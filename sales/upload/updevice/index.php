<?php

require_once('../../inc/config.php');
require_once('../../inc/database.php');

$pageTitle = "Upload Merchant File";
$section = "up_merchants";
include(ROOT_PATH . 'inc/header.php'); 

  if (isset($_GET['filename'])) {

    ini_set("auto_detect_line_endings", true);
    function readCSV($csvFile){
           $data = fopen($csvFile, 'r');
           while (!feof($data) ) {
                   $line_of_text[] = fgetcsv($data, 1024);
           }
           fclose($data);
           return $line_of_text;
    }

    $csvFile = "../uploads/devices/" . $_GET['filename'];

    $csv = readCSV($csvFile);

    $db->beginTransaction();

    $sql = $db->prepare('INSERT IGNORE INTO tbl_devices(device_id, device_model, device_firmware, device_status, batch_id) VALUES(:a, :b, :c, :d, :e)');

    foreach ($csv as $insert_row)
    {
      $sql->bindValue(':a', $insert_row[0]);
      $sql->bindValue(':b', $insert_row[1]);
      $sql->bindValue(':c', $insert_row[2]);
      $sql->bindValue(':d', $insert_row[3]);
      $sql->bindValue(':e', $insert_row[4]);

      $sql->execute();
    }


    $db->commit();

    $success = true;

  }

  

?>



<div class="section page">

    <div class="wrapperpage"> 

      <h1 class="h1pages">Upload Devices's File</h1>

      <?php 

        if($success === true){


          echo "<p align=\"center\" class=\"message\">The file has been succesfully loaded</p>";
        }

      ?>

      <form id="merchants" method="post" enctype="multipart/form-data" action="../../inc/php_uploader.php">

        <table>
          <tr>
            
              <td>
                  <input id="uploadFile" placeholder="Choose File" disabled="disabled" class="uploadInput" />
                  <div class="fileUpload btn btn-primary">
                      <span>Upload</span>
                      <input id="uploadBtn" type="file" class="upload" name="file" />
                      <input type="hidden" name="uploadpath" value="devices/" />
                      <input type="hidden" name="path" value="upload/updevice/index.php?filename=">
                  </div>
              </td>
          </tr>
            
        </table>
                                                       
        <input type="submit" value="Process" />

      </form>

      <script>

        document.getElementById("uploadBtn").onchange = function () {
          document.getElementById("uploadFile").value = this.value;
        };

      </script>

  </div>

</div>

<?php include(ROOT_PATH . 'inc/footer.php'); ?>
