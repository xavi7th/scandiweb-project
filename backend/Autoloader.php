<?php

namespace Backend;

class Autoloader
{
  private $prefix;

  public function setPrefix($prefix)
  {
    return $this->prefix = $prefix;
  }

  private function registerAllFiles($dir)
  {
    //? Ignore hidden files that start with a .
    $files = preg_grep('/^([^.])/', scandir($dir));

    foreach ($files as $key => $value) { // ignore files we don't want to autoload
      if (in_array($value, ['routes.php', 'index.php', '.gitignore', 'README.md', 'Views', 'frontend', 'extras', 'cgi-bin', 'errors.log'])) {
        continue;
      }

      if (is_file($dir . '/' . $value)) {
        include_once($dir . '/' . $value);
        continue;
      }

      $this->registerAllFiles($dir . '/' . $value);
    }
  }

  public function register()
  {
    $this->registerAllFiles('./');

    spl_autoload_register(function ($class) {
      include $this->prefix . $class . '.php';
    });

    session_start();
  }
}
