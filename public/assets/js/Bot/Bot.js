import { RequestHelper } from '../Utils/RequestHelper.js';
export class Bot {
    constructor() {
        this.isRunning = false;
        this.client = null;
        this.chatDisplay = document.getElementById('chat-display');
        // This is just to avoid undefined values while waiting for async getSettings method.
        this.settings = {
            channels: [],
            cooldown: 5,
            openAiKey: '',
            maxOpenaiMessageLength: 1000,
            commands: [],
            features: [],
        };
    }
    async start() {
        if (this.isRunning && this.client) {
            console.log('Bot is already running.');
            return;
        }
        this.settings = await this.getSettings();
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
    async getSettings() {
        const channelOverride = document.getElementById('account-section-channelOverride');
        const botSelector = document.getElementById('bot-profiles-selector');
        const selectedBotIndex = Number(botSelector.selectedIndex) - 1;
        const response = await RequestHelper.get('/api/userData');
        const result = await RequestHelper.handleResponse(response);
        const currentProfile = result.botProfiles[selectedBotIndex];
        const settings = {
            channels: [''],
            cooldown: currentProfile.cooldownTime,
            openAiKey: '',
            maxOpenaiMessageLength: currentProfile.maxOpenaiMessageLength,
            commands: currentProfile.commands,
            features: currentProfile.features,
        };
        if (channelOverride && channelOverride.value !== '') {
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
