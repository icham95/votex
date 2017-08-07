<?php 

include_once('classes/autoload.php');

use classes\{ Sapi, Database};

$_key = 'begadang';

$s = new Sapi();
$s->set_routes('/login', 'Controller_api/login', 'POST');
$s->set_routes('/register', 'Controller_api/register', 'POST');

$s->set_routes('/testing', function () {
  echo 'testing';
});

$s->set_routes('/jwt', 'Controller_api/jwt');

$s->run();
