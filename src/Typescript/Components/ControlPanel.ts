import { AbstractFormModal } from './Abstract/AbstractFormModal.js';

export class ControlPanel {
  private botProfileSelector: HTMLSelectElement;
  // eslint-disable-next-line no-undef
  private botProfiles: NodeListOf<HTMLOptionElement>;

  constructor() {
    new AbstractFormModal('create-bot-profile-modal', ['create-bot-profile'], 'create-bot-profile-form');
    this.botProfileSelector = document.getElementById('bot-profiles-selector') as HTMLSelectElement;
    // eslint-disable-next-line no-undef
    this.botProfiles = this.botProfileSelector.querySelectorAll('option') as NodeListOf<HTMLOptionElement>;
    this.bindEvents();
  }

  bindEvents() {
    console.log('Bot profiles: ');
    console.log(this.botProfiles);
    console.log('Binding control panel events...');
  };
}