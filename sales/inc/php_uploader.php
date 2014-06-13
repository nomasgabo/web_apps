<?php
require_once("config.php");

if (($_FILES["file"]["type"] == "text/csv") && ($_FILES["file"]["size"] < 2000000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  if (file_exists(ROOT_PATH . "upload/uploads/" . $_POST["uploadpath"] . "PayPal" . date("Y-m-d H:i:s")))
    {
    echo $_FILES["file"]["name"] . " already exists. ";
    }
  else
    {
     $pathupload = ROOT_PATH . "upload/uploads/" . $_POST["uploadpath"] . "PayPal " . date("Y-m-d H:i:s");

     move_uploaded_file($_FILES["file"]["tmp_name"], $pathupload);
     header ("location: " . BASE_URL . $_POST["path"] . $_FILES["file"]["name"]);
     exit;
    }
  }
else
  {
  echo "Invalid File!";
  }
?> 