import { RequestHelper } from './RequestHelper.js';
export class UiUtils {
    static async updateInterface() {
        const botSelector = document.getElementById('bot-profiles-selector');
        const selectedBotIndex = Number(botSelector.selectedIndex) - 1;
        let currentBot = null;
        console.log('Fetching user data:');
        const userData = await RequestHelper.getUserData();
        const user = userData.user;
        console.log(user);
        console.log('Updating interface...');
        this.updateAccountSection();
        if (selectedBotIndex != undefined && selectedBotIndex >= 0) {
            currentBot = userData.botProfiles[selectedBotIndex];
            console.log('Current bot: ', currentBot);
            this.updateBotFeatures();
            this.updateBotSettings();
        }
    }
    static updateBotSettings() {
        console.log('Updating bot settings...');
    }
    static updateBotFeatures() {
        console.log('Updating bot features...');
    }
    static updateAccountSection() {
        console.log('Updating account section...');
    }
}
