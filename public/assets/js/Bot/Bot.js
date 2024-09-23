export class Bot {
    constructor() {
        this.init();
    }
    init() {
        const client = new tmi.Client({
            channels: ['LIRIK_247'],
        });
        client.connect();
        client.on('message', (channel, tags, message, self) => {
            console.log(`${tags['display-name']}: ${message}`);
        });
    }
}
