<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
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

    <form class="main-form small-form" action="colors.php" method="post">
      <div>
        <p>Class Type: <input type="text" name="class-type" value="" list="class-type-list"></p>
        <datalist id="class-type-list">
          <?php
            $getClassTypesQuery = "SELECT unnest(enum_range(NULL::class_type))::text EXCEPT SELECT name FROM archived_enums;";
            $classTypeNames = pg_fetch_all_columns(pg_query($db_connection, $getClassTypesQuery));
            foreach ($classTypeNames as $name) {
              echo "<option value='{$name}'>";
            }
          ?>
        </datalist>
        <p>Color: <input type="color" name="color" value=""></p>
      </div>

    </form>

  </div>


</body>

</html>
