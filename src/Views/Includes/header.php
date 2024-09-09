<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= HOME_URL ?>assets/css/output.css">
  <script type="module" src="<?= HOME_URL ?>assets/js/script.js"></script>
  <?php if (isset($_SESSION['user_id'])): ?>
    <script type="module" src="<?= HOME_URL ?>assets/js/app.js"></script>
  <?php endif ?>
  <title>NatterBase</title>
</head>

<body class="bg-gray-800 text-white">
  <header class="bg-gray-900 text-white shadow border-b-[1px] border-gray-700">
    <div class="container w-11/12 mx-auto flex justify-between items-center py-2">
      <h1 class="text-2xl font-bold">NatterBase</h1>

      <!-- Navigation bar -->
      <div class="hidden sm:flex items-center justify-between w-full">
        <nav class="flex-1">
          <ul class="flex justify-center space-x-4">
            <li><a href="/" class="hover:text-gray-300">Home</a></li>
            <li><a href="/about" class="hover:text-gray-300">About</a></li>
          </ul>
        </nav>
        <a href="/login" class="btn btn-base">Connexion</a>
      </div>

      <!-- Burger button -->
      <button id="menu-toggle" class="block sm:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>

      <!-- Mobile sidebar menu -->
      <aside id="sidebar" class="fixed left-0 top-0 w-64 h-full bg-gray-900 text-white hidden border-r-[1px] border-gray-700 sm:hidden">
        <ul class="space-y-4 p-4">
          <li><a href="/" class="hover:text-gray-300">Home</a></li>
          <li><a href="/about" class="hover:text-gray-300">About</a></li>
        </ul>
        <a href="/login" class="btn btn-base mt-auto">Connexion</a>
      </aside>

    </div>
  </header>