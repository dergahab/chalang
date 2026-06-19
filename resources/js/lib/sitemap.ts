/**
 * Sitemap utilities
 */
export interface SitemapUrl {
    loc: string;
    lastmod?: string;
    changefreq?: 'always' | 'hourly' | 'daily' | 'weekly' | 'monthly' | 'yearly' | 'never';
    priority?: number;
}

export interface SitemapImage {
    url: string;
    title?: string;
    caption?: string;
    geoLocation?: string;
    license?: string;
}

export interface SitemapLink {
    lang: string;
    url: string;
}

/**
 * Generate XML sitemap entry
 */
export function generateSitemapUrl(url: SitemapUrl): string {
    const { loc, lastmod, changefreq = 'weekly', priority = 0.5 } = url;
    
    return `  <url>
    <loc>${loc}</loc>
    <lastmod>${lastmod}</lastmod>
    <changefreq>${changefreq}</changefreq>
    <priority>${priority}</priority>
  </url>`;
}

/**
 * Generate XML video sitemap entry
 */
export function generateVideoSitemap(
    loc: string,
    video: {
        title: string;
        description: string;
        thumbnail_loc: string;
        content_loc?: string;
        player_loc?: string;
        duration?: number;
        expiration_date?: string;
        rating?: number;
        view_count?: number;
        publication_date?: string;
        family_friendly?: boolean;
        tag?: string[];
    }
): string {
    const tags = video.tag?.map(t => `      <video:tag>${t}</video:tag>`).join('\n');
    
    return `  <url>
    <loc>${loc}</loc>
    <video:video>
      <video:title><![CDATA[${video.title}]]></video:title>
      <video:description><![CDATA[${video.description}]]></video:description>
      <video:thumbnail_loc>${video.thumbnail_loc}</video:thumbnail_loc>
      ${video.content_loc ? `<video:content_loc>${video.content_loc}</video:content_loc>` : ''}
      ${video.player_loc ? `<video:player_loc allow_embed="yes">${video.player_loc}</video:player_loc>` : ''}
      ${video.duration ? `<video:duration>${video.duration}</video:duration>` : ''}
      ${video.expiration_date ? `<video:expiration_date>${video.expiration_date}</video:expiration_date>` : ''}
      ${video.rating ? `<video:rating>${video.rating}</video:rating>` : ''}
      ${video.view_count ? `<video:view_count>${video.view_count}</video:view_count>` : ''}
      ${video.publication_date ? `<video:publication_date>${video.publication_date}</video:publication_date>` : ''}
      <video:family_friendly>${video.family_friendly ? 'yes' : 'no'}</video:family_friendly>
${tags || ''}
    </video:video>
  </url>`;
}

/**
 * Generate XML image sitemap entry
 */
export function generateImageSitemap(loc: string, images: SitemapImage[]): string {
    const imageTags = images.map(img => 
        `      <image:image>
        <image:loc>${img.url}</image:loc>
        ${img.title ? `<image:title><![CDATA[${img.title}]]></image:title>` : ''}
        ${img.caption ? `<image:caption><![CDATA[${img.caption}]]></image:caption>` : ''}
        ${img.geoLocation ? `<image:geo_location>${img.geoLocation}</image:geo_location>` : ''}
        ${img.license ? `<image:license>${img.license}</image:license>` : ''}
      </image:image>`
    ).join('\n');
    
    return `  <url>
    <loc>${loc}</loc>
${imageTags}
  </url>`;
}

/**
 * Generate complete sitemap XML
 */
export function generateSitemap(
    urls: SitemapUrl[],
    options?: {
        xhtml?: boolean;
        images?: boolean;
        videos?: boolean;
        news?: boolean;
    }
): string {
    const urlEntries = urls.map(generateSitemapUrl).join('\n');
    
    return `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xhtml="http://www.w3.org/1999/xhtml"
  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
  xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
  xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
${urlEntries}
</urlset>`;
}

/**
 * Generate robots.txt content
 */
export function generateRobotsTxt(sitemapUrl: string, allowRules?: string[], disallowRules?: string[]): string {
    const lines = [
        'User-agent: *',
        'Allow: /',
        ...(allowRules || []).map(rule => `Allow: ${rule}`),
        'Disallow: /api/',
        'Disallow: /admin/',
        'Disallow: /_debug/',
        ...(disallowRules || []).map(rule => `Disallow: ${rule}`),
        '',
        `Sitemap: ${sitemapUrl}`,
    ];
    
    return lines.join('\n');
}

/**
 * Generate sitemap index for multiple sitemaps
 */
export function generateSitemapIndex(
    sitemaps: Array<{ loc: string; lastmod: string }>
): string {
    const entries = sitemaps.map(s => 
        `  <sitemap>
    <loc>${s.loc}</loc>
    <lastmod>${s.lastmod}</lastmod>
  </sitemap>`
    ).join('\n');
    
    return `<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap-index/0.9">
${entries}
</sitemapindex>`;
}

export default {
    generateSitemapUrl,
    generateVideoSitemap,
    generateImageSitemap,
    generateSitemap,
    generateRobotsTxt,
    generateSitemapIndex,
};