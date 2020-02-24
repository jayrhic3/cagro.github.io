<?php

session_start();
include('connection.php');
if(!isset($_SESSION['username'])){
    header('location:index.php');
}

require __DIR__ . '/twilio-php-master/src/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'ACbc55e14f0e3e6de49f0de0f40ad7a0cc';
$token = '8239218b9d0d5b2a2fb6a74c1f5781bb';
$client = new Client($sid, $token);

$number=array();
$query5="SELECT mobnum from beneficiaries";
$statement5 = $connection->prepare($query5);
$statement5->execute();
$result5 = $statement5->fetchAll();
foreach($result5 as $row)
{
   $temp=substr($row['mobnum'],1);
   $number[]='+63'.$temp;
}

$connected=@fsockopen("www.google.com",80);
if($connected){
    $query6="SELECT * from notification";
    $statement6 = $connection->prepare($query6);
    $statement6->execute();
    $result6 = $statement6->fetchAll();
    foreach($result6 as $row)
    {
        if($row['sms_stat']==''){
            foreach($number as $key){
                $client->messages->create(
                    $key,
                    array(
                        'from' => '+19182356752',
                        'body' => "Hi dear Beneficiary we would you to inform that ther will be a ".$row["title"]." conducted in Cagro Office today."
                    )
                );
            }
            $query7='UPDATE project_program set sms_stat="Sent" where id='.$row["id"].'';
            $statement7 = $connection->prepare($query7);
            $statement7->execute();
        }
    }
}else{
   
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cagro Information System</title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link type="image/x-icon" href="assets/images/cagro5.png" rel="shortcut icon">
    
    

    <!-- Common -->
    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/helper.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="js/fullcalendar.css" rel="stylesheet">
   

    <!-- Datatable -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />
    <script src="js/moment.min.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" />
    <style>
        .back{
            background:skyblue;
        }
    </style>
    
</head>

<body>

<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                    <ul>
                        <div class="logo"><a href="index.html"><img src="assets/images/cagro1.png" alt="" /><span>CAGRO</span></a></div>
                        <li class="label">Home</li>
                        <li><a href="dashboard.php"><i class="ti-home"></i>Dashboard</a></li>
                        <li><a href="secretary.php"><i class="ti-user"></i>Beneficiaries</a></li>
                        <li><a href="recent_request.php"><i class="ti-bell"></i>Requests</a></li>
                        <li><a class="sidebar-sub-toggle"><i class="ti-panel"></i> Records <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                            <li><a href="planning_agrisupplies.php"><i class="ti-folder"></i>Agri Supplies</a></li>
                            <li><a href="planning_technical_assistance.php"><i class="ti-folder"></i>Technical Assistance</a></li>
                            <li><a href="planning_farm_mechanization.php"><i class="ti-folder"></i>Farm Mechanization</a></li>
                            <li><a href="planning_other_assistance.php"><i class="ti-folder"></i>Other Assistance</a></li>
                            </ul>
                        </li>
                        <li class="label">Events</li>
                        <li><a href="project_programs.php"><i class="ti-calendar"></i>Activities</a></li>
                        <li class="label">Reports</li>
                        <li><a href="ongoing_bene_record__secretary.php"><i class="ti-folder"></i>Beneficiary Reports</a></li>
                        <li><a href="transaction_report_secretary.php"><i class="ti-folder"></i>Transaction Report</a></li>
                        <li><a href="feedback_report_secretary.php"><i class="ti-folder"></i>Feedback Report</a></li>
                    </ul>
                </div>
            </div>
        </div>
    <!-- /# sidebar -->


    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="float-left">
                        <h4 id="datetime"></h4>
                        <h5 id="time"></h5>
                    </div>
                    <div class="float-right">
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <?php 
                                    $count;
                                    if($statement = $connection->prepare('SELECT COUNT(title) as num from notification WHERE event_status="Unread"')){
                                        $statement->execute();
                                        $result = $statement->fetchAll();
                                        foreach($result as $row)
                                        {
                                            $count=$row['num'];
                                        }
                                    }
                                
                                ?>
                                <i class="ti-alarm-clock"></i><span style="color:red;font-size:12px;"><b><?php 
                                if($count==0){
                                    echo "";
                                }else{
                                echo $count; 
                                }
                                
                                ?></b></span>
                                <div class="drop-down dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-content-heading">
                                        <span class="text-left">Recent Notifications</span>
                                    </div>
                                    <div class="dropdown-content-body">
                                        <ul>

                                        <?php 
                                        
                                            if($statement = $connection->prepare('SELECT * from notification order by start_event desc limit 3')){
                                                $statement->execute();
                                                $result = $statement->fetchAll();
                                                
                                                if(!empty($result)){

                                                

                                                foreach($result as $row)
                                                {
                                                 
                                        
                                        ?>

                                            <li>
                                                <a >
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/notif.png" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right"><?php echo $row['event_status'] ?></small>
                                                        <div class="notification-heading"><?php echo $row['title'] ?></div>
                                                    </div>
                                                </a>
                                            </li>

                                        <?php 
                                        
                                            }

                                            echo '<li class="text-center">
                                            <a href="#" id="view_notif" class="more-link">See All</a>
                                        </li>';
                                        }else{
                                            echo '<li class="text-center">
                                            <a href="#" >No Nofication</a>
                                                </li>';
                                        }
                                    }
                                        
                                        
                                        ?>
                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="dropdown dib">
                            <div class="header-icon" data-toggle="dropdown">
                                <span class="user-avatar"><?php echo $_SESSION["username"]; ?>
                                    <i class="ti-angle-down f-s-10"></i>
                                </span>
                                <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                              
                                    <div class="dropdown-content-body">
                                        <ul>
                                            <li>
                                                <a id="profile">
                                                    <i class="ti-user"></i>
                                                    <span>Profile</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a id="setting">
                                                    <i class="ti-settings"></i>
                                                    <span>Setting</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a id="logout">
                                                    <i class="ti-power-off"></i>
                                                    <span>Logout</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
              
                <!-- /# row -->
                
                <div class="row" id="show_table">
                            <!-- /# column -->
                            <div class="col-lg-12">
                                <div class="card">
                                <div class="card-body">
                                <h3>Notifications</h3><br>
                                    <div class="table-responsive">
                                                <table id="user_data" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Event Name</th>
                                                            <th >Event Date</th>
                                                            <th>Status</th>
                                                            <th width="5%">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                        </div>
                                </div>
                                </div>
                            </div>
                           
                        </div>

                        <div class="row" id="view_event">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="form_event">
                                            <h3>Event</h3>
                                            <div class="row">
                                                <div class="col-lg-12"> 
                                                    <div class="form-group">
                                                        <label >Project Name</label>
                                                        <input type="text" class="form-control" id="pro_name" name="pro_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6"> 
                                                    <div class="form-group">
                                                        <label >Start Event</label>
                                                        <input type="text" class="form-control" id="start_e" name="start_e">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label >End Event</label>
                                                        <input type="text" class="form-control" id="end_e" name="end_e">
                                                    </div>
                                                </div>   
                                            </div>
                                    
                                            <div class="row">
                                                <div class="col-lg-12" align="right">
                                                        <input type="hidden" id="user_id" name="user_id">
                                                        <input type="button" id="close_form" value="Close" class="btn btn-default">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="footer">
                                    <p>2019 © DAVAO DEL NORTE STATE COLLEGE - INSTITUTE OF INFORMATION TECHNOLOGY. - <a href="www.dnsc.edu.ph">www.dnsc.edu.ph</a></p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>



    <!-- Common -->
   

</body>
   
    <script src="js/scripts.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="assets/js/lib/menubar/sidebar.js"></script>
    <script src="assets/js/lib/preloader/pace.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/moment.min.js"></script>
    
    

</html>

<script>
$(document).ready(function(){
    var interval=setInterval(function(){
        var momentNow=new moment();
        $('#datetime').html(momentNow.format('MMMM DD, YYYY')+' '+momentNow.format('dddd').substring(0,3).toUpperCase());
        $('#time').html(momentNow.format('A hh:mm:ss'));
   },100);

    $('#view_event').hide();
    $('#show_table').show();

    $('#logout').click(function(){
        document.location.href="logout.php";
    });
    $('#profile').click(function(){
        document.location.href="profile_secretary.php";
    });
    $('#setting').click(function(){
        document.location.href="setting.php";
    });

    $('#view_notif').click(function(){
        document.location.href="notification_table.php";
    });

    $('#close_form').click(function(){
        $('#view_event').hide();
        $('#show_table').show();
    });

    $(document).on('click', '.check', function(){
		var user_id = $(this).attr("id");
		$.ajax({
			url:"fetch_single_notification.php",
			method:"POST",
			data:{user_id:user_id},
			dataType:"json",
			success:function(data)
			{
				$('#view_event').show();
                $('#show_table').hide();

				$('#pro_name').val(data.title);
                $('#start_e').val(data.start_event);
                $('#end_e').val(data.end_event);
				$('#user_id').val(user_id);
                dataTable.ajax.reload();
			}
		})
	});


    var dataTable = $('#user_data').DataTable({
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
        url:"fetch_program_notification.php",
        type:"POST"
    },
    "columnDefs":[
        {
            "targets":[0, 3, 3],
            "orderable":false,
        },
    ],

});
    
    
});
</script>