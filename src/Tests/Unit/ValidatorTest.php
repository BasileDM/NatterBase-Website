<?php

namespace src\Tests\Unit;

use PHPUnit\Framework\TestCase;
use src\Utils\Validator;

class ValidatorTest extends TestCase
{
  public function testValidEmail()
  {
    $this->assertTrue(Validator::validateMail('a@a.com'));
  }

  public function testInvalidEmail()
  {
    $this->assertFalse(Validator::validateMail('a@a'));
  }

  public function testValidPassword()
  {
    $this->assertTrue(Validator::validatePassword('password'));
  }

  public function testInvalidPassword()
  {
    $this->assertFalse(Validator::validatePassword('pass'));
  }

  public function testValidUsername()
  {
    $this->assertTrue(Validator::validateUsername('username'));
  }

  public function testInvalidUsername()
  {
    $this->assertFalse(Validator::validateUsername('usernam'));
  }
}