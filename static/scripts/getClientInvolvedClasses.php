<?php
  $queryID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM clients WHERE name = '{$QUERY_NAME}' AND (archived IS NULL OR archived = '');"), 0, 1)['id'];

  $query = <<<EOT
  SELECT class_type, classes.id, cancelled, date_of_class, start_time, end_time, lesson_plan, tacks, special_tack, stirrup_leather_length, pads, horses, instructor, therapist, equine_specialist, leaders, sidewalkers, clients FROM classes WHERE
  {$queryID} = ANY(clients) AND
  (archived IS NULL OR archived = '')
  ;
EOT;

  $result = pg_query($db_connection, $query);

  $allClasses = pg_fetch_all($result);

  if (!$allClasses) {return;}

  foreach ($allClasses as $key => $specificClass) {
    $getClientsQuery = <<<EOT
      SELECT clients.name FROM clients WHERE
      clients.id = ANY('{$allClasses[$key]['clients']}')
      ;
EOT;
      if ($specificClass['sidewalkers']) {
        $getSidewalkersQuery = <<<EOT
          SELECT workers.name FROM workers WHERE
          workers.id = ANY('{$allClasses[$key]['sidewalkers']}') AND
          (archived IS NULL OR archived = '')
          ;
EOT;
      }
      if ($specificClass['horses']) {
        $getHorsesQuery = <<<EOT
          SELECT name FROM horses WHERE
          id = ANY('{$allClasses[$key]['horses']}') AND
          (archived IS NULL OR archived = '')
          ;
EOT;
      }
      if ($specificClass['leaders']) {
        $getLeadersQuery = <<<EOT
          SELECT workers.name FROM workers WHERE
          workers.id = ANY('{$allClasses[$key]['leaders']}') AND
          (archived IS NULL OR archived = '')
          ;
EOT;
      }

    $clients = pg_fetch_all_columns(pg_query($db_connection, $getClientsQuery));
    $sidewalkers = pg_fetch_all_columns(pg_query($db_connection, $getSidewalkersQuery));
    $horses = pg_fetch_all_columns(pg_query($db_connection, $getHorsesQuery));
    $leaders = pg_fetch_all_columns(pg_query($db_connection, $getLeadersQuery));

    $allClasses[$key]['clients'] = $clients;
    $allClasses[$key]['sidewalkers'] = $sidewalkers;

    $allClasses[$key]['instructor'] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$allClasses[$key]['instructor']} ;"))['name'];
    $allClasses[$key]['therapist'] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$allClasses[$key]['therapist']} ;"))['name'];
    $allClasses[$key]['equine_specialist'] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$allClasses[$key]['equine_specialist']} ;"))['name'];
    $allClasses[$key]['leaders'] = $horses;
    $allClasses[$key]['horses'] = $leaders;

    $allClasses[$key]['tacks'] = explode(',', rtrim(ltrim($allClasses[$key]['tacks'], '{'), '}'));
    $allClasses[$key]['pads'] = explode(',', rtrim(ltrim($allClasses[$key]['pads'], '{'), '}'));



  }

?>
