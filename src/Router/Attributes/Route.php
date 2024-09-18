<?php

namespace src\Router\Attributes;

#[\Attribute]
class Route
{
  public function __construct(public string $method, public string $path) {}
}
