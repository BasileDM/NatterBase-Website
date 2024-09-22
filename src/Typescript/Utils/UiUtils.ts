/* eslint-disable @typescript-eslint/no-explicit-any */
import { ConversionUtils } from './ConversionUtils.js';
import { RequestHelper } from './RequestHelper.js';

export class UiUtils {
  public static async updateInterface() {
    const botSelector = document.getElementById('bot-profiles-selector') as HTMLSelectElement;
    const selectedBotIndex = Number(botSelector.selectedIndex) - 1;
    let currentBot = null;

    console.log('Fetching user data:');
    const userData = await RequestHelper.getUserData();
    const user = userData.user;
    console.log('User: ', user);

    this.updateAccountSection();
    if (selectedBotIndex != undefined && selectedBotIndex >= 0) {
      currentBot = userData.botProfiles[selectedBotIndex];
      console.log('Current bot: ', currentBot);
      this.updateBotSettingsSection(currentBot);
      this.updateBotFeaturesSection();
    }
  }

  public static updateBotSettingsSection(currentBot: any) {
    const placeholder = document.getElementById('bot-settings-placeholder') as HTMLElement;
    const creationDate = document.getElementById('bot-settings-creation-date') as HTMLElement;
    const botNameInput = document.getElementById('bot-name') as HTMLInputElement;
    const platformInput = document.getElementById('bot-platform') as HTMLInputElement;
    const cooldownInput = document.getElementById('bot-cooldown') as HTMLInputElement;

    if (placeholder) {
      placeholder.classList.add('hidden');
    }

    if (creationDate) {
      const localDate = ConversionUtils.UTCtoLocalDate(currentBot.creationDate);
      creationDate.innerText = 'Creation date: ' + localDate;

    }

    if (botNameInput && currentBot) {
      botNameInput.value = currentBot.name;
    }

    if (platformInput && currentBot) {
      platformInput.value = currentBot.platformName;
    }

    if (cooldownInput && currentBot) {
      cooldownInput.value = currentBot.cooldownTime;
    }
  }

  public static updateBotFeaturesSection() {
    console.log('Updating bot features...');
  }

  public static updateAccountSection() {
    console.log('Updating account section...');
  }
}