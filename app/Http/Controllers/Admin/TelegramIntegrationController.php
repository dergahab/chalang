<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TelegramSubscriber;
use App\Models\TelegramNotificationLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TelegramIntegrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:telegram.index');
    }

    public function index()
    {
        $subscribers = TelegramSubscriber::with('user')->get();
        
        $deliveryStats = [
            'total'   => TelegramNotificationLog::count(),
            'sent'    => TelegramNotificationLog::where('status', 'sent')->count(),
            'failed'  => TelegramNotificationLog::where('status', 'failed')->count(),
            'pending' => \Illuminate\Support\Facades\DB::table('jobs')->where('payload', 'like', '%ProcessTelegramNotification%')->count(),
        ];

        $recentLogs = TelegramNotificationLog::with('subscriber')
            ->latest()
            ->limit(15)
            ->get();

        return view('admin.pages.telegram.index', compact('subscribers', 'deliveryStats', 'recentLogs'));
    }

    public function generateCode(Request $request)
    {
        $user = auth()->user();
        
        // Remove old unused codes for this user
        TelegramSubscriber::where('user_id', $user->id)
            ->whereNull('chat_id')
            ->delete();

        $code = strtoupper(Str::random(6));
        
        TelegramSubscriber::create([
            'user_id' => $user->id,
            'verification_code' => $code,
            'verification_code_expires_at' => now()->addMinutes(5),
            'notification_settings' => [
                'contact_form' => true,
                'order_received' => true,
                'new_user' => false,
                'system_alerts' => true,
                'delayed_replies' => true,
                'stats_commands' => true,
                'server_commands' => true,
                'maintenance_commands' => true,
                'leads_commands' => true
            ]
        ]);

        return response()->json([
            'success' => true,
            'code' => $code,
            'bot_username' => config('nutgram.bot_username') ?? 'ChalangAI_bot'
        ]);
    }

    public function updateSettings(Request $request, $id)
    {
        $subscriber = TelegramSubscriber::findOrFail($id);
        
        $updateData = [];
        if ($request->has('is_active')) $updateData['is_active'] = $request->boolean('is_active');
        if ($request->has('is_silent')) $updateData['is_silent'] = $request->boolean('is_silent');
        if ($request->has('settings')) $updateData['notification_settings'] = $request->input('settings');
        
        $subscriber->update($updateData);

        return response()->json(['success' => true, 'message' => 'Tənzimləmələr yeniləndi.']);
    }

    public function destroy($id)
    {
        $subscriber = TelegramSubscriber::findOrFail($id);
        $subscriber->delete();
        
        return response()->json(['success' => true, 'message' => 'Bağlantı kəsildi.']);
    }

    public function syncCommands(\SergiX44\Nutgram\Nutgram $bot)
    {
        try {
            $bot->registerMyCommands();
            
            // Also clear relevant cache
            \Illuminate\Support\Facades\Cache::forget('telegram_health_status');
            \Illuminate\Support\Facades\Cache::forget('telegram_bot_info');
            
            return response()->json(['success' => true, 'message' => 'Bot komandaları sinxronlaşdırıldı və sistem keşi təmizləndi!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Xəta: ' . $e->getMessage()]);
        }
    }

    public function sendTestMessage(\SergiX44\Nutgram\Nutgram $bot, $id)
    {
        $subscriber = TelegramSubscriber::findOrFail($id);

        if (!$subscriber->chat_id) {
            return response()->json(['success' => false, 'message' => 'Bu abunəçinin chat_id-si yoxdur. Əvvəlcə botu qoşun.']);
        }

        try {
            $admin = auth()->user();
            $message = "✅ <b>Test Mesajı</b>\n\n"
                . "Admin paneli ilə Telegram bağlantınız <b>uğurla işləyir!</b>\n\n"
                . "👤 <b>Göndərən:</b> " . $admin->name . "\n"
                . "⏱️ <b>Vaxt:</b> " . now()->format('d.m.Y H:i:s');

            $bot->sendMessage(chat_id: $subscriber->chat_id, text: $message, parse_mode: 'HTML');

            activity()->causedBy($admin)->log("Test mesajı göndərildi → @{$subscriber->username}");

            \App\Models\TelegramNotificationLog::create([
                'subscriber_id' => $subscriber->id,
                'chat_id' => $subscriber->chat_id,
                'type' => 'test',
                'message_preview' => mb_substr(strip_tags($message), 0, 200),
                'status' => 'sent',
                'attempts' => 1,
                'sent_at' => now(),
            ]);

            return response()->json(['success' => true, 'message' => '@' . $subscriber->username . ' üçün test mesajı göndərildi!']);
        } catch (\Exception $e) {
            if (isset($subscriber)) {
                \App\Models\TelegramNotificationLog::create([
                    'subscriber_id' => $subscriber->id,
                    'chat_id' => $subscriber->chat_id,
                    'type' => 'test',
                    'message_preview' => 'Test Mesajı Uğursuz Oldu',
                    'status' => 'failed',
                    'attempts' => 1,
                    'error_message' => $e->getMessage(),
                ]);
            }
            return response()->json(['success' => false, 'message' => 'Xəta: ' . $e->getMessage()]);
        }
    }

    public function clearCache()
    {
        try {
            // Enterprise Fix: Don't use Artisan optimize:clear via HTTP in production.
            // Only clear the caches that affect Telegram functionality directly.
            \Illuminate\Support\Facades\Cache::forget('telegram_health_status');
            \Illuminate\Support\Facades\Cache::forget('telegram_bot_info');
            \Illuminate\Support\Facades\Cache::forget('telegram_subscribers_active');
            
            return response()->json(['success' => true, 'message' => 'Telegram sistemi keşi təmizləndi!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Xəta: ' . $e->getMessage()]);
        }
    }

    public function broadcast(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'image_url' => 'nullable|url'
        ]);

        $message = $request->input('message');
        $imageUrl = $request->input('image_url');
        $admin = auth()->user();

        // Aktiv olan bütün istifadəçilərə kütləvi mesaj (broadcast) at
        $subscribers = TelegramSubscriber::where('is_active', true)->whereNotNull('chat_id')->get();
        $count = $subscribers->count();

        if ($count === 0) {
            return response()->json(['success' => false, 'message' => 'Aktiv abunəçi tapılmadı.']);
        }

        foreach ($subscribers as $sub) {
            $options = ['parse_mode' => 'HTML'];
            if ($imageUrl) {
                $options['photo'] = $imageUrl;
            }
            
            \App\Jobs\ProcessTelegramNotification::dispatch((string)$sub->chat_id, $message, $options, 'broadcast');
        }

        activity()->causedBy($admin)->log("Kütləvi Telegram mesajı gönderildi. (Abunəçi sayısı: {$count})");

        return response()->json([
            'success' => true, 
            'message' => "Mesaj {$count} aktiv abunəçiyə göndərilmək üçün növbəyə alındı!"
        ]);
    }

    public function getLogs()
    {
        try {
            $logFile = storage_path('logs/laravel.log');
            if (!file_exists($logFile)) {
                return response()->json(['success' => true, 'logs' => 'Loq faylı hələ yaradılmayıb.']);
            }

            // Enterprise Fix: Filter logs securely
            $data = file($logFile);
            $filteredLines = array_filter($data, function($line) {
                return stripos($line, 'Telegram') !== false || stripos($line, 'Nutgram') !== false;
            });
            
            $lines = array_slice($filteredLines, -50);
            $logs = implode("", $lines);

            if (empty($logs)) {
                $logs = "Teleqrama aid xəbərdarlıq və ya loq tapılmadı.";
            }

            return response()->json(['success' => true, 'logs' => $logs]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
