<?
/*****************************************************************************
	͹���ֹ�ޥ���DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class mstdb_ZipcodeClassTblAccess extends dbcom_DBcontroll {

	/*------------------------------------------------------------
	    ���С��ѿ������
	------------------------------------------------------------*/
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $zipdat;		// ������̤��Ǽ���룲����Ϣ������

	/*------------------------------------------------------------
	    ���󥹥ȥ饯��
	------------------------------------------------------------*/
	function mstdb_ZipcodeClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->zipdat = array();	// ������Ϣ������
	}
	
	
	/*------------------------------------------------------------
	    ͹���ֹ�ޥ��� - ����
	------------------------------------------------------------*/
	function mstdb_GetZipcode() {
		
		// �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "mstdb_GetZipcode(1):".$obj->php_error;
			return Array( "-1" , NULL );
		}
		
		// �ӣѣ�ʸ�ףȣţңŶ��Ȥ�Ω��
		$sql_where = "";
		if ( $this->jyoken["zp_zip"] != "" ){
			$sql_where .= " AND zp_zip = '{$this->jyoken["zp_zip"]}' ";
		}
		if ( $this->jyoken["zp_prefcd"] != "" ){
			$sql_where .= " AND zp_prefcd = '{$this->jyoken["zp_prefcd"]}' ";
		}
		if ( $this->jyoken["zp_citycd"] != "" ){
			$sql_where .= " AND zp_citycd = '{$this->jyoken["zp_citycd"]}' ";
		}
		if ( count($this->jyoken["address_list"]) != 0 ){
			$sql_tmp = "";
			$sql_where .= " AND ( ";
			foreach($this->jyoken["address_list"] as $key => $val){
				if($sql_tmp != "")$sql_tmp .= " AND ";
				$sql_tmp .= " zp_pref || zp_city || zp_add like '%{$val}%' ";
			}
			$sql_where .= $sql_tmp;
			$sql_where .= " ) ";
		}
		if ( $this->jyoken["address_select"] != "" ){
			$sql_where .= " AND zp_zip = '{$this->jyoken["address_select"]}' ";
		}
		
		
		// �ӣѣ�ʸ�ϣңģţҶ��Ȥ�Ω��
		if ( $this->sort["zp_zip"] == "asc" ){
			$sql_order .= " ORDER BY zp_zip asc ";
		}elseif ( $this->sort["zp_zip"] == "desc" ){
			$sql_order .= " ORDER BY zp_zip desc ";
		}
		
		// �ӣѣ�ʸ�����Ȥ�Ω��
		$strSQL = "";
		if( $this->jyoken["distinct"] != "" ){
			$strSQL = " SELECT distinct zp_citycd,zp_city FROM m_zip ";
		}else{
			$strSQL = " SELECT * FROM m_zip ";
		}
		$stmt2 = "";
		$stmt2 .= " WHERE zp_zip is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		
		// �ӣѣ̼¹�
// echo($strSQL);
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_GetZipcode(1):".pg_errormessage ($this->conn);
			return Array( "-1" , NULL );
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "mstdb_GetZipcode(2):Get Failed";
			$obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->zipdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "mstdb_GetZipcode(6):Get Failed";
			return Array( "-1" , NULL );
		}
		
		return Array( "0" , $cnt );
		
	}
	
	
	/*------------------------------------------------------------
	    ͹���ֹ�ޥ��� - �����Ͽ
	------------------------------------------------------------*/
	function mstdb_InsZipcodeAll () {
		
		
		// �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "mstdb_InsZipcodeAll(1):".$obj->php_error;
			return Array( "-1" , NULL );
		}
		
		
		// �ơ��֥��å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE m_zip IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_InsZipcodeAll(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		@pg_free_result( $result );
		
		
		// ��¸��Ͽ�����ǧ
		$strSQL = "";
		$strSQL .= " SELECT count(zp_zip) FROM m_zip";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_InsZipcodeAll(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		$intBuffCnt = @pg_result( $result , 0 , count );
		IF( $intBuffCnt != 0 ){
			$this->php_error = "mstdb_InsZipcodeAll(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "1" , NULL );
		}
		@pg_free_result( $result );
		
		
		// INSERT�����ǧ
		$intCntInsZip = count( $this->zipdat );
		
		
		// INSERT����
		$intInsCnt = 0;
		FOR( $iX=0; $iX<$intCntInsZip; $iX++ ){
			
			// ͹���ֹ������Ͽ
			$strSQL = "";
			$strSQL .= " INSERT INTO m_zip ";
			$strSQL .= "           ( ";
			$strSQL .= "             zp_zip , ";
			$strSQL .= "             zp_prefcd , ";
			$strSQL .= "             zp_pref , ";
			$strSQL .= "             zp_citycd , ";
			$strSQL .= "             zp_city , ";
			$strSQL .= "             zp_add ";
			$strSQL .= "           ) ";
			$strSQL .= "      VALUES ";
			$strSQL .= "           ( ";
			$strSQL .= "             '{$this->zipdat[$iX]["zp_zip"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["zp_prefcd"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["zp_pref"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["zp_citycd"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["zp_city"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["zp_add"]}' ";
			$strSQL .= "           ) ";
		//echo "InsZipcodeAll_SQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ) {
//echo "InsZipcodeAll_SQL ... [".$strSQL."]<BR>";
				$this->php_error = "mstdb_InsZipcodeAll(5):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return Array( "-1" , NULL );
			}
			if ( pg_cmdtuples( $result ) != 1 ) {
//echo "InsZipcodeAll_SQL ... [".$strSQL."]<BR>";
				$this->php_error = "mstdb_InsZipcodeAll(6):Insert Failed";
				$obj->dbcom_DbRollback ();
				return Array( "-1" , NULL );
			}
			@pg_free_result( $result );
			
			$intInsCnt++;
			
		}
		
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "mstdb_InsZipcodeAll(7):".$this->php_error;
			return Array( "-1" , NULL );
		}
		
		return Array( "0" , $intInsCnt );
		
	}
	
	
	/*------------------------------------------------------------
	    ͹���ֹ�ޥ��� - �����
	------------------------------------------------------------*/
	function mstdb_DelZipcodeAll () {
		
		// �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "mstdb_DelZipcodeAll(1):".$obj->php_error;
			return (-1);
		}
		
		// �ơ��֥��å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE m_zip IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_InsZipcodeAll(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		@pg_free_result( $result );
		
		
		// �ǡ��������
		$strSQL = "";
		$strSQL .= " DELETE FROM m_zip ";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_DelZipcodeAll(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		$intAllDelCnt = pg_cmdtuples ( $result );
		@pg_free_result( $result );
		
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "mstdb_DelZipcodeAll(4):".$this->php_error;
			return Array( "-1" , NULL );
		}
		
		return Array( "0" , $intAllDelCnt );
		
	}

}
?>
