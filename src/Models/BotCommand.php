<?php

namespace src\Models;

use src\Services\Hydration;

final class BotCommand
{
  private int $idBotCommand;
  private int $idBot;
  private string $name;
  private string $text;

  use Hydration;

  public function toArray(): array
  {
    return [
      "idBotCommand" => $this->idBotCommand,
      "idBot" => $this->idBot,
      "name" => $this->name,
      "text" => $this->text
    ];
  }

  /**
   * Get the value of idBotCommand
   */
  public function getIdBotCommand(): int
  {
    return $this->idBotCommand;
  }

  /**
   * Set the value of idBotCommand
   *
   * @param   int  $idBotCommand  
   * 
   */
  public function setIdBotCommand(int $idBotCommand)
  {
    $this->idBotCommand = $idBotCommand;
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
   * Get the value of text
   */
  public function getText(): string
  {
    return $this->text;
  }

  /**
   * Set the value of text
   *
   * @param   string  $text  
   * 
   */
  public function setText(string $text)
  {
    $this->text = $text;
  }
}
