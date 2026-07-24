# WIP

## 2026-07-22 — master — Eleventy rebuild of the lost WordPress site (COMPLETE, unreviewed)

**Context:** WP host died, no backups, damienmulhall.com gone. Rebuilt as a static
Eleventy site in `2026/`. Promote to root once Roger signs off.

**Done & verified**
- All 5 case studies recovered from `dm_posts.csv` → `2026/src/work/*.md` (clean markdown).
- Homepage copy recovered from Carbon Fields defaults → `src/_data/home.json`.
- Full template port (Nunjucks), design 1:1 with the PHP theme. Verified via screenshots.
- GSAP layer ported: ScrollSmoother/SplitText/work-hover/crow loader all kept; SPA fetch
  layer removed; reduced-motion guards; boot deferred + chunked (fixed a mobile LCP 6.4s→2.1s).
- Lighthouse: desktop 100/100/100/100 all pages; mobile 97-99 perf, 100/100/100 rest.
- Behavioural smoke test (`npm run smoke`, puppeteer) 17/17: animations, badges, fonts,
  reduced-motion, no console errors.
- Self-hosted fonts, 13 badge icons (9 real from Roger + 4 drawn), placeholders for 23
  lost images (`2026/MISSING-ASSETS.md`), DO `app.yaml`, README + FONTS.md.
- dm-cyan darkened #33a199→#226d68 for WCAG AA (only deliberate design change).

**Not done (deliberately)**
- Nothing committed. `2026/` is 101 untracked files.
- Real images/CV still placeholders (originals lost — Damien supplies).
- Fonts are Adobe-served originals, not a bought webfont licence (see FONTS.md).
- Root still holds the old WP theme — promotion is a separate post-approval step.

**Review round 1 (2026-07-24) — done**
- Removed stray underlines from nav links + buttons (kept on footer + prose only).
- Built the mobile menu (hamburger had markup but no JS — was part of the removed SPA layer).
- Case-study back link: "Back to All Work", added top margin, no underline.
- Crow: repurposed from AJAX loading-overlay → deliberate intro splash. 1.5s hold,
  first-visit-per-session (sessionStorage), homepage-only (protects deep-page LCP),
  tap-to-dismiss, skipped under reduced-motion. Bumped opacity 0.1→1, size→280px.
  Clean serialized Lighthouse: desktop 100 all; mobile 99 home (LCP 1.9s w/ splash) + 99 elsewhere.
  Note: lighthouse.mjs run-of-6 gives noisy numbers under CPU contention — measure serialized.

**Next step**
Roger reviews `2026/` (run `cd 2026 && npm start`). On approval: commit, then promote
2026/ → root and delete the WP theme files.
