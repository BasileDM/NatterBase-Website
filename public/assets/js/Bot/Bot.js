export class Bot {
    constructor() {
        this.isRunning = false;
        this.client = null;
        this.chatDisplay = document.getElementById('chat-display');
        this.settings = this.getSettings();
    }
    start() {
        if (this.isRunning && this.client) {
            console.log('Bot is already running.');
            return;
        }
        this.settings = this.getSettings();
        if (!this.client || this.settings.channels != this.client.channels) {
            this.client = new tmi.Client({
                connection: {
                    secure: true,
                    reconnect: true,
                },
                channels: this.settings.channels,
            });
            this.client.on('connected', (address, port) => {
                console.log(`Connected to ${address}:${port}`);
            });
            this.client.on('message', (channel, tags, message, self) => {
                if (self)
                    return;
                console.log(`${tags['display-name']}: ${message}`);
                this.displayMessage(`${tags['display-name']}: ${message}`);
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
    getSettings() {
        const cooldownInput = document.getElementById('bot-cooldown');
        const openAiKeyInput = document.getElementById('account-section-openAiKey');
        const channelOverride = document.getElementById('account-section-channelOverride');
        const settings = {
            channels: ['BasileDM'],
            cooldown: cooldownInput ? parseInt(cooldownInput.value) : 5,
            openAiKey: openAiKeyInput ? openAiKeyInput.value : '',
            maxOpenaiMessageLength: 1000,
            commands: [],
            features: [],
        };
        if (channelOverride && channelOverride.value !== '') {
            console.log('Channel override:', channelOverride.value);
            settings.channels = [channelOverride.value];
        }
        return settings;
    }
    displayMessage(message) {
        if (this.chatDisplay) {
            const newText = document.createElement('p');
            newText.innerText = message;
            this.chatDisplay.appendChild(newText);
        }
    }
}
