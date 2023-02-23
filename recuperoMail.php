<html>
<head>
	<title>Recupero dati dalla tabella email_queue</title>
</head>
<body>
	<h1>Recupero dati dalla tabella email_queue</h1>
	<table id="email_queue_table">
		<thead>
			<tr>
				<th>ID</th>
				<th>To Address</th>
				<th>Subject</th>
				<th>Message</th>
			</tr>
		</thead>
		<tbody>
			<!-- qui verranno aggiunti i dati recuperati dalla tabella email_queue -->
		</tbody>
	</table>

	<script src="path/to/your/script.js"></script>
</body>

<script>
// Definizione della funzione per recuperare i dati dalla tabella email_queue
function getEmailQueueData() {
    // Creazione della richiesta HTTP
    var xhttp = new XMLHttpRequest();

    // Funzione da eseguire quando la richiesta viene completata
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Parsing dei dati in formato JSON
            var emailQueueData = JSON.parse(this.responseText);

            // Aggiunta dei dati alla tabella HTML
            var emailQueueTableBody = document.querySelector('#email_queue_table tbody');
            emailQueueData.forEach(function(row) {
                var tr = document.createElement('tr');
                tr.innerHTML = '<td>' + row.id + '</td>' +
                               '<td>' + row.to_address + '</td>' +
                               '<td>' + row.subject + '</td>' +
                               '<td>' + row.message + '</td>';
                emailQueueTableBody.appendChild(tr);
            });
        }
    };

    // Apertura della connessione alla URL che recupera i dati dalla tabella email_queue
    xhttp.open("GET", "path/to/your/get_email_queue_data.php", true);
    xhttp.send();
}

// Chiamata alla funzione per recuperare i dati dalla tabella email_queue al caricamento della pagina
window.onload = getEmailQueueData;
</script>






<?php
// Connessione al database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "lavoro";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Query per recuperare i dati dalla tabella email_queue
$sql = "SELECT id, to_address, subject, message FROM email_queue";
$result = $conn->query($sql);

// Array per salvare i dati recuperati dalla tabella email_queue
$emailQueueData = array();

// Ciclo sui risultati della query e aggiunta dei dati all'array
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $emailQueueData[] = $row;
    }
}

// Chiusura della connessione al database
$conn->close();

// Impostazione dell'header della risposta come JSON
header('Content-Type: application/json');

// Restituzione dei dati in formato JSON
echo json_encode($emailQueueData);
?>

</html>