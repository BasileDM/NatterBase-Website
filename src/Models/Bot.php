<?php

namespace src\Models;

use src\Services\Hydration;

final class Bot
{
  private int $idBot;
  private string $name;
  private string $creationDate;
  private int $cooldownTime = 0;
  private int $idModel = 1;
  private string $modelName;
  private string|null $twitchJoinChannel;
  private string $platformName;
  private int $idPlatform = 1;
  private int $idUser;
  /** @var BotCommand[] */
  private array $botCommands = [];
  /** @var BotFeature[] */
  private array $botFeatures = [];

  use Hydration;

  public function toArray(): array
  {
    return [
      'idBot' => $this->getIdBot(),
      'name' => $this->getName(),
      'creationDate' => $this->getCreationDate(),
      'cooldownTime' => $this->getCooldownTime(),
      'idModel' => $this->getIdModel(),
      'modelName' => $this->getModelName(),
      'twitchJoinChannel' => $this->getTwitchJoinChannel(),
      'idPlatform' => $this->getIdPlatform(),
      'platformName' => $this->getPlatformName(),
      'idUser' => $this->getIdUser(),
      'botCommands' => $this->getBotCommandsArray(),
      'botFeatures' => $this->getBotFeaturesArray(),
    ];
  }

  public function getBotFeaturesArray(): array|null
  {
    $featuresArray = [];
    foreach ($this->getBotFeatures() as $feature) {
      $featuresArray[] = $feature->toArray();
    }
    return $featuresArray;
  }

  public function getBotCommandsArray(): array|null
  {
    $commandsArray = [];
    foreach ($this->getBotCommands() as $command) {
      $commandsArray[] = $command->toArray();
    }
    return $commandsArray;
  }

  /**
   * Get the value of idBot
   */
  public function getIdBot(): int
  {
    return $this->idBot;
  }

  /**
   * Set the value of idBot
   *
   * @param   int  $idBot  
   * 
   */
  public function setIdBot(int $idBot)
  {
    $this->idBot = $idBot;
  }

  /**
   * Get the value of name
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * Set the value of name
   *
   * @param   string  $name  
   * 
   */
  public function setName(string $name)
  {
    $this->name = $name;
  }

  /**
   * Get the value of creationDate
   */
  public function getCreationDate(): string
  {
    return $this->creationDate;
  }

  /**
   * Set the value of creationDate
   *
   * @param   string  $creationDate  
   * 
   */
  public function setCreationDate(string $creationDate)
  {
    $this->creationDate = $creationDate;
  }

  /**
   * Get the value of cooldownTime
   */
  public function getCooldownTime(): int
  {
    return $this->cooldownTime;
  }

  /**
   * Set the value of cooldownTime
   *
   * @param   int  $cooldownTime  
   * 
   */
  public function setCooldownTime(int $cooldownTime)
  {
    $this->cooldownTime = $cooldownTime;
  }

  /**
   * Get the value of idModel
   */
  public function getIdModel(): int
  {
    return $this->idModel;
  }

  /**
   * Set the value of idModel
   *
   * @param   int  $idModel  
   * 
   */
  public function setIdModel(int $idModel)
  {
    $this->idModel = $idModel;
  }

  /**
   * Get the value of idPlatform
   */
  public function getIdPlatform(): int
  {
    return $this->idPlatform;
  }

  /**
   * Set the value of idPlatform
   *
   * @param   int  $idPlatform  
   * 
   */
  public function setIdPlatform(int $idPlatform)
  {
    $this->idPlatform = $idPlatform;
  }

  /**
   * Get the value of idUser
   */
  public function getIdUser(): int
  {
    return $this->idUser;
  }

  /**
   * Set the value of idUser
   *
   * @param   int  $idUser  
   * 
   */
  public function setIdUser(int $idUser)
  {
    $this->idUser = $idUser;
  }

  /**
   * Get the value of botCommands
   */
  public function getBotCommands(): array
  {
    return $this->botCommands;
  }

  /**
   * Set the value of botCommands
   *
   * @param   array  $botCommands  
   * 
   */
  public function setBotCommands(array $botCommands)
  {
    $this->botCommands = $botCommands;
  }

  /**
   * Get the value of botFeatures
   */
  public function getBotFeatures(): array
  {
    return $this->botFeatures;
  }

  /**
   * Set the value of botFeatures
   *
   * @param   array  $botFeatures  
   * 
   */
  public function setBotFeatures(array $botFeatures)
  {
    $this->botFeatures = $botFeatures;
  }

  /**
   * Get the value of platformName
   */
  public function getPlatformName(): string
  {
    return $this->platformName;
  }

  /**
   * Set the value of platformName
   *
   * @param   string  $platformName  
   * 
   */
  public function setPlatformName(string $platformName)
  {
    $this->platformName = $platformName;
  }

  /**
   * Get the value of modelName
   */
  public function getModelName(): string
  {
    return $this->modelName;
  }

  /**
   * Set the value of modelName
   *
   * @param   string  $modelName  
   * 
   */
  public function setModelName(string $modelName)
  {
    $this->modelName = $modelName;
  }

  /**
   * Get the value of twitchJoinChannel
   */
  public function getTwitchJoinChannel(): string|null
  {
    return $this->twitchJoinChannel;
  }

  /**
   * Set the value of twitchJoinChannel
   *
   * @param   string  $twitchJoinChannel  
   * 
   */
  public function setTwitchJoinChannel(string|null $twitchJoinChannel)
  {
    $this->twitchJoinChannel = $twitchJoinChannel;
  }
}
