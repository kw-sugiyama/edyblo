<?
/*****************************************************************************
	������DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_AdminClassTblAccess extends dbcom_DBcontroll {

	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $admindat;		// ������̤��Ǽ���룲����Ϣ������

	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_AdminClassTblAccess () {
		$this->conn = NULL;	 // �ģ���³�ɣ�
		$this->php_error = NULL;    // �������顼��å�����
		$this->jyoken = array();    // �������
		$this->sort = NULL;   	 	// ����ɽ��������
		$this->admindat = array();  // ������Ϣ������
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}

	/*  �����ԤΥ������������å�  */
	function basedb_CheckAdmin () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_CheckAdmin(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		
		// ������������
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_admin ";
		$strSQL .= "  WHERE ad_logincd = '{$this->admindat[0]["ad_logincd"]}' ";
		$strSQL .= "    AND ad_passcd = '{$this->admindat[0]["ad_passcd"]}' ";
		$strSQL .= "    AND ad_deldate IS NULL ";
	//echo "AdminSearchSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_CheckAdmin(2):".pg_errormessage ($this->conn);
			return (-1);
		}
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->admindat[0]["ad_logincd"] != $arr["ad_logincd"] ) {
			$this->php_error = "basedb_CheckAdmin(3):".pg_errormessage ($this->conn);
			return (1);
		}
		if ( $this->admindat[0]["ad_passcd"] != $arr["ad_passcd"] ) {
			$this->php_error = "basedb_CheckAdmin(4):".pg_errormessage ($this->conn);
			return (1);
		}
		if ( $arr["ad_deldate"] != NULL ) {
			$this->php_error = "basedb_CheckAdmin(5):".pg_errormessage ($this->conn);
			return (2);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_CheckAdmin(6):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		
		$this->admindat[0]["ad_id"] = $arr["ad_id"];
		$this->admindat[0]["ad_name"] = $arr["ad_name"];
		$this->admindat[0]["ad_loginid"] = $arr["ad_loginid"];
		$this->admindat[0]["ad_passwd"] = $arr["ad_passwd"];
		$this->admindat[0]["ad_logincd"] = $arr["ad_logincd"];
		$this->admindat[0]["ad_passcd"] = $arr["ad_passcd"];
		$this->admindat[0]["ad_auth"] = $arr["ad_auth"];
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_CheckAdmin(7):Get Failed";
			return array (-1,NULL);
		}
		return (0);
		
	}
	
	
	/*  ���饤����ȥơ��֥롡�ӣ�����  */
	function basedb_GetAdmin ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetAdmin(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//���ӣѣ�ʸ�Ȥ�Ω��
		$sql_where = "";
		if ( $this->jyoken["ad_id"] != "" ){
			$sql_where .= " AND ad_id = '{$this->jyoken["ad_id"]}' ";
		}
		if ( $this->jyoken["ad_logincd"] != "" ){
			$sql_where .= " AND ad_logincd = '{$this->jyoken["ad_logincd"]}' ";
		}
		if ( $this->jyoken["ad_passcd"] != "" ){
			$sql_where .= " AND ad_passcd = '{$this->jyoken["ad_passcd"]}' ";
		}
		if ( $this->jyoken["ad_deldate"] != "" ){
			$sql_where .= " AND ad_deldate is NULL ";
		}
		
		if ( $this->sort == 1 ){
			$sql_order .= " ORDER BY ad_id desc ";
		}else{
			$sql_order .= " ORDER BY ad_id ";
		}
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_admin ";
		$stmt2 = "";
		$stmt2 .= " WHERE ad_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetAdmin_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetAdmin(1):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetAdmin(2):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->admindat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(ad_id) FROM t_admin ";
		$strSQL .= $stmt2;
	//echo "GetAdmin_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetAdmin(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetAdmin(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetAdmin(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*  �����Ծ���ơ��֥롡�ɣ�����  */
	function basedb_InsAdmin () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsAdmin(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_admin IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsAdmin(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  ������ɣĽ�ʣ�����å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_admin ";
		$strSQL .= "  WHERE ad_loginid = '{$this->admindat[0]["ad_loginid"]}' ";
		$strSQL .= "    AND ad_deldate IS NULL ";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
echo("1");
			$this->php_error = "basedb_InsAdmin(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_numrows ( $result ) != 0 ) {
echo("2");
			$obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_freeresult ( $result );
		
		
		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO t_admin ";
		$strSQL .= "           ( ";
		$strSQL .= "             ad_name , ";
		$strSQL .= "             ad_loginid , ";
		$strSQL .= "             ad_passwd , ";
		$strSQL .= "             ad_logincd , ";
		$strSQL .= "             ad_passcd , ";
		$strSQL .= "             ad_auth , ";
		$strSQL .= "             ad_makeid , ";
		$strSQL .= "             ad_insdate , ";
		$strSQL .= "             ad_upddate , ";
		$strSQL .= "             ad_biko , ";
		$strSQL .= "             ad_yobi1 , ";
		$strSQL .= "             ad_yobi2 , ";
		$strSQL .= "             ad_yobi3 , ";
		$strSQL .= "             ad_yobi4 , ";
		$strSQL .= "             ad_yobi5 ";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->admindat[0]["ad_name"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_loginid"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_passwd"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_logincd"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_passcd"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_auth"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_makeid"]}' , ";
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_biko"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_yobi1"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_yobi2"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_yobi3"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_yobi4"]}' , ";
		$strSQL .= "             '{$this->admindat[0]["ad_yobi5"]}' ";
		$strSQL .= "           ) ";
	echo "AdminInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
echo("3");
			$this->php_error = "basedb_InsAdmin(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
echo("4");
			$this->php_error = "basedb_InsAdmin(5):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "agentdb_InsUser(6):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  �����Ծ���ơ��֥롡�գ������  */
	function basedb_UpdAdmin () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdAdmin(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_admin ";
		$strSQL .= "  WHERE ad_id = '{$this->admindat[0]["ad_id"]}' ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_UpdAdmin(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->admindat[0]["ad_id"] != $arr["ad_id"] ) {
			$this->php_error = "basedb_UpdAdmin(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		if ( $this->admindat[0]["ad_upddate"] != $arr["ad_upddate"] ) {
			$this->php_error = "basedb_UpdAdmin(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (3);
		}
		@pg_free_result( $result );
		
		//  ������ɣĽ�ʣ�����å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_admin ";
		$strSQL .= "  WHERE ad_id != '{$this->admindat[0]["ad_id"]}' ";
		$strSQL .= "    AND ad_loginid = '{$this->admindat[0]["ad_loginid"]}' ";
		$strSQL .= "    AND ad_deldate IS NULL ";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_UpdAdmin(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_numrows ( $result ) != 0 ) {
			$obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE t_admin ";
		$strSQL .= "    SET ";
		$strSQL .= "        ad_name = '{$this->admindat[0]["ad_name"]}' , ";
		$strSQL .= "        ad_loginid = '{$this->admindat[0]["ad_loginid"]}' , ";
		$strSQL .= "        ad_passwd = '{$this->admindat[0]["ad_passwd"]}' , ";
		$strSQL .= "        ad_logincd = '{$this->admindat[0]["ad_logincd"]}' , ";
		$strSQL .= "        ad_passcd = '{$this->admindat[0]["ad_passcd"]}' , ";
		$strSQL .= "        ad_auth = '{$this->admindat[0]["ad_auth"]}' , ";
		$strSQL .= "        ad_makeid = '{$this->admindat[0]["ad_makeid"]}' , ";
		$strSQL .= "        ad_upddate = 'now' , ";
		$strSQL .= "        ad_biko = '{$this->admindat[0]["ad_biko"]}' , ";
		$strSQL .= "        ad_yobi1 = '{$this->admindat[0]["ad_yobi1"]}' , ";
		$strSQL .= "        ad_yobi2 = '{$this->admindat[0]["ad_yobi2"]}' , ";
		$strSQL .= "        ad_yobi3 = '{$this->admindat[0]["ad_yobi3"]}' , ";
		$strSQL .= "        ad_yobi4 = '{$this->admindat[0]["ad_yobi4"]}' , ";
		$strSQL .= "        ad_yobi5 = '{$this->admindat[0]["ad_yobi5"]}' ";
		$strSQL .= "  WHERE ad_id = '{$this->admindat[0]["ad_id"]}' ";
	//echo "AdminUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdAdmin(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdAdmin(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdAdmin(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  �����Ծ���ơ��֥롡�ģ������  */
	function basedb_DelAdmin ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelAdmin(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_admin ";
		$strSQL .= "  WHERE ad_id = {$this->admindat[0]["ad_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelAdmin(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->admindat[0]["ad_id"] != $arr["ad_id"] ) {
			$this->php_error = "basedb_DelAdmin(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE t_admin ";
				$strSQL .= "    SET ad_deldate = 'now' ";
				$strSQL .= "  WHERE ad_id = '{$this->admindat[0]["ad_id"]}'";
			//echo "AdminDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelAdmin(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM t_admin ";
				$strSQL .= "  WHERE ad_id = '{$this->admindat[0]["ad_id"]}'";
			//echo "AdminDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelAdmin(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelAdmin(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "agentdb_InsUser(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}

}
?>
