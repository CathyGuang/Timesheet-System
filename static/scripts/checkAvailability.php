<?php

  function checkAvailability($id, $typeOfObject, $date, $time1, $time2) {
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/connectdb.php";

    $tableNameList = pg_fetch_all_columns(pg_query($db_connection, "SELECT table_name FROM information_schema.tables WHERE table_schema='public' AND table_type='BASE TABLE';"));
    $enumTypeQuery = <<<EOT
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
    $enumTypeSQL = pg_fetch_all(pg_query($db_connection, $enumTypeQuery));
    $enumTypeList = array();
    foreach ($enumTypeSQL as $array) {
      $enumTypeList[] = $array['Name'];
    }


    if (in_array($typeOfObject, $tableNameList)) {
      echo "this is in a table!<br>";
      $classQuery = <<<EOT
      SELECT start_time, end_time FROM classes
      WHERE
      (
      {$id} = classes.horse OR
      {$id} = ANY(classes.clients) OR
      {$id} = classes.instructor OR
      {$id} = classes.therapist OR
      {$id} = classes.equine_specialist OR
      {$id} = classes.leader OR
      {$id} = ANY(classes.sidewalkers)
      ) AND (
      '{$date}' = date_of_class
      )

      ;
EOT;
      $horseCareShiftQuery = <<<EOT
      SELECT start_time, end_time FROM horse_care_shifts
      WHERE
      (
      {$id} = horse_care_shifts.leader OR
      {$id} = ANY(horse_care_shifts.volunteers)
      )

      ;
EOT;
      $officeShiftQuery = <<<EOT
      SELECT start_time, end_time FROM office_shifts
      WHERE
      (
      {$id} = office_shifts.leader OR
      {$id} = ANY(office_shifts.volunteers)
      )

      ;
EOT;

      $allEvents = pg_fetch_all(pg_query($db_connection, $classQuery));
      $allEvents[] = pg_fetch_all(pg_query($db_connection, $horseCareShiftQuery));
      $allEvents[] = pg_fetch_all(pg_query($db_connection, $officeShiftQuery));

      var_dump($allEvents);

      foreach ($allEvents as $key => $timePair) {
        if ($timePair) {
          if (strtotime($timePair['start_time']) < strtotime($time2) and strtotime($timePair['end_time']) > strtotime($time1)) {return false;}
        }
      }



    } elseif (in_array($typeOfObject, $enumTypeList)) {
      echo "this is an enum value!<br>";


    }




    return true;
  };




  $result = checkAvailability(2, 'workers', "2018-12-10", "9:00", "10:00");

  echo "<br><br>";

  var_dump($result);
?>
