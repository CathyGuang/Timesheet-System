<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <title>Volunteer Daily Schedule</title>
</head>

<body>

  <header>
    <h1><?php echo $_POST['query-name'] ?>'s Daily Schedule</h1>
    <nav>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>




  <?php
    print_r($_POST);

  ?>







</body>

</html>
