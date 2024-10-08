<?php

namespace src\Models;

use src\Services\Hydration;

final class BotFeature
{
  // Properties from Bot_Features table
  private int $idBotFeature;
  private string $name;
  private bool $isAdmin;
  private bool $isSubscriber;
  private int $idBotFeatureCategory;
  private string $categoryName;

  // Properties from Relation_Bots_Features table
  private int $idBot;
  private ?bool $isAdminOverride = null;
  private ?bool $isSubscriberOverride = null;
  private ?string $trigger = null;
  private ?int $diceSidesNumber = null;
  private ?int $maxOpenaiMessageLength = null;
  private ?string $openAiPrePrompt = null;

  use Hydration;

  public function toArray(): array
  {
    $array = get_object_vars($this);
    return $array;
  }

  /**
   * Get the value of idBotFeature
   */
  public function getIdBotFeature(): int
  {
    return $this->idBotFeature;
  }

  /**
   * Set the value of idBotFeature
   *
   * @param   int  $idBotFeature  
   * 
   */
  public function setIdBotFeature(int $idBotFeature)
  {
    $this->idBotFeature = $idBotFeature;
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
   * Get the value of isAdmin
   */
  public function isIsAdmin(): bool
  {
    return $this->isAdmin;
  }

  /**
   * Set the value of isAdmin
   *
   * @param   bool  $isAdmin  
   * 
   */
  public function setIsAdmin(bool $isAdmin)
  {
    $this->isAdmin = $isAdmin;
  }

  /**
   * Get the value of isSubscriber
   */
  public function isIsSubscriber(): bool
  {
    return $this->isSubscriber;
  }

  /**
   * Set the value of isSubscriber
   *
   * @param   bool  $isSubscriber  
   * 
   */
  public function setIsSubscriber(bool $isSubscriber)
  {
    $this->isSubscriber = $isSubscriber;
  }

  /**
   * Get the value of idBotFeatureCategory
   */
  public function getIdBotFeatureCategory(): int
  {
    return $this->idBotFeatureCategory;
  }

  /**
   * Set the value of idBotFeatureCategory
   *
   * @param   int  $idBotFeatureCategory  
   * 
   */
  public function setIdBotFeatureCategory(int $idBotFeatureCategory)
  {
    $this->idBotFeatureCategory = $idBotFeatureCategory;
  }

  /**
   * Get the value of categoryName
   */
  public function getCategoryName(): string
  {
    return $this->categoryName;
  }

  /**
   * Set the value of categoryName
   *
   * @param   string  $categoryName  
   * 
   */
  public function setCategoryName(string $categoryName)
  {
    $this->categoryName = $categoryName;
  }

  public function getIdBot(): int
  {
    return $this->idBot;
  }

  public function setIdBot(int $idBot)
  {
    $this->idBot = $idBot;
  }

  public function getIsAdminOverride(): ?bool
  {
    return $this->isAdminOverride ?? false;
  }

  public function setIsAdminOverride(?bool $isAdminOverride)
  {
    $this->isAdminOverride = $isAdminOverride;
  }

  public function getIsSubscriberOverride(): ?bool
  {
    return $this->isSubscriberOverride ?? false;
  }

  public function setIsSubscriberOverride(?bool $isSubscriberOverride)
  {
    $this->isSubscriberOverride = $isSubscriberOverride;
  }

  public function getTrigger(): ?string
  {
    return $this->trigger;
  }

  public function setTrigger(?string $trigger)
  {
    $this->trigger = $trigger;
  }

  public function getDiceSidesNumber(): ?int
  {
    return $this->diceSidesNumber;
  }

  public function setDiceSidesNumber(?int $diceSidesNumber)
  {
    $this->diceSidesNumber = $diceSidesNumber;
  }

  /**
   * Get the value of maxOpenaiMessageLength
   */
  public function getMaxOpenaiMessageLength(): ?int
  {
    return $this->maxOpenaiMessageLength;
  }

    /**
     * Set the value of maxOpenaiMessageLength
     *
     * @param   int  $maxOpenaiMessageLength  
     * 
     */
    public function setMaxOpenaiMessageLength(?int $maxOpenaiMessageLength)
    {
        $this->maxOpenaiMessageLength = $maxOpenaiMessageLength;
    }

  /**
   * Get the value of openAiPrePrompt
   */
  public function getOpenAiPrePrompt(): ?string
  {
    return $this->openAiPrePrompt;
  }

    /**
     * Set the value of openAiPrePrompt
     *
     * @param   string  $openAiPrePrompt  
     * 
     */
    public function setOpenAiPrePrompt(?string $openAiPrePrompt)
    {
        $this->openAiPrePrompt = $openAiPrePrompt;
    }
}
