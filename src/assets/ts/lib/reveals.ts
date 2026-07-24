/**
 * Scroll-triggered reveals.
 *
 * The starting states also exist in CSS (`.fade-in` and friends are opacity: 0),
 * with `body.loaded` as the no-JS / reduced-motion escape hatch. When GSAP takes
 * an element over we tag it `.gsap-reveal` so the CSS transition stops fighting
 * the tween frame by frame.
 */

import { gsap } from 'gsap';
import { queryAll } from './env';

/** Tweens this module owns, so `forceVisible()` can undo exactly them. */
const revealTweens: gsap.core.Tween[] = [];

interface RevealGroup {
  selector: string;
  from: gsap.TweenVars;
  to: gsap.TweenVars;
  start: string;
}

const GROUPS: RevealGroup[] = [
  {
    selector: '.fade-in, [data-reveal="fade"]',
    from: { opacity: 0, y: 50 },
    to: { opacity: 1, y: 0, duration: 1, ease: 'power2.out' },
    start: 'top 85%',
  },
  {
    selector: '.scale-in, [data-reveal="scale"]',
    from: { opacity: 0, scale: 0.8 },
    to: { opacity: 1, scale: 1, duration: 0.8, ease: 'back.out(1.7)' },
    start: 'top 80%',
  },
  {
    selector: '.slide-left, [data-reveal="left"]',
    from: { opacity: 0, x: -100 },
    to: { opacity: 1, x: 0, duration: 1, ease: 'power2.out' },
    start: 'top 80%',
  },
  {
    selector: '.slide-right, [data-reveal="right"]',
    from: { opacity: 0, x: 100 },
    to: { opacity: 1, x: 0, duration: 1, ease: 'power2.out' },
    start: 'top 80%',
  },
];

export function setupReveals(enabled: boolean): void {
  // Reduced motion: `body.loaded` already puts every one of these at its final
  // state, so there is nothing to do and nothing left invisible.
  if (!enabled) return;

  GROUPS.forEach((group) => {
    queryAll<HTMLElement>(group.selector).forEach((element) => {
      element.classList.add('gsap-reveal');

      revealTweens.push(
        gsap.fromTo(element, group.from, {
          ...group.to,
          scrollTrigger: {
            trigger: element,
            start: group.start,
            toggleActions: 'play none none none',
            once: true,
          },
        }),
      );
    });
  });
}

/** Continuous quarter-turn idle animation on decorative marks. */
export function setupRotations(enabled: boolean): void {
  if (!enabled) return;

  queryAll<HTMLElement>('.animate-rotate').forEach((element) => {
    gsap.set(element, { transformOrigin: 'center center' });

    gsap
      .timeline({ repeat: -1 })
      .to(element, { rotation: '+=90', scale: 0.9, duration: 0.5, ease: 'power2.inOut' })
      .to(element, { scale: 1, duration: 3, ease: 'power2.out' });
  });
}

/**
 * Hard guarantee: nothing this module (or a half-applied tween) touched is left
 * at opacity 0. Called when animations are disabled or after a failure.
 */
export function forceVisible(): void {
  // Kill only our own triggers — ScrollSmoother owns one too and must survive.
  revealTweens.forEach((tween) => {
    tween.scrollTrigger?.kill();
    tween.kill();
  });
  revealTweens.length = 0;

  const selectors = GROUPS.map((group) => group.selector).join(', ');
  queryAll<HTMLElement>(selectors).forEach((element) => {
    element.classList.remove('gsap-reveal');
    gsap.set(element, { clearProps: 'all' });
    element.style.opacity = '1';
    element.style.transform = 'none';
  });
}
