<?php 

require_once("../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

$pageTitle = "Enable user access";
$section = "add_permissions";
include(ROOT_PATH . 'inc/header.php'); ?>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/datatables.css" type="text/css">

<!--  <link rel="stylesheet" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css"> -->


<div class="section page">

    <div class="wrapper">  	

    	<h1>Assign Devices</h1>

		<form id="users" method="post" action="show_devices.php" onsubmit="return false">

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

                <tr>
                    <th>
                        <label for="device_id">Device Id</label>
                    </th>
                    <td>
                        <input type="text" name="device_id" id="device_id" value="<?php if (isset($user)) { echo htmlspecialchars($user); } ?>"> 
                    </td>
                </tr>
                                                     
            </table>

		</form>


		<?php 

	    if (isset($_GET["user_id"])) { 
	        
	        $devices = get_device_list($_GET['user_id']); ?>

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

<?php if(isset($_GET['user_id'])) { 
	echo '$("#select_users").val("' . $_GET['user_id'] . '")';
} else {
	echo '$(document).ready(function(){';
    echo '$("form#users").submit();'; 
	echo '});';
} ?>
  	
</script>



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

	//oTable.$('tr').click( function () {
    //var sData = oTable.fnGetData( this,0 );
    //alert( 'The cell clicked on had the value of '+sData );
    //});	

    $('#tb_example tbody tr td:last-child').click( function () {
    //var sData = oTable.fnGetData( this,0 );
    //alert( 'The cell clicked on had the value of '+sData );
    //sData = $(this).closest('tr').children('td:first').text();
    
    var device = $(this).closest('tr').children('td:first').text(); 
	
	$.post('free_device.php',{'device_id': device}).done(function(data){
	    alert(data);
	    location.reload();
	});



    });

  });

$("#device_id").change(function() {

	var device = $("#device_id").val(); 
	var user = $("#select_users").val();

	$.post('assign_device.php',{'user_id': user, 'device_id': device}).done(function(data){
	    alert(data);
	    location.reload();
	});


});
  	
</script>

<?php include(ROOT_PATH . 'inc/footer.php') ?>