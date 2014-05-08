<?php 

require_once("../inc/config.php");
require_once("../inc/models.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $page_id = utf8_encode(trim($_POST["page_id"]));
    $page_name = utf8_encode(trim($_POST["page_name"]));
    $path = utf8_encode(trim($_POST["path"]));
    $father_id = utf8_encode(trim($_POST["father_id"]));

    if ($page_id == "" OR $page_name == "" OR $path == "") {
        $error_message = "You must specify a value for page id, name and path.";
    }

    if(!isset($error_message)) {
        foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $error_message = "There was a problem with the information you entered.";    
            }
        }
    }

    if(!isset($error_message) && $_POST["employee"] != "") {
        $error_message = "Your form submission has an error.";
    }
    
    if(verify_page($page_id)){
        $error_message = "The page already exists in the database";
    } 

    if (!isset($error_message)){

        require(ROOT_PATH . "inc/database.php");

        try {

            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,DB_USER,DB_PASS);
            $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $db -> exec ("SET NAMES 'utf8'");

            $sql = "INSERT INTO tbl_pages (page_id,page_name,page_path,father_id) VALUES (:page_id,:page_name,:path, :father_id)";   
            $q = $db->prepare($sql);
            $q->execute(array(':page_id'=> $page_id,
                              ':page_name'=> $page_name,
                              ':path' => $path,
                              ':father_id' => $father_id));

            header("Location: " . BASE_URL . "addpage/?page=" . $page_name);
        }

         catch (Exception $e){
    
            echo "Could not connect to the database, error: " . $e ;
            exit;
        }
               
    }
    
}

?>