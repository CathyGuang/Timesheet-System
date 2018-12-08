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
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    if (!$_POST['selected-worker']) {
      echo <<<EOT
      <div class="main-content-div">
        <form action="" method="post" class="main-form small-form">
          <p>Select your name:</p>
          <input type="text" name="selected-worker" list="worker-list" onclick="select();">
            <datalist id="worker-list">
EOT;
            $workerNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE staff = TRUE;"), 0);
            foreach ($workerNames as $name) {
              echo "<option value='{$name}'>";
            }
            echo <<<EOT
            </datalist>
          <input type="submit" value="Submit">
        </form>
      </div>
EOT;
    } else {
      $QUERY_NAME = $_POST['selected-worker'];
      include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/getWorkerInvolvedClasses.php";
      echo <<<EOT
        <form action="manage-class-front-end.php" method="post" class="main-form">
EOT;
      if($allClasses) {
        foreach ($allClasses as $classTuple) {
          $clientString = "";
          foreach ($classTuple['clients'] as $name) {
            $clientString = $clientString . $name . ", ";
          }
          echo "<button type='submit' name='buttonInfo' value='{$classTuple['id']};{$clientString}'>{$classTuple['class_type']}, {$clientString} {$classTuple['date_of_class']}</button>";
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
