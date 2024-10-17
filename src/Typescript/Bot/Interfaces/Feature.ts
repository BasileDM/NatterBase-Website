export interface Feature {
  trigger: string;
  diceSidesNumber?: number | null;
  openAiPrePrompt?: string | null;
  maxOpenAiMessageLength?: number | null;
  deleteTrigger?: string | null;
}