<?php

namespace src\Router;

// Global variable to store headers
$GLOBALS['headers'] = [];

// Redefine the header() function in this namespace
function header($string, $replace = true, $http_response_code = null)
{
  $GLOBALS['headers'][] = $string;
}
