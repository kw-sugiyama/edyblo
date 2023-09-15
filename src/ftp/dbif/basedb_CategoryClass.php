<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_CategoryClassTblAccess extends dbcom_DBcontroll {

	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $categorydat;		// 検索結果を格納する２次元連想配列

	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_CategoryClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->categorydat = Array();	// ２次元連想配列
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}

	/*  管理者のログイン情報チェック  */
	/*
	function basedb_CheckCategory () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
//echo("#0#0#");
			$this->php_error = "basedb_CheckCategory(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		
		// ログイン情報取得
		$strSQL = "";
		$strSQL .= " SELECT * FROM v_category ";
		$strSQL .= "  WHERE cg_login_id_sec = '{$this->categorydat[0]["cg_login_id_sec"]}' ";
		$strSQL .= "    AND cg_login_pass_sec = '{$this->categorydat[0]["cg_login_pass_sec"]}' ";
		$strSQL .= "    AND cg_del_date IS NULL ";
	//echo "CategorySearchSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_CheckCategory(2):".pg_errormessage ($this->conn);
			return (-1);
		}
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->categorydat[0]["cg_login_id_sec"] != $arr["cg_login_id_sec"] ) {
			$this->php_error = "basedb_CheckCategory(3):".pg_errormessage ($this->conn);
			return (1);
		}
		if ( $this->categorydat[0]["cg_login_pass_sec"] != $arr["cg_login_pass_sec"] ) {
			$this->php_error = "basedb_CheckCategory(4):".pg_errormessage ($this->conn);
			return (1);
		}
		if ( $arr["cg_del_date"] != NULL ) {
			$this->php_error = "basedb_CheckCategory(5): This category account is deleted. ";
			return (2);
		}
		if ( $arr["cg_stat"] != 1 ) {
			$this->php_error = "basedb_CheckCategory(6): This category account is not use ( status ). ";
			return (3);
		}
		if ( $arr["cg_limit_date"] != NULL ) {
			if ( $arr["cg_limit_date"] < date("Y-m-d") ){
				$this->php_error = "basedb_CheckCategory(7): This category account is not use ( limit date ). ";
				return (4);
			}
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_CheckCategory(8):Get Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$this->categorydat[0]["cg_id"] = $arr["cg_id"];
		$this->categorydat[0]["cg_name"] = $arr["cg_name"];
		$this->categorydat[0]["cg_login_id"] = $arr["cg_login_id"];
		$this->categorydat[0]["cg_login_pass"] = $arr["cg_login_pass"];
		$this->categorydat[0]["cg_login_id_sec"] = $arr["cg_login_id_sec"];
		$this->categorydat[0]["cg_login_pass_sec"] = $arr["cg_login_pass_sec"];
		$this->categorydat[0]["cg_stat"] = $arr["cg_stat"];
		$this->categorydat[0]["cg_limit_date"] = $arr["cg_limit_date"];
		$this->categorydat[0]["blog_stat"] = $arr["blog_stat"];
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_CheckCategory(9):Get Failed";
			return (-1);
		}
		
		return (0);
		
	}
	*/
	
	
	/*  クライアントテーブル　Ｓｅｌｅｃｔ  */
	function basedb_GetCategory ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetCategory(1):".$obj->php_error;
//echo($this->php_error);
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cg_id"] != "" )      $sql_where .= " AND cg_id = '{$this->jyoken["cg_id"]}' ";
		if( $this->jyoken["cg_clid"] != "" )   $sql_where .= " AND cg_clid = '{$this->jyoken["cg_clid"]}' ";
		if( $this->jyoken["cg_lmid"] != "" )   $sql_where .= " AND cg_lmid = '{$this->jyoken["cg_lmid"]}' ";
		if( $this->jyoken["cg_stat"] != "" )	  $sql_where .= " AND cg_stat = {$this->jyoken["cg_stat"]} ";
		if( $this->jyoken["cg_type"] != "" )	  $sql_where .= " AND cg_type = {$this->jyoken["cg_type"]} ";
		if( $this->jyoken["cg_stitle"] != "" )    $sql_where .= " AND cg_stitle = '{$this->jyoken["cg_stitle"]}' ";
		if( $this->jyoken["cg_ltitle"] != "" ) $sql_where .= " AND cg_ltitle = '{$this->jyoken["cg_ltitle"]}' ";
		if( $this->jyoken["cg_dispno"] != "" ) $sql_where .= " AND cg_dispno = '{$this->jyoken["cg_dispno"]}' ";
		if( $this->jyoken["cg_deldate"] != "" )$sql_where .= " AND cg_deldate is NULL ";
		
		// ＳＱＬソート条件作成
		if ( $this->sort["cg_id"] == 1 ){
			$sql_order .= " ORDER BY cg_id desc ";
		}else if( $this->sort["cg_id"] == 2 ){
			$sql_order .= " ORDER BY cg_id ";
		}
		if ( $this->sort["cg_dispno"] == 1 ){
			$sql_order .= " ORDER BY cg_stat,cg_dispno desc ";
		}else if( $this->sort["cg_dispno"] == 2 ){
			$sql_order .= " ORDER BY cg_stat,cg_dispno ";
		}

		
		// ＳＱＬ文全体組み立て
		$strSQL = "";
		IF( $this->jyoken["table_name"] != "" ){
			$strSQL = " SELECT * FROM v_category ";
		}ELSE{
			$strSQL = " SELECT * FROM t_category ";
		}
		$stmt2 = "";
		$stmt2 .= " WHERE cg_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
	//echo "GetCategory_SQL ... [".$strSQL."]<BR>";
		
		
		//　ＳＱＬ実行
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCategory(1):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetCategory(2):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->categorydat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cg_id) FROM t_category ";
		$strSQL .= $stmt2;
	//echo "GetCategory_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCategory(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetCategory(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetCategory(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*  管理者情報テーブル　Ｉｎｓｅｒｔ  */
	function basedb_InsCategory () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsCategory(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_category IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCategory(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}

		//  表示順重複チェック
		if($this->categorydat[0]["cg_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_category ";
			$strSQL .= "  WHERE cg_dispno = '{$this->categorydat[0]["cg_dispno"]}' ";
			$strSQL .= "    AND cg_deldate is null ";
			$strSQL .= "    AND cg_stat <> 9 ";
			$strSQL .= "    AND cg_clid = '{$this->categorydat[0]["cg_clid"]}' ";
			$strSQL .= "    AND cg_type = '{$this->categorydat[0]["cg_type"]}' ";
			if($this->categorydat[0]["cg_lmid"]!="" && $this->categorydat[0]["cg_lmid"]!=null)$strSQL .= "    AND cg_lmid = '{$this->categorydat[0]["cg_lmid"]}' ";
			if($this->categorydat[0]["cg_lmid"]=="" || $this->categorydat[0]["cg_lmid"]==null)$strSQL .= "    AND cg_lmid is not null ";
			$result = @pg_exec( $this->conn , $strSQL );
//echo($strSQL);
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

		//  TOP_FLAGチェック
		if($this->categorydat[0]["cg_topflg"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_category ";
			$strSQL .= "  WHERE cg_topflg = 1 ";
			$strSQL .= "    AND cg_deldate is null ";
			$strSQL .= "    AND cg_clid = '{$this->categorydat[0]["cg_clid"]}' ";
			$strSQL .= "    AND cg_type = '{$this->categorydat[0]["cg_type"]}' ";
			$result = @pg_exec( $this->conn , $strSQL );
//echo($strSQL);
			if ( !$result ) {
				$this->php_error = "basedb_InsClient(4):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_numrows ( $result ) != 0 ) {
				$obj->dbcom_DbRollback ();
				return (10);
			}
		}

		@pg_free_result( $result );

		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_category ";
		$strSQL .= "           ( ";
		$strSQL .= "             cg_clid , ";
		$strSQL .= "             cg_lmid , ";
		$strSQL .= "             cg_stat , ";
		$strSQL .= "             cg_type , ";
		$strSQL .= "             cg_topflg , ";
		$strSQL .= "             cg_stitle , ";
		$strSQL .= "             cg_ltitle , ";
		$strSQL .= "             cg_dispno , ";
		$strSQL .= "             cg_adminid , ";
		$strSQL .= "             cg_insdate , ";
		$strSQL .= "             cg_upddate , ";
		$strSQL .= "             cg_yobi1 , ";
		$strSQL .= "             cg_yobi2 , ";
		$strSQL .= "             cg_yobi3 , ";
		$strSQL .= "             cg_yobi4 , ";
		$strSQL .= "             cg_yobi5";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->categorydat[0]["cg_clid"]!=""){
			$strSQL .= "             '{$this->categorydat[0]["cg_clid"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->categorydat[0]["cg_lmid"]!=""){
			$strSQL .= "             '{$this->categorydat[0]["cg_lmid"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->categorydat[0]["cg_stat"]!=""){
			$strSQL .= "             '{$this->categorydat[0]["cg_stat"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->categorydat[0]["cg_type"]!=""){
			$strSQL .= "             '{$this->categorydat[0]["cg_type"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->categorydat[0]["cg_topflg"]!=""){
			$strSQL .= "             '{$this->categorydat[0]["cg_topflg"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             '{$this->categorydat[0]["cg_stitle"]}' , ";
		$strSQL .= "             '{$this->categorydat[0]["cg_ltitle"]}' , ";
		if($this->categorydat[0]["cg_dispno"]!=""){
			$strSQL .= "             '{$this->categorydat[0]["cg_dispno"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->categorydat[0]["cg_adminid"]!=""){
			$strSQL .= "             '{$this->categorydat[0]["cg_adminid"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             'now' , ";
		$strSQL .= "             'now' , ";
		$strSQL .= "             '{$this->categorydat[0]["cg_yobi1"]}' , ";
		$strSQL .= "             '{$this->categorydat[0]["cg_yobi2"]}' , ";
		$strSQL .= "             '{$this->categorydat[0]["cg_yobi3"]}' , ";
		$strSQL .= "             '{$this->categorydat[0]["cg_yobi4"]}' , ";
		$strSQL .= "             '{$this->categorydat[0]["cg_yobi5"]}'";
		$strSQL .= "           ) ";
	//echo "CategoryInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCategory(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsCategory(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cg_idの取得
		$result = @pg_exec( $this->conn , " SELECT currval('t_category_cg_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsCategory(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->categorydat[0]["cg_id"] = @pg_result( $result , 0 , currval );
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsCategory(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  管理者情報テーブル　Ｕｐｄａｔｅ  */
	function basedb_UpdCategory () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCategory(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_category ";
		$strSQL .= "  WHERE cg_id = '{$this->categorydat[0]["cg_id"]}' ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
//echo("##1##");
			$this->php_error = "basedb_UpdCategory(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->categorydat[0]["cg_id"] != $arr["cg_id"] ) {
//echo("##2##");
			$this->php_error = "basedb_UpdCategory(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->categorydat[0]["cg_upddate"] != $arr["cg_upddate"] ) {
//echo("##3##");
			$this->php_error = "basedb_UpdCategory(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}

		//  表示順重複チェック
		if($this->categorydat[0]["cg_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_category ";
			$strSQL .= "  WHERE cg_dispno = '{$this->categorydat[0]["cg_dispno"]}' ";
			$strSQL .= "    AND cg_deldate is null ";
			$strSQL .= "    AND cg_stat <> 9 ";
			$strSQL .= "    AND cg_clid = '{$this->categorydat[0]["cg_clid"]}' ";
			$strSQL .= "    AND cg_type = '{$this->categorydat[0]["cg_type"]}' ";
			$strSQL .= "    AND cg_id <> '{$this->categorydat[0]["cg_id"]}' ";
			if($this->categorydat[0]["cg_lmid"]!="")$strSQL .= "    AND cg_lmid = '{$this->categorydat[0]["cg_lmid"]}' ";
		//echo "CategoryUpdSQL ... [".$strSQL."]<BR>";
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

		//  TOP_FLAGチェック
		if($this->categorydat[0]["cg_topflg"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_category ";
			$strSQL .= "  WHERE cg_topflg = 1 ";
			$strSQL .= "    AND cg_deldate is null ";
			$strSQL .= "    AND cg_id <> '{$this->categorydat[0]["cg_id"]}' ";
			$strSQL .= "    AND cg_clid = '{$this->categorydat[0]["cg_clid"]}' ";
			$strSQL .= "    AND cg_type = '{$this->categorydat[0]["cg_type"]}' ";
		//echo "CategoryUpdSQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "basedb_InsClient(4):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_numrows ( $result ) != 0 ) {

				@pg_free_result( $result );

				$strSQL = "";
				$strSQL .= " UPDATE t_category ";
				$strSQL .= "    SET ";
				$strSQL .= "        cg_topflg = 9 ";
				$strSQL .= " where cg_clid = {$this->categorydat[0]["cg_clid"]} ";
				$strSQL .= " AND cg_type = 1 ";
			//echo "CategoryUpdSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec( $this->conn , $strSQL );
				if ( !$result ){
					$this->php_error = "basedb_UpdCategory(7):".pg_errormessage ($this->conn);
					$obj->dbcom_DbRollback ();
					return (-1);
				}
			}

		@pg_free_result( $result );

		}


		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_category ";
		$strSQL .= "    SET ";
		IF( $this->categorydat[0]["cg_clid"] != "" ){
			$strSQL .= "        cg_clid = '{$this->categorydat[0]["cg_clid"]}' , ";
		}ELSE{
			$strSQL .= "        cg_clid = NULL , ";
		}
		IF( $this->categorydat[0]["cg_lmid"] != "" ){
			$strSQL .= "        cg_lmid = '{$this->categorydat[0]["cg_lmid"]}' , ";
		}ELSE{
			$strSQL .= "        cg_lmid = NULL , ";
		}
		IF( $this->categorydat[0]["cg_type"] != "" ){
			$strSQL .= "        cg_type = '{$this->categorydat[0]["cg_type"]}' , ";
		}ELSE{
			$strSQL .= "        cg_type = NULL , ";
		}
		IF( $this->categorydat[0]["cg_stat"] != "" ){
			$strSQL .= "        cg_stat = '{$this->categorydat[0]["cg_stat"]}' , ";
		}ELSE{
			$strSQL .= "        cg_stat = NULL , ";
		}
		IF( $this->categorydat[0]["cg_yobi1"] != "" ){
			$strSQL .= "        cg_yobi1 = '{$this->categorydat[0]["cg_yobi1"]}' , ";
		}ELSE{
			$strSQL .= "        cg_yobi1 = NULL , ";
		}
		IF( $this->categorydat[0]["cg_yobi2"] != "" ){
			$strSQL .= "        cg_yobi2 = '{$this->categorydat[0]["cg_yobi2"]}' , ";
		}ELSE{
			$strSQL .= "        cg_yobi2 = NULL , ";
		}
		IF( $this->categorydat[0]["cg_yobi3"] != "" ){
			$strSQL .= "        cg_yobi3 = '{$this->categorydat[0]["cg_yobi3"]}' , ";
		}ELSE{
			$strSQL .= "        cg_yobi3 = NULL , ";
		}
		IF( $this->categorydat[0]["cg_topflg"] != "" ){
			$strSQL .= "        cg_topflg = '{$this->categorydat[0]["cg_topflg"]}' , ";
		}ELSE{
			$strSQL .= "        cg_topflg = NULL , ";
		}
		$strSQL .= "        cg_stitle = '{$this->categorydat[0]["cg_stitle"]}' , ";
		$strSQL .= "        cg_ltitle = '{$this->categorydat[0]["cg_ltitle"]}' , ";
		IF( $this->categorydat[0]["cg_dispno"] != "" ){
			$strSQL .= "        cg_dispno = '{$this->categorydat[0]["cg_dispno"]}' , ";
		}ELSE{
			$strSQL .= "        cg_dispno = NULL , ";
		}
		IF( $this->categorydat[0]["cg_adminid"] != "" ){
			$strSQL .= "        cg_adminid = '{$this->categorydat[0]["cg_adminid"]}' , ";
		}ELSE{
			$strSQL .= "        cg_adminid = NULL , ";
		}
		$strSQL .= "        cg_upddate = 'now' ";
		$strSQL .= "  WHERE cg_id = '{$this->categorydat[0]["cg_id"]}' ";
	//echo "CategoryUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdCategory(7):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdCategory(8):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCategory(9):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  管理者情報テーブル　Ｄｅｌｅｔｅ  */
	function basedb_DelCategory ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelCategory(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_category ";
		$strSQL .= "  WHERE cg_id = {$this->categorydat[0]["cg_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelCategory(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->categorydat[0]["cg_id"] != $arr["cg_id"] ) {
			$this->php_error = "basedb_DelCategory(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE t_category ";
				$strSQL .= "    SET cg_deldate = 'now' ";
				$strSQL .= "  WHERE cg_id = '{$this->categorydat[0]["cg_id"]}'";
			//echo "CategoryDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCategory(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM t_category ";
				$strSQL .= "  WHERE cg_id = '{$this->categorydat[0]["cg_id"]}'";
			//echo "CategoryDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCategory(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelCategory(6):Delete Failed";
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
	function basedb_DspCategory () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCategory(1):".$obj->php_error;
			return (-1);
		}

		$flg = true;
		for ( $vX = 0; $vX < $this->categorydat[0]["intCnt"]; $vX++ ) {
			for ( $jX = 0; $jX < $this->categorydat[0]["intCnt"]; $jX++ ) {
				if ($vX != $jX && $this->categorydat[$vX]["cg_dispno"] == $this->categorydat[$jX]["cg_dispno"] ) {
					$flg = false;
					break;
				}
			}
		}
		if($flg == false){
				$this->php_error = "basedb_DspCategory(2):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (2);
		}

		for($iX=0;$iX<$this->categorydat[0]["intCnt"];$iX++){

			//  レコードロック
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_category ";
			$strSQL .= "  WHERE cg_id = '{$this->categorydat[$iX]["cg_id"]}' ";
			$strSQL .= "    FOR UPDATE ";
			$result = @pg_exec ( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "basedb_UpdCategory(2):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			//  該当データ・第３者が先に更新したかのチェック
			$arr = @pg_fetch_array ( $result , 0 );
			if ( $this->categorydat[$iX]["cg_id"] != $arr["cg_id"] ) {
				$this->php_error = "basedb_UpdCategory(3):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( $this->categorydat[$iX]["cg_upddate"] != $arr["cg_upddate"] ) {
				$this->php_error = "basedb_UpdCategory(4):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (1);
			}
			@pg_free_result( $result );

			//  管理者情報修正
			$strSQL = "";
			$strSQL .= " UPDATE t_category ";
			$strSQL .= "    SET ";
			$strSQL .= "        cg_dispno = '{$this->categorydat[$iX]["cg_dispno"]}' , ";
			$strSQL .= "        cg_upddate = 'now' ";
			$strSQL .= "  WHERE cg_id = '{$this->categorydat[$iX]["cg_id"]}' ";
	//echo "CategoryDspSQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ){
				$this->php_error = "basedb_UpdCategory(7):".pg_errormessage ($this->conn);
				$obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_cmdtuples( $result ) != 1 ) {
				$this->php_error = "basedb_UpdCategory(8):Update Failed";
				$obj->dbcom_DbRollback ();
				return (-1);
			}
		
		}

		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCategory(9):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


}
?>
