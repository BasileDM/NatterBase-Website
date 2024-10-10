<?php
include __DIR__ . '/Includes/header.php';
include __DIR__ . '/Includes/Components/controlPanel.php';
?>

<!-- Chat / Dashboard -->
<section id="app-dashboard">
  <h2>Chat</h2>
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
      <label class="block text-sm font-medium" for="account-section-twitch-channel">Join channel</label>
      <input class="input" type="text" name="twitchJoinChannel" id="account-section-twitch-channel">
      <div id="account-section-twitch-channel-error-display" class="text-red-500"></div>
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
  <div class="flex gap-2 items-center">
    <h2>Bot Features</h2>
    <a title="Documentation" target="_blank" href="./docs#features">
      <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
        <path d="M478-240q21 0 35.5-14.5T528-290q0-21-14.5-35.5T478-340q-21 0-35.5 14.5T428-290q0 21 14.5 35.5T478-240Zm-36-154h74q0-33 7.5-52t42.5-52q26-26 41-49.5t15-56.5q0-56-41-86t-97-30q-57 0-92.5 30T342-618l66 26q5-18 22.5-39t53.5-21q32 0 48 17.5t16 38.5q0 20-12 37.5T506-526q-44 39-54 59t-10 73Zm38 314q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
      </svg>
    </a>
  </div>
  <p id="bot-features-placeholder">Please select a bot.</p>

  <form id="bot-features-form">
    <div id="bot-features-display" class="flex flex-wrap gap-4 justify-start"></div>
    <button id="add-feature-button" class="btn btn-base hidden" type="button">Add New Feature</button>
    <button id="bot-features-save-btn" type="submit" class="btn btn-success mt-4 hidden">
      Save Features
    </button>
  </form>

  <!-- Feature Card Template -->
  <template id="feature-card-template">
    <div class="feature-card flex flex-col mt-2 bg-gray-900 text-white border-[1px] border-gray-700 shadow-lg p-4 rounded-md mb-4 min-w-[280px] max-w-[380px] flex-1">
      <div class="mb-2">
        <label class="block text-sm font-medium mb-1">Feature</label>
        <select name="feature-select" class="w-full p-2 bg-gray-700 text-white rounded"></select>
      </div>
      <div class="mb-2">
        <label class="block text-sm font-medium mb-1">Trigger</label>
        <input type="text" name="trigger" placeholder="Enter trigger" class="w-full p-2 bg-gray-700 text-white rounded" />
      </div>
      <div class="feature-fields flex-grow"></div>
      <button type="button" class="remove-feature-button mt-auto text-red-500 hover:text-red-700">Remove Feature</button>
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
      <span id="account-settings-save-btn" class="btn btn-success flex">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
          <path d="M840-680v480q0 33-23.5 56.5T760-120H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h480l160 160Zm-80 34L646-760H200v560h560v-446ZM480-240q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM240-560h360v-160H240v160Zm-40-86v446-560 114Z" />
        </svg>
        Save
      </span>
      <span id="account-settings-delete-btn" class="btn btn-alert flex">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
          <path d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z" />
        </svg>
        Delete account
      </span>
    </div>
  </form>
</section>

<!-- Local keys -->
<section id="app-keys" class="hidden">
  <div class="mt-4 space-y-4">
    <div class="flex gap-2 items-center">
      <h2>Local keys</h2>
      <a title="How to get keys ?" target="_blank" href="./docs#getting-started">
        <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
          <path d="M478-240q21 0 35.5-14.5T528-290q0-21-14.5-35.5T478-340q-21 0-35.5 14.5T428-290q0 21 14.5 35.5T478-240Zm-36-154h74q0-33 7.5-52t42.5-52q26-26 41-49.5t15-56.5q0-56-41-86t-97-30q-57 0-92.5 30T342-618l66 26q5-18 22.5-39t53.5-21q32 0 48 17.5t16 38.5q0 20-12 37.5T506-526q-44 39-54 59t-10 73Zm38 314q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
        </svg>
      </a>
    </div>
    <div>
      <label class="text-sm font-medium flex mb-2" for="twitchToken">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
          <path d="M2.149 0l-1.612 4.119v16.836h5.731v3.045h3.224l3.045-3.045h4.657l6.269-6.269v-14.686h-21.314zm19.164 13.612l-3.582 3.582h-5.731l-3.045 3.045v-3.045h-4.836v-15.045h17.194v11.463zm-3.582-7.343v6.262h-2.149v-6.262h2.149zm-5.731 0v6.262h-2.149v-6.262h2.149z" fill-rule="evenodd" clip-rule="evenodd" />
        </svg>
        Twitch token
      </label>
      <input class="input" type="password" name="twitchToken" id="account-section-twitchToken">
    </div>
    <div>
      <label class="flex text-sm font-medium mb-2" for="openAiKey">
        <svg fill="currentColor" width="24" height="24" viewBox="0 0 24 24" role="img" xmlns="http://www.w3.org/2000/svg">
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
          <g id="SVGRepo_iconCarrier">
            <title>OpenAI icon</title>
            <path d="M22.2819 9.8211a5.9847 5.9847 0 0 0-.5157-4.9108 6.0462 6.0462 0 0 0-6.5098-2.9A6.0651 6.0651 0 0 0 4.9807 4.1818a5.9847 5.9847 0 0 0-3.9977 2.9 6.0462 6.0462 0 0 0 .7427 7.0966 5.98 5.98 0 0 0 .511 4.9107 6.051 6.051 0 0 0 6.5146 2.9001A5.9847 5.9847 0 0 0 13.2599 24a6.0557 6.0557 0 0 0 5.7718-4.2058 5.9894 5.9894 0 0 0 3.9977-2.9001 6.0557 6.0557 0 0 0-.7475-7.0729zm-9.022 12.6081a4.4755 4.4755 0 0 1-2.8764-1.0408l.1419-.0804 4.7783-2.7582a.7948.7948 0 0 0 .3927-.6813v-6.7369l2.02 1.1686a.071.071 0 0 1 .038.052v5.5826a4.504 4.504 0 0 1-4.4945 4.4944zm-9.6607-4.1254a4.4708 4.4708 0 0 1-.5346-3.0137l.142.0852 4.783 2.7582a.7712.7712 0 0 0 .7806 0l5.8428-3.3685v2.3324a.0804.0804 0 0 1-.0332.0615L9.74 19.9502a4.4992 4.4992 0 0 1-6.1408-1.6464zM2.3408 7.8956a4.485 4.485 0 0 1 2.3655-1.9728V11.6a.7664.7664 0 0 0 .3879.6765l5.8144 3.3543-2.0201 1.1685a.0757.0757 0 0 1-.071 0l-4.8303-2.7865A4.504 4.504 0 0 1 2.3408 7.872zm16.5963 3.8558L13.1038 8.364 15.1192 7.2a.0757.0757 0 0 1 .071 0l4.8303 2.7913a4.4944 4.4944 0 0 1-.6765 8.1042v-5.6772a.79.79 0 0 0-.407-.667zm2.0107-3.0231l-.142-.0852-4.7735-2.7818a.7759.7759 0 0 0-.7854 0L9.409 9.2297V6.8974a.0662.0662 0 0 1 .0284-.0615l4.8303-2.7866a4.4992 4.4992 0 0 1 6.6802 4.66zM8.3065 12.863l-2.02-1.1638a.0804.0804 0 0 1-.038-.0567V6.0742a4.4992 4.4992 0 0 1 7.3757-3.4537l-.142.0805L8.704 5.459a.7948.7948 0 0 0-.3927.6813zm1.0976-2.3654l2.602-1.4998 2.6069 1.4998v2.9994l-2.5974 1.4997-2.6067-1.4997Z"></path>
          </g>
        </svg>
        OpenAI API key
      </label>
      <input class="input" type="password" name="openAiKey" id="account-section-openAiKey">
    </div>
  </div>
</section>

<?php
include __DIR__ . '/Includes/Components/Modals/confirmationModal.html';
include __DIR__ . '/Includes/footer.html';
?>