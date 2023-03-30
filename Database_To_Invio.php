<html>

<head>
    <title>Invio mail a destinatari</title>
</head>

</html>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lavoro";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

$mail = new PHPMailer(true);

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

try
{
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP(); // Send using SMTP
    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'noreply.cannizzaro@gmail.com'; // SMTP username
    $mail->Password = 'dyhrddqzfcoikcqp'; // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; 
    //`PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port = 587; // TCP port to connect to, use 465 for 
    //`PHPMailer::ENCRYPTION_SMTPS` above

    // Recipients
    $mail->setFrom('noreply.cannizzaro@gmail.com');

    // Query per selezionare tutti i record dalla tabella subscribers

    $sqlMail = "SELECT email FROM subscribers";
    $result = mysqli_query($conn, $sqlMail);

    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $to_address = $row["email"];
            $mail->addAddress($to_address);
        }
    }

    // Query per selezionare tutti i record dalla tabella email_queue

    $sql = "SELECT subject, message FROM email_queue";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        $message = "";
        while ($row = mysqli_fetch_assoc($result))
        {
            $subject = $row["subject"];
            $message .= "<br><br><br>" . "<strong>SUBJECT: " . $subject . "</strong> <br>BODY:" . $row["message"];
        }

        // Set recipient and content
        $mail->addAddress($to_address);
        $mail->isHTML(true);
        $mail->Subject = "elenco mail di questa settimana";
        $mail->Body = $message;

        // invia mail ed elimina dal database
        $mail->SMTPDebug = 0;
        if ($mail->send())
        {
            $delete_sql = "DELETE FROM email_queue";
            mysqli_query($conn, $delete_sql);
        }

        // Clear recipients
        $mail->ClearAllRecipients();

        // Stampa messaggio di avvenuto invio email
        echo 'Tutte le email sono state inviate correttamente';
    }
    else
    {
        echo "Non ci sono email da inviare";
    }

    // Chiudi la connessione al database

    mysqli_close($conn);
}
catch (Exception $e)
{
    echo "Impossibile inviare il messaggio: {$mail->ErrorInfo}";
}
?>