<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= HOME_URL ?>assets/css/output.css">
  <script type="module" src="<?= HOME_URL ?>assets/js/main.js"></script>
  <?php if (isset($_SESSION['userId'])): ?>
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
            <li><a href="/" class="<?= $view_section == 'home' ? 'border-b-[1px] border-white' : '' ?> hover:text-gray-300">Home</a></li>
            <li><a href="/features" class="<?= $view_section == 'features' ? 'border-b-[1px] border-white' : '' ?> hover:text-gray-300">Features</a></li>
          </ul>
        </nav>
        <?php if (isset($_SESSION['isAuth'])): ?>
          <a id="navbar-app-button" class="btn btn-base" href="/app">Web app</a>
        <?php else: ?>
          <span id="navbar-login-button" class="btn btn-base">Web app</span>
        <?php endif ?>
      </div>

      <!-- Burger button -->
      <button id="burger-btn" class="block sm:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
    </div>
    <?php include __DIR__ . '/Components/banner.php'; ?>
  </header>