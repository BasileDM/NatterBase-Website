/* eslint-disable @typescript-eslint/no-explicit-any */
import { ConversionUtils } from './ConversionUtils.js';
import { RequestHelper } from './RequestHelper.js';
export class UiUtils {
    static async updateInterface() {
        const botSelector = document.getElementById('bot-profiles-selector');
        const selectedBotIndex = Number(botSelector.selectedIndex) - 1;
        let currentBot = null;
        console.log('Fetching user data:');
        const userData = await RequestHelper.getUserData();
        const user = userData.user;
        console.log('User: ', user);
        this.updateAccountSection(user);
        this.updateBotsList(userData.botProfiles);
        if (selectedBotIndex != undefined && selectedBotIndex >= 0) {
            currentBot = userData.botProfiles[selectedBotIndex];
            this.updateBotSettingsSection(currentBot);
            this.updateBotFeaturesSection(currentBot);
        }
    }
    static updateBotSettingsSection(currentBot) {
        const botSettingsFormElement = document.getElementById('bot-settings-form');
        const placeholder = document.getElementById('bot-settings-placeholder');
        const creationDate = document.getElementById('bot-settings-creation-date');
        const botNameInput = document.getElementById('bot-name');
        const platformInput = document.getElementById('bot-platform');
        const cooldownInput = document.getElementById('bot-cooldown');
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
    }
    static updateBotFeaturesSection(currentBot) {
        console.log('Updating bot features section...', currentBot);
        const placeholder = document.getElementById('bot-features-placeholder');
        if (placeholder) {
            placeholder.classList.add('hidden');
        }
    }
    static updateAccountSection(user) {
        console.log('Updating account section...', user);
    }
    static updateBotsList(bots) {
        console.log('Updating bots list...', bots);
        const botSelector = document.getElementById('bot-profiles-selector');
        if (botSelector) {
            const currentSelectedIndex = botSelector.selectedIndex;
            botSelector.options.length = 1;
            bots.forEach((bot) => {
                botSelector.options.add(new Option(bot.name, bot.id));
            });
            if (currentSelectedIndex != undefined && currentSelectedIndex >= 0) {
                botSelector.selectedIndex = currentSelectedIndex;
            }
        }
    }
}
