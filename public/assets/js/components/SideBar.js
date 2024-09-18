export class Sidebar {
    constructor() {
        this.animationDuration = 450;
        this.sidebarElement = document.getElementById('sidebar');
        if (window.location.pathname == '/app') {
            this.sidebarElement.classList.remove('hidden');
        }
        this.toggleButton = document.getElementById('burger-btn');
        this.openAnimationClass = 'animate-slideIn';
        this.closeAnimationClass = 'animate-slideOut';
        this.bindEvents();
    }
    bindEvents() {
        // Handle windows resizing
        window.addEventListener('resize', () => {
            if (window.innerWidth > 640 && window.location.pathname == '/app') {
                this.open();
            }
            if (window.innerWidth > 640 && window.location.pathname != '/app') {
                this.close();
            }
        });
        // Open sidebar
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
        this.sidebarElement.classList.remove('hidden');
        this.sidebarElement.classList.remove(this.closeAnimationClass);
        this.sidebarElement.classList.add(this.openAnimationClass);
    }
    close() {
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
