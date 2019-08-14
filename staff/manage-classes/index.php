<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php INCLUDE $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
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
        <form autocomplete="off" action="" method="post" class="main-form small-form">
          <p>Select your name:</p>
          <input type="text" name="selected-worker" list="worker-list" onclick="select();">
            <datalist id="worker-list">
EOT;
            $workerNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM workers WHERE staff = TRUE AND (archived IS NULL OR archived = '');"), 0);
            foreach ($workerNames as $name) {
              $name = htmlspecialchars($name, ENT_QUOTES);
              echo "<option value='{$name}'>";
            }
            echo <<<EOT
            </datalist>
          <p>Show old classes: <input type="checkbox" name="show-old-classes" value="true"></p>
          <input type="submit" value="Submit">
        </form>
      </div>
EOT;
    } else {
      $QUERY_NAME = $_POST['selected-worker'];
      if ($_POST['show-old-classes'] == 'true') {
        $FETCH_OLD_CLASSES = true;
      }
      include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/getWorkerInvolvedClasses.php";
      echo <<<EOT
        <form autocomplete="off" action="manage-class-front-end.php" method="get" class="main-form">
EOT;
      if($allClasses) {
        foreach ($allClasses as $classTuple) {
          $clientString = "";
          foreach ($classTuple['clients'] as $name) {
            $name = htmlspecialchars($name, ENT_QUOTES);
            $clientString = $clientString . $name . ", ";
          }
          echo "<button type='submit' name='buttonInfo' value='{$classTuple['id']};{$clientString}'>{$classTuple['display_title']}, {$classTuple['date_of_class']}</button>";
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
