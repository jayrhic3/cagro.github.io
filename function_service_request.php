<?php


function get_total_all_records()
{
	include('connection.php');
	$statement = $connection->prepare("SELECT * FROM request_services group by request_id");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>