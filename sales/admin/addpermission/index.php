<?php 

require_once("../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

$pageTitle = "Enable user access";
$section = "add_permissions";
include(ROOT_PATH . 'inc/header.php'); ?>


	
 <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"> -->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>

 $(function(){
	    $( "#sortable1" ).sortable({
	        connectWith: ".connectedSortable",
	        cancel: ".disabledItem",
	        items: "li:not(.disabledItem)",
	        receive: function(event,ui){
	        	var page = ui.item.attr('value'); 
	        	var user = $("#select_users").val();
	        	var type = "remove";
	   
	    		$.post('update_permissions.php',{'page_id': page, 'user_id': user, 'type': type}).done(function(data){
	    			alert(data);
	    		});
	    			
	        }
	    }).disableSelection();

	    $( "#sortable2" ).sortable({
	        connectWith: ".connectedSortable",  // deactivate:myFunc
	        cancel: ".disabledItem",
	        items: "li:not(.disabledItem)",
	        receive: function(event,ui){
	        	var type = "add"
	        	var page = ui.item.attr('value'); 
	        	var user = $("#select_users").val();

	    		$.post('update_permissions.php',{'page_id': page, 'user_id': user, 'type': type}).done(function( data){
	    			alert(data);
	    		});
	    			
	        }
	    }).disableSelection();

	});

</script>

<div class="section page">

    <div class="wrapper">  	

    <h1>Manage Permissions</h1>

		<form id="users" method="post" action="show_permissions.php">

			<table>
                <tr>
                    <th>
                        <label for="user">User</label>
                    </th>
                    <td>
                        
							<?php $users = get_users_all(); ?>

							<select name="user" id="select_users" onchange="this.form.submit()">
					            <?php foreach($users as $option) { ?>
					            <option value="<?php echo $option['user_id']; ?>"><?php echo $option['name']; ?> </option>
					            <?php } ?>
					        </select>

						</select>
                    </td>
                </tr>
                                                     
            </table>

		</form>

		<div class="wrapperpermisos">

		<?php

		if (isset($_GET['user_id'])){

			
			$asignados = get_granted_list($_GET['user_id']);
			$no_asignados = get_missing_list($_GET['user_id']);

			echo "<div class=\"permisos\">";
			echo "<ul data-header=\"heading\" id=\"sortable1\" class=\"connectedSortable\">";
			echo "<li class=\"disabledItem\" value=\"Asignados\">No Asignados</li>";   
			
			foreach($no_asignados as $missing){

				echo "<li class=\"ui-state-default\" value=\"" . $missing['page_id'] . "\">" . $missing['page_name'] . "</li>";
			
			}
			
			echo "</ul>";
			echo "</div>";

			echo "<div class=\"permisosderecha\">";
			echo "<ul id=\"sortable2\" class=\"connectedSortable\">";
			echo "		<li class=\"disabledItem\" value=\"Por Asignar\">Asignados</li>";   

			foreach($asignados as $granted){

				echo "<li class=\"ui-state-default\" value=\"" . $granted['page_id'] . "\">" . $granted['page_name'] . "</li>";
			
			}

			echo "</ul>";
			echo "</div>";

		}
		?>
		</div>

  	</div>

</div>

<script type="text/javascript">

<?php if(isset($_GET['user_id'])) { 
	echo '$("#select_users").val("' . $_GET['user_id'] . '")';
} else {
	echo '$(document).ready(function(){';
    echo '$("form#users").submit();'; 
	echo '});';
} ?>
  	
</script>

<?php include(ROOT_PATH . 'inc/footer.php') ?>