<?php 

if(!isset($_SESSION)){
    session_start();
}

require_once('config.php');
require_once('models.php');;

$menu = get_menu_list($_SESSION['user']);

?>
<html>
<head>
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css" type="text/css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700" type="text/css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
<body>
	 <div class="header">

		<div class="wrapper">

			<h1 class="branding-title"><a href="<?php echo BASE_URL; ?>">Sistema de logística</a></h1>

			<ul class="navi">
				 
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
			      }

			        ?>
			</ul>

		</div>

	</div>

	<script>

	 $(document).ready(
	  function () {
	    $('.navi li').hover(
	      function () { //appearing on hover
	        $('ul', this).fadeIn();
	      },
	      function () { //disappearing on hover
	        $('ul', this).fadeOut();
	      }
	    );
	  }
	);

  </script>

  <div id="content">