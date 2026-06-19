<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Chalang Group</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Questrial&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-preview.css?v=') . time() }}">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            /* Background color handled by chalang-preview.css variables */
        }

        /* Hybrid Card: Glassmorphism + Rounded */
        .login-card {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 30px;
            
            /* Glassmorphism */
            background: rgba(255, 255, 255, 0.2); /* More transparent for glass feel */
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            
            position: relative;
            z-index: 10;
        }

        [data-theme='dark'] .login-card {
            background: rgba(30, 41, 59, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo {
            height: 40px;
            margin-bottom: 20px;
            fill: var(--text-main);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        /* Rounded Inputs (Iteration 2 style but more rounded as requested) */
        .form-control {
            width: 100%;
            padding: 14px 25px; /* More padding for rounded look */
            border-radius: 50px; /* Fully rounded */
            border: 1px solid rgba(0,0,0,0.1);
            background: rgba(255,255,255,0.6);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            transition: all 0.3s;
        }

        [data-theme='dark'] .form-control {
            background: rgba(0,0,0,0.3);
            border-color: rgba(255,255,255,0.1);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(var(--brand-primary-rgb), 0.15);
            background: rgba(255,255,255,0.9);
        }
        
        [data-theme='dark'] .form-control:focus {
            background: rgba(0,0,0,0.5);
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            margin-left: 15px; /* Align with rounded input */
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-sub);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            border-radius: 50px; /* Fully rounded button */
            background: var(--brand-gradient);
            color: white;
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 10px 20px var(--brand-glow);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px var(--brand-glow);
        }

        /* Toggles (Iteration 2 style) */
        .controls-top {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 20;
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 42px; /* Adjusted for label */
            background: none;
            border: none;
            color: var(--text-sub);
            cursor: pointer;
            padding: 0;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 5px;
            margin-left: 15px;
            display: block;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            margin-left: 10px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            accent-color: var(--brand-primary);
        }
    </style>
</head>
<body>
    <!-- Brand Background Shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="controls-top">
        <button class="control-btn lang-btn" id="lang-toggle" aria-label="Change language">AZ</button>
        <button class="control-btn theme-toggle" id="theme-toggle" aria-label="Toggle theme">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7z"/></svg>
        </button>
    </div>

    <div class="login-card">
        <div class="login-header">
            <svg class="login-logo" viewBox="0 0 81.87 15.74">
                <g>
                    <path fill="currentColor" d="M25.7,5.95c-.49-.62-1.3-1.22-2.46-1.22-1.96,0-3.33,1.59-3.33,3.31,0,1.84,1.46,3.38,3.34,3.38.87,0,1.75-.34,2.36-1.14h2.11c-.81,1.72-2.38,2.9-4.52,2.9-3.43,0-5.1-2.89-5.1-5.14s1.66-5.07,5.13-5.07c2.03,0,3.72,1.1,4.54,2.98h-2.07Z"/>
                    <path fill="currentColor" d="M28.72,3.14h1.82v3.93h3.58v-3.93h1.82v9.8h-1.82v-4.11h-3.58v4.11h-1.82V3.14Z"/>
                    <path fill="currentColor" d="M40.67,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM42.51,8.65l-1.11-2.86-1.11,2.86h2.23Z"/>
                    <path fill="currentColor" d="M46.89,3.14h1.82v8.04h2.99v1.76h-4.81V3.14Z"/>
                    <path fill="currentColor" d="M56.09,3.14h1.46l4.08,9.8h-2l-1.01-2.53h-3.6l-1.01,2.53h-2l4.08-9.8ZM57.93,8.65l-1.11-2.86-1.11,2.86h2.23Z"/>
                    <path fill="currentColor" d="M62.3,3.14h1.82l4.37,6.62V3.14h1.82v9.8h-1.82l-4.37-6.62v6.62h-1.82V3.14Z"/>
                    <path fill="currentColor" d="M81.87,7.95c-.03,2.33-1.46,5.23-5.21,5.23s-5.23-2.72-5.23-5.07,1.78-5.14,5.21-5.14c2.25,0,4.01,1.14,4.74,3.06h-2.17c-.76-1.25-2.11-1.3-2.57-1.3-2.29,0-3.39,1.78-3.39,3.31,0,1.67,1.22,3.38,3.47,3.38,1.19,0,2.33-.54,2.86-1.76h-4.09v-1.71h6.39Z"/>
                    <path fill="currentColor" d="M8.88.03C3.91-.37-.27,3.73.01,8.7c.18,3.15,2.14,5.82,4.88,7.04.02,0,.04-.02.03-.03-.22-.3-.35-.68-.35-1.08,0-.87.6-1.6,1.41-1.8.02,0,.02-.03,0-.04-1.88-.92-3.1-2.96-2.8-5.26.27-2.08,2.21-4.04,4.29-4.34,3.14-.44,5.82,1.98,5.82,5.03,0,2-1.16,3.74-2.85,4.56-.02,0-.02.04,0,.04.81.2,1.41.93,1.41,1.8,0,.4-.13.77-.34,1.08-.01.02,0,.04.03.03,2.88-1.28,4.89-4.16,4.89-7.52C16.44,3.9,13.11.36,8.88.03Z"/>
                    <path fill="currentColor" d="M8.23,13.3l.19.37c.14.28.36.5.64.64l.37.19s.01.02,0,.03l-.37.19c-.28.14-.5.36-.64.64l-.19.37s-.02.01-.03,0l-.19-.37c-.14-.28-.36-.5-.64-.64l-.37-.19s-.01-.02,0-.03l.37-.19c.28-.14.5-.36.64-.64l.19-.37s.02-.01.03,0Z"/>
                </g>
            </svg>
            <h2 data-lang="login_title">Xoş gəlmişsiniz!</h2>
            <p class="text-sub" data-lang="login_desc">Admin panelə daxil olun</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label" data-lang="email">Email ünvanı</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@chalang.com">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label" data-lang="password">Şifrə</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="******">
                <button type="button" class="password-toggle" id="password-toggle">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 0.95rem;">
                <label class="form-check d-flex align-items-center gap-2 cursor-pointer mb-0">
                    <input class="form-check-input" type="checkbox" value="1" id="auth-remember-check" name="remember" {{ old('remember') ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                    <span class="form-check-label text-sub" for="auth-remember-check" data-lang="remember" style="user-select: none;">Məni xatırla</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-primary text-decoration-none fw-semibold" style="transition: color 0.3s;" data-lang="forgot_password">Şifrəni unutmusunuz?</a>
            </div>

            <button type="submit" class="btn-login" data-lang="btn_login">Daxil ol</button>
        </form>
    </div>

    @include('front.layouts.partials.scroll_to_top')


    <script src="{{ asset('assets/js/chalang-preview.js?v=') . time() }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Password Toggle
            const toggleBtn = document.getElementById('password-toggle');
            const passwordInput = document.getElementById('password');
            
            if(toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', () => {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    if(type === 'text') {
                        toggleBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
                    } else {
                        toggleBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
                    }
                });
            }

            // Translations
            const loginTranslations = {
                AZ: { login_title: 'Xoş gəlmişsiniz!', login_desc: 'Admin panelə daxil olun', email: 'Email ünvanı', password: 'Şifrə', remember: 'Məni xatırla', btn_login: 'Daxil ol', forgot_password: 'Şifrəni unutmusunuz?' },
                EN: { login_title: 'Welcome Back!', login_desc: 'Sign in to admin panel', email: 'Email Address', password: 'Password', remember: 'Remember me', btn_login: 'Sign In', forgot_password: 'Forgot Password?' },
                RU: { login_title: 'Добро пожаловать!', login_desc: 'Войдите в админ-панель', email: 'Эл. адрес', password: 'Пароль', remember: 'Запомнить меня', btn_login: 'Войти', forgot_password: 'Забыли пароль?' }
            };

            const langBtn = document.getElementById('lang-toggle');
            if(langBtn) {
                langBtn.addEventListener('click', () => {
                    setTimeout(() => {
                        const currentLang = langBtn.innerText;
                        const data = loginTranslations[currentLang] || loginTranslations['AZ'];
                        
                        document.querySelectorAll('[data-lang]').forEach(el => {
                            const key = el.getAttribute('data-lang');
                            if (data[key]) {
                                el.innerText = data[key];
                            }
                        });
                    }, 50);
                });
            }
        });
    </script>
</body>
</html>