<?php
  $queryID = pg_fetch_array(pg_query($db_connection, "SELECT id FROM workers WHERE workers.name = '{$QUERY_NAME}';"), 0, 1)['id'];

  $query = <<<EOT
  SELECT class_type, date_of_class, classes.id, clients FROM classes WHERE
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

  $getClientsQuery = <<<EOT
    SELECT clients.name FROM clients WHERE
    clients.id = ANY('{$allClasses[0]['clients']}')
    ;
EOT;
  $clients = pg_fetch_all_columns(pg_query($db_connection, $getClientsQuery));

  foreach ($allClasses as $key => $specificClass) {
    $allClasses[$key]['clients'] = $clients;
  }

?>
