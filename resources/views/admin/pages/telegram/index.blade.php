@extends('admin.layouts.main')

@section('heading_title', 'Teleqram Komanda Mərkəzi')

@section('custom_buttons')
    <div class="d-flex align-items-center gap-3">
        <a href="https://t.me/{{ env('TELEGRAM_BOT_USERNAME', 'ChalangAI_bot') }}" target="_blank" class="btn btn-sm rounded-pill px-4 fw-bold d-flex align-items-center premium-btn-outline" style="border: 1px solid rgba(0, 242, 254, 0.4); color: #00f2fe; background: rgba(0, 242, 254, 0.05);">
            <i class="ri-telegram-fill me-2 fs-16 text-info"></i> BOTU AÇ
        </a>
        <button type="button" class="btn btn-vision-primary btn-sm rounded-pill px-4 fw-bold shadow-lg d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#pairBotModal">
            <i class="ri-links-line me-2 fs-16"></i> YENİ BAĞLANTI QUR
        </button>
    </div>
@endsection


@section('content')
<style>
    /* VISION CORE v3 - RESILIENT PREMIUM STYLES */
    :root {
        --brand-primary: #4b0082;
        --brand-secondary: #d500f9;
        --brand-cyan: #00f2fe;
        --card-bg: rgba(17, 24, 39, 0.8);
        --text-muted: #94a3b8;
    }

    .glass-card-resilient {
        background: var(--card-bg) !important;
        backdrop-filter: blur(15px) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 20px !important;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3) !important;
    }

    /* THE ACTION GRID THAT WORKS */
    .vision-action-grid {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 12px !important;
    }

    .vision-control-card {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 16px !important;
        padding: 16px !important;
        text-align: left !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        text-decoration: none !important;
        color: #fff !important;
        position: relative;
        overflow: hidden;
    }

    .vision-control-card:hover {
        background: rgba(255, 255, 255, 0.07) !important;
        border-color: var(--brand-secondary) !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 10px 20px rgba(213, 0, 249, 0.15) !important;
    }

    .vision-control-card i {
        font-size: 24px !important;
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        transition: transform 0.3s ease;
    }

    .vision-control-card:hover i {
        transform: scale(1.1);
    }

    .vision-control-card .label {
        font-size: 13px !important;
        font-weight: 700 !important;
        letter-spacing: 0.3px !important;
        display: block !important;
    }

    .vision-control-card .desc {
        font-size: 10px !important;
        color: var(--text-muted) !important;
        display: block !important;
    }

    .vision-control-card-wide {
        grid-column: span 2 !important;
        background: linear-gradient(90deg, rgba(75, 0, 130, 0.15), rgba(213, 0, 249, 0.15)) !important;
    }

    /* STATUS PULSE */
    .status-pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
        box-shadow: 0 0 10px currentColor;
        animation: vision-pulse 2s infinite;
    }

    @keyframes vision-pulse {
        0% { transform: scale(0.95); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(0.95); opacity: 0.5; }
    }

    /* TABLE POLISH */
    .table-premium-v3 {
        color: #fff !important;
    }
    .table-premium-v3 thead th {
        color: var(--text-muted) !important;
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        border-bottom: 1px solid rgba(255,255,255,0.05) !important;
        padding: 15px !important;
    }

    /* PREMIUM MODAL SYSTEM */
    .modal-content {
        background: rgba(11, 15, 25, 0.9) !important;
        backdrop-filter: blur(25px) !important;
        border: 1px solid rgba(213, 0, 249, 0.15) !important;
        border-radius: 28px !important;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.6) !important;
    }

    .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        padding: 24px 30px !important;
    }

    .modal-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
        padding: 20px 30px !important;
    }

    .modal-backdrop.show {
        backdrop-filter: blur(10px) !important;
        background-color: rgba(0, 0, 0, 0.8) !important;
    }

    /* LOG VIEWER - TERMINAL STYLE */
    .log-container {
        background: rgba(0, 0, 0, 0.3) !important;
        border: 1px solid rgba(213, 0, 249, 0.1) !important;
        border-radius: 16px !important;
        padding: 20px !important;
        font-family: 'Consolas', 'Monaco', monospace !important;
        max-height: 550px;
        overflow-y: auto;
        font-size: 12px !important;
        line-height: 1.8 !important;
        color: #cbd5e1 !important;
    }

    .log-line-error { color: #ff4d4d !important; background: rgba(255, 77, 77, 0.05); padding: 2px 4px; border-radius: 4px; }
    .log-line-info { color: var(--brand-cyan) !important; }
    .log-line-warning { color: #fbbf24 !important; }

    /* PERMISSION CARDS IN SETTINGS */
    .permission-card {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        border-radius: 16px !important;
        padding: 16px !important;
        margin-bottom: 12px !important;
        display: flex !important;
        align-items: center !important;
        transition: all 0.3s ease !important;
    }

    .permission-card:hover {
        background: rgba(255, 255, 255, 0.06) !important;
        border-color: rgba(213, 0, 249, 0.25) !important;
    }

    .permission-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 20px;
    }

    /* CUSTOM INPUTS */
    .modal-body .form-control {
        background: rgba(255, 255, 255, 0.04) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 12px !important;
        color: #fff !important;
        padding: 12px 15px !important;
    }

    .modal-body .form-control:focus {
        border-color: var(--brand-secondary) !important;
        background: rgba(255, 255, 255, 0.07) !important;
        box-shadow: 0 0 15px rgba(213, 0, 249, 0.1) !important;
    }

    /* PREMIUM BUTTONS */
    .btn-vision-primary {
        background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary)) !important;
        border: none !important;
        color: #fff !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: relative;
        overflow: hidden;
    }
    .btn-vision-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(213, 0, 249, 0.35) !important;
        color: #fff !important;
    }
    .premium-btn-outline {
        transition: all 0.3s ease !important;
    }
    .premium-btn-outline:hover {
        background: rgba(0, 242, 254, 0.15) !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 242, 254, 0.2);
    }
    .action-btn-hover {
        transition: all 0.3s ease !important;
    }
    .action-btn-hover:hover {
        transform: scale(1.15) translateY(-2px);
    }
</style>

<script>
    /* VISION CORE v3 - RESILIENT CORE FUNCTIONS */
    window.testBotConnection = function(card) {
        const icon = card?.querySelector('i');
        if(icon) icon.className = 'ri-loader-4-line ri-spin';
        if(typeof toastr !== 'undefined') toastr.info('Bağlantı yoxlanılır...');
        
        fetch('{{ route("admin.telegram.health") }}')
            .then(r => r.json())
            .then(data => {
                if (data.success && data.api_status === 'online') {
                    toastr?.success(`Telegram API: Stabil ✅ (${data.response_time_ms}ms)`);
                } else {
                    toastr?.error(`Telegram API: İşləmir ❌`);
                }
            })
            .catch(() => toastr?.error('Bağlantı xətası'))
            .finally(() => { if(icon) icon.className = 'ri-pulse-line'; });
    };

    window.syncBotCommands = function(card) {
        const icon = card?.querySelector('i');
        if(icon) icon.className = 'ri-loader-4-line ri-spin';
        if(typeof toastr !== 'undefined') toastr.info('Sinxronizasiya edilir...');
        
        fetch('{{ route("admin.telegram.sync-commands") }}', { 
            method: 'POST', 
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(d => {
            if(typeof toastr !== 'undefined') toastr[d.success ? 'success' : 'error'](d.message); else alert(d.message);
        })
        .finally(() => { if(icon) icon.className = 'ri-refresh-line'; });
    };

    window.clearBotCache = function(card) {
        if (!confirm('Sistem keşi təmizlənsin?')) return;
        const icon = card?.querySelector('i');
        if(icon) icon.className = 'ri-loader-4-line ri-spin';
        
        fetch('{{ route("admin.telegram.clear-cache") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(d => {
            if(typeof toastr !== 'undefined') toastr[d.success ? 'success' : 'error'](d.message); else alert(d.message);
        })
        .finally(() => { if(icon) icon.className = 'ri-eraser-line'; });
    };

    window.openLogViewer = function() {
        const modalEl = document.getElementById('logViewerModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
            fetchLogs();
        }
    };

    window.fetchLogs = function() {
        const container = document.getElementById('logContent');
        if(!container) return;
        container.innerHTML = '<div class="text-center py-5"><i class="ri-loader-4-line ri-spin fs-24 mb-2 text-primary"></i><p class="text-muted">Məlumatlar sinxronizasiya olunur...</p></div>';

        fetch('{{ route("admin.telegram.logs") }}')
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const lines = data.logs.split("\n").filter(l => l.trim() !== "");
                    let html = '';
                    lines.forEach(line => {
                        let cls = '';
                        if (line.includes('.ERROR') || line.includes('.CRITICAL')) cls = 'log-line-error';
                        else if (line.includes('.INFO')) cls = 'log-line-info';
                        else if (line.includes('.WARNING')) cls = 'log-line-warning';
                        html += `<div class="${cls}" style="padding: 4px 15px; border-bottom: 1px solid rgba(255,255,255,0.02);">${line}</div>`;
                    });
                    container.innerHTML = html || '<div class="text-center text-muted py-4">Loq faylı boşdur.</div>';
                    setTimeout(() => container.scrollTop = container.scrollHeight, 100);
                }
            }).catch(() => {
                container.innerHTML = '<div class="text-center text-danger py-4">Loqları yükləmək mümkün olmadı.</div>';
            });
    };

    window.fetchTelegramHealth = function() {
        fetch('{{ route("admin.telegram.health") }}')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const pulse = document.getElementById('api-status-pulse');
                    const text = document.getElementById('api-status-text');
                    const ping = document.getElementById('api-response-time');
                    if(pulse) pulse.style.background = data.api_status === 'online' ? '#00f2fe' : '#ff4d4d';
                    if(text) text.innerText = data.api_status === 'online' ? 'SİSTEM AKTİVDİR' : 'API BAĞLANTISI YOXDUR';
                    if(ping) ping.innerText = data.response_time_ms + ' ms';
                    
                    // Update Queue Worker metrics
                    if(data.queue) {
                        const queueText = document.getElementById('queue-status-text');
                        const queuePending = document.getElementById('queue-pending');
                        const queueFailed = document.getElementById('queue-failed');
                        
                        if(queueText) queueText.innerText = data.queue.connection === 'database' ? 'DB Driver Aktivi' : (data.queue.connection === 'sync' ? 'Sinxron (Gözlədilmir)' : data.queue.connection);
                        if(queuePending) queuePending.innerText = data.queue.pending_jobs;
                        if(queueFailed) queueFailed.innerText = data.queue.failed_jobs;
                    }
                }
            });
    };

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        fetchTelegramHealth();
        setInterval(fetchTelegramHealth, 15000); // 15 sec update for more fluid UI
        
        // Pairing Code Generation
        const generateBtn = document.getElementById('generateCodeBtn');
        if (generateBtn) {
            let countdownInterval;
            
            generateBtn.addEventListener('click', function() {
                const btn = this;
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="ri-loader-4-line ri-spin me-2"></i> YARADILIR...';
                btn.disabled = true;
                
                fetch('{{ route("admin.telegram.generate-code") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Display the code
                        document.getElementById('displayPairingCode').innerText = data.code;
                        
                        // Set the Bot Link
                        const botLink = document.getElementById('botLink');
                        const botUrl = `https://t.me/${data.bot_username}?start=${data.code}`;
                        botLink.innerText = `@${data.bot_username}`;
                        botLink.href = botUrl;
                        
                        // Generate QR Code dynamically
                        const qrImg = document.getElementById('pairingQrCode');
                        qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(botUrl)}&color=4b0082`;
                        
                        // Toggle Visibility
                        btn.style.display = 'none';
                        document.getElementById('pairingCodeArea').classList.remove('d-none');
                        
                        // Start 5 min countdown
                        clearInterval(countdownInterval);
                        let timeLeft = 300; // 5 minutes in seconds
                        const countdownEl = document.getElementById('codeCountdown');
                        
                        countdownInterval = setInterval(() => {
                            timeLeft--;
                            const m = Math.floor(timeLeft / 60).toString().padStart(2, '0');
                            const s = (timeLeft % 60).toString().padStart(2, '0');
                            countdownEl.innerText = `${m}:${s}`;
                            
                            if (timeLeft <= 0) {
                                clearInterval(countdownInterval);
                                document.getElementById('pairingCodeArea').classList.add('d-none');
                                btn.style.display = 'block';
                                btn.innerHTML = '<i class="ri-qr-code-line me-2"></i> KODU YENİDƏN YARAT';
                                btn.disabled = false;
                            }
                        }, 1000);
                        
                    } else {
                        if(typeof toastr !== 'undefined') toastr.error('Xəta baş verdi'); else alert('Xəta baş verdi');
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                    }
                })
                .catch(error => {
                    if(typeof toastr !== 'undefined') toastr.error('Server xətası'); else alert('Server xətası');
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                });
            });
        }

        // Action Center Bindings
        document.getElementById('btn-health-check')?.addEventListener('click', function() { testBotConnection(this); });
        document.getElementById('btn-sync-commands')?.addEventListener('click', function() { syncBotCommands(this); });
        document.getElementById('btn-clear-cache')?.addEventListener('click', function() { clearBotCache(this); });
        document.getElementById('btn-open-logs')?.addEventListener('click', function() { openLogViewer(); });
        document.getElementById('btn-open-broadcast')?.addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('broadcastModal')).show();
        });

        // Broadcast Handler
        document.getElementById('sendBroadcastBtn')?.addEventListener('click', function() {
            const btn = this;
            const message = document.getElementById('broadcastMessage').value;
            const imageUrl = document.getElementById('broadcastImageUrl').value;
            
            if(!message.trim()) {
                if(typeof toastr !== 'undefined') toastr.error('Mesaj daxil edilməlidir.'); else alert('Mesaj daxil edilməlidir.');
                return;
            }
            
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="ri-loader-4-line ri-spin me-2"></i> GÖNDƏRİLİR...';
            btn.disabled = true;
            
            fetch('{{ route("admin.telegram.broadcast") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message, image_url: imageUrl })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    if(typeof toastr !== 'undefined') toastr.success(data.message); else alert(data.message);
                    document.getElementById('broadcastForm').reset();
                    bootstrap.Modal.getInstance(document.getElementById('broadcastModal')).hide();
                } else {
                    if(typeof toastr !== 'undefined') toastr.error(data.message); else alert(data.message);
                }
            })
            .catch(err => {
                if(typeof toastr !== 'undefined') toastr.error('Xəta baş verdi.'); else alert('Xəta baş verdi.');
            })
            .finally(() => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            });
        });

        // Search Filter
        const searchInput = document.querySelector('input[placeholder="Axtarış..."]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                document.querySelectorAll('.table-premium-v3 tbody tr').forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(query) ? '' : 'none';
                });
            });
        }
    });

    const settingsList = [
        { key: 'contact_form', label: '📩 Kontakt formları', desc: 'Yeni sayt müraciətləri', icon: 'ri-mail-send-line', color: '#00f2fe' },
        { key: 'order_received', label: '🛒 Yeni sifarişlər', desc: 'Xidmət və ya məhsul alışları', icon: 'ri-shopping-cart-2-line', color: '#ff9f43' },
        { key: 'new_user', label: '👤 Yeni qeydiyyatlar', desc: 'Sistemə yeni istifadəçi qeydiyyatı', icon: 'ri-user-add-line', color: '#28c76f' },
        { key: 'system_alerts', label: '⚠️ Sistem xəbərdarlıqları', desc: 'Server xətaları və təhlükəsizlik', icon: 'ri-error-warning-line', color: '#ea5455' },
        { key: 'leads_commands', label: '⚡ Lead İdarəetməsi', desc: 'Müraciətlərin bot üzərindən emalı', icon: 'ri-flashlight-line', color: '#f8d210' },
        { key: 'stats_commands', label: '📊 Statistika', desc: 'Statistik məlumatlara giriş icazəsi', icon: 'ri-bar-chart-box-line', color: '#32ccbc' },
        { key: 'server_commands', label: '🖥️ Server Komandaları', desc: 'Bot vasitəsilə server idarəetməsi', icon: 'ri-terminal-window-line', color: '#a29bfe' },
        { key: 'maintenance_commands', label: '🛠️ Texniki Qulluq', desc: 'Sistem təmizləmə və servis əmrləri', icon: 'ri-tools-line', color: '#fd79a8' },
        { key: 'delayed_replies', label: '⏳ Gecikmiş Cavablar', desc: 'Müştəri mesajlarına gecikmiş reaksiyalar', icon: 'ri-time-line', color: '#55efc4' }
    ];

    window.openSettings = function(id, settings) {
        const container = document.getElementById('settingsContainer');
        document.getElementById('editSubId').value = id;
        container.innerHTML = '';
        settingsList.forEach(s => {
            const checked = settings[s.key] ? 'checked' : '';
            container.innerHTML += `
                <div class="permission-card">
                    <div class="permission-icon" style="background: rgba(${parseInt(s.color.slice(1,3),16)}, ${parseInt(s.color.slice(3,5),16)}, ${parseInt(s.color.slice(5,7),16)}, 0.1); color:${s.color}">
                        <i class="${s.icon}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-white fw-bold fs-13 mb-0">${s.label}</div>
                        <div class="text-muted fs-11">${s.desc}</div>
                    </div>
                    <div class="form-check form-switch custom-switch-secondary">
                        <input class="form-check-input setting-toggle" type="checkbox" data-key="${s.key}" ${checked}>
                    </div>
                </div>`;
        });
        const modal = new bootstrap.Modal(document.getElementById('settingsModal'));
        modal.show();
    };

    window.saveSettings = function() {
        const id = document.getElementById('editSubId').value;
        const settings = {};
        document.querySelectorAll('.setting-toggle').forEach(t => settings[t.dataset.key] = t.checked);
        fetch(`/admin/telegram-integration/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ settings: settings })
        }).then(r => r.json()).then(d => d.success && location.reload());
    };

    window.toggleActive = function(id, val, el) {
        fetch(`/admin/telegram-integration/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ is_active: val })
        }).then(r => r.json()).then(d => { 
            if(d.success) {
                if(typeof toastr !== 'undefined') toastr.success('Aktivlik yeniləndi'); 
            } else {
                if(typeof toastr !== 'undefined') toastr.error(d.message || 'Xəta baş verdi');
                if(el) el.checked = !val;
            }
        }).catch(e => {
            if(typeof toastr !== 'undefined') toastr.error('Sistem xətası');
            if(el) el.checked = !val;
        });
    };

    window.toggleSilent = function(id, val, el) {
        fetch(`/admin/telegram-integration/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ is_silent: val })
        }).then(r => r.json()).then(d => { 
            if(d.success) {
                if(typeof toastr !== 'undefined') toastr.success('Səssiz rejim yeniləndi'); 
            } else {
                if(typeof toastr !== 'undefined') toastr.error(d.message || 'Xəta baş verdi');
                if(el) el.checked = !val;
            }
        }).catch(e => {
            if(typeof toastr !== 'undefined') toastr.error('Sistem xətası');
            if(el) el.checked = !val;
        });
    };

    window.testMessage = function(id, btn) {
        const original = btn.innerHTML;
        btn.innerHTML = '<i class="ri-loader-4-line ri-spin"></i>';
        fetch(`/admin/telegram-integration/${id}/test-message`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(r => r.json()).then(d => {
            alert(d.message);
            btn.innerHTML = original;
        });
    };

    window.disconnect = function(id) {
        if (!confirm('Bağlantı kəsilsin?')) return;
        fetch(`/admin/telegram-integration/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(r => r.json()).then(d => d.success && location.reload());
    };
</script>


<div class="row g-4 mb-5">
    <!-- Health Status -->
    <div class="col-xl-4">
        <div class="card glass-card h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar-md bg-soft-info rounded-3 d-flex align-items-center justify-content-center shadow-lg" style="width: 54px; height: 54px; background: rgba(0, 242, 254, 0.1); border: 1px solid rgba(0, 242, 254, 0.2);">
                        <i class="ri-robot-3-line text-info fs-26"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted fw-bold text-uppercase fs-10 mb-1" style="letter-spacing: 1px;">Telegram API Statusu</h6>
                        <div class="d-flex align-items-center">
                            <span class="pulse-indicator me-2" id="api-status-pulse" style="background: #ff9f43;"></span>
                            <h4 class="text-white mb-0 fs-20 fw-black" id="api-status-text">YOXLANILIR</h4>
                        </div>
                    </div>
                </div>
                <div class="pt-3 border-top" style="border-color: rgba(255,255,255,0.08) !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted fs-11">Gecikmə (Ping): <span class="text-white fw-black ms-1" id="api-response-time">-- ms</span></span>
                        <span class="badge bg-dark text-info border border-info border-opacity-25 px-2 py-1 fs-10" id="bot-runtime-mode">POLLING</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Queue & Background Jobs -->
    <div class="col-xl-4">
        <div class="card glass-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar-md bg-soft-purple rounded-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(213, 0, 249, 0.1);">
                        <i class="ri-database-2-line text-primary fs-24"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted fw-bold text-uppercase fs-11 mb-1">Queue Worker (Növbə)</h6>
                        <h4 class="text-white mb-0 fs-18" id="queue-status-text">Yoxlanılır...</h4>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-3 mb-2">
                    <span class="text-muted fs-11">Gözləyən Bildiriş (Pending)</span>
                    <span class="text-info fw-bold fs-12" id="queue-pending">--</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted fs-11">Uğursuz Göndəriş (Failed)</span>
                    <span class="text-danger fw-bold fs-12" id="queue-failed">--</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Center (ULTRA-MODERN v2) -->
    <div class="col-xl-4">
        <div class="card glass-card h-100" style="border-color: rgba(213, 0, 249, 0.15) !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="text-muted fw-bold text-uppercase fs-10 mb-0" style="letter-spacing: 1.5px;">Hərəkətlər Mərkəzi</h6>
                    <div class="d-flex gap-1">
                        <span class="pulse-indicator" style="background: var(--brand-secondary); width: 6px; height: 6px;"></span>
                        <span class="text-primary fs-10 fw-black">LIVE</span>
                    </div>
                </div>
                
                <div class="vision-action-grid">
                    <div class="vision-control-card" id="btn-health-check">
                        <i class="ri-pulse-line"></i>
                        <div>
                            <span class="label">Bağlantı</span>
                            <span class="desc">API statusunu yoxla</span>
                        </div>
                    </div>
                    <div class="vision-control-card" id="btn-sync-commands">
                        <i class="ri-refresh-line"></i>
                        <div>
                            <span class="label">Sinxron et</span>
                            <span class="desc">Komandaları yenilə</span>
                        </div>
                    </div>
                    <div class="vision-control-card" id="btn-open-logs">
                        <i class="ri-terminal-box-line"></i>
                        <div>
                            <span class="label">Loqlar</span>
                            <span class="desc">Sistem qeydləri</span>
                        </div>
                    </div>
                    <div class="vision-control-card" id="btn-clear-cache">
                        <i class="ri-eraser-line"></i>
                        <div>
                            <span class="label">Keşi Təmizlə</span>
                            <span class="desc">Məlumatları sıfırla</span>
                        </div>
                    </div>
                    <div class="vision-control-card vision-control-card-wide" id="btn-open-broadcast">
                        <i class="ri-broadcast-line"></i>
                        <div>
                            <span class="label">Kütləvi Mesaj Göndər</span>
                            <span class="desc">Bütün aktiv abunəçilərə bildiriş göndərişi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DATA TABLE -->
<div class="row">
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header border-bottom border-dashed d-flex align-items-center py-4">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="ri-shield-user-line text-primary fs-20"></i>
                        </div>
                        <div>
                            <h5 class="text-white mb-0 fs-18 fw-black">Admin İdarəetməsi</h5>
                            <p class="text-muted mb-0 fs-12">Bütün aktiv abunəçilər və giriş səviyyələri</p>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0 d-flex gap-3">
                    <div class="search-box">
                        <input type="text" class="form-control bg-white bg-opacity-5 border-white border-opacity-10 rounded-pill px-4 text-white" placeholder="Axtarış..." style="width: 280px; font-size: 13px;">
                        <i class="ri-search-line search-icon text-muted"></i>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-premium-v3 align-middle table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>ADMİN / ROL</th>
                                <th>TELEGRAM USER</th>
                                <th>STATUS</th>
                                <th>BİLDİRİŞ REJİMİ</th>
                                <th class="text-end">İDARƏETMƏ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscribers as $sub)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs bg-soft-primary rounded-pill d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px; background: rgba(213, 0, 249, 0.1);">
                                            <span class="text-primary fw-bold fs-16">{{ strtoupper(substr($sub->user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="text-white fw-bold mb-0 fs-14">{{ $sub->user->full_name }}</h6>
                                            @php
                                                $role = $sub->user->getRoleNames()->first();
                                                $roleName = $role == 'super-admin' ? 'Baş Admin' : ($role == 'admin' ? 'Administrator' : $role);
                                            @endphp
                                            <small class="text-muted fs-11">{{ $roleName }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center text-info">
                                        <i class="ri-telegram-fill me-2 fs-18"></i>
                                        <code style="background: transparent; color: #00f2fe;">{{ $sub->username ?? 'Naməlum' }}</code>
                                    </div>
                                </td>
                                <td>
                                    @if($sub->chat_id)
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 border-0">
                                            <i class="ri-checkbox-circle-fill me-1"></i> QOŞULUB
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2 border-0">GÖZLƏNİLİR</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-4">
                                        <div class="form-check form-switch custom-switch-primary">
                                            <input class="form-check-input" type="checkbox" onclick="toggleActive({{ $sub->id }}, this.checked, this)" {{ $sub->is_active ? 'checked' : '' }}>
                                            <label class="ms-1 fs-12 text-muted">Aktiv</label>
                                        </div>
                                        <div class="form-check form-switch custom-switch-secondary">
                                            <input class="form-check-input" type="checkbox" onclick="toggleSilent({{ $sub->id }}, this.checked, this)" {{ $sub->is_silent ? 'checked' : '' }}>
                                            <label class="ms-1 fs-12 text-muted">Səssiz</label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-soft-success btn-icon btn-sm rounded-pill action-btn-hover shadow-sm" onclick="testMessage({{ $sub->id }}, this)" data-bs-toggle="tooltip" title="Test mesaj göndər">
                                        <i class="ri-send-plane-line"></i>
                                    </button>
                                    <button class="btn btn-soft-info btn-icon btn-sm rounded-pill action-btn-hover shadow-sm ms-1" onclick="openSettings({{ $sub->id }}, {{ json_encode($sub->notification_settings) }})" data-bs-toggle="tooltip" title="Ayarlar">
                                        <i class="ri-settings-4-line"></i>
                                    </button>
                                    <button class="btn btn-soft-danger btn-icon btn-sm rounded-pill action-btn-hover shadow-sm ms-1" onclick="disconnect({{ $sub->id }})" data-bs-toggle="tooltip" title="Kənarlaşdır">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="opacity-20 text-white">
                                        <i class="ri-telegram-line fs-48 mb-2 d-block"></i>
                                        <p>Məlumat tapılmadı</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODALS (PREMIUM DARK) -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center">
                    <div class="bg-soft-primary p-2 rounded-3 me-3" style="background: rgba(213, 0, 249, 0.1);">
                        <i class="ri-shield-keyhole-line text-primary fs-20"></i>
                    </div>
                    <span>İCAZƏLƏR VƏ BİLDİRİŞLƏR</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 scrollbar-hide" style="max-height: 65vh; overflow-y: auto;">
                <form id="settingsForm">
                    <input type="hidden" id="editSubId">
                    <div id="settingsContainer">
                        <!-- Apple Style Settings will be injected here via JS -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soft-light rounded-pill px-4 me-2" data-bs-dismiss="modal">İMTİNA</button>
                <button type="button" class="btn btn-vision-primary rounded-pill px-5" id="saveSettingsBtn" onclick="saveSettings()">YADDA SAXLA</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white d-flex align-items-center">
                    <i class="ri-terminal-box-line me-3 text-primary fs-24"></i>
                    <div>
                        <span class="d-block fw-bold">SİSTEM LOQLARI</span>
                        <small class="text-muted fs-10 text-uppercase tracking-wider">Laravel Real-time Monitoring</small>
                    </div>
                </h5>
                <div class="ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-soft-info btn-icon rounded-pill" onclick="fetchLogs()" title="Yenilə">
                        <i class="ri-refresh-line"></i>
                    </button>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body p-4">
                <div class="log-container scrollbar-hide" id="logContent">
                    <div class="text-center py-5">
                        <i class="ri-loader-4-line ri-spin fs-24 mb-2 text-primary"></i>
                        <p class="text-muted">Məlumatlar emal olunur...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pairBotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-5 text-center">
                <div class="avatar-xl mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle shadow-lg" 
                     style="width: 120px; height: 120px; background: radial-gradient(circle, rgba(213,0,249,0.15) 0%, rgba(213,0,249,0) 70%); border: 1px solid rgba(213,0,249,0.1);">
                    <i class="ri-telegram-fill text-primary fs-64"></i>
                </div>
                <h4 class="text-white fw-black mb-2 fs-24">BOTU QOŞ</h4>
                <p class="text-muted mb-4 fs-13">Təhlükəsiz bağlantı üçün birdəfəlik kod yaradın.</p>
                
                <div id="pairingCodeArea" class="d-none">
                    <div class="bg-black bg-opacity-40 p-4 rounded-4 mb-4 border border-primary border-opacity-20 shadow-inner">
                        <h2 class="mb-0 fw-black text-primary fs-40" id="displayPairingCode" style="letter-spacing: 12px; text-shadow: 0 0 20px rgba(213, 0, 249, 0.4);">------</h2>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-4">
                        <div class="status-pulse-dot" style="background: #fbbf24;"></div>
                        <span class="text-warning fs-13 fw-bold" id="codeCountdown">05:00</span>
                        <span class="text-muted fs-12 ms-1">sonra kod keçərsizdir</span>
                    </div>

                    <div class="mb-4 d-flex justify-content-center">
                        <div style="background:#fff; padding:12px; border-radius:16px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                            <img id="pairingQrCode" src="" alt="QR Kod" width="140" height="140">
                        </div>
                    </div>
                    
                    <div class="alert bg-soft-info border-0 text-start text-info fs-12 mb-0 rounded-4">
                        <div class="d-flex">
                            <i class="ri-information-line fs-18 me-2"></i>
                            <div>
                                Teleqramda <a href="#" id="botLink" target="_blank" class="fw-bold text-info text-decoration-underline">@{{ env('TELEGRAM_BOT_USERNAME', 'ChalangAI_bot') }}</a> açın və bu kodu göndərin.
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="generateCodeBtn" class="btn btn-vision-primary w-100 py-3 mt-2 rounded-pill fs-16 fw-bold">
                    <i class="ri-qr-code-line me-2"></i> KOD YARAT
                </button>
            </div>
        </div>
    </div>
</div>

{{-- BROADCAST MODAL --}}
<div class="modal fade" id="broadcastModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title text-white d-flex align-items-center">
                    <div class="bg-soft-primary p-2 rounded-3 me-3" style="background: rgba(0, 242, 254, 0.1);">
                        <i class="ri-broadcast-line text-info fs-20"></i>
                    </div>
                    <span>KÜTLƏVİ MESAJ (BROADCAST)</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert bg-soft-primary border-0 text-white fs-12 mb-4 rounded-4" style="background: rgba(255,255,255,0.03);">
                    <div class="d-flex align-items-center">
                        <i class="ri-group-line fs-24 me-3 text-primary"></i>
                        <div>
                            Bu mesaj bütün aktiv abunəçilərə <b>({{ $subscribers->where('is_active', true)->count() }} nəfər)</b> göndəriləcək.
                            <small class="d-block text-muted mt-1">Gecikmə qarşısını almaq üçün növbə (queue) sistemindən istifadə olunur.</small>
                        </div>
                    </div>
                </div>
                <form id="broadcastForm">
                    <div class="mb-4">
                        <label class="form-label text-muted fs-11 fw-bold text-uppercase">Mesaj Mətni (HTML dəstəklənir)</label>
                        <textarea class="form-control" id="broadcastMessage" rows="6" placeholder="<b>Diqqət!</b> Sistem yenilənməsi..."></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label text-muted fs-11 fw-bold text-uppercase">Şəkil URL (İstəyə bağlı)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 border-white border-opacity-10 text-muted">
                                <i class="ri-image-line"></i>
                            </span>
                            <input type="url" class="form-control border-start-0" id="broadcastImageUrl" placeholder="https://example.com/banner.jpg">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soft-light rounded-pill px-4" data-bs-dismiss="modal">LƏĞV ET</button>
                <button type="button" class="btn btn-vision-primary rounded-pill px-5" id="sendBroadcastBtn">
                    <i class="ri-send-plane-fill me-2"></i> GÖNDƏR
                </button>
            </div>
        </div>
    </div>
</div>

{{-- DELIVERY TRACKING --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-white mb-1 fs-18 fw-bold">
                        <i class="ri-send-plane-2-line me-2 text-primary"></i>Bildiriş Göndəriş Tarixçəsi
                    </h5>
                    <p class="text-muted mb-0 fs-12">Son 15 göndəriş — Gerçək delivery statusu</p>
                </div>
                <div class="d-flex gap-3 align-items-center">
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                        <i class="ri-checkbox-circle-line me-1"></i> Göndərildi: {{ $deliveryStats['sent'] }}
                    </span>
                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                        <i class="ri-close-circle-line me-1"></i> Uğursuz: {{ $deliveryStats['failed'] }}
                    </span>
                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                        <i class="ri-time-line me-1"></i> Gözləyir: {{ $deliveryStats['pending'] }}
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-premium-v3 align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ALICI</th>
                                <th>TİP</th>
                                <th>MESAJ ÖNİZLƏMƏSİ</th>
                                <th>STATUS</th>
                                <th>CƏHDLƏRİN SAYI</th>
                                <th>VAXT</th>
                                <th class="text-end">ƏMƏLİYYAT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogs as $log)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-telegram-fill text-info me-2"></i>
                                        <code style="background:transparent; color:#00f2fe; font-size:12px;">
                                            {{ $log->subscriber?->username ?? $log->chat_id }}
                                        </code>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-2 py-1"
                                        style="background: rgba(213,0,249,0.15); color: #d500f9; font-size:10px;">
                                        {{ $log->type }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted fs-12" style="max-width:250px; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                        {{ $log->message_preview ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    @if($log->status === 'sent')
                                        <span class="badge bg-success-subtle text-success rounded-pill px-2">
                                            <i class="ri-checkbox-circle-fill me-1"></i>Göndərildi
                                        </span>
                                    @elseif($log->status === 'failed')
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-2"
                                            title="{{ $log->error_message }}">
                                            <i class="ri-close-circle-fill me-1"></i>Uğursuz
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-2">
                                            <i class="ri-time-fill me-1"></i>Gözləyir
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="text-white fs-13 fw-bold">{{ $log->attempts }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-white fw-bold fs-12">{{ $log->created_at?->format('d.m.Y H:i:s') }}</span>
                                        <span class="text-muted fs-11">{{ $log->created_at?->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-soft-primary btn-icon btn-sm rounded-pill action-btn-hover" 
                                            onclick="viewLogDetails('{{ $log->subscriber?->username ?? $log->chat_id }}', '{{ $log->type }}', '{{ $log->status }}', `{{ htmlspecialchars($log->message_preview ?? '') }}`, `{{ htmlspecialchars($log->error_message ?? '') }}`, '{{ $log->created_at?->format('d.m.Y H:i:s') }}')"
                                            data-bs-toggle="tooltip" title="Tam Detallar">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="opacity-30 text-white">
                                        <i class="ri-send-plane-line fs-36 mb-2 d-block"></i>
                                        <p class="fs-13">Hələ heç bir bildiriş göndərilməyib</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log Details Modal -->
<div class="modal fade glass-modal" id="logDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content premium-modal">
            <div class="modal-header border-bottom border-white border-opacity-10">
                <h5 class="modal-title text-white">
                    <i class="ri-eye-line text-primary me-2"></i>Bildiriş Detalları
                </h5>
                <button type="button" class="btn-close btn-close-white opacity-50" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-white border-opacity-10">
                    <span class="text-muted fs-13">Alıcı:</span>
                    <span class="text-info fw-bold" id="detail-receiver"></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-white border-opacity-10">
                    <span class="text-muted fs-13">Vaxt:</span>
                    <span class="text-white fw-bold fs-13" id="detail-time"></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted fs-13">Status:</span>
                    <span id="detail-status"></span>
                </div>
                <div class="mb-3 mt-4">
                    <span class="text-muted fs-13 d-block mb-2">Tam Mətn:</span>
                    <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); color: #e2e8f0; font-size: 13px; max-height: 250px; overflow-y: auto; white-space: pre-wrap;" id="detail-message"></div>
                </div>
                <div class="mb-0" id="detail-error-container" style="display: none;">
                    <span class="text-danger fs-13 d-block mb-2">Xəta Səbəbi:</span>
                    <div class="p-3 rounded-3 border border-danger border-opacity-25" style="background: rgba(220, 53, 69, 0.1); color: #ff8a8a; font-size: 13px; white-space: pre-wrap;" id="detail-error"></div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-light w-100" data-bs-dismiss="modal">Bağla</button>
            </div>
        </div>
    </div>
</div>

<script>
    function viewLogDetails(receiver, type, status, message, error, time) {
        document.getElementById('detail-receiver').innerText = receiver;
        document.getElementById('detail-time').innerText = time;
        document.getElementById('detail-message').innerText = message || 'Mətn yoxdur';
        
        let statusHtml = '';
        if(status === 'sent') {
            statusHtml = '<span class="badge bg-success-subtle text-success px-3 py-2"><i class="ri-checkbox-circle-fill me-1"></i>Göndərildi</span>';
        } else if(status === 'failed') {
            statusHtml = '<span class="badge bg-danger-subtle text-danger px-3 py-2"><i class="ri-close-circle-fill me-1"></i>Uğursuz</span>';
        } else {
            statusHtml = '<span class="badge bg-warning-subtle text-warning px-3 py-2"><i class="ri-time-fill me-1"></i>Gözləyir</span>';
        }
        document.getElementById('detail-status').innerHTML = statusHtml;

        if (error && error.trim() !== '') {
            document.getElementById('detail-error-container').style.display = 'block';
            document.getElementById('detail-error').innerText = error;
        } else {
            document.getElementById('detail-error-container').style.display = 'none';
        }

        new bootstrap.Modal(document.getElementById('logDetailsModal')).show();
    }
</script>
@endsection
