<?php
include __DIR__ . '/Includes/header.php';
?>

<div class="flex items-center justify-center min-h-fit h-full">
  <section class="h-full min-w-[304px] mx-auto flex flex-col sm:flex-row items-center justify-between space-y-8 sm:space-y-0 sm:space-x-8">
    <div class="text-center sm:text-left min-w-[280px] max-w-[480px]">
      <h1 class="text-4xl font-bold mb-4">Welcome to Natterbase</h1>
      <p class="text-gray-300 mb-6">
        Manage your bots with ease, create profiles, add AI features and all of this 100% locally.
      </p>
      <div class="flex flex-row space-x-4 items-center justify-evenly sm:justify-start">
        <div href="./app" id="homepage-login-btn" class="btn btn-base rounded-lg px-6 py-3 flex">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-120v-80h280v-560H480v-80h280q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H480Zm-80-160-55-58 102-102H120v-80h327L345-622l55-58 200 200-200 200Z" />
          </svg>
          Log in
        </div>
        <a href="./docs" class="btn flex px-6 py-3 border border-gray-600 text-gray-300 rounded-lg shadow hover:bg-gray-600 transition">
          Learn more
        </a>
      </div>
    </div>
    <!-- Illustration -->
    <img src="./assets/img/twitch-chat.png" class="w-auto min-w-auto h-auto max-h-[75vh] border-[1px] border-gray-600 shadow-xl rounded-lg" alt="Natterbase chat application illustration">
  </section>
</div>

<?php
include __DIR__ . '/Includes/footer.html';
?>