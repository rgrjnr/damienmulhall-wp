// GSAP Animation Setup
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger, SplitText);

// Animation class for managing theme animations
class ThemeAnimations {
  private animations: Map<string, gsap.core.Timeline> = new Map();

  constructor() {
    this.init();
  }

  private init(): void {
    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.setupAnimations());
    } else {
      this.setupAnimations();
    }
  }

  private setupAnimations(): void {
    // Add loaded class to body
    document.body.classList.add('loaded');

    // Initialize different animation types
    this.setupTextAnimations();
    this.setupScrollAnimations();
    this.setupPageTransitions();
    this.setupInteractiveAnimations();

    // Refresh ScrollTrigger after all animations are set up
    ScrollTrigger.refresh();
  }

  // Text animations using SplitText
  private setupTextAnimations(): void {
    // Animate headings on scroll
    const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
    headings.forEach((heading) => {
      if (heading.textContent) {
        const split = new SplitText(heading, { type: 'chars, words' });

        gsap.from(split.chars, {
          duration: 0.8,
          y: 50,
          opacity: 0,
          stagger: 0.02,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: heading,
            start: 'top 80%',
            end: 'bottom 20%',
            toggleActions: 'play none none reverse',
          },
        });
      }
    });

    // Animate paragraphs
    const paragraphs = document.querySelectorAll('p');
    paragraphs.forEach((paragraph) => {
      if (paragraph.textContent) {
        const split = new SplitText(paragraph, { type: 'lines' });

        gsap.from(split.lines, {
          duration: 1,
          y: 30,
          opacity: 0,
          stagger: 0.1,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: paragraph,
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play none none reverse',
          },
        });
      }
    });
  }

  // Scroll-triggered animations
  private setupScrollAnimations(): void {
    // Fade in elements on scroll
    const fadeElements = document.querySelectorAll('.fade-in, .wp-block-image, .wp-block-gallery');
    fadeElements.forEach((element) => {
      gsap.fromTo(
        element,
        {
          opacity: 0,
          y: 50,
        },
        {
          opacity: 1,
          y: 0,
          duration: 1,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: element,
            start: 'top 85%',
            end: 'bottom 15%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    });

    // Scale in elements
    const scaleElements = document.querySelectorAll('.scale-in, .wp-block-button');
    scaleElements.forEach((element) => {
      gsap.fromTo(
        element,
        {
          scale: 0.8,
          opacity: 0,
        },
        {
          scale: 1,
          opacity: 1,
          duration: 0.8,
          ease: 'back.out(1.7)',
          scrollTrigger: {
            trigger: element,
            start: 'top 80%',
            end: 'bottom 20%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    });

    // Slide in from left/right
    const slideElements = document.querySelectorAll('.slide-left, .slide-right');
    slideElements.forEach((element) => {
      const direction = element.classList.contains('slide-left') ? -100 : 100;

      gsap.fromTo(
        element,
        {
          x: direction,
          opacity: 0,
        },
        {
          x: 0,
          opacity: 1,
          duration: 1,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: element,
            start: 'top 80%',
            end: 'bottom 20%',
            toggleActions: 'play none none reverse',
          },
        }
      );
    });
  }

  // Page transition animations
  private setupPageTransitions(): void {
    // Smooth page transitions
    const links = document.querySelectorAll(
      'a[href]:not([href^="#"]):not([href^="mailto:"]):not([href^="tel:"])'
    );

    links.forEach((link) => {
      link.addEventListener('click', (e) => {
        const target = e.target as HTMLAnchorElement;
        const url = target.href;

        // Only handle internal links
        if (url && url.includes(window.location.host)) {
          e.preventDefault();

          // Fade out animation
          gsap.to('body', {
            opacity: 0,
            duration: 0.3,
            ease: 'power2.inOut',
            onComplete: () => {
              window.location.href = url;
            },
          });
        }
      });
    });

    // Page load animation
    gsap.fromTo(
      'body',
      { opacity: 0 },
      {
        opacity: 1,
        duration: 0.5,
        ease: 'power2.out',
        onComplete: () => {
          document.body.classList.add('page-loaded');
        },
      }
    );
  }

  // Interactive animations
  private setupInteractiveAnimations(): void {
    // Button hover animations
    const buttons = document.querySelectorAll('button, .wp-block-button__link, .btn');
    buttons.forEach((button) => {
      button.addEventListener('mouseenter', () => {
        gsap.to(button, {
          scale: 1.05,
          duration: 0.2,
          ease: 'power2.out',
        });
      });

      button.addEventListener('mouseleave', () => {
        gsap.to(button, {
          scale: 1,
          duration: 0.2,
          ease: 'power2.out',
        });
      });
    });

    // Image hover effects
    const images = document.querySelectorAll('.wp-block-image img, .gallery-item img');
    images.forEach((image) => {
      image.addEventListener('mouseenter', () => {
        gsap.to(image, {
          scale: 1.05,
          duration: 0.3,
          ease: 'power2.out',
        });
      });

      image.addEventListener('mouseleave', () => {
        gsap.to(image, {
          scale: 1,
          duration: 0.3,
          ease: 'power2.out',
        });
      });
    });
  }

  // Public methods for custom animations
  public animateElement(
    selector: string,
    animation: gsap.TweenVars,
    scrollTrigger?: ScrollTrigger.Vars
  ): gsap.core.Tween | null {
    const element = document.querySelector(selector);
    if (!element) {
      console.warn(`Element with selector "${selector}" not found`);
      return null;
    }

    return gsap.fromTo(
      element,
      { opacity: 0, y: 30 },
      {
        ...animation,
        scrollTrigger: scrollTrigger
          ? {
              trigger: element,
              start: 'top 80%',
              end: 'bottom 20%',
              toggleActions: 'play none none reverse',
              ...scrollTrigger,
            }
          : undefined,
      }
    );
  }

  public createTimeline(name: string): gsap.core.Timeline {
    const timeline = gsap.timeline();
    this.animations.set(name, timeline);
    return timeline;
  }

  public getTimeline(name: string): gsap.core.Timeline | undefined {
    return this.animations.get(name);
  }

  public killAnimation(name: string): void {
    const timeline = this.animations.get(name);
    if (timeline) {
      timeline.kill();
      this.animations.delete(name);
    }
  }

  // Utility method to refresh ScrollTrigger
  public refresh(): void {
    ScrollTrigger.refresh();
  }
}

// Extend Window interface to include themeAnimations
declare global {
  interface Window {
    themeAnimations: ThemeAnimations;
  }
}

// Initialize animations when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  // Create global animation instance
  window.themeAnimations = new ThemeAnimations();
});

// Export for use in other modules
export { ThemeAnimations };

// Add GSAP to window for debugging
if (typeof window !== 'undefined') {
  (window as any).gsap = gsap;
  (window as any).ScrollTrigger = ScrollTrigger;
  (window as any).SplitText = SplitText;
}
