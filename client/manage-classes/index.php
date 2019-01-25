<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php INCLUDE $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Client Manage Classes</title>
</head>

<body>

  <header>
    <h1>Manage Classes</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <?php
    if (!$_POST['selected-client']) {
      echo <<<EOT
      <div class="main-content-div">
        <form autocomplete="off" action="" method="post" class="main-form small-form" autocomplete='off'>
          <p>Select your name:</p>
          <input type="text" name="selected-client" list="client-list" onclick="select();">
            <datalist id="client-list">
EOT;
            $clientNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM clients WHERE (archived IS NULL OR archived = '');"), 0);
            foreach ($clientNames as $name) {
              $name = htmlspecialchars($name, ENT_QUOTES);
              echo "<option value='{$name}'>";
            }
            echo <<<EOT
            </datalist>
          <input type="submit" value="Submit">
        </form>
      </div>
EOT;
    } else {
      $QUERY_NAME = $_POST['selected-client'];
      include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/getClientInvolvedClasses.php";
      echo <<<EOT
        <form autocomplete="off" action="manage-class-front-end.php" method="post" class="main-form">
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
