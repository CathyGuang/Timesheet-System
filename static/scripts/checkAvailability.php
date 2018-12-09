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

      $classQuery = "";
      $horseCareShiftQuery = "";
      $officeShiftQuery = "";

      if ($typeOfObject == "workers") {
        $classQuery = <<<EOT
        SELECT start_time, end_time FROM classes
        WHERE
        (
        {$id} = classes.instructor OR
        {$id} = classes.therapist OR
        {$id} = classes.equine_specialist OR
        {$id} = classes.leader OR
        {$id} = ANY(classes.sidewalkers)
        ) AND (
        '{$date}' = date_of_class
        ) AND (
        (archived IS NULL OR archived = '')
        )

        ;
EOT;
        $horseCareShiftQuery = <<<EOT
        SELECT start_time, end_time FROM horse_care_shifts
        WHERE
        (
        {$id} = horse_care_shifts.leader OR
        {$id} = ANY(horse_care_shifts.volunteers)
        ) AND (
        '{$date}' = date_of_shift
        ) AND (
        (archived IS NULL OR archived = '')
        )

        ;
EOT;
        $officeShiftQuery = <<<EOT
        SELECT start_time, end_time FROM office_shifts
        WHERE
        (
        {$id} = office_shifts.leader OR
        {$id} = ANY(office_shifts.volunteers)
        ) AND (
        '{$date}' = date_of_shift
        ) AND (
        (archived IS NULL OR archived = '')
        )

        ;
EOT;
      } else if ($typeOfObject == "horses") {
        $classQuery = <<<EOT
        SELECT start_time, end_time FROM classes
        WHERE
        (
        {$id} = classes.horse
        ) AND (
        '{$date}' = date_of_class
        ) AND (
        (archived IS NULL OR archived = '')
        )

        ;
EOT;
      } else if ($typeOfObject == "clients") {
        $classQuery = <<<EOT
        SELECT start_time, end_time FROM classes
        WHERE
        (
        {$id} = ANY(classes.clients)
        ) AND (
        '{$date}' = date_of_class
        ) AND (
        (archived IS NULL OR archived = '')
        )

        ;
EOT;
      }


      //compile list of all events that involve the target that are on the date of concern
      $allEvents = pg_fetch_all(pg_query($db_connection, $classQuery));
      if ($horseCareShiftQuery != "") {
        $allEvents[] = pg_fetch_all(pg_query($db_connection, $horseCareShiftQuery));
      }
      if ($officeShiftQuery != "") {
        $allEvents[] = pg_fetch_all(pg_query($db_connection, $officeShiftQuery));
      }

      //Check all events for availability, return conflicting times if conflict is found
      if ($allEvents) {
        foreach ($allEvents as $key => $timePair) {
          if ($timePair) {
            if (strtotime($timePair['start_time']) < strtotime($time2) and strtotime($timePair['end_time']) > strtotime($time1)) {return array($timePair['start_time'], $timePair['end_time']);}
          }
        }
      }



    } elseif (in_array($typeOfObject, $enumTypeList)) {

      //Get all classes on date
      $allClasses = pg_fetch_all(pg_query($db_connection, "SELECT * FROM classes WHERE date_of_class = '{$date}' AND (archived IS NULL OR archived = '');"));

      //Filter by time
      if ($allClasses) {
        $allClasses2 = array();
        foreach ($allClasses as $key => $class) {
          if (strtotime($class['start_time']) < strtotime($time2) and strtotime($class['end_time']) > strtotime($time1)) {
            $allClasses2[] = $class;
          }
        }
        $allClasses = $allClasses2;
      }


      //Check if target is being used in any of these classes, return conflicting times if so
      if ($allClasses) {
        foreach ($allClasses as $key => $class) {
          if (in_array($id, $class)) {return array($class['start_time'], $class['end_time']);}
        }
      }


    }

    //If no conflicts have been found and returned, return false (which means the target IS available)
    return false;
  };


?>
