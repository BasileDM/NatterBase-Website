<?php
$botProfiles = $view_userData['botProfiles'];
?>
<div id="control-panel" class="pb-4 flex border-b border-gray-700 items-center justify-between">
  <div id="profile-buttons">
    <div class="flex flex-col items-center">
      <div id="create-bot-profile" class="text-center btn btn-base">Create bot profile</div>
      <select class="text-black self-center w-full" id="bot-profiles-selector" name="bot-profile">
        <option class="text-center" value="default" selected>Or select one...</option>
        <?php foreach ($botProfiles as $key => $botProfile): ?>
          <option class="text-center" value="<?= $botProfile['idBot'] ?>" data-index="<?= $key ?>">
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