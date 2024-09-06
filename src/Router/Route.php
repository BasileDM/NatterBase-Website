<?php

namespace src\Router;

#[\Attribute]
class Route
{
  public function __construct(public string $method, public string $path) {}
}
