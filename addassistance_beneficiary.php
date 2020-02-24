<?php 
    session_start();
    include('connection.php');
    $arrya=$_POST['assis'];
    $id=$_POST['user_id'];
    $other=$_POST['check'];
    $arr=[];
    $arr=explode(",",trim($arrya[0]));
    $count=0;
    $count2=0;
    $date=date('Y-m-d H:i:s');
	$cdate=date('F j, Y',strtotime($date));
    
    $request_id=rand().rand().rand();
    $_SESSION["request_id"]=$request_id;


            $query2="SELECT description FROM assistance";
			$statement2 = $connection->prepare($query2);
			$statement2->execute();
			$result2 = $statement2->fetchAll();
			foreach($result2 as $row2)
			{
				if(strtoupper($arr[0])==strtoupper($row2["description"])){
					$count2+=1;
				}
            }
        if($count2==0){
            $query4="INSERT INTO assistance(description) values('$arr[0]')";
            $statement4 = $connection->prepare($query4);
            $statement4->execute();
        }

        foreach($arr as $key){
            if($key=='Agri Supplies'||$key=='Technical Assistance'||$key=='Farm Mechanization'){
                 $count+=1;
                 $other='';
            }else{
                 $count=0;
                 $other='check';
            }
            $statement = $connection->prepare("CALL add_assistant(@service_id,'$id','$key','$date','$cdate','$request_id','$other')");
            $statement->execute();
        }
        

   echo "Data Saved Succesfully";
?>