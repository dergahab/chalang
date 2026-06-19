<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Chalang Group</title>
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
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.2);
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

        .form-control {
            width: 100%;
            padding: 14px 25px;
            border-radius: 50px;
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
            margin-left: 15px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-sub);
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            border-radius: 50px;
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

        .alert-success {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #10b981;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--text-sub);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: var(--brand-primary);
        }

        .controls-top {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 20;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 5px;
            margin-left: 15px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="controls-top">
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
            <h2>Şifrəni unutmusunuz?</h2>
            <p class="text-sub">Email ünvanınızı daxil edin, sizə bərpa linki göndərək.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email ünvanı</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@chalang.com">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-login">Bərpa linkini göndər</button>
            
            <a href="{{ route('login') }}" class="back-link">← Giriş səhifəsinə qayıt</a>
        </form>
    </div>

    @include('front.layouts.partials.scroll_to_top')


    <script src="{{ asset('assets/js/chalang-preview.js?v=') . time() }}"></script>
</body>
</html>
