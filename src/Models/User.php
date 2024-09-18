<?php

namespace src\Models;

use src\Repositories\UserRepository;
use src\Services\Hydration;

final class User
{
  private int $idUser;
  private string $mail;
  private string $username;
  private string $passwordHash;
  private bool $isActivated;
  private string $gdpr;
  private string|null $twitchId;
  private string|null $twitchUsername;
  private string $roleName;

  use Hydration;

  public function create(array $inputs): User|false
  {
    $this->hydrateFromInputs($inputs);
    $userRepository = new UserRepository();
    $existingUser = $userRepository->getUserByMail($this->getMail());

    if ($existingUser)
      return false;
    else {
      $this->setIsActivated(false);
      $this->setGdpr(gmdate('Y-m-d H:i:s'));
      $this->setRoleName('user');
      return $userRepository->insert($this);
    }
  }
  public function getAuthLevelFromRole(): int
  {
    switch ($this->getRoleName()) {
      case 'admin':
        return 2;
      case 'user':
        return 1;
      default:
        return 0;
    }
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
  public function getTwitchId(): string|null
  {
    return $this->twitchId;
  }

  /**
   * Set the value of twitchId
   *
   * @param   string  $twitchId  
   * 
   */
  public function setTwitchId(string|null $twitchId)
  {
    $this->twitchId = $twitchId;
  }

  /**
   * Get the value of twitchUsername
   */
  public function getTwitchUsername(): string|null
  {
    return $this->twitchUsername;
  }

  /**
   * Set the value of twitchUsername
   *
   * @param   string  $twitchUsername  
   * 
   */
  public function setTwitchUsername(string|null $twitchUsername)
  {
    $this->twitchUsername = $twitchUsername;
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
