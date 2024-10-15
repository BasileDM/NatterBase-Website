<?php

namespace src\Tests\Unit;

use PHPUnit\Framework\TestCase;
use src\Models\User;

class UserTest extends TestCase
{
  public function testToSafeInfoArrayReturnsCorrectData()
  {
    $user = new User();
    $user->setIdUser(1);
    $user->setMail('test@example.com');
    $user->setUsername('TestUser');
    $user->setPasswordHash('testpassword');
    $user->setIsActivated(true);
    $user->setGdpr(true);
    $user->setTwitchUsername('TwitchTestUser');
    $user->setRoleName('admin');

    $expected = [
      'idUser' => 1,
      'mail' => 'test@example.com',
      'username' => 'TestUser',
      'isActivated' => true,
      'gdpr' => true,
      'twitchUsername' => 'TwitchTestUser',
      'roleName' => 'admin',
    ];

    $this->assertEquals($expected, $user->toSafeInfoArray(), "The toSafeInfoArray method should return the correct data array.");
  }

  public function testGetAuthLevelFromRole()
  {
    $user = new User();
    $user->setRoleName('admin');
    $this->assertEquals(2, $user->getAuthLevelFromRole(), "Admin role should return auth level 2");

    $user->setRoleName('user');
    $this->assertEquals(1, $user->getAuthLevelFromRole(), "User role should return auth level 1");

    $user->setRoleName('guest');
    $this->assertEquals(0, $user->getAuthLevelFromRole(), "Unknown role should return auth level 0");
  }
}
