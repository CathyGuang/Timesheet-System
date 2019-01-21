<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Home | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <img src="/static/logo.png.ln" alt="<?php echo $organizationName; ?> Logo" style="position: absolute;">

  <header>
    <h1><?php echo $organizationName; ?> Web Portal</h1>
    <label id="version-label"><a href="README.md">v1.1</a></label>
  </header>



  <div class="main-content-div">
    <a href="/volunteer"><button class="green-button">Volunteer</button></a>
    <a href="/staff"><button class="green-button">Staff</button></a>
    <a href="/client"><button class="green-button">Client</button></a>
    <a href="/check-availability"><button class="blue-button">Check Availability</button></a>
    <button type="submit" form="full-daily-schedule-form" name="selected-date" value="<?php echo date('Y-m-d'); ?>" class="blue-button">Full Daily Schedule</button>
    <a href="/horse-daily-schedule"><button class="green-button">Horse Daily Schedule</button></a>
    <a href="/directory"><button class="blue-button">Directories</button></a>
    <a href="/admin"><button class="red-button">Admin</button></a>
  </div>

  <form autocomplete="off" action="/full-daily-schedule/index.php" method="post" id="full-daily-schedule-form" style="visibility: hidden">
    <input type="text" name="selected-name" value="ALL">
  </form>



</body>

</html>
