<?php

	if(!isset($_SESSION)){
    session_start();
}

	require_once("../../inc/config.php");

	$device = $_POST['device_id'];

	if (isset($device)){

    require(ROOT_PATH . "inc/database.php");

    try {

        $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,DB_USER,DB_PASS);
        $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $db -> exec ("SET NAMES 'utf8'");

    	$sql = "UPDATE tbl_devices SET user_id = NULL , device_status = 'stored' WHERE device_id = :device_id";   
        $q = $db->prepare($sql);
        $q->execute(array(':device_id'=> $device));   

        echo "The device " . $device . " has been removed from the user.";
	 }

     catch (Exception $e){

        echo 'Exception -> ';
    var_dump($e->getMessage());
    exit;
        
    }
           
}

?>