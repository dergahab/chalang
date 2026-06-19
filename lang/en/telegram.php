<?php

return [
    // Errors
    'error_unlinked' => '❌ <b>Error:</b> Account is not linked.',
    'error_permission' => '❌ <b>Access Denied:</b> You do not have permission for this action.',
    'error_invalid_code' => '❌ <b>Error:</b> Invalid code.',
    'error_expired_code' => '❌ <b>Error:</b> The code has expired. Please generate a new code from the admin panel.',
    'error_system' => '❌ <b>Error:</b> An unexpected system error occurred.',
    'error_fallback' => '❓ <b>I didn\'t understand.</b> Please use the menu.',
    
    // Success & Info
    'success_linked' => '✅ <b>Success!</b> Your account has been linked.',
    'welcome_message' => "🚀 <b>Welcome to Chalang Master Control Panel!</b>\n\nYour Chat ID: <code>:chat_id</code>\n\nChoose an option below to start managing.",
    'help_message' => "<b>💎 Chalang Master Help:</b>\n\nUse the menu to control the system. If you face any issues, contact an administrator.",
    
    // Menu Buttons
    'btn_activity' => '📦 Activity',
    'btn_insights' => '✨ Insights',
    'btn_settings' => '⚙️ Settings',
    'btn_stats' => '📊 Statistics',
    'btn_server_status' => '🖥️ Server Status',
    'btn_latest_leads' => '📩 Latest Leads',
    'btn_subscribers' => '👥 Subscribers',
    'btn_clear_cache' => '🧹 Clear Cache',
    'btn_maintenance' => '🛠️ Maintenance Mode',
    'btn_home' => '🏠 Main Menu',
    'btn_refresh' => '🔄 Refresh',
    'btn_details' => '➡️ View Details',
    'btn_yes' => '✅ Yes, I am sure',
    'btn_no' => '❌ No, Cancel',

    // Menu Descriptions
    'menu_home_returned' => '🏠 Returned to main menu.',
    'menu_activity_desc' => "📦 <b>Activity Section:</b>\nMonitor live statistics and server status here.",
    'menu_insights_desc' => "✨ <b>Insights Section:</b>\nCheck latest leads and subscriber data.",
    'menu_settings_desc' => "⚙️ <b>Settings Section:</b>\nSystem configuration and emergency actions.",

    // Content - Activity
    'stats_title' => '<b>📊 Today\'s Statistics:</b>',
    'stats_visitors' => '👥 <b>Visitors:</b>',
    'stats_leads' => '📩 <b>Leads:</b>',
    'stats_refreshed' => 'Statistics refreshed!',
    
    'server_title' => '<b>🖥️ Server Health:</b>',
    'server_disk' => '💾 <b>Disk:</b>',
    'server_php' => '🔋 <b>PHP:</b>',
    'server_load' => '🚀 <b>Load (Status):</b>',
    'server_time' => '⏱️ <b>Time:</b>',
    'server_normal' => 'Normal',

    // Content - Insights
    'leads_title' => '<b>📩 Last :count Leads:</b>',
    'leads_empty' => 'No leads found yet.',
    
    'subs_title' => '<b>👥 Active Bot Subscribers:</b>',
    'subs_unknown' => 'Unknown',

    // Content - Settings
    'cache_warning' => "⚠️ <b>Warning!</b>\nYou are about to clear the entire system cache. Are you sure?",
    'cache_processing' => "⏳ <b>Clearing cache...</b> please wait.",
    'cache_success' => "✅ <b>System cache successfully cleared!</b>\n\n(This action has been logged)",
    
    'maintenance_warning' => "⚠️ <b>Warning!</b>\nYou are about to put the system in <b>:status</b> mode. Are you sure?",
    'maintenance_processing' => "⏳ <b>Changing system status...</b> please wait.",
    'maintenance_on' => "⚠️ <b>SYSTEM IS NOW IN MAINTENANCE MODE!</b>",
    'maintenance_off' => "✅ <b>SYSTEM IS NOW ACTIVE!</b>",
    'maintenance_status_on' => 'ACTIVE (ONLINE)',
    'maintenance_status_off' => 'MAINTENANCE (OFFLINE)',

    // General
    'action_cancelled' => "❌ <b>Action cancelled.</b>",
    
    // Logs
    'log_stats_checked' => 'Checked Daily Statistics via Telegram bot.',
    'log_server_checked' => 'Checked Server Status via Telegram bot.',
    'log_leads_checked' => 'Viewed Latest Leads via Telegram bot.',
    'log_cache_cleared' => 'Cleared System Cache via Telegram bot.',
    'log_maintenance_on' => 'Enabled Maintenance mode via Telegram bot.',
    'log_maintenance_off' => 'Disabled Maintenance mode via Telegram bot.',
];
