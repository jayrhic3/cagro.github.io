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
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Datatable -->
    <link href="assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />

    <script src="js/jquery.min.js"></script>

    <style>
        .back{
            background:skyblue;
        }
        .table{
            width:100%;
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
                                   <h3>Services Request</h3>
                                   <div class="row">
                                        <div class="col-lg-12"  id="ongoing_table">
                                            <div class="table-responsive">
                                                <table id="user_data" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Last Name</th>
                                                            <th >First Name</th>
                                                            <th >Middle Name</th>
                                                            <th width="5%">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
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

    <!-- modal -->
    <div id="userModal" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <form method="post" id="assistance_form" action="print_service_request.php" target="_blank">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Beneficiary Request</h4>
                            <b><button type="button" class="close" data-dismiss="modal" id="ex_close"><span class="ti-close"></span></button></b>
                        </div>
                        <div class="modal-body">
                            
                            <input type="hidden" id="t1" name="id_a[]" class="ass">
                            <input type="hidden" id="t2" name="id_a[]" class="ass">
                            <input type="hidden" id="t3" name="id_a[]" class="ass">
                            <input type="hidden" id="t4" name="id_a[]" class="ass">
                            <input type="hidden" id="t5" name="id_a[]" class="ass">
                            <input type="hidden" id="t6" name="id_a[]" class="ass">
                            <input type="hidden" id="t7" name="id_a[]" class="ass">

                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check1" value="Vegetables Seedlings/Seeds">Vegetables Seedlings/Seeds
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check2" value="Fruit Trees Seedlings">Fruit Trees Seedlings
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check3" value="Organic/Vermicast">Organic/Vermicast
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check4" value="Fertilizers">Fertilizers
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check5" value="Corn Seeds">Corn Seeds
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check6" value="Rice Seeds">Rice Seeds
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="assis[]" id="assis" class="check7" value="Chemicals">Chemicals
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="user_id" id="user_id" />
                            
                            <input type="submit" id="addassis" class="btn btn-warning" value="Print View" />
                        </div>
                    </div>
                </form>
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
    <script src="assets/js/lib/bootstrap.min.js"></script>
    
    

</html>

<script>
$(document).ready(function(){ 
    var interval=setInterval(function(){
        var momentNow=new moment();
        $('#datetime').html(momentNow.format('MMMM DD, YYYY')+' '+momentNow.format('dddd').substring(0,3).toUpperCase());
        $('#time').html(momentNow.format('A hh:mm:ss'));
   },100);
    $('#other_input').hide();
    var dataTable = $('#user_data').DataTable({
    "lengthMenu": [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    "processing":true,
    "serverSide":true,
    "order":[],
    "ajax":{
        url:"fetch_request_services.php",
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
				url:"goto_single_request_services_list.php",
				method:'POST',
				data:{'user_id':user_id},
				success:function(data)
				{
                    document.location.href="request_services_list_single.php";
				}
			});
	});
    /*
    $(document).on('click', '.check', function(){
		var user_id = $(this).attr("id");
            $.ajax({
                    url:"fetch_single_request_services.php",
                    method:"POST",
                    data:{user_id:user_id},
                    dataType:"json",
                    success:function(data)
                    {
                        $('#user_id').val(user_id);
                        var arr1=[];
                        arr1=data.assistant.trim().split(',');
                        for($i=0;$i<arr1.length;$i++){
                            if(arr1[$i].replace(/"|'/g,'')=="Vegetables_Seedlings/Seeds"){
                                $('.check1').attr('checked','checked');
                            }
                            else if(arr1[$i].replace(/"|'/g,'')=="Fruit_Trees_Seedlings"){
                                $('.check2').attr('checked','checked');
                            }
                            else if(arr1[$i].replace(/"|'/g,'')=="Organic/Vermicast"){
                                $('.check3').attr('checked','checked');
                            }
                            else if(arr1[$i].replace(/"|'/g,'')=="Fertilizers"){
                                $('.check4').attr('checked','checked');
                            }
                            else if(arr1[$i].replace(/"|'/g,'')=="Corn_Seeds"){
                                $('.check5').attr('checked','checked');
                            }
                            else if(arr1[$i].replace(/"|'/g,'')=="Rice_Seeds"){
                                $('.check6').attr('checked','checked');
                            }
                            else if(arr1[$i].replace(/"|'/g,'')=="Chemicals"){
                                $('.check7').attr('checked','checked');
                            }
                            
                        }
                        
                        var arr2=[];
                        arr2=data.service.trim().split(',');
                        for($i=0;$i<arr2.length;$i++){
                            $('#t1').val(arr2[0].replace(/"|'/g,''));
                            $('#t2').val(arr2[1].replace(/"|'/g,''));
                            $('#t3').val(arr2[2].replace(/"|'/g,''));
                            $('#t4').val(arr2[0].replace(/"|'/g,''));
                            $('#t5').val(arr2[1].replace(/"|'/g,''));
                            $('#t6').val(arr2[2].replace(/"|'/g,''));
                            $('#t7').val(arr2[2].replace(/"|'/g,''));
                        }
                            


                    }
                });
	});
    $('#ex_close').click(function(){
        location.reload();
    });
    */
    $('#addassis').click(function(){
        $('#userModal').modal('hide');
        location.reload();
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