<?php

namespace classes;
use PDO;

class Database
{
  
  public $host = 'localhost';
  public $username = 'root';
  public $password = 'root';
  public $database = 'db_votex';
  private $_instance;

  public function __construct () {
    $this->connect();
  }

  public function connect()
  {
    $this->_instance = new PDO('mysql:host=' .$this->host. ';dbname=' .$this->database. ';', $this->username, $this->password);
  }

  public function register($arr)
  {
    $sql = 'insert into users (name, password) values (?,?)';
    $sth = $this->_instance->prepare($sql);
    $sth->execute($arr);
    return $this->_instance->lastInsertId();
  }

  public function getUser($where, $value)
  {
    $sql = 'select * from users where name = ?';
    $sth = $this->_instance->prepare($sql);
    $sth->execute([$value]);
    return $sth->fetchAll();
    
  }

  public function disconnect () {
    $this->_instance = null;
  }

}
