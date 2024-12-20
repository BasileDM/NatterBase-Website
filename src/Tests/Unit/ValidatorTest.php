<?php

namespace src\Tests\Unit;

use PHPUnit\Framework\TestCase;
use src\Utils\Validator;

class ValidatorTest extends TestCase
{
  private array $inputs = [
    'mail' => 'a@a.com',
    'username' => 'aaa',
    'password' => 'aaaaaaaa',
    'confirmPassword' => 'aaaaaaaa',
    'gdpr' => true,
    'name' => 'aaaa',
    'twitchJoinChannel' => 'aaaa',
    'openaiPrePrompt' => 'aaaa',
    'cooldownTime' => '0',
    'idBot' => '1',
  ];

  public function testValidateInputsValid(): void
  {
    $result = Validator::validateInputs($this->inputs);
    // Password hash will always be different so needs it's own testing
    $passwordHash = $result['sanitized']['passwordHash'];
    unset($result['sanitized']['passwordHash']);

    $expected = [
      'name' => "aaaa",
      'mail' => "a@a.com",
      'username' => "aaa",
      'twitchJoinChannel' => "aaaa",
      'openaiPrePrompt' => "aaaa",
      'cooldownTime' => 0,
      'idBot' => 1
    ];

    $this->assertArrayNotHasKey("errors", $result);
    $this->assertArrayHasKey("sanitized", $result);
    $this->assertEquals($expected, $result['sanitized'], "Sanitized inputs should match expected values");
    $this->assertTrue(password_verify("aaaaaaaa", $passwordHash), "Password hash should be valid");
  }

  public function testValidateInputsInvalidMail(): void
  {
    $wrongInputs = $this->inputs;
    $wrongInputs['mail'] = 'wrongMail';

    // Validate
    $result = Validator::validateInputs($wrongInputs);

    $this->assertArrayHasKey("errors", $result, "Errors key should exist");
    $this->assertArrayHasKey("mail", $result["errors"], "Mail key should exist in errors");
    $this->assertArrayNotHasKey("sanitized", $result, "Sanitized key should not exist");
  }

  public function testValidateInputsMismatchPassword(): void
  {
    $wrongInputs = $this->inputs;
    $wrongInputs['confirmPassword'] = 'differentPw';

    // Validate
    $result = Validator::validateInputs($wrongInputs);

    $this->assertArrayHasKey("errors", $result, "Errors key should exist");
    $this->assertArrayHasKey("password", $result["errors"], "Password key should exist in errors");
    $this->assertArrayNotHasKey("sanitized", $result, "Sanitized key should not exist");
  }
}
