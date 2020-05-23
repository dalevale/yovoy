<?php 
    require_once __DIR__.'/includes/config.php';
?>

<?php

$connect = new PDO('mysql:host=localhost; dbname=yovoy_db; charset=utf8', 'root', '');

$data = array();

$query = "SELECT * FROM event ORDER BY event_id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   		=> $row["event_id"],
  'title'   	=> $row["name"],
  'start'   	=> $row["event_date"],
  'locat' 		=> $row["location"],
  'eventInfo'	=> $row["description"],
  'eventCap' 	=> $row["capacity"]
 );
}

echo json_encode($data);

?>