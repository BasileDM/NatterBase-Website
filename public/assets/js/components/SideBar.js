export class Sidebar {
    constructor() {
        this.isOpen = false;
        this.animationDuration = 450;
        this.sidebarElement = document.getElementById('sidebar');
        if (window.location.pathname == '/app') {
            this.sidebarElement.classList.remove('hidden');
        }
        this.toggleButton = document.getElementById('burger-btn');
        this.websiteNavElement = document.getElementById('website-mobile-nav');
        if (window.innerWidth > 640) {
            this.websiteNavElement.classList.add('hidden');
        }
        // eslint-disable-next-line no-undef
        this.appNavButtons = this.sidebarElement.querySelectorAll('li[id*="app-nav-button"]');
        this.openAnimationClass = 'animate-slideIn';
        this.closeAnimationClass = 'animate-slideOut';
        this.bindEvents();
    }
    bindEvents() {
        // App navigation buttons
        for (let i = 0; i < this.appNavButtons.length; i++) {
            this.appNavButtons[i].addEventListener('click', () => {
                // Get the section ID from the data-section attribute
                const sectionId = this.appNavButtons[i].dataset.section;
                // Hide all sections
                document.querySelectorAll('section[id*="app"]').forEach((section) => {
                    section.classList.add('hidden');
                });
                // Show the relevant section
                if (sectionId) {
                    const sectionElement = document.getElementById(sectionId);
                    sectionElement?.classList.remove('hidden');
                }
            });
        }
        // Handle window resizing
        window.addEventListener('resize', () => {
            if (window.innerWidth > 640) {
                this.websiteNavElement.classList.add('hidden');
            }
            else {
                this.websiteNavElement.classList.remove('hidden');
            }
            if (!this.isOpen && window.innerWidth > 640 && window.location.pathname == '/app') {
                this.open();
            }
            if (this.isOpen && window.innerWidth > 640 && window.location.pathname != '/app') {
                this.close();
            }
        });
        // Open sidebar from burger button
        this.toggleButton.addEventListener('click', () => {
            this.toggle();
        });
        // Close sidebar when clicking outside
        document.addEventListener('click', (event) => {
            if (window.innerWidth > 640)
                return;
            if (!this.sidebarElement.contains(event.target)
                && !this.toggleButton.contains(event.target)) {
                this.close();
            }
        });
    }
    open() {
        this.isOpen = true;
        this.sidebarElement.classList.remove('hidden');
        this.sidebarElement.classList.remove(this.closeAnimationClass);
        this.sidebarElement.classList.add(this.openAnimationClass);
    }
    close() {
        this.isOpen = false;
        this.sidebarElement.classList.remove(this.openAnimationClass);
        this.sidebarElement.classList.add(this.closeAnimationClass);
        setTimeout(() => {
            this.sidebarElement.classList.add('hidden');
        }, this.animationDuration);
    }
    toggle() {
        if (this.sidebarElement.classList.contains('hidden')) {
            this.open();
        }
        else {
            this.close();
        }
    }
}
