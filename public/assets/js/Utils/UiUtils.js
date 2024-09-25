/* eslint-disable @typescript-eslint/no-explicit-any */
import { ConversionUtils } from './ConversionUtils.js';
import { FormValidator } from './FormValidator.js';
import { RequestHelper } from './RequestHelper.js';
import { UiElements } from './UiElements.js';
export class UiUtils {
    static async updateInterface() {
        const selectedBotIndex = Number(UiElements.botProfileSelector.selectedIndex) - 1;
        let currentBot = null;
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
            UiElements.runBotButton.classList.remove('hidden');
            UiElements.runBotBtnDisabled.classList.add('hidden');
        }
    }
    static updateDashboardSection() {
        if (UiElements.dashboardPlaceholder) {
            UiElements.dashboardPlaceholder.classList.add('hidden');
        }
    }
    static updateBotSettingsSection(currentBot) {
        console.log('Updating bot settings section...', currentBot);
        if (UiElements.botSettingsForm) {
            UiElements.botSettingsForm.classList.remove('hidden');
        }
        if (UiElements.botSettingsPlaceholder) {
            UiElements.botSettingsPlaceholder.classList.add('hidden');
        }
        if (UiElements.creationDate) {
            const localDate = ConversionUtils.UTCtoLocalDate(currentBot.creationDate);
            UiElements.creationDate.innerText = 'Creation date: ' + localDate;
        }
        if (UiElements.botNameInput) {
            UiElements.botNameInput.value = currentBot.name;
        }
        if (UiElements.platformInput) {
            UiElements.platformInput.value = currentBot.platformName;
        }
        if (UiElements.cooldownInput) {
            UiElements.cooldownInput.value = currentBot.cooldownTime;
        }
        if (UiElements.twitchJoinChannelInput) {
            UiElements.twitchJoinChannelInput.value = currentBot.twitchJoinChannel;
        }
        if (UiElements.openAiPrePromptInput) {
            UiElements.openAiPrePromptInput.value = currentBot.openAiPrePrompt;
        }
    }
    static updateBotFeaturesSection(currentBot) {
        console.log('Updating bot features section...', currentBot);
        if (UiElements.botFeaturesPlaceholder) {
            UiElements.botFeaturesPlaceholder.classList.add('hidden');
        }
    }
    static updateAccountSection(user) {
        console.log('Updating account section...', user);
    }
    static updateBotsList(bots) {
        if (UiElements.botProfileSelector) {
            const currentSelectedIndex = UiElements.botProfileSelector.selectedIndex;
            UiElements.botProfileSelector.options.length = 1;
            bots.forEach((bot) => {
                UiElements.botProfileSelector.options.add(new Option(bot.name, bot.idBot));
            });
            if (currentSelectedIndex != undefined && currentSelectedIndex >= 0) {
                UiElements.botProfileSelector.selectedIndex = currentSelectedIndex;
            }
            else {
                UiElements.botProfileSelector.selectedIndex = 0;
                this.resetPlaceholders();
            }
        }
    }
    static displayAccountPassInputs() {
        if (UiElements.changePassInputsDiv !== null) {
            UiElements.changePassBtn.classList.add('hidden');
            UiElements.changePassInputsDiv.classList.remove('hidden');
            const changePassInputs = UiElements.changePassInputsDiv.querySelectorAll('input');
            if (changePassInputs !== null) {
                changePassInputs.forEach(input => input.disabled = false);
            }
        }
    }
    static resetAllSections() {
        this.resetAccountSection();
    }
    static resetAccountSection() {
        if (UiElements.changePassInputsDiv) {
            UiElements.changePassInputsDiv.classList.add('hidden');
        }
        if (UiElements.changePassBtn) {
            UiElements.changePassBtn.classList.remove('hidden');
        }
        FormValidator.removeFormErrors('account-settings-form');
    }
    static resetPlaceholders() {
        console.log('Resetting placeholders...');
    }
}
