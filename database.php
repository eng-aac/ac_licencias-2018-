<?php
$server = 'localhost';
$username = 'root';
$password = '';

/*CREATE DATABASE base_datos_personal DEFAULT CHARACTER set utf8 COLLATE utf8_spanish2_ci;*/

$database = 'base_datos_personal';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
  
}
?>