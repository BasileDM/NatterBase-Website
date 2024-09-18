<!-- Mobile sidebar menu -->
<aside id="sidebar" class="fixed left-0 top-12 w-64 h-full text-white hidden border-r-[1px] border-t-[1px] border-gray-700 bg-gray-900/40 backdrop-filter backdrop-blur-lg shadow sm:hidden">
  <ul class="space-y-4 p-4">
    <li><a href="/" class="hover:text-gray-300">Home</a></li>
    <li><a href="/features" class="hover:text-gray-300">Features</a></li>
  </ul>
  <?php if (isset($_SESSION['isAuth'])): ?>
  <a id="sidebar-app-button" class="btn btn-base mt-auto" href="/app">Web app</a>
  <?php else: ?>
  <span id="sidebar-login-button" class="btn btn-base mt-auto">Web app</span>
  <?php endif ?>
</aside>