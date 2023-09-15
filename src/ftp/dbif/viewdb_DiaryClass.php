<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class viewdb_DiaryClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $diarydat;		// 検索結果を格納する２次元連想配列
	var $diarycntdat;	// 検索結果を格納する２次元連想配列(件数)
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function viewdb_DiaryClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->diarydat = Array();	// ２次元連想配列
		$this->diarycntdat = Array();	// ２次元連想配列(件数)
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function viewdb_GetDiary ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetDiary(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["dr_id"] != "" )      $sql_where .= " AND dr_id = {$this->jyoken["dr_id"]} ";
		if( $this->jyoken["dr_clid"] != "" )    $sql_where .= " AND dr_clid = {$this->jyoken["dr_clid"]} ";
		if( $this->jyoken["dr_cgid"] != "" )    $sql_where .= " AND dr_cgid = '{$this->jyoken["dr_cgid"]}' ";
		if( $this->jyoken["dr_title"] != "" )   $sql_where .= " AND dr_title = '{$this->jyoken["dr_title"]}' ";
		if( $this->jyoken["dr_contents"] != "" )$sql_where .= " AND dr_contents = '{$this->jyoken["dr_contents"]}' ";
		if( $this->jyoken["dr_update"] != "" )  $sql_where .= " AND dr_update = '{$this->jyoken["dr_update"]}' ";
		if( $this->jyoken["dr_deldate"] != "" ) $sql_where .= " AND dr_deldate is NULL ";
		if( $this->jyoken["cl_stat"] != "" )    $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )   $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )     $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" ) $sql_where .= " AND cl_deldate is NULL ";
		if( count( $this->jyoken["dr_clid_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["dr_clid_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " dr_clid = '{$val}' ";
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
		IF( $this->sort["dr_upddate"] == 2 ){
			$sql_order = " ORDER BY diary_b.dr_upddate desc ";
		}
		IF( $this->sort["dr_upddate"] == 1 ){
			$sql_order = " ORDER BY diary_b.dr_upddate ";
		}
		
		//カラム
		$column = "";
		$column .= "dr_id, dr_clid, dr_cgid, dr_title, dr_contents, dr_img1, dr_img2, dr_img3, ";
		$column .= "dr_img4, dr_ido, dr_keido, dr_zoom, dr_upddate, dr_tcid,cl_id, cl_urlcd, ";
		$column .= "cl_jname, cl_kname, cl_mail, cl_zip, cl_pref, cl_prefcd, cl_city, cl_citycd, ";
		$column .= "cl_add, cl_estate, cl_phone, cl_fax, cl_dokuji_flg, cl_googlemap_key, cl_dokuji_domain";

		$select_table = "";
		$select_table = " ( SELECT DISTINCT ON ( dr_id ) {$column} FROM v_diary WHERE dr_id is NOT NULL AND cl_id is not null ";
		$select_table .= $sql_where;
		$select_table .=" ORDER BY dr_id ) AS diary_a ";
		$select_table =" ( SELECT * FROM {$select_table} ORDER BY diary_a.dr_upddate desc LIMIT 100 OFFSET 0 ) AS diary_b";

		$strSQL = "";
		$strSQL = " SELECT * FROM {$select_table} ";
//		$stmt2 = "";
//		$stmt2 .= " WHERE dr_id is NOT NULL AND cl_id is not null ";
//		$stmt2 .= $sql_where;
//		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
//	echo "GetDiary_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetDiary(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetDiary(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->diarydat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(dr_id) FROM {$select_table}";
		$strSQL .= $stmt2;
	//echo "GetDiary_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetDiary(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetDiary(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetDiary(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}

	/*-----------------------------------------------------
	    ブログ基本情報件数
	-----------------------------------------------------*/
	function viewdb_CntDiary ( $stpos , $getnum ) {

		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetDiary(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["dr_id"] != "" )      $sql_where .= " AND dr_id = {$this->jyoken["dr_id"]} ";
		if( $this->jyoken["dr_clid"] != "" )    $sql_where .= " AND dr_clid = {$this->jyoken["dr_clid"]} ";
		if( $this->jyoken["dr_cgid"] != "" )    $sql_where .= " AND dr_cgid = '{$this->jyoken["dr_cgid"]}' ";
		if( $this->jyoken["dr_title"] != "" )   $sql_where .= " AND dr_title = '{$this->jyoken["dr_title"]}' ";
		if( $this->jyoken["dr_contents"] != "" )$sql_where .= " AND dr_contents = '{$this->jyoken["dr_contents"]}' ";
		if( $this->jyoken["dr_update"] != "" )  $sql_where .= " AND dr_update = '{$this->jyoken["dr_update"]}' ";
		if( $this->jyoken["dr_deldate"] != "" ) $sql_where .= " AND dr_deldate is NULL ";
		if( $this->jyoken["cl_stat"] != "" )    $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )   $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )     $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" ) $sql_where .= " AND cl_deldate is NULL ";
		if( count( $this->jyoken["dr_clid_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["dr_clid_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " dr_clid = '{$val}' ";
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

		$strSQL = " SELECT count( distinct dr_id ) as count FROM v_diary WHERE dr_id is NOT NULL AND cl_id is not null ";
		$strSQL .= $sql_where;
		$strSQL .=" ";

		//　ＳＱＬ実行
	//echo "CntDiary_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_CntDiary(2):".pg_errormessage ($this->conn);
			return -1;
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_CntDiary(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return -1;
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->diarycntdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_CntDiary(4):Get Failed";
			return -1;
		}
		return 1;
	}
}
?>
