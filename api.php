<?php 

include_once('classes/autoload.php');

use classes\Sapi;

$s = new Sapi();
$s->set_routes('/login', function () {
  return ['testing' => 'asd'];
}, 'POST');

$s->set_routes('/register', function () {
  return 'oke';
});

$s->run();