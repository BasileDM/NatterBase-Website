/* eslint-disable @typescript-eslint/no-explicit-any */
// / <reference types="tmi.js" />
declare const tmi: typeof import('tmi.js');


export class Bot {

  constructor() {
    this.init();
  }

  init() {
    const client = new tmi.Client({
      channels: [ 'LIRIK_247' ],
    });

    client.connect();

    client.on('message', (channel: any, tags: { [x: string]: any; }, message: any, self: any) => {
      console.log(`${tags['display-name']}: ${message}`);
    });
  }
}