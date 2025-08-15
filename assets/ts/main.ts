// interface NavigationSettings {
//   selector?: string;
// }

// class Navigation {
//   private selector: string;

//   constructor(settings: NavigationSettings) {
//     this.selector = settings.selector || 'a';
//     this.getAllLinks();
//     document.body.classList.add('loaded');
//   }

//   private getAllLinks(): void {
//     const allLinks = document.querySelectorAll<HTMLAnchorElement>(this.selector);

//     allLinks.forEach((link) => {
//       link.addEventListener('click', (e) => this.openLink(e));
//     });
//   }

//   private async openLink(event: Event): Promise<void> {
//     event.preventDefault();
//     const target = event.target as HTMLAnchorElement;
//     const url = target.href;

//     console.log(event);

//     if (url && url.includes(window.location.host)) {
//       document.body.classList.remove('loaded');
//       document.body.classList.add('loading');

//       try {
//         const response = await fetch(url);
//         if (!response.ok) {
//           throw new Error(`HTTP error! status: ${response.status}`);
//         }

//         const text = await response.text();
//         document.body.innerHTML = text;
//         history.pushState({}, '', url);
//         document.body.classList.remove('loading');
//         document.body.classList.add('loaded');
//         this.getAllLinks();
//         console.log('✅ Navigation succeeded');
//       } catch (error) {
//         console.error('Navigation failed:', error);
//         document.body.classList.remove('loading');
//         document.body.classList.add('loaded');
//       }
//     }
//   }
// }

// document.addEventListener('DOMContentLoaded', () => {
//   new Navigation({
//     selector: 'a:not(.wp-admin-toolbar-item)',
//   });
// });
