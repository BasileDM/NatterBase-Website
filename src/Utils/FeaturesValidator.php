<?php

namespace src\Utils;

final class FeaturesValidator
{
  public static function validateInputs(): array
  {
    $request = json_decode(file_get_contents('php://input'), true);
    $features = $request ?? [];

    $sanitizedFeatures = [];
    $errors = [];

    foreach ($features as $index => $feature) {
      $featureErrors = [];
      $sanitizedFeature = [];

      // Validate 'trigger'
      if (isset($feature['trigger'])) {
        $result = self::validateTrigger($feature['trigger']);
        if (isset($result['error'])) {
          $featureErrors['trigger'] = $result['error'];
        } else {
          $sanitizedFeature['trigger'] = $result['sanitized'];
        }
      } else {
        $featureErrors['trigger'] = 'Trigger is required';
      }

      // Validate 'idBotFeature'
      if (isset($feature['idBotFeature'])) {
        $result = Validator::validateInt($feature['idBotFeature'], 'idBotFeature');
        if (isset($result['error'])) {
          $featureErrors['idBotFeature'] = $result['error'];
        } else {
          $sanitizedFeature['idBotFeature'] = $result['sanitized'];
        }
      } else {
        $featureErrors['idBotFeature'] = 'idBotFeature is required';
      }

      // Validate 'dice_sides_number'
      if (isset($feature['dice_sides_number'])) {
        $result = Validator::validateInt($feature['dice_sides_number'], 'dice_sides_number');
        if (isset($result['error'])) {
          $featureErrors['dice_sides_number'] = $result['error'];
        } else {
          $sanitizedFeature['dice_sides_number'] = $result['sanitized'];
        }
      } else {
        $featureErrors['dice_sides_number'] = 'dice_sides_number is required';
      }

      // If there are errors, add them to the errors array
      if (!empty($featureErrors)) {
        $errors[$index] = $featureErrors;
      } else {
        // Add to sanitized features only if no errors
        $sanitizedFeatures[$index] = $sanitizedFeature;
      }
    }

    // Return only errors if there are any
    if (!empty($errors)) {
      return ['errors' => $errors];
    }

    // If no errors, return sanitized features only
    return ['sanitized' => $sanitizedFeatures];
  }




  private static function validateTrigger(string $trigger): array
  {
    $sanitizedTrigger = filter_var($trigger, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if ($sanitizedTrigger === '' || $trigger != $sanitizedTrigger) {
      return ['error' => 'Invalid trigger'];
    }
    return ['sanitized' => $sanitizedTrigger];
  }
}
