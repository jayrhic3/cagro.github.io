<?php


function get_total_all_records()
{
	include('connection.php');
	$statement = $connection->prepare("SELECT * FROM recent_request WHERE other ='check'");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>