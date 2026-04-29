<?php
session_start();

require_once "../config/db_connect.php";
require_once "../models/UserManager.php";

if(isset($_POST["login"])){

    $username = $_POST["username"];
    $password = md5($_POST["password"]);   

    $userManager = new UserManager($db);
    $user = $userManager->authenticate($username, $password);

    if($user){
        $_SESSION["user"] = $user->getUsername();
        header("Location: ../views/dashboard.php");
        exit();
    }else{
        $error = "Login incorrect";
        require "../views/login.php";
        exit();
    }
}

if(isset($_GET["logout"])){
    session_destroy();
    header("Location: ../views/login.php");
    exit();
}
