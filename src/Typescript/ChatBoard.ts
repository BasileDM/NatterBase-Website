/* eslint-disable no-unused-vars */
export class ChatBoard {
  private chatDisplay: HTMLElement;
  private chatInput: HTMLInputElement;
  private sendButton: HTMLElement;
  private logColor: string = 'white';
  private errorColor: string = 'red';
  private successColor: string = 'green';
  private warningColor: string = 'orange';
  private sendMessageCallback: (_message: string) => void;

  constructor(sendMessageCallback: (_message: string) => void) {
    this.sendMessageCallback = sendMessageCallback;

    this.chatDisplay = document.getElementById('chat-display') as HTMLElement;
    this.chatInput = document.getElementById('chat-input') as HTMLInputElement;
    this.sendButton = document.getElementById('chat-send-button') as HTMLElement;

    // Event listeners
    this.sendButton.addEventListener('click', () => this.handleSendMessage());
    this.chatInput.addEventListener('keypress', (event) => {
      if (event.key === 'Enter') {
        event.preventDefault();
        this.handleSendMessage();
      }
    });
  }

  private handleSendMessage(): void {
    const message = this.chatInput.value.trim();
    if (message) {
      this.chatInput.value = '';
      this.sendMessageCallback(message);
    }
  }

  public displayMessage(username: string, message: string, color: string | null): void {
    const messageElement = document.createElement('p');

    // Create the username span
    const usernameElement = document.createElement('span');
    usernameElement.textContent = username;
    usernameElement.style.fontWeight = 'bold';
    usernameElement.style.color = color || 'white';

    // Create the message span
    const messageTextElement = document.createElement('span');
    messageTextElement.textContent = `: ${message}`;

    // Append username and message to the messageElement
    messageElement.appendChild(usernameElement);
    messageElement.appendChild(messageTextElement);

    // Append the messageElement to the chat display
    this.chatDisplay.appendChild(messageElement);
    this.scrollToBottom();
  }


  public log(message: string, color: string = this.logColor): void {
    const messageElement = document.createElement('p');
    messageElement.style.color = color;
    messageElement.textContent = message;
    this.chatDisplay.appendChild(messageElement);
    this.scrollToBottom();
  }

  public warn(message: string, color: string = this.warningColor): void {
    this.log(message, color);
  }

  public error(message: string, color: string = this.errorColor): void {
    this.log(message, color);
  }

  private scrollToBottom(): void {
    this.chatDisplay.scrollTop = this.chatDisplay.scrollHeight;
  }
}
