<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class viewdb_CampainClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $campaindat;	// ������̤��Ǽ���룲����Ϣ������
	var $campaincntdat;	// ������̤��Ǽ���룲����Ϣ������(���)
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function viewdb_CampainClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->campaindat = Array();	// ������Ϣ������
		$this->campaincntdat = Array();	// ������Ϣ������(���)
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function viewdb_GetCampain ( $stpos , $getnum ) {

		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetCampain(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//�ӣѣ̾�����
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

		
		// �¤ӽ�
		$sql_order = "";
		IF( $this->sort["cp_upddate"] == 2 ){
			$sql_order = " ORDER BY campain_b.cp_upddate desc ";
		}
		IF( $this->sort["cp_upddate"] == 1 ){
			$sql_order = " ORDER BY campain_b.cp_upddate ";
		}
		
		//�����
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
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
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
		
		//�����������
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
	    �֥����ܾ�����
	-----------------------------------------------------*/
	function viewdb_CntCampain ( $stpos , $getnum ) {

		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetCampain(1):".$obj->php_error;
			return array (-1,NULL);
		}

		//�ӣѣ̾�����
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

		//���ӣѣ̼¹�
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
