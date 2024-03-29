<?php
declare(strict_types=1);
namespace Parmonov98\Dotenv;

use Dotenv\Dotenv as CustomDotenv;

class Dotenv
{
  public $file_name = '';
  public $state = false;
  public $variables = [];

  function __construct(string $file_name = 'env')
  {
    $this->file_name = $file_name;
    $content = null;
    try {
      $filePath = getcwd() . "/." . $this->file_name;
      if (!file_exists($filePath)) {
        copy(getcwd() . "/.env.example", $filePath);
      }
      $content = file_get_contents($filePath);
    } catch (\Exception $e) {
      $this->state = $e->getMessage();
      return;
    }
    if ($content !== null) {
      $this->state = true;
      $this->variables = $this->parseVariables($content);
    }
  }

  function getState()
  {
    return $this->state;
  }
  function get(string $key)
  {
    if (isset($this->variables[$key])) {
      return $this->variables[$key];
    }
    return false;
  }
  function set(string $key, $value = null)
  {

    if (isset($this->variables[$key])) {
      return $this->variables[$key] = $value;
    }
    return false;
  }
  function save($save_to = '')
  {
    $vars = [];
    foreach ($this->variables as $key => $value) {
      $vars[] = $key . "=" . $value;
    }
    $this->variables = $vars;
    $content = implode("\n", $vars);
    try {

      if ($save_to !== '') {
        file_put_contents($save_to, $content);
      } else {
        file_put_contents($this->file_name, $content);
      }
    } catch (\Exception $e) {
      $this->state = $e->getMessage();
      return;
    }
    return true;
  }
  function refresh()
  {
    $content = file_get_contents($this->file_name);
    $this->variables = $this->parseVariables($content);
  }

  function parseVariables(string $content)
  {
    $lines = explode("\n", $content);
    $vars = array_filter($lines, 'trim');

    foreach ($vars as $key => $value) {
      $item = $value;
      if (stripos($item, '=') !== false) {
        $item = explode('=', $item);
        $vars[$item[0]] = $item[1];
        unset($vars[$key]);
      }
    }
    return $vars;
  }
}
