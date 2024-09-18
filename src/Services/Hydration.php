<?php

namespace src\Services;

trait Hydration
{
  public function __construct(array $data = [])
  {
    $this->hydrate($data);
  }

  public function __set($name, $value)
  {
    $this->hydrate([$name => $value]);
  }
  
  private function hydrate(array $data): void
  {
    $setter = "set";
    foreach ($data as $key => $value) {
      $parts = explode("_", $key);
      foreach ($parts as $part) {
        $part = strtolower($part);
        $part = ucfirst($part);
        $setter .= $part;
      }
      if (method_exists($this, $setter)) $this->$setter($value);
    }
  }

  private function hydrateFromInputs(array $inputs): void
  {
    foreach ($inputs as $key => $value) {
      $setter = "set" . ucfirst($key);
      if (method_exists($this, $setter)) $this->$setter($value);
    }
  }
}
