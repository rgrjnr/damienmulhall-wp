// GSAP Animation Setup
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';
import { ScrollSmoother } from 'gsap/ScrollSmoother';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger, SplitText, ScrollSmoother);

// Animation class for managing theme animations
class ThemeAnimations {
  private animations: Map<string, gsap.core.Timeline> = new Map();
  private smoother: ScrollSmoother | null = null;
  private crowLoader: HTMLElement | null = null;
  private crowVideo: HTMLVideoElement | null = null;

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

    // Initialize smooth scrolling
    this.setupSmoothScroll();

    // Initialize different animation types
    this.setupTextAnimations();
    this.setupScrollAnimations();
    this.setupPageTransitions();
    this.setupInteractiveAnimations();
    this.setupPopstateHandler();

    // Handle initial anchor link if present in URL
    this.handleInitialAnchorLink();

    // Refresh ScrollTrigger after all animations are set up
    ScrollTrigger.refresh();
  }

  // Setup smooth scrolling with ScrollSmoother
  private setupSmoothScroll(): void {
    // Check if ScrollSmoother is available
    if (typeof ScrollSmoother !== 'undefined') {
      // Create smooth scroller
      this.smoother = ScrollSmoother.create({
        wrapper: '#smooth-wrapper',
        content: '#smooth-content',
        smooth: 1.5,
        effects: true,
        normalizeScroll: true,
        smoothTouch: 0.1,
        ignoreMobileResize: true,
      });

      // Add smooth scroll to window for debugging
      (window as any).smoother = this.smoother;
    } else {
      // Fallback to CSS smooth scroll
      this.setupCSSSmoothScroll();
    }
  }

  // Fallback CSS smooth scroll
  private setupCSSSmoothScroll(): void {
    // Add smooth scroll behavior to html element
    document.documentElement.style.scrollBehavior = 'smooth';
  }

  // Setup smooth scrolling for anchor links
  private setupSmoothAnchorLinks(): void {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');

    anchorLinks.forEach((link) => {
      link.addEventListener('click', (e) => {
        const target = e.target as HTMLAnchorElement;
        const href = target.getAttribute('href');

        if (href && href !== '#') {
          e.preventDefault();
          const targetElement = document.querySelector(href);

          if (targetElement) {
            if (this.smoother) {
              // Use ScrollSmoother for smooth scrolling
              this.smoother.scrollTo(targetElement, true, 'top');
            } else {
              // Fallback to native smooth scroll
              targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
              });
            }
          }
        }
      });
    });
  }

  // Text animations using SplitText
  private setupTextAnimations(): void {
    // Animate headings on scroll
    const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
    headings.forEach((heading) => {
      if (heading.textContent) {
        const split = new SplitText(heading, { type: 'lines, words' });

        // Add overflow hidden to each line
        split.lines.forEach((line) => {
          const lineElement = line as HTMLElement;
          lineElement.style.overflow = 'hidden';
          lineElement.classList.add('split-line');
        });

        gsap.from(split.words, {
          duration: 0.8,
          y: '100%',
          stagger: 0.1,
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
        const split = new SplitText(paragraph, { type: 'words' });

        gsap.fromTo(
          split.words,
          {
            opacity: 0.5,
          },
          {
            opacity: 1,
            duration: 1,
            ease: 'power2.out',
            stagger: 0.2,
            scrollTrigger: {
              trigger: paragraph,
              start: 'top 85%',
              end: 'bottom 40%',
              scrub: true,
            },
          }
        );
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
    // Initialize crow loader elements
    this.crowLoader = document.getElementById('crow-loader') as HTMLElement;
    this.crowVideo = document.getElementById('crow-video') as HTMLVideoElement;

    // Setup link listeners
    this.attachLinkListeners();

    // Initial page load animation
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

  // Attach listeners to all internal links
  private attachLinkListeners(): void {
    // Handle regular internal links for AJAX transitions
    const links = document.querySelectorAll(
      'a[href]:not([href^="#"]):not([href^="mailto:"]):not([href^="tel:"]):not([target="_blank"])'
    );

    links.forEach((link) => {
      link.addEventListener('click', (e) => this.handleLinkClick(e));
    });

    // Handle anchor links for smooth scrolling
    this.setupSmoothAnchorLinks();
  }

  // Handle internal link clicks with AJAX
  private handleLinkClick(e: Event): void {
    const target = e.currentTarget as HTMLAnchorElement;
    const url = target.href;
    const href = target.getAttribute('href');

    // Double-check: don't handle anchor links (they should be handled by setupSmoothAnchorLinks)
    if (href && href.startsWith('#')) {
      return;
    }

    // Only handle internal links
    if (url && url.includes(window.location.host) && !target.classList.contains('no-ajax')) {
      e.preventDefault();
      this.loadPage(url);
    }
  }

  // Load page via AJAX
  private async loadPage(url: string): Promise<void> {
    // Extra safeguard: don't show crow loader for anchor links
    if (url.includes('#')) {
      console.warn('Attempted to load anchor link via AJAX, this should not happen');
      return;
    }

    // Show crow loader immediately
    this.showCrowLoader();

    try {
      // Fetch the new page
      const response = await fetch(url);
      if (!response.ok) throw new Error('Failed to fetch page');

      const html = await response.text();

      // Parse the HTML
      const parser = new DOMParser();
      const newDoc = parser.parseFromString(html, 'text/html');

      // Get the main content areas to replace
      const newContent =
        newDoc.querySelector('#smooth-content') || newDoc.querySelector('main') || newDoc.body;
      const currentContent =
        document.querySelector('#smooth-content') ||
        document.querySelector('main') ||
        document.body;

      // Get new title
      const newTitle = newDoc.querySelector('title')?.textContent || '';

      // Fade out current content
      await gsap.to(currentContent, {
        opacity: 0,
        duration: 0.3,
        ease: 'power2.inOut',
      });

      // Replace content
      if (currentContent && newContent) {
        currentContent.innerHTML = newContent.innerHTML;
      }

      // Update page title
      if (newTitle) {
        document.title = newTitle;
      }

      // Update URL in browser
      window.history.pushState({}, '', url);

      // Scroll to top instantly (no animation)
      if (this.smoother) {
        // If using ScrollSmoother, jump to top instantly
        this.smoother.scrollTo(0, false);
      } else {
        // Otherwise use native instant scroll
        window.scrollTo(0, 0);
      }

      // Reinitialize components
      this.reinitializeAfterLoad();

      // Fade in new content
      await gsap.fromTo(
        currentContent,
        { opacity: 0 },
        {
          opacity: 1,
          duration: 0.5,
          ease: 'power2.out',
        }
      );

      // Hide loader after content is visible
      this.hideCrowLoader();
    } catch (error) {
      console.error('Error loading page:', error);
      // Fallback to normal navigation if AJAX fails
      this.hideCrowLoader();
      window.location.href = url;
    }
  }

  // Reinitialize components after AJAX load
  private reinitializeAfterLoad(): void {
    // Re-attach link listeners (this includes anchor links)
    this.attachLinkListeners();

    // Reinitialize animations for new content
    this.setupTextAnimations();
    this.setupScrollAnimations();
    this.setupInteractiveAnimations();

    // Refresh ScrollTrigger
    ScrollTrigger.refresh();

    // If smooth scroll is enabled, update it
    if (this.smoother) {
      this.smoother.content('#smooth-content');
      this.smoother.refresh();
    }

    // Handle any anchor links in the URL after AJAX load
    this.handleInitialAnchorLink();
  }

  // Handle browser back/forward buttons
  private setupPopstateHandler(): void {
    window.addEventListener('popstate', () => {
      this.loadPage(window.location.href);
    });
  }

  // Handle initial anchor link in URL (for direct links to sections)
  private handleInitialAnchorLink(): void {
    const hash = window.location.hash;
    if (hash) {
      // Small delay to ensure content is fully loaded
      window.setTimeout(() => {
        const targetElement = document.querySelector(hash);
        if (targetElement) {
          if (this.smoother) {
            this.smoother.scrollTo(targetElement, true, 'top');
          } else {
            targetElement.scrollIntoView({
              behavior: 'smooth',
              block: 'start',
            });
          }
        }
      }, 100);
    }
  }

  // Crow loader methods
  private showCrowLoader(): void {
    if (this.crowLoader && this.crowVideo) {
      this.crowLoader.classList.add('active');
      this.crowVideo.play().catch((e) => console.log('Video autoplay prevented:', e));
    }
  }

  private hideCrowLoader(): void {
    if (this.crowLoader) {
      this.crowLoader.classList.remove('active');
    }
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

    // Continuous rotation animation for .animate-rotate elements
    this.setupRotateAnimations();

    // Work item hover animations
    this.setupWorkItemAnimations();
  }

  // Continuous rotation animation for .animate-rotate elements
  private setupRotateAnimations(): void {
    const rotateElements = document.querySelectorAll('.animate-rotate');

    rotateElements.forEach((element) => {
      // Set transform origin to center for proper rotation
      gsap.set(element, {
        transformOrigin: 'center center',
      });

      // Create timeline for 90deg rotation with pause
      const tl = gsap.timeline({ repeat: -1 });

      tl.to(element, {
        rotation: '+=90',
        scale: 0.9,
        duration: 0.5,
        ease: 'power2.inOut',
      }).to(element, {
        scale: 1,
        duration: 3,
        ease: 'power2.out',
      }); // Scale back to 1 during pause
    });
  }

  // Work item hover animations
  private setupWorkItemAnimations(): void {
    const workItems = document.querySelectorAll('.work-item');

    console.log(`Found ${workItems.length} work items for animation setup`);

    workItems.forEach((item, index) => {
      const background = item.querySelector('.work-background') as HTMLElement;
      const title = item.querySelector('.work-title') as HTMLElement;
      const titleDuplicate = item.querySelector('.work-title-duplicate') as HTMLElement;
      const highlights = item.querySelectorAll('.work-highlights > div > div'); // Target the highlight circles
      const arrow = item.querySelector('.work-arrow') as HTMLElement;
      const arrowPaths = item.querySelectorAll('.arrow-path') as NodeListOf<SVGPathElement>;

      console.log(`Work item ${index + 1}:`, {
        background: !!background,
        title: !!title,
        titleDuplicate: !!titleDuplicate,
        highlightsCount: highlights.length,
        arrow: !!arrow,
        arrowPathsCount: arrowPaths.length,
      });

      if (!background || !title || !titleDuplicate) {
        console.warn(`Missing required elements for work item ${index + 1}`);
        return;
      }

      // Get item dimensions for calculations
      const itemRect = item.getBoundingClientRect();
      const itemHeight = itemRect.height;

      // Create timeline for this item
      const tl = gsap.timeline({ paused: true });

      // Store mouse entry position
      let mouseEntryY = 0;

      item.addEventListener('mouseenter', (e) => {
        const rect = item.getBoundingClientRect();
        mouseEntryY = (e as MouseEvent).clientY - rect.top;

        // Determine if mouse entered from top or bottom
        const isFromTop = mouseEntryY < rect.height / 2;

        console.log(`Mouse entered work item ${index + 1} from ${isFromTop ? 'top' : 'bottom'}`);

        // Reset animations
        gsap.set([title, titleDuplicate], { clearProps: 'all' });
        gsap.set(background, { scaleY: 0 });
        gsap.set(arrowPaths, { strokeDashoffset: 100 });

        // Set background origin based on entry point
        gsap.set(background, {
          transformOrigin: isFromTop ? 'top' : 'bottom',
          scaleY: 0,
        });

        // Animate background growing
        tl.to(
          background,
          {
            scaleY: 1,
            duration: 0.5,
            ease: 'expo.inOut',
          },
          0
        );

        // Animate original title moving outside frame to bottom
        tl.to(
          title,
          {
            y: itemHeight,
            duration: 0.5,
            ease: 'expo.inOut',
          },
          0
        );

        // Animate duplicate title from outside top to original position + 1em right
        gsap.set(titleDuplicate, {
          y: -itemHeight,
          opacity: 1,
        });

        tl.to(
          titleDuplicate,
          {
            y: 0,
            // Removed x animation - title stays at 1em offset
            duration: 0.5,
            ease: 'expo.inOut',
          },
          0
        );

        // Animate arrow appearance and stroke drawing
        if (arrow && arrowPaths.length > 0) {
          tl.to(
            arrowPaths,
            {
              strokeDashoffset: 0,
              duration: 0.4,
              ease: 'power2.out',
            },
            0.3
          );
        }

        // Animate highlights with stagger effect (only position, not color)
        if (highlights.length > 0) {
          tl.to(
            highlights,
            {
              y: itemHeight,
              duration: 0.2, // Same duration as other animations
              ease: 'power2.inOut',
              stagger: 0.05, // Add stagger effect back
            },
            0
          );
        }

        tl.play();
      });

      item.addEventListener('mouseleave', () => {
        console.log(`Mouse left work item ${index + 1}`);
        // Reverse the animation with same duration
        tl.reverse();
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

  // Smooth scroll methods
  public scrollTo(
    target: string | Element,
    _options?: { offset?: number; duration?: number }
  ): void {
    if (this.smoother) {
      // Use ScrollSmoother
      const element = typeof target === 'string' ? document.querySelector(target) : target;
      if (element) {
        this.smoother.scrollTo(element);
      }
    } else {
      // Fallback to native smooth scroll
      const element = typeof target === 'string' ? document.querySelector(target) : target;
      if (element) {
        element.scrollIntoView({
          behavior: 'smooth',
          block: 'start',
        });
      }
    }
  }

  public scrollToTop(): void {
    if (this.smoother) {
      this.smoother.scrollTo(0);
    } else {
      window.scrollTo({
        top: 0,
        behavior: 'smooth',
      });
    }
  }

  public getSmoother(): ScrollSmoother | null {
    return this.smoother;
  }
}

// Extend Window interface to include themeAnimations
declare global {
  interface Window {
    themeAnimations: ThemeAnimations;
    smoother: ScrollSmoother | null;
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
