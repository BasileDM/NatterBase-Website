<?php

namespace src\Controllers\api;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\BotService;
use src\Services\Response;
use src\Utils\Validator;

final class ApiBotController
{
  private BotService $botService;

  public function __construct()
  {
    $this->botService = new BotService();
  }

  use Response;

  #[Route('POST', '/createBotProfile')]
  #[Authorization(1)]
  public function createBotProfile(): void
  {
    $validation = Validator::validateInputs();

    if (isset($validation['errors'])) {
      $this->formErrorsResponse(400, $validation['errors']);
      exit;
    } else {
      $result = $this->botService->create($validation['sanitized']);

      if (!$result) {
        $this->jsonResponse(400, ['message' => 'Could not create bot profile']);
      }

      $this->jsonResponse(200, ['message' => 'Bot profile created successfully']);
    }
  }

  #[Route('GET', '/getBot')]
  #[Authorization(1)]
  public function getBot(): void
  {
    $botId = $_GET['param'];
    $botSettings = $this->botService->getBotSettings($botId);

    if (!$botSettings || empty($botSettings)) {
      $this->jsonResponse(400, ['message' => 'Could not get bot settings']);
    }

    if ($_SESSION['userId'] != $botSettings['idUser']) {
      $this->jsonResponse(400, ['message' => 'Could not get bot settings']);
    }

    $this->jsonResponse(200, $botSettings);
  }

  #[Route('POST', '/updateBotProfile')]
  #[Authorization(1)]
  public function updateBotProfile(): void
  {
    $validation = Validator::validateInputs();
    if (isset($validation['errors'])) {
      $this->formErrorsResponse(400, $validation['errors']);
      exit;
    } else {
      $result = $this->botService->update($validation['sanitized']);
      if (!$result) {
        $this->jsonResponse(400, ['message' => 'Could not update bot profile']);
      }
      $this->jsonResponse(200, ['message' => 'Bot profile updated successfully']);
    }
  }
}
