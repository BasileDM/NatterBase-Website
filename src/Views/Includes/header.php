<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Natterbase allows to to make your own AI chatbot for twitch.">
  <meta name="keywords" content="natterbase, twitch, chatbot, AI">
  <meta name="robots" content="index, follow">
  <link rel="stylesheet" href="./assets/css/output.css">
  <link rel="icon" type="image/x-icon" href="./assets/img/favicon.png">
  <script type="module" src="./assets/js/main.js" defer></script>
  <?php if (isset($_SESSION['userId']) && $view_section == 'app'): ?>
    <script src="./assets/js/lib/tmi.min.js"></script>
    <script type="module" src="./assets/js/app.js" defer></script>
  <?php endif ?>
  <title>Natterbase |
    <?php
    if ($view_section == 'app') {
      echo 'App';
    } else if ($view_section == 'docs') {
      echo 'Docs';
    } else {
      echo 'Home';
    }
    ?>
  </title>
</head>

<body class="bg-gray-800 text-white h-screen flex flex-col overflow-hidden bg-gradient-to-b from-gray-800 via-[rgba(31,41,55,0.8)] to-gray-900">
  <header class="bg-gray-900 text-white shadow border-b-[1px] border-gray-700">
    <div class="mx-5 flex justify-between items-center py-2">
      <?php include __DIR__ . '/Components/logo.php'; ?>
      <!-- Navigation bar -->
      <div class="hidden sm:flex items-center justify-between w-full">
        <nav class="flex-1">
          <ul class="flex justify-center space-x-4">
            <li class="flex hover:text-gray-300 hover:cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
              </svg>
              <a href="./" class="<?= $view_section == 'home' ? 'border-b-[1px] border-white' : '' ?> hover:text-gray-300">
                Home
              </a>
            </li>
            <li class="flex hover:text-gray-300 hover:cursor-pointer">
              <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
              </svg>
              <a href="./docs" class="<?= $view_section == 'docs' ? 'border-b-[1px] border-white' : '' ?> hover:text-gray-300">
                Docs
              </a>
            </li>
          </ul>
        </nav>
        <?php if (isset($_SESSION['isAuth']) && $view_section != 'app'): ?>
          <a id="navbar-app-button" class="btn btn-base flex" href="./app">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
              <path d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880q83 0 155.5 31.5t127 86q54.5 54.5 86 127T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80Zm0-82q26-36 45-75t31-83H404q12 44 31 83t45 75Zm-104-16q-18-33-31.5-68.5T322-320H204q29 50 72.5 87t99.5 55Zm208 0q56-18 99.5-55t72.5-87H638q-9 38-22.5 73.5T584-178ZM170-400h136q-3-20-4.5-39.5T300-480q0-21 1.5-40.5T306-560H170q-5 20-7.5 39.5T160-480q0 21 2.5 40.5T170-400Zm216 0h188q3-20 4.5-39.5T580-480q0-21-1.5-40.5T574-560H386q-3 20-4.5 39.5T380-480q0 21 1.5 40.5T386-400Zm268 0h136q5-20 7.5-39.5T800-480q0-21-2.5-40.5T790-560H654q3 20 4.5 39.5T660-480q0 21-1.5 40.5T654-400Zm-16-240h118q-29-50-72.5-87T584-782q18 33 31.5 68.5T638-640Zm-234 0h152q-12-44-31-83t-45-75q-26 36-45 75t-31 83Zm-200 0h118q9-38 22.5-73.5T376-782q-56 18-99.5 55T204-640Z" />
            </svg>
            Web app
          </a>
        <?php elseif (!isset($_SESSION['isAuth'])): ?>
          <span id="navbar-login-button" class="btn btn-base flex">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
              <path d="M480-80q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-155.5t86-127Q252-817 325-848.5T480-880q83 0 155.5 31.5t127 86q54.5 54.5 86 127T880-480q0 82-31.5 155t-86 127.5q-54.5 54.5-127 86T480-80Zm0-82q26-36 45-75t31-83H404q12 44 31 83t45 75Zm-104-16q-18-33-31.5-68.5T322-320H204q29 50 72.5 87t99.5 55Zm208 0q56-18 99.5-55t72.5-87H638q-9 38-22.5 73.5T584-178ZM170-400h136q-3-20-4.5-39.5T300-480q0-21 1.5-40.5T306-560H170q-5 20-7.5 39.5T160-480q0 21 2.5 40.5T170-400Zm216 0h188q3-20 4.5-39.5T580-480q0-21-1.5-40.5T574-560H386q-3 20-4.5 39.5T380-480q0 21 1.5 40.5T386-400Zm268 0h136q5-20 7.5-39.5T800-480q0-21-2.5-40.5T790-560H654q3 20 4.5 39.5T660-480q0 21-1.5 40.5T654-400Zm-16-240h118q-29-50-72.5-87T584-782q18 33 31.5 68.5T638-640Zm-234 0h152q-12-44-31-83t-45-75q-26 36-45 75t-31 83Zm-200 0h118q9-38 22.5-73.5T376-782q-56 18-99.5 55T204-640Z" />
            </svg>
            Web app
          </span>
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

  <!-- Sidebar and main content -->
  <main class="flex flex-1 relative overflow-hidden">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <div class="flex flex-col flex-1 p-4 overflow-auto custom-scrollbar">
      <?php
      include __DIR__ . '/Components/toast.html';
      include __DIR__ . '/Components/Modals/loginModal.html';
      ?>