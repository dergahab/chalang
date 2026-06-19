@php
// Helper: Convert Hex to RGB
$hex2rgb = function($hex) {
$hex = str_replace('#', '', $hex);
if(strlen($hex) == 3) {
$r = hexdec(substr($hex,0,1).substr($hex,0,1));
$g = hexdec(substr($hex,1,1).substr($hex,1,1));
$b = hexdec(substr($hex,2,1).substr($hex,2,1));
} else {
$r = hexdec(substr($hex,0,2));
$g = hexdec(substr($hex,2,2));
$b = hexdec(substr($hex,4,2));
}
return "$r, $g, $b";
};

// Fetch Settings — Brand Colors
$pLight = \App\Models\Setting::getValue('theme_color_primary_light') ?? '#4b0082';
$sLight = \App\Models\Setting::getValue('theme_color_secondary_light') ?? '#d500f9';
$tLight = \App\Models\Setting::getValue('theme_color_tertiary_light') ?? '#9333ea'; // brand-violet (not blue!)
$pDark  = \App\Models\Setting::getValue('theme_color_primary_dark')  ?? '#7c3aed';
$sDark  = \App\Models\Setting::getValue('theme_color_secondary_dark') ?? '#c026d3';
$tDark  = \App\Models\Setting::getValue('theme_color_tertiary_dark')  ?? '#8b00ff'; // deep violet (not blue!)

$fontFamily    = \App\Models\Setting::getValue('theme_font_family')    ?? 'Outfit';
$borderRadius  = \App\Models\Setting::getValue('theme_border_radius')  ?? 'rounded';
$smartBg       = \App\Models\Setting::getValue('theme_smart_bg')       ?? false;
$glowIntensity = \App\Models\Setting::getValue('theme_glow_intensity') ?? 15;
$customCss     = \App\Models\Setting::getValue('theme_custom_css');
$customJs      = \App\Models\Setting::getValue('theme_custom_js');

// Gradient Studio Settings
$gradientAngle      = (int)(\App\Models\Setting::getValue('gradient_angle')             ?? 135);
$ambientIntensity   = (int)(\App\Models\Setting::getValue('gradient_ambient_intensity') ?? 60);  // 0-100
$gradientBtnStart   = \App\Models\Setting::getValue('gradient_btn_start')   ?? '';  // empty = use brand-primary
$gradientBtnEnd     = \App\Models\Setting::getValue('gradient_btn_end')     ?? '';  // empty = use brand-secondary
$gradientTextStart  = \App\Models\Setting::getValue('gradient_text_start')  ?? '';
$gradientTextEnd    = \App\Models\Setting::getValue('gradient_text_end')    ?? '';
$gradientBrandCss   = \App\Models\Setting::getValue('gradient_brand_css')   ?? '';

// Computed values
$ambientFactor = round($ambientIntensity / 100, 2);

// Font Mapping
$fonts = [
'Outfit'         => 'Outfit:wght@300;400;500;600;700;800;900',
'Inter'          => 'Inter:wght@300;400;500;600;700;800;900',
'Roboto'         => 'Roboto:wght@300;400;500;700;900',
'Playfair Display' => 'Playfair+Display:wght@400;600;700;900'
];
$selectedFontString = $fonts[$fontFamily] ?? $fonts['Outfit'];

// Radius Mapping
$radii = [
'square'  => ['btn' => '0px',  'card' => '0px',  'input' => '0px'],
'rounded' => ['btn' => '12px', 'card' => '24px', 'input' => '12px'],
'pill'    => ['btn' => '50px', 'card' => '30px', 'input' => '25px'],
];
$r = $radii[$borderRadius] ?? $radii['rounded'];
@endphp

<!-- Dynamic Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=<?php echo $selectedFontString; ?>&display=swap" rel="stylesheet">

<style>
    :root {
        /* TYPOGRAPHY */
        --font-main: '<?php echo $fontFamily; ?>', sans-serif;
        --font-display: '<?php echo $fontFamily; ?>', sans-serif;
        --font-heading: '<?php echo $fontFamily; ?>', sans-serif;
        --font-body: '<?php echo $fontFamily; ?>', sans-serif;

        /* SHAPES (Semantic) */
        --radius-btn: <?php echo $r['btn']; ?>;
        --radius-card: <?php echo $r['card']; ?>;
        --radius-input: <?php echo $r['input']; ?>;

        /* SHAPES (Core Mapping - Binding to Design System) */
        --radius-sm: var(--radius-input);
        /* Inputs follow input radius */
        --radius-md: var(--radius-card);
        /* Cards follow card radius */
        --radius-lg: var(--radius-card);
        /* Large containers follow card radius */
        --radius-full: var(--radius-btn);
        /* Buttons follow button radius */

        /* LIGHT MODE COLORS */
        --brand-primary: <?php echo $pLight; ?> !important;
        --brand-primary-rgb: <?php echo $hex2rgb($pLight); ?> !important;
        --brand-secondary: <?php echo $sLight; ?> !important;
        --brand-secondary-rgb: <?php echo $hex2rgb($sLight); ?> !important;
        --brand-tertiary: <?php echo $tLight; ?> !important;
        --brand-tertiary-rgb: <?php echo $hex2rgb($tLight); ?> !important;
        --brand-gradient: <?php echo $gradientBrandCss ?: "linear-gradient({$gradientAngle}deg, ".($gradientBtnStart ?: $pLight).", ".($gradientBtnEnd ?: $sLight).")"; ?> !important;
        --brand-glow: rgba(<?php echo $hex2rgb($pLight); ?>, <?php echo $glowIntensity / 100; ?>) !important;

        /* GRADIENT STUDIO (Global) */
        --gradient-angle: <?php echo $gradientAngle; ?>deg;
        --ambient-intensity: <?php echo $ambientFactor; ?>;
        --gradient-text-start: <?php echo $gradientTextStart ?: $pLight; ?>;
        --gradient-text-end: <?php echo $gradientTextEnd ?: $sLight; ?>;
        --gradient-btn-start: <?php echo $gradientBtnStart ?: $pLight; ?>;
        --gradient-btn-end: <?php echo $gradientBtnEnd ?: $sLight; ?>;

        /* GLASS & SURFACE COLORS (Light) */
        --bg-body: #f2f4f8;
        --card-bg: rgba(255, 255, 255, 0.6);
        --nav-bg-glass: rgba(255, 255, 255, 0.3);
        --card-border: rgba(255, 255, 255, 0.8);
        --nav-border: rgba(255, 255, 255, 0.9);
        --nav-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        --btn-glass: rgba(255, 255, 255, 0.2);

        /* TEXT COLORS (Light) */
        --text-main: #111111;
        --text-sub: #555555;

        /* Map legacy tokens just in case */
        --color-bg: var(--bg-body, #f2f4f8) !important;
        --color-bg-secondary: #f8f9fa !important;
        --color-text-main: var(--text-main, #1a1a2e) !important;
        --color-text-sub: var(--text-sub, #555555) !important;

        <?php if ($smartBg): ?>
        /* Smart Tint Light: White mixed with 3% Primary */
        --bg-body: color-mix(in srgb, <?php echo $pLight; ?> 3%, #f2f4f8) !important;
        <?php endif; ?>
    }

    html[data-theme="dark"] {
        /* DARK MODE COLORS */
        --brand-primary: <?php echo $pDark; ?> !important;
        --brand-primary-rgb: <?php echo $hex2rgb($pDark); ?> !important;
        --brand-secondary: <?php echo $sDark; ?> !important;
        --brand-secondary-rgb: <?php echo $hex2rgb($sDark); ?> !important;
        --brand-tertiary: <?php echo $tDark; ?> !important;
        --brand-tertiary-rgb: <?php echo $hex2rgb($tDark); ?> !important;
        --brand-gradient: <?php echo $gradientBrandCss ?: "linear-gradient({$gradientAngle}deg, ".($gradientBtnStart ?: $pDark).", ".($gradientBtnEnd ?: $sDark).")"; ?> !important;
        --brand-glow: rgba(<?php echo $hex2rgb($pDark); ?>, <?php echo $glowIntensity / 100; ?>) !important;
        --gradient-btn-start: <?php echo $gradientBtnStart ?: $pDark; ?>;
        --gradient-btn-end: <?php echo $gradientBtnEnd ?: $sDark; ?>;

        /* GLASS & SURFACE COLORS (Dark) */
        --bg-body: #0b0f19;
        --card-bg: rgba(17, 24, 39, 0.8);
        --nav-bg-glass: rgba(11, 15, 25, 0.9);
        --card-border: rgba(255, 255, 255, 0.08);
        --nav-border: rgba(255, 255, 255, 0.05);
        --nav-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        --btn-glass: rgba(255, 255, 255, 0.05);

        /* TEXT COLORS (Dark) */
        --text-main: #e2e8f0;
        --text-sub: #94a3b8;

        /* Map legacy tokens */
        --color-bg: var(--bg-body, #0b0f19) !important;
        --color-bg-secondary: #111827 !important;
        --color-text-main: var(--text-main, #e2e8f0) !important;
        --color-text-sub: var(--text-sub, #94a3b8) !important;

        <?php if ($smartBg): ?>
        /* Smart Tint Dark */
        --bg-body: color-mix(in srgb, <?php echo $pDark; ?> 5%, #0b0f19) !important;
        --nav-bg-glass: color-mix(in srgb, <?php echo $pDark; ?> 5%, rgba(11, 15, 25, 0.9)) !important;
        <?php endif; ?>
    }

    /* GLOBAL OVERRIDES */
    body {
        font-family: var(--font-main) !important;
    }

    /* NOTE: We mapped Core variables above (--radius-full, etc.) so we don't need manual class overrides here anymore.
       This keeps the CSS cleaner and respects the Design System structure. */

    /* CUSTOM CSS from Admin */
    <?php echo $customCss; ?>
</style>

<?php if ($customJs): ?>
    <script>
        <?php echo $customJs; ?>
    </script>
<?php endif; ?>