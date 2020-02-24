<?php
include('connection.php');
    $output1 = 'All,';
	$output=array();
    $muni=$_POST['muni'];
    if($muni=='Tagum City'){
        $query="SELECT * FROM barangay WHERE id=10";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Asuncion'){
        $query="SELECT * FROM barangay WHERE id=1";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Braulio E. Dujali'){
        $query="SELECT * FROM barangay WHERE id=2";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Carmen'){
        $query="SELECT * FROM barangay WHERE id=3";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Kapalong'){
        $query="SELECT * FROM barangay WHERE id=4";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='New Corella'){
        $query="SELECT * FROM barangay WHERE id=5";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Panbo City'){
        $query="SELECT * FROM barangay WHERE id=6";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
    else if($muni=='Samal'){
        $query="SELECT * FROM barangay WHERE id=7";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
    else if($muni=='San Isidro'){
        $query="SELECT * FROM barangay WHERE id=8";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Santo Tomas'){
        $query="SELECT * FROM barangay WHERE id=9";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Talaingod'){
        $query="SELECT * FROM barangay WHERE id=11";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Compostela'){
        $query="SELECT * FROM barangay WHERE id=12";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Laak'){
        $query="SELECT * FROM barangay WHERE id=13";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Mabini'){
        $query="SELECT * FROM barangay WHERE id=14";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Maco'){
        $query="SELECT * FROM barangay WHERE id=15";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Maragusan'){
        $query="SELECT * FROM barangay WHERE id=16";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Mawab'){
        $query="SELECT * FROM barangay WHERE id=17";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Monkayo'){
        $query="SELECT * FROM barangay WHERE id=18";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Montevista'){
        $query="SELECT * FROM barangay WHERE id=19";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Nabunturan'){
        $query="SELECT * FROM barangay WHERE id=20";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='New Bataan'){
        $query="SELECT * FROM barangay WHERE id=21";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}
	else if($muni=='Pantukan'){
        $query="SELECT * FROM barangay WHERE id=22";
	    $statement = $connection->prepare($query);
	    $statement->execute();
	    $result = $statement->fetchAll();
	    foreach($result as $row)
	    {
		    $output1.= $row["description"].",";
	    }
	}

    $output["barangay"]=$output1;
	echo json_encode($output);

?>