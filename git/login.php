<?php
/*
 * error_reporting ( E_ALL );
 * ini_set ( 'display_errors', '1' );
 */
extract ( $_REQUEST );
if (isset ( $_POST ['submit'] )) {
	
	include 'includes/connection.php';
	$db = new connection ();
	include 'controller/systemUserController.php';
	$sys_user_ob = new SystemUserConrtoller ();
	$resContent = $sys_user_ob->loginAction ( $_REQUEST );
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Login</title>

<link href="css/bootstrap.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/sb-admin.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet"
	type="text/css">
	<link href="js/jvalidate/screen.css" rel="stylesheet" type="text/css">
</head>

<body>

	<div id="wrapper">
		<div class="container-fluid">

			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-2"></div>
				<div class="col-lg-6">
					<h3 class="page-header">Login</h3>
					<div class="row col-lg-12">
					<?php
					if ($resContent) {
						$db->showMessage ( 3, $resContent );
					}
					?>
						<form role="form" id="loginfrm" method="post" action="">

							<div class="form-group">
								<label>User Name</label> <input class="form-control" type="text"
									name="user_name" id="user_name">

							</div>
							<div class="form-group">
								<label>Password</label> <input class="form-control"
									type="password" name="password" id="password">

							</div>

							<button type="submit" class="btn btn-success" name="submit"
								id="submit">Login</button>
						</form>
					</div>
				</div>
				<div class="col-lg-4"></div>
			</div>
			<!-- /.row -->

			<div class="row"></div>
			<!-- /.row -->

		</div>
		<!-- /.container-fluid -->


		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->
	<!-- Footer Js -->
	<!-- end Footer Js -->
	<?php include 'includes/scriptjs.php';?>
	<!-- jQuery -->
	<script type="text/javascript">
	/**
	VALIDATE
	*/
	$(document).ready(function() {
		$("#submit").click(function(){
			roleFrmValidate();
		});	
	});
	function roleFrmValidate(){
		$("#loginfrm").validate({
			rules : {
				user_name : {
					required : true,
				},
				password : {
					required : true,
				}
			}
		});
	}
	</script>

</body>

</html>
