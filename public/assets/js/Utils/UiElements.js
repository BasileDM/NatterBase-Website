var _a;
export class UiElements {
}
_a = UiElements;
// Control panel
UiElements.botProfileSelector = document.getElementById('bot-profiles-selector');
UiElements.runBotButton = document.getElementById('run-bot-btn');
UiElements.runBotBtnDisabled = document.getElementById('run-bot-btn-disabled');
// Dashboard section
UiElements.dashboardPlaceholder = document.getElementById('dashboard-placeholder');
UiElements.chatDisplay = document.getElementById('chat-display');
// Account settings section
UiElements.changePassBtn = document.getElementById('account-settings-password-btn');
UiElements.changePassInputsDiv = document.getElementById('account-settings-password-inputs');
UiElements.accountSettingsForm = document.getElementById('account-settings-form');
UiElements.twitchTokenInput = document.getElementById('account-section-twitchToken');
UiElements.openAiKeyInput = document.getElementById('account-section-openAiKey');
UiElements.saveAccountSettingsButton = document.getElementById('account-settings-save-btn');
// Bot settings section
UiElements.botSettingsForm = document.getElementById('bot-settings-form');
UiElements.botSettingsPlaceholder = document.getElementById('bot-settings-placeholder');
UiElements.creationDate = document.getElementById('bot-settings-creation-date');
UiElements.botNameInput = document.getElementById('bot-name');
UiElements.platformInput = document.getElementById('bot-platform');
UiElements.cooldownInput = document.getElementById('bot-cooldown');
UiElements.twitchJoinChannelInput = document.getElementById('account-section-twitch-channel');
UiElements.openAiPrePromptInput = document.getElementById('account-section-openai-pre-prompt');
UiElements.saveBotSettingsButton = document.getElementById('bot-settings-save-btn');
// Bot features section
UiElements.botFeaturesPlaceholder = document.getElementById('bot-features-placeholder');
// Sidebar
UiElements.sidebar = document.getElementById('sidebar');
UiElements.toggleButton = document.getElementById('burger-btn');
UiElements.websiteNavElement = document.getElementById('website-mobile-nav');
// eslint-disable-next-line no-undef
UiElements.appNavButtons = _a.sidebar.querySelectorAll('li[id*="app-nav-button"]');
UiElements.logoutBtn = document.getElementById('sidebar-logout-button');
