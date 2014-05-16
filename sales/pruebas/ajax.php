<?php 

include("../inc/config.php");

if (isset($_POST['action'])){

        require(ROOT_PATH . "inc/database.php");

        try {

            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,DB_USER,DB_PASS);
            $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $db -> exec ("SET NAMES 'utf8'");

            $sql = "INSERT INTO tbl_pages (page_id,page_name,page_path,father_id) VALUES (:page_id,:page_name,:path, :father_id)";   
            $q = $db->prepare($sql);
            $q->execute(array(':page_id'=> "manu",
                              ':page_name'=> $_POST['action'],
                              ':path' => "/delpage/index.php",
                              ':father_id' => ""));

        }

         catch (Exception $e){
    
            echo "Could not connect to the database, error: " . $e ;
            exit;

        }
               
    }

 ?>