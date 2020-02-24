<?php
include('connection.php');
    $output = array();
    $id=$_POST['id'];
    $newpass=$_POST['newpass'];
    $oldpass=$_POST['oldpass'];
    $mix="";
    $query="SELECT * FROM users WHERE id = $id LIMIT 1";
	$statement = $connection->prepare( $query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
        $output["password"] = $row["password"];
        $output["salt"] = $row["salt"];

        $mix.=$output["salt"];
        $mix.=$newpass;
        $passhash = password_hash($mix."DNSC_SECURITY", PASSWORD_DEFAULT);

        $query2="UPDATE users SET password='$passhash' WHERE id=$id";
        $statement2 = $connection->prepare( $query2);
        $statement2->execute();
        $output["error"]="Password Updated";
    }
	echo json_encode($output);
?>