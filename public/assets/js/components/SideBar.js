import { UiElements } from '../Utils/UiElements.js';
import { UiUtils } from '../Utils/UiUtils.js';
export class Sidebar {
    constructor() {
        this.isOpen = false;
        this.animationDuration = 450;
        if (window.location.pathname == '/app') {
            UiElements.sidebar.classList.remove('hidden');
        }
        if (window.innerWidth > 640) {
            UiElements.websiteNavElement.classList.add('hidden');
            document.getElementById('sidebar-app-button')?.classList.add('hidden');
        }
        this.openAnimationClass = 'animate-slideIn';
        this.closeAnimationClass = 'animate-slideOut';
        this.bindEvents();
    }
    bindEvents() {
        // App navigation buttons
        for (let i = 0; i < UiElements.appNavButtons.length; i++) {
            UiElements.appNavButtons[i].addEventListener('click', () => {
                // Get the section ID from the data-section attribute
                const sectionId = UiElements.appNavButtons[i].dataset.section;
                // Hide all sections and show the proper one
                document.querySelectorAll('section[id*="app"]').forEach((section) => {
                    section.classList.add('hidden');
                });
                if (sectionId) {
                    const sectionElement = document.getElementById(sectionId);
                    sectionElement?.classList.remove('hidden');
                }
                UiUtils.resetAllSections();
            });
        }
        // Handle window resizing
        window.addEventListener('resize', () => {
            if (window.innerWidth > 640) {
                UiElements.websiteNavElement.classList.add('hidden');
                document.getElementById('sidebar-app-button')?.classList.add('hidden');
            }
            else {
                UiElements.websiteNavElement.classList.remove('hidden');
                document.getElementById('sidebar-app-button')?.classList.remove('hidden');
            }
            if (!this.isOpen && window.innerWidth > 640 && window.location.pathname == '/app') {
                this.open();
            }
            if (this.isOpen && window.innerWidth > 640 && window.location.pathname != '/app') {
                this.close();
            }
        });
        // Open sidebar from burger button
        UiElements.toggleButton.addEventListener('click', () => {
            this.toggle();
        });
        // Close sidebar when clicking outside
        document.addEventListener('click', (event) => {
            if (window.innerWidth > 640)
                return;
            if (!UiElements.sidebar.contains(event.target)
                && !UiElements.toggleButton.contains(event.target)) {
                this.close();
            }
        });
        // Logout session storage clearing
        if (UiElements.logoutBtn) {
            UiElements.logoutBtn.addEventListener('click', () => {
                sessionStorage.clear();
            });
        }
    }
    open() {
        this.isOpen = true;
        UiElements.sidebar.classList.remove('hidden');
        UiElements.sidebar.classList.remove(this.closeAnimationClass);
        UiElements.sidebar.classList.add(this.openAnimationClass);
    }
    close() {
        this.isOpen = false;
        UiElements.sidebar.classList.remove(this.openAnimationClass);
        UiElements.sidebar.classList.add(this.closeAnimationClass);
        setTimeout(() => {
            UiElements.sidebar.classList.add('hidden');
        }, this.animationDuration);
    }
    toggle() {
        if (UiElements.sidebar.classList.contains('hidden')) {
            this.open();
        }
        else {
            this.close();
        }
    }
}
