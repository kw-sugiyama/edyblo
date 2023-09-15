<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class viewdb_CampainClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $campaindat;	// 検索結果を格納する２次元連想配列
	var $campaincntdat;	// 検索結果を格納する２次元連想配列(件数)
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function viewdb_CampainClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->campaindat = Array();	// ２次元連想配列
		$this->campaincntdat = Array();	// ２次元連想配列(件数)
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function viewdb_GetCampain ( $stpos , $getnum ) {

		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetCampain(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cp_id"] != "" )      $sql_where .= " AND cp_id = {$this->jyoken["cp_id"]} ";
		if( $this->jyoken["cp_clid"] != "" )    $sql_where .= " AND cp_clid = {$this->jyoken["cp_clid"]} ";
		if( $this->jyoken["cp_stat"] != "" )    $sql_where .= " AND cp_stat = '{$this->jyoken["cp_stat"]}' ";
		if( $this->jyoken["cp_title"] != "" )   $sql_where .= " AND cp_title = '{$this->jyoken["cp_title"]}' ";
		if( $this->jyoken["cp_cgid"] != "" )    $sql_where .= " AND cp_cgid = {$this->jyoken["cp_cgid"]} ";
		if( $this->jyoken["cp_contents"] != "" )$sql_where .= " AND cp_contents = '{$this->jyoken["cp_contents"]}' ";
		if( $this->jyoken["cp_start"] != "" )   $sql_where .= " AND ( cp_start <= '{$this->today}' OR cp_start is NULL ) ";
		if( $this->jyoken["cp_end"] != "" )     $sql_where .= " AND ( cp_end >= '{$this->today}' OR cp_end is NULL ) ";
		if( $this->jyoken["cp_update"] != "" )  $sql_where .= " AND cp_update = '{$this->jyoken["cp_update"]}' ";
		if( $this->jyoken["cp_deldate"] != "" ) $sql_where .= " AND cp_deldate is NULL ";
		if( $this->jyoken["cl_stat"] != "" )    $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )   $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )     $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" ) $sql_where .= " AND cl_deldate is NULL ";
		if( count( $this->jyoken["cp_clid_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cp_clid_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cp_clid = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
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
		IF( $this->sort["cp_upddate"] == 2 ){
			$sql_order = " ORDER BY campain_b.cp_upddate desc ";
		}
		IF( $this->sort["cp_upddate"] == 1 ){
			$sql_order = " ORDER BY campain_b.cp_upddate ";
		}
		
		//カラム
		$column = "";
		$column .= "cp_id, cp_clid, cp_start, cp_end, cp_camstart, cp_camend, cp_cgid, cp_title, ";
		$column .= "cp_subtitle, cp_linktext, cp_btntext, cp_contents, cp_age, cp_img1, cp_img2, ";
		$column .= "cp_img3, cp_img4, cp_ido, cp_keido, cp_zoom, cp_upddate, cp_tcid, cp_tccomment, ";
		$column .= "cl_id, cl_urlcd, cl_jname, cl_kname, cl_mail, cl_zip, cl_pref, cl_prefcd, cl_city, ";
		$column .= "cl_citycd, cl_add, cl_estate, cl_phone, cl_fax, cl_dokuji_flg, cl_googlemap_key, cl_dokuji_domain";
		
		$select_table = "";
		$select_table = " ( SELECT DISTINCT ON ( cp_id ) {$column} FROM v_campain WHERE cp_id is NOT NULL AND cl_id is not null ";
		$select_table .= $sql_where;
		$select_table .=" ORDER BY cp_id ) AS campain_a";
		$select_table =" ( SELECT * FROM {$select_table} ORDER BY campain_a.cp_upddate desc LIMIT 100 OFFSET 0 ) AS campain_b";
		
		$strSQL = "";
		$strSQL = " SELECT * FROM {$select_table} ";
//		$stmt2 = "";
//		$stmt2 .= " WHERE cp_id is NOT NULL AND cl_id is not null ";
//		$stmt2 .= $sql_where;
//		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
//	echo "Getcampaign_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetCampain(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetCampain(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->campaindat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cp_id) FROM {$select_table} ";
		$strSQL .= $stmt2;
	//echo "GetDiary_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetCampain(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetCampain(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetCampain(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	/*-----------------------------------------------------
	    ブログ基本情報件数
	-----------------------------------------------------*/
	function viewdb_CntCampain ( $stpos , $getnum ) {

		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetCampain(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cp_id"] != "" )      $sql_where .= " AND cp_id = {$this->jyoken["cp_id"]} ";
		if( $this->jyoken["cp_clid"] != "" )    $sql_where .= " AND cp_clid = {$this->jyoken["cp_clid"]} ";
		if( $this->jyoken["cp_stat"] != "" )    $sql_where .= " AND cp_stat = '{$this->jyoken["cp_stat"]}' ";
		if( $this->jyoken["cp_title"] != "" )   $sql_where .= " AND cp_title = '{$this->jyoken["cp_title"]}' ";
		if( $this->jyoken["cp_cgid"] != "" )    $sql_where .= " AND cp_cgid = {$this->jyoken["cp_cgid"]} ";
		if( $this->jyoken["cp_contents"] != "" )$sql_where .= " AND cp_contents = '{$this->jyoken["cp_contents"]}' ";
		if( $this->jyoken["cp_start"] != "" )   $sql_where .= " AND ( cp_start <= '{$this->today}' OR cp_start is NULL ) ";
		if( $this->jyoken["cp_end"] != "" )     $sql_where .= " AND ( cp_end >= '{$this->today}' OR cp_end is NULL ) ";
		if( $this->jyoken["cp_update"] != "" )  $sql_where .= " AND cp_update = '{$this->jyoken["cp_update"]}' ";
		if( $this->jyoken["cp_deldate"] != "" ) $sql_where .= " AND cp_deldate is NULL ";
		if( $this->jyoken["cl_stat"] != "" )    $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )   $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )     $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" ) $sql_where .= " AND cl_deldate is NULL ";
		if( count( $this->jyoken["cp_clid_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cp_clid_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cp_clid = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
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

		$strSQL = " SELECT count( distinct cp_id ) as count FROM v_campain WHERE cp_id is NOT NULL AND cl_id is not null ";
		$strSQL .= $sql_where;
		$strSQL .=" ";

		//　ＳＱＬ実行
	//echo "CntCampain_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_CntCampain(2):".pg_errormessage ($this->conn);
			return -1;
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_CntCampain(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return -1;
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->campaincntdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_CntCampain(4):Get Failed";
			return -1;
		}
		return 1;
	}
}
?>
