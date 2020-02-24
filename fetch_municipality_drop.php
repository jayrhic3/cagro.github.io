<?php
include('connection.php');
    $output1 = ',';
	$output=array();
    $province=$_POST['province'];
    if($province=='Davao del Norte'){
        $query="SELECT * FROM municipality WHERE id=9";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	if($province=='Compostela Valley'){
        $query="SELECT * FROM municipality WHERE id=7";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
    }
    
	$output["municipality"]=$output1;
	echo json_encode($output);

?>