<?php

namespace src\Services;

final class MailService
{
  public static function sendActivationMail($user)
  {
    $name = $user->getUsername();
    $email = $user->getMail();
    $userId = $user->getIdUser();

    $token = self::generateActivationToken($userId);
    $link = FULL_URL . "activate?token=" . urlencode($token);

    $subject = "Natterbase Account Activation";
    $message = "Hello $name,\n\n"
      . "Please activate your account using the link below:\n"
      . "$link\n\n"
      . "The Natterbase Team.\n";

    $headers = "From: Natterbase Team <contact@natterbase.com>\r\n"
      . "Content-Type: text/plain; charset=\"UTF-8\"\n"
      . "Content-Transfer-Encoding: 8bit\n";

    return mail($email, $subject, $message, $headers);
  }

  private static function generateActivationToken($userId): string
  {
    $expires = time() + 3600;
    $data = $userId . '|' . $expires;
    $signature = hash_hmac('sha256', $data, SECRET);
    $token = base64_encode($data . '|' . $signature);
    return $token;
  }

  public static function verifyActivationToken($token)
  {
    $decoded = base64_decode($token, true);
    if ($decoded === false) {
      return false;
    }

    $parts = explode('|', $decoded);
    if (count($parts) !== 3) {
      return false;
    }

    list($userId, $expires, $signature) = $parts;

    if ($expires < time()) {
      return false;
    }

    $data = $userId . '|' . $expires;
    $expectedSignature = hash_hmac('sha256', $data, SECRET);

    if (!hash_equals($expectedSignature, $signature)) {
      return false;
    }

    return $userId;
  }
}
