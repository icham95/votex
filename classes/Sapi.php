<?php 

namespace classes;

# SAPI (SAM API)
# Belajar Belajar Belajar -.-"

class Sapi
{
  public $routes = [];

  public function set_routes ($path, $function, $verb = 'GET') {
    $this->routes[$path]['verb'] = $verb;
    $this->routes[$path]['function'] = $function;
  }

  public function run()
  {
    $http_verb = $_SERVER['REQUEST_METHOD'];
    $get = $_GET['key'];
    $get = substr($get, 3);
    foreach ( $this->routes as $key => $value ) {
      if ($get === $key) {
        if ( $value['verb'] == $http_verb ) {
          $type_var = gettype($value['function']);
          if ($type_var == 'string') {
            $controller = $value['function'];
            $explode_controller = explode('/', $controller);
            include_once "classes/" . $explode_controller[0] . '.php';
            $object = new $explode_controller[0]();
            return $object->{$explode_controller[1]}();
          } else if ($type_var == 'object') {
            return $value['function']();
          }
          break 1;
        }
      }
    }
  }

  static function toJSON($arr)
  {
    echo json_encode($arr);
  }
}
