<?php

namespace src\Models;

final class BotFeature
{
  private int $idBotFeature;
  private string $name;
  private bool $isAdmin;
  private bool $isSubscriber;
  private string $category;

  public function __construct(int $idBotFeature, string $name, bool $isAdmin, bool $isSubscriber, string $category)
  {
    $this->idBotFeature = $idBotFeature;
    $this->name = $name;
    $this->isAdmin = $isAdmin;
    $this->isSubscriber = $isSubscriber;
    $this->category = $category;
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
   * Get the value of category
   */
  public function getCategory(): string
  {
    return $this->category;
  }

    /**
     * Set the value of category
     *
     * @param   string  $category  
     * 
     */
    public function setCategory(string $category)
    {
        $this->category = $category;
    }
}
