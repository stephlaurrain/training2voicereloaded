<?php

/* if (!$_rel_path) {  $_rel_path = "../.."; } */

/* return array(
  "db" => "sqlite:" . $_rel_path."/db/training.db3",
  "username" => "",
  "password" => ""
  );
 * // "options" => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
 *  */

return array(
    "db" => "mysql:host=localhost;dbname=training2voice",
    "user" => "root",
    "pass" => "12345",
    "options" => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
);
?>

