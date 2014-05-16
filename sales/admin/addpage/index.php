<?php 
require_once("../../inc/config.php");
require_once(ROOT_PATH . "inc/models.php");

$pageTitle = "Add Pages";
$section = "add_pages";
include(ROOT_PATH . 'inc/header.php'); ?>

    <div class="section page">

        <div class="wrapper">

            <h1>Add Pages</h1>

            <?php if (isset($_GET["page"])) { ?>
                <p align="center" class="message">The page <?php echo $_GET["page"]; ?> has been added succesfully</p>
                
            <?php  } //else { ?>

            <?php               

            if (!isset($error_message)) {
                echo '<p align="center">Please enter the following info in order to add a page</p>';
            } else {
                echo '<p class="message">' . $error_message . '</p>';
            }

             $father = get_father_pages(); 

            ?>

            <form method="post" action='<?php echo BASE_URL; ?>admin/addpage/addpage.php'>

                <table>
                    <tr>
                        <th>
                            <label for="page_id">Id</label>
                        </th>
                        <td>
                            <input type="text" name="page_id" id="page_id" value="<?php if (isset($user)) { echo htmlspecialchars($user); } ?>"> 
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="page_name">Name</label>
                        </th>
                        <td>
                            <input type="text" name="page_name" id="page_name">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="path">Path</label>
                        </th>
                        <td>
                            <input type="text" name="path" id="path">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="father_id">Father Id</label>
                        </th>
                        <td>
                            <select name="father_id" id="father_id">
                                <option value=""></option>
                                <?php foreach($father as $option) { ?>
                                <option value="<?php echo $option['page_id']; ?>"><?php echo $option['page_name']; ?> </option>
                                <?php } ?>
                            </select>
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

<?php include(ROOT_PATH . 'inc/footer.php'); ?>
