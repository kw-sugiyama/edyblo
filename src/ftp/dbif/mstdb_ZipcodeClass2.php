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
		if ( $this->jyoken["zip"] != "" ){
			$sql_where .= " AND zip = '{$this->jyoken["zip"]}' ";
		}
		if ( $this->jyoken["pref_cd"] != "" ){
			$sql_where .= " AND pref_cd = '{$this->jyoken["pref_cd"]}' ";
		}
		if ( $this->jyoken["addr_cd"] != "" ){
			$sql_where .= " AND addr_cd = '{$this->jyoken["addr_cd"]}' ";
		}
		if ( $this->jyoken["address_list"] != "" ){
			$sql_where .= " AND address2 || address3 like '%{$this->jyoken["address_list"]}%' ";
		}
		
		
		// �ӣѣ�ʸ�ϣңģţҶ��Ȥ�Ω��
		if ( $this->sort["zip"] == "asc" ){
			$sql_order .= " ORDER BY zip asc ";
		}elseif ( $this->sort["zip"] == "desc" ){
			$sql_order .= " ORDER BY zip desc ";
		}
		
		// �ӣѣ�ʸ�����Ȥ�Ω��
		$strSQL = "";
		if( $this->jyoken["distinct"] != "" ){
			$strSQL = " SELECT distinct addr_cd,address2 FROM mst_t_zipcode ";
		}else{
			$strSQL = " SELECT * FROM mst_t_zipcode ";
		}
		$stmt2 = "";
		$stmt2 .= " WHERE zip is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		
		// �ӣѣ̼¹�
		echo($strSQL);
		$result = pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_GetZipcode(1):".pg_errormessage ($this->conn);
			return Array( "-1" , NULL );
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "mstdb_GetZipcode(2):Get Failed";
			$obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		$numrows = pg_num_rows( $result );
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
		$strSQL .= " LOCK TABLE mst_t_zipcode IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_InsZipcodeAll(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		@pg_free_result( $result );
		
		
		// ��¸��Ͽ�����ǧ
		$strSQL = "";
		$strSQL .= " SELECT count(zip) FROM mst_t_zipcode";
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
			$strSQL .= " INSERT INTO mst_t_zipcode ";
			$strSQL .= "           ( ";
			$strSQL .= "             zip , ";
			$strSQL .= "             pref_cd , ";
			$strSQL .= "             address1 , ";
			$strSQL .= "             addr_cd , ";
			$strSQL .= "             address2 , ";
			$strSQL .= "             address3 ";
			$strSQL .= "           ) ";
			$strSQL .= "      VALUES ";
			$strSQL .= "           ( ";
			$strSQL .= "             '{$this->zipdat[$iX]["zip"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["pref_cd"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["address1"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["addr_cd"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["address2"]}' , ";
			$strSQL .= "             '{$this->zipdat[$iX]["address3"]}' ";
			$strSQL .= "           ) ";
		//echo "InsZipcodeAll_SQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "mstdb_InsZipcodeAll(5):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return Array( "-1" , NULL );
			}
			if ( pg_cmdtuples( $result ) != 1 ) {
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
		$strSQL .= " LOCK TABLE mst_t_zipcode IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "mstdb_InsZipcodeAll(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return Array( "-1" , NULL );
		}
		@pg_free_result( $result );
		
		
		// �ǡ��������
		$strSQL = "";
		$strSQL .= " DELETE FROM mst_t_zipcode ";
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
