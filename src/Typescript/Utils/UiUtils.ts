import { RequestHelper } from './RequestHelper.js';

export class UiUtils {
  public static async updateInterface(selectedBotIndex: number|null = null) {
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

  public static updateBotSettings() {
    console.log('Updating bot settings...');
  }

  public static updateBotFeatures() {
    console.log('Updating bot features...');
  }

  public static updateAccountSection() {
    console.log('Updating account section...');
  }
}