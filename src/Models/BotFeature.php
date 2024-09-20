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
}
