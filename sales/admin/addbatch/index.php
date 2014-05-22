<?php 
require_once("../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

$pageTitle = "Add Batches";
$section = "add_batches";
include(ROOT_PATH . 'inc/header.php'); ?>

<script>
  $(function() {
    $( "#arrived_at" ).datepicker({ dateFormat: 'yy-mm-dd'});

  });
</script>


    <div class="section page">

        <div class="wrapper">

            <h1>Add Batches</h1>

            <?php if (isset($_GET["batch"])) { ?>
                <p align="center" class="message">The batch <?php echo $_GET["batch"]; ?> has been added succesfully</p>
                
            <?php  }?>

            <?php               

            if (!isset($error_message)) {
                echo '<p align="center">Please enter the following info in order to add a batch</p>';
            } else {
                echo '<p class="message">' . $error_message . '</p>';
            }
 
            ?>

            <form method="post" action='<?php echo BASE_URL; ?>admin/addbatch/addbatch.php'>

                <table>
                    <tr>
                        <th>
                            <label for="batch_id">Batch Id</label>
                        </th>
                        <td>
                            <input type="text" name="batch_id" id="batch_id" value="<?php if (isset($user)) { echo htmlspecialchars($user); } ?>"> 
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="batch_provider">Provider</label>
                        </th>
                        <td>
                            <input type="text" name="batch_provider" id="batch_provider">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="arrived_at">Arrived At</label>
                        </th>
                        <td>
                            <input type="text" name="arrived_at" id="arrived_at">
                        </td> 
                    </tr>
                    <tr style="display: none;">
                        <th>
                            <label for="employee">Email</label>
                        </th>
                        <td>
                            <input type="text" name="employee" id="employee">
                            <p>Humans: please leave this field blank.</p>
                        </td>
                    </tr>                   
                </table>
                <input type="submit" value="Add Batch">

            </form>

        </div>

    </div>

<?php include(ROOT_PATH . 'inc/footer.php'); ?>
