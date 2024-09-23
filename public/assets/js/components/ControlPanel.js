import { UiUtils } from '../Utils/UiUtils.js';
import { AbstractFormModal } from './Abstract/AbstractFormModal.js';
export class ControlPanel {
    constructor() {
        new AbstractFormModal('create-bot-profile-modal', ['create-bot-profile-btn'], 'create-bot-profile-form');
        this.botProfileSelector = document.getElementById('bot-profiles-selector');
        this.bindEvents();
    }
    bindEvents() {
        // Bot profile selector
        this.botProfileSelector.addEventListener('change', () => {
            UiUtils.updateInterface();
        });
    }
    ;
}
