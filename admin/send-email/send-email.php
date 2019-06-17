<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Email | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <header>
    <h1>Send System Email</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">

    <?php

      $mailToAddress = "";
      $emailArray = [];
      if ($_POST["to"] == "Staff") {
        $emailArray = pg_fetch_all_columns(pg_query($db_connection, "SELECT email FROM workers WHERE staff;"), 0);
      }
      if ($_POST["to"] == "Volunteers") {
        $emailArray = pg_fetch_all_columns(pg_query($db_connection, "SELECT email FROM workers WHERE volunteer;"), 0);
      }
      if ($_POST["to"] == "Staff and Volunteers") {
        $emailArray = pg_fetch_all_columns(pg_query($db_connection, "SELECT email FROM workers WHERE staff OR volunteer;"), 0);
      }
      if ($_POST["to"] == "Clients") {
        $emailArray = pg_fetch_all_columns(pg_query($db_connection, "SELECT email FROM clients;"), 0);
      }
      if ($_POST["to"] == "All") {
        $emailArray = pg_fetch_all_columns(pg_query($db_connection, "SELECT email FROM workers WHERE staff OR volunteer;"), 0);
        $emailArray = array_merge($emailArray, pg_fetch_all_columns(pg_query($db_connection, "SELECT email FROM clients;"), 0));
      }


      $mailToAddress = implode(", ", $emailArray);
      $emailBody = wordwrap($_POST['message'], 70);


      $mail = mail($mailToAddress, $_POST['subject'], $emailBody, "From: no-reply@darkhorsescheduling.com");
      if ($mail) {
        echo "<p>Success.</p>";
      } else {
        echo "<p>Message failed to send.</p>";
      }

    ?>


  </div>


</body>

</html>
