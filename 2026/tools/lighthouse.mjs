/**
 * Build, serve, and run Lighthouse against every page — mobile and desktop.
 *
 * Usage: npm run lighthouse
 */

import { spawn } from 'node:child_process';
import { mkdirSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const ROOT = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const PORT = 8099;
const PAGES = ['/', '/work/', '/work/dell-podcast/'];
const THRESHOLD = 95;

mkdirSync(resolve(ROOT, '.lighthouse'), { recursive: true });

function run(command, args, options = {}) {
  return new Promise((resolvePromise, reject) => {
    const child = spawn(command, args, { cwd: ROOT, stdio: 'inherit', ...options });
    child.on('exit', (code) =>
      code === 0 ? resolvePromise() : reject(new Error(`${command} exited ${code}`)),
    );
  });
}

const server = spawn('node', ['tools/serve.mjs', String(PORT)], {
  cwd: ROOT,
  stdio: 'ignore',
});

// A server left behind from an aborted run will serve a stale build on the same
// port and quietly invalidate every result, so tear it down on any exit path.
const stopServer = () => server.kill('SIGKILL');
process.on('exit', stopServer);
for (const signal of ['SIGINT', 'SIGTERM', 'uncaughtException']) process.on(signal, () => {
  stopServer();
  process.exit(1);
});

// Give the static server a moment to bind.
await new Promise((r) => setTimeout(r, 1500));

let failed = false;

for (const preset of ['desktop', 'mobile']) {
  for (const page of PAGES) {
    const slug = page.replace(/\W+/g, '-').replace(/^-|-$/g, '') || 'home';
    const output = resolve(ROOT, '.lighthouse', `${preset}-${slug}.json`);
    const args = [
      'lighthouse',
      `http://localhost:${PORT}${page}`,
      '--quiet',
      '--chrome-flags=--headless=new',
      '--output=json',
      `--output-path=${output}`,
    ];
    if (preset === 'desktop') args.push('--preset=desktop');

    console.log(`\n▸ ${preset} ${page}`);
    await run('npx', args);

    const { categories } = JSON.parse(await import('node:fs').then((fs) => fs.promises.readFile(output, 'utf8')));
    for (const [key, category] of Object.entries(categories)) {
      const score = Math.round(category.score * 100);
      const ok = score >= THRESHOLD;
      if (!ok) failed = true;
      console.log(`  ${ok ? '✓' : '✗'} ${category.title.padEnd(16)} ${score}`);
    }
  }
}

server.kill();
process.exit(failed ? 1 : 0);
