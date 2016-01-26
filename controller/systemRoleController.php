<?php
class SystemRoleConrtoller {
	
	/*
	 * Table Name
	 */
	public $table_name = "system_role";
	
	/**
	 *
	 * @var unknown
	 */
	public $db;
	public $sys_role_id;
	public $sys_role;
	public $created_at;
	public $flag = 0;
	function __construct() {
		$db = new connection ();
	}
	public function insertAction($params) {
		$db = new connection ();
		$columns_values = array (
				"sys_role_id" => 'NULL',
				"sys_role" => $params ['sys_role'],
				"created_at" => $db->now_time,
				"flag" => 0 
		);
		$msg = "";
		if ($db->alreadyExists ( "Select * from system_role where sys_role='" . $params ['sys_role'] . "'" )) {
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
	public function selectAction($where = "") {
		$tableName = $this->table_name;
		if ($tableName != "") {
			$result = array ();
			$sel = "SELECT * FROM `$tableName` WHERE $where";
			if ($res = mysql_query ( $sel )) {
				if (mysql_num_rows ( $res ) > 0) {
					$select_Data = array ();
					$i = 0;
					while ( $row = mysql_fetch_array ( $res ) ) {
						
						$select_Data [$i] ['sys_role_id'] = $row ['sys_role_id'];
						$select_Data [$i] ['sys_role'] = $row ['sys_role'];
						$select_Data [$i] ['created_at'] = $row ['created_at'];
						$select_Data [$i] ['flag'] = $row ['flag'];
						$i ++;
					}
					
					return $select_Data;
				}
			} else {
				return false;
			}
		}
	}
	public function updateAction($params) {
		$db = new connection ();
		$pk = $params ['pk'];
		if ($pk != "") {
			$columns_values = array (
					"sys_role_id" => $pk,
					"sys_role" => $params ['sys_role'],
					"created_at" => $db->now_time,
					"flag" => 0 
			);
			$msg = "";
			if ($db->alreadyExists ( "Select * from system_role where sys_role='" . $params ['sys_role'] . "' and sys_role_id!=" . $pk )) {
				$res = $db->updateData ( $this->table_name, $columns_values, " sys_role_id=$pk" );
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
}
?>
