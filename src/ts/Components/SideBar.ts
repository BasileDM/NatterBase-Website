import { UIComponent } from '../Abstracts/UIComponent.js';

export class Sidebar extends UIComponent {
  private sidebarElement : HTMLElement;
  private toggleButton : HTMLElement;

  constructor() {
    super();
    this.sidebarElement = document.getElementById('sidebar') as HTMLElement;
    this.toggleButton = document.getElementById('sidebar-toggle-btn') as HTMLElement;
  }

  open(): void {
    this.sidebarElement.classList.remove('hidden');
    this.sidebarElement.classList.remove('animate-slideOut');
    this.sidebarElement.classList.add('animate-slideIn');
  }

  close(): void {
    this.sidebarElement.classList.remove('animate-slideIn');
    this.sidebarElement.classList.add('animate-slideOut');

    setTimeout(() => {
      this.sidebarElement.classList.add('hidden');
    }, 450);
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
      if (this.sidebarElement.classList.contains('hidden')) {
        this.open();
      }
      else {
        this.close();
      }
    });

    // Close sidebar when clicking outside of it
    document.addEventListener('click', (event: MouseEvent) => {
      if (!this.sidebarElement.contains(event.target as Node) && !this.toggleButton.contains(event.target as Node)) {
        this.close();
      }
    });
  }
}