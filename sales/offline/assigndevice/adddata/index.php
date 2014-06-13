<?php 
require_once("../../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

$email = $_GET["email"];

if (!isset($email) OR !verify_email_full($email)){

	if (!isset($_GET["err"])){

		header("location: index.php");

	}

}

$pageTitle = "Add Merchant Data";
$section = "adddata";
include(ROOT_PATH . 'inc/header.php'); ?>


    <div class="section page">

        <div class="wrapper">

            <h1>Add Merchant Data</h1>

    		<?php 

		        if (isset( $_GET['err'])) {

		        	if ($_GET['err'] == 'empty') {

		            	echo '<p class="message">You need to enter all the information</p>';

		            } else {

		            	echo '<p class="message">There was a problem with the info you entered</p>';

		            }

		        } 

		        ?>

            <form method="POST" action='<?php echo BASE_URL; ?>/offline/assigndevice/adddata/adddata.php'>

                <table>
                    <tr>
                        <th>
                            <label for="email">Email</label>
                        </th>
                        <td>
                            <input type="text" name="email" id="email" value="<?php echo $email; ?>" readonly> 
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="company">Company</label>
                        </th>
                        <td>
                            <input type="text" name="company" id="company">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="first">First Name</label>
                        </th>
                        <td>
                            <input type="text" name="first" id="first">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="last">Last Name</label>
                        </th>
                        <td>
                            <input type="text" name="last" id="last">
                        </td> 
                    </tr>
                    <tr>
                        <th>
                            <label for="last">Phone</label>
                        </th>
                        <td>
                            <input type="text" name="phone" id="phone">
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
                <input type="submit" value="Add Merchant">

            </form>

        </div>

    </div>

<?php include(ROOT_PATH . 'inc/footer.php'); ?>
