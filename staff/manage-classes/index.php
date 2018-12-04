<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php INCLUDE $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/connectdb.php"; ?>
  <title>Staff Manage Classes</title>
</head>

<body>

  <header>
    <h1>Manage Classes</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    if (!$_POST['selected-worker']) {
      echo <<<EOT
        <form action="" method="post" class="main-form">
          <input type="text" name="selected-worker" list="worker-list" onclick="select();">
            <datalist id="worker-list">
EOT;
            $workerNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers;"), 0);
            foreach ($workerNames as $name) {
              echo "<option value='{$name}'>";
            }
            echo <<<EOT
            </datalist>
          <input type="submit" value="Submit">
        </form>
EOT;
    } else {
      $QUERY_NAME = $_POST['selected-worker'];
      include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/getWorkerInvolvedClasses.php";
      echo <<<EOT
        <form action="manage-class-front-end.php" method="post" class="main-form">
EOT;
      if($allClasses) {
        foreach ($allClasses as $classTuple) {
          echo "<button type='submit' name='selectedClassID' value='{$classTuple['id']}'>{$classTuple['class_type']}, {$classTuple['name']}, {$classTuple['date_of_class']}</button>";
        }


        echo <<<EOT
        </form>
EOT;
      } else {
        echo "</form><h3 class='main-content-header'>No Classes Found.</h3>";
      }
    }

  ?>


</body>

</html>
