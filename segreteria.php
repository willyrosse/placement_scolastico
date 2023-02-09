<?php
include 'ch19_include.php';

if (!$_POST) {
  $display_block = <<<END_OF_BLOCK
  <form method="POST" action="$_SERVER[PHP_SELF]">
    <p><label for="subject">Subject:</label><br>
    <input type="text" id="subject" name="subject" size="40"></p>
    <p><label for="message">Mail Body:</label><br>
    <textarea id="message" name="message" cols="50" rows="10"></textarea></p>
    <button type="submit" name="submit" value="submit">Submit</button>
  </form>
END_OF_BLOCK;
} else if ($_POST) {
  if (($_POST['subject'] == "") || ($_POST['message'] == "")) {
    header("Location: sendmymail.php");
    exit;
  }
  doDB();
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  } else {
    $sql = "SELECT email FROM subscribers";
    $result = mysqli_query($mysqli, $sql)
             or die(mysqli_error($mysqli));
    $mailheaders = "From: Your Mailing List
        <you@yourdomain.com>";
    while ($row = mysqli_fetch_array($result)) {
      set_time_limit(0);
      $email = $row['email'];
      mail("$email", stripslashes($_POST['subject']),
           stripslashes($_POST['message']), $mailheaders);
      $display_block .= "newsletter sent to: ".$email."<br>";
    }
    mysqli_free_result($result);
    mysqli_close($mysqli);
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sending a Newsletter</title>
</head>
<body>
  <h1>Send a Newsletter</h1>
  <?php echo $display_block; ?>
</body>
</html>
