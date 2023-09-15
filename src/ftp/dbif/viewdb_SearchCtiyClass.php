<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class viewdb_SCityClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $scitydat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function viewdb_SCityClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->scitydat = Array();	// ������Ϣ������
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function viewdb_GetSCity ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetSCity(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//�ӣѣ̾�����
		$sql_where = "";

		if( $this->jyoken["sc_age"] != "" )       $sql_where .= " AND sc_age & '{$this->jyoken["sc_age"]}' = '{$this->jyoken["sc_age"]}' ";
		if( $this->jyoken["sc_classform"] != "" ) $sql_where .= " AND sc_classform::int & '{$this->jyoken["sc_classform"]}'::int = '{$this->jyoken["sc_classform"]}' ";
		if( $this->jyoken["sc_stat"] != "" )      $sql_where .= " AND sc_stat = 1 ";
		if( $this->jyoken["cl_stat"] != "" )      $sql_where .= " AND cl_stat = 1 ";
		if( $this->jyoken["cl_pstat"] != "" )   $sql_where .= " AND cl_pstat = 1 ";
		if( $this->jyoken["cl_start"] != "" )     $sql_where .= " AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) ";
		if( $this->jyoken["cl_end"] != "" )       $sql_where .= " AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) ";
		if( $this->jyoken["cl_deldate"] != "" )   $sql_where .= " AND cl_deldate is NULL ";
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
		if( count( $this->jyoken["ar_citycd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar_citycd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_citycd = '{$val}' ";
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
		if( count( $this->jyoken["es_stacd_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["es_stacd_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " es_stacd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		if( count( $this->jyoken["sc_classform_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sc_classform_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " sc_classform::int & '{$val}'::int = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		if( count( $this->jyoken["cl_yobi1_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cl_yobi1_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " AND ";
				$buffsql .= " cl_yobi1 LIKE '%{$val}%' ";
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

		
		// �¤ӽ�
		$sql_order = "";
		if( $this->sort["city"] == 1 ){
			$sql_order = " ORDER BY school.ar_citycd ";
		}elseif( $this->sort["sta"] == 1 ){
			$sql_order = " ORDER BY school.es_sta ";
		}

		//�����
		$column = "";
		$column .= "sc_id, sc_clid, sc_title, sc_keywd, sc_introduce, ";
		$column .= "sc_classform, sc_holiday, sc_pr, sc_ido, sc_keido, sc_mapimg, sc_topimg, ";
		$column .= "sc_zoom,sc_age, sc_headertitle, sc_toptitle, sc_topsubtitle, ";
		$column .= "cl_urlcd, cl_jname, cl_kname, cl_mail, cl_zip, ";
		$column .= "cl_pref, cl_prefcd, cl_city, cl_citycd, cl_add, ";
		$column .= "cl_estate, cl_phone, cl_fax, cl_biko, cl_dokuji_flg, cl_dokuji_domain, ";
		$column .= "cl_yobi1, ar_id, ar_flg, ar_zip, ar_pref, ar_prefcd, ";
		$column .= "ar_city, ar_citycd, ar_add, ar_estate, ";
		$column .= "es_line, es_linecd, es_sta, es_stacd, "; 
		$column .= "es_walk, es_bus, es_biko, es_linecdname ";
		
		$select_table = " SELECT DISTINCT ON (sc_id) {$column} FROM v_search_city ";
		$stmt2 .= " WHERE cl_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$select_table .= $stmt2;
		$select_table .= "ORDER BY sc_id ";
		
		$strSQL = "";
		$strSQL = " SELECT * FROM ( {$select_table} ) AS school ";
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
//	echo "GetSCity_SQL ... [".$strSQL."]<BR>";
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
				$this->scitydat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(school.sc_id) FROM ( {$select_table} ) AS school ";
		//$strSQL .= $stmt2;
//	echo "GetDiary_TotalSQL ... [".$strSQL."]<BR>";
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
	    ������� - ����
	-----------------------------------------------------*/
	function viewdb_CntSCity ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_CntSCity(1):".$obj->php_error;
			return -1;
		}

		//�ӣѣ̾�����
		$sql_where = "";
		
		if( $this->jyoken["ar_prefcd"] != "" )    $sql_where .= " AND ar_prefcd = '{$this->jyoken["ar_prefcd"]}' ";

		if( count( $this->jyoken["ar_pref_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar_pref_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " ar_prefcd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		
		
		$select_table = "SELECT DISTINCT ON (sc_id) * FROM v_search_city WHERE cl_id IS NOT NULL AND cl_deldate IS NULL AND cl_stat = 1 AND cl_pstat = 1 AND ( cl_start <= '{$this->today}' OR cl_start is NULL ) AND ( cl_end >= '{$this->today}' OR cl_end is NULL ) AND sc_stat = 1 ";
		$select_table .= $sql_where;
		$strSQL = "";
		$strSQL = " SELECT city.ar_prefcd, city.ar_city, city.ar_citycd, count(city.ar_citycd) FROM ({$select_table})AS city GROUP BY city.ar_citycd, city.ar_city, city.ar_prefcd";
		$stmt2 = "";
		$stmt2 .= " HAVING city.ar_citycd is NOT NULL ";
		//$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		
		//���ӣѣ̼¹�
//	echo "CntSPref_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_CntSCity(2):".pg_errormessage ($this->conn);
			return -1;
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_CntSCity(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return -1;
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->scitydat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_CntSCity(4):Get Failed";
			return -1;
		}
		
			return 1;
		
	}
	
	
}
?>
