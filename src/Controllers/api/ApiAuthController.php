<?php

namespace src\api\Controllers;

use src\Router\Attributes\Authorization;
use src\Router\Attributes\Route;
use src\Services\Response;

final class AuthController
{
  use Response;

  #[Route('GET', '/api/twitchAuth')]
  #[Authorization(1)]
  public function getTwitchAuth(): void
  {
    // This helps verify the integrity of the request after the call back and avoid CSRF
    $state = bin2hex(random_bytes(16));
    $_SESSION['state'] = $state;

    $authUrl = "https://id.twitch.tv/oauth2/authorize?client_id=" . TWITCH_CLIENT_ID
      . "&redirect_uri=" . TWITCH_REDIRECT_URI
      . "&response_type=code&scope=" . TWITCH_SCOPES
      . "&state=" . $state;
    header("Location: " . $authUrl);
    exit;
  }

  #[Route('GET', '/api/twitchCallback')]
  #[Authorization(1)]
  public function handleTwitchCallback(): void
  {
    if (!isset($_GET['code'], $_GET['state'])) {
      $this->jsonResponse(500, ['message' => 'Could not get code']);
      exit;
    }
    $code = $_GET['code'];
    $state = $_GET['state'];

    if ($state !== $_SESSION['state']) {
      $this->jsonResponse(400, ['message' => 'State error retrieving code']);
      exit;
    }

    $data = [
      'client_id' => TWITCH_CLIENT_ID,
      'client_secret' => TWITCH_CLIENT_SECRET,
      'code' => $code,
      'grant_type' => 'authorization_code',
      'redirect_uri' => TWITCH_REDIRECT_URI,
      'scope' => 'user:read:email'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://id.twitch.tv/oauth2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if ($response === false) {
      $error = curl_error($ch);
      curl_close($ch);
      $this->jsonResponse(500, ['message' => $error]);
      exit;
    }
    curl_close($ch);

    $response = json_decode($response, true);
    if (!isset($response['access_token'])) {
      $this->jsonResponse(500, ['message' => 'Could not get access token']);
      exit;
    }

    $token = $response['access_token'];
    $_SESSION['token'] = $token;
    $this->jsonResponse(200, ['message' => 'Success', 'token' => $token]);
    exit;
  }
}
