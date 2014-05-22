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

    $csvFile = "../uploads/payments/" . $_GET['filename'];

    $csv = readCSV($csvFile);

    foreach ($csv as $insert_row)
    {
      
      if (verify_payment($insert_row[10]))

      {

        $db->beginTransaction();

        $sql = $db->prepare('INSERT IGNORE INTO tbl_payments(payment_id, merchant_email, payment_email, payment_type, payment_date, amount, payment_status, found) VALUES(:a, :b, :c, :d, :e, :f, :g, :h)');

        $sql->bindValue(':a', $insert_row[12]);
        $sql->bindValue(':b', $insert_row[10]);
        $sql->bindValue(':c', $insert_row[10]);
        $sql->bindValue(':d', "PayPal");
        $sql->bindValue(':e', $insert_row[0]);
        $sql->bindValue(':f', $insert_row[7]);
        $sql->bindValue(':g', "Ready");
        $sql->bindValue(':h', 1);

        $sql->execute();
    
        $db->commit();
                
      } else {

        $db->beginTransaction();

        $sql = $db->prepare('INSERT IGNORE INTO tbl_payments(payment_id, merchant_email, payment_email, payment_type, payment_date, amount, payment_status, found) VALUES(:a, :b, :c, :d, :e, :f, :g, :h)');

        $sql->bindValue(':a', $insert_row[12]);
        $sql->bindValue(':b', "");
        $sql->bindValue(':c', $insert_row[10]);
        $sql->bindValue(':d', "PayPal");
        $sql->bindValue(':e', $insert_row[0]);
        $sql->bindValue(':f', $insert_row[7]);
        $sql->bindValue(':g', "Ready");
        $sql->bindValue(':h', 0);

        $sql->execute();
    
        if($db->commit() == true)

        {
        
                  

          try {

                $email_body = "";

                $email_body = $email_body . "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";
                $email_body = $email_body . "<html>";
                $email_body = $email_body . "<head>";
                $email_body = $email_body . "<META http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
                $email_body = $email_body . "</head>";
                $email_body = $email_body . "<body>";
                $email_body = $email_body . "<div>";
                $email_body = $email_body . "<table width=\"800\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;font-size:13px\">";
                $email_body = $email_body . "  <tr style=\"background:#ededed\">";
                $email_body = $email_body . "    <td width=\"52\" height=\"80\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400\"> </td>";
                $email_body = $email_body . "    <td valign=\"middle\" align=\"right\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;font-size:14px\">“Sólo es digno de libertad quien sabe conquistarla cada día”<br>";
                $email_body = $email_body . "    GOETHE </td>";
                $email_body = $email_body . "    <td width=\"52\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400\"> </td>";
                $email_body = $email_body . "  </tr>";
                $email_body = $email_body . "  <tr>";
                $email_body = $email_body . "    <td colspan=\"3\" valign=\"top\"><img src=\"http://www.e-deweb.com/clip/N/images/triangulo.png\" alt=\"\" width=\"158\" height=\"91\"></td>";
                $email_body = $email_body . "  </tr>";
                $email_body = $email_body . "  <tr>";
                $email_body = $email_body . "    <td valign=\"top\" width=\"52\"> </td>";
                $email_body = $email_body . "    <td valign=\"top\" width=\"712\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                $email_body = $email_body . "      <tr>";
                $email_body = $email_body . "        <td colspan=\"3\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:300;padding-top:15px\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                $email_body = $email_body . "          <tr>";
                $email_body = $email_body . "            <td width=\"80%\"><span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:300;font-size:48px;line-height:53px\">¡Felicidades!</span><br>";
                $email_body = $email_body . "              <span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:300;font-size:30px;line-height:40px\">Hemos recibido tu pago</span></td>";
                $email_body = $email_body . "             <td align=\"right\" valign=\"top\"><img src=\"http://www.e-deweb.com/clip/N/images/logo.png\" alt=\"\" width=\"84\" height=\"84\"></td>";
                $email_body = $email_body . "          </tr>";
                $email_body = $email_body . "        </table></td>";
                $email_body = $email_body . "        </tr>";
                $email_body = $email_body . "      <tr>";
                $email_body = $email_body . "        <td colspan=\"3\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ff4c00;font-size:14px;font-weight:300;padding-top:14px\">";
                $email_body = $email_body . "        <span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;font-size:14px\">Hola (NAME)<br><br>";
                $email_body = $email_body . "          Te informamos que recibimos tu pago a través de paypal, sin embargo no hemos podido<br>";
                $email_body = $email_body . "          identificar la cuenta con la que te registraste en nuestro sistema.<br><br>";
                $email_body = $email_body . "          Te pedimos te comuniques con nosotros para verificar tus datos y enviar tu Clip<br>";
                $email_body = $email_body . "          lo más pronto posible.</span></td>";
                $email_body = $email_body . "        </tr>";
                $email_body = $email_body . "      <tr>";
                $email_body = $email_body . "        <td colspan=\"3\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ff4c00;font-size:14px;font-weight:300;padding-top:14px\">";
                $email_body = $email_body . "        <span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;font-size:14px\">______________________________________________<br><br></span></td>";
                $email_body = $email_body . "      </tr>";
                $email_body = $email_body . "      <tr>";
                $email_body = $email_body . "        <td colspan=\"2\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-size:12px\">";
                $email_body = $email_body . "          <p style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-size:12px\">Si tienes más preguntas o quieres recibir asistencia personalizada:</p></td>";
                $email_body = $email_body . "        </tr>";
                $email_body = $email_body . "      <tr>";
                $email_body = $email_body . "        <td colspan=\"2\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-size:12px\">";
                $email_body = $email_body . "        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                $email_body = $email_body . "          <tr>";
                $email_body = $email_body . "            <td align=\"left\" valign=\"bottom\" style=\"padding-top:10px;padding-bottom:10px\"><img src=\"http://www.e-deweb.com/clip/N/images/7.png\" style=\"margin-left:10px\"></td>";
                $email_body = $email_body . "            <td align=\"left\" valign=\"bottom\" style=\"padding-top:10px;padding-bottom:10px\"><img src=\"http://www.e-deweb.com/clip/N/images/8.png\" style=\"margin-left:40px\"></td>";
                $email_body = $email_body . "            <td align=\"left\" valign=\"bottom\" style=\"padding-top:10px;padding-bottom:10px\"><img src=\"http://www.e-deweb.com/clip/N/images/9.png\" style=\"margin-left:50px\"></td>";
                $email_body = $email_body . "            <td align=\"left\" valign=\"bottom\" style=\"padding-top:10px;padding-bottom:10px\"><img src=\"http://www.e-deweb.com/clip/N/images/10.png\"></td>";
                $email_body = $email_body . "          </tr>";
                $email_body = $email_body . "          <tr>";
                $email_body = $email_body . "            <td width=\"27%\" valign=\"top\">Consulta la sección de <br>";
                $email_body = $email_body . "              preguntas <strong style=\"color:#ff4c00\">frecuentes</strong>.</td>";
                $email_body = $email_body . "            <td width=\"25%\" valign=\"top\">Contáctanos a través <br>";
                $email_body = $email_body . "              de la página de <strong style=\"color:#ff4c00\"><a href=\"https://www.facebook.com/clipmx\" style=\"color:#ff4c00;text-decoration:none\" target=\"_blank\">Facebook</a></strong></td>";
                $email_body = $email_body . "            <td width=\"31%\" valign=\"top\">Llámanos al <strong style=\"color:#ff4c00\">01 800 002 5476</strong><br>";
                $email_body = $email_body . "              de lunes a viernes<br>";
                $email_body = $email_body . "              de 9:00 a 19:00 horas </td>";
                $email_body = $email_body . "            <td width=\"15%\" valign=\"top\">Escríbenos a <br>";
                $email_body = $email_body . "              <strong style=\"color:#ff4c00\"><a href=\"mailto:help@clip.mx\" style=\"color:#ff4c00;text-decoration:none\" target=\"_blank\">help@clip.mx</a></strong></td>";
                $email_body = $email_body . "          </tr>";
                $email_body = $email_body . "        </table></td>";
                $email_body = $email_body . "        </tr>";
                $email_body = $email_body . "      <tr>";
                $email_body = $email_body . "        <td height=\"\" colspan=\"3\" valign=\"middle\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;font-size:14px;padding-top:20px;padding-bottom:20px\"><strong>¡Únete a la revolución de pagos!</strong><br>";
                $email_body = $email_body . "          Saludos,<br>";
                $email_body = $email_body . "          Customer Happiness Specialist <br><br>";
                $email_body = $email_body . "          </td>";
                $email_body = $email_body . "      </tr>";
                $email_body = $email_body . "    </table></td>";
                $email_body = $email_body . "    <td valign=\"top\" width=\"52\"> </td>";
                $email_body = $email_body . "  </tr>";
                $email_body = $email_body . "  <tr style=\"background:#1d1d1b\" bgcolor=\"#1D1D1B\">";
                $email_body = $email_body . "    <td width=\"52\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400\"> </td>";
                $email_body = $email_body . "    <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                $email_body = $email_body . "      <tr>";
                $email_body = $email_body . "        <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ffc700;font-weight:400;padding-top:20px\"><span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ffc700;font-weight:400;font-size:12\">";
                $email_body = $email_body . "        <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;color:#fff;padding-top:20px;font-size:12px\">Llámanos de lunes a viernes<br>";
                $email_body = $email_body . "          de 9:00 a 19:00 horas<br>";
                $email_body = $email_body . "          <strong>01 800 002 5476</strong></td>";
                $email_body = $email_body . "        <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;font-weight:400;color:#fff;padding-top:20px;font-size:12px\">Contáctanos en fin de semana<br>";
                $email_body = $email_body . "          sábados de 9:00 a 17:00 horas<br>";
                $email_body = $email_body . "          <strong><a href=\"https://www.facebook.com/clipmx\" style=\"color:#fff;text-decoration:none\" target=\"_blank\">facebook.com/clipmx</a></strong></td>";
                $email_body = $email_body . "        <td height=\"80\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;color:#fff;padding-top:20px;font-size:12px\">Mándanos un mail <br>";
                $email_body = $email_body . "          <strong><a href=\"mailto:help@clip.mx\" style=\"color:#fff;text-decoration:none\" target=\"_blank\">help@clip.mx</a><br>";
                $email_body = $email_body . "          <a href=\"mailto:info@clip.mx\" style=\"color:#fff;text-decoration:none\" target=\"_blank\">info@clip.mx</a></strong></td>";
                $email_body = $email_body . "      </tr>";
                $email_body = $email_body . "    </table></td>";
                $email_body = $email_body . "    <td width=\"52\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400\"> </td>";
                $email_body = $email_body . "  </tr>";
                $email_body = $email_body . "</table>";
                $email_body = $email_body . "</div>";
                $email_body = $email_body . "</body>";
                $email_body = $email_body . "</html>";

                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "ssl";  
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 465;
                $mail->Username = "gabo@payclip.com";
                $mail->Password = "Kittie3005$";
                $mail->SetFrom("gabo@payclip.com", "Clip");
                $mail->AddAddress($email, $name);
                $mail->Subject = "Your user account has been created";
                $mail->MsgHTML($email_body);

            }

            catch (Exception $e) {
                echo $e->getMessage();
            }


        }

      }

    }  

  }

?>



<div class="section page">

    <div class="wrapperpage"> 

      <h1 class="h1pages">Upload Paypal's File</h1>

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
                      <input type="hidden" name="uploadpath" value="payments/" />
                      <input type="hidden" name="path" value="upload/uppaypal/index.php?filename=">
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
