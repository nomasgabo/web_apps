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

function verify_payment($email) {

    require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT email FROM tbl_merchants WHERE email = ?");
        $results -> bindparam(1,$email);
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

function verify_batch($batch) {

    require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT batch_id FROM tbl_batches WHERE batch_id = ?");
        $results -> bindparam(1,$batch);
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

function get_users_all(){
    require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT user_id, name FROM tbl_users");
        $results -> execute();
        
    } catch(Exception $e){
        echo "Data could not be retrieved  from the database.";
        exit;
    }

    /*while ($row = $results -> fetchAll(PDO::FETCH_ASSOC)){
        $page["page_id"] = $row["page_id"];
        $page["page_name"] = $row["page_name"];
    }*/
    $user = $results -> fetchAll(PDO::FETCH_ASSOC);

    return $user;

}

function get_missing_list($user){
    require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT page_id, page_name FROM tbl_pages WHERE page_id NOT IN (SELECT page_id FROM tbl_permissions WHERE user_id = ?)");
        $results -> bindparam(1,$user);
        $results -> execute();
    } catch(Exception $e){
        echo "Data could not be retrieved  from the database.";
        exit;
    }

    $missing = $results -> fetchAll(PDO::FETCH_ASSOC);

    return $missing;

}

function get_granted_list($user){
    require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT p.page_id, p.page_name FROM tbl_pages p, tbl_permissions pr WHERE p.page_id = pr.page_id AND pr.user_id = ?");
        $results -> bindparam(1,$user);
        $results -> execute();

    } catch(Exception $e){
        echo "Data could not be retrieved  from the database.";
        exit;
    }

    $granted = $results -> fetchAll(PDO::FETCH_ASSOC);

    return $granted;

}

function get_menu_list($user){
    require(ROOT_PATH . "inc/database.php");

    try {
        $results = $db -> prepare("SELECT p.page_id, p.page_name, p.page_path FROM tbl_pages p, tbl_permissions pr WHERE p.page_id = pr.page_id AND pr.user_id = ? AND p.father_id is Null");
        $results -> bindparam(1,$user);
        $results -> execute();
    } catch(Exception $e){
        echo "Data could not be retrieved  from the database.";
        exit;
    }

    $menu = $results -> fetchAll(PDO::FETCH_ASSOC);

    for ($x=0; $x < count($menu); $x++){
        

        try {
            $result = $db -> prepare("SELECT p.page_name, p.page_path FROM tbl_pages p, tbl_permissions pr WHERE p.page_id = pr.page_id AND pr.user_id = ? AND p.father_id = ? ORDER BY p.page_name");
            $result -> bindparam(1,$user);
            $result -> bindparam(2,$menu[$x]['page_id']);
            $result -> execute();
        } catch(Exception $e){
            echo "Data could not be retrieved  from the database.";
            exit;
       }

      $menu[$x]['childs'] = $result -> fetchAll(PDO::FETCH_ASSOC);

    }
      
    return $menu;
}
