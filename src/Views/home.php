<?php
include __DIR__ . '/Includes/header.php';
?>

<div class="flex items-center justify-center h-full">
  <section class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between space-y-8 md:space-y-0 md:space-x-8">
    <div class="text-center md:text-left">
      <h1 class="text-4xl font-bold mb-4">Welcome to NatterBase</h1>
      <p class="text-gray-300 mb-6">
        Manage your bots with ease and connect your apps efficiently with our powerful tools.
      </p>
      <div class="flex flex-col space-y-3 md:space-y-0 md:flex-row md:space-x-4">
        <a href="/app" class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-400 transition">Get Started</a>
        <a href="/login" class="px-6 py-3 border border-gray-600 text-gray-300 rounded-lg shadow hover:bg-gray-800 transition">Login</a>
      </div>
    </div>
    <!-- Illustration -->
    <div class="w-full md:w-1/2">
      <img src="./assets/img/twitch-chat.png" alt="Illustration" class="h-[80vh] w-auto">
    </div>
  </section>
</div>

<?php
include __DIR__ . '/Includes/footer.html';
?>