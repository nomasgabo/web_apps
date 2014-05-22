<?php 

require_once("../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $batch_id = utf8_encode(trim($_POST["batch_id"]));
    $batch_provider = utf8_encode(trim($_POST["batch_provider"]));
    $arrived_at = utf8_encode(trim($_POST["arrived_at"]));

    if ($batch_id == "" OR $batch_provider == "" OR $arrived_at == "") {
        $error_message = "You must specify a value for batch id, provider and arrival date.";
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
    
    if(verify_batch($batch_id)){
        $error_message = "The batch already exists in the database";
    } 

    if (!isset($error_message)){

        require(ROOT_PATH . "inc/database.php");

        try {

            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,DB_USER,DB_PASS);
            $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $db -> exec ("SET NAMES 'utf8'");

            $sql = "INSERT INTO tbl_batches (batch_id, provider, arrived_at) VALUES (:batch_id, :batch_provider, :arrived_at)";   
            $q = $db->prepare($sql);
            $q->execute(array(':batch_id'=> $batch_id,
                              ':batch_provider'=> $batch_provider,
                              ':arrived_at' => $arrived_at));

            header("Location: " . BASE_URL . "admin/addbatch/?batch=" . $batch_id);
        }

         catch (Exception $e){
    
            echo "Could not connect to the database, error: " . $e ;
            exit;
        }
               
    }
    
}

?>