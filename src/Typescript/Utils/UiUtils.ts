/* eslint-disable @typescript-eslint/no-explicit-any */
import { ConversionUtils } from './ConversionUtils.js';
import { FormValidator } from './FormValidator.js';
import { RequestHelper } from './RequestHelper.js';
import { UiElements } from './UiElements.js';
import { FeatureField } from '../Interfaces/FeatureField.js';
import { Toast } from '../Components/Toast.js';

export class UiUtils {
  private static userData: any;

  public static async updateInterface(): Promise<void> {
    const selectedBotIndex = Number(UiElements.botProfileSelector.selectedIndex) - 1;
    let currentBot = null;

    const userData = await RequestHelper.getUserData();
    UiUtils.userData = userData;

    this.updateAccountSection();
    this.updateBotsList(userData.botProfiles);

    if (selectedBotIndex != undefined && selectedBotIndex >= 0) {
      currentBot = userData.botProfiles[selectedBotIndex];
      this.updateBotSettingsSection(currentBot);
      this.updateBotFeaturesSection(currentBot, userData);
      this.updateDashboardSection();
      UiElements.runBotButton.classList.remove('hidden');
      UiElements.runBotButton.classList.add('flex');
      UiElements.runBotBtnDisabled.classList.add('hidden');
    }
    else {
      this.updateBotSettingsSection(null);
      this.updateBotFeaturesSection(null, null);
      this.resetPlaceholders();
      UiElements.runBotButton.classList.remove('flex');
      UiElements.runBotButton.classList.add('hidden');
      UiElements.runBotBtnDisabled.classList.remove('hidden');
    }
  }

  private static updateDashboardSection(): void {
    if (UiElements.dashboardPlaceholder) {
      UiElements.dashboardPlaceholder.classList.add('hidden');
    }
  }

  private static updateBotSettingsSection(currentBot: any) {
    if (currentBot == undefined || currentBot == null) {
      if (UiElements.botSettingsForm) {
        UiElements.botSettingsForm.classList.add('hidden');
      }

      if (UiElements.botSettingsPlaceholder) {
        UiElements.botSettingsPlaceholder.classList.remove('hidden');
      }
      return;
    }

    if (UiElements.botSettingsForm) {
      UiElements.botSettingsForm.classList.remove('hidden');
    }

    if (UiElements.botSettingsPlaceholder) {
      UiElements.botSettingsPlaceholder.classList.add('hidden');
    }

    // Update the fields...
    if (UiElements.creationDate) {
      const localDate = ConversionUtils.UTCtoLocalDate(currentBot.creationDate);
      UiElements.creationDate.innerText = 'Creation date: ' + localDate;
    }

    if (UiElements.botNameInput) {
      UiElements.botNameInput.value = currentBot.name;
    }

    if (UiElements.platformInput) {
      UiElements.platformInput.value = currentBot.platformName;
    }

    if (UiElements.cooldownInput) {
      UiElements.cooldownInput.value = currentBot.cooldownTime;
    }

    if (UiElements.twitchJoinChannelInput) {
      UiElements.twitchJoinChannelInput.value = currentBot.twitchJoinChannel;
    }
  }

  private static updateBotFeaturesSection(currentBot: any, userData: any): void {
    if (!currentBot || !userData) {
      UiElements.botFeaturesDisplay.classList.add('hidden');
      UiElements.botFeaturesPlaceholder.classList.remove('hidden');
      UiElements.saveFeaturesBtn.classList.add('hidden');
      UiElements.addFeatureBtn.classList.add('hidden');
      return;
    }

    UiElements.botFeaturesDisplay.classList.remove('hidden');
    UiElements.saveFeaturesBtn.classList.remove('hidden');
    UiElements.addFeatureBtn.classList.remove('hidden');
    UiElements.botFeaturesPlaceholder.classList.add('hidden');

    if (currentBot.botFeatures.length === 0) {
      UiElements.saveFeaturesBtn.classList.add('hidden');
    }

    // Clear existing features
    UiElements.botFeaturesDisplay.innerHTML = '';

    // If there are existing features for the current bot, create feature cards for them
    if (currentBot.botFeatures && currentBot.botFeatures.length > 0) {
      currentBot.botFeatures.forEach((botFeature: any, index: number) => {
        UiUtils.createFeatureCard(botFeature, index);
      });
    }
  }

  private static updateAccountSection(): void {
    FormValidator.removeFormErrors('account-settings-form');
    UiElements.changePassInputsDiv.classList.add('hidden');
    const inputs = UiElements.changePassInputsDiv.getElementsByTagName('input');
    for (let i = 0; i < inputs.length; i++) {
      inputs[i].value = '';
    }
    UiElements.changePassBtn.classList.remove('hidden');
  }

  private static updateBotsList(bots: any): void {
    if (UiElements.botProfileSelector) {
      const currentSelectedIndex = UiElements.botProfileSelector.selectedIndex;
      UiElements.botProfileSelector.options.length = 1;
      bots.forEach((bot: any) => {
        UiElements.botProfileSelector.options.add(new Option(bot.name, bot.idBot));
      });

      if (currentSelectedIndex != undefined && currentSelectedIndex >= 0) {
        UiElements.botProfileSelector.selectedIndex = currentSelectedIndex;
      }
      else {
        UiElements.botProfileSelector.selectedIndex = 0;
        this.resetPlaceholders();
      }
    }
  }

  public static displayAccountPassInputs(): void {
    if (UiElements.changePassInputsDiv !== null) {
      UiElements.changePassBtn.classList.add('hidden');
      UiElements.changePassInputsDiv.classList.remove('hidden');
      const changePassInputs = UiElements.changePassInputsDiv.querySelectorAll('input');
      if (changePassInputs !== null) {
        changePassInputs.forEach(input => input.disabled = false);
      }
    }
  }

  public static resetAllSections(): void {
    this.resetAccountSection();
  }

  public static resetAccountSection(): void {
    if (UiElements.changePassInputsDiv) {
      UiElements.changePassInputsDiv.classList.add('hidden');
    }
    if (UiElements.changePassBtn) {
      UiElements.changePassBtn.classList.remove('hidden');
    }
    FormValidator.removeFormErrors('account-settings-form');
  }

  public static hideAllSectionsContent(): void {
    // UiElements.botSettingsForm.classList.add('hidden');
  }

  public static resetPlaceholders(): void {
    if (UiElements.dashboardPlaceholder) {
      UiElements.dashboardPlaceholder.classList.remove('hidden');
    }
    if (UiElements.botSettingsPlaceholder) {
      UiElements.botSettingsPlaceholder.classList.remove('hidden');
    }
    if (UiElements.botFeaturesPlaceholder) {
      UiElements.botFeaturesPlaceholder.classList.remove('hidden');
    }
  }

  /**
   *
   * Bot features methods
   *
   */
  private static createFeatureCard(botFeature: any, index: number): void {
    const template = document.getElementById('feature-card-template') as HTMLTemplateElement;
    const clone = document.importNode(template.content, true);
    const featureCard = clone.querySelector('.feature-card') as HTMLElement;
    featureCard.setAttribute('data-index', index.toString());

    // Used to avoid doing a fetch upon deletion
    if (!botFeature) {
      featureCard.dataset.isNew = true.toString();
    }

    // Set the 'trigger' input value and ID
    const triggerInput = featureCard.querySelector('input[name="trigger"]') as HTMLInputElement;
    triggerInput.id = `feature-trigger-${index}`;
    triggerInput.value = botFeature ? botFeature.trigger : '';

    // Set the label's for attribute
    const triggerLabel = featureCard.querySelector('label[for="trigger-input"]') as HTMLLabelElement;
    triggerLabel.htmlFor = triggerInput.id;

    // Populate the 'feature-select' dropdown
    const selectElement = featureCard.querySelector('select[name="feature-select"]') as HTMLSelectElement;
    selectElement.name = 'idBotFeature';
    selectElement.id = `feature-select-${index}`;
    UiUtils.populateFeatureSelect(selectElement);

    // Set the 'feature-select' label's for attribute
    const featureSelectLabel = featureCard.querySelector('label[for="feature-select"]') as HTMLLabelElement;
    featureSelectLabel.htmlFor = selectElement.id;

    // Set the selected value
    if (botFeature) {
      selectElement.value = botFeature.idBotFeature;
    }

    // Event listener for feature selection
    selectElement.addEventListener('change', (event) => {
      const selectedFeatureId = (event.target as HTMLSelectElement).value;
      UiUtils.updateFeatureFields(featureCard, selectedFeatureId);
    });

    // Event listener for the 'remove feature' button
    const removeFeatureButton = featureCard.querySelector('.remove-feature-button') as HTMLButtonElement;
    removeFeatureButton.addEventListener('click', async () => {
      if (featureCard.dataset.isNew === 'true') {
        featureCard.remove();
        if (UiElements.botFeaturesDisplay.childElementCount === 0) {
          UiElements.saveFeaturesBtn.classList.add('hidden');
        }
        return;
      }
      const response = await RequestHelper.delete(`./deleteBotFeature?idBot=${botFeature.idBot}&idFeature=${botFeature.idBotFeature}&trigger=${botFeature.trigger}`);
      const jsonResponseBody = await RequestHelper.handleResponse(response);
      if (!jsonResponseBody) {
        return;
      }
      new Toast('success', jsonResponseBody.message);
      featureCard.remove();
    });

    // Populate the feature-specific fields
    UiUtils.updateFeatureFields(featureCard, selectElement.value);

    // Set the values of the feature-specific fields
    if (botFeature) {
      const featureFieldsContainer = featureCard.querySelector('.feature-fields')!;
      const inputs = featureFieldsContainer.querySelectorAll('input, select, textarea');
      inputs.forEach((inputElement) => {
        if (inputElement instanceof HTMLInputElement || inputElement instanceof HTMLSelectElement || inputElement instanceof HTMLTextAreaElement) {
          const fieldName = inputElement.getAttribute('data-field-name')!;
          inputElement.name = `${fieldName}`;
          inputElement.value = botFeature[fieldName] || '';
        }
      });
    }

    // Append the feature card to 'bot-features-display'
    UiElements.botFeaturesDisplay.appendChild(featureCard);
    UiElements.saveFeaturesBtn.classList.remove('hidden');
  }

  // Add a new feature card (called when clicking the 'Add New Feature' button)
  static addNewFeatureCard(): void {
    const index = UiElements.botFeaturesDisplay.querySelectorAll('.feature-card').length;
    UiUtils.createFeatureCard(null, index);
  }

  static populateFeatureSelect(selectElement: HTMLSelectElement): void {
    // Clear existing options
    selectElement.innerHTML = '';

    // Create options and options groups for each feature
    UiUtils.userData.allCategories.forEach((category: any) => {
      const optgroup = document.createElement('optgroup');
      optgroup.label = category.name;

      UiUtils.userData.allFeatures
        .filter((feature: any) => feature.idBotFeatureCategory === category.id_bot_feature_category)
        .forEach((feature: any) => {
          const option = document.createElement('option');
          option.value = feature.idBotFeature.toString();
          option.textContent = feature.name;
          optgroup.appendChild(option);
        });

      selectElement.appendChild(optgroup);
    });
  }

  private static updateFeatureFields(featureCard: HTMLElement, featureId: string): void {
    const featureFieldsContainer = featureCard.querySelector('.feature-fields') as HTMLElement;
    featureFieldsContainer.innerHTML = '';

    // Get the relevant fields for the selected feature
    const featureFields: FeatureField[] = UiUtils.getFeatureFields(featureId);

    if (!featureFields || featureFields.length === 0) {
      return;
    }

    // For each field, create an input element with styling
    featureFields.forEach((field) => {
      const fieldWrapper = document.createElement('div');
      fieldWrapper.classList.add('mb-2');

      const label = document.createElement('label');
      label.textContent = field.label;
      label.classList.add('block', 'text-sm', 'font-medium', 'mb-1');

      let input: HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement;
      if (field.type === 'select') {
        input = document.createElement('select');
        input.classList.add('w-full', 'p-2', 'bg-gray-700', 'text-white', 'rounded');
        if (field.options && field.options.length > 0) {
          field.options.forEach((optionValue: string) => {
            const option = document.createElement('option');
            option.value = optionValue;
            option.textContent = optionValue;
            input.appendChild(option);
          });
        }
      }
      else if (field.type === 'textarea') {
        input = document.createElement('textarea');
        input.classList.add('w-full', 'p-2', 'bg-gray-700', 'text-white', 'rounded');
      }
      else {
        input = document.createElement('input');
        input.type = field.type || 'text';
        input.classList.add('w-full', 'p-2', 'bg-gray-700', 'text-white', 'rounded');
      }

      const inputName = `${field.name}`;
      input.setAttribute('name', inputName);
      input.setAttribute('data-field-name', field.name);

      // Error display span element
      const errorDisplay = document.createElement('span');
      errorDisplay.setAttribute('id', `${inputName}-error-display`);
      errorDisplay.classList.add('text-red-500', 'text-sm', 'mt-1');

      fieldWrapper.appendChild(label);
      fieldWrapper.appendChild(input);
      fieldWrapper.appendChild(errorDisplay);
      featureFieldsContainer.appendChild(fieldWrapper);
    });
  }

  static getFeatureFields(featureId: string): FeatureField[] {
    // Define the fields relevant to each feature ID
    const featureFieldsMapping: { [key: string]: FeatureField[] } = {
      '1': [
        { name: 'diceSidesNumber', label: 'Number of sides on the dice', type: 'number' },
      ],
      '2': [
        { name: 'openAiPrePrompt', label: 'OpenAI pre-prompt', type: 'textarea' },
        { name: 'maxOpenaiMessageLength', label: 'Max message length', type: 'number' },
      ],
      '3': [
        { name: 'deleteTrigger', label: 'Delete trigger', type: 'text' },
      ],
    };
    return featureFieldsMapping[featureId] || [];
  }
}