<?php 
    include('connection.php');
    $arrya=[];
    $arrya=$_POST['assis'];
    $other=$_POST['check'];
    $arr=[];
    $arr=explode(",",trim($arrya[0]));

    $arrya2=[];
    $arrya2=$_POST['ass'];
    $arr2=[];
    $arr2=explode(",",trim($arrya2[0]));
    
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
    $request_id=rand().rand().rand();
    $id=$_POST['user_id'];

    
    foreach($arr2 as $key2){
        $statement = $connection->prepare("DELETE FROM record_assistance_beneficiary WHERE service_id ='$key2'");
        $statement->execute();
   }

    foreach($arr as $key){
        $statement = $connection->prepare("CALL add_assistant(@service_id,'$id','$key','$date','$cdate','$request_id','$other')");
        $statement->execute();
   }

   echo "Data Updated Succesfully";
?>