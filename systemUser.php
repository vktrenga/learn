<?php
ob_start ();
session_start ();

include 'includes/connection.php';
include 'controller/systemUserController.php';
include 'controller/systemRoleController.php';
extract ( $_REQUEST );
$sys_user_ob = new SystemUserConrtoller ();
if (isset ( $_REQUEST ['pk'] ) && $pk != "") {
	$db->deleteData ( $sys_user_ob->table_name, " sys_user_id=$pk" );
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

<title>Exam Admin-Panel</title>

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
					<div class="col-lg-12">

						<a class="btn btn-sm btn-primary pull-right"
							href="systemUser_cu.php">Add New</a>
						<h3 class="page-header">System User</h3>
					</div>
				</div>
				<!-- /.row -->

				<div class="row">
				<?php
				if ($resContent) {
					$db->showMessage ( 0, $resContent );
				}
				?>
					<div class="col-lg-12">

						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th width="5%">S.No</th>
										<th>System User</th>
										<th>System Role</th>

										<th>User Name</th>
										<th>Email</th>
										<th>Mobile</th>
										<th>Created At</th>
										<th width="5%">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$tableDataRes = $sys_user_ob->selectAction ( "flag=0" );
								
								for($r = 0; $r < count ( $tableDataRes ); $r ++) {
									$pk = $tableDataRes [$r] ['sys_user_id'];
									$sys_role = new SystemRoleConrtoller ();
									$sys_role_data = $sys_role->selectAction ( "sys_role_id=" . $tableDataRes [$r] ['sys_role_id'] );
									$sys_role_name = $sys_role_data [0] ['sys_role'];
									?>
									<tr>
										<td><?php echo $r+1; ?></td>
										<td><?php echo $tableDataRes[$r]['sys_name']; ?></td>
										<td><?php echo $sys_role_name; ?></td>

										<td><?php echo $tableDataRes[$r]['user_name']; ?></td>
										<td><?php echo $tableDataRes[$r]['email']; ?></td>
										<td><?php echo $tableDataRes[$r]['mobile']; ?></td>
										<td><?php echo $db->showDBDateTime($tableDataRes[$r]['created_at']); ?></td>
										<td><a href="systemUser_cu.php?pk=<?php echo $pk; ?>" title="Edit"><i
												class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a
											href="systemUser.php?pk=<?php echo $pk; ?>" title="Delete"
											onclick="return deleteConfirm()"><i class="fa fa-trash"></i></a></td>
									</tr>
									<?php
								}
								?>
									
								</tbody>
							</table>
						</div>
					</div>
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


</body>

</html>
