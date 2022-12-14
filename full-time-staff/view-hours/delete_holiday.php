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
     <a href="./"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


    <?php
    if ($_POST['delete']) {
      $query = "DELETE FROM holiday_hours WHERE id = {$_POST['id']}";
      $result = pg_query($db_connection, $query);

      if ($result){
        echo "<h3 class='main-content-header'>Successfully deleted this holiday hour entry.</h3>";
      }else{
        echo "<h3 class='main-content-header'>Something went wrong. Contact admin for this day's hours.</h3>";
      }
    }
    ?>
</body>



</html>
