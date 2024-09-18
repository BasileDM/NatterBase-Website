<div id="sidebar"
  class="absolute sm:relative w-64 h-full sm:h-auto bg-gray-900/40 backdrop-blur-lg backdrop-filter border-r border-gray-700 text-white shadow z-10 hidden flex-col min-h-0">
  <!-- Sidebar content -->
  <ul class="space-y-4 p-4 flex-1 overflow-y-auto">
    <li><a href="/" class="hover:text-gray-300">Home</a></li>
    <li><a href="/features" class="hover:text-gray-300">Features</a></li>
  </ul>
  <div class="p-4">
    <?php if (isset($_SESSION['isAuth'])): ?>
      <a id="sidebar-app-button" class="btn btn-base" href="/app">Web app</a>
    <?php else: ?>
      <span id="sidebar-login-button" class="btn btn-base">Web app</span>
    <?php endif ?>
  </div>
</div>