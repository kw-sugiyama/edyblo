<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_FreeClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $freedat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_FreeClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->freedat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetFree ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetFree(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["fr_id"] != "" )       $sql_where .= " AND fr_id = {$this->jyoken["fr_id"]} ";
		if( $this->jyoken["fr_clid"] != "" )       $sql_where .= " AND fr_clid = {$this->jyoken["fr_clid"]} ";


        //削除は表示しない
        if( $this->jyoken["fr_deldate"] == "" ) 
        {
            $sql_where .= " AND fr_deldate is NULL ";
        }
            $sql_where .= " AND fr_deldate is NULL ";

		
		// 並び順
		$sql_order = "";
		IF( $this->sort["fr_upddate"] == 2 ){
			$sql_order = " ORDER BY fr_upddate desc ";
		}
		IF( $this->sort["fr_upddate"] == 1 ){
			$sql_order = " ORDER BY fr_upddate ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_free ";
		$stmt2 = "";
		$stmt2 .= " WHERE fr_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo "GetFree_SQL ... [".$strSQL."]<BR>";
        $result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetFree(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetFree(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
        }


        $numrows = pg_numrows( $result );
		$cnt = 0;
        for ( $curpos=0; $curpos<$numrows; $curpos++ ) 
        {
            $arr = pg_fetch_array( $result , $curpos );
            reset($arr);
            while( list( $key,$val ) = each( $arr ) )
            {
                $this->freedat[$curpos][$key] = $val;
            }
            $cnt++;
        }
		@pg_free_result( $result );


		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(fr_id) FROM t_free ";
		$strSQL .= $stmt2;
	//echo "GetFree_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetFree(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetFree(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetFree(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
    }



	/*-----------------------------------------------------
	    ブログ基本情報 - 登録
	-----------------------------------------------------*/
	function basedb_Insfree () {
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_Insfree(1):".$obj->php_error;
			return (-1);
		}
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_free ";
		$strSQL .= "           ( ";
		$strSQL .= "             fr_clid, ";
		$strSQL .= "             fr_title , ";
		$strSQL .= "             fr_html , ";
		$strSQL .= "             fr_insdate , ";
		$strSQL .= "             fr_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->freedat[0]["fr_clid"]}' , ";
		$strSQL .= "             '{$this->freedat[0]["fr_title"]}' , ";
		$strSQL .= "             '{$this->freedat[0]["fr_html"]}' , ";
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
        //echo "freeInsSQL ... [".$strSQL."]<BR>";

        $result = @pg_exec( $this->conn , $strSQL );
        //エラー
		if ( !$result ) {
			$this->php_error = "basedb_Insfree(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
        //変更がなければエラー
        if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_Insfree(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
        @pg_free_result( $result );
		//  トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_Insfree(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}
	/*-----------------------------------------------------
	    情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdFree() {

		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdTeacher(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_free ";
		$strSQL .= "  WHERE fr_id = {$this->freedat[0]["fr_id"]} ";
        $strSQL .= "    FOR UPDATE ";
//echo( $strSQL);

		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
//echo("##0##upd##");
			$this->php_error = "basedb_UpdTeacher(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}

		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_free ";
		$strSQL .= "    SET ";
		if($this->freedat[0]["fr_title"] != ""){
			$strSQL .= "        fr_title = '{$this->freedat[0]["fr_title"]}' , ";
		}else{
			$strSQL .= "        fr_title = NULL , ";
        }

		if($this->freedat[0]["fr_html"] != ""){
			$strSQL .= "        fr_html = '{$this->freedat[0]["fr_html"]}' , ";
		}else{
			$strSQL .= "        fr_html = NULL , ";
		}
	
		
		$strSQL .= "        fr_upddate = 'now' ";
		$strSQL .= "  WHERE fr_id = {$this->freedat[0]["fr_id"]} ";
//echo "TeacherUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdTeacher(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdTeacher(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdTeacher(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}

	/*-----------------------------------------------------
	    情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_DelFree() {

		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdTeacher(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_free ";
		$strSQL .= "  WHERE fr_id = {$this->freedat[0]["fr_id"]} ";
        $strSQL .= "    FOR UPDATE ";
//echo( $strSQL);

		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
//echo("##0##upd##");
			$this->php_error = "basedb_UpdTeacher(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_free ";
        $strSQL .= "    SET ";
        /*
		if($this->freedat[0]["fr_title"] != ""){
			$strSQL .= "        fr_title = '{$this->freedat[0]["fr_title"]}' , ";
		}else{
			$strSQL .= "        fr_title = NULL , ";
        }

		if($this->freedat[0]["fr_html"] != ""){
			$strSQL .= "        fr_html = '{$this->freedat[0]["fr_html"]}' , ";
		}else{
			$strSQL .= "        fr_html = NULL , ";
        }
        */
		
		$strSQL .= "        fr_deldate = 'now' ";
		$strSQL .= "  WHERE fr_id = {$this->freedat[0]["fr_id"]} ";
//echo "TeacherUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdTeacher(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdTeacher(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdTeacher(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}
}
?>
