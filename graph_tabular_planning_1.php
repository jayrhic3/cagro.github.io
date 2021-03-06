<?php

session_start();
include('connection.php');

if(!isset($_SESSION['username'])){
    header('location:index.php');
}



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
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <!-- Datatable -->
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />
    <link href="assets/css/morris.css" rel="stylesheet" />


    <style>
        .back{
            background:skyblue;
        }
        .year{
            margin-top:8px;
            margin-left:160px;
        }
        .yearinput{
            margin-left:-250px;
        }
        .year_but{
            margin-left:-25px;
        }
        .form-control{
            border-color:black;
        }
        .btn-primary{
            margin-top:30px;
        }
        .btn-warning{
            margin-top:30px;
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
                        <li><a href="dashboard2.php"><i class="ti-home"></i>Dashboard</a></li>
                        <li><a href="planning_agri_supplies.php"><i class="ti-shopping-cart-full"></i>Agri Supplies</a></li>
                        <li><a href="request_services.php"><i class="ti-shopping-cart-full"></i>Request</a></li>
                        <li><a href="beneficiary_product_record.php"><i class="ti-folder"></i>Product Request</a></li>
                        <li><a href="beneficiary_product_transactions.php"><i class="ti-folder"></i>Transactions</a></li>
                        <li><a class="sidebar-sub-toggle"><i class="ti-panel"></i> Inventory <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="inventory_vegetable_seeds.php"><i class="ti-folder"></i>Vegetable Seeds</a></li>
                                <li><a href="inventory_fruit_seeds.php"><i class="ti-folder"></i>Fruit trees Seeds</a></li>
                                <li><a href="inventory_organic.php"><i class="ti-folder"></i>Organic/Vermicast</a></li>
                                <li><a href="inventory_fertilizer.php"><i class="ti-folder"></i>Fertilizers</a></li>
                                <li><a href="inventory_corn_seeds.php"><i class="ti-folder"></i>Corn Seeds</a></li>
                                <li><a href="inventory_rice_seeds.php"><i class="ti-folder"></i>Rice Seeds</a></li>
                                <li><a href="inventory_chemicals.php"><i class="ti-folder"></i>Chemicals</a></li>
                            </ul>
                        </li>
                        <li><a class="sidebar-sub-toggle"><i class="ti-panel"></i> Reports <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                            <ul>
                                <li><a href="inventory_reports.php"><i class="ti-folder"></i>Inventory Reports</a></li>
                                <li><a href="planning_barangay_report.php"><i class="ti-folder"></i>Barangay Reports</a></li>
                                <li><a href="planning_beneficiary_report.php"><i class="ti-folder"></i>Beneficiary Reports</a></li>
                                <li><a href="planning_statistical_report.php"><i class="ti-folder"></i>Statistical Reports</a></li>
                            </ul>
                        </li>
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
                
                            <form action="print_graph.php" method="post" target="_blank">
                            <div class="row">
                            <!-- /# column -->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h5>Type of Report:</h5>
                                        <select name="type" id="type" class="form-control">
                                            <option value="Monthly">Monthly</option>
                                            <option value="Yearly">Yearly</option>
                                            <option value="Customize">Customize</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="cdatef">
                                            <h5>Date from:</h5>
                                            <input type="date" id="datefrom" name="datefrom" class="form-control">
                                        </div>
                                        <div id="yearf">
                                        <h5>Year from:</h5>
                                            <select name="yearfrom" id="yearfrom" class="form-control">
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
                                        </div>
                                        
                                        <div id="yearni">
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
                                            </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="cdatet">
                                            <h5>Date from:</h5>
                                            <input type="date" id="dateto" name="dateto" class="form-control">
                                        </div>
                                        <div id="yeart">
                                        <h5>Year to:</h5>
                                            <select name="yearto" id="yearto" class="form-control">
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
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                            <button type="button" class="btn btn-primary ti-search" id="sear"></button>
                                      
                                    </div>
                                    <div class="col-md-2">
                                        <div align="right">
                                            <button type="submit" class="btn btn-warning ti-printer"></button>
                                            <button type="button" id="graph" class="btn btn-primary ti-eye"> Graph</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                    <div class="card-body">
                                        <table id="user_data" class="table table-stripped table-bordered">
                                                <thead>
                                                    <th>Date</th>
                                                    <th>Year</th>
                                                    <th>Month</th>
                                                    <th>Type of Product</th>
                                                    <th>Product Name</th>
                                                    <th style="text-align:center;">Total No. Serve</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                        </table>
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
    <script src="js/jquery.dataTables.min.js"></script>
    

</html>

<script>
$(document).ready(function(){ 
    
    var interval=setInterval(function(){
        var momentNow=new moment();
        $('#datetime').html(momentNow.format('MMMM DD, YYYY')+' '+momentNow.format('dddd').substring(0,3).toUpperCase());
        $('#time').html(momentNow.format('A hh:mm:ss'));
   },100);

   $('#yearf').hide();
    $('#yeart').hide();
    $('#yearni').show();
    $('#sear').hide();
    $('#cdatef').hide();
    $('#cdatet').hide();

    $(document).on('change','#type',function(){
        var type=$('#type').val();
       if(type=='Monthly'){
            $('#yearf').hide();
            $('#yeart').hide();
            $('#yearni').show();
            $('#sear').hide();
            $('#cdatef').hide();
            $('#cdatet').hide();
       }else if(type=='Yearly'){
            $('#yearf').show();
            $('#yeart').show();
            $('#yearni').hide();
            $('#sear').show();
            $('#cdatef').hide();
            $('#cdatet').hide();
       }else if(type=='Customize'){
            $('#cdatef').show();
            $('#cdatet').show();
            $('#yearf').hide();
            $('#yeart').hide();
            $('#yearni').hide();
            $('#sear').show();
       }
    });

    fetchChart();
   var dataTable;
 function fetchChart(){

    var year=$('#year').val();
    var type=$('#type').val();
    var yearf=$('#yearfrom').val();
    var yeart=$('#yearto').val();
    var datef=$('#datefrom').val();
    var datet=$('#dateto').val();

    dataTable = $('#user_data').DataTable({
            "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"fetch_chart_table2.php",
                type:"POST",
                data:{'year':year,'type':type,'yearf':yearf,'yeart':yeart,'datef':datef,'datet':datet}
            },
            "columnDefs":[
                {
                    "targets":[0, 3, 3],
                    "orderable":false,
                },
            ],

            });
    };

    $(document).on('click','#sear',function(){
        dataTable.clear().destroy();
        fetchChart();
    });
    $(document).on('click','#graph',function(){
        document.location.href="dashboard2.php";
    });

   

    $(document).on('click','#sear',function(){
        dataTable.clear().destroy();
        fetchChart();
    });

    $(document).on('change','#year',function(){
        dataTable.clear().destroy();
        fetchChart();
    });

    $('#logout').click(function(){
        document.location.href="logout.php";
    });
    $('#profile').click(function(){
        document.location.href="profile_planning.php";
    });
    $('#setting').click(function(){
        document.location.href="planning_setting.php";
    });
    $('#view_notif').click(function(){
        document.location.href="notification_table_inventory.php";
    });

});
</script>