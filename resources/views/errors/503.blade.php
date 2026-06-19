<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <style>
        body { text-align: center; padding: 150px; font-family: sans-serif; background: #f8f9fa; color: #333; }
        h1 { font-size: 50px; margin-bottom: 10px; }
        p { font-size: 20px; color: #666; }
        .logo { max-width: 200px; margin-bottom: 40px; }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/chalang-preview.css?v=') . time() }}">
</head>
<body>
    @if(\App\Models\Setting::getValue('site_logo'))
        <img src="{{ \App\Models\Setting::getValue('site_logo') }}" alt="Logo" class="logo">
    @endif
    <h1>Biz tezliklə qayıdacağıq!</h1>
    <p>Saytda hazırda texniki işlər gedir. Zəhmət olmasa bir az sonra yenidən yoxlayın.</p>
    <p>&mdash; {{ \App\Models\Setting::getValue('site_title') ?? 'Chalang' }} Komandası</p>
    @include('front.layouts.partials.scroll_to_top')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/chalang-preview.js?v=') . time() }}"></script>
</body>
</html>
