import { RequestHelper } from './RequestHelper.js';
export class UiUtils {
    static async updateInterface(selectedBotIndex = null) {
        console.log('Fetching user data:');
        let currentBot = null;
        const userData = await RequestHelper.getUserData();
        const user = userData.user;
        console.log(user);
        console.log('Updating interface...');
        if (selectedBotIndex !== null) {
            currentBot = userData.botProfiles[selectedBotIndex];
            console.log(currentBot);
            this.updateBotFeatures();
            this.updateBotSettings();
        }
        this.updateAccountSection();
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
