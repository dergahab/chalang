<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Services --}}
    @foreach ($services as $service)
        <url>
            <loc>{{ url('/preview/services/' . $service->slug) }}</loc>
            <lastmod>{{ $service->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- Portfolios --}}
    @foreach ($portfolios as $portfolio)
        <url>
            <loc>{{ url('/preview/portfolio/' . $portfolio->slug) }}</loc>
            <lastmod>{{ $portfolio->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    {{-- Blogs --}}
    @foreach ($blogs as $blog)
        <url>
            <loc>{{ url('/preview/blogs/' . $blog->slug) }}</loc>
            <lastmod>{{ $blog->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
