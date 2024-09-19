<?php

namespace src\Controllers;

use src\Router\Attributes\Route;
use src\Services\Response;
use src\Utils\Validator;

final class BotController
{
  use Response;

  #[Route('POST', '/createBotProfile')]
  public function createBotProfile(): void
  {
    $request = json_decode(file_get_contents('php://input'), true);
    $validationResult = Validator::validateInputs($request);

    if (isset($validationResult['errors'])) {
      $this->formErrorsResponse(400, $validationResult['errors']);
      exit;
    } else {
      $this->jsonResponse(200, 'Bot profile created successfully');
    }
  }
}
