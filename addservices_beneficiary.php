<?php 
session_start();
    include('connection.php');
    $arrya=$_POST['assis'];
    $id=$_POST['user_id'];
    $service_id=$_POST['service_id'];
    $arr=[];
    $arr=explode(",",trim($arrya[0]));

    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
    $request_id="";
    $request_id.=rand().rand().rand();
    $_SESSION["request_id"]=$request_id;

    foreach($arr as $key){
        $statement = $connection->prepare("CALL add_services(@service_id,'$id','$key','$date','$cdate','$request_id','$service_id')");
        $statement->execute();
   }

   echo "Data Saved Succesfully";
?>