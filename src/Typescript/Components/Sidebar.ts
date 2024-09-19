export class Sidebar {
  private isOpen: boolean = false;
  private sidebarElement: HTMLElement;
  private toggleButton: HTMLElement;
  private websiteNavElement: HTMLElement;
  // eslint-disable-next-line no-undef
  private appNavButtons: NodeListOf<HTMLElement>;
  private openAnimationClass: string;
  private closeAnimationClass: string;
  private animationDuration: number = 450;

  constructor() {
    this.sidebarElement = document.getElementById('sidebar') as HTMLElement;
    if (window.location.pathname == '/app') {
      this.sidebarElement.classList.remove('hidden');
    }
    this.toggleButton = document.getElementById('burger-btn') as HTMLElement;
    this.websiteNavElement = document.getElementById('website-mobile-nav') as HTMLElement;
    if (window.innerWidth > 640) {
      this.websiteNavElement.classList.add('hidden');
    }
    // eslint-disable-next-line no-undef
    this.appNavButtons = this.sidebarElement.querySelectorAll('li[id*="app-nav-button"]') as NodeListOf<HTMLElement>;
    console.log(this.appNavButtons);
    console.log(this.sidebarElement.innerHTML);
    this.openAnimationClass = 'animate-slideIn';
    this.closeAnimationClass = 'animate-slideOut';
    this.bindEvents();
  }

  private bindEvents(): void {
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
    document.addEventListener('click', (event: MouseEvent) => {
      if (window.innerWidth > 640) return;
      if (!this.sidebarElement.contains(event.target as Node)
        && !this.toggleButton.contains(event.target as Node)) {
        this.close();
      }
    });
  }

  private open(): void {
    this.isOpen = true;
    this.sidebarElement.classList.remove('hidden');
    this.sidebarElement.classList.remove(this.closeAnimationClass);
    this.sidebarElement.classList.add(this.openAnimationClass);
  }

  private close(): void {
    this.isOpen = false;
    this.sidebarElement.classList.remove(this.openAnimationClass);
    this.sidebarElement.classList.add(this.closeAnimationClass);

    setTimeout(() => {
      this.sidebarElement.classList.add('hidden');
    }, this.animationDuration);
  }

  private toggle(): void {
    if (this.sidebarElement.classList.contains('hidden')) {
      this.open();
    }
    else {
      this.close();
    }
  }
}
