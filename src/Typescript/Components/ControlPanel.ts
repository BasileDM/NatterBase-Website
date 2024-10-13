/* eslint-disable @typescript-eslint/no-explicit-any */
import { Bot } from '../Bot/Bot.js';
import { FormValidator } from '../Utils/FormValidator.js';
import { RequestHelper } from '../Utils/RequestHelper.js';
import { UiUtils } from '../Utils/UiUtils.js';
import { FormModal } from './Modals/FormModal.js';
import { Toast } from './Toast.js';
import { UiElements } from '../Utils/UiElements.js';
import { ConfirmationModal } from './Modals/ConfirmationModal.js';

export class ControlPanel {
  private bot: Bot | null;
  private confirmationModal: ConfirmationModal;

  constructor() {
    new FormModal(
      'create-bot-profile-modal',
      ['create-bot-profile-btn'],
      'create-bot-profile-form',
    );
    this.bot = null;
    this.bindEvents();

    UiElements.twitchTokenInput.value = sessionStorage.getItem('natterbaseTwitchToken') || '';
    UiElements.openAiKeyInput.value = sessionStorage.getItem('natterbaseOpenAiKey') || '';
    this.confirmationModal = new ConfirmationModal('confirmation-modal');
  }

  private bindEvents(): void {
    // Bot profile selector
    UiElements.botProfileSelector.addEventListener('change', () => {
      UiUtils.updateInterface();
    });

    // Run bot button
    UiElements.runBotButton.addEventListener('click', () => {
      if (!sessionStorage.getItem('natterbaseTwitchToken') && !UiElements.twitchTokenInput.value) {
        new Toast('error', 'Set a Twitch token in "Local keys" to run the bot.');
        return;
      }
      if (!UiElements.twitchJoinChannelInput.value || UiElements.twitchJoinChannelInput.value === '') {
        new Toast('error', 'Set a Twitch channel to join in "Bot settings".');
        return;
      }
      if (!sessionStorage.getItem('natterbaseOpenAiKey') && !UiElements.openAiKeyInput.value && (!this.bot || !this.bot.isRunning)) {
        this.confirmationModal.open('You didn\'t set an OpenAI API key. AI related features will not work. Do you want to continue?', () => {
          this.runBot();
          return;
        });
      }
      else {
        this.runBot();
        return;
      }
    });

    // Save bot settings button
    UiElements.saveBotSettingsButton.addEventListener('click', async () => {
      this.submitBotSettings();
    });
    // Delete bot profile button
    UiElements.deleteBotProfileButton.addEventListener('click', async () => {
      this.deleteBotProfile();
    });

    // Local keys
    UiElements.twitchTokenInput.addEventListener('change', () => {
      sessionStorage.setItem('natterbaseTwitchToken', UiElements.twitchTokenInput.value);
    });
    UiElements.openAiKeyInput.addEventListener('change', () => {
      sessionStorage.setItem('natterbaseOpenAiKey', UiElements.openAiKeyInput.value);
    });

    // Save account settings button
    UiElements.saveAccountSettingsButton.addEventListener('click', async () => {
      this.submitAccountSettings();
    });
    // Delete account button
    UiElements.deleteAccountButton.addEventListener('click', async () => {
      this.deleteAccount();
    });

    // Change password button
    UiElements.changePassBtn.addEventListener('click', async () => {
      UiUtils.displayAccountPassInputs();
    });

    // Bot features
    UiElements.botFeaturesForm.addEventListener('submit', async (event: SubmitEvent) => {
      event.preventDefault();
      this.submitBotFeatures();
    });
    if (UiElements.addFeatureBtn) {
      UiElements.addFeatureBtn.addEventListener('click', () => {
        UiUtils.addNewFeatureCard();
      });
    }
  }

  private runBot(): void {
    if (this.bot && this.bot.isRunning) {
      this.bot.stop();
      UiElements.runBotButton.classList.add('btn-success');
      UiElements.runBotButton.classList.remove('btn-alert');
      UiElements.runBotText.innerText = 'Run bot';
      // Play icon
      UiElements.runBotIcon.innerHTML = '<path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z" />';
    }
    else if (this.bot) {
      this.bot.start();
      UiElements.runBotButton.classList.remove('btn-success');
      UiElements.runBotButton.classList.add('btn-alert');
      UiElements.runBotText.innerText = 'Stop bot';
      // Stop icon
      UiElements.runBotIcon.innerHTML = '<path d="M324-636v312-312ZM218-218v-524h524v524H218Zm106-106h312v-312H324v312Z"/>';
    }
    else {
      this.bot = new Bot();
      this.bot.start();
      UiElements.runBotButton.classList.remove('btn-success');
      UiElements.runBotButton.classList.add('btn-alert');
      UiElements.runBotText.innerText = 'Stop bot';
      // Stop icon
      UiElements.runBotIcon.innerHTML = '<path d="M324-636v312-312ZM218-218v-524h524v524H218Zm106-106h312v-312H324v312Z"/>';
    }
  }

  private async submitBotSettings(): Promise<void> {
    const formData = new FormData(UiElements.botSettingsForm);
    const formObject = Object.fromEntries(formData.entries());
    try {
      const botId = UiElements.botProfileSelector.value;
      const response = await RequestHelper.post(`./updateBotProfile?idBot=${botId}`, formObject);
      const jsonResponseBody = await RequestHelper.handleResponse(response);
      if (!jsonResponseBody) {
        return;
      }

      if (jsonResponseBody.formErrors) {
        new FormValidator('bot-settings-form').displayFormErrors(jsonResponseBody.formErrors);
        return;
      }

      new Toast('success', jsonResponseBody.message);
      UiElements.changePassInputsDiv.classList.add('hidden');
      UiElements.changePassBtn.classList.remove('hidden');
      UiUtils.updateInterface();
    }
    catch (error) {
      console.error('Unexpected error: ', error);
      new Toast('error', 'Failed sending request. Try again later.');
    }
  }

  private async deleteBotProfile(): Promise<void> {
    this.confirmationModal.open('Are you sure you want to delete this bot profile?', async () => {
      try {
        const botId = UiElements.botProfileSelector.value;
        const response = await RequestHelper.delete(`./deleteBotProfile?idBot=${botId}`);
        const jsonResponseBody = await RequestHelper.handleResponse(response);
        if (!jsonResponseBody) {
          return;
        }

        new Toast('success', jsonResponseBody.message);
        UiElements.botProfileSelector.selectedIndex = 0;
        UiUtils.updateInterface();
      }
      catch (error) {
        console.error('Unexpected error: ', error);
        new Toast('error', 'Failed sending request. Try again later.');
      }
    });
  }

  private async submitAccountSettings() {
    const formData = new FormData(UiElements.accountSettingsForm);
    const formObject = Object.fromEntries(formData.entries());
    try {
      const response = await RequestHelper.post('./api/updateUserData', formObject);
      const jsonResponseBody = await RequestHelper.handleResponse(response);

      if (!jsonResponseBody) {
        return;
      }

      if (jsonResponseBody.formErrors) {
        new FormValidator('account-settings-form').displayFormErrors(jsonResponseBody.formErrors);
        return;
      }

      new Toast('success', 'Account settings updated!');
      UiUtils.updateInterface();
    }
    catch (error) {
      console.error('Unexpected error: ', error);
      new Toast('error', 'Failed sending request. Try again later.');
    }
  }

  private async deleteAccount() {
    this.confirmationModal.open('This is permanent! Are you sure you want to delete your account?', async () => {
      try {
        const response = await RequestHelper.delete('./api/deleteUser');
        const jsonResponseBody = await RequestHelper.handleResponse(response);
        if (!jsonResponseBody) {
          return;
        }

        new Toast('success', jsonResponseBody.message);
        sessionStorage.clear();
        window.location.href = '/logout';
      }
      catch (error) {
        console.error('Unexpected error: ', error);
        new Toast('error', 'Failed sending request. Try again later.');
      }
    });
  }

  private async submitBotFeatures(): Promise<void> {
    const formObject: any = {};

    // Collect feature data based on data-index attribute
    const featureCards = UiElements.botFeaturesForm.querySelectorAll('.feature-card');
    featureCards.forEach((card) => {
      const featureData: any = {};
      const index = card.getAttribute('data-index') || '0';

      // Collect inputs within the current feature card
      const inputs = card.querySelectorAll('input, select, textarea');
      inputs.forEach((inputElement) => {
        if (
          inputElement instanceof HTMLInputElement ||
          inputElement instanceof HTMLSelectElement ||
          inputElement instanceof HTMLTextAreaElement
        ) {
          featureData[inputElement.name] = inputElement.value;
        }
      });

      // Assign the feature data to the formObject using the index as a key
      formObject[index] = featureData;
    });

    try {
      const botId = UiElements.botProfileSelector.value;
      const response = await RequestHelper.post(`./updateBotFeatures?idBot=${botId}`, formObject);
      const jsonResponseBody = await RequestHelper.handleResponse(response);
      if (!jsonResponseBody) {
        return;
      }

      if (jsonResponseBody.formErrors) {
        new FormValidator('bot-features-form').displayFormErrors(jsonResponseBody.formErrors);
        return;
      }

      new Toast('success', 'Bot features updated successfully!');
      UiUtils.updateInterface();
    }
    catch (error) {
      console.error('Unexpected error: ', error);
      new Toast('error', 'Failed to save bot features. Try again later.');
    }
  }
}
