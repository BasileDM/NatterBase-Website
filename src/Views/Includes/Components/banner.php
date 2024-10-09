<?php
$notice = $_GET['notice'] ?? '';
$message = '';
$style = '';

switch ($notice) {
  case 'dbCreated':
    $message = '✅ Database tables successfully created.';
    $style = 'banner-success';
    break;
  case 'registered':
    $message = '⚠️ Pease check your mails to activate your account.';
    $style = 'banner-warning';
    break;
    case 'activated':
      $message = '✅ Your account has been activated. You can now login!';
      $style = 'banner-success';
      break;
  case 'success':
    $message = '✅ Success! Your request has been processed.';
    $style = 'banner-success';
    break;
  case 'warning':
    $message = '⚠️ Warning! There was a problem with your request.';
    $style = 'banner-warning';
    break;
  case 'alert':
    $message = '❌ Alert! Something went wrong.';
    $style = 'banner-alert';
    break;
  default:
    $message = '';
    break;
}

if ($message):
?>
  <div class="banner <?php echo $style; ?>">
    <div class="container mx-auto flex justify-between items-center px-4 py-2">
      <span class="text-white"><?php echo $message; ?></span>
      <button
        class="text-white font-bold hover:text-gray-200"
        onclick="this.parentElement.parentElement.style.display='none';">✖</button>
    </div>
  </div>
<?php endif; ?>