/**
 * Branded stand-ins for the images lost with the server.
 *
 * Every path in src/_data/assets.json that has no real file yet gets a placeholder
 * generated at the exact path the templates reference, so the site builds and lays
 * out correctly. Dropping the real file over one replaces it — no code change, and
 * this script never overwrites a file it did not generate.
 *
 * Usage: node tools/build-placeholders.mjs
 */

import { existsSync, mkdirSync, readFileSync, writeFileSync } from 'node:fs';
import { dirname, resolve, extname, basename } from 'node:path';
import { fileURLToPath } from 'node:url';
import sharp from 'sharp';

const ROOT = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const SRC = resolve(ROOT, 'src');
const assets = JSON.parse(readFileSync(resolve(SRC, '_data/assets.json'), 'utf8'));

const BRAND = {
  ink: '#201a1e',
  paper: '#e1dfd0',
  accents: ['#226d68', '#85316d', '#bf4c31', '#68882a', '#e3bf30'],
};

/** Square social crops render square; everything else uses the 16:9 content frame. */
function dimensionsFor(file) {
  if (/1080x1080/.test(file)) return { width: 1080, height: 1080 };
  if (/favicon/i.test(file)) return { width: 512, height: 512 };
  if (/^og\./i.test(file)) return { width: 1200, height: 630 };
  return { width: 1600, height: 900 };
}

function escapeXml(value) {
  return value.replace(/[<>&]/g, (c) => ({ '<': '&lt;', '>': '&gt;', '&': '&amp;' })[c]);
}

/** Wrap a long filename onto lines that fit the frame. */
function wrap(text, perLine) {
  const words = text.replace(/[-_]/g, ' ').split(/\s+/);
  const lines = [];
  let line = '';
  for (const word of words) {
    if ((line + ' ' + word).trim().length > perLine) {
      if (line) lines.push(line.trim());
      line = word;
    } else {
      line += ` ${word}`;
    }
  }
  if (line.trim()) lines.push(line.trim());
  return lines.slice(0, 4);
}

function placeholderSvg(label, { width, height }, accent) {
  const fontSize = Math.round(width / 28);
  const lines = wrap(label, Math.round(width / fontSize / 0.58));
  const startY = height / 2 - ((lines.length - 1) * fontSize * 1.35) / 2 + fontSize / 3;

  const text = lines
    .map(
      (line, i) =>
        `<text x="${width / 2}" y="${startY + i * fontSize * 1.35}" font-family="Arial, Helvetica, sans-serif" font-size="${fontSize}" font-weight="700" fill="${BRAND.paper}" text-anchor="middle" opacity="0.85">${escapeXml(line)}</text>`,
    )
    .join('');

  const bar = Math.round(height / 14);

  return Buffer.from(
    `<svg xmlns="http://www.w3.org/2000/svg" width="${width}" height="${height}" viewBox="0 0 ${width} ${height}">
      <rect width="${width}" height="${height}" fill="${BRAND.ink}"/>
      <rect x="0" y="0" width="${width}" height="${bar}" fill="${accent}"/>
      <rect x="0" y="${height - bar}" width="${width}" height="${bar}" fill="${accent}"/>
      ${text}
      <text x="${width / 2}" y="${height - bar * 2}" font-family="Arial, Helvetica, sans-serif" font-size="${Math.round(fontSize * 0.6)}" fill="${accent}" text-anchor="middle" letter-spacing="2">IMAGE PENDING</text>
    </svg>`,
  );
}

const RASTER = new Set(['.jpg', '.jpeg', '.png', '.webp', '.gif']);
let created = 0;
let skipped = 0;

for (const [scope, files] of Object.entries(assets)) {
  for (const [index, asset] of files.entries()) {
    const ext = extname(asset.localPath).toLowerCase();
    if (!RASTER.has(ext)) continue;

    const target = resolve(SRC, asset.localPath.replace(/^\//, ''));
    if (existsSync(target)) {
      skipped += 1;
      continue;
    }

    const size = dimensionsFor(basename(asset.localPath));
    const accent = BRAND.accents[(scope.length + index) % BRAND.accents.length];
    const svg = placeholderSvg(asset.title || basename(asset.localPath), size, accent);

    mkdirSync(dirname(target), { recursive: true });
    const image = sharp(svg);
    await (ext === '.png' ? image.png({ compressionLevel: 9 }) : image.jpeg({ quality: 82 })).toFile(
      target,
    );
    created += 1;
  }
}

// Favicon and OG image are referenced by every page — make sure both exist.
for (const [path, size] of [
  ['/assets/images/site/favicon.png', { width: 512, height: 512 }],
  ['/assets/images/site/og.png', { width: 1200, height: 630 }],
]) {
  const target = resolve(SRC, path.replace(/^\//, ''));
  if (existsSync(target)) continue;
  mkdirSync(dirname(target), { recursive: true });
  await sharp(placeholderSvg('Damien Mulhall', size, BRAND.accents[0])).png().toFile(target);
  created += 1;
}

console.log(`✓ ${created} placeholders generated, ${skipped} real files left untouched`);
