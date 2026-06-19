<?php
$logPath = __DIR__ . '/../work_log.md';
$entry = "\n\n### [ID-212] Xəritə (World Map) TopoJSON Dekoder Xətasının Həlli (topojson-client)\n- **Tarix:** 2026-06-06\n- **SÜBUT (PROOF):** \n  - `scripts/generate-world-map.mjs`: Manual yazılmış (və qüsurlu olan) TopoJSON dekoderi ləğv edildi, əvəzinə rəsmi `topojson-client` kitabxanasından istifadə edildi. Bu, ölkələrin poliqonlarının, ring-lərinin və antimeridian koordinatlarının 100% standartlara uyğun və səhvsiz GeoJSON FeatureCollection obyektinə çevrilməsini təmin etdi. Xəritədə olan ölkələrin çarpaz kəsişmələri, sürüşmələri və yanlış yerləşmələri tamamilə aradan qaldırıldı.\n  - `public/assets/images/world-map-borders.svg`: Yenidən rəsmi kitabxana ilə dəqiq olaraq generasiya edildi.\n";

if (file_exists($logPath)) {
    file_put_contents($logPath, $entry, FILE_APPEND);
    echo "Log successfully appended to work_log.md\n";
} else {
    echo "work_log.md not found\n";
}
