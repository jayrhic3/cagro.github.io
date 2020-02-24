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
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Datatable -->
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />
   
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
                                    if($statement3 = $connection->prepare('SELECT COUNT(title) as num from notification WHERE event_status="Unread"')){
                                        $statement3->execute();
                                        $result3 = $statement3->fetchAll();
                                        foreach($result3 as $row3)
                                        {
                                            $count=$row3['num'];
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
                                        
                                            if($statement4 = $connection->prepare('SELECT * from notification order by start_event desc limit 3')){
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
                                                        <small class="notification-timestamp pull-right"><?php echo $row4['event_status'] ?></small>
                                                        <div class="notification-heading"><?php echo $row4['title'] ?></div>
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
                                    <h3>Technical Assistance</h3><br>
                                        <div class="table-responsive">
                                            <table id="user_data" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Last Name</th>
                                                        <th >First Name</th>
                                                        <th>Middle Name</th>
                                                        <th width="5%">Action</th>
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

        <!-- modal -->
        <div id="userModal" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Status</h4>
                            <b><button type="button" class="close" data-dismiss="modal"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="On Going">On Going</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Done">Done</option>
                                </select>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="user_id" id="user_id" />
                            <input type="button" id="updatestat" class="btn btn-success" value="Update" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <!-- Common -->
    
    

</body>
    <script src="js/jquery.min.js"></script>
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
    
    var dataTable = $('#user_data').DataTable({
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
        url:"fetch_technical_asis.php",
        type:"POST"
    },
    "columnDefs":[
        {
            "targets":[0, 3, 3],
            "orderable":false,
        },
    ],

    });


    $(document).on('click', '.check', function(){
		var user_id = $(this).attr("id");
        $.ajax({
				url:"goto_single_technical_list.php",
				method:'POST',
				data:{'user_id':user_id},
				success:function(data)
				{
                    document.location.href="technical_list_single.php";
				}
			});
	});

    $(document).on('click', '#updatestat', function(){
		var user_id = $('#user_id').val();
        var status=$('#status').val();

            if(status!=''){
                $.ajax({
                    url:"update_status_technical.php",
                    method:"POST",
                    data:{user_id:user_id,status:status},
                    success:function(data)
                    {
                        alert(data);
                        $('#userModal').modal('hide');
                        dataTable.ajax.reload();
                    }
                })
            }else{
                alert("fields are required");
            }
		
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
    $('#view_notif').click(function(){
        document.location.href="notification_table.php";
    });
});
</script>