<?php
require_once("../../inc/config.php");

if (($_FILES["file"]["type"] == "text/csv") && ($_FILES["file"]["size"] < 200000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  if (file_exists("uploads/" . $_FILES["file"]["name"]))
    {
    echo $_FILES["file"]["name"] . " already exists. ";
    }
  else
    {
     
     move_uploaded_file($_FILES["file"]["tmp_name"], "../uploads/" . $_FILES["file"]["name"]);
     header ("location: " . BASE_URL .  "upload/upmerchant/index.php?filename=" . $_FILES["file"]["name"]);
	 exit;
    }
  }
else
  {
  echo "Invalid File!";
  }
?> 