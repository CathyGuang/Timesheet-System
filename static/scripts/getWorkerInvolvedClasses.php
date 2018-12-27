<?php
  if ($QUERY_NAME == "ALL") {
    $query = <<<EOT
    SELECT DISTINCT class_type, classes.id, cancelled, date_of_class, start_time, end_time, lesson_plan, tacks, special_tack, stirrup_leather_length, pads, horses, staff, leaders, sidewalkers, clients, attendance FROM classes;
EOT;
  } else {
    $queryID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE workers.name = '{$QUERY_NAME}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

    $query = <<<EOT
    SELECT DISTINCT class_type, classes.id, cancelled, date_of_class, start_time, end_time, lesson_plan, tacks, special_tack, stirrup_leather_length, pads, horses, staff, leaders, sidewalkers, clients, attendance
    FROM classes, jsonb_each_text(classes.staff) WHERE
    (
    '{$queryID}' = value OR
    {$queryID} = ANY(leaders) OR
    {$queryID} = ANY(sidewalkers)
    ) AND (
    (archived IS NULL OR archived = '')
    )

    ;
EOT;
  }

  $result = pg_query($db_connection, $query);

  $allClasses = pg_fetch_all($result);

  if (!$allClasses) {return;}


  foreach ($allClasses as $key => $specificClass) {

    $getClientsQuery = <<<EOT
      SELECT id, clients.name FROM clients WHERE
      clients.id = ANY('{$allClasses[$key]['clients']}')
      ;
EOT;
    $getAttendanceQuery = <<<EOT
      SELECT clients.name FROM clients WHERE
      clients.id = ANY('{$allClasses[$key]['attendance']}')
      ;
EOT;
      if ($specificClass['sidewalkers']) {
        $getSidewalkersQuery = <<<EOT
          SELECT id, workers.name FROM workers WHERE
          workers.id = ANY('{$allClasses[$key]['sidewalkers']}') AND
          (archived IS NULL OR archived = '')
          ;
EOT;
      }
      if ($specificClass['horses']) {
        $getHorsesQuery = <<<EOT
          SELECT id, name FROM horses WHERE
          id = ANY('{$allClasses[$key]['horses']}') AND
          (archived IS NULL OR archived = '')
          ;
EOT;
      }
      if ($specificClass['leaders']) {
        $getLeadersQuery = <<<EOT
          SELECT id, workers.name FROM workers WHERE
          workers.id = ANY('{$allClasses[$key]['leaders']}') AND
          (archived IS NULL OR archived = '')
          ;
EOT;
      }

    $clients = pg_fetch_all_columns(pg_query($db_connection, $getClientsQuery));

    $attendance = pg_fetch_all_columns(pg_query($db_connection, $getAttendanceQuery));

    $sidewalkers = pg_fetch_all_columns(pg_query($db_connection, $getSidewalkersQuery));

    $horses = pg_fetch_all_columns(pg_query($db_connection, $getHorsesQuery));

    $leaders = pg_fetch_all_columns(pg_query($db_connection, $getLeadersQuery));


    var_dump($allClasses[$key]['clients']);


    $allClasses[$key]['clients'] = $clients;
    $allClasses[$key]['attendance'] = $attendance;
    $allClasses[$key]['sidewalkers'] = $sidewalkers;

    $rawArray = explode(",", ltrim(rtrim($allClasses[$key]['staff'], '}'), '{'));
    $allClasses[$key]['staff'] = array();
    foreach ($rawArray as $roleIDString) {
      $roleIDString = trim($roleIDString);
      $role = rtrim(ltrim(explode(':', $roleIDString)[0], '"'), '"');
      $staffID = trim(explode(':', $roleIDString)[1]);
      $allClasses[$key]['staff'][$role] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$staffID} ;"))['name'];
    }


    $allClasses[$key]['leaders'] = $leaders;
    $allClasses[$key]['horses'] = $horses;

    $allClasses[$key]['tacks'] = explode(',', rtrim(ltrim($allClasses[$key]['tacks'], '{'), '}'));
    $allClasses[$key]['pads'] = explode(',', rtrim(ltrim($allClasses[$key]['pads'], '{'), '}'));



    echo "<br>FINAL FORMATTING:<br>";
    var_dump($allClasses[$key]['leaders']);
    var_dump($allClasses[$key]['sidewalkers']);

  }



?>
