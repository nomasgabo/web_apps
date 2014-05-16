<?php session_start();

require_once("../inc/config.php");
require_once("../inc/models.php");

$menu = get_menu_list($_SESSION['user']);

?>


?>

<html>
<head>
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css" type="text/css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700" type="text/css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="runnable.css" />

</head>
<body>
	<div class="header">

		<div class="wrapper">

			<h1 class="branding-title"><a href="<?php echo BASE_URL; ?>">Sistema de logística</a></h1>

			<ul class="nav">
				
				<!-- <li><?php if ($section != "sign_in") { echo "Hi " . $_SESSION['user'] . " !"; } ?></li> -->
				 
				<?php 

					if ($section != "sign_in") { 					

			        foreach ($menu as $menuitem){

			          echo "<li>";
			          echo "<a href=" . $menuitem['page_path'] . ">" . $menuitem['page_name'] . "</a>";

			          if (!empty($menuitem['childs'])){

			            echo "<ul>";

			            foreach ($menuitem['childs'] as $menuchild){

			              echo   "<li><a href=" . $menuchild['page_path'] . ">" . $menuchild['page_name'] . "</a></li>";

			            }

			            echo "</ul>";

			          }  

			          echo "</li>"; 

			        }
			        
			        echo "<li><a href=" . BASE_URL . "login/logout.php>Logout</a></li>";

			        ?>
			</ul>

		</div>

	</div>

	<div id="content">