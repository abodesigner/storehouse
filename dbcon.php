<?php

$dsn  = 'mysql:host=localhost;dbname=shop';

$user = 'root';

$pwd  = '';

$option = array(
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

);

try {

  $con = new PDO($dsn, $user, $pwd, $option);

  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // echo "You Are Connected" . '<br>';

} catch (PDOException $e) {

  echo "connection failed" . $e->getMessage();
}
