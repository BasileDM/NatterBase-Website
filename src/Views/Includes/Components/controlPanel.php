<?php
$botProfiles = $view_userData['botProfiles'];
?>
<div id="control-panel" class="pb-4 flex border-b border-gray-700 items-center justify-between">
  <div id="profile-buttons">
    <div class="flex flex-col items-center gap-2 min-w-32">
      <div id="create-bot-profile-btn" class="text-center btn btn-success w-full flex">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
          <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
        </svg>
        New bot
      </div>
      <select id="bot-profiles-selector" class="py-1 text-black self-center w-full max-w-40 rounded-full text-center hover:cursor-pointer" name="bot-profile">
        <option value="default" selected hidden>Select bot</option>
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
    <div id="run-bot-btn" class="btn btn-success items-center justify-center hidden rounded-full">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
        <path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z" />
      </svg>
      Run bot
    </div>
    <div id="run-bot-btn-disabled" class="btn btn-success btn-disabled items-center justify-center rounded-full flex">
      <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
        <path d="M320-200v-560l440 280-440 280Zm80-280Zm0 134 210-134-210-134v268Z" />
      </svg>
      No bot selected
    </div>
  </div>
</div>

<?php include __DIR__ . '/Modals/createBotModal.html' ?>