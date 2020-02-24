<?php

session_start();
include('connection.php');
if(!isset($_SESSION['username'])){
    header('location:index.php');
}

$dataPoints = array( 
	array("y" => 3373.64, "label" => "Germany" ),
	array("y" => 2435.94, "label" => "France" ),
	array("y" => 1842.55, "label" => "China" ),
	array("y" => 1828.55, "label" => "Russia" ),
	array("y" => 1039.99, "label" => "Switzerland" ),
	array("y" => 765.215, "label" => "Japan" ),
	array("y" => 612.453, "label" => "Netherlands" )
);

$query="SELECT * from inventory_all_products";
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
foreach($result as $row)
{
    if($row['quantity']>20){
        $quer="UPDATE inventory_all_products SET status='Available' WHERE id=".$row['id']." ";
        $statement7 = $connection->prepare($quer);
        $statement7->execute();
    }else if($row["quantity"]<=0){
        $quer="UPDATE inventory_all_products SET status='Not Available' WHERE id=".$row['id']." ";
        $statement7 = $connection->prepare($quer);
        $statement7->execute();
    }else if($row["quantity"]<=20){
        $quer="UPDATE inventory_all_products SET status='Low Stock' WHERE id=".$row['id']." ";
        $statement7 = $connection->prepare($quer);
        $statement7->execute();
    }
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

    <!-- Datatable -->
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />
    <link href="assets/css/morris.css" rel="stylesheet" />

    <style>
       
    </style>
    
</head>

<body>

<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
            <div class="nano">
                <div class="nano-content">
                <ul>
                        <div class="logo"><a href="index.html"><img src="assets/images/cagro1.png" alt="" /><span>CAGRO</span></a></div>
                        <li class="label">Home</li>
                        <li><a href="dashboard3.php"><i class="ti-home"></i>Dashboard</a></li>
                        <li class="label">Secretary Reports</li>
                        <li><a href="admin_beneficiary_reports_secretary.php"><i class="ti-folder"></i>Beneficiary Reports</a></li>
                        <li><a href="admin_transactional_report.php"><i class="ti-folder"></i>Transactional Reports</a></li>
                        <li><a href="admin_feedback_report.php"><i class="ti-folder"></i>Feedback Reports</a></li>
                        <li class="label">Planning Reports</li>
                        <li><a href="admin_inventory_reports.php"><i class="ti-folder"></i>Inventory Reports</a></li>
                        <li><a href="admin_planning_barangay_report.php"><i class="ti-folder"></i>Barangay Reports</a></li>
                        <li><a href="admin_planning_beneficiary_report.php"><i class="ti-folder"></i>Beneficiary Reports</a></li>
                        <li><a href="admin_planning_statistical_report.php"><i class="ti-folder"></i>Statistical Reports</a></li>
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
                                    if($statement3 = $connection->prepare('SELECT count(product_name) as num from inventory_all_products where status!="Available"')){
                                        $statement3->execute();
                                        $result3 = $statement3->fetchAll();
                                        foreach($result3 as $row3)
                                        {
                                            $count=$row3['num'];
                                        }
                                    }
                                
                                ?>
                                <i class="ti-bell"></i><span style="color:red;font-size:12px;"><b><?php 
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
                                        
                                            if($statement4 = $connection->prepare('SELECT * from inventory_all_products where status!="Available" order by created_at desc limit 3')){
                                                $statement4->execute();
                                                $result4 = $statement4->fetchAll();
                                                
                                                if(!empty($result4)){

                                                

                                                foreach($result4 as $row4)
                                                {
                                                 
                                        
                                        ?>

                                            <li>
                                                <a >
                                                    <img class="pull-left m-r-10 avatar-img" src="assets/images/avatar/notif.png" alt="" />
                                                    <div class="notification-content">
                                                        <small class="notification-timestamp pull-right"><?php echo $row4['status'] ?></small>
                                                        <div class="notification-heading"><?php echo $row4['product_name'] ?></div>
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


                <div class="row">
                            <!-- /# column -->
                            <div class="col-md-12">
                                <h5>Year:</h5>
                                    <select name="year" id="year" class="form-control">
                                        <?php 
                                            
                                            $starting_year  =2018;
                                            $ending_year = date('Y');
                                            for($starting_year; $starting_year <= $ending_year; $starting_year++) {
                                                if($starting_year == date('Y')) {
                                                    echo '<option value="'.$starting_year.'" selected="selected">'.$starting_year.'</option>';
                                                } else {
                                                    echo '<option value="'.$starting_year.'">'.$starting_year.'</option>';
                                                }
                                            } 
                                            
                                            
                                            ?>
                                    </select>
                                <div class="card back">
                                    <div class="card-body">
                                        <h3>Dashboard</h3>
                                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
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
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/morris.min.js"></script>
    <script src="js/raphael-min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="assets/js/lib/menubar/sidebar.js"></script>
    <script src="assets/js/lib/preloader/pace.min.js"></script>
    <script src="js/canvasjs.min.js"></script>
    <script src="js/moment.min.js"></script>
    

</html>

<script>
$(document).ready(function(){ 
    var interval=setInterval(function(){
        var momentNow=new moment();
        $('#datetime').html(momentNow.format('MMMM DD, YYYY')+' '+momentNow.format('dddd').substring(0,3).toUpperCase());
        $('#time').html(momentNow.format('A hh:mm:ss'));
   },100);

 fetchChart();
 function fetchChart(){
    var year=$('#year').val();
    $.ajax({
			url:"fetch_single_chart2.php",
			method:"POST",
			data:{year:year},
			dataType:"json",
			success:function(data)
			{
               var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light2",
                    zoomEnabled: true,
                    exportEnabled:true,
                    title:{
                        text: "Issued Product per Category"
                    },
                    axisY: {
                        title: "Total Stock Issued"
                    },
                    data: [{
                        type: "column",
                        yValueFormatString: "#,##0",
                        dataPoints: data
                    }]
                });
                chart.render();
			}
		});
    };

    $(document).on('change','#year',function(){
        fetchChart();
    });

    $('#logout').click(function(){
        document.location.href="logout.php";
    });
    $('#profile').click(function(){
        document.location.href="profile_admin.php";
    });
    $('#setting').click(function(){
        document.location.href="admin_setting.php";
    });
    $('#view_notif').click(function(){
        document.location.href="notification_table_inventory_admin.php";
    });


});
</script>