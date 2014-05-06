<?php 

session_start();

require_once("inc/config.php");
require_once("inc/users.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user = trim($_POST["user"]);
    $password = md5(trim($_POST["password"]));
    
    if ($user == "" OR $password == "") {
        header("Location: " . BASE_URL . "?err=empty");
        exit;
    }

    if(!isset($error_message)) {
        
        foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $header("Location: " . BASE_URL . "?err=prob");
                exit;    
            }
        }
    }

    if($password === sign_in($user)){
        
        $_SESSION['logged_in'] = 'y';
        $_SESSION['user'] = $user;

        header("Location: " . BASE_URL . "adduser/");
        exit;

    } else {

    	header("Location: " . BASE_URL . "?err=auth");
        exit;
    } 
}

?>