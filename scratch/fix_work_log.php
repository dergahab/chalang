<?php
$logPath = __DIR__ . '/../work_log.md';
if (!file_exists($logPath)) {
    die("work_log.md not found\n");
}

$content = file_get_contents($logPath);

$targetHeader = "### [ID-049] Xəritə (World Map) Geodezik Dəqiqləşdirmə və Hotspot Optimizasiyası";
$pos = strpos($content, $targetHeader);

if ($pos !== false) {
    $content = substr($content, 0, $pos);
    $content = rtrim($content);
    echo "Removed wrongly appended ID-049 entry\n";
}

$newEntry = "\n\n### [ID-210] Xəritə (World Map) Geodezik Dəqiqləşdirmə və Hotspot Optimizasiyası\n";
$newEntry .= "- **Tarix:** 2026-06-06\n";
$newEntry .= "- **SÜBUT (PROOF):** \n";
$newEntry .= "  - `scripts/generate-world-map.mjs`: Natural Earth TopoJSON məlumatı 50m miqyasına (orta keyfiyyətli sharp borders) keçirildi. Xəritənin arxa fon düzbucaqlısı silindi (transparent bg) və ölkələrin xətləri premium dark mode rəngləri ilə daha aydın (sharp border) stilizə edildi.\n";
$newEntry .= "  - `public/assets/images/world-map-borders.svg`: Yenidən generasiya edildi (241 ölkə/ərazi, Plate Carrée proyeksiya).\n";
$newEntry .= "  - `resources/js/Components/Sections/Process.tsx`: `DEFAULT_MAP_POINTS` daxilindəki Bakı, New York, Switzerland və Dubai koordinatları Plate Carrée (Equirectangular) proyeksiyasına uyğun real geodezik faizlərlə yeniləndi. Hotspot dizaynına real-time `animate-ping` ripple effekti, mərkəz nöqtə və şüşəvari floating şəhər etiketləri (glassmorphic label) əlavə edildi.\n";
$newEntry .= "  - `resources/views/admin/pages/home_sections/edit.blade.php`: Adminkada olan default xəritə `.png`-dən `.svg`-yə keçirildi ki, vizual olaraq front ilə 1:1 eyni olsun.\n";
$newEntry .= "  - Verilənlər bazası: `preview.process.map_points` açarı üzrə olan Bakı koordinatı `top: 27.6, left: 63.9` olaraq yeniləndi.\n";

$content .= $newEntry;

file_put_contents($logPath, $content);
echo "Successfully written [ID-210] to work_log.md\n";
