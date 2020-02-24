<?php
include('connection.php');
        $id=0;
        $id=$_POST['u_id'];
        $username=$_POST['username'];
        $gender=$_POST['gender'];
        $firstname=$_POST['firstname'];
        $lastname=$_POST['lastname'];
        $middlename=$_POST['middlename'];
        $purok=$_POST['purok'];
        $barang=$_POST['barang'];
        $muni=$_POST['muni'];
        $bday=$_POST['bday'];
        $mobnum=$_POST['mobnum'];

		$query="UPDATE users SET username = '$username',gender='$gender',firstname='$firstname',
        lastname='$lastname',middlename='$middlename',purok='$purok',barangay='$barang',municipality='$muni',
        bday='$bday',mobnum='$mobnum' WHERE id = $id";
		$statement = $connection->prepare($query);
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Updated Successfuly!';
		}else{
			echo "Unsuccessful!";
		}
	
?>