import { RequestHelper } from '../Utils/RequestHelper.js';
import { UiElements } from '../Utils/UiElements.js';
export class Bot {
    constructor() {
        this.isRunning = false;
        this.client = null;
        // This is just to avoid undefined values while waiting for async getSettings method.
        this.settings = {
            twitchToken: '',
            channels: [],
            cooldown: 5,
            openAiKey: '',
            openAiPrePrompt: '',
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
        // Create new client if it doesn't exist or if channels have changed
        if (!this.client || this.settings.channels != this.client.channels) {
            this.client = new tmi.Client({
                options: {
                    skipUpdatingEmotesets: true,
                },
                connection: {
                    secure: true,
                    reconnect: true,
                },
                identity: {
                    username: 'NatterbaseBot',
                    password: `oauth:${this.settings.twitchToken}`,
                },
                channels: this.settings.channels,
            });
            // Client events
            this.client.on('connected', (address, port) => {
                console.log(`Connected to ${address}:${port}`);
            });
            this.client.on('message', (channel, tags, message, self) => {
                console.log(`${tags['display-name']}: ${message}`);
                this.displayMessage(`${tags['display-name']}: ${message}`);
                if (self)
                    return;
                // Check for the !ask command and call OpenAI
                if (message.startsWith('!ask ')) {
                    const prompt = message.replace('!ask ', '');
                    this.getOpenAIResponse(prompt, this.settings.openAiPrePrompt).then((response) => {
                        this.client?.say(channel, `@${tags.username}, ${response}`);
                    }).catch(error => {
                        console.error('Error getting OpenAI response:', error);
                        this.client?.say(channel, `@${tags.username}, I couldn't get an answer right now.`);
                    });
                }
                // Simple hello test command
                if (message.toLowerCase() === '!hello') {
                    this.client.say(channel, `@${tags.username}, heya!`);
                }
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
        const selectedBotIndex = Number(UiElements.botProfileSelector.selectedIndex) - 1;
        const response = await RequestHelper.get('/api/userData');
        const result = await RequestHelper.handleResponse(response);
        const currentProfile = result.botProfiles[selectedBotIndex];
        const settings = {
            twitchToken: UiElements.twitchTokenInput.value,
            openAiKey: UiElements.openAiKeyInput.value,
            channels: [currentProfile.twitchJoinChannel],
            cooldown: currentProfile.cooldownTime,
            openAiPrePrompt: currentProfile.openAiPrePrompt,
            maxOpenaiMessageLength: currentProfile.maxOpenaiMessageLength,
            commands: currentProfile.botCommands,
            features: currentProfile.botFeatures,
        };
        return settings;
    }
    displayMessage(message) {
        if (UiElements.chatDisplay) {
            const newText = document.createElement('p');
            newText.innerText = message;
            UiElements.chatDisplay.appendChild(newText);
        }
    }
    // Method to send a request to OpenAI and get a response
    async getOpenAIResponse(prompt, prePrompt) {
        const url = 'https://api.openai.com/v1/chat/completions';
        const data = {
            model: 'gpt-3.5-turbo',
            messages: [
                { role: 'system', content: prePrompt || 'You are a helpful assistant.' },
                { role: 'user', content: prompt },
            ],
            max_tokens: 100,
        };
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.settings.openAiKey}`,
                },
                body: JSON.stringify(data),
            });
            if (!response.ok) {
                const errorText = await response.text();
                console.error(`OpenAI request failed: ${response.status} - ${response.statusText}`);
                console.error(`Response body: ${errorText}`);
                throw new Error(`OpenAI request failed: ${response.status} - ${response.statusText}`);
            }
            const result = await response.json();
            return result.choices[0].message.content.trim();
        }
        catch (error) {
            console.error('Error in OpenAI request:', error);
            throw error;
        }
    }
}
