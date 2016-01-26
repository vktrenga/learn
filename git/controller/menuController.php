<?php
class menuController {

	/*
	 * Table Name
	*/
	public $table_name = "menu";

	/**
	 *
	 * @var unknown
	 */
	public $db;
	public $menu_id;
	public $menu_name;
	public $url;
	public $created_at;
	public $created_by;
	public $flag = 0;
	function __construct() {
		$db = new connection ();
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

						$select_Data [$i] ['menu_id'] = $row ['menu_id'];
						$select_Data [$i] ['menu_name'] = $row ['menu_name'];
						$select_Data [$i] ['url'] = $row ['url'];
						$select_Data [$i] ['created_at'] = $row ['created_at'];
						$select_Data [$i] ['created_by'] = $row ['created_by'];
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

}
?>
