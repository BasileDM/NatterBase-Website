<?php

namespace src\Models;

use DateTime;
use src\Repositories\BotRepository;
use src\Repositories\UserRepository;
use src\Services\Hydration;

final class BotProfile
{
  private int $idBot;
  private string $name;
  private string $creationDate;
  private int $cooldownTime = 0;
  private string $maxOpenaiMessageLength = '120';
  private int $idModel = 1;
  private int $idPlatform = 1;
  private int $idUser;

  use Hydration;

  public function create(array $inputs): BotProfile|false
  {
    $this->hydrateFromInputs($inputs);
    $botRepository = new BotRepository();
    $existingBot = $botRepository->getByNameAndUserId($this->getName(), $this->getIdUser());
    if ($existingBot)
      return false;
    else {
      $this->setCreationDate((new DateTime())->format('Y-m-d H:i:s'));
      return $botRepository->insert($this);
    }
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
   * Get the value of maxOpenaiMessageLength
   */
  public function getMaxOpenaiMessageLength(): string
  {
    return $this->maxOpenaiMessageLength;
  }

    /**
     * Set the value of maxOpenaiMessageLength
     *
     * @param   string  $maxOpenaiMessageLength  
     * 
     */
    public function setMaxOpenaiMessageLength(string $maxOpenaiMessageLength)
    {
        $this->maxOpenaiMessageLength = $maxOpenaiMessageLength;
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
}