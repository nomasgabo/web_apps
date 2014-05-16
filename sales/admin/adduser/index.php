<?php 

require_once("../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

$pageTitle = "Add Users";
$section = "add_users";
include(ROOT_PATH . 'inc/header.php'); ?>

    <div class="section page">

        <div class="wrapper">

            <h1>Add Users</h1>

            <?php if (isset($_GET["user"])) { ?>
                <p align="center" class="message">The user <?php echo $_GET["user"]; ?> has been added succesfully</p>
            <?php } //else { ?>

                <?php               

                if (!isset($error_message)) {
                    echo '<p align="center">Please enter the following info in order to add a user</p>';
                } else {
                    echo '<p class="message">' . $error_message . '</p>';
                }

                ?>

                <form method="post" action='<?php echo BASE_URL; ?>/admin/adduser/adduser.php'>

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
                        <tr>
                            <th>
                                <label for="confirm">Confirm Password</label>
                            </th>
                            <td>
                                <input type="password" name="confirm" id="confirm">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="name">Name</label>
                            </th>
                            <td>
                                <input type="text" name="name" id="name" value="<?php if (isset($name)) { echo htmlspecialchars($name); } ?>">
                            </td>
                        </tr> 
                        <tr>
                            <th>
                                <label for="email">Email</label>
                            </th>
                            <td>
                                <input type="text" name="email" id="email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
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
                    <input type="submit" value="Add">

                </form>

            <?php //} ?>

        </div>

    </div>

<?php include(ROOT_PATH . 'inc/footer.php') ?>

