<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
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

  <div class="form-container">

    <form class="standard-form" action="colors.php" method="post">
      <div class="form-section">
        <div class="form-element">
          <label for="class-type">Class Type:</label>
          <input type="text" name="class-type" id="class-type" value="" list="class-type-list" required>
          <datalist id="class-type-list">
            <?php
              $getClassTypesQuery = "SELECT unnest(enum_range(NULL::CLASS_TYPE))::text EXCEPT SELECT name FROM archived_enums;";
              $classTypeNames = pg_fetch_all_columns(pg_query($db_connection, $getClassTypesQuery));
              var_dump($classTypeNames);
              foreach ($classTypeNames as $name) {
                echo "<option value='{$name}'>";
              }
            ?>
          </datalist>
        </div>
      </div>
      <div class="form-section">
        <div class="form-element">
          <label for="color-code">Color:</label>
          <input type="color" name="color-code" id="color-code">
        </div>
      </div>
      <div class="form-section">
        <button type="button" class="cancel-form" onclick="window.history.back()">Cancel</button>
        <input type="submit" value="Update">
      </div>
      
    </form>

  </div>


</body>

</html>
