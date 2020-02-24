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

    <!-- Datatable -->
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />
    <link href="assets/css/morris.css" rel="stylesheet" />
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" />

    <style>
        .back{
            background:skyblue;
        }
        #assis{
            height:20px;
            width:20px;
        }
        .modal-header{
            background-color:skyblue;
        }
        .form-group{
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
                                    <h3>Agri Supplies List</h3>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h4><?php echo $_SESSION['name']; ?></h4><p>Request List</p>
                                        </div>
                                        <div class="col-md-4">
                                            <div align="right">
                                                <button type="button" id="close_button" class="btn btn-secondary ti-back-left btn-sm"></button>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    
                                        <div class="table-responsive">
                                            <table id="user_data" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Last Name</th>
                                                        <th >First Name</th>
                                                        <th>Middle Name</th>
                                                        <th>Status</th>
                                                        <th>Date Requested</th>
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



    <!-- Common -->
    <div id="userModal" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Products</h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check1" value="Vegetables_Seedlings/Seeds"> Vegetables Seedlings/Seeds
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check2" value="Fruit_Trees_Seedlings"> Fruit Trees Seedlings
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check3" value="Organic/Vermicast"> Organic/Vermicast
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check1" value="Fertilizers"> Fertilizers
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check2" value="Corn_Seeds"> Corn Seeds
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check3" value="Rice_Seeds"> Rice Seeds
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check3" value="Chemicals"> Chemicals
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="asis_user_id" id="asis_user_id" />
                            <input type="hidden" name="service_id" id="service_id" />
                            <input type="button" id="addassis" class="btn btn-primary" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="close_form">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="userModal3" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="add_assis_form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Are you sure want to add Product to <span id="name_nila"></span>?</h4>
                            <b><button type="button" id="close_con_ass" class="close" data-dismiss="modal"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                               
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="fed_id" id="fed_id" />
                            <input type="button" id="add_assis" class="btn btn-success" value="Yes" />
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="close_con">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    

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
    
    var dataTable = $('#user_data').DataTable({
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
        url:"fetch_agri_supplies_single.php",
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
        var service_id=$(this).val();
        $('#service_id').val(service_id);
        $('#assistance_form')[0].reset();
        $('#asis_user_id').val(user_id);
	});

    $(document).on('click', '#addassis', function(){
        var assistant=[];
        $('#assis:checked').each(function(i,e){
            assistant.push($(this).val());
        });
        
        var user_id = $('#asis_user_id').val();
        if(assistant==''){
            alert("choose at least 1");
        }else{
            $.ajax({
			url:"fetch_single_beneficiary_secretary.php",
			method:"POST",
			data:{user_id:user_id},
			dataType:"json",
			success:function(data)
			{
				$('#name_nila').text(data);
			}
		});
            for(i=0;i<assistant.length;i++){
                var html='<p>* '+assistant[i]+'</p>';
                $('#userModal3 .modal-body').append(html);
            }
            $('#userModal3').modal('show');
            $('#userModal').modal('hide');
        }
	});

    $(document).on('click', '#close_con', function(){
        $('#userModal3').modal('hide');
        $('#userModal').modal('show');
        $('#userModal3 p').remove();
	});

    $(document).on('click', '#add_assis', function(){
        var service_id=$('#service_id').val();
        var assistant=[];
        $('#assis:checked').each(function(i,e){
            assistant.push($(this).val());
        });
        var user_id = $('#asis_user_id').val();
        if(assistant==''){
            alert("choose at least 1");
        }else{
            $.ajax({
				url:"addservices_beneficiary.php",
				method:'POST',
				data:{'assis[]':assistant.join(),'user_id':user_id,'service_id':service_id},
				success:function(data)
				{
                    alert(data);
                    $('#userModal3').modal('hide');
                    $('#userModal').modal('hide');
                    window.open('print_service_request.php');
				}
			});
        }
	});

    /*
    $(document).on('click', '#addassis', function(){
        var assistant=[];
        $('#assis:checked').each(function(i,e){
            assistant.push($(this).val());
        });
        var user_id = $('#asis_user_id').val();
        if(assistant==''){
            alert("choose at least 1");
        }else{
            $.ajax({
				url:"addservices_beneficiary.php",
				method:'POST',
				data:{'assis[]':assistant.join(),'user_id':user_id},
				success:function(data)
				{
                    alert(data);
                    $('#userModal').modal('hide');
                    document.location.href="request_services.php";
				}
			});
        }
        
	});
    */

    $('#close_button').click(function(){
        document.location.href="planning_agri_supplies.php";
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
});
</script>