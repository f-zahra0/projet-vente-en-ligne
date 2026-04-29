<?php

$dsn = "mysql:host=localhost;dbname=bd_eshop;charset=utf8mb4";
$user = "root";
$password = "";

try{

$db = new PDO($dsn,$user,$password);
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){

die("Erreur DB : ".$e->getMessage());

}