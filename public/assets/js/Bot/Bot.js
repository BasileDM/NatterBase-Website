import { RequestHelper } from '../Utils/RequestHelper.js';
import { UiElements } from '../Utils/UiElements.js';
import { ChatBoard } from '../ChatBoard.js';
export class Bot {
    constructor() {
        this.features = [];
        this.isRunning = false;
        this.client = null;
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
        this.chatBoard = new ChatBoard();
    }
    async start() {
        if (this.isRunning && this.client) {
            this.chatBoard.warn('Bot is already running.');
            return;
        }
        this.settings = await this.getSettings();
        this.loadFeatures();
        if (!this.client || this.settings.channels !== this.client.channels) {
            this.client = new tmi.Client({
                options: { skipUpdatingEmotesets: true },
                connection: { secure: true, reconnect: true },
                identity: {
                    username: 'NatterbaseBot',
                    password: `oauth:${this.settings.twitchToken}`,
                },
                channels: this.settings.channels,
            });
            this.client.on('connected', (address, port) => {
                this.chatBoard.log(`Connected to ${address}:${port}`, 'green');
            });
            this.client.on('message', (channel, tags, message, self) => {
                if (self)
                    return;
                this.chatBoard.displayMessage(`${tags['display-name']}: ${message}`);
                this.handleMessage(channel, tags, message);
            });
        }
        this.client.connect().then(() => {
            this.chatBoard.log('Bot connected to the channel.', 'green');
            this.isRunning = true;
        }).catch(console.error);
    }
    stop() {
        if (!this.isRunning || !this.client) {
            this.chatBoard.warn('Bot is not running or client is null.');
            return;
        }
        if (this.client.readyState() !== 'OPEN') {
            this.chatBoard.warn('Client is not connected.');
            return;
        }
        this.client.disconnect().then(() => {
            this.chatBoard.log('Bot disconnected from the channel.');
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
    loadFeatures() {
        this.features = this.settings.features.map(feature => ({
            trigger: feature.trigger,
            diceSidesNumber: feature.diceSidesNumber ?? null,
            openAiPrePrompt: feature.openAiPrePrompt ?? null,
        }));
    }
    async handleMessage(channel, tags, message) {
        const botName = this.client?.getUsername() || '';
        for (const feature of this.features) {
            const trigger = feature.trigger;
            // Check for triggers that are mentions (@BotName)
            if (trigger === '@' && message.includes(`@${botName}`)) {
                await this.handleFeatureResponse(channel, tags, message, feature);
                return;
            }
            // Check if message starts with the trigger
            if (message.startsWith(trigger)) {
                await this.handleFeatureResponse(channel, tags, message, feature);
                return;
            }
        }
    }
    async handleFeatureResponse(channel, tags, message, feature) {
        // AI Response
        if (feature.openAiPrePrompt) {
            const prompt = message.replace(feature.trigger, '').trim();
            try {
                const response = await this.getOpenAIResponse(prompt, feature.openAiPrePrompt);
                this.client?.say(channel, `@${tags.username}, ${response}`);
            }
            catch (error) {
                this.chatBoard.error('Error getting OpenAI response: ' + error);
                this.client?.say(channel, `@${tags.username}, I couldn't get an answer right now Sadge.`);
            }
        }
        // Dice Roll
        if (feature.diceSidesNumber) {
            const diceRoll = Math.floor(Math.random() * feature.diceSidesNumber) + 1;
            this.client?.say(channel, `@${tags.username}, you rolled a ${diceRoll}`);
        }
    }
}
