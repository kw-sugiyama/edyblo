<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_RoomClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $roomdat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_RoomClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->roomdat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetCnt ( $id ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetRoom(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//　クライアントテーブル
		$strSQL = "";
		$strSQL = " SELECT count(cl_id) FROM base_t_client ";
		$strSQL .= " WHERE cl_id = {$id} ";
		
		//　ＳＱＬ実行
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//　ブログ基本情報テーブル
		$strSQL = "";
		$strSQL = " SELECT count(blog_cl_id) FROM base_t_blog ";
		$strSQL .= " WHERE blog_cl_id = {$id} ";
		
		//　ＳＱＬ実行
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows += @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//　カテゴリ情報テーブル
		$strSQL = "";
		$strSQL = " SELECT count(cate_cl_id) FROM base_t_category ";
		$strSQL .= " WHERE cate_cl_id = {$id} ";
		
		//　ＳＱＬ実行
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows += @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//　建物部屋情報テーブル
		$strSQL = "";
		$strSQL = " SELECT count(build_id) FROM base_v_buiroom ";
		$strSQL .= " WHERE build_cl_id = {$id} ";
		
		//　ＳＱＬ実行
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows += @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//　日記情報テーブル
		$strSQL = "";
		$strSQL = " SELECT count(diary_id) FROM base_t_diary ";
		$strSQL .= " WHERE diary_cl_id = {$id} ";
		
		//　ＳＱＬ実行
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows += @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//　クライアントテーブル　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cl_id) FROM base_t_client ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		//　ブログ基本情報テーブル　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(blog_id) FROM base_t_blog ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total += @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		//　カテゴリ情報テーブル　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cate_id) FROM base_t_category ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total += @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		//　建物部屋情報テーブル　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(build_id) FROM base_v_buiroom ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total += @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		//　日記情報テーブル　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(diary_id) FROM base_t_diary ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total += @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetRoom(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $numrows , $total );
		
	}
	
}
?>
