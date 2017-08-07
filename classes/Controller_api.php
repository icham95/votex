<?php 

namespace classes;

include_once('vendor/autoload.php');

use classes\Helper;
use \Firebase\JWT\JWT;

class Controller_api
{
  private $_key = 'belajardanngopi';
  
  public function login()
  {
    $data = Helper::get_contents();

    // validation
    $msgErr = [];
    if (strlen($data->username) < 1) {
      array_push($msgErr, 'Username tidak boleh kosong');
    }

    if (strlen($data->password) < 1) {
      array_push($msgErr, 'Password tidak boleh kosong');
    }

    if (count($msgErr) > 0) {
      Sapi::toJSON([
        'success' => false,
        'msg' => $msgErr,
      ]);
    } else {
      $db = new Database();
      $users = $db->getUser('name', $data->username);
      if (count($users) > 0) {
        if (password_verify($data->password, $users[0]['password']) == true) {
          Sapi::toJSON([
            'success' => true,
            'msg' => 'login berhasil',
            'token' => $this->generate_token($users[0])
          ]);
        } else {
          Sapi::toJSON([
            'success' => false,
            'msg' => 'username dan password tidak cocok!'
          ]);  
        }
      } else {
        Sapi::toJSON([
          'success' => false,
          'msg' => 'username dan password tidak cocok!'
        ]);
      }
    }
  }

  public function register()
  {
    $payload = file_get_contents('php://input');
    $data = json_decode($payload);

    // validation
    $msgErr = [];
    if (strlen($data->username) < 1) {
      array_push($msgErr, 'Username tidak boleh kosong');
    }

    if (strlen($data->password) < 1) {
      array_push($msgErr, 'Password tidak boleh kosong');
    }

    $db = new Database();
    $users = $db->getUser('name', $data->username);
    if (count($users) > 0) {
      array_push($msgErr, 'User sudah terdaftar');
    } 

    if (count($msgErr) > 0) {
      Sapi::toJSON([
        'success' => false,
        'msg' => $msgErr
      ]);
    } else {
      $data->password = password_hash($data->password, PASSWORD_DEFAULT);
      $arr = [$data->username, $data->password];
      $insert_id = $db->register($arr);
      Sapi::toJSON([
        'success' => true,
        'data' => [
          'id' => $insert_id,
          'username' => $data->username
        ]
      ]);
    }
  }

  private function generate_token($data = null)
  {
    $token = array(
        "iat" => time(),
        "exp" => time() + (24 * 60 * 60),
        "data" => $data
    );
    return JWT::encode($token, $this->_key);
  }

  public function jwt()
  {
    // 1day
    // echo time() + (24 * 60 * 60);
    // 7 24 hours
    // echo time() + (7 * 24 * 60 * 60);
    // http://php.net/manual/en/function.time.php

    $key = $this->_key;
    $token = array(
        "iat" => time(),
        "exp" => time() + (24 * 60 * 60),
        "data" => 'ini data'
    );
    $jwt = JWT::encode($token, $key);
    echo 'token : '.$jwt . '<br>';

    // deceded
    $decoded = JWT::decode($jwt, $key, array('HS256'));
    print_r($decoded);
  }
}


