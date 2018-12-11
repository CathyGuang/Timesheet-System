<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <title>Home | Forward Stride Web Portal</title>
</head>

<body>

  <img src="/static/images/logo.png" alt="Forward Stride Logo" style="position: absolute;">

  <header>
    <h1>Forward Stride Web Portal</h1>
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

  <form action="/full-daily-schedule/index.php" method="post" id="full-daily-schedule-form" style="visibility: hidden">
    <input type="text" name="selected-name" value="ALL">
  </form>



</body>

</html>
