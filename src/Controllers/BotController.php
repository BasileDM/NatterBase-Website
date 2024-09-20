<?php

namespace src\Controllers;

use src\Models\Bot;
use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\Response;
use src\Utils\Validator;

final class BotController
{
  use Response;

  #[Route('POST', '/createBotProfile')]
  #[Authorization(1)]
  public function createBotProfile(): void
  {
    $request = json_decode(file_get_contents('php://input'), true);
    $validationResult = Validator::validateInputs($request);

    if (isset($validationResult['errors'])) {
      $this->formErrorsResponse(400, $validationResult['errors']);
      exit;
    } else {
      $bot = new Bot();
      // Manually adding session user id for auto hydration
      $validationResult['sanitized']['idUser'] = $_SESSION['userId'];
      $result = $bot->create($validationResult['sanitized']);
      if (!$result) {
        $this->jsonResponse(400, 'Could not create bot profile');
      }

      $this->jsonResponse(200, 'Bot profile created successfully');
    }
  }
}
