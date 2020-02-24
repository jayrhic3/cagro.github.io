<?php
include('connection.php');
if(isset($_POST["user_id"]))
{
    $output=array();
    $id=$_POST['user_id'];
    $query="SELECT * FROM notification WHERE id=$id";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
        $output["title"] = $row["title"];
        $output["start_event"]=$row["start_word"];
        $output["end_event"]=$row["end_word"];
    }
    $query2="UPDATE project_program SET event_status='Read' WHERE id=$id";
    $statement2 = $connection->prepare($query2);
	$statement2->execute();
	echo json_encode($output);
}
?>