<?php
//Log out

session_start();

require_once("inc/config.php");

//Kill all the the session variables.
$_SESSION = array();

//Kill the session itself.
session_destroy();

//Back to the log in page.
header("Location:" . BASE_URL . "index.php");

exit();
?>