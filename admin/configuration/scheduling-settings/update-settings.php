<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Admin | Scheduling Settings</title>
</head>

<body>

  <header>
    <h1>Configure Scheduling Settings</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">

    <?php
      $ignoreTack = 'FALSE';
      $ignorePad = 'FALSE';
      if ($_POST['ignore_tack_conflicts']) {
        $ignoreTack = 'TRUE';
      }
      if ($_POST['ignore_pad_conflicts']) {
        $ignorePad = 'TRUE';
      }

      $ignoreTackQuery = "UPDATE misc_data SET value = '{$ignoreTack}' WHERE key LIKE 'ignore_tack_conflicts';";
      $ignorePadQuery = "UPDATE misc_data SET value = '{$ignorePad}' WHERE key LIKE 'ignore_pad_conflicts';";

      $result1 = pg_query($db_connection, $ignoreTackQuery);
      $result2 = pg_query($db_connection, $ignorePadQuery);

      if ($result1 && $result2) {
        echo "<h3 class='main-content-header'>Success</h3>";
      } else {
        echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }

    ?>



  </div>


</body>

</html>
