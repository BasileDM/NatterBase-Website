<div id="sidebar" class="absolute sm:relative w-64 h-full sm:h-auto bg-gray-900/40 backdrop-blur-lg backdrop-filter border-r border-gray-700 text-white shadow z-10 hidden flex-col">
  <div class="flex flex-col h-full">
    <!-- Sidebar content -->
    <?php if (isset($_SESSION['isAuth'])): ?>
    <div class="flex-grow">
      <!-- Dashboard navigation -->
      <div class="p-4">
        <h3>App</h3>
        <ul class="flex-1 overflow-y-auto">
          <li id="dashboard-app-nav-button" data-section="app-dashboard" class="hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">Dashboard</li>
          <li id="bot-features-app-nav-button" data-section="app-bot-features" class="hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">Bot Features</li>
          <li id="settings-app-nav-button" data-section="app-settings" class="hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">App settings</li>
          <li id="account-app-nav-button" data-section="app-account" class="hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">Account</li>
        </ul>
      </div>
    </div>
    <?php endif ?>
    <!-- Site navigation -->
    <div id="website-mobile-nav" class="p-4">
      <h3>Website navigation</h3>
      <ul class="flex-1 overflow-y-auto">
        <a href="/">
          <li class="hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">
            Home
          </li>
        </a>
        <a href="/features">
          <li class="hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">
            Features
          </li>
        </a>
      </ul>
    </div>
    <div class="p-4">
      <?php if (isset($_SESSION['isAuth'])): ?>
        <a id="sidebar-app-button" class="btn btn-base" href="/app">Web app</a>
        <a id="sidebar-logout-button" class="btn btn-alert" href="/logout">Logout</a>
      <?php else: ?>
        <span id="sidebar-login-button" class="btn btn-base">Web app</span>
      <?php endif ?>
    </div>
  </div class="flex flex-col h-full">
</div>