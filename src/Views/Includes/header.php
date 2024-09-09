<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php HOME_URL ?>assets/css/output.css">
  <script src="<?php HOME_URL ?>assets/js/menu.js"></script>
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
        <a href="/login" class="custom-btn">Connexion</a>
      </div>

      <?php
      include __DIR__ . '/../Components/burger-button.php';
      include __DIR__ . '/../Components/sidebar.php';
      ?>

    </div>
  </header>