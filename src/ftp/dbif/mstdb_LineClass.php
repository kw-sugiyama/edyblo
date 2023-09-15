<?
/*****************************************************************************
	沿線駅マスタDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class mstdb_LineClassTblAccess extends dbcom_DBcontroll {
	
	
	/*------------------------------------------------------------
	    メンバー変数初期化
	------------------------------------------------------------*/
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $linedat;		// 検索結果を格納する２次元連想配列
	
	
	/*------------------------------------------------------------
	    コンストラクタ
	------------------------------------------------------------*/
	function mstdb_LineClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->linedat = Array();	// ２次元連想配列
	}
	
	
	/*------------------------------------------------------------
	    沿線駅マスタ - 検索
	------------------------------------------------------------*/
	function mstdb_GetLine( $select_flg ) {
		
		// トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "mstdb_GetLine(1):".$obj->php_error;
			return Array( "-1" , NULL );
		}
		
		
		// ＳＱＬ文ＷＨＥＲＥ句組み立て
		$sql_where = "";
		if ( $this->jyoken["st_areacd"] != "" ){
			$sql_where .= " AND st_areacd = '{$this->jyoken["st_areacd"]}' ";
		}
		if ( $this->jyoken["st_prefcd"] != "" ){
			$sql_where .= " AND st_prefcd = '{$this->jyoken["st_prefcd"]}' ";
		}
		if ( $this->jyoken["st_linecd"] != "" ){
			$sql_where .= " AND st_linecd = '{$this->jyoken["st_linecd"]}' ";
		}
		if ( $this->jyoken["st_stacd"] != "" ){
			$sql_where .= " AND st_stacd = '{$this->jyoken["st_stacd"]}' ";
		}

		if( count( $this->jyoken["st_areacd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["st_areacd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " st_areacd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		if( count( $this->jyoken["st_prefcd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["st_prefcd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " st_prefcd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		if( count( $this->jyoken["st_linecd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["st_linecd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " st_linecd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		if( count( $this->jyoken["st_stacd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["st_stacd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " st_stacd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}

		// ＳＱＬ文ＯＲＤＥＲ句組み立て
		IF( $this->sort["st_linecd"] != "" ){
			$sql_order .= " ORDER BY st_linecd ";
		}ELSEIF( $this->sort["line_sta_name"] != "" ){
			$sql_order .= " ORDER BY st_linecd , line_sta_name ";
		}ELSE{
			$sql_order .= " ORDER BY st_areacd , st_prefcd , st_linecd , st_stacd ";
		}
		
		
		// ＳＱＬ文全体組み立て
		SWITCH( $select_flg ){
			Case 1:
				// 通常検索
				$strSQL = "";
				$strSQL = " SELECT * FROM m_station ";
				$stmt2 = "";
				$stmt2 .= " WHERE st_areacd is NOT NULL ";
				$stmt2 .= $sql_where;
				$strSQL .= $stmt2;
				$strSQL .= $sql_order;
				break;
			Case 2:
				// エリアのみ抽出
				$strSQL = "";
				$strSQL .= " SELECT ";
				$strSQL .= "        st_areacd , ";
				$strSQL .= "        st_area ";
				$strSQL .= "   FROM m_station ";
				$strSQL .= "  GROUP BY st_areacd , st_area ";
				$strSQL .= "  ORDER BY st_areacd ";
				break;
			Case 3:
				// 指定エリアの県抽出
				$strSQL = "";
				$strSQL .= " SELECT ";
				$strSQL .= "        st_areacd , ";
				$strSQL .= "        st_area , ";
				$strSQL .= "        st_prefcd , ";
				$strSQL .= "        st_pref ";
				$strSQL .= "   FROM m_station ";
				$stmt2 = "";
				$stmt2 .= " WHERE st_areacd is NOT NULL ";
				$stmt2 .= $sql_where;
				$strSQL .= $stmt2;
				$strSQL .= "  GROUP BY st_areacd , st_area , st_prefcd , st_pref ";
				$strSQL .= "  ORDER BY st_prefcd";
				break;
			Case 4:
				// 指定エリア・県の沿線抽出
				$strSQL = "";
				$strSQL .= " SELECT ";
				$strSQL .= "        st_areacd , ";
				$strSQL .= "        st_area , ";
				$strSQL .= "        st_prefcd , ";
				$strSQL .= "        st_pref , ";
				$strSQL .= "        st_linecd , ";
				$strSQL .= "        st_line ";
				$strSQL .= "   FROM m_station ";
				$stmt2 = "";
				$stmt2 .= " WHERE st_areacd is NOT NULL ";
				$stmt2 .= $sql_where;
				$strSQL .= $stmt2;
				$strSQL .= "  GROUP BY st_areacd , st_area , st_prefcd , st_pref , st_linecd , st_line ";
				$strSQL .= "  ORDER BY st_linecd ";
				break;
			Case 5:
				// 県・沿線抽出
				$strSQL = "";
				$strSQL .= " SELECT ";
				$strSQL .= "        st_prefcd , ";
				$strSQL .= "        st_pref , ";
				$strSQL .= "        st_linecd , ";
				$strSQL .= "        st_line ";
				$strSQL .= "   FROM m_station ";
				$stmt2 = "";
				$stmt2 .= " WHERE st_areacd is NOT NULL ";
				$stmt2 .= $sql_where;
				$strSQL .= $stmt2;
				$strSQL .= "  GROUP BY st_prefcd , st_pref ,st_linecd , st_line ";
				$strSQL .= "  ORDER BY st_prefcd , st_linecd ";
				break;
			default:
				$this->php_error = "mstdb_GetLine(2): select_flg is not setting.";
				return Array( "-1" , NULL );
				break;
		}
	//echo "GetLine_SQL ... [".$strSQL."]<BR>";
		
		
		// ＳＱＬ実行
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_GetLine(3):".pg_errormessage ($this->conn);
			return Array( "-1" , NULL );
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "mstdb_GetLine(4):Get Failed";
			$obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->linedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "mstdb_GetLine(5):Get Failed";
			return Array( "-1" , NULL );
		}
		
		
		return Array( "0" , $cnt );
		
	}
	
	
	/*------------------------------------------------------------
	    沿線駅マスタ - 一括登録
	------------------------------------------------------------*/
	function mstdb_InsLineAll () {
		
		
		// トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "mstdb_InsLineAll(1):".$obj->php_error;
			return Array( "-1" , NULL );
		}
		
		
		// テーブルロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE m_station IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_InsLineAll(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		@pg_free_result( $result );
		
		
		// 既存登録情報確認
		$strSQL = "";
		$strSQL .= " SELECT count(st_areacd) FROM m_station";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_InsLineAll(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		$intBuffCnt = @pg_result( $result , 0 , count );
		IF( $intBuffCnt != 0 ){
			$this->php_error = "mstdb_InsLineAll(4): Line master's count is not zero. ";
			$ret = $obj->dbcom_DbRollback ();
			return Array( "1" , NULL );
		}
		@pg_free_result( $result );
		
		
		// INSERT件数確認
		$intCntInsLine = count( $this->linedat );
		
		
		// INSERT処理
		$intInsCnt = 0;
		FOR( $iX=0; $iX<$intCntInsLine; $iX++ ){
			
			// 沿線駅情報登録
			$strSQL = "";
			$strSQL .= " INSERT INTO m_station ";
			$strSQL .= "           ( ";
			$strSQL .= "             st_areacd , ";
			$strSQL .= "             st_area , ";
			$strSQL .= "             st_prefcd , ";
			$strSQL .= "             st_pref , ";
			$strSQL .= "             st_linecd , ";
			$strSQL .= "             st_line , ";
			$strSQL .= "             st_linekana , ";
			$strSQL .= "             st_stacd , ";
			$strSQL .= "             st_sta , ";
			$strSQL .= "             st_stakana , ";
			$strSQL .= "             st_yobi1 , ";
			$strSQL .= "             st_yobi2 , ";
			$strSQL .= "             st_yobi3 , ";
			$strSQL .= "             st_yobi4 , ";
			$strSQL .= "             st_yobi5 ";
			$strSQL .= "           ) ";
			$strSQL .= "      VALUES ";
			$strSQL .= "           ( ";
			$strSQL .= "             '{$this->linedat[$iX]["st_areacd"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_area"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_prefcd"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_pref"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_linecd"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_line"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_linekana"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_stacd"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_sta"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_stakana"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_yobi1"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_yobi2"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_yobi3"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_yobi4"]}' , ";
			$strSQL .= "             '{$this->linedat[$iX]["st_yobi5"]}' ";
			$strSQL .= "           ) ";
		//echo "InsLineAll_SQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "mstdb_InsLineAll(5):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return Array( "-1" , NULL );
			}
			if ( pg_cmdtuples( $result ) != 1 ) {
				$this->php_error = "mstdb_InsLineAll(6):Insert Failed";
				$obj->dbcom_DbRollback ();
				return Array( "-1" , NULL );
			}
			@pg_free_result( $result );
			
			$intInsCnt++;
			
		}
		
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "mstdb_InsLineAll(7):".$this->php_error;
			return Array( "-1" , NULL );
		}
		
		return Array( "0" , $intInsCnt );
		
	}
	
	
	/*------------------------------------------------------------
	    沿線駅マスタ - 一括削除
	------------------------------------------------------------*/
	function mstdb_DelLineAll () {
		
		// トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "mstdb_DelLineAll(1):".$obj->php_error;
			return (-1);
		}
		
		// テーブルロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE m_station IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_DelLineAll(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		@pg_free_result( $result );
		
		
		// データ全削除
		$strSQL = "";
		$strSQL .= " DELETE FROM m_station ";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_DelLineAll(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		$intAllDelCnt = pg_cmdtuples ( $result );
		@pg_free_result( $result );
		
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "mstdb_DelLineAll(4):".$this->php_error;
			return Array( "-1" , NULL );
		}
		
		return Array( "0" , $intAllDelCnt );
		
	}

}
?>
