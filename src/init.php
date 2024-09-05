<?php
require_once __DIR__ . '/autoload.php';

session_start();

require_once __DIR__ . "/../config.local.php";

// if (DB_INITIALIZED == FALSE)
// {
//   $db = new src\Models\Database();
//   echo $db->initialiserBDD();
// }

require_once __DIR__ . "/router.php";
