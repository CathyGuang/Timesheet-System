<?php
  $queryID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE workers.name = '{$QUERY_NAME}';"), 0, 1)['id'];

  $query = <<<EOT
  SELECT class_type, classes.id, date_of_class, start_time, end_time, lesson_plan, tack, special_tack, stirrup_leather_length, pad, horse, instructor, therapist, equine_specialist, leader, sidewalkers, clients FROM classes WHERE
  instructor = {$queryID} OR
  therapist = {$queryID} OR
  equine_specialist = {$queryID} OR
  leader = {$queryID} OR
  {$queryID} = ANY(sidewalkers)

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
          workers.id = ANY('{$allClasses[$key]['sidewalkers']}')
          ;
EOT;
      }

    $clients = pg_fetch_all_columns(pg_query($db_connection, $getClientsQuery));
    $sidewalkers = pg_fetch_all_columns(pg_query($db_connection, $getSidewalkersQuery));

    $allClasses[$key]['clients'] = $clients;
    $allClasses[$key]['sidewalkers'] = $sidewalkers;

    $allClasses[$key]['instructor'] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$allClasses[$key]['instructor']} ;"))['name'];
    $allClasses[$key]['therapist'] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$allClasses[$key]['therapist']} ;"))['name'];
    $allClasses[$key]['equine_specialist'] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$allClasses[$key]['equine_specialist']} ;"))['name'];
    $allClasses[$key]['leader'] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM workers WHERE id = {$allClasses[$key]['leader']} ;"))['name'];
    $allClasses[$key]['horse'] = pg_fetch_array(pg_query($db_connection, "SELECT name FROM horses WHERE id = {$allClasses[$key]['horse']} ;"))['name'];


  }

?>
