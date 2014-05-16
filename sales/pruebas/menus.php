<?php 

session_start();

require_once("../inc/config.php");
require_once("../inc/models.php");

  $menu = get_menu_list($_SESSION['user']);

?>

<html>
  <head>
    <!-- Load jQuery from Google's CDN -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <!-- Source our javascript file with the jQUERY code -->
    <script src="script.js"></script>
    <link rel="stylesheet" href="runnable.css" />
  </head>
  <body>
    <!-- Use this navigation div as your menu bar div -->

    <div class="navigation">

  		<ul class="nav">
  			
        <?php 

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
          
          ?>		
  			
  		</ul>
  	</div>
  </body>

  <script>

  $(document).ready(
  /* This is the function that will get executed after the DOM is fully loaded */
	  function () {
	    /* Next part of code handles hovering effect and submenu appearing */
	    $('.nav li').hover(
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
</html>