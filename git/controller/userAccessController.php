<?php
class userAccessController {

	/*
	 * Table Name
	*/
	public $table_name = "system_access";

	/**
	 *
	 * @var unknown
	 */
	public $db;
	public $sys_access_id;
	public $menu_id;
	public $sys_role_id;

	public $flag = 0;
	function __construct() {
		$db = new connection ();
	}
	public function insertAction($params) {
		$db = new connection ();
		if (isset ( $params ['menu_id'] )) {
			foreach ( $params ['menu_id'] as $pos => $val ) {
				$columns_values = array (
						"sys_access_id" => 'NULL',
						"menu_id" => $val,
						"sys_role_id" => $params ['sys_role_id'],
						"flag" => 0
				);
				$msg = "";
				if ($db->alreadyExists ( "Select * from system_access where flag=0 and sys_role_id='" . $params ['sys_role_id'] . "' and menu_id='$val'" )) {
					$res = $db->insertData ( $this->table_name, $columns_values );
					if ($res == true) {
						$msg = "Success";
					} else {
						$msg = "Failed";
					}
				} else {
					$msg = "Data Already Exists";
				}
			}
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

						$select_Data [$i] ['sys_access_id'] = $row ['sys_access_id'];
						$select_Data [$i] ['menu_id'] = $row ['menu_id'];
						$select_Data [$i] ['sys_role_id'] = $row ['sys_role_id'];
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
					"exam_type" => $params ['exam_type'],
					"description" => trim($params ['description']),
					"modified_at" => $db->now_time,
					"modified_by" => $_SESSION ['sys_user_id'],
					"flag" => 0
			);
			$msg = "";
			if ($db->alreadyExists ( "Select * from exam_type where flag=0 and exam_type='" . $params ['exam_type'] . "' and exam_type_id!=" . $pk )) {
				$res = $db->updateData ( $this->table_name, $columns_values, " exam_type_id=$pk" );
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
