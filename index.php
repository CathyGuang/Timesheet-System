<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Home | <?php echo $organizationName; ?> Web Portal</title>
</head>

<body>

  <img src="/static/logo.png.ln" alt="<?php echo $organizationName; ?> Logo" style="position: absolute;width:300px;top:0em;">

  <header>
    <h1><?php echo $organizationName; ?> Web Portal</h1>
    <label id="version-label"><a href="README.md">v1.6</a></label>
    <label id="dhs-website-label"><a href="https://www.darkhorsescheduling.com/">darkhorsescheduling.com</a></label>
  </header>



  <div class="main-content-div">
    <a href="/volunteer"><button class="green-button">Volunteer</button></a>
    <a href="/part-time-staff"><button class="green-button">Part Time Staff</button></a>
    <a href="/full-time-staff"><button class="green-button">Full Time Staff</button></a>
    <a href="/directory"><button class="blue-button">Directories</button></a>
    <a href="/admin"><button class="red-button">Admin</button></a>
  </div>

  <form autocomplete="off" action="/full-daily-schedule/index.php" method="post" id="full-daily-schedule-form" style="visibility: hidden">
    <input type="text" name="selected-name" value="ALL">
  </form>



</body>

</html>
