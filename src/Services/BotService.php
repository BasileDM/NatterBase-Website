<?php

namespace src\Services;

use DateTime;
use src\Models\Bot;
use src\Repositories\BotCommandRepository;
use src\Repositories\BotFeatureRepository;
use src\Repositories\BotRepository;

final class BotService
{
  private BotRepository $botRepository;
  private BotCommandRepository $botCommandRepository;
  private BotFeatureRepository $botFeatureRepository;

  public function __construct()
  {
    $this->botRepository = new BotRepository();
    $this->botCommandRepository = new BotCommandRepository();
    $this->botFeatureRepository = new BotFeatureRepository();
  }

  public function create(array $inputs): Bot|false
  {
    $newBot = new Bot();
    // Adding idUser as a key of the saneInputs assoc array (for hydration)
    $inputs += ['idUser' => $_SESSION['userId']];
    $newBot->hydrateFromInputs($inputs);
    $existingBot = $this->botRepository->getByNameAndUserId($newBot->getName(), $newBot->getIdUser());
    if ($existingBot) return false;
    else {
      $newBot->setCreationDate((new DateTime())->format('Y-m-d H:i:s'));
      return $this->botRepository->insert($newBot);
    }
  }

  public function getBotByUserId(int $userId): array
  {
    $bots = $this->botRepository->getByUserId($userId);

    foreach ($bots as $bot) {
      $this->populateBotRelations($bot);
    }

    return $bots;
  }

  public function getBotById(int $botId): Bot
  {
    $bot = $this->botRepository->getById($botId);
    if ($bot !== null) {
      $this->populateBotRelations($bot);
    }
    return $bot;
  }

  private function populateBotRelations(Bot $bot): void
  {
    $botId = $bot->getIdBot();

    $commands = $this->botCommandRepository->getByBotId($botId);
    $features = $this->botFeatureRepository->getByBotId($botId);

    $bot->setBotCommands($commands);
    $bot->setBotFeatures($features);
  }

  public function getUserBotsArray(int $userId): array
  {
    $bots = $this->getBotByUserId($userId);
    $botsArray = array_map(fn(Bot $bot) => $bot->toArray(), $bots);
    return $botsArray;
  }
}
