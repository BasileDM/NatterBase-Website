export class Bot {
    constructor() {
        this.client = null;
        this.isRunning = false;
    }
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
        this.client.on('message', (channel, tags, message, self) => {
            if (self)
                return;
            console.log(`${tags['display-name']}: ${message}`);
        });
        // Listen for the connected event
        this.client.on('connected', (address, port) => {
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
