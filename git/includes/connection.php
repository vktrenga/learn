<?php
// include_once "../../dbConfig.php";
/**
 *
 * @var unknown
 */
define ( "HOST", "localhost" );
define ( "USERNAME", "root" );
define ( "PASSWORD", "123" );
define ( "DATABASE", "exam" );

ob_start ();
session_start ();
class connection {
	public $now_time;
	function __construct() {
		if (! isset ( $_SESSION ['sys_user_id'] ) && ! isset ( $_SESSION ['sys_user_name'] ) && ! isset ( $_SESSION ['sys_role_id'] )) {
			if ($_SESSION ['sys_user_id'] == "" && $_SESSION ['sys_user_name'] == "" && $_SESSION ['sys_role_id'] == "") {
				header ( "Location:logout.php" );
			}
		}
		$conn = mysql_connect ( HOST, USERNAME, PASSWORD ) or die ( mysql_error () . " - DB Server Not Connect" );
		mysql_select_db ( DATABASE, $conn ) or die ( mysql_errno () . " DB Not Fount" );
		$this->now_time = date ( "Y-m-d H:i:s" );
	}
	public function dbClose() {
		mysql_close ();
	}
	public function insertData($tableName, $columns_values) {
		if (count ( $columns_values ) > 0) {
			
			$column_array = array ();
			$value_array = array ();
			foreach ( $columns_values as $column => $value ) {
				$column_array [] = $column;
				$value_array [] = mysql_escape_string ( $value );
			}
			$column_array = implode ( "`,`", $column_array );
			$value_array = implode ( "','", $value_array );
			$qry = "INSERT INTO `$tableName` (`" . $column_array . "`) VALUES ('" . $value_array . "')";
			if (mysql_query ( $qry )) {
				$insert_id=mysql_insert_id();
				return $insert_id;
			} else {
				return false;
			}
		}
	}
	public function alreadyExists($qry) {
		if ($qry != "") {
			if ($ex_res = mysql_query ( $qry )) {
				if (mysql_num_rows ( $ex_res ) == 0) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function updateData($tableName, $columns_values, $where) {
		if (count ( $columns_values ) > 0 && $where != "") {
			
			$fields = "";
			$u = 1;
			foreach ( $columns_values as $column => $value ) {
				$value = mysql_escape_string ( $value );
				$fields .= "`$column`='$value'";
				if ($u < count ( $columns_values )) {
					$fields .= ",";
				}
				$u ++;
			}
			
			$qry = "UPDATE `$tableName` SET $fields WHERE  $where";
			if (mysql_query ( $qry )) {
				return true;
			} else {
				return false;
			}
		}
	}
	public function deleteData($tableName, $where) {
		if ($tableName != "" && $where != "") {
			
			$qry = "UPDATE `$tableName` SET flag=1 WHERE  $where";
			if (mysql_query ( $qry )) {
				return true;
			} else {
				return false;
			}
		}
	}
	public function selectData($tableName, $fields, $where) {
		if ($tableName != "" && $where != "") {
			if (count ( $fields ) > 0) {
				$fields = "`" . implode ( "`,`", $fields ) . "`";
			} else {
				$fields = "*";
			}
			$result = array ();
			$sel = "SELECT $fields FROM `$tableName` WHERE $where";
			if ($res = mysql_query ( $sel )) {
				if (mysql_num_rows ( $res ) > 0) {
					$val = array ();
					while ( $row = mysql_fetch_assoc ( $res ) ) {
						$val [] = $row ['type'];
					}
					return $val;
				}
			} else {
				return false;
			}
		}
	}
	public function rawQry($qry) {
		if ($qry != "") {
			if ($ex_res = mysql_query ( $qry )) {
				if (mysql_num_rows ( $ex_res ) > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function showMessage($status, $msg) {
		switch ($status) {
			case 0 :
				$s = "info";
				break;
			case 1 :
				$s = "success";
				break;
			case 2 :
				$s = "info";
				break;
			case 3 :
				$s = "danger";
				break;
			default :
				$s = "success";
				break;
		}
		echo '<div class="alert-' . $s . '" id="msgDivContent" style="padding:2px;text-align:center;width:50%;"><strong>' . $msg . '</strong></div>';
	}
	public function showDBDateTime($data) {
		if ($data != "") {
			return date ( "d-m-Y h:i a", strtotime ( $data ) );
		} else {
			return $data;
		}
	}
	public function showDBDate($data) {
		if ($data != "") {
			return date ( "d-m-Y", strtotime ( $data ) );
		} else {
			return $data;
		}
	}
	public function storeDBDateTime($data) {
		if ($data != "") {
			return date ( "Y-m-d h:i a", strtotime ( $data ) );
		} else {
			return $data;
		}
	}
	public function storeDBDate($data) {
		if ($data != "") {
			return date ( "Y-m-d", strtotime ( $data ) );
		} else {
			return $data;
		}
	}
	public function encodeData($data) {
		if ($data != "") {
			return base64_encode ( $data );
		} else {
			return $data;
		}
	}
	public function decodeData($data) {
		if ($data != "") {
			
			return base64_decode ( $data );
		} else {
			return $data;
		}
	}
}
$db = new connection ();

?>
