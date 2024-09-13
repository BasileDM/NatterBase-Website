export class Sidebar {
  private sidebarElement: HTMLElement;
  private toggleButton: HTMLElement;
  private openAnimationClass = 'animate-slideIn';
  private closeAnimationClass = 'animate-slideOut';
  private animationDuration = 450;

  constructor() {
    this.sidebarElement = document.getElementById('sidebar') as HTMLElement;
    this.toggleButton = document.getElementById('burger-btn') as HTMLElement;
    this.bindEvents();
  }

  open(): void {
    this.sidebarElement.classList.remove('hidden');
    this.sidebarElement.classList.remove(this.closeAnimationClass);
    this.sidebarElement.classList.add(this.openAnimationClass);
  }

  close(): void {
    this.sidebarElement.classList.remove(this.openAnimationClass);
    this.sidebarElement.classList.add(this.closeAnimationClass);

    setTimeout(() => {
      this.sidebarElement.classList.add('hidden');
    }, this.animationDuration);
  }

  toggle(): void {
    if (this.sidebarElement.classList.contains('hidden')) {
      this.open();
    }
    else {
      this.close();
    }
  }

  bindEvents(): void {
    this.toggleButton.addEventListener('click', () => {
      this.toggle();
    });

    document.addEventListener('click', (event: MouseEvent) => {
      if (!this.sidebarElement.contains(event.target as Node) && !this.toggleButton.contains(event.target as Node)) {
        this.close();
      }
    });
  }
}
