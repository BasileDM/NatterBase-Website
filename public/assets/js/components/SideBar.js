import { UIComponent } from '../Abstracts/UIComponent.js';
export class Sidebar extends UIComponent {
    constructor() {
        super();
        this.sidebarElement = document.getElementById('sidebar');
        this.toggleButton = document.getElementById('sidebar-toggle-btn');
    }
    open() {
        this.sidebarElement.classList.remove('hidden');
        this.sidebarElement.classList.remove('animate-slideOut');
        this.sidebarElement.classList.add('animate-slideIn');
    }
    close() {
        this.sidebarElement.classList.remove('animate-slideIn');
        this.sidebarElement.classList.add('animate-slideOut');
        setTimeout(() => {
            this.sidebarElement.classList.add('hidden');
        }, 450);
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
            if (this.sidebarElement.classList.contains('hidden')) {
                this.open();
            }
            else {
                this.close();
            }
        });
        // Close sidebar when clicking outside of it
        document.addEventListener('click', (event) => {
            if (!this.sidebarElement.contains(event.target) && !this.toggleButton.contains(event.target)) {
                this.close();
            }
        });
    }
}
