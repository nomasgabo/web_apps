<html>
<head>
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css" type="text/css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700" type="text/css">

</head>
<body>
	<div class="header">

		<div class="wrapper">

			<h1 class="branding-title"><a href="<?php echo BASE_URL; ?>">Sistema de logística</a></h1>

			<ul class="nav">
				<li>
					<?php if ($section != "sign_in") { echo '<a href=' . BASE_URL . 'logout.php>Logout</a>';} ?>
				</li> 
			</ul>

		</div>

	</div>

	<div id="content">