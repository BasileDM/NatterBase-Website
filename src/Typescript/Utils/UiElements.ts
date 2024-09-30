export class UiElements {
  // Control panel
  public static botProfileSelector = document.getElementById('bot-profiles-selector') as HTMLSelectElement;
  public static runBotButton = document.getElementById('run-bot-btn') as HTMLElement;
  public static runBotBtnDisabled = document.getElementById('run-bot-btn-disabled') as HTMLElement;

  // Dashboard section
  public static dashboardPlaceholder = document.getElementById('dashboard-placeholder') as HTMLElement;
  public static chatDisplay = document.getElementById('chat-display') as HTMLPreElement;

  // Account settings section
  public static changePassBtn = document.getElementById('account-settings-password-btn') as HTMLElement;
  public static changePassInputsDiv = document.getElementById('account-settings-password-inputs') as HTMLDivElement;
  public static accountSettingsForm = document.getElementById('account-settings-form') as HTMLFormElement;
  public static twitchTokenInput = document.getElementById('account-section-twitchToken') as HTMLInputElement;
  public static openAiKeyInput = document.getElementById('account-section-openAiKey') as HTMLInputElement;
  public static saveAccountSettingsButton = document.getElementById('account-settings-save-btn') as HTMLElement;
  public static deleteAccountButton = document.getElementById('account-settings-delete-btn') as HTMLElement;

  // Bot settings section
  public static botSettingsForm = document.getElementById('bot-settings-form') as HTMLFormElement;
  public static botSettingsPlaceholder = document.getElementById('bot-settings-placeholder') as HTMLElement;
  public static creationDate = document.getElementById('bot-settings-creation-date') as HTMLElement;
  public static botNameInput = document.getElementById('bot-name') as HTMLInputElement;
  public static platformInput = document.getElementById('bot-platform') as HTMLInputElement;
  public static cooldownInput = document.getElementById('bot-cooldown') as HTMLInputElement;
  public static twitchJoinChannelInput = document.getElementById('account-section-twitch-channel') as HTMLInputElement;
  public static openAiPrePromptInput = document.getElementById('account-section-openai-pre-prompt') as HTMLInputElement;
  public static saveBotSettingsButton = document.getElementById('bot-settings-save-btn') as HTMLElement;
  public static deleteBotProfileButton = document.getElementById('bot-settings-delete-btn') as HTMLElement;

  // Bot features section
  public static botFeaturesPlaceholder = document.getElementById('bot-features-placeholder') as HTMLElement;
  public static botFeaturesDisplay = document.getElementById('bot-features-display') as HTMLElement;
  public static botFeaturesForm = document.getElementById('bot-features-form') as HTMLFormElement;
  public static saveFeaturesBtn = document.getElementById('bot-features-save-btn') as HTMLElement;
  public static addFeatureBtn = document.getElementById('add-feature-button') as HTMLButtonElement;

  // Sidebar
  public static sidebar = document.getElementById('sidebar') as HTMLElement;
  public static toggleButton = document.getElementById('burger-btn') as HTMLElement;
  public static websiteNavElement = document.getElementById('website-mobile-nav') as HTMLElement;
  // eslint-disable-next-line no-undef
  public static appNavButtons = this.sidebar.querySelectorAll('li[id*="app-nav-button"]') as NodeListOf<HTMLElement>;
  public static logoutBtn = document.getElementById('sidebar-logout-button') as HTMLElement;
}