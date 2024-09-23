/* eslint-disable @typescript-eslint/no-explicit-any */
declare const tmi: typeof import('tmi.js');
import * as tmiTypes from 'tmi.js';

export class Bot {
  private client: tmiTypes.Client | null = null;
  public isRunning: boolean = false;

  start() {
    if (this.isRunning) {
      console.log('Bot is already running.');
      return;
    }

    this.client = new tmi.Client({
      connection: {
        secure: true,
        reconnect: true,
      },
      channels: ['BasileDM'],
    });

    this.client.connect().then(() => {
      console.log('Bot connected to the channel.');
      this.isRunning = true;
    }).catch(console.error);

    // Listen to messages
    this.client.on('message', (channel: any, tags: { [x: string]: any }, message: any, self: any) => {
      if (self) return;
      console.log(`${tags['display-name']}: ${message}`);
    });

    // Listen for the connected event
    this.client.on('connected', (address: any, port: any) => {
      console.log(`Connected to ${address}:${port}`);
    });
  }

  stop() {
    if (!this.isRunning || !this.client) {
      console.log('Bot is not running.');
      return;
    }

    this.client.disconnect().then(() => {
      console.log('Bot disconnected from the channel.');
      this.isRunning = false;
      this.client = null;
    }).catch(console.error);
  }
}
