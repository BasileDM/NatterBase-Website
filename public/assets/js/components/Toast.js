export class Toast {
    constructor(toastId) {
        this.toastElement = document.getElementById(toastId);
    }
    show(animationClass) {
        this.toastElement.classList.remove('hidden');
        if (animationClass) {
            this.toastElement.classList.add(animationClass);
        }
        // Automatically close after 3 seconds
        setTimeout(() => {
            this.close('animate-fadeOut');
        }, 3000);
    }
    close(animationClass) {
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
