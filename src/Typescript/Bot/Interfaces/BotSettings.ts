export interface BotSettings {
  twitchToken: string;
  openAiKey: string;
  channels: string[];
  cooldown: number;
  openAiPrePrompt: string;
  maxOpenaiMessageLength: number;
  commands: string[];
  features: string[];
}