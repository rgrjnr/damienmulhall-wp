/**
 * One-off (but re-runnable) migration: dm_posts.csv -> src/work/*.md
 *
 * The original WordPress database was lost with the server. All that survives is a
 * `wp_posts` dump. That gives us post_title / post_excerpt / post_content and the
 * attachment manifest, but NOT wp_postmeta (Carbon Fields values, featured images)
 * or wp_term_relationships (highlight badge assignments). Those are reconstructed
 * from the OVERRIDES table below and marked for Damien to confirm.
 *
 * Usage: npm run migrate
 */

import { readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { dirname, resolve, basename } from 'node:path';
import { fileURLToPath } from 'node:url';
import { parse } from 'csv-parse/sync';
import TurndownService from 'turndown';

const __dirname = dirname(fileURLToPath(import.meta.url));
const ROOT = resolve(__dirname, '..');
const CSV = resolve(ROOT, '..', 'dm_posts.csv');

/**
 * Everything the CSV could not tell us, reconstructed from the case study bodies.
 * Each entry is Damien's to correct — `needsReview` fields are listed in
 * MISSING-ASSETS.md so nothing silently ships as a guess.
 */
const OVERRIDES = {
  'dell-podcast': {
    shortTitle: 'Dell Podcast Series',
    client: 'Dell Technologies',
    duration: '',
    highlights: ['mic', 'spotify', 'increase'],
    hero: '3966-DEL-SD-Podcast-Series-for-DTF-Podcast-trailer-Poster-frame-1.jpg',
    needsReview: ['duration'],
  },
  'windows-11-community-events': {
    shortTitle: 'Windows 11 Events',
    client: 'Dell Technologies',
    duration: '3 months',
    highlights: ['megaphone', 'increase', 'star'],
    hero: '4275-LinkedIn-1080x1080-posts2.jpg',
    // Body says only "a leading technology solutions provider" — client inferred.
    needsReview: ['client'],
  },
  'google-education': {
    shortTitle: 'Google for Education',
    client: 'Google for Education / Dell Technologies',
    duration: '',
    highlights: ['education', 'my-computer', 'star'],
    hero: 'EDU-Lifestyle-4-Latitude-5430-Chromebook.jpeg',
    needsReview: ['duration'],
  },
  'product-launch-training-emea': {
    shortTitle: 'EMEA Launch Training',
    client: 'Dell Technologies',
    duration: '',
    highlights: ['my-computer', 'megaphone', 'increase'],
    hero: 'Screenshot-2025-08-26-at-18.18.29.png',
    needsReview: ['duration'],
  },
  'vashi-nedomansky-filmmaking-guide': {
    shortTitle: 'Filmmaking Guide',
    client: 'Dell Technologies',
    duration: '',
    highlights: ['movie', '4k', 'video-card'],
    hero: 'Screenshot-2025-08-26-at-15.05.53.png',
    needsReview: ['duration'],
  },
};

const rows = parse(readFileSync(CSV, 'utf8'), {
  columns: true,
  skip_empty_lines: true,
  relax_quotes: true,
});

const caseStudies = rows
  .filter((r) => r.post_type === 'case-study' && r.post_status === 'publish')
  .sort((a, b) => a.post_date.localeCompare(b.post_date));

const attachments = rows.filter((r) => r.post_type === 'attachment');

/** Map every recovered upload URL to the local path it will live at. */
const assetIndex = new Map();
for (const a of attachments) {
  const file = basename(new URL(a.guid).pathname);
  const parent = caseStudies.find((c) => c.ID === a.post_parent);
  const scope = parent ? parent.post_name : 'site';
  assetIndex.set(file, {
    localPath: `/assets/images/${scope === 'site' ? 'site' : `work/${scope}`}/${file}`,
    mime: a.post_mime_type,
    title: a.post_title,
    scope,
    originalUrl: a.guid,
  });
}

// WordPress only set post_parent for media uploaded from inside a post. Files chosen
// as a featured image elsewhere came through with parent 0, so re-scope anything the
// OVERRIDES table names as a hero onto its case study.
for (const [slug, meta] of Object.entries(OVERRIDES)) {
  const entry = assetIndex.get(meta.hero);
  if (!entry) throw new Error(`Hero "${meta.hero}" for "${slug}" is not in the attachment manifest`);
  entry.scope = slug;
  entry.localPath = `/assets/images/work/${slug}/${meta.hero}`;
}

/** Resolve any historical upload URL (.local, /wp-content/, /storage/) to a local path. */
function localiseUrl(url) {
  const file = basename(url.split('?')[0]);
  // WordPress derivative suffixes: foo-1024x573.png / foo-scaled.jpg -> foo.png
  const base = file.replace(/(?:-\d+x\d+|-scaled)+(?=\.[a-z0-9]+$)/gi, '');
  const hit = assetIndex.get(file) || assetIndex.get(base);
  if (hit) return hit.localPath;
  // Unknown file that only ever appeared inline in post_content.
  const orphan = `/assets/images/orphans/${base}`;
  assetIndex.set(base, {
    localPath: orphan,
    mime: '',
    title: base,
    scope: 'orphan',
    originalUrl: url,
  });
  return orphan;
}

/** Strip the layers of editor cruft: Gutenberg comments, classic-editor spans, inline styles. */
function cleanHtml(html) {
  return (
    html
      // Gutenberg block delimiters
      .replace(/<!--\s*\/?wp:[^>]*?-->/g, '')
      .replace(/<!--\s*more\s*-->/g, '')
      // TinyMCE bookmark spans
      .replace(/<span[^>]*mce_SELRES[^>]*>[\s\S]*?<\/span>/g, '')
      // The classic editor wrapped every sentence in font-weight:400 spans
      .replace(/<span style="font-weight:\s*400;?"[^>]*>/g, '')
      .replace(/<\/span>/g, '')
      // WP shortcode video -> real element
      .replace(
        /\[video[^\]]*mp4="([^"]+)"[^\]]*\]\s*\[\/video\]/g,
        (_m, src) =>
          `<video controls preload="none" playsinline src="${localiseUrl(src)}"></video>`,
      )
      // Presentational attributes we do not want in the new markup
      .replace(/\s(?:style|class|aria-level|width|height)="[^"]*"/g, '')
      // Images that were wrapped in <b> or a heading purely for layout
      .replace(/<(b|strong)>\s*(<img[^>]*>)\s*<\/\1>/g, '$2')
      .replace(/<h([1-6])>\s*(<img[^>]*>)\s*<\/h\1>/g, '$2')
      .replace(/<h([1-6])>\s*<\/h\1>/g, '')
      .replace(/<p>\s*<\/p>/g, '')
      .replace(/<(b|strong)>\s*<\/\1>/g, '')
  );
}

/**
 * The classic editor stored paragraphs as bare text separated by blank lines rather
 * than <p> tags. Once the font-weight spans are stripped those collapse into one
 * run-on paragraph, so re-establish the block boundaries before converting.
 */
const BLOCK_START = /^<(?:h[1-6]|ul|ol|li|p|div|figure|img|iframe|video|blockquote|table|hr|b|strong)\b/i;

function wrapBareText(html) {
  return html
    .split(/\n{2,}/)
    .map((chunk) => {
      const text = chunk.trim();
      if (!text) return '';
      return BLOCK_START.test(text) ? text : `<p>${text}</p>`;
    })
    .filter(Boolean)
    .join('\n\n');
}

const turndown = new TurndownService({
  headingStyle: 'atx',
  bulletListMarker: '-',
  codeBlockStyle: 'fenced',
  emDelimiter: '_',
});

// Headings are already styled by the template — drop bold inside them.
turndown.addRule('plainHeadings', {
  filter: ['h1', 'h2', 'h3', 'h4'],
  replacement: (content, node) =>
    `\n\n${'#'.repeat(Number(node.nodeName[1]))} ${content.replace(/\*\*/g, '').trim()}\n\n`,
});

// Keep embeds (Megaphone player, recovered video) as raw HTML, but lazily.
turndown.addRule('embeds', {
  filter: ['iframe', 'video'],
  replacement: (_content, node) => {
    if (node.nodeName === 'IFRAME') {
      const src = node.getAttribute('src') || '';
      return `\n\n<iframe class="embed" src="${src}" loading="lazy" width="100%" height="200" frameborder="0" scrolling="no" title="Podcast player"></iframe>\n\n`;
    }
    return `\n\n<video class="embed" controls preload="none" playsinline src="${node.getAttribute('src')}"></video>\n\n`;
  },
});

turndown.addRule('localImages', {
  filter: 'img',
  replacement: (_content, node) => {
    const src = localiseUrl(node.getAttribute('src') || '');
    const alt = (node.getAttribute('alt') || '').trim();
    return `\n\n![${alt}](${src})\n\n`;
  },
});

function tidyMarkdown(md) {
  return md
    .replace(/ /g, ' ')
    .replace(/[ \t]+$/gm, '')
    // Turndown pads list markers to 4 columns; plain "- " is friendlier to hand-edit.
    .replace(/^(\s*)-\s{3}/gm, '$1- ')
    .replace(/\n{3,}/g, '\n\n')
    .trim();
}

function yaml(value) {
  return `'${String(value).replace(/'/g, "''")}'`;
}

mkdirSync(resolve(ROOT, 'src/work'), { recursive: true });

const reviewNotes = [];

caseStudies.forEach((post, index) => {
  const slug = post.post_name;
  const meta = OVERRIDES[slug];
  if (!meta) throw new Error(`No OVERRIDES entry for recovered case study "${slug}"`);

  const heroPath = `/assets/images/work/${slug}/${meta.hero}`;
  const body = tidyMarkdown(turndown.turndown(wrapBareText(cleanHtml(post.post_content))))
    // The video files themselves were lost; a poster keeps the frame from rendering blank.
    .replace(/<video class="embed"/g, `<video class="embed" poster="${heroPath}"`);

  const frontmatter = [
    '---',
    `title: ${yaml(post.post_title)}`,
    `shortTitle: ${yaml(meta.shortTitle)}`,
    `excerpt: ${yaml(post.post_excerpt.trim())}`,
    `client: ${yaml(meta.client)}`,
    `duration: ${yaml(meta.duration)}`,
    `date: ${post.post_date.slice(0, 10)}`,
    `order: ${index + 1}`,
    `hero: ${yaml(heroPath)}`,
    `highlights: [${meta.highlights.join(', ')}]`,
    '---',
    '',
  ].join('\n');

  writeFileSync(resolve(ROOT, 'src/work', `${slug}.md`), `${frontmatter}${body}\n`);

  for (const field of meta.needsReview || []) {
    reviewNotes.push(`- \`${slug}.md\` → **${field}** was not in the database dump; current value is an inference.`);
  }
  console.log(`✓ src/work/${slug}.md  (${body.length} chars)`);
});

// --- Asset manifest -------------------------------------------------------
const byScope = new Map();
for (const [file, info] of assetIndex) {
  if (!byScope.has(info.scope)) byScope.set(info.scope, []);
  byScope.get(info.scope).push({ file, ...info });
}

writeFileSync(
  resolve(ROOT, 'src/_data/assets.json'),
  `${JSON.stringify(Object.fromEntries(byScope), null, 2)}\n`,
);

const doc = [
  '# Missing assets',
  '',
  'The server was lost without backups, so no image, video or PDF binary survived —',
  'only their filenames, dimensions and which case study they belonged to (recovered',
  'from the `wp_posts` dump in `dm_posts.csv`).',
  '',
  'Every path below is already wired into the site and currently shows a branded',
  'placeholder. **Drop the real file at the exact path and it appears — no code change.**',
  '',
];

for (const [scope, files] of [...byScope].sort()) {
  doc.push(`## ${scope === 'site' ? 'Site-wide' : scope === 'orphan' ? 'Referenced inline only' : `Case study: ${scope}`}`, '');
  for (const f of files.sort((a, b) => a.file.localeCompare(b.file))) {
    doc.push(`- \`${f.localPath}\`${f.mime ? ` — ${f.mime}` : ''}`);
  }
  doc.push('');
}

if (reviewNotes.length) {
  doc.push('## Metadata to confirm', '', 'These were stored in `wp_postmeta`, which the dump does not include:', '', ...reviewNotes, '');
}

writeFileSync(resolve(ROOT, 'MISSING-ASSETS.md'), `${doc.join('\n')}\n`);

console.log(`\n✓ ${caseStudies.length} case studies, ${assetIndex.size} assets catalogued`);
console.log('✓ MISSING-ASSETS.md');
