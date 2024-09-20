<?php

namespace src\Controllers;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\BotService;
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
      // Manually adding session user id for bot auto hydration
      $saneInputs = $validationResult['sanitized'];
      $saneInputs['idUser'] = $_SESSION['userId'];

      $botService = new BotService();
      $result = $botService->create($saneInputs);

      if (!$result) {
        $this->jsonResponse(400, 'Could not create bot profile');
      }

      $this->jsonResponse(200, 'Bot profile created successfully');
    }
  }
}
