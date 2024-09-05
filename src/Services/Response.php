<?php

namespace src\Services;

trait Response
{
  public function render(string $view, array $data = ['section' => '', 'action' => ''])
  {
    if (!empty($data))
    {
      foreach ($data as $key => $value)
      {
        ${'view_' . $key} = $value;
      }
    }
    if (!isset($section))
    {
      $section = '';
    }
    if (!isset($action))
    {
      $action = '';
    }
    include_once __DIR__ . '/../Views/' . $view . ".php";
  }
}
