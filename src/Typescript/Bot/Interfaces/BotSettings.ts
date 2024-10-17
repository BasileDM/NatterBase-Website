import { Feature } from './Feature.js';

export interface BotSettings {
  botId: number;
  twitchToken: string;
  openAiKey: string;
  channels: string[];
  cooldown: number;
  commands: string[];
  features: Feature[];
}