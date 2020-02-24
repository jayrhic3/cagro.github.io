<?php 

include('connection.php');

    $datefrom=$_POST['datefrom'];
    $dateto=$_POST['dateto'];

    $count=0;
	$query2="SELECT count(distinct beneficiary_id) as coun from record_assistance_beneficiary WHERE DATE_FORMAT(created_at,'%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto' group by month(created_at)";
	$statement2 = $connection->prepare($query2);
	$statement2->execute();
	$result2 = $statement2->fetchAll();

	foreach($result2 as $row2)
	{
		$count+=intval($row2['coun']);
	}


    echo $count;




?>