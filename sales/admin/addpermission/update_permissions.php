<?php

	if(!isset($_SESSION)){
    session_start();
}

	require_once("../../inc/config.php");

	$page = $_POST['page_id'];
	$user = $_POST['user_id'];
	$type = $_POST['type'];
	$creator = $_SESSION['user'];

	if (isset($page) && isset($user) && isset($type)){

    require(ROOT_PATH . "inc/database.php");

    try {

        $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,DB_USER,DB_PASS);
        $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $db -> exec ("SET NAMES 'utf8'");

        if ($type == "add"){

        	$sql = "INSERT INTO tbl_permissions (user_id, page_id, created_at, created_by) VALUES (:user_id,:page_id,:created_at,:created_by)";   
	        $q = $db->prepare($sql);
	        $q->execute(array(':user_id'=> $user,
	                          ':page_id'=> $page,
	                          ':created_at' => date("Y-m-d H:i:s"),
	                          ':created_by' => $creator));

	        echo "The user " . $user . " has been granted with the following access: " . $page;

	    } elseif ($type == "remove") {

	    	$sql = "DELETE FROM tbl_permissions WHERE user_id = :user_id and :page_id = page_id";
	        $q = $db->prepare($sql);
	        $q->execute(array(':user_id'=> $user,
	                          ':page_id'=> $page));

	        echo "The access to " . $page . " has been removed for " . $user;

	    }

	    
	 }

     catch (Exception $e){

        echo "There was an error processing your request";
        

    }
           
}

?>