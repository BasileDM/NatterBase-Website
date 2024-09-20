<?php
$botProfiles = $view_userData['botProfiles'];
?>
<div id="control-panel" class="pb-4 flex border-b border-gray-700 items-center justify-between">
  <div id="profile-buttons">
    <div class="flex flex-col items-center">
      <div id="create-bot-profile" class="text-center btn btn-base">Create bot profile</div>
      <select class="text-black self-center w-full" id="bot-profiles-selector" name="bot-profile">
        <option class="text-center" value="default" selected>Or select one...</option>
        <?php foreach ($botProfiles as $botProfile): ?>
          <option class="text-center" value="<?= $botProfile['idBot'] ?>"><?= $botProfile['name'] ?></option>
        <?php endforeach ?>
      </select>
    </div>
  </div>
  <div id="bot-buttons">
    <div class="btn btn-success items-center justify-center">Run bot</div>
  </div>
</div>

<!-- Create bot profile modal -->
<dialog id="create-bot-profile-modal" class="max-h-[80vh] overflow-y-auto border-[1px] border-gray-700 rounded-lg p-6 max-w-lg mx-auto bg-gray-800 text-white shadow-lg">
  <h2>Create bot profile</h2>
  <form id="create-bot-profile-form" method="dialog" data-route="createBotProfile">
    <div>
      <label for="name" class="block text-sm font-medium">Name*</label>
      <input
        id="name"
        name="name"
        type="text"
        class="w-full p-2 rounded-md bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      <span id="name-error-display" class="text-red-500"></span>
    </div>
    <div>
      <label for="platform" class="block text-sm font-medium">Platform</label>
      <input
        id="platform"
        name="platform"
        type="text"
        class="text-gray-500 w-full p-2 rounded-md bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        value="Twitch.tv"
        disabled />
      <input type="hidden" name="platform" value="Twitch.tv" />
    </div>
    <div class="flex justify-end">
      <button id="create-bot-profile-submit-btn" type="submit" class="btn btn-base">Create</button>
    </div>
  </form>
</dialog>