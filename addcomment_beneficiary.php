<?php 
    include('connection.php');
    $user_id=$_POST['user_id'];
    $ass=$_POST['ass'];
    $rate=$_POST['rate'];
    $comment=$_POST['comment'];

    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
        
    $statement = $connection->prepare("INSERT into comment_recommendation(beneficiary_id,assistance_received,rating,comment,created_at,word_created) 
    values('$user_id','$ass','$rate','$comment','$date','$cdate')");
    $statement->execute();
   

   echo "Data Inserted Succesfully";
?>