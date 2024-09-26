<?php

namespace src\Controllers\api;

use Exception;
use src\Repositories\BotRepository;
use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\BotService;
use src\Services\Response;
use src\Utils\FeaturesValidator;
use src\Utils\Validator;

final class ApiBotController
{
  private BotService $botService;
  private BotRepository $botRepository;

  public function __construct()
  {
    $this->botService = new BotService();
    $this->botRepository = new BotRepository();
  }

  use Response;

  #[Route('POST', '/createBotProfile')]
  #[Authorization(1)]
  public function createBotProfile(): void
  {
    try {
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
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => "Backend error"]);
    }
  }

  #[Route('GET', '/getBot')]
  #[Authorization(1)]
  public function getBot(): void
  {
    try {
      $botId = $_GET['param'];
      $botSettings = $this->botService->getBotSettings($botId);

      if (!$botSettings || empty($botSettings)) {
        $this->jsonResponse(400, ['message' => 'Could not get bot settings']);
        exit;
      }

      if ($_SESSION['userId'] != $botSettings['idUser']) {
        $this->jsonResponse(400, ['message' => 'Could not get bot settings']);
        exit;
      }

      $this->jsonResponse(200, $botSettings);
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => "Backend error"]);
    }
  }

  #[Route('POST', '/updateBotProfile')]
  #[Authorization(1)]
  public function updateBotProfile(): void
  {
    try {
      $validation = Validator::validateInputs();
      if (isset($validation['errors'])) {
        $this->formErrorsResponse(400, $validation['errors']);
        exit;
      }

      if (!isset($_GET['idBot'])) {
        $this->jsonResponse(400, ['message' => 'Invalid Id']);
        exit;
      }

      $result = $this->botService->update($validation['sanitized'], $_GET['idBot']);
      if (!$result) {
        $this->jsonResponse(400, ['message' => 'Could not update bot profile']);
        exit;
      }

      $this->jsonResponse(200, ['message' => 'Bot profile updated successfully']);
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => "Backend error"]);
    }
  }

  #[Route('DELETE', '/deleteBotProfile')]
  #[Authorization(1)]
  public function deleteBotProfile(): void
  {
    try {
      $result = $this->botService->delete($_GET['idBot']);
      if (!$result) {
        $this->jsonResponse(400, ['message' => 'Could not delete bot profile']);
        exit;
      }

      $this->jsonResponse(200, ['message' => 'Bot profile deleted successfully']);
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => "Backend error"]);
    }
  }

  #[Route('POST', '/updateBotFeatures')]
  #[Authorization(1)]
  public function updateBotFeatures(): void
  {
    try {
      $validation = FeaturesValidator::validateInputs();
      if (isset($validation['errors'])) {
        $this->formErrorsResponse(400, $validation['errors']);
        exit;
      }

      if (!isset($_GET['idBot'])) {
        $this->jsonResponse(400, ['message' => 'Invalid Id']);
        exit;
      }

      $result = $this->botService->updateFeatures($validation['sanitized'], $_GET['idBot']);
      if (!$result) {
        $this->jsonResponse(400, ['message' => 'Could not update bot features']);
        exit;
      }

      $this->jsonResponse(200, ['message' => 'Bot features updated successfully']);
    } catch (Exception $e) {
      $this->jsonResponse(500, ['message' => "Backend error" . $e->getMessage()]);
    }
  }
}
