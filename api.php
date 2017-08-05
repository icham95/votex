<?php 

include_once('classes/autoload.php');

use classes\{ Sapi, Database};

$s = new Sapi();
$s->set_routes('/login', function () {
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

  if (count($msgErr) > 0) {
    Sapi::toJSON([
      'success' => false,
      'msg' => $msgErr
    ]);
  } else {
    $db = new Database();
    $users = $db->getUser('name', $data->username);
    if (count($users) > 0) {
      if (password_verify($data->password, $users[0]['password']) == true) {
        Sapi::toJSON([
          'success' => true,
          'msg' => 'login berhasil'
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
}, 'POST');

$s->set_routes('/register', function () {
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
}, 'POST');

$s->set_routes('/testing', function () {
  Sapi::toJSON(['testing' => 'oke']);
});

$s->run();
