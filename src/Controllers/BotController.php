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
    $request = json_decode(file_get_contents('php://input'), true);
    $validationResult = Validator::validateInputs($request);

    if (isset($validationResult['errors'])) {
      $this->formErrorsResponse(400, $validationResult['errors']);
      exit;
    } else {
      // Adding idUser as a key of the saneInputs assoc array (for bot auto hydration)
      $saneInputs = $validationResult['sanitized'] + ['idUser' => $_SESSION['userId']];
      $result = $this->botService->create($saneInputs);

      if (!$result) {
        $this->jsonResponse(400, 'Could not create bot profile');
      }

      $this->jsonResponse(200, 'Bot profile created successfully');
    }
  }
}
