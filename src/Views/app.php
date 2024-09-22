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
  <p id="bot-settings-placeholder">Please select a bot.</p>
  <form action="" class="space-y-4 hidden" id="bot-settings-form">
    <p id="bot-settings-creation-date">Creation date: </p>
    <div>
      <label class="block text-sm font-medium" for="bot-name">Profile name</label>
      <input class="input" type="text" name="name" id="bot-name">
    </div>
    <div>
      <label class="block text-sm font-medium" for="bot-platform">Platform</label>
      <input class="input" type="text" name="platform" id="bot-platform" disabled>
    </div>
    <div>
      <label class="block text-sm font-medium" for="bot-cooldown">Cooldown</label>
      <input class="input" type="number" name="cooldown" id="bot-cooldown">
    </div>
    <div class="flex gap-2">
      <span class="btn btn-success">Save</span>
      <span class="btn btn-alert">Delete profile</span>
    </div>
  </form>
</section>

<section id="app-bot-features" class="hidden">
  <h2>Bot Features</h2>
  <p id="bot-features-placeholder">Please select a bot.</p>
</section>

<section id="app-account" class="hidden">
  <h2>Account settings</h2>
  <form action="" class="space-y-4">
    <div>
      <label class="block text-sm font-medium" for="username">Username</label>
      <input class="input" type="text" name="username" id="account-section-username"
        value="<?= htmlspecialchars($view_userData["user"]["username"] ?? '') ?>">
    </div>
    <div>
      <label class="block text-sm font-medium" for="mail">Mail</label>
      <input class="input" type="text" name="mail" id="account-section-mail"
        value="<?= htmlspecialchars($view_userData["user"]["mail"] ?? '') ?>" disabled>
    </div>
    <div>
      <label class="block text-sm font-medium" for="openAiKey">OpenAI API key</label>
      <input class="input" type="text" name="openAiKey" id="account-section-openAiKey">
    </div>
    <div>
      <label class="block text-sm font-medium" for="twitchUsername">Twitch username</label>
      <input class="input" type="text" name="twitchUsername" id="account-section-twitchUsername"
        value="<?= htmlspecialchars($view_userData["user"]["twitchUsername"] ?? '') ?>">
    </div>
    <div class="flex gap-2">
      <span class="btn btn-success">Save</span>
      <span class="btn btn-alert">Delete account</span>
    </div>
  </form>
</section>

<?php
include __DIR__ . '/Includes/footer.html';
?>