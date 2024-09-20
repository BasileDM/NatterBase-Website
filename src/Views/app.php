<?php
include __DIR__ . '/Includes/header.php';
include __DIR__ . '/Includes/Components/controlPanel.php';
?>

<section id="app-dashboard">
  <h2>Dashboard</h2>
  <p>"This is the dashboard: data = "<pre><?= var_dump($botProfiles) ?></pre>"</p>
</section>
<section id="app-bot-features" class="hidden">
  <h2>Bot Features</h2>
  <p><?= "These are the bot features"; ?></p>
</section>
<section id="app-settings" class="hidden">
  <h2>App settings</h2>
  <p><?= "This is the app settings"; ?></p>
</section>
<section id="app-account" class="hidden">
  <h2>Account settings</h2>
  <p><?= "This is your account"; ?></p>
</section>

<?php
include __DIR__ . '/Includes/footer.php';
?>