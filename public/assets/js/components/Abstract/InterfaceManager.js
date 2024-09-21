import { RequestHelper } from '../../Utils/RequestHelper.js';
export class InterfaceManager {
    updateInterface() {
        console.log('Updating interface');
    }
    fetchUserData() {
        const response = RequestHelper.get('/api/user');
    }
}
