<?php
include('connection.php');
include('function_upload.php');
if(isset($_POST["operation"]))
{
		$id=$_POST['use_id'];
		$image = '';
		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}
		$query="UPDATE users SET profiles = '$image' WHERE id = '$id'";
		$statement = $connection->prepare($query);
		$result = $statement->execute();
		if(!empty($result))
		{
			echo 'Succesfully Uploaded';
		}else{
			echo "wrong";
		}
	
}else{
    echo 'wrong';
}
?>