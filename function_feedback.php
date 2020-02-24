<?php


function get_total_all_records()
{
	include('connection.php');
	$statement = $connection->prepare("SELECT * FROM comment_recommendation");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>