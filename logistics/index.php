<?php 

session_start();

require_once("inc/config.php");

if ($_SESSION['logged_in'] == 'y'){
	
	header("Location: " . BASE_URL . "adduser/");
    
}




$pageTitle = "Sign In";
$section = "sign_in";

include(ROOT_PATH . 'inc/header.php'); 

?>

<div class="section page">

    <div class="wrapper">

        <h1>Sign In</h1>

        <?php 

        if (isset( $_GET['err'])) {

        	if($_GET['err'] == 'auth') { 
            
            	echo '<p class="message">The user or password you entered is not correct</p>';

            } elseif ($_GET['err'] == 'empty') {

            	echo '<p class="message">You need to enter a valid user and password</p>';

            } else {

            	echo '<p class="message">There was a problem with the info you entered</p>';

            }

        } else {

            echo '<p align="center">Please enter your user and password to log in</p>';

        }

        ?>

            <form method="post" action='<?php echo BASE_URL . "check_login.php"?>'>

                <table>
                    <tr>
                        <th>
                            <label for="name">User</label>
                        </th>
                        <td>
                            <input type="text" name="user" id="user" value="<?php if (isset($user)) { echo htmlspecialchars($user); } ?>"> 
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="password">Password</label>
                        </th>
                        <td>
                            <input type="password" name="password" id="password">
                        </td>
                    </tr>                   
                </table>
                <input type="submit" value="Sign In">

            </form>	

    </div>

</div>

<?php include(ROOT_PATH . 'inc/footer.php'); ?>
