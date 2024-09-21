import { UiUtils } from '../Utils/UiUtils.js';
import { AbstractFormModal } from './Abstract/AbstractFormModal.js';

export class ControlPanel {
  private botProfileSelector: HTMLSelectElement;
  // eslint-disable-next-line no-undef
  private botProfiles: NodeListOf<HTMLOptionElement>;
  private createProfileModal: AbstractFormModal;

  constructor() {
    this.createProfileModal = new AbstractFormModal('create-bot-profile-modal', ['create-bot-profile'], 'create-bot-profile-form');
    this.botProfileSelector = document.getElementById('bot-profiles-selector') as HTMLSelectElement;
    // eslint-disable-next-line no-undef
    this.botProfiles = this.botProfileSelector.querySelectorAll('option') as NodeListOf<HTMLOptionElement>;
    this.bindEvents();
  }

  protected bindEvents() {
    console.log('Bot profiles: ');
    console.log(this.botProfiles);

    // Bot profile selector
    this.botProfileSelector.addEventListener('change', (event) => {
      const target = event.target as HTMLSelectElement;
      const targetOption = target.options[target.selectedIndex];
      console.log('Selected option value: ' + targetOption.value);
      console.log('Selected option index: ' + targetOption.index);
      console.log('Selected option data index: ' + targetOption.dataset.index);
      UiUtils.updateInterface();
    });
  };
}