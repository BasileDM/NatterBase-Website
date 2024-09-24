export interface BotSettings {
  twitchToken: string;
  openAiKey: string;
  channels: string[];
  cooldown: number;
  maxOpenaiMessageLength: number;
  commands: string[];
  features: string[];
}