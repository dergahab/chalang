<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Xətası | Chalang Group</title>
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
            text-align: center;
        }

        .error-card {
            width: 100%;
            max-width: 500px;
            padding: 60px 40px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
        }

        [data-theme='dark'] .error-card {
            background: rgba(30, 41, 59, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 10px;
            background: var(--brand-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: 'Questrial', sans-serif;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text-main);
        }

        .error-desc {
            color: var(--text-sub);
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .btn-home {
            padding: 14px 30px;
            border-radius: 50px;
            background: var(--brand-gradient);
            color: white;
            text-decoration: none;
            font-weight: 700;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 10px 20px var(--brand-glow);
            display: inline-block;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px var(--brand-glow);
        }
    </style>
</head>
<body>
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>

    <div class="error-card">
        <div class="error-code">500</div>
        <h1 class="error-title">Daxili Server Xətası</h1>
        <p class="error-desc">Gözlənilməz bir xəta baş verdi. Zəhmət olmasa bir az sonra yenidən cəhd edin.</p>
        <a href="{{ url('/') }}" class="btn-home">Ana Səhifəyə Qayıt</a>
    </div>

    @include('front.layouts.partials.scroll_to_top')


    <script src="{{ asset('assets/js/chalang-preview.js?v=') . time() }}"></script>
</body>
</html>
