<?php

namespace src\Controllers;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\BotService;
use src\Services\Response;
use src\Utils\Validator;

final class BotController
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
}
