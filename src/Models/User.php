<?php

namespace src\Models;

use DateTime;

final class User {
  private int $id;
  private string $mail;
  private string $username;
  private string $passwordHash;
  private bool $isActivated;
  private DateTime $gdpr;
  private string $twitchId;
  private string $twitchUsername;
  private int $role;

  public function __construct(int $id, string $mail, string $username, string $passwordHash, bool $isActivated, DateTime $gdpr, string $twitchId, string $twitchUsername, int $role) {
    $this->id = $id;
    $this->mail = $mail;
    $this->username = $username;
    $this->passwordHash = $passwordHash;
    $this->isActivated = $isActivated;
    $this->gdpr = $gdpr;
    $this->twitchId = $twitchId;
    $this->twitchUsername = $twitchUsername;
    $this->role = $role;
  }

  /**
   * Get the value of id
   */
  public function getId(): int
  {
    return $this->id;
  }

    /**
     * Set the value of id
     *
     * @param   int  $id  
     * 
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

  /**
   * Get the value of mail
   */
  public function getMail(): string
  {
    return $this->mail;
  }

    /**
     * Set the value of mail
     *
     * @param   string  $mail  
     * 
     */
    public function setMail(string $mail)
    {
        $this->mail = $mail;
    }

  /**
   * Get the value of username
   */
  public function getUsername(): string
  {
    return $this->username;
  }

    /**
     * Set the value of username
     *
     * @param   string  $username  
     * 
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

  /**
   * Get the value of passwordHash
   */
  public function getPasswordHash(): string
  {
    return $this->passwordHash;
  }

    /**
     * Set the value of passwordHash
     *
     * @param   string  $passwordHash  
     * 
     */
    public function setPasswordHash(string $passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }

  /**
   * Get the value of isActivated
   */
  public function isIsActivated(): bool
  {
    return $this->isActivated;
  }

    /**
     * Set the value of isActivated
     *
     * @param   bool  $isActivated  
     * 
     */
    public function setIsActivated(bool $isActivated)
    {
        $this->isActivated = $isActivated;
    }

  /**
   * Get the value of gdpr
   */
  public function getGdpr(): DateTime
  {
    return $this->gdpr;
  }

    /**
     * Set the value of gdpr
     *
     * @param   DateTime  $gdpr  
     * 
     */
    public function setGdpr(DateTime $gdpr)
    {
        $this->gdpr = $gdpr;
    }

  /**
   * Get the value of twitchId
   */
  public function getTwitchId(): string
  {
    return $this->twitchId;
  }

    /**
     * Set the value of twitchId
     *
     * @param   string  $twitchId  
     * 
     */
    public function setTwitchId(string $twitchId)
    {
        $this->twitchId = $twitchId;
    }

  /**
   * Get the value of twitchUsername
   */
  public function getTwitchUsername(): string
  {
    return $this->twitchUsername;
  }

    /**
     * Set the value of twitchUsername
     *
     * @param   string  $twitchUsername  
     * 
     */
    public function setTwitchUsername(string $twitchUsername)
    {
        $this->twitchUsername = $twitchUsername;
    }

  /**
   * Get the value of role
   */
  public function getRole(): int
  {
    return $this->role;
  }

    /**
     * Set the value of role
     *
     * @param   int  $role  
     * 
     */
    public function setRole(int $role)
    {
        $this->role = $role;
    }
}