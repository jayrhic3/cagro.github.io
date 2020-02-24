<?php

//load.php
include('connection.php');
$data = array();

$query = "SELECT * FROM project_program ORDER BY id";

$statement = $connection->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'des'   => $row["descrip"],
  'barang'   => $row["barangay"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}

echo json_encode($data);

?>
