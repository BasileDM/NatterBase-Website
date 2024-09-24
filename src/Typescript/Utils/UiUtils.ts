/* eslint-disable @typescript-eslint/no-explicit-any */
import { ConversionUtils } from './ConversionUtils.js';
import { FormValidator } from './FormValidator.js';
import { RequestHelper } from './RequestHelper.js';

export class UiUtils {
  public static async updateInterface() {
    const botSelector = document.getElementById('bot-profiles-selector') as HTMLSelectElement;
    const selectedBotIndex = Number(botSelector.selectedIndex) - 1;
    let currentBot = null;
    const runBotButton = document.getElementById('run-bot-btn') as HTMLElement;
    const runBotBtnDisabled = document.getElementById('run-bot-btn-disabled') as HTMLElement;

    console.log('Updating interface. Fetching user data...');
    const userData = await RequestHelper.getUserData();
    console.log('UserData: ', userData);
    const user = userData.user;

    this.updateAccountSection(user);
    this.updateBotsList(userData.botProfiles);
    if (selectedBotIndex != undefined && selectedBotIndex >= 0) {
      currentBot = userData.botProfiles[selectedBotIndex];
      this.updateBotSettingsSection(currentBot);
      this.updateBotFeaturesSection(currentBot);
      this.updateDashboardSection();
      runBotButton.classList.remove('hidden');
      runBotBtnDisabled.classList.add('hidden');
    }
  }

  private static updateDashboardSection() {
    const placeholder = document.getElementById('dashboard-placeholder') as HTMLElement;
    if (placeholder) {
      placeholder.classList.add('hidden');
    }
  }

  private static updateBotSettingsSection(currentBot: any) {
    console.log('Updating bot settings section...', currentBot);
    const botSettingsFormElement = document.getElementById('bot-settings-form') as HTMLFormElement;
    const placeholder = document.getElementById('bot-settings-placeholder') as HTMLElement;
    const creationDate = document.getElementById('bot-settings-creation-date') as HTMLElement;
    const botNameInput = document.getElementById('bot-name') as HTMLInputElement;
    const platformInput = document.getElementById('bot-platform') as HTMLInputElement;
    const cooldownInput = document.getElementById('bot-cooldown') as HTMLInputElement;
    const twitchJoinChannelInput = document.getElementById('account-section-twitch-channel') as HTMLInputElement;
    const OpenAiPrePromptInput = document.getElementById('account-section-openai-pre-prompt') as HTMLInputElement;

    if (botSettingsFormElement) {
      botSettingsFormElement.classList.remove('hidden');
    }

    if (placeholder) {
      placeholder.classList.add('hidden');
    }

    if (creationDate) {
      const localDate = ConversionUtils.UTCtoLocalDate(currentBot.creationDate);
      creationDate.innerText = 'Creation date: ' + localDate;

    }

    if (botNameInput) {
      botNameInput.value = currentBot.name;
    }

    if (platformInput) {
      platformInput.value = currentBot.platformName;
    }

    if (cooldownInput) {
      cooldownInput.value = currentBot.cooldownTime;
    }

    if (twitchJoinChannelInput) {
      twitchJoinChannelInput.value = currentBot.twitchJoinChannel;
    }

    if (OpenAiPrePromptInput) {
      OpenAiPrePromptInput.value = currentBot.openAiPrePrompt;
    }
  }

  private static updateBotFeaturesSection(currentBot: any) {
    console.log('Updating bot features section...', currentBot);
    const placeholder = document.getElementById('bot-features-placeholder') as HTMLElement;
    if (placeholder) {
      placeholder.classList.add('hidden');
    }
  }

  private static updateAccountSection(user: any) {
    console.log('Updating account section...', user);
  }

  private static updateBotsList(bots: any) {
    const botSelector = document.getElementById('bot-profiles-selector') as HTMLSelectElement;

    if (botSelector) {
      const currentSelectedIndex = botSelector.selectedIndex;
      botSelector.options.length = 1;
      bots.forEach((bot: any) => {
        botSelector.options.add(new Option(bot.name, bot.idBot));
      });

      if (currentSelectedIndex != undefined && currentSelectedIndex >= 0) {
        botSelector.selectedIndex = currentSelectedIndex;
      }
      else {
        botSelector.selectedIndex = 0;
        this.resetPlaceholders();
      }
    }
  }

  public static displayAccountPassInputs() {
    const changePassInputsDiv = document.getElementById('account-settings-password-inputs') as HTMLElement;
    const changePassBtn = document.getElementById('account-settings-password-btn') as HTMLElement;
    if (changePassInputsDiv !== null) {
      changePassBtn.classList.add('hidden');
      changePassInputsDiv.classList.remove('hidden');
      const changePassInputs = changePassInputsDiv.querySelectorAll('input');
      if (changePassInputs !== null) {
        changePassInputs.forEach(input => input.disabled = false);
      }
    }
  }

  public static resetAllSections() {
    this.resetAccountSection();
  }

  public static resetAccountSection() {
    const passwordInputs = document.getElementById('account-settings-password-inputs') as HTMLElement;
    if (passwordInputs) {
      passwordInputs.classList.add('hidden');
    }
    const changePassBtn = document.getElementById('account-settings-password-btn') as HTMLElement;
    if (changePassBtn) {
      changePassBtn.classList.remove('hidden');
    }
    FormValidator.removeFormErrors('account-settings-form');
  }

  private static resetPlaceholders() {
    console.log('Resetting placeholders...');
  }
}