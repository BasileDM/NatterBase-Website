/* eslint-disable @typescript-eslint/no-explicit-any */
import { ConversionUtils } from './ConversionUtils.js';
import { FormValidator } from './FormValidator.js';
import { RequestHelper } from './RequestHelper.js';
import { UiElements } from './UiElements.js';
export class UiUtils {
    static async updateInterface() {
        const selectedBotIndex = Number(UiElements.botProfileSelector.selectedIndex) - 1;
        let currentBot = null;
        const userData = await RequestHelper.getUserData();
        console.log('Fetched UserData: ', userData);
        const user = userData.user;
        const featuresData = userData.allFeatures;
        this.updateAccountSection(user);
        this.updateBotsList(userData.botProfiles);
        if (selectedBotIndex != undefined && selectedBotIndex >= 0) {
            currentBot = userData.botProfiles[selectedBotIndex];
            this.updateBotSettingsSection(currentBot);
            this.updateBotFeaturesSection(currentBot, featuresData);
            this.updateDashboardSection();
            UiElements.runBotButton.classList.remove('hidden');
            UiElements.runBotBtnDisabled.classList.add('hidden');
        }
        else {
            this.updateBotSettingsSection(null);
            this.updateBotFeaturesSection(null, null);
            this.resetPlaceholders();
            UiElements.runBotButton.classList.add('hidden');
            UiElements.runBotBtnDisabled.classList.remove('hidden');
        }
    }
    static updateDashboardSection() {
        if (UiElements.dashboardPlaceholder) {
            UiElements.dashboardPlaceholder.classList.add('hidden');
        }
    }
    static updateBotSettingsSection(currentBot) {
        if (currentBot == undefined || currentBot == null) {
            if (UiElements.botSettingsForm) {
                UiElements.botSettingsForm.classList.add('hidden');
            }
            if (UiElements.botSettingsPlaceholder) {
                UiElements.botSettingsPlaceholder.classList.remove('hidden');
            }
            return;
        }
        if (UiElements.botSettingsForm) {
            UiElements.botSettingsForm.classList.remove('hidden');
        }
        if (UiElements.botSettingsPlaceholder) {
            UiElements.botSettingsPlaceholder.classList.add('hidden');
        }
        // Update the fields...
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
    static updateBotFeaturesSection(currentBot, featuresData) {
        if (!currentBot || !featuresData) {
            UiElements.botFeaturesDisplay.classList.add('hidden');
            UiElements.botFeaturesPlaceholder.classList.remove('hidden');
            return;
        }
        UiElements.botFeaturesDisplay.classList.remove('hidden');
        UiElements.botFeaturesPlaceholder.classList.add('hidden');
        // Clear existing features
        UiElements.botFeaturesDisplay.innerHTML = '';
        // Get the IDs of features enabled for the current bot
        const enabledFeatureIds = currentBot.botFeatures.map((feature) => feature.idFeature);
        // Render features grouped by category
        featuresData.forEach((category) => {
            const categoryDiv = document.createElement('div');
            const categoryTitle = document.createElement('h3');
            categoryTitle.textContent = category.categoryName;
            categoryDiv.appendChild(categoryTitle);
            category.features.forEach((feature) => {
                const label = document.createElement('label');
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'features';
                checkbox.value = feature.idFeature.toString();
                if (enabledFeatureIds.includes(feature.idFeature)) {
                    checkbox.checked = true;
                }
                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(` ${feature.name}`));
                categoryDiv.appendChild(label);
                categoryDiv.appendChild(document.createElement('br'));
            });
            UiElements.botFeaturesDisplay.appendChild(categoryDiv);
        });
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
    static hideAllSectionsContent() {
        // UiElements.botSettingsForm.classList.add('hidden');
    }
    static resetPlaceholders() {
        if (UiElements.dashboardPlaceholder) {
            UiElements.dashboardPlaceholder.classList.remove('hidden');
        }
        if (UiElements.botSettingsPlaceholder) {
            UiElements.botSettingsPlaceholder.classList.remove('hidden');
        }
        if (UiElements.botFeaturesPlaceholder) {
            UiElements.botFeaturesPlaceholder.classList.remove('hidden');
        }
    }
}
