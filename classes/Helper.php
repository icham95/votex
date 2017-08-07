<?php 

namespace classes;

class Helper
{
  static function get_contents()
  {
    $payload = file_get_contents('php://input');
    return json_decode($payload);
  }
}
