<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_LeftmenuClassTblAccess extends dbcom_DBcontroll {

	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $leftmenudat;		// 検索結果を格納する２次元連想配列

	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_LeftmenuClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->leftmenudat = Array();	// ２次元連想配列
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}

	/*  管理者のログイン情報チェック  */
	/*
	function basedb_CheckLeftmenu () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
//echo("#0#0#");
			$this->php_error = "basedb_CheckLeftmenu(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		
		// ログイン情報取得
		$strSQL = "";
		$strSQL .= " SELECT * FROM v_leftmenu ";
		$strSQL .= "  WHERE lm_login_id_sec = '{$this->leftmenudat[0]["lm_login_id_sec"]}' ";
		$strSQL .= "    AND lm_login_pass_sec = '{$this->leftmenudat[0]["lm_login_pass_sec"]}' ";
		$strSQL .= "    AND lm_del_date IS NULL ";
	//echo "LeftmenuSearchSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_CheckLeftmenu(2):".pg_errormessage ($this->conn);
			return (-1);
		}
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->leftmenudat[0]["lm_login_id_sec"] != $arr["lm_login_id_sec"] ) {
			$this->php_error = "basedb_CheckLeftmenu(3):".pg_errormessage ($this->conn);
			return (1);
		}
		if ( $this->leftmenudat[0]["lm_login_pass_sec"] != $arr["lm_login_pass_sec"] ) {
			$this->php_error = "basedb_CheckLeftmenu(4):".pg_errormessage ($this->conn);
			return (1);
		}
		if ( $arr["lm_del_date"] != NULL ) {
			$this->php_error = "basedb_CheckLeftmenu(5): This leftmenu account is deleted. ";
			return (2);
		}
		if ( $arr["lm_stat"] != 1 ) {
			$this->php_error = "basedb_CheckLeftmenu(6): This leftmenu account is not use ( status ). ";
			return (3);
		}
		if ( $arr["lm_limit_date"] != NULL ) {
			if ( $arr["lm_limit_date"] < date("Y-m-d") ){
				$this->php_error = "basedb_CheckLeftmenu(7): This leftmenu account is not use ( limit date ). ";
				return (4);
			}
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_CheckLeftmenu(8):Get Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$this->leftmenudat[0]["lm_id"] = $arr["lm_id"];
		$this->leftmenudat[0]["lm_name"] = $arr["lm_name"];
		$this->leftmenudat[0]["lm_login_id"] = $arr["lm_login_id"];
		$this->leftmenudat[0]["lm_login_pass"] = $arr["lm_login_pass"];
		$this->leftmenudat[0]["lm_login_id_sec"] = $arr["lm_login_id_sec"];
		$this->leftmenudat[0]["lm_login_pass_sec"] = $arr["lm_login_pass_sec"];
		$this->leftmenudat[0]["lm_stat"] = $arr["lm_stat"];
		$this->leftmenudat[0]["lm_limit_date"] = $arr["lm_limit_date"];
		$this->leftmenudat[0]["blog_stat"] = $arr["blog_stat"];
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_CheckLeftmenu(9):Get Failed";
			return (-1);
		}
		
		return (0);
		
	}
	*/
	
	
	/*  クライアントテーブル　Ｓｅｌｅｃｔ  */
	function basedb_GetLeftmenu ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetLeftmenu(1):".$obj->php_error;
//echo($this->php_error);
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["lm_id"] != "" )      $sql_where .= " AND lm_id = '{$this->jyoken["lm_id"]}' ";
		if( $this->jyoken["lm_clid"] != "" )   $sql_where .= " AND lm_clid = '{$this->jyoken["lm_clid"]}' ";
		if( $this->jyoken["lm_stat"] != "" )	  $sql_where .= " AND lm_stat = {$this->jyoken["lm_stat"]} ";
		if( $this->jyoken["lm_type"] != "" )	  $sql_where .= " AND lm_type = {$this->jyoken["lm_type"]} ";
		if( $this->jyoken["lm_stitle"] != "" )    $sql_where .= " AND lm_stitle = '{$this->jyoken["lm_stitle"]}' ";
		if( $this->jyoken["lm_ltitle"] != "" ) $sql_where .= " AND lm_ltitle = '{$this->jyoken["lm_ltitle"]}' ";
		if( $this->jyoken["lm_dispno"] != "" ) $sql_where .= " AND lm_dispno = '{$this->jyoken["lm_dispno"]}' ";
		if( $this->jyoken["lm_deldate"] != "" )$sql_where .= " AND lm_deldate is NULL ";
		
		// ＳＱＬソート条件作成
		if ( $this->sort["lm_id"] == 1 ){
			$sql_order .= " ORDER BY lm_id desc ";
		}else if( $this->sort["lm_id"] == 2 ){
			$sql_order .= " ORDER BY lm_id ";
		}
		if ( $this->sort["lm_dispno"] == 1 ){
			$sql_order .= " ORDER BY lm_stat,lm_dispno desc ";
		}else if( $this->sort["lm_dispno"] == 2 ){
			$sql_order .= " ORDER BY lm_stat,lm_dispno ";
		}

		
		// ＳＱＬ文全体組み立て
		$strSQL = "";
		IF( $this->jyoken["table_name"] != "" ){
			$strSQL = " SELECT * FROM v_leftmenu ";
		}ELSE{
			$strSQL = " SELECT * FROM t_leftmenu ";
		}
		$stmt2 = "";
		$stmt2 .= " WHERE lm_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
	//echo "GetLeftmenu_SQL ... [".$strSQL."]<BR>";
		
		
		//　ＳＱＬ実行
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetLeftmenu(1):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetLeftmenu(2):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->leftmenudat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(lm_id) FROM t_leftmenu ";
		$strSQL .= $stmt2;
	//echo "GetLeftmenu_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetLeftmenu(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetLeftmenu(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetLeftmenu(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*  管理者情報テーブル　Ｉｎｓｅｒｔ  */
	function basedb_InsLeftmenu () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsLeftmenu(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_leftmenu IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsLeftmenu(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}

		//  表示順重複チェック
		if($this->leftmenudat[0]["lm_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_leftmenu ";
			$strSQL .= "  WHERE lm_dispno = '{$this->leftmenudat[0]["lm_dispno"]}' ";
			$strSQL .= "    AND lm_type = '{$this->leftmenudat[0]["lm_type"]}' ";
			$strSQL .= "    AND lm_deldate is null ";
			$strSQL .= "    AND lm_stat <> 9 ";
			$strSQL .= "    AND lm_clid = '{$this->leftmenudat[0]["lm_clid"]}' ";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "basedb_InsClient(3):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_numrows ( $result ) != 0 ) {
				$obj->dbcom_DbRollback ();
				return (2);
			}
		}

		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_leftmenu ";
		$strSQL .= "           ( ";
		$strSQL .= "             lm_clid , ";
		$strSQL .= "             lm_stat , ";
		$strSQL .= "             lm_type , ";
		$strSQL .= "             lm_title , ";
		$strSQL .= "             lm_dispno , ";
		$strSQL .= "             lm_adminid , ";
		$strSQL .= "             lm_insdate , ";
		$strSQL .= "             lm_upddate , ";
		$strSQL .= "             lm_yobi1 , ";
		$strSQL .= "             lm_yobi2 , ";
		$strSQL .= "             lm_yobi3 , ";
		$strSQL .= "             lm_yobi4 , ";
		$strSQL .= "             lm_yobi5";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->leftmenudat[0]["lm_clid"]!=""){
			$strSQL .= "             '{$this->leftmenudat[0]["lm_clid"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->leftmenudat[0]["lm_stat"]!=""){
			$strSQL .= "             '{$this->leftmenudat[0]["lm_stat"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->leftmenudat[0]["lm_type"]!=""){
			$strSQL .= "             '{$this->leftmenudat[0]["lm_type"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             '{$this->leftmenudat[0]["lm_title"]}' , ";
		if($this->leftmenudat[0]["lm_dispno"]!=""){
			$strSQL .= "             '{$this->leftmenudat[0]["lm_dispno"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->leftmenudat[0]["lm_adminid"]!=""){
			$strSQL .= "             '{$this->leftmenudat[0]["lm_adminid"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             'now' , ";
		$strSQL .= "             'now' , ";
		$strSQL .= "             '{$this->leftmenudat[0]["lm_yobi1"]}' , ";
		$strSQL .= "             '{$this->leftmenudat[0]["lm_yobi2"]}' , ";
		$strSQL .= "             '{$this->leftmenudat[0]["lm_yobi3"]}' , ";
		$strSQL .= "             '{$this->leftmenudat[0]["lm_yobi4"]}' , ";
		$strSQL .= "             '{$this->leftmenudat[0]["lm_yobi5"]}'";
		$strSQL .= "           ) ";
	//echo "LeftmenuInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsLeftmenu(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsLeftmenu(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// lm_idの取得
		$result = @pg_exec( $this->conn , " SELECT currval('t_leftmenu_lm_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsLeftmenu(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->leftmenudat[0]["lm_id"] = @pg_result( $result , 0 , currval );
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsLeftmenu(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  管理者情報テーブル　Ｕｐｄａｔｅ  */
	function basedb_UpdLeftmenu () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdLeftmenu(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_leftmenu ";
		$strSQL .= "  WHERE lm_id = '{$this->leftmenudat[0]["lm_id"]}' ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
//echo("##1##");
			$this->php_error = "basedb_UpdLeftmenu(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->leftmenudat[0]["lm_id"] != $arr["lm_id"] ) {
//echo("##2##");
			$this->php_error = "basedb_UpdLeftmenu(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->leftmenudat[0]["lm_upddate"] != $arr["lm_upddate"] ) {
//echo("##3##");
			$this->php_error = "basedb_UpdLeftmenu(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}

		//  表示順重複チェック
		if($this->leftmenudat[0]["lm_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_leftmenu ";
			$strSQL .= "  WHERE lm_dispno = '{$this->leftmenudat[0]["lm_dispno"]}' ";
			$strSQL .= "    AND lm_deldate is null ";
			$strSQL .= "    AND lm_stat <> 9 ";
			$strSQL .= "    AND lm_clid = '{$this->leftmenudat[0]["lm_clid"]}' ";
			$strSQL .= "    AND lm_type = '{$this->leftmenudat[0]["lm_type"]}' ";
			$strSQL .= "    AND lm_id <> '{$this->leftmenudat[0]["lm_id"]}' ";
		//echo "LeftmenuUpdSQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ) {
//echo("##4##");
				$this->php_error = "basedb_InsClient(3):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_numrows ( $result ) != 0 ) {
//echo("##5##");
				$obj->dbcom_DbRollback ();
				return (2);
			}
		}

		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_leftmenu ";
		$strSQL .= "    SET ";
		IF( $this->leftmenudat[0]["lm_clid"] != "" ){
			$strSQL .= "        lm_clid = '{$this->leftmenudat[0]["lm_clid"]}' , ";
		}ELSE{
			$strSQL .= "        lm_clid = NULL , ";
		}
		IF( $this->leftmenudat[0]["lm_type"] != "" ){
			$strSQL .= "        lm_type = '{$this->leftmenudat[0]["lm_type"]}' , ";
		}ELSE{
			$strSQL .= "        lm_type = NULL , ";
		}
		IF( $this->leftmenudat[0]["lm_stat"] != "" ){
			$strSQL .= "        lm_stat = '{$this->leftmenudat[0]["lm_stat"]}' , ";
		}ELSE{
			$strSQL .= "        lm_stat = NULL , ";
		}
		$strSQL .= "        lm_title = '{$this->leftmenudat[0]["lm_title"]}' , ";
		IF( $this->leftmenudat[0]["lm_dispno"] != "" ){
			$strSQL .= "        lm_dispno = '{$this->leftmenudat[0]["lm_dispno"]}' , ";
		}ELSE{
			$strSQL .= "        lm_dispno = NULL , ";
		}
		IF( $this->leftmenudat[0]["lm_adminid"] != "" ){
			$strSQL .= "        lm_adminid = '{$this->leftmenudat[0]["lm_adminid"]}' , ";
		}ELSE{
			$strSQL .= "        lm_adminid = NULL , ";
		}
		$strSQL .= "        lm_upddate = 'now' ";
		$strSQL .= "  WHERE lm_id = '{$this->leftmenudat[0]["lm_id"]}' ";
	//echo "LeftmenuUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdLeftmenu(7):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdLeftmenu(8):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdLeftmenu(9):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  管理者情報テーブル　Ｄｅｌｅｔｅ  */
	function basedb_DelLeftmenu ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelLeftmenu(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_leftmenu ";
		$strSQL .= "  WHERE lm_id = {$this->leftmenudat[0]["lm_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelLeftmenu(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->leftmenudat[0]["lm_id"] != $arr["lm_id"] ) {
			$this->php_error = "basedb_DelLeftmenu(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE t_leftmenu ";
				$strSQL .= "    SET lm_deldate = 'now' ";
				$strSQL .= "  WHERE lm_id = '{$this->leftmenudat[0]["lm_id"]}'";
			//echo "LeftmenuDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelLeftmenu(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}

				//  カテゴリ件数チェック
				$strSQL = "";
				$strSQL .= " SELECT * FROM t_category ";
				$strSQL .= "  WHERE cg_lmid = '{$this->leftmenudat[0]["lm_id"]}' ";
				$result3 = @pg_exec( $this->conn , $strSQL );
				if ( !$result3 ) {
					$this->php_error = "basedb_InsClient(3):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}

				//  管理者情報修正
				if ( pg_numrows ( $result3 ) != 0 ) {
					$strSQL = "";
					$strSQL .= " UPDATE t_category ";
					$strSQL .= "    SET ";
					$strSQL .= "        cg_deldate = 'now' ";
					$strSQL .= "  WHERE cg_lmid = '{$this->leftmenudat[0]["lm_id"]}' ";
			//echo "LeftmenuDspSQL ... [".$strSQL."]<BR>";
					$result2 = @pg_exec( $this->conn , $strSQL );
					if ( !$result2 ){
						$this->php_error = "basedb_UpdLeftmenu(7):".pg_errormessage ($this->conn);
						$obj->dbcom_DbRollback ();
						return (-1);
					}
				}

				@pg_free_result( $result3 );

				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM t_leftmenu ";
				$strSQL .= "  WHERE lm_id = '{$this->leftmenudat[0]["lm_id"]}'";
			//echo "LeftmenuDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelLeftmenu(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelLeftmenu(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "agentdb_InsUser(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}

	/*  表示順反映　Ｄｉｓｐ  */
	function basedb_DspLeftmenu () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdLeftmenu(1):".$obj->php_error;
			return (-1);
		}

		$flg = true;
		for ( $vX = 0; $vX < $this->leftmenudat[0]["intCnt"]; $vX++ ) {
			for ( $jX = 0; $jX < $this->leftmenudat[0]["intCnt"]; $jX++ ) {
				if ($vX != $jX && $this->leftmenudat[$vX]["lm_dispno"] == $this->leftmenudat[$jX]["lm_dispno"] ) {
					$flg = false;
					break;
				}
			}
		}
		if($flg == false){
				$this->php_error = "basedb_DspLeftmenu(2):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (2);
		}

		for($iX=0;$iX<$this->leftmenudat[0]["intCnt"];$iX++){

			//  レコードロック
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_leftmenu ";
			$strSQL .= "  WHERE lm_id = '{$this->leftmenudat[$iX]["lm_id"]}' ";
			$strSQL .= "    FOR UPDATE ";
			$result = @pg_exec ( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "basedb_UpdLeftmenu(2):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			//  該当データ・第３者が先に更新したかのチェック
			$arr = @pg_fetch_array ( $result , 0 );
			if ( $this->leftmenudat[$iX]["lm_id"] != $arr["lm_id"] ) {
				$this->php_error = "basedb_UpdLeftmenu(3):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( $this->leftmenudat[$iX]["lm_upddate"] != $arr["lm_upddate"] ) {
				$this->php_error = "basedb_UpdLeftmenu(4):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (1);
			}
			@pg_free_result( $result );

			//  管理者情報修正
			$strSQL = "";
			$strSQL .= " UPDATE t_leftmenu ";
			$strSQL .= "    SET ";
			$strSQL .= "        lm_dispno = '{$this->leftmenudat[$iX]["lm_dispno"]}' , ";
			$strSQL .= "        lm_upddate = 'now' ";
			$strSQL .= "  WHERE lm_id = '{$this->leftmenudat[$iX]["lm_id"]}' ";
	//echo "LeftmenuDspSQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ){
				$this->php_error = "basedb_UpdLeftmenu(7):".pg_errormessage ($this->conn);
				$obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_cmdtuples( $result ) != 1 ) {
				$this->php_error = "basedb_UpdLeftmenu(8):Update Failed";
				$obj->dbcom_DbRollback ();
				return (-1);
			}
		
		}

		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdLeftmenu(9):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


}
?>
