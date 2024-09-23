declare const tmi: typeof import('tmi.js');
import * as tmiTypes from 'tmi.js';

export class Bot {
  private client: tmiTypes.Client | null;
  public isRunning: boolean;

  constructor() {
    this.client = null;
    this.isRunning = false;
  }

  start() {
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
        channels: ['LIRIK_247'],
      });

      this.client.on('connected', (address: string, port: number) => {
        console.log(`Connected to ${address}:${port}`);
      });

      this.client.on('message', (channel: string, tags: tmiTypes.ChatUserstate, message: string, self: boolean) => {
        if (self) return;
        console.log(`${tags['display-name']}: ${message}`);
      });
    }

    this.client.connect().then(() => {
      console.log('Bot connected to the channel.');
      this.isRunning = true;
    }).catch(console.error);
  }

  stop() {
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
}
