<?php

namespace src\Services;

trait Response
{
  private function render(string $view, array $data = ['section' => '', 'action' => ''])
  {
    if (!empty($data)) {
      foreach ($data as $key => $value) {
        ${'view_' . $key} = $value;
      }
    }
    if (!isset($section)) {
      $section = '';
    }
    if (!isset($action)) {
      $action = '';
    }
    include_once __DIR__ . '/../Views/' . $view . ".php";
  }

  private function jsonResponse(int $code, string $message = '', string $redirect = ''): void 
  {
    http_response_code($code);
    echo json_encode([
      'message' => $message
    ]);
    if (!empty($redirect)) header('Location: ' . $redirect);
    exit;
  }

  private function formErrorsResponse(int $code, array $errors): void
  {
    http_response_code($code);
    echo json_encode([
      'formErrors' => $errors
    ]);
    exit;
  }
}
