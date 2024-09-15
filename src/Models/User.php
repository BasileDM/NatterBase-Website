<?php

namespace src\Models;

use src\Services\Hydration;

final class User
{
  private int $idUser;
  private string $mail;
  private string $username;
  private string $passwordHash;
  private bool $isActivated;
  private string $gdpr;
  private string $twitchId;
  private string $twitchUsername;
  private int $roleId;
  private string $roleName;

  use Hydration;

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
  public function getGdpr(): string
  {
    return $this->gdpr;
  }

    /**
     * Set the value of gdpr
     *
     * @param   string  $gdpr  
     * 
     */
    public function setGdpr(string $gdpr)
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
   * Get the value of roleId
   */
  public function getRoleId(): int
  {
    return $this->roleId;
  }

    /**
     * Set the value of roleId
     *
     * @param   int  $roleId  
     * 
     */
    public function setRoleId(int $roleId)
    {
        $this->roleId = $roleId;
    }

  /**
   * Get the value of roleName
   */
  public function getRoleName(): string
  {
    return $this->roleName;
  }

    /**
     * Set the value of roleName
     *
     * @param   string  $roleName  
     * 
     */
    public function setRoleName(string $roleName)
    {
        $this->roleName = $roleName;
    }
}