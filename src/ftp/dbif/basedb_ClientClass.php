<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/
//cl_mobile_flg　追加　
require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_ClientClassTblAccess extends dbcom_DBcontroll {

	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $clientdat;		// 検索結果を格納する２次元連想配列

	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_ClientClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->clientdat = Array();	// ２次元連想配列
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}

	/*  管理者のログイン情報チェック  */
	function basedb_CheckClient () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_CheckClient(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		
		// ログイン情報取得
		$strSQL = "";
		$strSQL .= " SELECT * FROM v_client ";
		$strSQL .= "  WHERE cl_logincd = '{$this->clientdat[0]["cl_logincd"]}' ";
		$strSQL .= "    AND cl_passcd = '{$this->clientdat[0]["cl_passcd"]}' ";
		$strSQL .= "    AND cl_deldate IS NULL ";
	//echo "ClientSearchSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_CheckClient(2):".pg_errormessage ($this->conn);
			return (-1);
		}
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->clientdat[0]["cl_logincd"] != $arr["cl_logincd"] ) {
			$this->php_error = "basedb_CheckClient(3):".pg_errormessage ($this->conn);
			return (5);
		}
		if ( $this->clientdat[0]["cl_passcd"] != $arr["cl_passcd"] ) {
			$this->php_error = "basedb_CheckClient(4):".pg_errormessage ($this->conn);
			return (5);
		}
		if ( $arr["cl_deldate"] != NULL ) {
			$this->php_error = "basedb_CheckClient(5): This client account is deleted. ";
			return (6);
		}
		if ( $arr["cl_stat"] != 1 ) {
			$this->php_error = "basedb_CheckClient(6): This client account is not use ( status ). ";
			return (7);
		}
		if ( $arr["cl_end"] != NULL ) {
			if ( $arr["cl_end"] < date("Y-m-d") ){
				$this->php_error = "basedb_CheckClient(7): This client account is not use ( limit date ). ";
				return (8);
			}
		}
		if ( $arr["cl_start"] != NULL ) {
			if ( $arr["cl_start"] > date("Y-m-d") ){
				$this->php_error = "basedb_CheckClient(7): This client account is not use ( noStart date ). ";
				return (9);
			}
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_CheckClient(8):Get Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$this->clientdat[0]["cl_id"] = $arr["cl_id"];
		$this->clientdat[0]["cl_dokuji_flg"] = $arr["cl_dokuji_flg"];
		$this->clientdat[0]["cl_dokuji_domain"] = $arr["cl_dokuji_domain"];
		$this->clientdat[0]["cl_googlemap_key"] = $arr["cl_googlemap_key"];
		$this->clientdat[0]["cl_advertisement_flg"] = $arr["cl_advertisement_flg"];
		$this->clientdat[0]["cl_advertisement_tag"] = $arr["cl_advertisement_tag"];
		$this->clientdat[0]["cl_mobile_flg"] = $arr["cl_mobile_flg"];

		$this->clientdat[0]["cl_mobile_dokuji_flg"] = $arr["cl_mobile_dokuji_flg"];
		$this->clientdat[0]["cl_mobile_dokuji_domain"] = $arr["cl_mobile_dokuji_domain"];
		$this->clientdat[0]["cl_mobile_googlemap_key"] = $arr["cl_mobile_googlemap_key"];

		$this->clientdat[0]["cl_smartphone_flg"] = $arr["cl_smartphone_flg"];

		$this->clientdat[0]["cl_id"] = $arr["cl_id"];
		$this->clientdat[0]["cl_id"] = $arr["cl_id"];
		$this->clientdat[0]["cl_loginid"] = $arr["cl_loginid"];
		$this->clientdat[0]["cl_passwd"] = $arr["cl_passwd"];
		$this->clientdat[0]["cl_logincd"] = $arr["cl_logincd"];
		$this->clientdat[0]["cl_passcd"] = $arr["cl_passcd"];
		$this->clientdat[0]["cl_urlcd"] = $arr["cl_urlcd"];
		$this->clientdat[0]["cl_stat"] = $arr["cl_stat"];
		$this->clientdat[0]["cl_pstat"] = $arr["cl_pstat"];
		$this->clientdat[0]["cl_start"] = $arr["cl_start"];
		$this->clientdat[0]["cl_end"] = $arr["cl_end"];
		$this->clientdat[0]["cl_jname"] = $arr["cl_jname"];
		$this->clientdat[0]["cl_kname"] = $arr["cl_kname"];
		$this->clientdat[0]["cl_agent"] = $arr["cl_agent"];
		$this->clientdat[0]["cl_mail"] = $arr["cl_mail"];
		$this->clientdat[0]["cl_zip"] = $arr["cl_zip"];
		$this->clientdat[0]["cl_pref"] = $arr["cl_pref"];
		$this->clientdat[0]["cl_prefcd"] = $arr["cl_prefcd"];
		$this->clientdat[0]["cl_city"] = $arr["cl_city"];
		$this->clientdat[0]["cl_citycd"] = $arr["cl_citycd"];
		$this->clientdat[0]["cl_add"] = $arr["cl_add"];
		$this->clientdat[0]["cl_estate"] = $arr["cl_estate"];
		$this->clientdat[0]["cl_phone"] = $arr["cl_phone"];
		$this->clientdat[0]["cl_fax"] = $arr["cl_fax"];
		$this->clientdat[0]["cl_biko"] = $arr["cl_biko"];

		$this->clientdat[0]["cl_biko"] = $arr["cl_dokuji_flg"];
		$this->clientdat[0]["cl_biko"] = $arr["cl_dokuji_domain"];
		$this->clientdat[0]["cl_biko"] = $arr["cl_googlemap_key"];

		$this->clientdat[0]["cl_yobi1"] = $arr["cl_yobi1"];
		$this->clientdat[0]["cl_yobi2"] = $arr["cl_yobi2"];
		$this->clientdat[0]["cl_yobi3"] = $arr["cl_yobi3"];
		$this->clientdat[0]["cl_yobi4"] = $arr["cl_yobi4"];
		$this->clientdat[0]["cl_yobi5"] = $arr["cl_yobi5"];
		$this->clientdat[0]["cl_makeid"] = $arr["cl_makeid"];
		$this->clientdat[0]["cl_insdate"] = $arr["cl_insdate"];
		$this->clientdat[0]["cl_upddate"] = $arr["cl_upddate"];
		$this->clientdat[0]["cl_deldate"] = $arr["cl_deldate"];
		$this->clientdat[0]["sc_stat"] = $arr["sc_stat"];
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_CheckClient(9):Get Failed";
			return (-1);
		}
		
		return (0);
		
	}
	
	
	/*  クライアントテーブル　Ｓｅｌｅｃｔ  */
	function basedb_GetClient ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetClient(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cl_id"] != "" )             $sql_where .= " AND cl_id = '{$this->jyoken["cl_id"]}' ";
		if( $this->jyoken["cl_id_not"] != "" )         $sql_where .= " AND cl_id <> '{$this->jyoken["cl_id_not"]}' ";
		if( $this->jyoken["cl_logincd"] != "" )   $sql_where .= " AND cl_logincd = '{$this->jyoken["cl_logincd"]}' ";
		if( $this->jyoken["cl_passcd"] != "" ) $sql_where .= " AND cl_passcd = '{$this->jyoken["cl_passcd"]}' ";
		if( $this->jyoken["cl_urlcd"] != "" )       $sql_where .= " AND cl_urlcd = '{$this->jyoken["cl_urlcd"]}' ";
		if( $this->jyoken["cl_stat"] != "" )           $sql_where .= " AND cl_stat = {$this->jyoken["cl_stat"]} ";
		if( $this->jyoken["cl_limit_date_s"] != "--" AND $this->jyoken["cl_limit_date_s"] != "")   $sql_where .= " AND ( cl_end >= '{$this->jyoken["cl_limit_date_s"]}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_limit_date_e"] != "--" AND $this->jyoken["cl_limit_date_e"] != "")   $sql_where .= " AND ( cl_end <= '{$this->jyoken["cl_limit_date_e"]}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_start_date_s"] != "--" AND $this->jyoken["cl_start_date_s"] != "")   $sql_where .= " AND ( cl_start >= '{$this->jyoken["cl_start_date_s"]}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_start_date_e"] != "--" AND $this->jyoken["cl_start_date_e"] != "")   $sql_where .= " AND ( cl_start <= '{$this->jyoken["cl_start_date_e"]}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_name_like"] != "" )      $sql_where .= " AND cl_jname || cl_kname LIKE '%{$this->jyoken["cl_name_like"]}%' ";
		if( $this->jyoken["cl_prefcd"] != "" )        $sql_where .= " AND cl_prefcd = {$this->jyoken["cl_prefcd"]} ";
		if( $this->jyoken["cl_pstat"] != "" )        $sql_where .= " AND ( cl_pstat = 1 OR cl_pstat is null ) ";
		if( $this->jyoken["cl_mobile_flg"] != "" )        $sql_where .= " AND cl_mobile_flg = 1  ";
		if( $this->jyoken["cl_smartphone_flg"] != "" )        $sql_where .= " AND cl_smartphone_flg = 1  ";
		if( $this->jyoken["cl_deldate"] == 0 ){
			//
		}else if( $this->jyoken["cl_deldate"] != "" ){
			$sql_where .= " AND cl_deldate is NULL ";
		}else{
			$sql_where .= " AND cl_deldate is NOT NULL ";
		}
		
		
		// ＳＱＬソート条件作成
		if( $this->sort["cl_upddate"] == 1 ){
			$sql_order .= " ORDER BY cl_upddate desc ";
		}else if( $this->sort["cl_upddate"] == 2 ){
			$sql_order .= " ORDER BY cl_upddate ";
		}
		
		if( $this->sort["cl_id"] == 1 ){
			$sql_order .= " ORDER BY cl_id desc ";
		}else if( $this->sort["cl_id"] == 2 ){
			$sql_order .= " ORDER BY cl_id ";
		}
		
		
		// ＳＱＬ文全体組み立て
		$strSQL = "";
		IF( $this->jyoken["table_name"] != "" ){
			$strSQL = " SELECT * FROM v_client ";
		}ELSE{
			$strSQL = " SELECT * FROM t_client ";
		}
		$stmt2 = "";
		$stmt2 .= " WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
	//echo "GetClient_SQL ... [".$strSQL."]<BR>";
		
		
		//　ＳＱＬ実行
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetClient(1):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetClient(2):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->clientdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cl_id) FROM t_client ";
		$strSQL .= $stmt2;
	//echo "GetClient_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetClient(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetClient(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetClient(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*  管理者情報テーブル　Ｉｎｓｅｒｔ  */
	function basedb_InsClient () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsClient(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_client IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsClient(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  ログインＩＤ重複チェック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_client ";
		$strSQL .= "  WHERE cl_loginid = '{$this->clientdat[0]["cl_loginid"]}' ";
		$strSQL .= "    AND cl_deldate IS NULL ";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsClient(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_numrows ( $result ) != 0 ) {
			$obj->dbcom_DbRollback ();
			return (4);
		}
		@pg_freeresult ( $result );
		
		// ＵＲＬ用コード重複チェック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_client ";
		$strSQL .= "  WHERE cl_urlcd = '{$this->clientdat[0]["cl_urlcd"]}' ";
		$strSQL .= "    AND cl_deldate IS NULL ";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsClient(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_numrows ( $result ) != 0 ) {
			$obj->dbcom_DbRollback ();
			return (3);
		}
		@pg_freeresult ( $result );
		
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_client ";
		$strSQL .= "           ( ";
		$strSQL .= "             cl_loginid , ";
		$strSQL .= "             cl_passwd , ";
		$strSQL .= "             cl_logincd , ";
		$strSQL .= "             cl_passcd , ";
		$strSQL .= "             cl_dokuji_flg , ";
		$strSQL .= "             cl_googlemap_key , ";
		$strSQL .= "             cl_dokuji_domain , ";
		$strSQL .= "             cl_advertisement_flg , ";
		$strSQL .= "             cl_advertisement_tag , ";
		$strSQL .= "             cl_mobile_flg, ";
		$strSQL .= "             cl_smartphone_flg, ";
		$strSQL .= "             cl_mobile_dokuji_flg , ";
		$strSQL .= "             cl_mobile_googlemap_key , ";
		$strSQL .= "             cl_mobile_dokuji_domain , ";
		$strSQL .= "             cl_urlcd , ";
		$strSQL .= "             cl_stat , ";
		$strSQL .= "             cl_end , ";
		$strSQL .= "             cl_start , ";
		$strSQL .= "             cl_jname , ";
		$strSQL .= "             cl_kname , ";
		$strSQL .= "             cl_agent , ";
		$strSQL .= "             cl_mail , ";
		$strSQL .= "             cl_phone , ";
		$strSQL .= "             cl_fax , ";
		$strSQL .= "             cl_biko , ";
		$strSQL .= "             cl_pstat , ";
		$strSQL .= "             cl_makeid , ";
		//$strSQL .= "             cl_yobi1 , ";
		$strSQL .= "             cl_insdate , ";
		$strSQL .= "             cl_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->clientdat[0]["cl_loginid"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_passwd"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_logincd"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_passcd"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_dokuji_flg"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_googlemap_key"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_dokuji_domain"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_advertisement_flg"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_advertisement_tag"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_mobile_flg"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_smartphone_flg"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_mobile_dokuji_flg"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_mobile_googlemap_key"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_mobile_dokuji_domain"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_urlcd"]}' , ";
		$strSQL .= "             {$this->clientdat[0]["cl_stat"]} , ";
		IF( $this->clientdat[0]["cl_end"] != "" ){
			$strSQL .= "     '{$this->clientdat[0]["cl_end"]}' , ";
		}ELSE{
			$strSQL .= "     NULL , ";
		}
		IF( $this->clientdat[0]["cl_start"] != "" ){
			$strSQL .= "     '{$this->clientdat[0]["cl_start"]}' , ";
		}ELSE{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             '{$this->clientdat[0]["cl_jname"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_kname"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_agent"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_mail"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_phone"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_fax"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_biko"]}' , ";
		$strSQL .= "             '{$this->clientdat[0]["cl_pstat"]}' , ";
		$strSQL .= "             {$this->clientdat[0]["cl_makeid"]} , ";
//		IF( $this->clientdat[0]["cl_yobi1"] != "" ){
//			$strSQL .= "     '{$this->clientdat[0]["cl_yobi1"]}' , ";
//		}ELSE{
//			$strSQL .= "     NULL , ";
//		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "ClientInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsClient(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsClient(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_idの取得
		$result = @pg_exec( $this->conn , " SELECT currval('t_client_cl_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->clientdat[0]["cl_id"] = @pg_result( $result , 0 , currval );
		@pg_free_result( $result );

		// upddateの取得
		$result = @pg_exec( $this->conn , " SELECT cl_upddate FROM t_client WHERE cl_id = '{$this->clientdat[0]["cl_id"]}'" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->clientdat[0]["cl_upddate"] = @pg_result( $result , 0 , cl_upddate );
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsClient(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  管理者情報テーブル　Ｕｐｄａｔｅ  */
	function basedb_UpdClient () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdClient(1):".$obj->php_error;
			return (-1);
		}

		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_client ";
		$strSQL .= "  WHERE cl_id = '{$this->clientdat[0]["cl_id"]}' ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_UpdClient(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->clientdat[0]["cl_id"] != $arr["cl_id"] ) {
			$this->php_error = "basedb_UpdClient(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->clientdat[0]["cl_upddate"] != $arr["cl_upddate"] ) {
			$this->php_error = "basedb_UpdClient(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}

		//  管理者情報修正
		
		// クライアント新規登録後のフリーワード検索用フィールド更新時のSQL
		IF( ($this->clientdat[0]["cl_yobi1"] != "") and ($this->clientdat[0]["ins_yobi1"] != "") ){
			$strSQL = "";
			$strSQL .= " UPDATE t_client ";
			$strSQL .= "    SET ";
			$strSQL .= "        cl_yobi1 = '{$this->clientdat[0]["cl_yobi1"]}' , ";
			$strSQL .= "        cl_upddate = 'now' ";
			$strSQL .= "  WHERE cl_id = '{$this->clientdat[0]["cl_id"]}' ";
		}
		// その他
		ELSE {
			// ログインパスワードの変更確認
			IF( $this->clientdat[0]["cl_passwd"] != $arr["cl_passwd"] ){
				$this->clientdat[0]["passwd_change"] = 1;
			}
			@pg_free_result( $result );


			//  ログインＩＤ重複チェック
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_client ";
			$strSQL .= "  WHERE cl_id != '{$this->clientdat[0]["cl_id"]}' ";
			$strSQL .= "    AND cl_loginid = '{$this->clientdat[0]["cl_loginid"]}' ";
			$strSQL .= "    AND cl_deldate IS NULL ";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "basedb_UpdClient(5):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_numrows ( $result ) != 0 ) {
				$obj->dbcom_DbRollback ();
				return (4);
			}
			@pg_free_result( $result );


			//  URLコード重複チェック
			if( $this->clientdat[0]["cl_urlcd"] != '' ){
				$strSQL = "";
				$strSQL .= " SELECT * FROM t_client ";
				$strSQL .= "  WHERE cl_id != '{$this->clientdat[0]["cl_id"]}' ";
				$strSQL .= "    AND cl_urlcd = '{$this->clientdat[0]["cl_urlcd"]}' ";
				$strSQL .= "    AND cl_deldate IS NULL ";
				$result = @pg_exec( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_UpdClient(6):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				if ( pg_numrows ( $result ) != 0 ) {
					$obj->dbcom_DbRollback ();
					return (3);
				}
				@pg_free_result( $result );
			}

			$strSQL = "";
			$strSQL .= " UPDATE t_client ";
			$strSQL .= "    SET ";
			$strSQL .= "        cl_loginid = '{$this->clientdat[0]["cl_loginid"]}' , ";
			$strSQL .= "        cl_passwd = '{$this->clientdat[0]["cl_passwd"]}' , ";
			$strSQL .= "        cl_logincd = '{$this->clientdat[0]["cl_logincd"]}' , ";
			$strSQL .= "        cl_passcd = '{$this->clientdat[0]["cl_passcd"]}' , ";
			IF( $this->clientdat[0]["cl_dokuji_flg"] != "" ){
				$strSQL .= "        cl_dokuji_flg = '{$this->clientdat[0]["cl_dokuji_flg"]}' , ";
			}ELSE{
				$strSQL .= "        cl_dokuji_flg = NULL , ";
			}
			$strSQL .= "        cl_googlemap_key = '{$this->clientdat[0]["cl_googlemap_key"]}' , ";
			$strSQL .= "        cl_dokuji_domain = '{$this->clientdat[0]["cl_dokuji_domain"]}' , ";
			IF( $this->clientdat[0]["cl_advertisement_flg"] != "" ){
				$strSQL .= "        cl_advertisement_flg = '{$this->clientdat[0]["cl_advertisement_flg"]}' , ";
			}
			IF( $this->clientdat[0]["cl_advertisement_tag"] != "" ){
				$strSQL .= "        cl_advertisement_tag = '{$this->clientdat[0]["cl_advertisement_tag"]}' , ";
			}
			IF( $this->clientdat[0]["cl_urlcd"] != "" ){
				$strSQL .= "        cl_urlcd = '{$this->clientdat[0]["cl_urlcd"]}' , ";
			}
			$strSQL .= "        cl_stat = {$this->clientdat[0]["cl_stat"]} , ";
			IF( $this->clientdat[0]["cl_end"] != "" ){
				$strSQL .= "        cl_end = '{$this->clientdat[0]["cl_end"]}' , ";
			}ELSE{
				$strSQL .= "        cl_end = NULL , ";
			}
			IF( $this->clientdat[0]["cl_start"] != "" ){
				$strSQL .= "        cl_start = '{$this->clientdat[0]["cl_start"]}' , ";
			}ELSE{
				$strSQL .= "        cl_start = NULL , ";
			}
			$strSQL .= "        cl_jname = '{$this->clientdat[0]["cl_jname"]}' , ";
			$strSQL .= "        cl_kname = '{$this->clientdat[0]["cl_kname"]}' , ";
			$strSQL .= "        cl_agent = '{$this->clientdat[0]["cl_agent"]}' , ";
			$strSQL .= "        cl_mail = '{$this->clientdat[0]["cl_mail"]}' , ";
			$strSQL .= "        cl_phone = '{$this->clientdat[0]["cl_phone"]}' , ";
			$strSQL .= "        cl_fax = '{$this->clientdat[0]["cl_fax"]}' , ";
			$strSQL .= "        cl_biko = '{$this->clientdat[0]["cl_biko"]}' , ";
//			$strSQL .= "        cl_mobile_flg = '{$this->clientdat[0]["cl_mobile_flg"]}' , ";
			
//			print_r($this->clientdat);

//プロパティが設定されていない場合には更新を行わない(client_toolからの更新時に初期化されてしまう)20100116 高木
			IF( isset( $this->clientdat[0]["cl_mobile_flg"] ) ){
				IF( $this->clientdat[0]["cl_mobile_flg"] != "" ){
				$strSQL .= "        cl_mobile_flg = '{$this->clientdat[0]["cl_mobile_flg"]}' , ";
				}ELSE{
					$strSQL .= "        cl_mobile_flg= NULL , ";
				}
			}

			IF( isset( $this->clientdat[0]["cl_mobile_dokuji_flg"] ) ){
				IF( $this->clientdat[0]["cl_mobile_dokuji_flg"] != "" ){
					$strSQL .= "        cl_mobile_dokuji_flg = '{$this->clientdat[0]["cl_mobile_dokuji_flg"]}' , ";
				}ELSE{
					$strSQL .= "        cl_mobile_dokuji_flg = NULL , ";
				}
			}
				
			IF( isset( $this->clientdat[0]["cl_mobile_googlemap_key"] ) ){
				IF( $this->clientdat[0]["cl_mobile_googlemap_key"] != "" ){
					$strSQL .= "        cl_mobile_googlemap_key = '{$this->clientdat[0]["cl_mobile_googlemap_key"]}' , ";
				}ELSE{
					$strSQL .= "        cl_mobile_googlemap_key = NULL , ";
				}
			}
				
			IF( isset( $this->clientdat[0]["cl_mobile_dokuji_domain"] ) ){
				IF( $this->clientdat[0]["cl_mobile_dokuji_domain"] != "" ){
					$strSQL .= "        cl_mobile_dokuji_domain = '{$this->clientdat[0]["cl_mobile_dokuji_domain"]}' , ";
				}ELSE{
					$strSQL .= "        cl_mobile_dokuji_domain = NULL , ";
				}
			}
			

			IF( isset( $this->clientdat[0]["cl_smartphone_flg"] ) ){
				IF( $this->clientdat[0]["cl_smartphone_flg"] != "" ){
				$strSQL .= "        cl_smartphone_flg = '{$this->clientdat[0]["cl_smartphone_flg"]}' , ";
				}ELSE{
					$strSQL .= "        cl_smartphone_flg= NULL , ";
				}
			}

			IF( $this->clientdat[0]["cl_pstat"] != "" ){
				$strSQL .= "        cl_pstat = '{$this->clientdat[0]["cl_pstat"]}' , ";
			}ELSE{
				$strSQL .= "        cl_pstat = NULL , ";
			}
			IF( $this->clientdat[0]["cl_makeid"] != "" ){
				$strSQL .= "        cl_makeid = '{$this->clientdat[0]["cl_makeid"]}' , ";
			}ELSE{
				$strSQL .= "        cl_makeid = NULL , ";
			}
			IF( $this->clientdat[0]["cl_yobi1"] != "" ){
				$strSQL .= "        cl_yobi1 = '{$this->clientdat[0]["cl_yobi1"]}' , ";
			}ELSE{
				$strSQL .= "        cl_yobi1 = NULL , ";
			}
			$strSQL .= "        cl_upddate = 'now' ";
			$strSQL .= "  WHERE cl_id = '{$this->clientdat[0]["cl_id"]}' ";
		}
		
		//echo "ClientUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdClient(7):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdClient(8):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdClient(9):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  管理者情報テーブル　Ｄｅｌｅｔｅ  */
	function basedb_DelClient ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelClient(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_client ";
		$strSQL .= "  WHERE cl_id = {$this->clientdat[0]["cl_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelClient(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->clientdat[0]["cl_id"] != $arr["cl_id"] ) {
			$this->php_error = "basedb_DelClient(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE t_client ";
				$strSQL .= "    SET cl_deldate = 'now' ";
				$strSQL .= "  WHERE cl_id = '{$this->clientdat[0]["cl_id"]}'";
			//echo "ClientDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelClient(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM t_client ";
				$strSQL .= "  WHERE cl_id = '{$this->clientdat[0]["cl_id"]}'";
			//echo "ClientDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelClient(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelClient(6):Delete Failed";
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

	/*  管理者情報テーブル フリーワード検索用文字列フィールド更新バッチ処理  */
	function basedb_UpdClient_freeword_batch () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdClient_freeword_batch(1):".$obj->php_error;
			return (-1);
		}

		// 配列で複数レコード来るのでレコード分繰り返す
		foreach( $this->clientdat[0]["arr_updrec"] as $key => $val ){
			//  レコードロック
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_client ";
			$strSQL .= "  WHERE cl_id = '{$val["cl_id"]}' ";
			$strSQL .= "    FOR UPDATE ";
			$result = @pg_exec ( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "basedb_UpdClient_freeword_batch(2):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			//  該当データ・第３者が先に更新したかのチェック
			$arr = @pg_fetch_array ( $result , 0 );
			if ( $val["cl_id"] != $arr["cl_id"] ) {
				$this->php_error = "basedb_UpdClient_freeword_batch(3):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( $val["cl_upddate"] != $arr["cl_upddate"] ) {
				$this->php_error = "basedb_UpdClient_freeword_batch(4):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (1);
			}

			@pg_free_result( $result );

			//  管理者情報修正
			
			$strSQL = "";
			$strSQL .= " UPDATE t_client ";
			$strSQL .= "    SET ";
			$strSQL .= "        cl_yobi1 = '{$val["cl_yobi1"]}' , ";
			$strSQL .= "        cl_upddate = 'now' ";
			$strSQL .= "  WHERE cl_id = '{$val["cl_id"]}' ";

	//echo "UpdClient_freeword_batchSQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ){
				$this->php_error = "basedb_UpdClient_freeword_batch(7):".pg_errormessage ($this->conn);
				$obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_cmdtuples( $result ) != 1 ) {
				$this->php_error = "basedb_UpdClient_freeword_batch(8):Update Failed";
				$obj->dbcom_DbRollback ();
				return (-1);
			}
		}

		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdClient_freeword_batch(9):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}

}
?>
