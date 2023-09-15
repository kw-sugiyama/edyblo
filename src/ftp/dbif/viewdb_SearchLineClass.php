<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class viewdb_SLineClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $slinedat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function viewdb_SLineClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->slinedat = Array();	// ������Ϣ������
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}
	
	
	/*-----------------------------------------------------
	    �α������� - ����
	-----------------------------------------------------*/
	function viewdb_GetSLine ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetSLine(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//�ӣѣ̾�����
		$sql_where = "";

		if( $this->jyoken["st_prefcd"] != "" )  $sql_where .= " AND st_prefcd = '{$this->jyoken["st_prefcd"]}' ";
		if( $this->jyoken["st_linecd"] != "" )  $sql_where .= " AND st_linecd = '{$this->jyoken["st_linecd"]}' ";
		if( $this->jyoken["st_stacd"] != "" )   $sql_where .= " AND st_stacd = '{$this->jyoken["st_stacd"]}' ";
		if( $this->jyoken["sc_stat"] != "" )    $sql_where .= " AND sc_stat = 1 ";
		if( $this->jyoken["cl_stat"] != "" )    $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )   $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )     $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" ) $sql_where .= " AND cl_deldate is NULL ";

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
		if( count( $this->jyoken["es_linecd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["es_linecd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_linecd LIKE '%/{$val}/%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		
		// �¤ӽ�
		$sql_order = "";
		if( $this->sort["pref"] == 1 ){
			$sql_order = " ORDER BY st_prefcd ";
		}elseif( $this->sort["line"] == 1 ){
			$sql_order = " ORDER BY st_linecd ";
		}elseif( $this->sort["sta"] == 1 ){
			$sql_order = " ORDER BY st_stacd ";
		}
		
		//�����
		$column = "";
		$column .= "sc_id, sc_clid, sc_title, sc_keywd, sc_introduce, ";
		$column .= "sc_classform, sc_holiday, sc_pr, sc_ido, sc_keido, ";
		$column .= "sc_zoom,sc_age, sc_headertitle, sc_toptitle, sc_topsubtitle, ";
		$column .= "cl_urlcd, cl_jname, cl_kname, cl_mail, cl_phone, cl_fax, ";
		$column .= "cl_biko, cl_dokuji_flg, cl_dokuji_domain, es_line, es_linecd, ";
		$column .= "es_sta, es_stacd, es_linecdname,st_prefcd, st_pref, st_linecd, ";
		$column .= "st_line, st_linekana, st_stacd, st_sta, st_stakana";

		$strSQL = "";
		$strSQL = " SELECT {$column} FROM v_search_line ";
		$stmt2 = "";
		$stmt2 .= " WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetSLine_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetSLine(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetSLine(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->slinedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(sc_id) FROM v_search_line ";
		$strSQL .= $stmt2;
	//echo "GetSLine_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetSLine(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetSLine(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetSLine(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	

	/*-----------------------------------------------------
	    �α������ - ����
	-----------------------------------------------------*/
	function viewdb_GetSLinecd ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetSLinecd(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//�ӣѣ̾�����
		$sql_where = "";

		if( $this->jyoken["st_prefcd"] != "" )  $sql_where .= " AND st_prefcd = '{$this->jyoken["st_prefcd"]}' ";
		if( $this->jyoken["st_linecd"] != "" )  $sql_where .= " AND st_linecd = '{$this->jyoken["st_linecd"]}' ";
		if( $this->jyoken["st_stacd"] != "" )   $sql_where .= " AND st_stacd = '{$this->jyoken["st_stacd"]}' ";
		if( $this->jyoken["sc_stat"] != "" )    $sql_where .= " AND sc_stat = 1 ";
		if( $this->jyoken["cl_stat"] != "" )    $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )   $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )     $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" ) $sql_where .= " AND cl_deldate is NULL ";
		
		// �¤ӽ�
		$sql_order = "";
		if( $this->sort['line'] == 1 ){
			$sql_order = " ORDER BY st_linecd ";
		}
	
		$strSQL = "";
		$strSQL = " SELECT es_linecd FROM v_search_line ";
		$stmt2 = "";
		$stmt2 .= " WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
//	echo "GetSLine_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetSLinecd(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetSLinecd(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->slinedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetSLinecd(4):Get Failed";
			return -1;
		}
		
			return 1;
		
	}

	/*-----------------------------------------------------
	    ������� - ����(����)
	-----------------------------------------------------*/
	function viewdb_CntSLine ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_CntSLine(1):".$obj->php_error;
			return -1;
		}

		//�ӣѣ̾�����
		$sql_where = "";

		if( $this->jyoken["st_prefcd"] != "" )  $sql_where .= " AND st_prefcd = '{$this->jyoken["st_prefcd"]}' ";
		if( $this->jyoken["st_linecd"] != "" )  $sql_where .= " AND st_linecd = '{$this->jyoken["st_linecd"]}' ";
		if( $this->jyoken["st_stacd"] != "" )   $sql_where .= " AND st_stacd = '{$this->jyoken["st_stacd"]}' ";
		if( $this->jyoken["sc_stat"] != "" )    $sql_where .= " AND sc_stat = 1 ";
		if( $this->jyoken["cl_stat"] != "" )    $sql_where .= " AND cl_stat = '{$this->jyoken["cl_stat"]}' ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )   $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )     $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" ) $sql_where .= " AND cl_deldate is NULL ";

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
		if( count( $this->jyoken["es_linecd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["es_linecd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_linecd LIKE '%/{$val}/%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}

		$strSQL = "SELECT count( sc_id ) as count from v_search_line WHERE cl_id IS NOT NULL AND cl_deldate IS NULL AND sc_stat = 1 AND cl_stat = 1 AND cl_pstat = 1 AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		
		$strSQL .= $sql_where;
		$strSQL .= $sql_order;
		
		//���ӣѣ̼¹�
	//echo "CntSLine_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_CntSLine(2):".pg_errormessage ($this->conn);
			return -1;
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_CntSLine(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return -1;
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->slinedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_CntSLine(4):Get Failed";
			return -1;
		}
		
			return 1;
		
	}

	/*-----------------------------------------------------
	    ������� - ����(��)
	-----------------------------------------------------*/

	function viewdb_CntSLPref ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_CntSLPref(1):".$obj->php_error;
			return -1;
		}

		//�ӣѣ̾�����
		$sql_where = "";
		
		if( $this->jyoken["st_prefcd"] != "" ) $sql_where .= " AND st_prefcd = '{$this->jyoken["st_prefcd"]}' ";

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
		
		$select_table = "SELECT * FROM v_search_line WHERE cl_id IS NOT NULL AND cl_deldate IS NULL AND cl_stat = 1 AND cl_pstat = 1 AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) AND sc_stat = 1 ";
		$strSQL = "";
		$strSQL = " SELECT line.st_prefcd, count(line.st_prefcd) FROM ({$select_table})AS line GROUP BY line.st_prefcd ";
		$stmt2 = "";
		$stmt2 .= " HAVING line.st_prefcd is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		
		//���ӣѣ̼¹�
//	echo "CntSLine_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_CntSLPref(2):".pg_errormessage ($this->conn);
			return -1;
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_CntSLPref(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return -1;
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->slinedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_CntSLPref(4):Get Failed";
			return -1;
		}
		
			return 1;
		
	}

	/*-----------------------------------------------------
	    ������� - ����(����)
	-----------------------------------------------------*/

	function viewdb_CntSLLine ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_CntSLLine(1):".$obj->php_error;
			return -1;
		}

		//�ӣѣ̾�����
		$sql_where = "";
		
		if( $this->jyoken["st_prefcd"] != "" ) $sql_where .= " AND st_prefcd = '{$this->jyoken["st_prefcd"]}' ";
		if( $this->jyoken["es_linecd"] != "" ) $sql_where .= " AND es_linecd LIKE '%/{$this->jyoken["es_linecd"]}/%' ";
		
		$select_table = "SELECT * FROM v_search_line WHERE cl_id IS NOT NULL AND cl_deldate IS NULL AND cl_stat = 1 AND cl_pstat = 1 AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) AND sc_stat = 1 ";
		$select_table .= $sql_where;
		$strSQL = "";
		$strSQL = " SELECT line.st_prefcd, line.st_line, line.st_linecd, count(line.st_linecd) FROM ({$select_table})AS line GROUP BY line.st_linecd, line.st_line, line.st_prefcd";
		$stmt2 = "";
		$stmt2 .= " HAVING line.st_linecd is NOT NULL ";
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		
		//���ӣѣ̼¹�
//	echo "CntSLine_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_CntSLLine(2):".pg_errormessage ($this->conn);
			return -1;
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_CntSLLine(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return -1;
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->slinedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_CntSLLine(4):Get Failed";
			return -1;
		}
		
			return 1;
		
	}

}
?>