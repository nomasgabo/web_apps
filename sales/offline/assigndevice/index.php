<?php
require_once("../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

$pageTitle = "Enable user access";
$section = "add_permissions";
include(ROOT_PATH . 'inc/header.php');

?>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/datatables.css" type="text/css">

<!--  <link rel="stylesheet" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css"> -->



<div class="section page">

    <div class="wrapper">  	

    	<h1>Assign Devices</h1>

		<form id="users" method="post">

			<table>
                
                <tr>
                    <th>
                        <label for="email">E-mail</label>
                    </th>
                    <td>
                        <input type="text" name="email" id="email" value="<?php if (isset($user)) { echo htmlspecialchars($user); } ?>"> 
                    </td>
                </tr>

            </table>

		</form>
		
	</div>

	<div id="hidden-code" class="wrapper" style="display:none">  	

  		<form id="code" method="POST" action="adddevice.php">

  		<table>
                
            <tr>
                <th>
                    <label for="code">Code</label>
                </th>
                <td>
                    <input type="text" name="code" id="code"> 
                </td>
            </tr>

        </table>
  	
        <input type="submit" value="Verify Code" >

  		</form>

  	</div>

  	<div class ="wrapper">

  		<form onsubmit="return false">

  			<input id="confirm" type="submit" value="Confirm Email" >

  		</form>

  	</div>

  	

  	<!-- <div id="hidden-code1" class ="wrapper" style="display:none">

  		<form method="POST" action="adddevice.php">

  			<input type="submit" value="Verify Code" >

  		</form>

  	</div> -->

</div>

<script type="text/javascript">

$("#confirm").click(function() {
	
	var user = "<?php echo $_SESSION['user']; ?>";

	$.post('sendemailcode.php',{'email': $("#email").val(), 'user': user}).done(function(data){
	    
      if (data === "This email has been already confirmed"){

          window.location.replace("adddevice.php?email="+$("#email").val());
          return;

      }


	    if (data !== "This email has already been taken"){

    	    alert(data);

      	  $("#hidden-code").show("slow");
      		$("#hidden-code1").show("slow");
      		$("#confirm").hide();

		}
	});
});

</script>

<?php include(ROOT_PATH . 'inc/footer.php') ?>