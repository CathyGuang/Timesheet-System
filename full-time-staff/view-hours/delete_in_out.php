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
      $query = "DELETE FROM in_out_times WHERE date_of_shift = '{$_POST['date_of_shift']}' AND staff = {$_POST['staff']};";
      $result = pg_query($db_connection, $query);

      if ($result){
        $total_hours_query = "DELETE FROM full_total_hours WHERE date_of_shift = '{$_POST['date_of_shift']}' AND staff = {$_POST['staff']};";
        $total_hours_result = pg_query($db_connection, $total_hours_query);
  
        $job_hour_query = "DELETE FROM full_job_hours WHERE date_of_shift = '{$_POST['date_of_shift']}' AND staff = {$_POST['staff']};";
        $job_hour_result = pg_query($db_connection, $job_hour_query);
  
        if ($total_hours_result && $job_hour_result){
        echo "<h3 class='main-content-header'>Successfully deleted this whole day's hours.</h3>";
      }else{
        echo "<h3 class='main-content-header'>Something went wrong. Contact admin for this day's hours.</h3>";
      }
     } else {
        echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }

      
        
    // }else{
    //   $query_total = "UPDATE in_out_times SET in_time = '{$_POST['in_time']}', out_time = '{$_POST['out_time']}' WHERE id = {$_POST['id']};";
    //   $result_total = pg_query($db_connection, $query_total);

    //   if ($result_total){
    //     echo "<h3 class='main-content-header'>You successfully update this row's data!</h3>";
    //   } else {
    //     echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
    //   }
    // }
    ?>
    <!-- UPDATE full_job_hours SET date_of_shift = '2021-08-27', hours = 1 WHERE idd = 9 -->
    <!-- UPDATE in_out_times SET in_time = '09:45:00', out_time = '10:30:00' WHERE id = 14 -->
    
</body>



</html>
