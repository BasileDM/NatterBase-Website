<?php

namespace src\Router\Attributes;

#[\Attribute]
class Authorization
{
  public function __construct(public int $authLevel) {}
}
