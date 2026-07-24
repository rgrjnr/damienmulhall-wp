/**
 * Static server for local previews and Lighthouse runs.
 *
 * Mirrors what App Platform actually serves — gzip on text responses and
 * long-lived immutable caching on fingerprinted assets — so audit numbers reflect
 * production rather than the quirks of a bare file server.
 *
 * Usage: node tools/serve.mjs [port]
 */

import { createServer } from 'node:http';
import { createReadStream, statSync } from 'node:fs';
import { extname, join, normalize, resolve, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';
import { createGzip } from 'node:zlib';

const ROOT = resolve(dirname(fileURLToPath(import.meta.url)), '../_site');
const PORT = Number(process.argv[2]) || 8099;

const TYPES = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'text/javascript; charset=utf-8',
  '.json': 'application/json; charset=utf-8',
  '.xml': 'application/xml; charset=utf-8',
  '.txt': 'text/plain; charset=utf-8',
  '.svg': 'image/svg+xml',
  '.avif': 'image/avif',
  '.webp': 'image/webp',
  '.jpeg': 'image/jpeg',
  '.jpg': 'image/jpeg',
  '.png': 'image/png',
  '.woff2': 'font/woff2',
  '.mp4': 'video/mp4',
  '.pdf': 'application/pdf',
};

const COMPRESSIBLE = new Set(['.html', '.css', '.js', '.json', '.xml', '.txt', '.svg']);

function resolveFile(urlPath) {
  const clean = normalize(decodeURIComponent(urlPath.split('?')[0])).replace(/^(\.\.[/\\])+/, '');
  const candidates = clean.endsWith('/')
    ? [join(clean, 'index.html')]
    : [clean, join(clean, 'index.html')];

  for (const candidate of candidates) {
    const full = join(ROOT, candidate);
    try {
      if (statSync(full).isFile()) return full;
    } catch {
      /* try the next candidate */
    }
  }
  return null;
}

createServer((request, response) => {
  const file = resolveFile(request.url || '/') ?? join(ROOT, '404.html');
  const ext = extname(file).toLowerCase();
  const found = resolveFile(request.url || '/') !== null;

  const headers = {
    'Content-Type': TYPES[ext] ?? 'application/octet-stream',
    // Fingerprinted images and immutable fonts cache hard; pages revalidate.
    'Cache-Control': /^\/assets\/(img|fonts)\//.test(request.url || '')
      ? 'public, max-age=31536000, immutable'
      : ext === '.html'
        ? 'public, max-age=0, must-revalidate'
        : 'public, max-age=86400',
    'X-Content-Type-Options': 'nosniff',
  };

  const acceptsGzip = /\bgzip\b/.test(request.headers['accept-encoding'] || '');
  if (acceptsGzip && COMPRESSIBLE.has(ext)) {
    headers['Content-Encoding'] = 'gzip';
    headers.Vary = 'Accept-Encoding';
    response.writeHead(found ? 200 : 404, headers);
    createReadStream(file).pipe(createGzip()).pipe(response);
    return;
  }

  response.writeHead(found ? 200 : 404, headers);
  createReadStream(file).pipe(response);
}).listen(PORT, () => {
  console.log(`serving _site on http://localhost:${PORT}`);
});
