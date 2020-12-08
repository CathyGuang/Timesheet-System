<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <link rel="stylesheet" href="/static/added.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <script type="text/javascript" src="/static/TimeSlider.js"></script>
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?> 
  <title>Full time</title>
 
</head>

<body>

  <header>
    <h1>Full-time</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <form class="form-inline" action="full-time.php">
    <label for="Name">Name:</label>
    <input type="Name" id="Name" placeholder="Enter name" name="name">
    <label>Date:</label>
    <input type="date" name="date-of-hours" value="<?php echo date('Y-m-d'); ?>" required>

  </form>



</body>

</html>
