<?
/******************************************************************************
		データベーストランザクションClassライブラリ
******************************************************************************/

class dbcom_DBcontroll {



	// メンバー変数定義

	var $conn;

	var $php_error;

	var $db_name;

	var $db_user;

	var $db_pwd;

	var $db_user_csv;

	var $db_pwd_csv;

	var $db_server;

	var $db_port;



	/* コンストラクタ */

	function dbcom_DBcontroll () {

		$this->conn = NULL;

		$this->php_error = NULL;

	}



	/* トランザクション開始宣言 */

	function dbcom_DbBeginTran () {

		$result = @pg_exec ( $this->conn, "begin" );
		if ( !$result ) {

			$this->php_error = "dbcom_DbBeginTran:".pg_errormessage($this->conn);

			return(-1);

		} else {

			return (0);

		}

	}



	/* トランザクションコミット */

	function dbcom_DbCommit () {



		$result = @pg_exec ( $this->conn, "commit" );

		if ( !$result ) {

			$this->php_error = "dbcom_DbCommit:".pg_errormessage($this->conn);

			return(-1);

		} else {

			return(0);

		}

	}



	/* トランザクションロールバック */

	function dbcom_DbRollback () {



		$result = @pg_exec ( $this->conn, "rollback" );

		if ( !$result ) {

			$this->php_error = "dbcom_DbRollback:".pg_errormessage($this->conn);

			return(-1);

		} else {

			return(0);

		}

	}



}

?>
