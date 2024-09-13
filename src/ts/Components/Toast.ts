export class Toast {
  private toastElement: HTMLElement;
  private closeButton: HTMLElement;
  private messageElement: HTMLElement;
  private iconElement: HTMLElement;
  private showAnimationClass: string;
  private closeAnimationClass: string;

  constructor() {
    this.toastElement = document.getElementById('toast') as HTMLElement;
    this.closeButton = document.getElementById('toast-close-btn') as HTMLElement;
    this.showAnimationClass = 'animate-toastSlideIn';
    this.closeAnimationClass = 'animate-toastSlideOut';
    this.messageElement = document.getElementById('toast-message') as HTMLElement;
    this.iconElement = document.getElementById('toast-icon') as HTMLElement;
    this.bindEvents();
  }

  private bindEvents(): void {
    this.closeButton.addEventListener('click', () => {
      this.close();
    });
  }

  private show(): void {
    this.toastElement.classList.remove('hidden', this.closeAnimationClass);
    this.toastElement.classList.add(this.showAnimationClass);

    setTimeout(() => {
      this.close();
    }, 3000);
  }

  private close(): void {
    this.toastElement.classList.remove(this.showAnimationClass);
    this.toastElement.classList.add(this.closeAnimationClass);

    setTimeout(() => {
      this.toastElement.classList.add('hidden');
    }, 450);
  }

  public display(type: string, message: string): void {
    this.messageElement.textContent = message;

    // Apply different styles based on the type
    if (type === 'success') {
      this.toastElement.classList.add('toast-success');
      this.iconElement.textContent = '✔️';
    }
    else if (type === 'error') {
      this.toastElement.classList.add('toast-error');
      this.iconElement.textContent = '❌';
    }

    this.show();
  }
}
