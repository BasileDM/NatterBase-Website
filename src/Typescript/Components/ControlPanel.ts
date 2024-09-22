import { UiUtils } from '../Utils/UiUtils.js';
import { AbstractFormModal } from './Abstract/AbstractFormModal.js';

export class ControlPanel {
  private botProfileSelector: HTMLSelectElement;

  constructor() {
    new AbstractFormModal(
      'create-bot-profile-modal',
      ['create-bot-profile-btn'],
      'create-bot-profile-form',
    );
    this.botProfileSelector = document.getElementById('bot-profiles-selector') as HTMLSelectElement;
    this.bindEvents();
  }

  private bindEvents() {
    // Bot profile selector
    this.botProfileSelector.addEventListener('change', () => {
      UiUtils.updateInterface();
    });
  };
}