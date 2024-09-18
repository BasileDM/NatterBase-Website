export class Sidebar {
  private sidebarElement: HTMLElement;
  private toggleButton: HTMLElement;
  private openAnimationClass: string;
  private closeAnimationClass: string;
  private animationDuration: number = 450;

  constructor() {
    this.sidebarElement = document.getElementById('sidebar') as HTMLElement;
    if (window.location.pathname == '/app') {
      this.sidebarElement.classList.remove('hidden');
    }
    this.toggleButton = document.getElementById('burger-btn') as HTMLElement;
    this.openAnimationClass = 'animate-slideIn';
    this.closeAnimationClass = 'animate-slideOut';
    this.bindEvents();
  }

  private bindEvents(): void {
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
    document.addEventListener('click', (event: MouseEvent) => {
      if (window.innerWidth > 640) return;
      if (!this.sidebarElement.contains(event.target as Node)
        && !this.toggleButton.contains(event.target as Node)) {
        this.close();
      }
    });
  }

  private open(): void {
    this.sidebarElement.classList.remove('hidden');
    this.sidebarElement.classList.remove(this.closeAnimationClass);
    this.sidebarElement.classList.add(this.openAnimationClass);
  }

  private close(): void {
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
