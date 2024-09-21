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
        this.botProfileSelector.addEventListener('change', (event) => {
            const target = event.target;
            const targetOption = target.options[target.selectedIndex];
            // console.log('Selected option value: ' + targetOption.value);
            // console.log('Selected option index: ' + targetOption.index);
            // console.log('Selected option data index: ' + targetOption.dataset.index);
            const selectedIndex = targetOption.dataset.index;
            if (selectedIndex) {
                UiUtils.updateInterface(parseInt(selectedIndex, 10));
            }
        });
    }
    ;
}
