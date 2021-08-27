<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <script type="text/javascript" src="/static/jquery.min.js"></script>
  <script type="text/javascript" src="/static/jquery-ui.js"></script>
  <link rel="stylesheet" href="/static/enter_hour.css">
  <!-- The javascript passing data list id and idd to this page from perivous selection -->
  <script type="text/javascript" src="change_data.js"></script>
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Change Data</title>
</head>

<body>

  <header>
    <h1>Delete Hours Complete</h1>
    <nav>
     <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


    <?php
      $query = "DELETE FROM full_job_hours WHERE idd = {$_POST['idd']};";
      echo $_POST['idd'];
      $result = pg_query($db_connection, $query);

      $total_hours_result = pg_query($db_connection, "SELECT total_hour FROM full_total_hours WHERE id = {$_POST['id']};");
      While ($total_hours_row = pg_fetch_row($total_hours_result)){
        $hours = $total_hours_row[0] - $_POST['id'];
        $query_total = "UPDATE full_total_hours SET total_hour = {$hours} WHERE id = {$_POST['id']};";
        $result_total = pg_query($db_connection, $query_total);
      }

      if ($result) {
        echo "<h3 class='main-content-header'>Success</h3";
      } else {
        echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }
      return;
    ?>

</body>



</html>
