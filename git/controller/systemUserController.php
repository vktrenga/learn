<?php
class SystemUserConrtoller {
	
	/*
	 * Table Name
	 */
	public $table_name = "system_user";
	
	/**
	 *
	 * @var unknown
	 */
	public $sys_user_id;
	public $sys_name;
	public $sys_role_id;
	public $dob;
	public $email;
	public $address;
	public $user_name;
	public $password;
	public $created_by;
	public $created_at;
	public $modified_by;
	public $modified_at;
	public $flag = 0;
	function __construct() {
		$db = new connection ();
	}
	public function insertAction($params) {
		$db = new connection ();
		$columns_values = array (
				"sys_user_id" => 'NULL',
				"sys_name" => $params ['sys_name'],
				"sys_role_id" => $params ['sys_role_id'],
				"dob" => $db->storeDBDate ( $params ['dob'] ),
				"email" => $params ['email'],
				"mobile" => $params ['mobile'],
				"address" => $params ['address'],
				"user_name" => $params ['user_name'],
				"password" => $db->encodeData ( $params ['password'] ),
				"created_by" => $_SESSION ['sys_user_id'],
				"created_at" => $db->now_time,
				"flag" => 0 
		);
		$msg = "";
		// print_r($columns_values);exit;
		if ($db->alreadyExists ( "Select * from system_user where user_name='" . $params ['user_name'] . "' and email='" . $params ['email'] . "'" )) {
			$res = $db->insertData ( $this->table_name, $columns_values );
			if ($res == true) {
				$msg = "Success";
			} else {
				$msg = "Failed";
			}
		} else {
			$msg = "Data Already Exists";
		}
		return $msg;
	}
	public function updateAction($params) {
		$db = new connection ();
		$pk = $params ['pk'];
		if ($pk != "") {
			$columns_values = array (
					"sys_name" => $params ['sys_name'],
					"sys_role_id" => $params ['sys_role_id'],
					"dob" => $db->storeDBDate ( $params ['dob'] ),
					"email" => $params ['email'],
					"mobile" => $params ['mobile'],
					"address" => $params ['address'],
					"user_name" => $params ['user_name'],
					"modified_by" => $_SESSION ['sys_user_id'],
					"modified_at" => $db->now_time,
					"flag" => 0 
			);
			$msg = "";
			if ($db->alreadyExists ( "Select * from system_user where flag=0 and user_name='" . $params ['user_name'] . "' and email='" . $params ['email'] . "' and sys_user_id!='$pk'" )) {
				$res = $db->updateData ( $this->table_name, $columns_values, " sys_user_id=$pk" );
				if ($res == true) {
					$msg = "Success";
				} else {
					$msg = "Failed";
				}
			} else {
				$msg = "Data Already Exists";
			}
		} else {
			$msg = "System Error";
		}
		return $msg;
	}
	public function selectAction($where = "") {
		$db = new connection ();
		$tableName = $this->table_name;
		if ($tableName != "") {
			$result = array ();
			$sel = "SELECT * FROM `$tableName` WHERE $where";
			if ($res = mysql_query ( $sel )) {
				if (mysql_num_rows ( $res ) > 0) {
					$select_Data = array ();
					$i = 0;
					while ( $row = mysql_fetch_array ( $res ) ) {
						
						$select_Data [$i] ['sys_user_id'] = $row ['sys_user_id'];
						$select_Data [$i] ['sys_name'] = $row ['sys_name'];
						$select_Data [$i] ['sys_role_id'] = $row ['sys_role_id'];
						$select_Data [$i] ['dob'] = $db->showDBDate ( $row ['dob'] );
						$select_Data [$i] ['email'] = $row ['email'];
						$select_Data [$i] ['mobile'] = $row ['mobile'];
						$select_Data [$i] ['address'] = $row ['address'];
						$select_Data [$i] ['user_name'] = $row ['user_name'];
						$select_Data [$i] ['password'] = $db->encodeData ( $row ['password'] );
						$select_Data [$i] ['created_by'] = $row ['created_by'];
						$select_Data [$i] ['created_at'] = $row ['created_at'];
						$select_Data [$i] ['modified_by'] = $row ['modified_by'];
						$select_Data [$i] ['modified_at'] = $row ['modified_at'];
						$select_Data [$i] ['flag'] = 0;
						
						$i ++;
					}
					
					return $select_Data;
				}
			} else {
				return false;
			}
		}
	}
	public function loginAction($params) {
		
		$db = new connection ();
		$user_name = $params ['user_name'];
		$tableName = $this->table_name;
		$password = $db->encodeData ( $params ['password'] );
		$rawQry = "SELECT * FROM `system_user` WHERE 1 and `flag`=0 and `user_name`='$user_name' and `password`='$password'";
		$res = $db->rawQry ( $rawQry );
		if ($res==true) {
			$sys_user = new SystemUserConrtoller ();
			$user_data = $sys_user->selectAction ( $where = " `flag`=0 and `user_name`='$user_name' and `password`='$password'" );
			$_SESSION ['sys_user_id'] = $user_data[0] ['sys_user_id'];
			$_SESSION ['sys_user_name'] = $user_data [0]['sys_name'];
			$_SESSION ['sys_role_id'] = $user_data[0] ['sys_role_id'];			
			header ( "Location:index.php" );
		} else {
			$msg = "Invalid Username and Password!";
			return $msg;
		}
	}
}

?>
