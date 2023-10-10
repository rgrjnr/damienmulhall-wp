class Navigation {
    constructor(settings) {
        this.getAllLinks();
        this.selector = settings.selector || "a"

        document.body.classList.add("loaded");
    }

    getAllLinks() {
        const allLinks = document.querySelectorAll(this.selector);

        allLinks.forEach((link) => {
            link.addEventListener("click", (e) => this.openLink(e));
        });
    }

    openLink(event) {
        event.preventDefault();
        const url = event.srcElement.href;
        console.log(event)
        if (url.includes(window.location.host)) {
            document.body.classList.remove("loaded");
            document.body.classList.add("loading");
            fetch(url).then((response) => {
                if (response.ok) {
                    return response.text();
                }
                throw response;
            }).then((text) => {
                document.body.innerHTML = text;
                history.pushState({}, "", url);
                document.body.classList.remove("loading");
                document.body.classList.add("loaded");
                this.getAllLinks();
                console.log("✅ Navigation succeeded")
            });
        }

    };
}

const navigation = new Navigation({
    selector: "a:not(.wp-admin-toolbar-item)"
});
