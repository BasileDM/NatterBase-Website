import { RequestHelper } from './RequestHelper.js';
export class UiUtils {
    static async updateInterface(selectedBotIndex) {
        const userData = await RequestHelper.getUserData();
        console.log('Updating interface:');
        console.log(userData);
        const currentBot = userData.botProfiles[selectedBotIndex];
        const user = userData.user;
        console.log(currentBot);
        console.log(user);
    }
}
