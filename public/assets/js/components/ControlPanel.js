import { AbstractFormModal } from './Abstract/AbstractFormModal.js';
export class ControlPanel {
    constructor() {
        new AbstractFormModal('create-bot-profile-modal', ['create-bot-profile'], 'create-bot-profile-form');
        this.botProfileSelector = document.getElementById('bot-profiles-selector');
        // eslint-disable-next-line no-undef
        this.botProfiles = this.botProfileSelector.querySelectorAll('option');
        this.bindEvents();
    }
    bindEvents() {
        console.log('Bot profiles: ');
        console.log(this.botProfiles);
        console.log('Binding control panel events...');
    }
    ;
}
