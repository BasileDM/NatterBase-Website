<?php
include __DIR__ . '/Includes/header.php';
?>
<div id="control-panel" class="p-4 flex border-b border-gray-700">
  <div class="mr-4 flex flex-col">
    <label for="bot-profile-selector">Bot profile</label>
    <select name="bot-profile" id="bot-profile-selector" value="default" class="text-black">
      <option value="default">None...</option>
    </select>
  </div>
  <div class="mr-4 btn btn-base">Run bot</div>
</div>
<section id="app-dashboard">
  <h2>Dashboard</h2>
  <p><?= "This is the dashboard: data = " . $view_data . ""; ?></p>
  <p class="mb-96">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repudiandae asperiores velit accusamus ad, expedita voluptas cumque deleniti. Ex amet accusantium dicta veritatis eum temporibus odio inventore cupiditate fugiat. Cumque.</p>
  <p class="mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repudiandae asperiores velit accusamus ad, expedita voluptas cumque deleniti. Ex amet accusantium dicta veritatis eum temporibus odio inventore cupiditate fugiat. Cumque.</p>
  <p class="mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repudiandae asperiores velit accusamus ad, expedita voluptas cumque deleniti. Ex amet accusantium dicta veritatis eum temporibus odio inventore cupiditate fugiat. Cumque.</p>
  <p class="mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repudiandae asperiores velit accusamus ad, expedita voluptas cumque deleniti. Ex amet accusantium dicta veritatis eum temporibus odio inventore cupiditate fugiat. Cumque.</p>
  <p class="mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repudiandae asperiores velit accusamus ad, expedita voluptas cumque deleniti. Ex amet accusantium dicta veritatis eum temporibus odio inventore cupiditate fugiat. Cumque.</p>
  <p class="mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repudiandae asperiores velit accusamus ad, expedita voluptas cumque deleniti. Ex amet accusantium dicta veritatis eum temporibus odio inventore cupiditate fugiat. Cumque.</p>
  <p class="mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium repudiandae asperiores velit accusamus ad, expedita voluptas cumque deleniti. Ex amet accusantium dicta veritatis eum temporibus odio inventore cupiditate fugiat. Cumque.</p>
</section>
<section id="app-bot-features" class="hidden">
  <h2>Bot Features</h2>
  <p><?= "These are the bot features: data = " . $view_data . ""; ?></p>
</section>
<section id="app-settings" class="hidden">
  <h2>App settings</h2>
  <p><?= "This is the app settings: data = " . $view_data . ""; ?></p>
</section>
<section id="app-account" class="hidden">
  <h2>Account settings</h2>
  <p><?= "This is your account: data = " . $view_data . ""; ?></p>
</section>

<?php
include __DIR__ . '/Includes/footer.php';
?>