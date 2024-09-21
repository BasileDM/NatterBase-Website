import { RequestHelper } from './RequestHelper.js';
export class UiUtils {
    static async updateInterface() {
        const userData = await RequestHelper.getUserData();
        console.log('Updating interface:');
        console.log(userData);
    }
}
