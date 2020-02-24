<?php

//insert.php

include('connection.php');
require __DIR__ . '/twilio-php-master/src/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

if(isset($_POST["title"]))
{
    $title=$_POST['title'];
    $des=$_POST['des'];
    $barang=$_POST['barang'];
    $start=$_POST['start'];
    $end=$_POST['end'];

    $wordstart=date('F j, Y',strtotime($start));
    $wordend=date('F j, Y',strtotime($end));
    
 $query = "INSERT INTO project_program 
 (title, start_event, end_event,start_event_word,end_event_word,event_status,descrip,barangay) 
 VALUES (:title, :start_event, :end_event,:wordstart,:wordend,:event_status,:descrip,:barangay)";
 $statement = $connection->prepare($query);
 $statement->execute(
  array(
   ':title'  => $title,
   ':start_event' => $start,
   ':end_event' => $end,
   ':wordstart' => $wordstart,
   ':wordend' => $wordend,
   ':barangay' => $barang,
   ':event_status' => "Unread",
   ':descrip' => $des
  )
 );


// Your Account SID and Auth Token from twilio.com/console
$sid = 'ACbc55e14f0e3e6de49f0de0f40ad7a0cc';
$token = '8239218b9d0d5b2a2fb6a74c1f5781bb';
$client = new Client($sid, $token);

$number=array();
if($barang=='All'){
    $query5="SELECT mobnum from beneficiaries";
    $statement5 = $connection->prepare($query5);
    $statement5->execute();
    $result5 = $statement5->fetchAll();
    foreach($result5 as $row)
    {
    $temp=substr($row['mobnum'],1);
    $number[]='+63'.$temp;
    }
}else{
    $query5="SELECT mobnum from beneficiaries where barangay='$barang'";
    $statement5 = $connection->prepare($query5);
    $statement5->execute();
    $result5 = $statement5->fetchAll();
    foreach($result5 as $row)
    {
    $temp=substr($row['mobnum'],1);
    $number[]='+63'.$temp;
    }
}

$connected=@fsockopen("www.google.com",80);
if($connected){
    foreach($number as $key){
        $client->messages->create(
            $key,
            array(
                'from' => '+19182356752',
                'body' => "Hi dear Beneficiary we would you to inform that ther will be a ".$title." conducted in Cagro Office on ".date('F j, Y',strtotime($start))
            )
        );
    }
}else{
   
}



}


?>
