<?php

namespace src\Services;

use src\Repositories\UserRepository;

final class MailService
{
  private $userRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
  }

  public function sendMail($name, $mail, $resaDate, $resaTime, $numberOfGuests)
  {
    $to = $mail . ", @letoiledoree.com";
    $subject = "Reservation L'Étoile Dorée";
    $message = "Bonjour " . $name . ",\n\n" . "Merci pour votre réservation pour le " . $resaDate . " à " . $resaTime . " pour " . $numberOfGuests . " invité(s).\n\n" . "Lorsqu'elle sera validée par notre équipe vous recevrez un mail de confirmation.\n\n" . "Cordialement,\n" . "L'équipe de l'hôtel.";
    $hash = password_hash($mail, PASSWORD_BCRYPT);
    $encryptedMail = base64_encode($hash);

    $message = $message . "\n\n" . "Vous pouvez toujours l'annuler en cliquant sur ce lien : " . FULL_URL . "cancel?id=" . $encryptedMail;
    $headers = "From: L'Étoile Dorée <contact@letoiledoree.com>\r\n";
    $headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
    $headers .= "Content-Transfer-Encoding: 8bit\n";
    $sentMail = mail($to, $subject, $message, $headers);
    return $sentMail;
  }
}
