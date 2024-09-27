<div id="sidebar" class="absolute sm:relative w-64 h-full sm:h-auto bg-gray-900/40 backdrop-blur-lg backdrop-filter border-r border-gray-700 text-white shadow z-10 hidden flex-col">
  <div class="flex flex-col h-full">
    <!-- Sidebar content -->
    <?php if (isset($_SESSION['isAuth']) && $view_section == 'app'): ?>
      <div class="flex-grow">
        <!-- Dashboard navigation -->
        <div class="p-4">
          <h3>App</h3>
          <ul class="flex-1 overflow-y-auto">
            <li id="dashboard-app-nav-button" data-section="app-dashboard" class="flex hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">
              <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z" />
              </svg>
              Chat
            </li>
            <li id="settings-app-nav-button" data-section="app-bot-settings" class="flex hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">
              <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z" />
              </svg>
              Bot settings
            </li>
            <li id="bot-features-app-nav-button" data-section="app-bot-features" class="flex hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">
              <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="m422-232 207-248H469l29-227-185 267h139l-30 208ZM320-80l40-280H160l360-520h80l-40 320h240L400-80h-80Zm151-390Z" />
              </svg>
              Bot features
            </li>
            <li id="account-app-nav-button" data-section="app-account" class="flex hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">
              <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-8 18-13.5 37.5T404-360h-4q-71 0-127.5 18T180-306q-9 5-14.5 14t-5.5 20v32h252q6 21 16 41.5t22 38.5H80Zm560 40-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80Zm40-120q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-560q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Zm12 400Z" />
              </svg>
              Account
            </li>
            <li id="keys-app-nav-button" data-section="app-keys" class="flex hover:text-gray-300 hover:cursor-pointer hover:bg-gray-600 p-2 rounded w-full">
              <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M280-400q-33 0-56.5-23.5T200-480q0-33 23.5-56.5T280-560q33 0 56.5 23.5T360-480q0 33-23.5 56.5T280-400Zm0 160q-100 0-170-70T40-480q0-100 70-170t170-70q67 0 121.5 33t86.5 87h352l120 120-180 180-80-60-80 60-85-60h-47q-32 54-86.5 87T280-240Zm0-80q56 0 98.5-34t56.5-86h125l58 41 82-61 71 55 75-75-40-40H435q-14-52-56.5-86T280-640q-66 0-113 47t-47 113q0 66 47 113t113 47Z" />
              </svg>
              Local Keys
            </li>
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