import { Toast } from './Components/Toast.js';
// Display the login success message stored by the Login modal
const toastMessage = sessionStorage.getItem('showToast');
if (toastMessage) {
    new Toast('success', toastMessage);
    sessionStorage.removeItem('showToast');
}