<?php

spl_autoload_register(function ($class) {
  $class .= '.php';
  $class = str_replace('\\', '/', $class);
  include_once $class;
});