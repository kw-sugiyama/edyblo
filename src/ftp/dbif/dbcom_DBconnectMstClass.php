<?
/******************************************************************************
	DB接続用Classライブラリ
******************************************************************************/
class dbcom_DBconnectMstClass {

	// メンバー変数定義
	var $conn;
	var $php_error;
	var $db_server;
	var $db_port;
	var $db_name;
	var $db_user;
	var $db_pwd;


	/* コンストラクタ */
	function dbcom_DBconnectMstClass () {
		
		include( SYS_PATH."configs/param_connect.conf" );
		
		$this->conn = NULL;
		$this->php_error = NULL;
		$this->db_server = $param_mst_db_connect["db_server"];
		$this->db_port = $param_mst_db_connect["db_port"];
		$this->db_name = $param_mst_db_connect["db_name"];
		$this->db_user = $param_mst_db_connect["db_user"];
		$this->db_pwd = $param_mst_db_connect["db_pwd"];
	}


	/* データベース接続 */
	function dbcom_DbConnectMst() {
		$this->conn = pg_connect( "host=$this->db_server port=$this->db_port dbname=$this->db_name user=$this->db_user password=$this->db_pwd" );
		if ( !$this->conn ) {
			$this->php_error = "dbcom_DbConnect:DB Connect Error";
			return (-1);
		} else {
			return (0);
		}
	}


	/* データベース切断 */
	function dbcom_DbDisconnectMst () {
		
		if ( !pg_close ( $this->conn ) ) {
			$this->php_error = "dbcom_DbDisconnect:".pg_errormessage($this->conn);
			return(-1);
		} else {
			return (0);
		}
	}
}
?>
