<?php
include __DIR__ . '/Includes/header.php';
include __DIR__ . '/Includes/Components/controlPanel.php';
?>

<section id="app-dashboard">
  <h2>Dashboard</h2>
  <p>"This is the dashboard: data = "<pre><?= var_dump($view_userData) ?></pre>"</p>
</section>

<section id="app-bot-settings" class="hidden">
  <h2>Bot settings</h2>
  <p><?= "Please select a profile."; ?></p>
</section>

<section id="app-bot-features" class="hidden">
  <h2>Bot Features</h2>
  <p><?= "Please select a profile."; ?></p>
</section>

<section id="app-account" class="hidden">
  <h2>Account settings</h2>
  <p>Username : <?= htmlspecialchars($view_userData["user"]["username"] ?? '') ?></p>
  <p>Mail : <?= htmlspecialchars($view_userData["user"]["mail"] ?? '') ?></p>
  <p>Twitch username : <?= htmlspecialchars($view_userData["user"]["twitchUsername"] ?? 'Link your account now!') ?></p>
  <p>Role : <?= htmlspecialchars($view_userData["user"]["roleName"] ?? '') ?></p>
</section>

<?php
include __DIR__ . '/Includes/footer.html';
?>