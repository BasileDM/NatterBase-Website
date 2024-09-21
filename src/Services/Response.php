<?php

namespace src\Services;

trait Response
{
  private function render(string $view, array $viewVariables = []): void
  {
    $defaults = [
      'section' => '',
    ];

    $viewVariables = array_merge($defaults, $viewVariables);
    extract($viewVariables, EXTR_PREFIX_ALL, 'view');

    include_once __DIR__ . '/../Views/' . $view . ".php";
  }

  private function jsonResponse(int $code, array $data = [], string $redirect = ''): void
  {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
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
