<?
/*****************************************************************************
	View Client DBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

$test="asdg";

class viewdb_ClientClassTblAccess extends dbcom_DBcontroll {

	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $clientdat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function viewdb_ClientClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->clientdat = Array();	// ２次元連想配列
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}
	
	/*  */
	
	/*  View Client テーブル　Ｓｅｌｅｃｔ  */
	function viewdb_GetClient ( $stpos , $getnum ) {
	
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetClient(1):".$obj->php_error; 
			return array (-1,NULL);
		}
		
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cl_id"] != "" )         $sql_where .= " AND cl_id = '{$this->jyoken["cl_id"]}' ";
		if( $this->jyoken["cl_urlcd"] != "" )   $sql_where .= " AND cl_urlcd = '{$this->jyoken["cl_urlcd"]}' ";
		if( $this->jyoken["cl_stat"] != "" )       $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_pstat"] != "" )     $sql_where .= " AND ( cl_pstat = 1 OR cl_biko_2 is null ) ";
		if( $this->jyoken["cl_start"] != "" ) $sql_where .= " AND ( cl_start <= '{$this->jyoken["cl_start"]}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" ) $sql_where .= " AND ( cl_end >= '{$this->jyoken["cl_end"]}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" )   $sql_where .= " AND cl_deldate is NULL ";
		if( $this->jyoken["sc_stat"] != "" )     $sql_where .= " AND sc_stat = '{$this->jyoken["sc_stat"]}' ";
		if( $this->jyoken["sc_deldate"] != "" ) $sql_where .= " AND sc_deldate is NULL ";
		
		IF( count( $this->jyoken["ar"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_zip = '{$val}' ";
			}
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_pref = '{$val}' ";
			}
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_prefcd = '{$val}' ";
			}
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_city = '{$val}' ";
			}
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_citycd = '{$val}' ";
			}
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_add = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["es"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["es"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_line = '{$val}' ";
			}
			FOREACH( $this->jyoken["es"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_sta = '{$val}' ";
			}
			FOREACH( $this->jyoken["es"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_walk = '{$val}' ";
			}
			FOREACH( $this->jyoken["es"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_bus = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["mn"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["mn"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " mn_lstat = '{$val}' ";
			}
			FOREACH( $this->jyoken["mnu"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " mn_lname = '{$val}' ";
			}
			FOREACH( $this->jyoken["mn"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " mn_ldispno = '{$val}' ";
			}
			FOREACH( $this->jyoken["mn"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " mn_hstat = '{$val}' ";
			}
			FOREACH( $this->jyoken["mn"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " mn_hdispno = '{$val}' ";
			}
			FOREACH( $this->jyoken["mn"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " mn_hname = '{$val}' ";
			}
			FOREACH( $this->jyoken["mn"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " mn_hurl = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["cg"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cg"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cg_stat = '{$val}' ";
			}
			FOREACH( $this->jyoken["cg"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cg_type = '{$val}' ";
			}
			FOREACH( $this->jyoken["cg"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cg_stitle = '{$val}' ";
			}
			FOREACH( $this->jyoken["cg"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cg_ltitle = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["sta"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_sta like '%{$val}%' ";
			}
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_stacd like '%{$val}%' ";
			}
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_walk like '%{$val}%' ";
			}
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_bus like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["cl_id_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_id = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		
		
		
		// ＳＱＬソート条件作成
		if ( $this->sort["cl_id"] == 1 ){
			$sql_order .= " ORDER BY cl_id desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_id ";
		}
		if ( $this->sort["cl_pref"] == 1 ){
			$sql_order .= " ORDER BY cl_pref desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_pref ";
		}
		
		
		// ＳＱＬ文全体組み立て
		$strSQL = "";
		$strSQL .= " SELECT * FROM v_client ";
		$stmt2 = "";
		$stmt2 .= "  WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
	//echo "GetViewClient_SQL ... [".$strSQL."]<BR>";
		
		//　ＳＱＬ実行
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(1):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(2):Get Failed";
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
		$strSQL .= " SELECT count(cl_id) FROM v_client ";
		$strSQL .= $stmt2;
	//echo "GetClient_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(5):Get Failed";
			$obj->dbcom_DbRollback ();


			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetClient(6):Get Failed";

			return array (-1,NULL);
		}
		return array( $cnt , $total );
		
	}

	/*  View Client テーブル　Ｓｅｌｅｃｔ  */
	function viewdb_GetComPref ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetClient(1):".$obj->php_error;

			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cl_id"] != "" )         $sql_where .= " AND cl_id = '{$this->jyoken["cl_id"]}' ";
		if( $this->jyoken["cl_urlcd"] != "" )   $sql_where .= " AND cl_urlcd = '{$this->jyoken["cl_urlcd"]}' ";
		if( $this->jyoken["cl_stat"] != "" )       $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_start"] != "" ) $sql_where .= " AND ( cl_start <= '{$this->jyoken["cl_start"]}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" ) $sql_where .= " AND ( cl_end >= '{$this->jyoken["cl_end"]}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_del_date"] != "" )   $sql_where .= " AND cl_del_date is NULL ";
		if( $this->jyoken["sc_stat"] != "" )     $sql_where .= " AND sc_stat = '{$this->jyoken["sc_stat"]}' ";
		if( $this->jyoken["blog_del_date"] != "" ) $sql_where .= " AND blog_del_date is NULL ";
		IF( count( $this->jyoken["ar"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pf"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pf"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_addr_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["ln"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ln"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " blog_line_cd like '%/{$val}/%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["sta"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " sc_station_cd like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pref_cd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pref_cd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["cl_id_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_id = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}

		
		// ＳＱＬソート条件作成
		if ( $this->sort["cl_id"] == 1 ){
			$sql_order .= " ORDER BY cl_id desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_id ";
		}
		if ( $this->sort["cl_pref"] == 1 ){
			$sql_order .= " ORDER BY cl_pref desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_pref ";
		}
		
		
		// ＳＱＬ文全体組み立て
		$strSQL = "";
		$strSQL .= " SELECT cl_pref,cl_pref_cd,count(*) FROM ( ";
		$strSQL .= " SELECT cl_id,cl_pref_cd,cl_pref FROM v_client ";
		$stmt2 = "";
		$stmt2 .= "  WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		$strSQL .= " ) as T1 group by cl_pref_cd,cl_pref ";
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
	//echo "GetViewClient_SQL ... [".$strSQL."]<BR>";
		
		
		//　ＳＱＬ実行
		$result = @pg_exec( $this->conn , $strSQL );
		
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(1):".pg_errormessage ($this->conn);

			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(2):Get Failed";
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
		$strSQL .= " SELECT count(cl_id) FROM v_client ";
		$strSQL .= $stmt2;
	//echo "GetClient_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(4):".pg_errormessage ($this->conn);

			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(5):Get Failed";
			$obj->dbcom_DbRollback ();

			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetClient(6):Get Failed";
			return array (-1,NULL);
		}
		
		
		return array( $cnt , $total );
		
	}

	/*  View Client テーブル　Ｓｅｌｅｃｔ  */
	function viewdb_GetComAddr ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetClient(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cl_id"] != "" )         $sql_where .= " AND cl_id = '{$this->jyoken["cl_id"]}' ";
		if( $this->jyoken["cl_urlcd"] != "" )   $sql_where .= " AND cl_urlcd = '{$this->jyoken["cl_urlcd"]}' ";
		if( $this->jyoken["cl_stat"] != "" )       $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_start"] != "" ) $sql_where .= " AND ( cl_start <= '{$this->jyoken["cl_start"]}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" ) $sql_where .= " AND ( cl_end >= '{$this->jyoken["cl_end"]}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_del_date"] != "" )   $sql_where .= " AND cl_del_date is NULL ";
		if( $this->jyoken["sc_stat"] != "" )     $sql_where .= " AND sc_stat = '{$this->jyoken["sc_stat"]}' ";
		if( $this->jyoken["blog_del_date"] != "" ) $sql_where .= " AND blog_del_date is NULL ";
		IF( count( $this->jyoken["ar"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pf"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pf"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_addr_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["ln"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ln"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " blog_line_cd like '%/{$val}/%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["sta"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " sc_station_cd like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pref_cd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pref_cd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["cl_id_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_id = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}

		
		// ＳＱＬソート条件作成
		if ( $this->sort["cl_id"] == 1 ){
			$sql_order .= " ORDER BY cl_id desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_id ";
		}
		if ( $this->sort["cl_pref"] == 1 ){
			$sql_order .= " ORDER BY cl_pref desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_pref ";
		}
		
		
		// ＳＱＬ文全体組み立て
		$strSQL = "";
		$strSQL .= " SELECT cl_pref,cl_pref_cd,cl_address1,cl_addr_cd,count(*) FROM ( ";
		$strSQL .= " SELECT cl_id,cl_pref_cd,cl_pref,cl_address1,cl_addr_cd FROM v_client ";
		$stmt2 = "";
		$stmt2 .= "  WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		$strSQL .= " ) as T1 group by cl_pref_cd,cl_pref,cl_address1,cl_addr_cd ";
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
	//echo "GetViewClient_SQL ... [".$strSQL."]<BR>";
		
		
		//　ＳＱＬ実行
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(1):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(2):Get Failed";
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
		$strSQL .= " SELECT count(cl_id) FROM v_client ";
		$strSQL .= $stmt2;
	//echo "GetClient_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetClient(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}

	/*  View Client テーブル　Ｓｅｌｅｃｔ  */
	function viewdb_GetComLine ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetClient(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		$sql_where2 = "";
		if( $this->jyoken["cl_id"] != "" ){
			$sql_where .= " AND cl_id = '{$this->jyoken["cl_id"]}' ";
			$sql_where2 .= " AND cl_id = '{$this->jyoken["cl_id"]}' ";
		}
		if( $this->jyoken["cl_urlcd"] != "" ){
			$sql_where .= " AND cl_urlcd = '{$this->jyoken["cl_urlcd"]}' ";
			$sql_where2 .= " AND cl_urlcd = '{$this->jyoken["cl_urlcd"]}' ";
		}
		if( $this->jyoken["cl_stat"] != "" ){
			$sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
			$sql_where2 .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		}
		if( $this->jyoken["cl_start"] != "" ){
			$sql_where .= " AND ( cl_start <= '{$this->jyoken["cl_start"]}' OR cl_start is NULL ) ";
			$sql_where2 .= " AND ( cl_start <= '{$this->jyoken["cl_start"]}' OR cl_start is NULL ) ";
		}
		if( $this->jyoken["cl_end"] != "" ){
			$sql_where .= " AND ( cl_end >= '{$this->jyoken["cl_end"]}' OR cl_end is NULL ) ";
			$sql_where2 .= " AND ( cl_end >= '{$this->jyoken["cl_end"]}' OR cl_end is NULL ) ";
		}
		if( $this->jyoken["cl_del_date"] != "" ){
			$sql_where .= " AND cl_del_date is NULL ";
			$sql_where2 .= " AND cl_del_date is NULL ";
		}
		if( $this->jyoken["sc_stat"] != "" ){
			$sql_where .= " AND sc_stat = '{$this->jyoken["sc_stat"]}' ";
			$sql_where2 .= " AND sc_stat = '{$this->jyoken["sc_stat"]}' ";
		}
		if( $this->jyoken["blog_del_date"] != "" ){
			$sql_where .= " AND blog_del_date is NULL ";
			$sql_where2 .= " AND blog_del_date is NULL ";
		}
		IF( count( $this->jyoken["ar"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["pf"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pf"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_addr_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pf"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_addr_cd = '{$val}' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["ln"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ln"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " blog_line_cd like '%/{$val}/%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";


			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ln"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " blog_line_cd2 like '%/{$val}/%' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["sta"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " sc_station_cd like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " sc_station_cd2 like '%{$val}%' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["pref_cd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pref_cd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pref_cd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["cl_id_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_id = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_id = '{$val}' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}

		
		// ＳＱＬソート条件作成
		if ( $this->sort["cl_id"] == 1 ){
			$sql_order .= " ORDER BY cl_id desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_id ";
		}
		if ( $this->sort["cl_pref"] == 1 ){
			$sql_order .= " ORDER BY cl_pref desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_pref ";
		}
		
		
		// ＳＱＬ文全体組み立て
		$strSQL = "";
		$strSQL .= " SELECT distinct cl_id,cl_pref_cd,cl_pref,blog_line,blog_line_cd,blog_line_cd_name,sc_station,sc_station_cd FROM ( ";

		$strSQL .= " (SELECT cl_id,cl_pref_cd,cl_pref,blog_line,blog_line_cd,blog_line_cd_name,sc_station,sc_station_cd FROM v_client ";
		$stmt2 = "  WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= " ) union all ";
		$strSQL .= " (SELECT cl_id,cl_pref_cd,cl_pref,blog_line2,blog_line_cd2,blog_line_cd_name2,sc_station2,sc_station_cd2 FROM v_client ";
		$stmt2 = "  WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where2;
		$strSQL .= $stmt2;
		$strSQL .= " ) ) as T1 ";
		$strSQL .= " where blog_line <> '' AND blog_line is not null ";
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
	//echo "GetViewClient_SQL ... [".$strSQL."]<BR>";
		
		
		//　ＳＱＬ実行
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(1):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(2):Get Failed";
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
		$strSQL .= " SELECT count(cl_id) FROM v_client ";
		$strSQL .= $stmt2;
	//echo "GetClient_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetClient(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}

	/*  View Client テーブル　Ｓｅｌｅｃｔ  */
	function viewdb_GetComSta ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetClient(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		$sql_where2 = "";
		if( $this->jyoken["cl_id"] != "" ){
			$sql_where .= " AND cl_id = '{$this->jyoken["cl_id"]}' ";
			$sql_where2 .= " AND cl_id = '{$this->jyoken["cl_id"]}' ";
		}
		if( $this->jyoken["cl_urlcd"] != "" ){
			$sql_where .= " AND cl_urlcd = '{$this->jyoken["cl_urlcd"]}' ";
			$sql_where2 .= " AND cl_urlcd = '{$this->jyoken["cl_urlcd"]}' ";
		}
		if( $this->jyoken["cl_stat"] != "" ){
			$sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
			$sql_where2 .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		}
		if( $this->jyoken["cl_start"] != "" ){
			$sql_where .= " AND ( cl_start <= '{$this->jyoken["cl_start"]}' OR cl_start is NULL ) ";
			$sql_where2 .= " AND ( cl_start <= '{$this->jyoken["cl_start"]}' OR cl_start is NULL ) ";
		}
		if( $this->jyoken["cl_end"] != "" ){
			$sql_where .= " AND ( cl_end >= '{$this->jyoken["cl_end"]}' OR cl_end is NULL ) ";
			$sql_where2 .= " AND ( cl_end >= '{$this->jyoken["cl_end"]}' OR cl_end is NULL ) ";
		}
		if( $this->jyoken["cl_del_date"] != "" ){
			$sql_where .= " AND cl_del_date is NULL ";
			$sql_where2 .= " AND cl_del_date is NULL ";
		}
		if( $this->jyoken["sc_stat"] != "" ){
			$sql_where .= " AND sc_stat = '{$this->jyoken["sc_stat"]}' ";
			$sql_where2 .= " AND sc_stat = '{$this->jyoken["sc_stat"]}' ";
		}
		if( $this->jyoken["blog_del_date"] != "" ){
			$sql_where .= " AND blog_del_date is NULL ";
			$sql_where2 .= " AND blog_del_date is NULL ";
		}
		IF( count( $this->jyoken["ar"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["pf"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pf"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_addr_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pf"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_addr_cd = '{$val}' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["ln"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ln"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " blog_line_cd like '%/{$val}/%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";


			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ln"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " blog_line_cd2 like '%/{$val}/%' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["sta"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " sc_station_cd like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " sc_station_cd2 like '%{$val}%' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["pref_cd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pref_cd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pref_cd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_pref_cd = '{$val}' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}
		IF( count( $this->jyoken["cl_id_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_id = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";

			$sql_where2 .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cl_id = '{$val}' ";
			}
			$sql_where2 .= $buffsql;
			$sql_where2 .= " ) ";
		}

		
		// ＳＱＬソート条件作成
		if ( $this->sort["cl_id"] == 1 ){
			$sql_order .= " ORDER BY cl_id desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_id ";
		}
		if ( $this->sort["cl_pref"] == 1 ){
			$sql_order .= " ORDER BY cl_pref desc ";
		}else if( $this->sort["cl_pref"] == 2 ){
			$sql_order .= " ORDER BY cl_pref ";
		}
		
		
		// ＳＱＬ文全体組み立て
		$strSQL = "";
		$strSQL .= " SELECT blog_line,blog_line_cd,blog_line_cd_name,sc_station,sc_station_cd,count(*) FROM ( ";
		$strSQL .= " SELECT distinct cl_id,blog_line,blog_line_cd,blog_line_cd_name,sc_station,sc_station_cd FROM ( ";

		$strSQL .= " (SELECT cl_id,cl_pref_cd,blog_line,blog_line_cd,blog_line_cd_name,sc_station,sc_station_cd FROM v_client ";
		$stmt2 = "  WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= " ) union all ";
		$strSQL .= " (SELECT cl_id,cl_pref_cd,blog_line2,blog_line_cd2,blog_line_cd_name2,sc_station2,sc_station_cd2 FROM v_client ";
		$stmt2 = "  WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where2;
		$strSQL .= $stmt2;
		$strSQL .= " ) ) as T1 ";
		$strSQL .= " where blog_line <> '' AND blog_line is not null ";
		$strSQL .= " ) as T2 ";
		$strSQL .= " group by blog_line,blog_line_cd,blog_line_cd_name,sc_station,sc_station_cd ";
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
	//echo "GetViewClient_SQL ... [".$strSQL."]<BR>";
		
		
		//　ＳＱＬ実行
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(1):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(2):Get Failed";
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
		$strSQL .= " SELECT count(cl_id) FROM v_client ";
		$strSQL .= $stmt2;
	//echo "GetClient_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetClient(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetClient(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetClient(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}

}
?>
