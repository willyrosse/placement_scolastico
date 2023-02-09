<?php
// Controllo se il form è stato inviato

$email = $_POST["email"];
if (isset($_POST["submit"])) {
    // elaborazione del form
    
    $course = "PCTO";

    //validazione dell'indirizzo email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Indirizzo email non valido";
        exit;
    }

    //connessione al database
    $mysqli = new mysqli("localhost", "root", "", "lavoro");
    if ($mysqli->connect_errno) {
        echo "Connessione al MySQL fallita: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        exit;
    }

    //controllo se l'email è già presente nella lista
    $check_sql = "SELECT id FROM SUBSCRIBERS WHERE email = '".$email."'";
    $check_res = $mysqli->query($check_sql);
    if ($check_res->num_rows > 0) {
        echo "Sei già registrato per questo corso!";
        exit;
    }

    //aggiunta dell'email alla lista
    $add_sql = "INSERT INTO subscribers (email) VALUES('".$email."')";
    $add_res = $mysqli->query($add_sql);
    if (!$add_res) {
        echo "Impossibile registrarsi per il corso. Riprova più tardi.";
        exit;
        }
        

        //chiusura della connessione a MySQL
        $mysqli->close();
        
        echo "Sei ora registrato per il corso PCTO! Ti invieremo ulteriori informazioni alla tua email.";
        exit;
    }
        ?>
        
        <!DOCTYPE html>
        <html>
        <head>
        <title>Registrazione Corso PCTO</title>
        </head>
        <body>
        <h1>Registrazione Corso PCTO</h1>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <p>Email: <input type="email" name="email" size="40"></p>
            <input type="submit" name="submit" value="Registrati">
        </form>
        </body>
        </html>

        