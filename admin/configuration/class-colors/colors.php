<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
  <?php include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php"; ?>
  <title>Admin | Class Colors</title>
</head>

<body>

  <header>
    <h1>Class Display Colors</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>

  <div class="main-content-div">

    <?php

      $classType = pg_escape_string(trim($_POST['class-type']));
      $colorCode = pg_escape_string(trim($_POST['color-code']));

      $query = "DELETE FROM class_type_colors WHERE class_type = '{$classType}'; INSERT INTO class_type_colors (class_type, color_code) VALUES ('{$classType}', '{$colorCode}');";

      $result = pg_query($db_connection, $query);

      if ($result) {
        echo "<h3 class='main-content-header'>Success</h3>";
      } else {
        echo "<h3 class='main-content-header'>An error occurred.</h3><p class='main-content-header'>Please try again, ensure that all data is correctly formatted.</p>";
      }
    ?>


  </div>


</body>

</html>
