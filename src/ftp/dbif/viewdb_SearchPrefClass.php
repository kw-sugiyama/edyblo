<?
/*****************************************************************************
	県検索DBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class viewdb_SPrefClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $sprefdat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function viewdb_SPrefClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->sprefdat = Array();	// ２次元連想配列
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}
	
	
	/*-----------------------------------------------------
	    教室　県 - 検索
	-----------------------------------------------------*/
	function viewdb_GetSPref ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetSPref(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//ＳＱＬ条件作成
		$sql_where = "";

		if( $this->jyoken["ar_prefcd"] != "" ) $sql_where .= " AND ar_prefcd = '{$this->jyoken["ar_prefcd"]}' ";
		if( $this->jyoken["cl_stat"] != "" )    $sql_where .= " AND cl_stat = 1 ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )   $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )     $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" ) $sql_where .= " AND cl_deldate is NULL ";
		if( $this->jyoken["sc_stat"] != "" )      $sql_where .= " AND sc_stat = 1 ";
		if( count( $this->jyoken["ar_prefcd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar_prefcd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_prefcd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		
		// 並び順
		$sql_order = "";
		IF( $this->sort["ar_prefcd"] == 1 ){
			$sql_order = " ORDER BY ar_prefcd ";
		}
		IF( $this->sort["ar_prefcd"] == 2 ){
			$sql_order = " ORDER BY ar_prefcd desc ";
		}
		IF( $this->sort["ar_citycd"] == 1 ){
			$sql_order = " ORDER BY ar_citycd ";
		}
		//カラム
		$column = "";
		$column .= "sc_id, sc_clid, sc_title, sc_keywd, sc_introduce, ";
		$column .= "sc_classform, sc_holiday, sc_pr, sc_ido, sc_keido, ";
		$column .= "sc_zoom,sc_age, sc_headertitle, sc_toptitle, sc_topsubtitle, ";
		$column .= "cl_urlcd, cl_jname, cl_kname, cl_mail, cl_zip, ";
		$column .= "cl_pref, cl_prefcd, cl_city, cl_citycd, cl_add, ";
		$column .= "cl_estate, cl_phone, cl_fax, cl_biko, cl_dokuji_flg, ";
		$column .= "cl_dokuji_domain, ar_id, ar_flg, ar_zip, ar_pref, ar_prefcd, ";
		$column .= "ar_city, ar_citycd, ar_add, ar_estate";
		
		$strSQL = "";
		$strSQL = " SELECT {$column} FROM v_search_pref ";
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
		
		//　ＳＱＬ実行
//	echo "Getpref_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetSPref(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetSPref(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->sprefdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(sc_id) FROM v_search_pref ";
		$strSQL .= $stmt2;
	//echo "GetDiary_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetSPref(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetSPref(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetSPref(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	

	/*-----------------------------------------------------
	    教室のある市区町村 - 検索
	-----------------------------------------------------*/
	function viewdb_GetSCity ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetSCity(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//ＳＱＬ条件作成
		$sql_where = "";

		if( $this->jyoken["ar_prefcd"] != "" ) $sql_where .= " AND ar_prefcd = '{$this->jyoken["ar_prefcd"]}' ";
		if( $this->jyoken["cl_stat"] != "" )    $sql_where .= " AND cl_stat = 1 ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )   $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )     $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" ) $sql_where .= " AND cl_deldate is NULL ";
		if( $this->jyoken["sc_stat"] != "" )      $sql_where .= " AND sc_stat = 1 ";
		if( count( $this->jyoken["ar_prefcd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar_prefcd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_prefcd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		
		// 並び順
		$sql_order = "";
		IF( $this->sort["ar_prefcd"] == 1 ){
			$sql_order = " ORDER BY ar_prefcd ";
		}
		IF( $this->sort["ar_prefcd"] == 2 ){
			$sql_order = " ORDER BY ar_prefcd desc ";
		}
		IF( $this->sort["ar_citycd"] == 1 ){
			$sql_order = " ORDER BY ar_citycd ";
		}
		//カラム
		$column = "";
		$column .= "ar_city, ar_citycd, ar_add, ar_estate";
		
		//SELECT元テーブル設定
		$table = " SELECT {$column} FROM v_search_pref ";
		$stmt2 = "";
		$stmt2 .= " WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$table .= $stmt2;
		$table .= $sql_order;
		
		
		$strSQL = "";
		$strSQL = " SELECT DISTINCT ON (city.ar_citycd) * FROM ( {$table} ) AS city ORDER BY city.ar_citycd ";
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
//	echo "Getpref_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetSCity(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetSCity(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->sprefdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(sc_id) FROM v_search_pref ";
		$strSQL .= $stmt2;
	//echo "GetDiary_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetSCity(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetSCity(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetSCity(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}

	/*-----------------------------------------------------
	    教室件数 - 検索
	-----------------------------------------------------*/
	function viewdb_CntSPref ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_CntSPref(1):".$obj->php_error;
			return -1;
		}

		//ＳＱＬ条件作成
		$sql_where = "";
		
		if( $this->jyoken["ar_prefcd"] != "" ) $sql_where .= " AND ar_prefcd = '{$this->jyoken["ar_prefcd"]}' ";

		if( count( $this->jyoken["ar_prefcd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar_prefcd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " pref.ar_prefcd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		
		
		$select_table = "SELECT * FROM v_search_pref WHERE cl_id IS NOT NULL AND cl_deldate IS NULL AND cl_stat = 1 AND cl_pstat = 1 AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) AND sc_stat = 1 ";
		$strSQL = "";
		$strSQL = " SELECT pref.ar_prefcd, count(pref.ar_prefcd) FROM ({$select_table})AS pref GROUP BY pref.ar_prefcd ";
		$stmt2 = "";
		$stmt2 .= " HAVING pref.ar_prefcd is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		
		//　ＳＱＬ実行
//	echo "CntSPref_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_CntSPref(2):".pg_errormessage ($this->conn);
			return -1;
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_CntSPref(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return -1;
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->sprefdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_CntSPref(4):Get Failed";
			return -1;
		}
		
			return 1;
		
	}
}
?>
