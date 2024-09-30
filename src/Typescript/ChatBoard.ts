export class ChatBoard {
  private chatDisplay: HTMLElement;
  private logColor: string = 'white';
  private errorColor: string = 'red';
  private successColor: string = 'green';
  private warningColor: string = 'orange';

  constructor() {
    this.chatDisplay = document.getElementById('chat-display') as HTMLElement;
  }

  displayMessage(message: string): void {
    this.chatDisplay.innerHTML += `<p>${message}</p>`;
  }

  log(message: string, color: string = this.logColor): void {
    this.chatDisplay.innerHTML += `<p style="color: ${color}">${message}</p>`;
  }

  warn(message: string, color: string = this.warningColor): void {
    this.chatDisplay.innerHTML += `<p style="color: ${color}">${message}</p>`;
  }

  error(message: string, color: string = this.errorColor): void {
    this.chatDisplay.innerHTML += `<p style="color: ${color}">${message}</p>`;
  }
}