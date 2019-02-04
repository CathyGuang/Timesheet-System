<?php

  function checkAvailability($id, $typeOfObject, $date, $time1, $time2) {
    //ignore calls for empty fields
    if ($id == "") {return false;}
    //connect to database
    include $_SERVER['DOCUMENT_ROOT']."/static/scripts/initialization.php";


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
      //ignore calls to check empty fields/null values
      $name = pg_fetch_row(pg_query($db_connection, "SELECT name FROM {$typeOfObject} WHERE id = '{$id}';"))[0];
      if (!$name) {return false;}


      $classQuery = "";
      $horseCareShiftQuery = "";
      $officeShiftQuery = "";

      if ($typeOfObject == "workers") {
        $classQuery = <<<EOT
        SELECT start_time, end_time, value FROM classes, jsonb_each_text(classes.staff)
        WHERE
        (
        '{$id}' = value
        ) AND (
        '{$date}' = date_of_class
        ) AND (
        (archived IS NULL OR archived = '')
        )

        UNION ALL

        SELECT start_time, end_time, value FROM classes, jsonb_each_text(classes.volunteers)
        WHERE
        (
        '{$id}' = value
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
        SELECT start_time, end_time, clients FROM classes
        WHERE
        (
        {$id} = ANY(classes.horses)
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
        {$id} = horse_care_shifts.horse
        ) AND (
        '{$date}' = date_of_shift
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


      // Compile list of all events that involve the target that are on the date of concern
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
            if (strtotime($timePair['start_time']) < strtotime($time2) and strtotime($timePair['end_time']) > strtotime($time1)) {
              return array($timePair['start_time'], $timePair['end_time']);
            }
          }
        }

        echo "<br>AllEvents:  ";
        var_dump($allEvents);
        //Check if horse is maxed out on uses for the day
        if ($typeOfObject == "horses") {
          $orgUseCount = 0;
          $ownerUseCount = 0;
          $horseInfo = pg_fetch_all(pg_query($db_connection, "SELECT * FROM horses WHERE id = {$id} AND (archived IS NULL OR archived = '');"))[0];

          foreach ($allEvents as $eventInfo) {
            $clientNames = pg_fetch_all_columns(pg_query($db_connection, "SELECT name FROM clients WHERE id = ANY('{$eventInfo['clients']}');"));
            if (in_array($horseInfo['owner'], $clientNames)) {
              $ownerUseCount++;
            } else {
              $orgUseCount++;
            }
          }

          if ($orgUseCount >= $horseInfo['org_uses_per_day'] && !in_array($horseInfo['owner'], $_POST['clients'])) {
            return "{$horseInfo['name']} is already being used {$horseInfo['org_uses_per_day']} times on {$date} by {$organizationName}!";
          }
          if ($ownerUseCount >= $horseInfo['owner_uses_per_day'] && in_array($horseInfo['owner'], $_POST['clients'])) {
            return "{$horseInfo['name']} is already being used {$horseInfo['owner_uses_per_day']} times on {$date} by their owner ({$horseInfo['owner']})!";
          }


          //Check if horse is maxed out on uses for the week
          $date1 = Date('Y-m-d', strtotime('last monday', strtotime($date . '+ 1 day')));
          $date2 = Date('Y-m-d', strtotime($date1 . '+ 1 week'));
          //Count horse uses during the time period
          $totalHorseUses = getHorseUsesByDateRange($horseInfo['id'], $date1, $date2);

          if ($totalHorseUses >= $horseInfo['horse_uses_per_week']) {
            return "{$horseInfo['name']} is already being used {$horseInfo['horse_uses_per_week']} times between {$date1} and {$date2}!";
          }
        }


      }




    } elseif (in_array($typeOfObject, $enumTypeList)) {
      //Ignore calls to check empty fields/null values
      if (!$id) {return false;}

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
          foreach ($class as $subString) {
            if (strpos($subString, $id)) {return array($class['start_time'], $class['end_time']);}
          }
        }
      }


    }

    //If no conflicts have been found and returned, return false (which means the target IS available)
    return false;
  };


?>
