<?php

session_start();

require_once("../../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $company = utf8_encode(trim($_POST["company"]));
    $first = utf8_encode(trim($_POST["first"]));
    $last = utf8_encode(trim($_POST["last"]));
    $phone = utf8_encode(trim($_POST["phone"]));
    $user = $_SESSION["user"];

    if ($email == "" OR $company == "" OR $first == "" OR $last == "" or $phone == "") {
        header("Location: " . BASE_URL . "offline/assigndevice/adddata/index.php?err=empty&email=" . $email);
        exit;
    }

    if(!isset($error_message)) {
        foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $header("Location: " . BASE_URL . "offline/assigndevice/adddata/index.php?err=prob&email=" . $email);
                exit;        
            }
        }
    }


    if(!isset($error_message) && $_POST["employee"] != "") {
        $header("Location: " . BASE_URL . "offline/assigndevice/adddata/index.php?err=bot&email=" . $email);
        exit;
    }



    require(ROOT_PATH . "inc/database.php");

    try {

        $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,DB_USER,DB_PASS);
        $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $db -> exec ("SET NAMES 'utf8'");
        $db -> beginTransaction();

        $sql = "INSERT INTO tbl_merchants (email,company,first_name,last_name,phone,created_at,created_by) VALUES (:email,:company,:first_name,:last_name,:phone,:created_at,:created_by)";   
        $q = $db->prepare($sql);
        $q->execute(array(':email'=> $email,
                          ':company'=> $company,
                          ':first_name' => $first,
                          ':last_name' => $last,
                          ':phone' => $phone,
                          ':created_at' => date("Y-m-d H:i:s"),
                          ':created_by' => $user));

        if ($db->commit()){

            header("Location: " . BASE_URL . "offline/assigndevice/adddevice/index.php?email=" . $email);

        }
    }

     catch (Exception $e){

        echo "Could not connect to the database, error: " . $e ;
        exit;
    }
       
}
    

?>