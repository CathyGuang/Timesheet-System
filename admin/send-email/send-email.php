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

    <?php var_dump($_POST); ?>

    <?php

      $mailToAddress = "";
      $emailArray = [];
      if ($_POST["to"] == "Staff") {
        $emailArray = pg_fetch_all_columns(pg_query($db_connection, "SELECT email FROM workers WHERE staff;"), 0);
      }
      if ($_POST["to"] == "Volunteers") {
        // code...
      }
      if ($_POST["to"] == "Staff and Volunteers") {
        // code...
      }
      if ($_POST["to"] == "Clients") {
        // code...
      }
      if ($_POST["to"] == "All") {
        // code...
      }

      echo "<br>";
      var_dump($emailArray);
      echo "<br>";

      $mailToAddress = implode(", ", $emailArray);

      echo $mailToAddress;


      $mail = mail($mailToAddress, $_POST['subject'], $_POST['message'], "From: " . $_POST['from'],);
      if ($mail) {
        echo "<p>Success.</p>";
      } else {
        echo "<p>Message failed to send.</p>";
      }



    ?>


  </div>


</body>

</html>
