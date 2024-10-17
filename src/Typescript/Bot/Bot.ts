declare const tmi: typeof import('tmi.js');
import * as tmiTypes from 'tmi.js';
import { BotSettings } from '../Bot/Interfaces/BotSettings.js';
import { RequestHelper } from '../Utils/RequestHelper.js';
import { UiElements } from '../Utils/UiElements.js';
import { ChatBoard } from '../ChatBoard.js';
import { Feature } from './Interfaces/Feature.js';
import { Command } from './Interfaces/Command.js';

export class Bot {
  public isRunning: boolean;
  private client: tmiTypes.Client | null;
  private settings: BotSettings;
  private chatBoard: ChatBoard;
  public features: Feature[] = [];

  constructor() {
    this.isRunning = false;
    this.client = null;
    this.settings = {
      botId: 0,
      twitchToken: '',
      channels: [],
      cooldown: 5,
      openAiKey: '',
      commands: [] as Command[],
      features: [],
    };
    this.chatBoard = new ChatBoard((message: string) => {
      this.sendMessage(message);
    });
  }

  public async start() {
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

      this.client.on('connected', (address: string, port: number) => {
        this.chatBoard.log(`Connected to ${address}:${port}`, 'green');
      });

      this.client.on('message', (channel: string, tags: tmiTypes.ChatUserstate, message: string, self: boolean) => {
        const username = tags['display-name'] || tags.username || 'Unknown';
        const color = tags.color || null;

        this.chatBoard.displayMessage(username, message, color);
        if (self) return;
        this.handleMessage(channel, tags, message);
      });
    }

    this.client.connect().then(() => {
      this.chatBoard.log('Bot connected to the channel.', 'green');
      this.isRunning = true;
    }).catch(console.error);
  }

  public stop() {
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

  private async getSettings(): Promise<BotSettings> {
    const selectedBotIndex = Number(UiElements.botProfileSelector.selectedIndex) - 1;
    const response = await RequestHelper.get('./api/userData');
    const result = await RequestHelper.handleResponse(response);
    const currentProfile = result.botProfiles[selectedBotIndex];

    const settings: BotSettings = {
      botId: currentProfile.idBot,
      twitchToken: UiElements.twitchTokenInput.value,
      openAiKey: UiElements.openAiKeyInput.value,
      channels: [currentProfile.twitchJoinChannel],
      cooldown: currentProfile.cooldownTime,
      commands: currentProfile.botCommands,
      features: currentProfile.botFeatures,
    };
    return settings;
  }

  private async getOpenAIResponse(prompt: string, prePrompt?: string): Promise<string> {
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

  private loadFeatures() {
    this.features = this.settings.features.map(feature => ({
      trigger: feature.trigger,
      diceSidesNumber: feature.diceSidesNumber ?? null,
      openAiPrePrompt: feature.openAiPrePrompt ?? null,
      maxOpenAiMessageLength: feature.maxOpenAiMessageLength ?? null,
      deleteTrigger: feature.deleteTrigger ?? null,
    }));
  }

  private async handleMessage(channel: string, tags: tmiTypes.ChatUserstate, message: string) {
    const botName = (this.client?.getUsername() || '').trim();
    const lowerCaseMessage = message.toLowerCase();
    const lowerCaseBotName = botName.toLowerCase();

    for (const feature of this.features) {
      const trigger = feature.trigger;

      // Check for triggers that are mentions (@BotName), case-insensitive
      if (trigger === '@' && lowerCaseMessage.includes(`@${lowerCaseBotName}`)) {
        await this.handleFeatureResponse(channel, tags, message, feature);
        return;
      }

      // Check if message starts with the trigger (But not @)
      if (trigger !== '@' && message.startsWith(trigger)) {
        await this.handleFeatureResponse(channel, tags, message, feature);
        return;
      }

      // Delete command : check if message starts with deleteTrigger for text commands
      if (feature.deleteTrigger && message.startsWith(feature.deleteTrigger)) {
        const cmdToDelete = message.replace(feature.deleteTrigger, '').trim().toLowerCase();
        if (this.settings.commands.find(cmd => cmd.name.toLowerCase() === cmdToDelete)) {
          const response = await RequestHelper.delete(`./api/deleteTextCommand?cmdName=${cmdToDelete}&idBot=${this.settings.botId}`);
          const jsonResponseBody = await RequestHelper.handleResponse(response);

          if (!jsonResponseBody) {
            this.client?.say(channel, 'Could not delete command Sadge');
          }
          this.client?.say(channel, '@' + tags.username + ' Command deleted! :)');
          this.settings.commands.splice(this.settings.commands.findIndex(cmd => cmd.name === cmdToDelete), 1);
          return;
        }
        else {
          this.client?.say(channel, '@' + tags.username + ' Command not found. :(');
          return;
        }
      }

      // Check if message contains text command name
      const command = this.settings.commands.find(cmd => cmd.name.toLowerCase() === lowerCaseMessage);
      if (command) {
        this.client?.say(channel, `@${tags.username}, ${command.text}`);
        return;
      }
    }
  }

  public sendMessage(message: string): void {
    if (this.client && this.isRunning) {
      this.settings.channels.forEach(channel => {
        this.client?.say(channel, message);
      });
    }
    else {
      this.chatBoard.error('Bot is not connected.');
    }
  }

  private async handleFeatureResponse(channel: string, tags: tmiTypes.ChatUserstate, message: string, feature: Feature) {
    // AI Response
    if (feature.openAiPrePrompt) {
      const prompt = message.replace(feature.trigger, '').trim();
      try {
        const response = await this.getOpenAIResponse(prompt, feature.openAiPrePrompt);
        this.client?.say(channel, `@${tags.username}, ${response}`);
      }
      catch (error) {
        this.chatBoard.error('Error getting OpenAI response: ' + error);
        this.client?.say(channel, `@${tags.username}, I couldn't get an answer right now Sadge`);
      }
    }

    // Dice Roll
    if (feature.diceSidesNumber) {
      const diceRoll = Math.floor(Math.random() * feature.diceSidesNumber) + 1;
      this.client?.say(channel, `@${tags.username}, you rolled a ${diceRoll}`);
    }

    // Add text command
    if (feature.deleteTrigger) {
      const cmdWithoutTrigger = message.replace(feature.trigger, '').trim();
      const cmdName = cmdWithoutTrigger.split(' ')[0].toLowerCase();
      const cmdText = cmdWithoutTrigger.split(' ').slice(1).join(' ');
      if (!this.settings.commands.some((cmd: Command) => cmd.name === cmdName)) {
        const result = await this.addTextCommand(cmdName, cmdText);
        if (result) {
          this.client?.say(channel, `@${tags.username}, new command added!`);
          this.settings = await this.getSettings();
        }
        else {
          this.client?.say(channel, `@${tags.username}, error adding command Sadge`);
        }
      }
      else {
        this.client?.say(channel, `@${tags.username}, command already exists!`);
      }
    }
  }

  private async addTextCommand(cmdName: string, cmdText: string): Promise<boolean> {
    if (cmdName && cmdText) {
      const response = await RequestHelper.post('./api/addTextCommand', { name: cmdName, text: cmdText, idBot: this.settings.botId });
      if (!response.ok) {
        return false;
      }
      return true;
    }
    return false;
  }
}
