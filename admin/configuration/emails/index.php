<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Admin | System Emails</title>
</head>

<body>

  <header>
    <h1>Configure System Emails</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <?php
      $volunteerCoordinatorEmail = pg_fetch_array(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'volunteer_coordinator_email';"), 0, PGSQL_ASSOC)['value'];
      $staffCoordinatorEmail = pg_fetch_array(pg_query($db_connection, "SELECT value FROM misc_data WHERE key LIKE 'staff_coordinator_email';"), 0, PGSQL_ASSOC)['value'];
    ?>

  <div class="form-container">

    <form autocomplete="off" class="standard-form standard-form" action="emails.php" method="post">
      <div class="form-section">
        <div class="form-element">
          <label for="volunteer_coordinator_email">Volunteer Coordinator: </label>
          <input type="email" name="volunteer_coordinator_email" id="volunteer_coordinator_email" value="<?php echo $volunteerCoordinatorEmail; ?>">
        </div>
      </div>
      <div class="form-section">
        <div class="form-element">
          <label for="staff_coordinator_email">Staff Coordinator: </label>
          <input type="email" name="staff_coordinator_email" id="staff_coordinator_email" value="<?php echo $staffCoordinatorEmail; ?>">
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
