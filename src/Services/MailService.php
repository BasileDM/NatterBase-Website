<?php

namespace src\Services;

final class MailService
{
  public static function sendActivationMail($user): bool
  {
    $name = $user->getUsername();
    $email = $user->getMail();
    $userId = $user->getIdUser();

    $token = self::generateActivationToken($userId);
    $link = FULL_URL . "activate?token=" . urlencode($token);

    $subject = "Natterbase Account Activation";
    $message = "
        <html>
        <body>
            <p>Hello $name,</p>
            <p>Please activate your account using the link below:</p>
            <p>Not working link yet</p>
            <p>The Natterbase Team.</p>
        </body>
        </html>";
    $message = wordwrap($message, 70, "\n\n");

    $headers = "From: Natterbase <contact@natterbase.com>\r\n";
    $headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
    $headers .= "Content-Transfer-Encoding: 8bit\n";

    $sentMail = mail($email, $subject, $message, $headers);
    return $sentMail;
  }

  private static function generateActivationToken($userId): string
  {
    $expires = time() + 3600;
    $data = $userId . '|' . $expires;
    $signature = hash_hmac('sha256', $data, SECRET);
    $token = base64_encode($data . '|' . $signature);
    return $token;
  }

  public static function verifyActivationToken($token): bool|string
  {
    $decoded = base64_decode($token, true);
    if ($decoded === false) {
      return false;
    }

    $parts = explode('|', $decoded);
    if (count($parts) !== 3) {
      return false;
    }

    [$userId, $expires, $signature] = $parts;

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
