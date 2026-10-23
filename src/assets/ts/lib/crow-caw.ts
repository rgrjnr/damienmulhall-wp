/**
 * Hover a crow and it caws. The caw is the beak-open stretch of the intro
 * splash video, drawn into a canvas laid exactly over the SVG crow and recoloured
 * to that crow's own fill, so the dark header crow and the cream about-panel crow
 * each caw in their own colours. Mouse and trackpad only; reduced motion skips it.
 *
 * Markup: `[data-crow-caw]` is the hover target and contains one `[data-crow]`
 * path. `data-crow-caw="flip"` mirrors the video for a crow facing left.
 */

import { hasFinePointer, queryAll } from './env';

const VIDEO_SRC = '/assets/images/site/loading.mp4';

// The caw window in the video: the beak opens just after 0.3s and has closed
// again by 1.5s, after which the head turns away (which the SVG can't match).
const CAW_START = 0.3;
const CAW_END = 1.5;

// The crow's bounding box in the 720px video frame, measured from the
// closed-beak frames. It lines up with the SVG path's own bounding box.
const BIRD = { x: 85, y: 153, w: 550, h: 416 };
// Source region drawn to the canvas: the bird plus room for the open beak.
const SRC = { x: 60, y: 120, w: 620, h: 470 };

let video: HTMLVideoElement | null = null;
let busy = false;

function getVideo(): HTMLVideoElement {
  if (video) return video;
  video = document.createElement('video');
  video.muted = true;
  video.playsInline = true;
  video.preload = 'auto';
  video.src = VIDEO_SRC;
  video.setAttribute('aria-hidden', 'true');
  // Safari only decodes frames for a video that's in the document and not
  // display:none, so it sits off to the side at 1px instead.
  Object.assign(video.style, {
    position: 'fixed', left: '0', top: '0', width: '1px', height: '1px',
    opacity: '0', pointerEvents: 'none',
  });
  document.body.appendChild(video);
  return video;
}

function parseRgb(value: string): [number, number, number] {
  const [r = 0, g = 0, b = 0] = (value.match(/\d+(\.\d+)?/g) ?? []).map(Number);
  return [r, g, b];
}

function caw(target: HTMLElement, crow: SVGGraphicsElement): void {
  if (busy) return;
  const vid = getVideo();
  if (vid.readyState < 2) return;
  busy = true;

  const flip = target.dataset.crowCaw === 'flip';
  const [r, g, b] = parseRgb(getComputedStyle(crow).fill);

  const bird = crow.getBoundingClientRect();
  const box = target.getBoundingClientRect();
  const scale = bird.width / BIRD.w;
  const cssW = SRC.w * scale;
  const cssH = SRC.h * scale;
  const left = flip
    ? bird.right - (SRC.x + SRC.w - BIRD.x) * scale - box.left
    : bird.left + (SRC.x - BIRD.x) * scale - box.left;
  const top = bird.top + (SRC.y - BIRD.y) * scale - box.top;

  const dpr = Math.min(window.devicePixelRatio || 1, 2);
  const canvas = document.createElement('canvas');
  canvas.className = 'crow-caw__canvas';
  canvas.width = Math.round(cssW * dpr);
  canvas.height = Math.round(cssH * dpr);
  Object.assign(canvas.style, {
    left: `${left}px`, top: `${top}px`, width: `${cssW}px`, height: `${cssH}px`,
    transform: flip ? 'scaleX(-1)' : '',
  });
  const ctx = canvas.getContext('2d', { willReadFrequently: true });
  if (!ctx) {
    busy = false;
    return;
  }

  let shown = false;
  const draw = (): void => {
    ctx.drawImage(vid, SRC.x, SRC.y, SRC.w, SRC.h, 0, 0, canvas.width, canvas.height);
    const frame = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const px = frame.data;
    // Black crow on white becomes the crow's own colour on transparent; the
    // ramp keeps anti-aliased edges soft and drops the video's faint grain.
    for (let i = 0; i < px.length; i += 4) {
      const lum = (px[i]! + px[i + 1]! + px[i + 2]!) / 3;
      px[i] = r;
      px[i + 1] = g;
      px[i + 2] = b;
      px[i + 3] = Math.max(0, Math.min(255, (200 - lum) * 2));
    }
    ctx.putImageData(frame, 0, 0);
    if (!shown) {
      shown = true;
      target.appendChild(canvas);
      crow.style.visibility = 'hidden';
    }
  };

  const finish = (): void => {
    vid.pause();
    crow.style.visibility = '';
    canvas.remove();
    busy = false;
  };

  const tick = (): void => {
    if (vid.currentTime >= CAW_END || vid.ended) {
      finish();
      return;
    }
    if (vid.currentTime >= CAW_START) draw();
    requestAnimationFrame(tick);
  };

  vid.currentTime = CAW_START;
  vid.play().then(() => requestAnimationFrame(tick), finish);
}

export function setupCrowCaw(enabled: boolean): void {
  if (!enabled || !hasFinePointer()) return;
  const targets = queryAll<HTMLElement>('[data-crow-caw]');
  if (!targets.length) return;

  // Same file as the intro splash, so usually already cached. Fetch it once the
  // page has settled so the first hover doesn't wait on the network.
  window.setTimeout(getVideo, 1500);

  targets.forEach((target) => {
    const crow = target.querySelector<SVGGraphicsElement>('[data-crow]');
    if (!crow) return;
    target.addEventListener('pointerenter', () => caw(target, crow));
  });
}
