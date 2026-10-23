/**
 * Scroll-triggered reveals.
 *
 * The starting states also exist in CSS (`.fade-in` and friends are opacity: 0),
 * with `body.loaded` as the no-JS escape hatch. When GSAP takes an element over
 * we tag it `.gsap-reveal` so the CSS transition stops fighting the tween frame
 * by frame.
 *
 * `gentle` is the reduced-motion version: the same reveals as a plain fade,
 * with no travel or scaling.
 */

import { gsap } from 'gsap';
import { MOTION, queryAll } from './env';

export type RevealMode = 'full' | 'gentle';

/** Tweens this module owns, so `forceVisible()` can undo exactly them. */
const revealTweens: gsap.core.Tween[] = [];

interface RevealGroup {
  selector: string;
  from: gsap.TweenVars;
}

const GROUPS: RevealGroup[] = [
  { selector: '.fade-in, [data-reveal="fade"]', from: { y: 24 } },
  { selector: '.scale-in, [data-reveal="scale"]', from: { scale: 0.95 } },
  { selector: '.slide-left, [data-reveal="left"]', from: { x: -40 } },
  { selector: '.slide-right, [data-reveal="right"]', from: { x: 40 } },
];

export function setupReveals(mode: RevealMode): void {
  GROUPS.forEach((group) => {
    const from: gsap.TweenVars = mode === 'full' ? { opacity: 0, ...group.from } : { opacity: 0 };

    queryAll<HTMLElement>(group.selector).forEach((element) => {
      element.classList.add('gsap-reveal');

      revealTweens.push(
        gsap.fromTo(element, from, {
          opacity: 1,
          x: 0,
          y: 0,
          scale: 1,
          duration: mode === 'full' ? MOTION.reveal : 0.4,
          ease: MOTION.ease,
          scrollTrigger: {
            trigger: element,
            start: 'top 85%',
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
      .to(element, { rotation: '+=90', scale: 0.9, duration: 0.5, ease: MOTION.easeInOut })
      .to(element, { scale: 1, duration: 3, ease: MOTION.ease });
  });
}

/**
 * Hard guarantee: nothing this module (or a half-applied tween) touched is left
 * at opacity 0. Called when animations are disabled or after a failure.
 */
export function forceVisible(): void {
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

  queryAll<HTMLElement>('.scribble').forEach((element) => element.classList.add('is-drawn'));
}
