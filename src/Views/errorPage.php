<?php
include __DIR__ . '/Includes/header.php';
include __DIR__ . '/Includes/interface.php';
?>

<main>
  <p><?= 'Error ' . http_response_code() . ': ' . $view_message ?></p>
</main>

<?php
include __DIR__ . '/Includes/footer.php';
?>