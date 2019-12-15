<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/main.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:700&display=swap" rel="stylesheet">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/initialization.php"; ?>
  <title>Admin | New Misc. Object</title>
</head>

<body>

  <header>
    <h1>New Object</h1>
    <nav>
      <a href="../"><button id="back-button">Back</button></a>
      <a href="/"><button id="home-button">Home</button></a>
    </nav>
  </header>


  <form autocomplete="off" action="create-new-other.php" method="post" class="standard-form">

    <p>Select object type:</p>
    <input name="object-type" list="object-type-list" onclick="select();" required>
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

          while ($row = pg_fetch_row($result)) {
            echo "<option value='{$row[1]}'>";
          }
        ?>
      </datalist>

    <p>Name of new object:</p>
    <input type="text" name="new-object-name" value="" required>


    <br><br>
    <button type="submit">Submit</button>

  </form>





</body>

</html>
