# Missing assets

The server was lost without backups, so no image, video or PDF binary survived —
only their filenames, dimensions and which case study they belonged to (recovered
from the `wp_posts` dump in `dm_posts.csv`).

Every path below is already wired into the site and currently shows a branded
placeholder. **Drop the real file at the exact path and it appears — no code change.**

## Case study: dell-podcast

- `/assets/images/work/dell-podcast/3966-DEL-SD-Podcast-Series-for-DTF-Podcast-trailer-3-17May2024.mp4` — video/mp4
- `/assets/images/work/dell-podcast/3966-DEL-SD-Podcast-Series-for-DTF-Podcast-trailer-3v2-14May2024.mp4` — video/mp4
- `/assets/images/work/dell-podcast/3966-DEL-SD-Podcast-Series-for-DTF-Podcast-trailer-Poster-frame-1.jpg` — image/jpeg
- `/assets/images/work/dell-podcast/Vector.svg` — image/svg+xml

## Case study: google-education

- `/assets/images/work/google-education/3884-DELL-Chrome-Educators-eGuide-FY24-03Nov2023-stu-1.pdf` — application/pdf
- `/assets/images/work/google-education/EDU-Lifestyle-1-Latitude-3445-Chromebook.jpeg` — image/jpeg
- `/assets/images/work/google-education/EDU-Lifestyle-2-Latitude-3445-Chromebook.jpeg` — image/jpeg
- `/assets/images/work/google-education/EDU-Lifestyle-3-Latitude-5430-Chromebook.jpeg` — image/jpeg
- `/assets/images/work/google-education/EDU-Lifestyle-4-Latitude-5430-Chromebook.jpeg` — image/jpeg

## Case study: product-launch-training-emea

- `/assets/images/work/product-launch-training-emea/4140-Dell-FM-Reboot-FY25-Landscape-05Feb2024.mp4` — video/mp4
- `/assets/images/work/product-launch-training-emea/Screenshot-2025-08-26-at-18.18.29.png` — image/png
- `/assets/images/work/product-launch-training-emea/Screenshot-2025-08-26-at-18.19.21-1.png` — image/png
- `/assets/images/work/product-launch-training-emea/Screenshot-2025-08-26-at-18.19.21.png` — image/png

## Site-wide

- `/assets/images/site/cropped-favicon.png` — image/png
- `/assets/images/site/Damien_Mulhall_CV.pdf` — application/pdf
- `/assets/images/site/favicon-1.png` — image/png
- `/assets/images/site/favicon.png` — image/png
- `/assets/images/site/icons8-4k.svg` — image/svg+xml
- `/assets/images/site/icons8-code.svg` — image/svg+xml
- `/assets/images/site/icons8-education.svg` — image/svg+xml
- `/assets/images/site/icons8-heart.svg` — image/svg+xml
- `/assets/images/site/icons8-increase.svg` — image/svg+xml
- `/assets/images/site/icons8-instagram.svg` — image/svg+xml
- `/assets/images/site/icons8-megaphone.svg` — image/svg+xml
- `/assets/images/site/icons8-mic.svg` — image/svg+xml
- `/assets/images/site/icons8-movie.svg` — image/svg+xml
- `/assets/images/site/icons8-my-computer.svg` — image/svg+xml
- `/assets/images/site/icons8-spotify.svg` — image/svg+xml
- `/assets/images/site/icons8-star.svg` — image/svg+xml
- `/assets/images/site/icons8-video-card.svg` — image/svg+xml
- `/assets/images/site/Layer_1-1.png` — image/png
- `/assets/images/site/Layer_1.png` — image/png
- `/assets/images/site/logo.png` — image/png
- `/assets/images/site/og.png` — image/png

## Case study: vashi-nedomansky-filmmaking-guide

- `/assets/images/work/vashi-nedomansky-filmmaking-guide/drive-download-20250815T153935Z-1-001.zip` — application/zip
- `/assets/images/work/vashi-nedomansky-filmmaking-guide/Screenshot-2025-08-26-at-15.02.49.png` — image/png
- `/assets/images/work/vashi-nedomansky-filmmaking-guide/Screenshot-2025-08-26-at-15.03.17.png` — image/png
- `/assets/images/work/vashi-nedomansky-filmmaking-guide/Screenshot-2025-08-26-at-15.04.12.png` — image/png
- `/assets/images/work/vashi-nedomansky-filmmaking-guide/Screenshot-2025-08-26-at-15.05.53.png` — image/png

## Case study: windows-11-community-events

- `/assets/images/work/windows-11-community-events/4275-LinkedIn-1080x1080-posts2.jpg` — image/jpeg
- `/assets/images/work/windows-11-community-events/IMG-20241015-WA0003.jpg` — image/jpeg
- `/assets/images/work/windows-11-community-events/IMG-20241015-WA0007.jpg` — image/jpeg
- `/assets/images/work/windows-11-community-events/IMG-20241015-WA0046.jpg` — image/jpeg

## Metadata to confirm

These were stored in `wp_postmeta`, which the dump does not include:

- `dell-podcast.md` → **duration** was not in the database dump; current value is an inference.
- `windows-11-community-events.md` → **client** was not in the database dump; current value is an inference.
- `google-education.md` → **duration** was not in the database dump; current value is an inference.
- `product-launch-training-emea.md` → **duration** was not in the database dump; current value is an inference.
- `vashi-nedomansky-filmmaking-guide.md` → **duration** was not in the database dump; current value is an inference.

