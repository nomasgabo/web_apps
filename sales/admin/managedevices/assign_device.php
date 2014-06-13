<?php

	if(!isset($_SESSION)){
    session_start();
}

	require_once("../../inc/config.php");
    require_once(ROOT_PATH . "inc/models.php");

	$user = $_POST['user_id'];
	$device = $_POST['device_id'];


	if (isset($user) && isset($device)){

    require(ROOT_PATH . "inc/database.php");

    if (verify_device($device) === "assigned"){

        echo "The device " . $device . " is already assigned and it can't be assigned again";
        exit;

    } else {

        try {

            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,DB_USER,DB_PASS);
            $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $db -> exec ("SET NAMES 'utf8'");

        	$sql = "UPDATE tbl_devices SET user_id = :user_id, device_status = 'assigned' WHERE device_id = :device_id";   
            $q = $db->prepare($sql);
            $q->execute(array(':user_id'=> $user,
                              ':device_id'=> $device));   

            echo "The device " . $device . " has been assigned to the user " . $user;
    	 }

         catch (Exception $e){

            echo 'Exception -> ';
            var_dump($e->getMessage());
            
        }

    }
           
}

?>