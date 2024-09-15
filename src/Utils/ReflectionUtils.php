<?php

namespace src\Utils;

use ReflectionClass;
use ReflectionMethod;

class ReflectionUtils
{
  public static function getPublicMethods(object $class): array
  {
    $reflector = new ReflectionClass($class);
    return $reflector->getMethods(ReflectionMethod::IS_PUBLIC);
  }
}