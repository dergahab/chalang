/**
 * Generate a geographically accurate world map SVG from Natural Earth data.
 * Uses topojson-client and d3-geo for flawless paths, handling lakes/seas correctly.
 * Output: public/assets/images/world-map-borders.svg
 */
import { readFileSync, writeFileSync, mkdirSync } from 'fs';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';
import * as topojson from 'topojson-client';
import * as d3Geo from 'd3-geo';

const __dirname = dirname(fileURLToPath(import.meta.url));
const root = resolve(__dirname, '..');

// Read world-atlas TopoJSON (50m resolution for accurate boundaries)
const topoPath = resolve(root, 'node_modules/world-atlas/countries-50m.json');
const topo = JSON.parse(readFileSync(topoPath, 'utf8'));

// Convert TopoJSON to GeoJSON
const geojson = topojson.feature(topo, topo.objects.countries);

const WIDTH = 1600;
const HEIGHT = 800;

// Use Equirectangular projection so that linear lon/lat mapping in frontend still perfectly aligns
const projection = d3Geo.geoEquirectangular()
    .scale(WIDTH / (2 * Math.PI))
    .translate([WIDTH / 2, HEIGHT / 2]);

const pathGenerator = d3Geo.geoPath().projection(projection);

// Generate path strings for all countries
const pathStrings = [];
for (const feature of geojson.features) {
    const p = pathGenerator(feature);
    if (p) pathStrings.push(p);
}

// --- Compose SVG ---
const svg = `<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${WIDTH} ${HEIGHT}" width="${WIDTH}" height="${HEIGHT}" fill="none">
  <!-- Transparent background. The holes (lakes, seas) will correctly show through. -->
  <g>
    ${pathStrings.map(d => `<path d="${d}" fill="var(--map-land, #111625)" fill-opacity="var(--map-land-opacity, 0.5)" stroke="var(--map-stroke, rgba(124, 58, 237, 0.16))" stroke-width="var(--map-stroke-width, 0.6)" stroke-linejoin="round" style="transition: fill 0.3s ease, stroke 0.3s ease;" class="world-map-country-path"/>`).join('\n    ')}
  </g>
</svg>`;

// Write output
const outDir = resolve(root, 'public/assets/images');
mkdirSync(outDir, { recursive: true });
const outPath = resolve(outDir, 'world-map-borders.svg');
writeFileSync(outPath, svg, 'utf8');

console.log(`✅ World map SVG generated using d3-geo: ${outPath}`);
console.log(`   ${pathStrings.length} countries, ${WIDTH}x${HEIGHT}px, Equirectangular projection`);
