export class ChatBoard {
    constructor() {
        this.logColor = 'white';
        this.errorColor = 'red';
        this.successColor = 'green';
        this.warningColor = 'orange';
        this.chatDisplay = document.getElementById('chat-display');
    }
    displayMessage(message) {
        this.chatDisplay.innerHTML += `<p>${message}</p>`;
    }
    log(message, color = this.logColor) {
        this.chatDisplay.innerHTML += `<p style="color: ${color}">${message}</p>`;
    }
    warn(message, color = this.warningColor) {
        this.chatDisplay.innerHTML += `<p style="color: ${color}">${message}</p>`;
    }
    error(message, color = this.errorColor) {
        this.chatDisplay.innerHTML += `<p style="color: ${color}">${message}</p>`;
    }
}
