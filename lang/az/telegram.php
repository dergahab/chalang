<?php

return [
    // Xətalar
    'error_unlinked' => '❌ <b>Xəta:</b> Hesab bağlı deyil.',
    'error_permission' => '❌ <b>Giriş rədd edildi:</b> Bu əməliyyat üçün icazəniz yoxdur.',
    'error_invalid_code' => '❌ <b>Xəta:</b> Yanlış kod.',
    'error_expired_code' => '❌ <b>Xəta:</b> Kodun vaxtı bitib. Zəhmət olmasa admin paneldən yeni kod yaradın.',
    'error_system' => '❌ <b>Xəta:</b> Sistemdə gözlənilməz xəta qeydə alındı.',
    'error_fallback' => '❓ <b>Başa düşmədim.</b> Lütfən menyudan istifadə edin.',
    
    // Uğur və Məlumat
    'success_linked' => '✅ <b>Uğurlu!</b> Hesabınız əlaqələndirildi.',
    'welcome_message' => "🚀 <b>Chalang Master Control Panelinə xoş gəlmisiniz!</b>\n\nSizin Chat ID: <code>:chat_id</code>\n\nİdarəetməyə başlamaq üçün aşağıdakı bölmələrdən birini seçin.",
    'help_message' => "<b>💎 Chalang Master Help:</b>\n\nMenyudan istifadə edərək sistemi idarə edin. Hər hansı problem olarsa, adminlə əlaqə saxlayın.",
    
    // Menyu Düymələri
    'btn_activity' => '📦 Aktivlik',
    'btn_insights' => '✨ İnsaytlar',
    'btn_settings' => '⚙️ Ayarlar',
    'btn_stats' => '📊 Statistika',
    'btn_server_status' => '🖥️ Server Status',
    'btn_latest_leads' => '📩 Son Müraciətlər',
    'btn_subscribers' => '👥 Abunəçilər',
    'btn_clear_cache' => '🧹 Keşi Təmizlə',
    'btn_maintenance' => '🛠️ Bakım Modu',
    'btn_home' => '🏠 Ana Menyu',
    'btn_refresh' => '🔄 Yenilə',
    'btn_details' => '➡️ Detallı Bax',
    'btn_yes' => '✅ Bəli, Əminəm',
    'btn_no' => '❌ Xeyr, Ləğv et',

    // Menyu başlıqları
    'menu_home_returned' => '🏠 Ana menyuya qayıtdınız.',
    'menu_activity_desc' => "📦 <b>Aktivlik Bölməsi:</b>\nCanlı statistika və server vəziyyətini buradan izləyin.",
    'menu_insights_desc' => "✨ <b>İnsaytlar Bölməsi:</b>\nMüraciətlər və abunəçi məlumatları üçün seçim edin.",
    'menu_settings_desc' => "⚙️ <b>Ayarlar Bölməsi:</b>\nSistem tənzimləmələri və təcili müdaxilə əmrləri.",

    // Məzmun - Aktivlik
    'stats_title' => '<b>📊 Bugünkü Statistika:</b>',
    'stats_visitors' => '👥 <b>Ziyarətçilər:</b>',
    'stats_leads' => '📩 <b>Müraciətlər:</b>',
    'stats_refreshed' => 'Statistika yeniləndi!',
    
    'server_title' => '<b>🖥️ Server Sağlamlığı:</b>',
    'server_disk' => '💾 <b>Disk:</b>',
    'server_php' => '🔋 <b>PHP:</b>',
    'server_load' => '🚀 <b>Yük (Status):</b>',
    'server_time' => '⏱️ <b>Zaman:</b>',
    'server_normal' => 'Normal',

    // Məzmun - İnsaytlar
    'leads_title' => '<b>📩 Son :count Müraciətlər:</b>',
    'leads_empty' => 'Hələ ki, müraciət yoxdur.',
    
    'subs_title' => '<b>👥 Aktiv Bot Abunəçiləri:</b>',
    'subs_unknown' => 'Naməlum',

    // Məzmun - Ayarlar
    'cache_warning' => "⚠️ <b>Diqqət!</b>\nSiz bütün sistemin keşini (cache) təmizləmək üzrəsiniz. Buna əminsinizmi?",
    'cache_processing' => "⏳ <b>Keş təmizlənir...</b> lütfən gözləyin.",
    'cache_success' => "✅ <b>Sistem keşi uğurla təmizləndi!</b>\n\n(Bu əməliyyat loglandı)",
    
    'maintenance_warning' => "⚠️ <b>Diqqət!</b>\nSiz sistemi <b>:status</b> rejiminə keçirmək üzrəsiniz. Buna əminsinizmi?",
    'maintenance_processing' => "⏳ <b>Sistem vəziyyəti dəyişdirilir...</b> lütfən gözləyin.",
    'maintenance_on' => "⚠️ <b>SİSTEM TƏMİR REJİMİNƏ KEÇİRİLDİ!</b>",
    'maintenance_off' => "✅ <b>SİSTEM AKTİVLƏŞDİRİLDİ!</b>",
    'maintenance_status_on' => 'AKTİV (ONLAYN)',
    'maintenance_status_off' => 'BAXIM (OFFLAYN)',

    // Ümumi
    'action_cancelled' => "❌ <b>Əməliyyat ləğv edildi.</b>",
    
    // Loglar
    'log_stats_checked' => 'Telegram bot vasitəsilə Gündəlik Statistika yoxlanıldı.',
    'log_server_checked' => 'Telegram bot vasitəsilə Server Vəziyyəti yoxlanıldı.',
    'log_leads_checked' => 'Telegram bot vasitəsilə Son Müraciətlər siyahısına baxıldı.',
    'log_cache_cleared' => 'Telegram bot vasitəsilə Keş təmizləndi.',
    'log_maintenance_on' => 'Telegram bot vasitəsilə Təmir (Maintenance) rejimi aktiv edildi.',
    'log_maintenance_off' => 'Telegram bot vasitəsilə Təmir rejimi söndürüldü.',
];
