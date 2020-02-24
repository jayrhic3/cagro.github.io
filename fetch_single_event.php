<?php
include('connection.php');
if(isset($_POST["user_id"]))
{
    $output=array();
    $id=$_POST['user_id'];
    $query="SELECT * FROM project_program WHERE id=$id";
	$statement = $connection->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
        $output["title"] = $row["title"];
        $output["project_location"] = $row["project_location"];
        $output["total_budget"] = $row["total_budget"];
        $output["fiscal_year"] = $row["fiscal_year"];
        $output["project_incharge"] = $row["project_incharge"];
        $output["labor"] = $row["labor"];
	}
	echo json_encode($output);
}
?>