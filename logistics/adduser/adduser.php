<?php
require_once("../inc/config.php");
require_once("../inc/models.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST["user"]);
    $password = md5(trim($_POST["password"]));
    $confirm = md5(trim($_POST["confirm"]));
    $name = utf8_encode(trim($_POST["name"]));
    $email = trim($_POST["email"]);

    if ($user == "" OR $password == "" OR $confirm == "" OR $name == "" or $email == "") {
        $error_message = "You must specify a value for user, password and confirmation, name and email.";
    }

    if ($password !== $confirm) {
        $error_message = "The password and the confirmation are not identical";
    }

    if(!isset($error_message)) {
        foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $error_message = "There was a problem with the information you entered.";    
            }
        }
    }

    if(!isset($error_message) && $_POST["employee"] != "") {
        $error_message = "Your form submission has an error.";
    }

    require_once(ROOT_PATH . "inc/phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    
    if(!isset($error_message) && !$mail->ValidateAddress($email)) {
        $error_message = "You must specify a valid email address.";
    }

    if(verify_user($user)){
        $error_message = "The user already exists in the database";
    } 

    if (!isset($error_message)){

        require(ROOT_PATH . "inc/database.php");

        try {

            $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,DB_USER,DB_PASS);
            $db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $db -> exec ("SET NAMES 'utf8'");

            $sql = "INSERT INTO tbl_users (user_id,password,name,email) VALUES (:user,:password,:name, :email)";   
            $q = $db->prepare($sql);
            $q->execute(array(':user'=> $user,
                              ':password'=> $password,
                              ':name' => $name,
                              ':email' => $email));
        }

         catch (Exception $e){
    
            echo "Could not connect to the database, error: " . $e ;
            exit;
        }

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
            $email_body = $email_body . "            <td width=\"62%\"><span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:300;font-size:48px;line-height:53px\">¡Bienvenido!<br>";
            $email_body = $email_body . "              Es hora de liberar<br>";
            $email_body = $email_body . "              tu negocio</span></td>";
            $email_body = $email_body . "             <td align=\"right\" valign=\"top\"><img src=\"http://www.e-deweb.com/clip/N/images/logo.png\" alt=\"\" width=\"84\" height=\"84\"></td>";
            $email_body = $email_body . "          </tr>";
            $email_body = $email_body . "        </table></td>";
            $email_body = $email_body . "        </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td colspan=\"3\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ff4c00;font-size:14px;font-weight:300;padding-top:14px\">";
            $email_body = $email_body . "        <span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;font-size:14px\">Hola (NAME)<br>";
            $email_body = $email_body . "          Para iniciar con el pie derecho, te recordamos todo lo que debes saber sobre Clip.<br>";
            $email_body = $email_body . "Revisa esta información siempre que tengas alguna duda.</span></td>";
            $email_body = $email_body . "        </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td colspan=\"3\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ff4c00;font-size:22px;font-weight:300;padding-top:14px\">Lector</td>";
            $email_body = $email_body . "      </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td width=\"50%\" valign=\"bottom\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;padding-top:14px\"><img src=\"http://www.e-deweb.com/clip/N/images/1.png\"></td>";
            $email_body = $email_body . "        <td width=\"50%\" valign=\"bottom\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;padding-top:14px\"><img src=\"http://www.e-deweb.com/clip/N/images/2.png\"></td>";
            $email_body = $email_body . "      </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;padding-top:14px;font-size:12px\"><strong>Tarjetas con banda magnética</strong><br>";
            $email_body = $email_body . "          <span style=\"color:#ff4c00\">Desliza</span> las tarjetas con <span style=\"color:#ff4c00\">banda</span> a través <br>";
            $email_body = $email_body . "          de la <span style=\"color:#ff4c00\">ranura frontal</span> del lector.</td>";
            $email_body = $email_body . "        <td width=\"50%\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:400;padding-top:14px;font-size:12px\"><strong>Tarjetas con chip</strong><br>";
            $email_body = $email_body . "          <span style=\"color:#ff4c00\">Inserta</span> las tarjetas con <span style=\"color:#ff4c00\">chip</span> en la <span style=\"color:#ff4c00\">ranura <br>";
            $email_body = $email_body . "          superior</span> del lector. <br></td>";
            $email_body = $email_body . "      </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td valign=\"bottom\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:600\"><img src=\"http://www.e-deweb.com/clip/N/images/3.png\"></td>";
            $email_body = $email_body . "        <td valign=\"bottom\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:600\"><img src=\"http://www.e-deweb.com/clip/N/images/4.png\"></td>";
            $email_body = $email_body . "        </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-size:12px\">";
            $email_body = $email_body . "        <span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:600\">Mantén tu lector activo</span><br>";
            $email_body = $email_body . "          Tu Clip cuenta con un led que cambiará<br>";
            $email_body = $email_body . "          de verde a rojo cuando la batería llegue al 20%<br>";
            $email_body = $email_body . "          de carga. Además, la aplicación móvil te avisará<br>";
            $email_body = $email_body . "          cuando la batería llegue al 20, 10 y 5%.</td>";
            $email_body = $email_body . "        <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-size:12px\">";
            $email_body = $email_body . "           <p><span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:600\">Actualiza tu app</span><br>";
            $email_body = $email_body . "             Para mayor comodidad, procura tener<br>";
            $email_body = $email_body . "             activa la opción de actualización<br>";
            $email_body = $email_body . "             automática, así tendrás acceso a todas<br>";
            $email_body = $email_body . "             las utilidades de la aplicación.</p></td>";
            $email_body = $email_body . "      </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td colspan=\"2\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:600;padding-top:0px\"><span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ff4c00;font-size:22px;font-weight:300;padding-top:0px\">Pagos y comisiones</span></td>";
            $email_body = $email_body . "        </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td valign=\"bottom\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:600\"><img src=\"http://www.e-deweb.com/clip/N/images/5.png\"></td>";
            $email_body = $email_body . "        <td valign=\"bottom\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-weight:600\"><img src=\"http://www.e-deweb.com/clip/N/images/6.png\"></td>";
            $email_body = $email_body . "      </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-size:12px\"><p><span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b\"><strong>Comisión única</strong><br>";
            $email_body = $email_body . "          Nuestra comisión* es de 3.6% por transacción,<br>";
            $email_body = $email_body . "          más IVA. No hay un mínimo de facturación ni <br>";
            $email_body = $email_body . "          comisiones mensuales.</span></p>";
            $email_body = $email_body . "          <p style=\"color:#6d6e71\">* Las comisiones por los pagos a meses sin<br>";
            $email_body = $email_body . "          intereses con American Express son adicionales <br>";
            $email_body = $email_body . "          y oscilan entre el 4.5% y el 11.95%,<br>";
            $email_body = $email_body . "          dependiendo el periodo. Consulta la<br>";
            $email_body = $email_body . "          información completa <strong style=\"color:#ff4c00\">aquí</strong>.</p></td>";
            $email_body = $email_body . "        <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-size:12px\"><p style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b\"><strong>Depósitos a tu cuenta bancaria</strong><br>";
            $email_body = $email_body . "          Se realizarán 2 días hábiles después de haber aceptado<br>";
            $email_body = $email_body . "          el pago**. Si realizas transacciones menores a<br>";
            $email_body = $email_body . "          500 pesos, te depositaremos en cuanto alcances esta <br>";
            $email_body = $email_body . "          cantidad en tu cuenta Clip.</p>";
            $email_body = $email_body . "          <p style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b\">Revisa que tu cuenta bancaria esté bien configurada<br>";
            $email_body = $email_body . "            en el perfil de tu negocio. Ingresa en<strong style=\"color:#ff4c00\"> <a href=\"http://www.clip.mx\" target=\"_blank\">www.clip.mx</a></strong>,<br>";
            $email_body = $email_body . "            accede a la configuración de tu cuenta y agrega <br>";
            $email_body = $email_body . "            tu clabe de 18 dígitos, junto con el nombre de tu banco.</p>";
            $email_body = $email_body . "          <p style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#6d6e71\">** Si el día del depósito es festivo, recibirás tu dinero<br>";
            $email_body = $email_body . "          el siguiente día hábil.</p></td>";
            $email_body = $email_body . "      </tr>";
            $email_body = $email_body . "      <tr>";
            $email_body = $email_body . "        <td colspan=\"2\" valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#1d1d1b;font-size:12px\">";
            $email_body = $email_body . "        <span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ff4c00;font-size:22px;font-weight:300;padding-top:0px\">Soporte<br>";
            $email_body = $email_body . "        </span>";
            $email_body = $email_body . "          ";
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
            $email_body = $email_body . "        <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ffc700;font-weight:400;padding-top:20px\"><span style=\"font-family:&#39;Open Sans&#39;,sans-serif;color:#ffc700;font-weight:400;font-size:12\">¿Tienes alguna duda?</span> </td>";
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
            $email_body = $email_body . "  <tr>";
            $email_body = $email_body . "    <td valign=\"top\"> </td>";
            $email_body = $email_body . "    <td valign=\"top\" style=\"font-family:&#39;Open Sans&#39;,sans-serif;font-size:10px;font-weight:400;color:#58595b;padding-top:7px\">Id. de correo electrónico de Clip 0000000</td>";
            $email_body = $email_body . "    <td valign=\"top\"> </td>";
            $email_body = $email_body . "  </tr>";
            $email_body = $email_body . "</table>";
            $email_body = $email_body . "</div>";
            $email_body = $email_body . "</body></html>";


            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "ssl";  
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->Username = "gabo@payclip.com";
            $mail->Password = "Kittie3005$";
            $mail->SetFrom("gabo@payclip.com", "Clip");
            $mail->AddAddress($email, $name);
            $mail->Subject    = "Your user account has been created";
            $mail->MsgHTML($email_body);

            //if(!$mail->Send()) throw new Exception($mail->ErrorInfo);

            header("Location: " . BASE_URL . "adduser/?user=" . $user);
        } 

        catch (Exception $e){
            echo $e->getMessage();
        }
       
    }
    
}

?>