<?php
include __DIR__ . '/Includes/header.php';
include __DIR__ . '/Includes/Components/controlPanel.php';
?>

<section id="app-dashboard">
  <h2>Dashboard</h2>
  <p>Welcome, <?= $view_userData["user"]["username"] ?>. Please select a bot.</p>
  <pre><?= var_dump($view_userData) ?></pre>
</section>

<section id="app-bot-settings" class="hidden">
  <h2>Bot settings</h2>
  <p>Please select a bot.</p>
  <form action="" class="space-y-4">
    <p>Creation date: </p>
    <div>
      <label for="bot-name">Bot profile name</label>
      <input class="input" type="text" name="name" id="bot-name">
    </div>
    <div>
      <label for="bot-platform">Bot platform</label>
      <input class="input" type="text" name="platform" id="bot-platform">
    </div>
    <div>
      <label for="bot-cooldown">Bot cooldown</label>
      <input class="input" type="number" name="cooldown" id="bot-cooldown">
    </div>
    <div class="flex gap-2">
      <span class="btn btn-success">Save</span>
      <span class="btn btn-alert">Delete</span>
    </div>
  </form>
</section>

<section id="app-bot-features" class="hidden">
  <h2>Bot Features</h2>
  <p>Please select a bot.</p>
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