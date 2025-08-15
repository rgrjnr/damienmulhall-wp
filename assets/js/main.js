class Navigation {
  constructor(settings) {
    this.selector = settings.selector || 'a';
    this.init();
  }

  init() {
    this.getAllLinks();
    this.crowLoader = document.getElementById('crow-loader');
    this.crowVideo = document.getElementById('crow-video');

    document.body.classList.add('loaded');
  }

  getAllLinks() {
    const allLinks = document.querySelectorAll(this.selector);

    allLinks.forEach((link) => {
      link.addEventListener('click', (e) => this.openLink(e));
    });
  }

  openLink(event) {
    event.preventDefault();
    const url = event.srcElement.href;
    console.log(event);
    if (url.includes(window.location.host)) {
      // Show crow loader
      this.showCrowLoader();

      document.body.classList.remove('loaded');
      document.body.classList.add('loading');
      fetch(url)
        .then((response) => {
          if (response.ok) {
            return response.text();
          }
          throw response;
        })
        .then((text) => {
          document.body.innerHTML = text;
          history.pushState({}, '', url);
          document.body.classList.remove('loading');
          document.body.classList.add('loaded');
          this.init();
          this.hideCrowLoader();
          console.log('✅ Navigation succeeded');
        })
        .catch((error) => {
          console.error('Navigation failed:', error);
          this.hideCrowLoader();
          document.body.classList.remove('loading');
          document.body.classList.add('loaded');
        });
    }
  }

  showCrowLoader() {
    if (this.crowLoader && this.crowVideo) {
      this.crowLoader.classList.add('active');
      this.crowVideo.play().catch((e) => console.log('Video autoplay prevented:', e));
    }
  }

  hideCrowLoader() {
    if (this.crowLoader) {
      this.crowLoader.classList.remove('active');
    }
  }
}

const navigation = new Navigation({
  selector: 'a:not(.wp-admin-toolbar-item)',
});
