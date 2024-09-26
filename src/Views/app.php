<?php
include __DIR__ . '/Includes/header.php';
include __DIR__ . '/Includes/Components/controlPanel.php';
?>

<!-- Chat / Dashboard -->
<section id="app-dashboard">
  <h2>Dashboard</h2>
  <p>Welcome, <?= $view_userData["user"]["username"] ?>. <span id="dashboard-placeholder">Please select a bot.</span></p>
  <pre id="chat-display"></pre>
</section>

<!-- Bot settings -->
<section id="app-bot-settings" class="hidden">
  <h2>Bot settings</h2>
  <p id="bot-settings-placeholder">Please select a bot.</p>
  <form action="" class="space-y-4 hidden" id="bot-settings-form">
    <p id="bot-settings-creation-date">Creation date: </p>
    <div>
      <label class="block text-sm font-medium" for="bot-name">Profile name</label>
      <input class="input" type="text" name="name" id="bot-name">
      <div id="bot-name-error-display" class="text-red-500"></div>
    </div>
    <div>
      <label class="block text-sm font-medium" for="bot-platform">Platform</label>
      <input class="input" type="text" name="platform" id="bot-platform" disabled>
    </div>
    <div>
      <label class="block text-sm font-medium" for="account-section-twitch-channel">Join channel:</label>
      <input class="input" type="text" name="twitchJoinChannel" id="account-section-twitch-channel">
      <div id="account-section-twitch-channel-error-display" class="text-red-500"></div>
    </div>
    <div>
      <label class="block text-sm font-medium" for="account-section-openai-pre-prompt">OpenAI pre-prompt:</label>
      <textarea class="input" name="openaiPrePrompt" id="account-section-openai-pre-prompt"></textarea>
      <div id="account-section-openai-pre-prompt-error-display" class="text-red-500"></div>
    </div>
    <div>
      <label class="block text-sm font-medium" for="bot-cooldown">Cooldown</label>
      <input class="input" type="number" name="cooldownTime" id="bot-cooldown">
      <div id="bot-cooldown-error-display" class="text-red-500"></div>
    </div>
    <div class="flex gap-2">
      <span id="bot-settings-save-btn" class="btn btn-success">Save</span>
      <span id="bot-settings-delete-btn" class="btn btn-alert">Delete profile</span>
    </div>
  </form>
</section>

<!-- Bot features -->
<section id="app-bot-features" class="hidden">
  <h2>Bot Features</h2>
  <p id="bot-features-placeholder">Please select a bot.</p>

  <form id="bot-features-form">
    <div id="bot-features-display"></div>
    <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
      Save Features
    </button>
  </form>

  <!-- Feature Card Template -->
  <template id="feature-card-template">
    <div class="feature-card bg-gray-800 text-white p-4 rounded mb-4">
      <div class="mb-2">
        <label class="block text-sm font-medium mb-1">Trigger</label>
        <input type="text" name="trigger" placeholder="Enter trigger" class="w-full p-2 bg-gray-700 text-white rounded" />
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium mb-1">Feature</label>
        <select name="feature-select" class="w-full p-2 bg-gray-700 text-white rounded"></select>
      </div>
      <div class="feature-fields"></div>
      <button type="button" class="remove-feature-button mt-2 text-red-500 hover:text-red-700">Remove Feature</button>
    </div>
  </template>


</section>



<!-- Account settings -->
<section id="app-account" class="hidden">
  <h2>Account settings</h2>
  <form action="" class="space-y-4" id="account-settings-form">
    <div>
      <label class="block text-sm font-medium" for="username">Username</label>
      <input class="input" type="text" name="username" id="account-section-username"
        value="<?= htmlspecialchars($view_userData["user"]["username"] ?? '') ?>">
      <div id="account-section-username-error-display" class="text-red-500"></div>
    </div>
    <div>
      <label class="block text-sm font-medium" for="mail">Mail</label>
      <input class="input" type="text" name="mail" id="account-section-mail"
        value="<?= htmlspecialchars($view_userData["user"]["mail"] ?? '') ?>" disabled>
    </div>
    <div>
      <span id="account-settings-password-btn" class="btn btn-alert">Change password</span>
    </div>
    <div id="account-settings-password-inputs" class="hidden">
      <label class="block text-sm font-medium" for="account-section-password">New password</label>
      <input class="input" type="password" name="password" id="account-section-password" disabled>
      <div id="account-section-password-error-display" class="text-red-500"></div>
      <label class="block text-sm font-medium" for="account-section-password-confirm">Confirm password</label>
      <input class="input" type="password" name="confirmPassword" id="account-section-password-confirm" disabled>
      <div id="account-section-password-confirm-error-display" class="text-red-500"></div>
    </div>
    <div class="flex gap-2">
      <span id="account-settings-save-btn" class="btn btn-success">Save</span>
      <span id="account-settings-delete-btn" class="btn btn-alert">Delete account</span>
    </div>
  </form>
</section>

<!-- Local keys -->
<section id="app-keys" class="hidden">
  <div class="mt-4 space-y-4">
    <h2>Local keys</h2>
    <div>
      <label class="block text-sm font-medium" for="twitchToken">Twitch token</label>
      <input class="input" type="password" name="twitchToken" id="account-section-twitchToken">
    </div>
    <div>
      <label class="block text-sm font-medium" for="openAiKey">OpenAI API key</label>
      <input class="input" type="password" name="openAiKey" id="account-section-openAiKey">
    </div>
  </div>
</section>

<?php
include __DIR__ . '/Includes/Components/Modals/confirmationModal.html';
include __DIR__ . '/Includes/footer.html';
?>