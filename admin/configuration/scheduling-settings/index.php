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


  <?php
      $ignoreTack = pg_fetch_row(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'ignore_tack_conflicts';"), 0, PGSQL_ASSOC)['value'];
      $ignorePad = pg_fetch_row(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'ignore_pad_conflicts';"), 0, PGSQL_ASSOC)['value'];
      var_dump($ignorePad);
      var_dump($ignoreTack);
    ?>

  <div class="form-container">

    <form autocomplete="off" class="standard-form standard-form" action="update-settings.php" method="post">
      <div class="form-section">
        <h3>Conflicts:</h3>
      </div>
      <div class="form-section">
        <div class="form-element">
          <p>Ignore Tack Conflicts: <input type="checkbox" name="ignore_tack_conflicts" <?php if ($ignoreTack == "TRUE") {echo "checked";} ?>></p>
        </div>
      </div>
      <div class="form-section">
        <div class="form-element">
          <p>Ignore Pad Conflicts: <input type="checkbox" name="ignore_pad_conflicts" <?php if ($ignorePad == "TRUE") {echo "checked";} ?>></p>
        </div>
      </div>

      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <button type="submit">Update</button>
      </div>


    </form>

  </div>


</body>

</html>
