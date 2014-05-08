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

function verify_page($page) {

    require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT page_id FROM tbl_pages WHERE page_id = ?");
        $results -> bindparam(1,$page);
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

function get_father_pages(){
    require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT page_id, page_name FROM tbl_pages");
        $results -> execute();
    } catch(Exception $e){
        echo "Data could not be retrieved  from the database.";
        exit;
    }

    /*while ($row = $results -> fetchAll(PDO::FETCH_ASSOC)){
        $page["page_id"] = $row["page_id"];
        $page["page_name"] = $row["page_name"];
    }*/
    $page = $results -> fetchAll(PDO::FETCH_ASSOC);

    return $page;

}
