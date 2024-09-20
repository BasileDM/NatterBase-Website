<?php

namespace src\Models;

final class BotCommand
{
  private int $idBotCommand;
  private int $name;
  private string $text;
  private int $idBot;

  public function __construct(int $idBotCommand, int $name, string $text, int $idBot)
  {
    $this->idBotCommand = $idBotCommand;
    $this->name = $name;
    $this->text = $text;
    $this->idBot = $idBot;
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
   * Get the value of name
   */
  public function getName(): int
  {
    return $this->name;
  }

  /**
   * Set the value of name
   *
   * @param   int  $name  
   * 
   */
  public function setName(int $name)
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
}
