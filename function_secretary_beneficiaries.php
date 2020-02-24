<?php


function get_total_all_records()
{
	include('connection.php');
	$statement = $connection->prepare("SELECT * FROM beneficiaries");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>