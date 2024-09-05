<?php
spl_autoload_register('loadClass');

function loadClass($class)
{
  $class = str_replace('src\\', '', $class);
  $classPath = str_replace('\\', '/', $class) . '.php';
  $filePath = __DIR__ . '/' . $classPath;

  if (file_exists($filePath))
  {
    require_once $filePath;
  }
  else
  {
    error_log('Class ' . $class . ' not found at path: ' . $filePath);
    throw new Exception('Class ' . $class . ' not found.');
  }
}
