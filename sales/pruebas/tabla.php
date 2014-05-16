<?php 

session_start();
require_once("../inc/config.php");
require_once("../inc/models.php");

$pageTitle = "Add Pages";
$section = "add_pages";
include(ROOT_PATH . 'inc/header.php'); ?>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

<html>
<body>

    <div class="section page">
    
        <div class="wrapper">


    <?php

        $users = get_users_all();
       
    ?>
    <form action="" method="post">
        <select name="user_id" id="user_id" onchange='get_permissions(this.value)'>
            <option value=""></option>
            <?php foreach($users as $option) { ?>
            <option value="<?php echo $option['user_id']; ?>"><?php echo $option['name']; ?> </option>
            <?php } ?>
        </select>
    </form>

    <?php 

    if (isset($_GET["user_id"])) { 
        
        $permissions = get_user_permissions($_GET['user_id']); ?>

        <table id="table_id" class="display" width="30%">
            <thead>
                <tr>
                    <th></th>
                    <th>Page Name</th>
                </tr>
            </thead>
            <tbody>

    <?php    

            foreach($permissions as $row) { ?>
                <tr>
                    <td><?php echo $row['page_id']; ?></td>
                    <td><?php echo $row['page_name']; ?></td>
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

</body>

</html>

<script type="text/javascript">



function get_permissions(value){

    var sData = value;
    alert (value);

    $.post("tblpermisos.php", {'user_id': sData});

}


$("#user_id").change(function() {    

  oTable = $('#table_id').dataTable(
  {
        
        "aoColumnDefs": [ { 
            targets: [ 0 ],
            orderData: [ 0, 1 ],
            "bVisible": false
            },{
            targets: [-1],
            bSortable: false}],
        "scrollCollapse": true,
        "paging":         false,
        "searching": false,
        "bInfo": false,
        }
    
    );
    
    oTable.$('tr').click( function () {
    var sData = oTable.fnGetData( this,0 );
    alert( 'The cell clicked on had the value of '+sData );

    $.post("ajax.php", {'action': sData});

  } );
} );

</script>

<script>

        


</script>


<?php include(ROOT_PATH . 'inc/footer.php') ?>
