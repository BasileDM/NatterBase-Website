/* eslint-disable no-undef */
/* eslint-disable @typescript-eslint/no-explicit-any */
import { ConversionUtils } from './ConversionUtils.js';
import { FormValidator } from './FormValidator.js';
import { RequestHelper } from './RequestHelper.js';
import { UiElements } from './UiElements.js';

export class UiUtils {
  private static userData: any;

  public static async updateInterface(): Promise<void> {
    const selectedBotIndex = Number(UiElements.botProfileSelector.selectedIndex) - 1;
    let currentBot = null;

    const userData = await RequestHelper.getUserData();
    UiUtils.userData = userData;
    console.log('Fetched UserData: ', userData);
    const user = userData.user;

    this.updateAccountSection(user);
    this.updateBotsList(userData.botProfiles);

    if (selectedBotIndex != undefined && selectedBotIndex >= 0) {
      currentBot = userData.botProfiles[selectedBotIndex];
      this.updateBotSettingsSection(currentBot);
      this.updateBotFeaturesSection(currentBot, userData);
      this.updateDashboardSection();
      UiElements.runBotButton.classList.remove('hidden');
      UiElements.runBotBtnDisabled.classList.add('hidden');
    }
    else {
      this.updateBotSettingsSection(null);
      this.updateBotFeaturesSection(null, null);
      this.resetPlaceholders();
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

    if (UiElements.openAiPrePromptInput) {
      UiElements.openAiPrePromptInput.value = currentBot.openAiPrePrompt;
    }
  }

  private static updateBotFeaturesSection(currentBot: any, userData: any): void {
    if (!currentBot || !userData) {
      UiElements.botFeaturesDisplay.classList.add('hidden');
      UiElements.botFeaturesPlaceholder.classList.remove('hidden');
      return;
    }

    UiElements.botFeaturesDisplay.classList.remove('hidden');
    UiElements.botFeaturesPlaceholder.classList.add('hidden');

    // Clear existing features
    UiElements.botFeaturesDisplay.innerHTML = '';

    // If there are existing features for the current bot, create feature cards for them
    if (currentBot.botFeatures && currentBot.botFeatures.length > 0) {
      currentBot.botFeatures.forEach((botFeature: any) => {
        UiUtils.createFeatureCard(botFeature);
      });
    }

    // Add the 'Add New Feature' button if it doesn't already exist
    if (!document.getElementById('add-feature-button')) {
      const addFeatureButton = document.createElement('button');
      addFeatureButton.id = 'add-feature-button';
      addFeatureButton.textContent = 'Add New Feature';
      addFeatureButton.addEventListener('click', () => {
        UiUtils.addNewFeatureCard();
      });
      UiElements.botFeaturesDisplay.appendChild(addFeatureButton);
    }
  }


  private static updateAccountSection(user: any): void {
    console.log('Updating account section...', user);
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
  private static createFeatureCard(botFeature: any): void {
    const template = document.getElementById('feature-card-template') as HTMLTemplateElement;
    const clone = document.importNode(template.content, true);
    const featureCard = clone.querySelector('.feature-card') as HTMLElement;

    // Set the 'trigger' input value
    const triggerInput = featureCard.querySelector('input[name="trigger"]') as HTMLInputElement;
    triggerInput.value = botFeature.trigger;

    // Populate the 'feature-select' dropdown
    const selectElement = featureCard.querySelector('select[name="feature-select"]') as HTMLSelectElement;
    UiUtils.populateFeatureSelect(selectElement);

    // Set the selected value
    selectElement.value = botFeature.idBotFeature.toString();

    // Add event listener for feature selection
    selectElement.addEventListener('change', (event) => {
      const selectedFeatureId = (event.target as HTMLSelectElement).value;
      UiUtils.updateFeatureFields(featureCard, selectedFeatureId);
    });

    // Populate the feature-specific fields
    UiUtils.updateFeatureFields(featureCard, botFeature.idBotFeature.toString());

    // Set the values of the feature-specific fields
    const featureFieldsContainer = featureCard.querySelector('.feature-fields')!;
    const inputs = featureFieldsContainer.querySelectorAll('input, select, textarea') as NodeListOf<HTMLInputElement>;
    inputs.forEach((input: HTMLInputElement) => {
      const fieldName = input.name;
      input.value = botFeature[fieldName] || '';
    });

    // Append the feature card to 'bot-features-display'
    UiElements.botFeaturesDisplay.appendChild(featureCard);
  }

  static addNewFeatureCard(): void {
    const template = document.getElementById('feature-card-template') as HTMLTemplateElement;
    const clone = document.importNode(template.content, true);
    const featureCard = clone.querySelector('.feature-card') as HTMLElement;

    // Populate the feature selection dropdown
    const selectElement = featureCard.querySelector('select[name="feature-select"]') as HTMLSelectElement;
    UiUtils.populateFeatureSelect(selectElement);

    // Add event listener for feature selection
    selectElement.addEventListener('change', (event) => {
      const selectedFeatureId = (event.target as HTMLSelectElement).value;
      UiUtils.updateFeatureFields(featureCard, selectedFeatureId);
    });

    // Append the feature card to 'bot-features-display'
    const display = document.getElementById('bot-features-display')!;
    display.appendChild(featureCard);
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

    // Clear existing fields
    featureFieldsContainer.innerHTML = '';

    // Get the relevant fields for the selected feature
    const featureFields = UiUtils.getFeatureFields(featureId);

    // For each field, create an input element
    featureFields.forEach((field: any) => {
      const label = document.createElement('label');
      label.textContent = field.label;

      let input: HTMLElement;
      if (field.type === 'select') {
        input = document.createElement('select');
        field.options.forEach((optionValue: string) => {
          const option = document.createElement('option');
          option.value = optionValue;
          option.textContent = optionValue;
          (input as HTMLSelectElement).appendChild(option);
        });
      }
      else {
        input = document.createElement('input');
        (input as HTMLInputElement).type = field.type || 'text';
      }
      input.setAttribute('name', field.name);

      label.appendChild(input);
      featureFieldsContainer.appendChild(label);
      featureFieldsContainer.appendChild(document.createElement('br'));
    });
  }


  static getFeatureFields(featureId: string): any[] {
    // Define the fields relevant to each feature ID
    const featureFieldsMapping: { [key: string]: any[] } = {
      '1': [
        { name: 'dice_sides_number', label: 'Number of sides on the dice', type: 'number' },
      ],
    };
    return featureFieldsMapping[featureId] || [];
  }

}