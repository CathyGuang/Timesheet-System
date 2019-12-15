<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | Edit Misc. Object</title>
</head>

<body>

  <header>
    <h1>Edit Object</h1>
    <nav> <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <form autocomplete="off" action="edit-other.php" method="post" class="standard-form">

    <p>Select object type:</p>
    <input id="object-type-selector" name="object-type" list="object-type-list" value="" onclick="select();" required>
      <datalist id="object-type-list">
        <?php
          $query = <<<EOT
          SELECT n.nspname as "Schema",
  pg_catalog.format_type(t.oid, NULL) AS "Name",
  pg_catalog.obj_description(t.oid, 'pg_type') as "Description"
FROM pg_catalog.pg_type t
     LEFT JOIN pg_catalog.pg_namespace n ON n.oid = t.typnamespace
WHERE (t.typrelid = 0 OR (SELECT c.relkind = 'c' FROM pg_catalog.pg_class c WHERE c.oid = t.typrelid))
  AND NOT EXISTS(SELECT 1 FROM pg_catalog.pg_type el WHERE el.oid = t.typelem AND el.typarray = t.oid)
      AND n.nspname <> 'pg_catalog'
      AND n.nspname <> 'information_schema'
  AND pg_catalog.pg_type_is_visible(t.oid)
ORDER BY 1, 2;
EOT;
          $result = pg_query($db_connection, $query);

          $all_objects = array();

          while ($row = pg_fetch_row($result)) {
            echo "<option value='{$row[1]}'>";

            $getSubObjectsQuery = "SELECT unnest(enum_range(NULL::{$row[1]}))::text EXCEPT SELECT name FROM archived_enums;";
            $subObjects = pg_query($db_connection, $getSubObjectsQuery);
            $subObjectNames = pg_fetch_all_columns($subObjects);
            $all_objects[$row[1]] = array();
            foreach ($subObjectNames as $key => $value) {
              $all_objects[$row[1]][$key] = $value;
            }
          }
        ?>
      </datalist>

    <?php //Create datalists for all object types
      foreach ($all_objects as $object_type => $subObjects) {
        echo "<datalist id='{$object_type}'>";
        foreach ($subObjects as $key => $value) {
          echo "<option value='{$value}'>";
        }
        echo "</datalist>";
      }
    ?>

    <p>Select object to edit:</p>
    <input id="object-selector" name="selected-object" list="" required>

    <p>Change object name:</p>
    <input type="text" name="new-object-name" value="" required>

    <p style='color: var(--dark-red)'>Archive: <input type="checkbox" name="archive" value="TRUE"> (also enter "archive" under 'Change object name'.)</p>

    <br><br>
    <input type="submit" value="Submit">

  </form>


<footer>
  <script type="text/javascript">
    var objectTypeSelector = document.getElementById('object-type-selector');
    var objectSelector = document.getElementById('object-selector');
    objectTypeSelector.onchange = function(){
      objectSelector.setAttribute("list", this.value);
    };
  </script>
</footer>


</body>

</html>
