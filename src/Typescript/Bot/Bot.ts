declare const tmi: typeof import('tmi.js');
import * as tmiTypes from 'tmi.js';
import { BotSettings } from '../Bot/Interfaces/BotSettings.js';

export class Bot {
  public isRunning: boolean;
  private client: tmiTypes.Client | null;
  private chatDisplay: HTMLPreElement | null;
  private settings: BotSettings;

  constructor() {
    this.isRunning = false;
    this.client = null;
    this.chatDisplay = document.getElementById('chat-display') as HTMLPreElement;
    this.settings = this.getSettings();
  }

  public start() {
    if (this.isRunning && this.client) {
      console.log('Bot is already running.');
      return;
    }

    if (!this.client) {
      this.client = new tmi.Client({
        connection: {
          secure: true,
          reconnect: true,
        },
        channels: this.settings.channels,
      });

      this.client.on('connected', (address: string, port: number) => {
        console.log(`Connected to ${address}:${port}`);
      });

      this.client.on('message', (channel: string, tags: tmiTypes.ChatUserstate, message: string, self: boolean) => {
        if (self) return;
        console.log(`${tags['display-name']}: ${message}`);
        this.displayMessage(`${tags['display-name']}: ${message}`);
      });
    }

    this.client.connect().then(() => {
      console.log('Bot connected to the channel.');
      this.isRunning = true;
    }).catch(console.error);
  }

  public stop() {
    if (!this.isRunning || !this.client) {
      console.log('Bot is not running or client is null.');
      return;
    }

    if (this.client.readyState() !== 'OPEN') {
      console.log('Client is not connected.');
      return;
    }

    this.client.disconnect().then(() => {
      console.log('Bot disconnected from the channel.');
      this.isRunning = false;
      this.client = null;
    }).catch(console.error);
  }

  getSettings(): BotSettings {
    const cooldownInput = document.getElementById('bot-cooldown') as HTMLInputElement;
    const openAiKeyInput = document.getElementById('account-section-openAiKey') as HTMLInputElement;
    const settings: BotSettings = {
      channels: ['Echo_Esports'],
      cooldown: cooldownInput ? parseInt(cooldownInput.value) : 5,
      openAiKey: openAiKeyInput ? openAiKeyInput.value : '',
      maxOpenaiMessageLength: 1000,
      commands: [],
      features: [],
    };
    return settings;
  }

  displayMessage(message: string) {
    if (this.chatDisplay) {
      const newText = document.createElement('p');
      newText.innerText = message;
      this.chatDisplay.appendChild(newText);
    }
  }
}
