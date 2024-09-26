<?php

namespace src\Services;

use DateTime;
use Exception;
use src\Models\Bot;
use src\Models\BotFeature;
use src\Repositories\BotRepository;
use src\Repositories\CommandRepository;
use src\Repositories\FeatureRepository;
use src\Repositories\UserRepository;

final class BotService
{
  private UserRepository $userRepository;
  private BotRepository $botRepository;
  private CommandRepository $commandRepository;
  private FeatureRepository $featureRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
    $this->botRepository = new BotRepository();
    $this->commandRepository = new CommandRepository();
    $this->featureRepository = new FeatureRepository();
  }

  public function create(array $inputs): Bot|false
  {
    $newBot = new Bot();
    // Adding idUser as a key of the saneInputs assoc array for hydration
    $inputs += ['idUser' => $_SESSION['userId']];
    $newBot->hydrateFromInputs($inputs);
    $existingBot = $this->botRepository->getByNameAndUserId($newBot->getName(), $newBot->getIdUser());
    if ($existingBot) return false;
    else {
      $newBot->setCreationDate((new DateTime())->format('Y-m-d H:i:s'));
      return $this->botRepository->insert($newBot);
    }
  }

  public function getBotsByUserId(int $userId): array
  {
    $bots = $this->botRepository->getByUserId($userId);

    foreach ($bots as $bot) {
      $this->populateBotRelations($bot);
    }

    return $bots;
  }

  public function getBotById(int $botId): Bot|false
  {
    $bot = $this->botRepository->getById($botId);
    if ($bot !== null && $bot !== false) {
      $this->populateBotRelations($bot);
    } else {
      return false;
    }
    return $bot;
  }

  private function populateBotRelations(Bot $bot): void
  {
    $botId = $bot->getIdBot();

    $commands = $this->commandRepository->getByBotId($botId);
    $features = $this->featureRepository->getByBotId($botId);

    $bot->setBotCommands($commands);
    $bot->setBotFeatures($features);
  }

  public function getUserBotsArray(int $userId): array
  {
    $bots = $this->getBotsByUserId($userId);
    
    $botsArray = array_map(fn(Bot $bot) => $bot->toArray(), $bots);
    return $botsArray;
  }

  public function getBotSettings(int $botId): array
  {
    $bot = $this->getBotById($botId);
    if ($bot === false) {
      return [];
    }
    $botSettings = $bot->toArray();
    return $botSettings;
  }

  public function update(array $inputs, int $botId): bool
  {
    $bot = $this->getBotById($botId);
    if ($bot === false || $bot->getIdUser() !== $_SESSION['userId']) {
      return false;
    }
    $bot->hydrateFromInputs($inputs);
    return $this->botRepository->update($bot);
  }

  public function delete(int $botId): bool
  {
    try {
      $user = $this->userRepository->getUserById($_SESSION['userId']);
      if ($user === false) {
        throw new Exception('User not found');
      }
      return $this->botRepository->delete($botId, $user->getIdUser());
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  public function updateFeatures(array $inputs, int $botId): bool
  {
    // Check if the user is the owner of the bot
    $bot = $this->getBotById($botId);
    if ($bot === false || $bot->getIdUser() != $_SESSION['userId']) {
      return false;
    }

    $features = [];
    foreach ($inputs as $input) {
      // Ensure the idBot is set in the input array
      $input['idBot'] = $botId;

      // Instantiate BotFeature using the Hydration trait
      $feature = $this->featureRepository->getFeatureById($input['idBotFeature']);
      $feature->hydrateFromInputs($input);

      // Add to the features array
      $features[] = $feature;
    }
    // Set the features to the bot
    $bot->setBotFeatures($features);

    // Proceed to update the database
    return $this->botRepository->updateBotFeatures($bot);
  }
}
