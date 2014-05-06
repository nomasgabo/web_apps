<?php

function verify_user($user) {

	require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT user_id FROM tbl_users WHERE user_id = ?");
        $results -> bindparam(1,$user);
        $results -> execute();
    } catch(Exception $e){
        echo "Data could not be retrieved  from the database.";
        exit;
    }

    $exist = $results -> fetch(PDO::FETCH_ASSOC);

    if($exist === false) {

    	return false;

    } else {

    	return true; 
    	
    }
        
}

function sign_in($user, $password) {

    require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT user_id, password FROM tbl_users WHERE user_id = ?");
        $results -> bindparam(1,$user);
        $results -> execute();
    } catch(Exception $e){
        echo "Data could not be retrieved  from the database.";
        exit;
    }

    $login = $results -> fetch(PDO::FETCH_ASSOC);

    if($login === false) {

        return false;

    } else {

        return $login["password"]; 
        
    }
        
}