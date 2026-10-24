/**
 * The career path in the about panel draws in as it scrolls into view: the
 * rule sweeps across, then each year lands in turn. Without this script (or with
 * reduced motion) the path is simply there.
 */

import { gsap } from 'gsap';
import { query, queryAll } from './env';

export function setupCareer(enabled: boolean): void {
  if (!enabled) return;

  const career = query<HTMLElement>('[data-career]');
  if (!career) return;
  const steps = queryAll<HTMLElement>('.career__step', career);

  const timeline = gsap.timeline({
    scrollTrigger: { trigger: career, start: 'top 85%', once: true },
  });
  timeline.fromTo(career, { '--career-rule': 0 }, { '--career-rule': 1, duration: 0.8, ease: 'power2.out' });
  timeline.fromTo(
    steps,
    { autoAlpha: 0, y: 14 },
    { autoAlpha: 1, y: 0, duration: 0.5, ease: 'power2.out', stagger: 0.12 },
    0.25,
  );
}
