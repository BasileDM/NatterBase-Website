<?php
$botProfiles = $view_userData['botProfiles'];
?>
<div id="control-panel" class="pb-4 flex border-b border-gray-700 items-center justify-between">
  <div id="profile-buttons">
    <div class="flex flex-col items-center gap-2">
      <div id="create-bot-profile-btn" class="text-center btn btn-base w-full">Create a bot</div>
      <select id="bot-profiles-selector" class="text-black self-center w-full max-w-40 rounded text-center hover:cursor-pointer" name="bot-profile">
        <option value="default" selected hidden>Select a bot</option>
        <?php foreach ($botProfiles as $key => $botProfile): ?>
          <option
            value="<?= $botProfile['idBot'] ?>"
            data-index="<?= $key ?>">
            <?= $botProfile['name'] ?>
          </option>
        <?php endforeach ?>
      </select>
    </div>
  </div>
  <div id="bot-buttons">
    <div id="run-bot-btn" class="btn btn-success items-center justify-center hidden">Run bot</div>
    <div id="run-bot-btn-disabled" class="btn btn-success btn-disabled items-center justify-center">No bot selected</div>
    <?php if (isset($_SESSION['authLevel']) && $_SESSION['authLevel'] == '2') : ?>
      <div>
        <label class="block text-sm font-medium" for="account-section-channelOverride">Channel override (admin)</label>
        <input class="input" type="text" name="channelOverride" id="account-section-channelOverride">
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . '/Modals/createBotModal.html' ?>