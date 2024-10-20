<?php

namespace src\Services;

require __DIR__ . '/../../vendor/autoload.php';

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class MailService
{
  public static function sendActivationMail($user)
  {
    $name = $user->getUsername();
    $email = $user->getMail();
    $userId = $user->getIdUser();

    $token = self::generateActivationToken($userId);
    $link = FULL_URL . "activate?token=" . urlencode($token);

    $mail = new PHPMailer(true);

    try {
      // Gmail SMTP server settings
      $mail->isSMTP();
      $mail->Host       = SMTP_HOST;
      $mail->SMTPAuth   = true;
      $mail->Username   = SMTP_USERNAME;
      $mail->Password   = SMTP_PASSWORD;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port       = SMTP_PORT;

      // Recipients
      $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
      $mail->addAddress($email, $name);

      // Content
      $mail->isHTML(true);
      $mail->Subject = 'Natterbase Account Activation';
      $mail->Body    = "
            <html>
            <body>
                <p>Hello $name,</p>
                <p>Please activate your account using the link below:</p>
                <p><a href='$link'>Activate your account</a></p>
                <p>The Natterbase Team.</p>
            </body>
            </html>";
      $mail->AltBody = "Hello $name,\n\nPlease activate your account using this link: $link\n\nThe Natterbase Team.";  // Plain text alternative

      // Send the email
      $mail->send();
      return true;
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      return false;
    }
  }

  public static function generateActivationToken($userId): string
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
