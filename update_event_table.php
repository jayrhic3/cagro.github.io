<?php
include('connection.php');

        $id=$_POST['user_id'];
        $pro_name=$_POST['pro_name'];
        $pro_location=$_POST['pro_location'];
        $total_b=$_POST['total_b'];
        $fiscal=$_POST['fiscal'];
        $proj_i=$_POST['proj_i'];
        $labor=$_POST['labor'];

		$query="UPDATE project_program SET title = '$pro_name',project_location ='$pro_location',total_budget ='$total_b',
        fiscal_year ='$fiscal',project_incharge ='$proj_i',labor='$labor' WHERE id = $id";
		$statement = $connection->prepare($query);
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Succesfully Updated';
		}else{
			echo "wrong";
		}
	
?>