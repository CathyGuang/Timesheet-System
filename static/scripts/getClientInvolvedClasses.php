<?php
  $queryID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM clients WHERE name = '{$QUERY_NAME}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

  $query = <<<EOT
  SELECT class_type, display_title, classes.id, cancelled, date_of_class, start_time, end_time, lesson_plan, tacks, special_tack, stirrup_leather_length, pads, horses, staff, leaders, sidewalkers, clients, attendance FROM classes WHERE
  {$queryID} = ANY(clients) AND
  (archived IS NULL OR archived = '')
  ;
EOT;

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

    $clients = pg_fetch_all(pg_query($db_connection, $getClientsQuery));
    $attendance = pg_fetch_all_columns(pg_query($db_connection, $getAttendanceQuery));
    $sidewalkers = pg_fetch_all(pg_query($db_connection, $getSidewalkersQuery));
    $horses = pg_fetch_all(pg_query($db_connection, $getHorsesQuery));
    $leaders = pg_fetch_all(pg_query($db_connection, $getLeadersQuery));


    $clientOrder = explode(',', rtrim(ltrim($allClasses[$key]['clients'], '{'), '}'));
    $sidewalkerOrder = explode(',', rtrim(ltrim($allClasses[$key]['sidewalkers'], '{'), '}'));
    $horseOrder = explode(',', rtrim(ltrim($allClasses[$key]['horses'], '{'), '}'));
    $leaderOrder = explode(',', rtrim(ltrim($allClasses[$key]['leaders'], '{'), '}'));

    $allClasses[$key]['clients'] = array();
    foreach ($clientOrder as $id) {
      foreach ($clients as $clientData) {
        if ($clientData['id'] == $id) {
          $allClasses[$key]['clients'][] = $clientData['name'];
        }
      }
    }

    $allClasses[$key]['attendance'] = $attendance;


    $allClasses[$key]['sidewalkers'] = array();
    foreach ($sidewalkerOrder as $id) {
      foreach ($sidewalkers as $sidewalkerData) {
        if ($sidewalkerData['id'] == $id) {
          $allClasses[$key]['sidewalkers'][] = $sidewalkerData['name'];
        }
      }
    }

    $allClasses[$key]['horses'] = array();
    foreach ($horseOrder as $id) {
      foreach ($horses as $horseData) {
        if ($horseData['id'] == $id) {
          $allClasses[$key]['horses'][] = $horseData['name'];
        }
      }
    }

    $allClasses[$key]['leaders'] = array();
    foreach ($leaderOrder as $id) {
      foreach ($leaders as $leaderData) {
        if ($leaderData['id'] == $id) {
          $allClasses[$key]['leaders'][] = $leaderData['name'];
        }
      }
    }


    $rawArray = explode(",", ltrim(rtrim($allClasses[$key]['staff'], '}'), '{'));
    $allClasses[$key]['staff'] = array();
    foreach ($rawArray as $roleIDString) {
      $roleIDString = trim($roleIDString);
      $role = rtrim(ltrim(explode(':', $roleIDString)[0], '"'), '"');
      $staffID = trim(explode(':', $roleIDString)[1]);
      $allClasses[$key]['staff'][$role] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$staffID} ;"))['name'];
    }


    $allClasses[$key]['tacks'] = explode(',', rtrim(ltrim($allClasses[$key]['tacks'], '{'), '}'));
    $allClasses[$key]['pads'] = explode(',', rtrim(ltrim($allClasses[$key]['pads'], '{'), '}'));



  }

?>
