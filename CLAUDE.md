# CLAUDE.md

Guidance for Claude Code working in this repository.

## What this is

The personal site for **Damien Mulhall**, a creative project manager. It is a
**static [Eleventy](https://www.11ty.dev/) site**, deployed to DigitalOcean App
Platform. Damien edits content by committing markdown; a push rebuilds and
redeploys.

It was rebuilt from a lost WordPress theme — the original host died with no
backups. Content was recovered from a `wp_posts` database dump (`dm_posts.csv`);
see `MISSING-ASSETS.md` for what did not survive.

## Commands

```bash
npm install
npm start          # dev server at localhost:8080, live reload
npm run build      # production build into _site/
npm run smoke      # headless-browser behavioural test (animations, menu, a11y)
npm run lighthouse # build, serve, audit every page (run serialized; see note)
```

Note: `npm run lighthouse` fires six audits back-to-back and gives noisy numbers
under CPU contention. For a trustworthy reading, audit one page at a time.

## Architecture

- **Eleventy 3 + Nunjucks.** Input `src/`, output `_site/`, config in
  `eleventy.config.mjs` (responsive-image shortcode, collections, RSS).
- **Content is data, not code:**
  - `src/_data/site.json` — site-wide details (name, description, social).
  - `src/_data/home.json` — all homepage copy.
  - `src/_data/badgeStyles.json` — highlight badge colours + icons.
  - `src/work/*.md` — one file per case study (frontmatter + markdown body).
- **Assets:** Sass → Tailwind → PostCSS (`tools/build-css.mjs`) and esbuild for
  TypeScript (`tools/build-js.mjs`). Tailwind design tokens in `tailwind.config.js`.
- **Animations:** GSAP (ScrollSmoother, SplitText, work-item hover) in
  `src/assets/ts/`. Boot is deferred + chunked to protect LCP, and every step is
  guarded for reduced-motion. The crow overlay is a homepage-only, once-per-session
  intro splash.
- **Fonts:** self-hosted Neue Haas Grotesk in `src/assets/fonts/`. See `FONTS.md`
  for the licensing situation before going live on a custom domain.

## Conventions

- **Adding a case study:** new `src/work/<slug>.md` with the frontmatter shown in
  `README.md`; images go in `src/assets/images/work/<slug>/`. `order` sets its
  position; `highlights` picks badges from `badgeStyles.json`.
- **Design fidelity matters** — this is a faithful rebuild. Preserve the Tailwind
  class strings and the brand palette. The one deliberate deviation from the
  original is `dm-cyan` (`#226d68`), darkened to meet WCAG AA contrast.
- **Missing images** show branded placeholders; drop the real file at the exact
  path in `MISSING-ASSETS.md` to replace one, no code change needed.

## Deploy

`.do/app.yaml` defines the DigitalOcean App Platform static site (`npm run build`
→ `_site`). Fill in the GitHub `repo:` field before first deploy.
