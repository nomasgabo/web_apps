<?php

	$user = $_POST['user'];
	header("Location: index.php?user_id=" . $user);

?>