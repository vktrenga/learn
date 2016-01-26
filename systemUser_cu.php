<?php
/*
 * error_reporting(E_ALL);
 * ini_set('display_errors', '1');
 */
include 'includes/connection.php';
include 'controller/systemUserController.php';
include 'controller/systemRoleController.php';
extract ( $_REQUEST );
$db = new connection ();
$sys_user_ob = new SystemUserConrtoller ();
$sys_role_ob = new SystemRoleConrtoller ();
/**
 * Action Declare
 * default action 0=add,1=edit,2=delete
 */

if (isset ( $_POST ['submit'] )) {
	
	if ($action == 0) {
		$resContent = $sys_user_ob->insertAction ( $_REQUEST );
	}
	if ($action == 1) {
		$resContent = $sys_user_ob->updateAction ( $_REQUEST );
	}
}
if (isset ( $_REQUEST ['pk'] ) && $pk != "") {
	$action = 1;
	$tableDataRes = $sys_user_ob->selectAction ( "sys_user_id=$pk" );
	$tableDatas = $tableDataRes [0];
} else {
	$pk = "";
	$action = 0;
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

<title>SB Admin - Bootstrap Admin Template</title>

   <?php include 'includes/header_tag.php';?>

</head>

<body>

	<div id="wrapper">

		<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<?php include 'includes/header.php';?>
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<?php include 'includes/menu.php';?>
			</div>
			<!-- /.navbar-collapse -->
		</nav>

		<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-11">
						<h3 class="page-header">System User Create / Update</h3>
					</div>
					<div class="col-lg-1">
						<a class="btn btn-sm btn-primary" href="systemUser.php">View</a>
					</div>
				</div>
				<!-- /.row -->

				<div class="row">
					
							<?php
							if ($resContent) {
								$db->showMessage ( 0, $resContent );
							}
							?>
					<form role="form" id="userFrm" method="post" action="">
						<div class="col-lg-6">


							<div class="form-group">
								<label>System User Name</label> <input class="form-control"
									type="text" name="sys_name" id="sys_name"
									value="<?php echo $tableDatas['sys_name']; ?>">

							</div>

							<div class="form-group">
								<label>System User Role</label> <select class="form-control"
									id="sys_role_id" name="sys_role_id">
									<option>--Select--</option>
									<?php
									$tableDataRes = $sys_role_ob->selectAction ( "flag=0" );
									for($r = 0; $r < count ( $tableDataRes ); $r ++) {
										$role_pk = $tableDataRes [$r] ['sys_role_id'];
										$role_name = $tableDataRes [$r] ['sys_role'];
										?>
										<option value="<?php echo $role_pk;?>" <?php if($role_pk==$tableDatas['sys_role_id']){echo "Selected";}?>><?php echo $role_name; ?></option>
										<?php
									}
									?>
								</select>
							</div>

							<div class="form-group">
								<label>DOB</label> <input class="form-control datepicker"
									type="text" name="dob" id="dob" readonly
									value="<?php echo $tableDatas['dob']; ?>">

							</div>
							<div class="form-group">
								<label>Email</label> <input class="form-control" type="text"
									name="email" id="email"
									value="<?php echo $tableDatas['email']; ?>">

							</div>
							<div class="form-group">
								<label>Mobile No</label> <input class="form-control" type="text"
									maxlength="10" name="mobile" id="mobile"
									value="<?php echo $tableDatas['mobile']; ?>">

							</div>

						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Address</label>
								<textarea class="form-control" name="address" id="address"><?php echo $tableDatas['address']; ?></textarea>


							</div>

							<div class="form-group">
								<label>User Name</label> <input class="form-control" type="text"
									name="user_name" id="user_name"
									value="<?php echo $tableDatas['user_name']; ?>">

							</div>
						<?php
						if ($action == 0) {
							?>
						<div class="form-group">
								<label>Password</label> <input class="form-control"
									type="password" name="password" id="password" value="">

							</div>

							<div class="form-group">
								<label>Confirm Password</label> <input class="form-control"
									type="password" name="confirm_password" id="confirm_password"
									value="">

							</div>
						<?php
						}
						?>

						<input type="hidden" name="pk" id="pk" value="<?php echo $pk; ?>">
							<input type="hidden" name="action" id="action"
								value="<?php echo $action; ?>">
							<button type="reset" class="btn btn-danger">Reset</button>
							<button type="submit" class="btn btn-success" name="submit"
								id="submit">Submit</button>
						</div>
					</form>
				</div>
				<!-- /.row -->

			</div>
			<!-- /.container-fluid -->

		</div>
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
		  $(function() {
			    $( ".datepicker" ).datepicker();
			  });

		
		$("#submit").click(function(){
			userFrmValidate();
		});	
	});
	function userFrmValidate(){
		$("#userFrm").validate({
			rules : {
				sys_name : {
					required : true,
				},
				sys_role_id : {
					required : true,
				},
				dob : {
					required : true,
				},
				email : {
					required : true,
					email:true,
				},
				mobile : {
					required : true,
					number:true,
				},
				user_name : {
					required : true,
					minlength:4,
					maxlength:8
					
				},
				password : {
					required : true,					
				},
				confirm_password : {
					required : true,
					equalTo: "#password"
				}
				
			}
		});
	}
	</script>
</body>

</html>
