<?php
session_start();
if(isset($_SESSION['position'])){
  if($_SESSION['position']=="Secretary"||$_SESSION['position']=="secretary"){
    header('location:dashboard.php');
  }
  elseif($_SESSION['position']=="Planning"||$_SESSION['position']=="planning"){
    header('location:dashboard2.php');
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<!-- Head -->

<head>
    <title>CAGRO - INFO STEAM</title>
    <!-- Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    
    <!-- //Meta-Tags -->
    <!-- Index-Page-CSS -->
    <link rel="stylesheet" href="assets/css1/style.css" type="text/css" media="all">
    <link type="image/x-icon" href="assets/images/cagro5.png" rel="shortcut icon">
    <!-- //Custom-Stylesheet-Links -->
    <!--fonts -->
    <!-- //fonts -->
    <link rel="stylesheet" href="assets/css1/font-awesome.min.css" type="text/css" media="all">
    <!-- //Font-Awesome-File-Links -->
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

</head>
<style>
body {
  overflow: hidden; /* Hide scrollbars */
	}
a,i {
	text-decoration: none;
	color: white;
}
.pointer {cursor: pointer;}
</style>
<body>

<section class="main">
	<div class="layer">
		<div class="content-w3ls">
			<div class="text-center icon">
				<img src="assets/images/infosteam1.png" class="img-fluid" width="90%">
			</div>
			<div class="content-bottom">
				<form method="post" id="user_form">
					<div class="field-group">
						<span class="fa fa-user" aria-hidden="true"></span>
						<div class="wthree-field">
							<input name="username" id="username" type="text" value="" placeholder="Username" required>
						</div>
					</div>
					<div class="field-group">
						<span class="fa fa-lock" aria-hidden="true"></span>
						<div class="wthree-field">
  								<input class="form-control pwd" name="password" id="password" type="Password" placeholder="Password">
						</div>
						<a class="btn btn-default reveal pointer" type="button">
							<span class="fa fa-eye" aria-hidden="true"></span>
						</a>
					</div>
					<div class="wthree-field">
						<button type="submit" class="btn" id="login" value="Login">Sign in</button>
					</div>
					<ul class="list-login">
						<li class="switch-agileits">
						</li>
						<li>
						</li>
						<li class="clearfix"></li>
					</ul>
					<ul class="list-login-bottom">
						<li class="">
							<a href="#" class="">Sign Up</a>
						</li>
						<li class="">
							<a href="#" class="text-right">forgot password?</a>
						</li>
						<li class="clearfix"></li>
					</ul>
				</form>
			</div>
		</div>
		<div class="bottom-grid1">
			<div class="links">
				<ul class="links-unordered-list">
					<li class="">
						<a href="#" class="">About Us</a>
					</li>
					<li class="">
						<a href="#" class="">Privacy Policy</a>
					</li>
					<li class="">
						<a href="#" class="">Terms of Use</a>
					</li>
				</ul>
			</div>
			<div class="copyright">
				<p>© 2019 Key. All rights reserved | Design by
					<a href="http://dnsc.edu.ph/">DNSC - IIT.</a>
				</p>
			</div>
		</div>
    </div>
</section>

</body>
<!-- //Body -->
</html>

<script>
	$(document).ready(function(){ 
		$(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
    } else {
        $pwd.attr('type', 'password');
    }
});
	
		$(document).on('submit', '#user_form', function(event){
			event.preventDefault();
			var username=$('#username').val()
			var password=$('#password').val()
	
			if(username == '' ){
				$('#username_error').text('*User Name is Required');
				$('#username_error').css({"color":"#FF0000"});
				$('#username').css({"border-color":"#FF0000"});
			}else{
				$('#username_error').text('')
				$('#username').css({"border-color":""});
			}	
			if(password == '' ){
				$('#password_error').text('*Password is Required');
				$('#password_error').css({"color":"#FF0000"});
				$('#password').css({"border-color":"#FF0000"});
			}else{
				$('#password_error').text('')
				$('#password').css({"border-color":""});
			}	
	
			if(password!='' && username!=''){
				$.ajax({
					url:"check_login.php",
					method:'POST',
					dataType:"json",
					data:{'username':username,'password':password},
					success:function(data)
					{
						alert(data.errors);
						if(data.position=="secretary"||data.position=="Secretary"){
							document.location.href="dashboard.php";
						}
						else if(data.position=="Planning"){
							document.location.href="dashboard2.php";
						}
						else if(data.position=="Admin"){
							document.location.href="dashboard3.php";
						}
					}
					});
	
			}
			
		});
	
	});
	</script>