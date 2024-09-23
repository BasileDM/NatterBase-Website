export interface BotSettings {
  channels: string[];
  cooldown: number;
  openAiKey: string;
  maxOpenaiMessageLength: number;
  commands: string[];
  features: string[];
}