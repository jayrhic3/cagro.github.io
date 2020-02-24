<?php
session_start();
include('connection.php');

if(!isset($_SESSION['username'])){
    header('location:index.php');
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
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Datatable -->
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />

    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>

    <style>
        .back{
            background:skyblue;
        }
        .table{
            width:100%;
        }
        .modal-header{
            background-color:skyblue;
        }
        .bod{
            font-size:20px;
            color:black;
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

                <div class="row">
                            <!-- /# column -->
                            <div class="col-md-12">
                                <div class="card">
                                   <div class="card-body">
                                        <h3>Transactions</h3>
                                            <div class="form-group">
                                                <label>Status:</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="All">All</option>
                                                    <option value="On Going">On Going</option>
                                                    <option value="Cancel">Cancel</option>
                                                    <option value="Done">Done</option>
                                                    <option value="Pending">Pending</option>
                                                </select>
                                            </div>
                                                <table id="user_data" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Last Name</th>
                                                            <th >First Name</th>
                                                            <th >Product Acquired</th>
                                                            <th >Quantity</th>
                                                            <th >Status</th>
                                                            <th >Date Acquired</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                           
                                        </div>
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

</body>

    
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
    <script src="assets/js/lib/menubar/sidebar.js"></script>
    <script src="assets/js/lib/preloader/pace.min.js"></script>
    <script src="js/moment.min.js"></script>
    
    

</html>

<script>
$(document).ready(function(){ 
    var interval=setInterval(function(){
        var momentNow=new moment();
        $('#datetime').html(momentNow.format('MMMM DD, YYYY')+' '+momentNow.format('dddd').substring(0,3).toUpperCase());
        $('#time').html(momentNow.format('A hh:mm:ss'));
   },100);
   fetchdata();
   var datatable;
    function fetchdata(){
        var status=$('#status').val();
        dataTable = $('#user_data').DataTable({
            "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"fetch_single_transactions.php",
                type:"POST",
                data:{'status':status}
            },
            "columnDefs":[
                {
                    "targets":[0, 3, 3],
                    "orderable":false,
                },
            ],

        });
    }

    $(document).on('change','#status',function(){
        dataTable.clear().destroy();
        fetchdata();
    });

    $('#logout').click(function(){
        document.location.href="logout.php";
    });
    $('#profile').click(function(){
        document.location.href="profile_secretary.php";
    });
    $('#setting').click(function(){
        document.location.href="setting.php";
    });
    $('#addassis').click(function(){
        $('#userModal').modal('hide');
        location.reload();
    });
    $('#view_notif').click(function(){
        document.location.href="notification_table.php";
    });

});
</script>