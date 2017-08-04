<?php 

namespace classes;

# SAPI (SAM API)
# Belajar Belajar Belajar -.-"

class Sapi
{
  public $routes = [];

  public function set_routes ($path, $function, $verb = 'GET') {
    $this->routes[$path]['verb'] = $verb;
    $this->routes[$path]['function'] = $function();
  }

  public function run()
  {
    $http_verb = $_SERVER['REQUEST_METHOD'];
    $get = $_GET['key'];
    $get = substr($get, 3);
    foreach ( $this->routes as $key => $value ) {
      if ($get == $key) {
        if ( $value['verb'] == $http_verb ) {
          echo json_encode($value['function']);
          break;
        }
      }
    }
  }
}
