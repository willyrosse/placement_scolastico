<html>
  <head>
    <title>invio mail a database</title>
  </head>

  <img style="width:20%" src="logo-ministero-black.png" alt="Logo ministero istruzione">
  <br>
  <img style="width:33%" src="https://scaling.spaggiari.eu/MIIT0065/logo/4975.png&amp;rs=%2FtccTw2MgxYfdxRYmYOB6HjkoZcUOGTiYi6QRxuVV5sOGTp63rmnr%2BRTYVh7%2BFO%2FGwXtspJHA9p4BXfBXCcE%2BNfMTv1f63V8Ma7anOoEpmr1vY686jQADlCXWoD41fhLPKDeb5KzEXlN3xj5VLED2HK76ruGkCrzhAMWUaH%2BXdg%3D" alt="ITIS S. Cannizzaro Rho">
  <br><br>

  <form method="POST" onsubmit="return submitForm()">
    <label for="subject">Oggetto:</label><br />
    <input type="text" id="subject" name="subject" placeholder="inserire soggetto" size="40" style="background-color: #0B4C5F; color:#FFFFFF"></p>
    <label for="message">Contenuto:</label><br />
    <textarea id="message" name="message" cols="50" rows="10" placeholder="inserire testo" style="background-color: #0B4C5F; color:#FFFFFF"></textarea></p>
    <button type="submit" name="submit" value="submit">Invia</button>
  </form>
</html>

<?php

$subject = '';
$message = '';

if (isset($_POST['submit']))
{
  // Check if subject and message are not empty
  if (!empty($_POST['subject']) && !empty($_POST['message']))
  {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'lavoro');

    // Insert the email into the database
    $query = "INSERT INTO email_queue (subject, message) VALUES ('$subject', '$message')";
    mysqli_query($db, $query);

    // Close the database connection
    mysqli_close($db);

    echo "l'Email è stata inviata alla segreteria, che provvederà ad inviarla agli studenti iscritti";
  }
  else
  {
    echo "Errore: ricordati di riempire entrambi i campi";
  }
}

?>