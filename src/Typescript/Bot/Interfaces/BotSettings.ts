import { Feature } from './Feature.js';

export interface BotSettings {
  twitchToken: string;
  openAiKey: string;
  channels: string[];
  cooldown: number;
  commands: string[];
  features: Feature[];
}