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
        .ti-printer{
            margin-top:32px;
            margin-left:92px;
        }
        .ti-search{
            margin-left:-15px;
            margin-top:32px;
        }
        .ti-trash{
            
            margin-top:32px;
        }
        .nacks{
            margin-left:-100px;
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
                                <div class="card">
                                   <div class="card-body">
                                   <h3>Beneficiary Reports</h3>
                                   <form  method="POST"  action="print_beneficiary_report.php" target="_blank">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Beneficiary Name:</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="All">All</option>
                                                    <?php 

                                                                $query2="SELECT t1.lastname as lastname,t1.firstname as firstname,
                                                                t1.id as id from beneficiaries as t1";

                                                                $statement2 = $connection->prepare($query2);
                                                                $statement2->execute();
                                                                $result2 = $statement2->fetchAll();
                                                                foreach($result2 as $row)
                                                                {
                                                                    echo '<option id="'.$row["id"].'">'.$row["lastname"].", ".$row["firstname"].'</option>';
                                                                }

                                                            ?>
                                                </select>
                                                <input type="hidden" id="user_id" name="user_id">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Type of Assistance:</label>
                                                <select name="assistance" id="assistance" class="form-control">
                                                    <option value="All">All</option>
                                                    <?php 

                                                                $query2="SELECT description from assistance as t1";

                                                                $statement2 = $connection->prepare($query2);
                                                                $statement2->execute();
                                                                $result2 = $statement2->fetchAll();
                                                                foreach($result2 as $row)
                                                                {
                                                                    echo '<option value="'.$row["description"].'">'.$row['description'].'</option>';
                                                                }

                                                            ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label>Date From:</label>
                                                <input type="date" class="form-control" name="datefrom" id="datefrom">
                                            </div>
                                            <div class="col-md-2">
                                                <label>Date To:</label>
                                                <input type="date" class="form-control" name="dateto" id="dateto">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-success ti-search" id="filter"></button>
                                            </div>
                                            <div class="col-md-2">
                                            <div align="right">
                                                <button type="submit" class="btn btn-warning ti-printer" id="print"> Print</button>        
                                            </div>
                                            </div>
                                        </div>
                                   </form>
                                   <br>
                                            <table id="user_data1" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Last Name</th>
                                                        <th >First Name</th>
                                                        <th>Assistant Request</th>
                                                        <th width="8%">Status</th>
                                                        <th width="17%">Date Requested</th>
                                                    </tr>
                                                </thead>
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
    $('#print').show();

    $('#datefrom').css({"border-color":"#000000"});
    $('#assistance').css({"border-color":"#000000"});
    $('#dateto').css({"border-color":"#000000"});
    $('#status').css({"border-color":"#000000"});
    
    
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
    var dataTable;
   
    $(document).on('click', '#filter', function(){
        var datefrom=$('#datefrom').val();
        var dateto=$('#dateto').val();
        if(datefrom!='' && dateto!=''){
            dataTable.clear().destroy();
            fetchData();
            $('#datefrom').css({"border-color":"#000000"});
            $('#dateto').css({"border-color":"#000000"});
        }else{
            $('#print').show();
            $('#datefrom').css({"border-color":"#FF0000"});
            $('#dateto').css({"border-color":"#FF0000"});
        }
	});
    fetchData();
    function fetchData(){
        var status=$('#status').val();
        var datefrom=$('#datefrom').val();
        var dateto=$('#dateto').val();
        var assistance=$('#assistance').val();
        var id;
        if(status!='All'){
            id=$('#status option:selected').attr('id');
            status='';
        }else{
            id='';
        }
        dataTable = $('#user_data1').DataTable({
            "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"fetch_ongoing.php",
                type:"POST",
                data:{'status':status,'id':id,'datefrom':datefrom,'dateto':dateto,'assistance':assistance}
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
        id=$('#status option:selected').attr('id');
        $('#user_id').val(id);
        dataTable.clear().destroy();
        fetchData();
    });
    $(document).on('change','#assistance',function(){
        id=$('#status option:selected').attr('id');
        $('#user_id').val(id);
        dataTable.clear().destroy();
        fetchData();
    });


});
</script>