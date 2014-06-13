<?php 

require_once("../../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

$pageTitle = "Deliver Device";
$section = "deliver_device";
include(ROOT_PATH . 'inc/header.php'); ?>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/datatables.css" type="text/css">

<!--  <link rel="stylesheet" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css"> -->


<div class="section page">

    <div class="wrapper">  	

    	<h1>Deliver Device(s)</h1>

		<form id="users" method="post" action="show_devices.php" onsubmit="return false">

			<table>
                
				<tr>
                    <th>
                        <label for="email">Email</label>
                    </th>
                    <td>
                        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($_GET["email"]);?>" readonly> 
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="user">User</label>
                    </th>
                    <td>
                        
							<?php $devices = get_devices_by_user($_SESSION["user"]); ?>

							<select name="user" id="select_users" onchange="this.form.submit()">
					            <?php foreach($devices as $device) { ?>
					            <option value="<?php echo $device['device_id']; ?>"><?php echo $device['device_id']; ?> </option>
					            <?php } ?>
					        </select>

						</select>
                    </td>
                </tr>
                                        
            </table>

            <input type="submit" value="Assign Device">

		</form>

		<br>

		<?php 

	    if (isset($_GET["email"])) { 
	        
	        $devices = get_devicem_list($_GET['email']); ?>

	        <table id="tb_example" class="display" width="600px">
	            <thead>
	                <tr>
	                    <th>Device Id</th>
	                    <th>Model</th>
	                    <th>Firmware</th>
	                    <th>-</th>
	                    
	                </tr>
	            </thead>
	            <tbody>

	    		<?php    

	            foreach($devices as $row) { ?>
	                <tr>
	                    <td><?php echo $row['device_id']; ?></td>
	                    <td><?php echo $row['device_model']; ?></td>
	                    <td><?php echo $row['device_firmware']; ?></td>
	                    <td><a style="color:red; text-decoration:none; text-align:center">x</a>
	                    
	                </tr>
	    		<?php 
	            } 

	    		?>

	            </tbody>
	        </table>

	    <?php

	        }
	    
	    ?>


  	</div>

</div>




<script type="text/javascript">

$(document).ready(function() {
   
	$("#device_id").focus()

    oTable = $('#tb_example').dataTable(
    {
    	"sAutoWidth": false,
    	"aoColumnDefs": 
    	[ 
			{ 
			
             "targets": [0,1,2],
             "sWidth": "30%",
         	
          	},
          	{ 
			
             "targets": [3],
             "sWidth": "10%",
             "bSortable": false
         	
          	}
 
        ],
        "scrollCollapse": true,
        "paging":         false,
        "searching": false,
        "bInfo": false     
    	
	});	
	

    $('#tb_example tbody tr td:last-child').click( function () {
    
    var device = $(this).closest('tr').children('td:first').text(); 
	
	$.post('free_devicem.php',{'device_id': device}).done(function(data){
	    alert(data);
	    location.reload();
	});



    });

  });

$("#device_id").change(function() {

	var device = $("#device_id").val(); 
	var email = $("#email").val();

	$.post('assign_devicem.php',{'email': email, 'device_id': device}).done(function(data){
	    alert(data);
	    location.reload();
	});


});
  	
</script>

<?php include(ROOT_PATH . 'inc/footer.php') ?>