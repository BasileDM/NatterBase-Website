<?php

namespace src\Utils;

final class ErrorUtils
{
  public static function getErrorCodeAndMessage(): array
  {
    $code = $_GET['code'] ?? null;
    if (!$code) $code = 404;
    $message = match ((int)$code) {
      400 => 'Bad Request',
      401 => 'Please login or register to access the app',
      403 => 'Forbidden',
      404 => 'Page Not Found',
      500 => 'Internal Server Error',
      503 => 'Service Unavailable',
      504 => 'Gateway Timeout',
      429 => 'Too Many Requests',
      default => 'Error',
    };

    return [$code, $message];
  }
}
