<html>

  <img style="width:20%" src="logo-ministero-black.png" alt="Logo ministero istruzione">
<br>
    <img style="width:33%" src="https://scaling.spaggiari.eu/MIIT0065/logo/4975.png&amp;rs=%2FtccTw2MgxYfdxRYmYOB6HjkoZcUOGTiYi6QRxuVV5sOGTp63rmnr%2BRTYVh7%2BFO%2FGwXtspJHA9p4BXfBXCcE%2BNfMTv1f63V8Ma7anOoEpmr1vY686jQADlCXWoD41fhLPKDeb5KzEXlN3xj5VLED2HK76ruGkCrzhAMWUaH%2BXdg%3D" alt="ITIS S. Cannizzaro Rho">
<form method="POST" action="">
    <p><label for="subject" >Oggetto:</label><br/>
    <input type="text" id="subject" name="subject" placeholder="inserire soggetto" size="40" style="background-color: #0B4C5F; color:#FFFFFF" ></p>
    <p><label for="message">Contenuto:</label><br/>
    <textarea id="message" name="message" cols="50" rows="10" placeholder="inserire testo" style="background-color: #0B4C5F; color:#FFFFFF"></textarea></p>
    <p id="lista"></p>
    <button type="submit" name="submit" value="submit">Invia</button>
  </form>
</html>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master\src\Exception.php';
require 'PHPMailer-master\src\PHPMailer.php"';
require 'PHPMailer-master\src\SMTP.php';

$mail = new PHPMailer(true);

$mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'noreply.cannizzaro@gmail.com';                 // SMTP username
    $mail->Password   = 'dyhrddqzfcoikcqp';                        // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    // Recipients
    $mail->setFrom('noreply.cannizzaro@gmail.com');
    $mail->addAddress('rossetti.william.2004@gmail.com');

    // Content
    $mail->isHTML(true);
                                      // Set email format to HTML
    if (isset($_POST ['subject']) && isset($_POST ['message'])){
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['message'];
    
    
    $mail->SMTPDebug = 0;
    $mail->send();
    echo 'Message has been sent';
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
