<?php


function get_total_all_records()
{
	include('connection.php');
	$statement = $connection->prepare("SELECT * FROM record_assistance_beneficiary ");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>