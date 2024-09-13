export class Sidebar {
    constructor() {
        this.animationDuration = 450;
        this.sidebarElement = document.getElementById('sidebar');
        this.toggleButton = document.getElementById('burger-btn');
        this.openAnimationClass = 'animate-slideIn';
        this.closeAnimationClass = 'animate-slideOut';
        this.bindEvents();
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
    bindEvents() {
        this.toggleButton.addEventListener('click', () => {
            this.toggle();
        });
        document.addEventListener('click', (event) => {
            if (!this.sidebarElement.contains(event.target) && !this.toggleButton.contains(event.target)) {
                this.close();
            }
        });
    }
}
