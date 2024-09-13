export class Toast {
  private toastElement: HTMLElement;

  constructor(toastId: string) {
    this.toastElement = document.getElementById(toastId) as HTMLElement;
  }

  show(animationClass?: string): void {
    this.toastElement.classList.remove('hidden');
    if (animationClass) {
      this.toastElement.classList.add(animationClass);
    }

    // Automatically close after 3 seconds
    setTimeout(() => {
      this.close('animate-fadeOut');
    }, 3000);
  }

  close(animationClass?: string): void {
    if (animationClass) {
      this.toastElement.classList.add(animationClass);
      setTimeout(() => {
        this.toastElement.classList.add('hidden');
      }, 450);
    }
    else {
      this.toastElement.classList.add('hidden');
    }
  }
}
