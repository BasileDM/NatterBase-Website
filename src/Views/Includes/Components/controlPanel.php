<?php
$botProfiles = $view_userData['botProfiles'];
?>
<div id="control-panel" class="pb-4 flex border-b border-gray-700 items-center justify-between">
  <div id="profile-buttons">
    <div class="flex flex-col items-center gap-2">
      <div id="create-bot-profile" class="text-center btn btn-base w-full">Create a bot</div>
      <select id="bot-profiles-selector" class="text-black self-center max-w-40 rounded text-center" name="bot-profile">
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
    <div class="btn btn-success items-center justify-center">Run bot</div>
  </div>
</div>

<?php include __DIR__ . '/Modals/createBotModal.html' ?>