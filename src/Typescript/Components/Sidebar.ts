/* eslint-disable @typescript-eslint/no-explicit-any */
import { UiElements } from '../Utils/UiElements.js';
import { UiUtils } from '../Utils/UiUtils.js';

export class Sidebar {
  private isAppPage = window.location.pathname.includes('/app') && (window as any).HTTP_STATUS_CODE === 200;
  private isOpen: boolean = false;
  private openAnimationClass: string;
  private closeAnimationClass: string;
  private animationDuration: number = 450;

  constructor() {
    if (this.isAppPage) {
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

  private bindEvents(): void {
    // App navigation buttons
    for (let i = 0; i < UiElements.appNavButtons.length; i++) {
      UiElements.appNavButtons[i].addEventListener('click', () => {

        // Remove active section classes for all buttons
        UiElements.appNavButtons.forEach((button) => {
          button.classList.remove('bg-gray-700', 'text-gray-300');
        });
        // Add active section classes for the clicked button
        UiElements.appNavButtons[i].classList.add('bg-gray-700', 'text-gray-300');

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
      if (!this.isOpen && window.innerWidth > 640 && this.isAppPage) {
        this.open();
      }
      if (this.isOpen && window.innerWidth > 640 && !this.isAppPage) {
        this.close();
      }
    });

    // Open sidebar from burger button
    UiElements.toggleButton.addEventListener('click', () => {
      this.toggle();
    });

    // Close sidebar when clicking outside
    document.addEventListener('click', (event: MouseEvent) => {
      if (window.innerWidth > 640) return;
      if (!UiElements.sidebar.contains(event.target as Node)
        && !UiElements.toggleButton.contains(event.target as Node)) {
        this.close();
      }
    });

    // Logout session storage clearing
    if (UiElements.logoutBtn) {
      UiElements.logoutBtn.addEventListener('click', () => {
        // sessionStorage.clear();
        sessionStorage.setItem('showToast', 'You have been logged out.');
      });
    }
  }

  private open(): void {
    this.isOpen = true;
    UiElements.sidebar.classList.remove('hidden');
    UiElements.sidebar.classList.remove(this.closeAnimationClass);
    UiElements.sidebar.classList.add(this.openAnimationClass);
  }

  private close(): void {
    this.isOpen = false;
    UiElements.sidebar.classList.remove(this.openAnimationClass);
    UiElements.sidebar.classList.add(this.closeAnimationClass);

    setTimeout(() => {
      UiElements.sidebar.classList.add('hidden');
    }, this.animationDuration);
  }

  private toggle(): void {
    if (UiElements.sidebar.classList.contains('hidden')) {
      this.open();
    }
    else {
      this.close();
    }
  }
}
