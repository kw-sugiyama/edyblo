<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_AreaClassTblAccess extends dbcom_DBcontroll {

	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $areadat;		// ������̤��Ǽ���룲����Ϣ������

	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_AreaClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->areadat = Array();	// ������Ϣ������
		$this->today = date("Y").'-'.date("m").'-'.date("d");
	}

	/*  ���饤����ȥơ��֥롡�ӣ�����  */
	function basedb_GetArea ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetArea(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["ar_id"] != "" )             $sql_where .= " AND ar_id = '{$this->jyoken["ar_id"]}' ";
		if( $this->jyoken["ar_clid"] != "" )   $sql_where .= " AND ar_clid = '{$this->jyoken["ar_clid"]}' ";
		if( $this->jyoken["ar_flg"] != "" )   $sql_where .= " AND ar_flg = '{$this->jyoken["ar_flg"]}' ";
		if( $this->jyoken["ar_zip"] != "" ) $sql_where .= " AND ar_zip = '{$this->jyoken["ar_zip"]}' ";
		if( $this->jyoken["ar_pref"] != "" )       $sql_where .= " AND ar_pref = '{$this->jyoken["ar_pref"]}' ";
		if( $this->jyoken["ar_prefcd"] != "" )       $sql_where .= " AND ar_prefcd = '{$this->jyoken["ar_prefcd"]}' ";
		if( $this->jyoken["ar_city"] != "" )           $sql_where .= " AND ar_city = {$this->jyoken["ar_city"]} ";
		if( $this->jyoken["ar_citycd"] != "" )      $sql_where .= " AND ar_citycd = '{$this->jyoken["ar_citycd"]}' ";
		if( $this->jyoken["ar_add"] != "" )        $sql_where .= " AND ar_add = {$this->jyoken["ar_add"]} ";
		if( $this->jyoken["ar_estate"] != "" )        $sql_where .= " AND ar_estate = {$this->jyoken["ar_estate"]} ";
		if( $this->jyoken["ar_deldate"] != "" ){
			$sql_where .= " AND ar_deldate is NOT NULL ";
		}ELSE{
			$sql_where .= " AND ar_deldate is NULL ";
		}
		
		
		// �ӣѣ̥����Ⱦ�����
		if ( $this->sort['ar_id'] == 1 ){
			$sql_order .= " ORDER BY ar_id desc ";
		}else if( $this->sort['ar_id'] == 2 ){
			$sql_order .= " ORDER BY ar_id ";
		}
		if ( $this->sort['ar_flg'] == 1 ){
			$sql_order .= " ORDER BY ar_flg desc ";
		}else if( $this->sort['ar_flg'] == 2 ){
			$sql_order .= " ORDER BY ar_flg ";
		}
		
		
		// �ӣѣ�ʸ�����Ȥ�Ω��
		$strSQL = "";
		IF( $this->jyoken["table_name"] != "" ){
			$strSQL = " SELECT * FROM v_area ";
		}ELSE{
			$strSQL = " SELECT * FROM t_area ";
		}
		$stmt2 = "";
		$stmt2 .= " WHERE ar_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}

		
		//���ӣѣ̼¹�
		$result = @pg_exec( $this->conn , $strSQL );
	 //echo "GetArea_TotalSQL ... [".$strSQL."]<BR>";
		if ( !$result ) {
			$this->php_error = "basedb_GetArea(1):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetArea(2):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->areadat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(ar_id) FROM t_area ";
		$strSQL .= $stmt2;
	// echo "GetArea_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetArea(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetArea(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetArea(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*  �����Ծ���ơ��֥롡�ɣ�����  */
	function basedb_InsArea () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsArea(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_area IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsArea(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );

		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO t_area ";
		$strSQL .= "           ( ";
		$strSQL .= "             ar_clid , ";
		$strSQL .= "             ar_flg , ";
		$strSQL .= "             ar_zip , ";
		$strSQL .= "             ar_pref , ";
		$strSQL .= "             ar_prefcd , ";
		$strSQL .= "             ar_city , ";
		$strSQL .= "             ar_citycd , ";
		$strSQL .= "             ar_add , ";
		$strSQL .= "             ar_estate , ";
		$strSQL .= "             ar_adminid , ";
		$strSQL .= "             ar_insdate , ";
		$strSQL .= "             ar_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		IF( $this->areadat[0]["ar_clid"] != "" ){
			$strSQL .= "     '{$this->areadat[0]["ar_clid"]}' , ";
		}ELSE{
			$strSQL .= "     NULL , ";
		}
		IF( $this->areadat[0]["ar_flg"] != "" ){
			$strSQL .= "     '{$this->areadat[0]["ar_flg"]}' , ";
		}ELSE{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             '{$this->areadat[0]["ar_zip"]}' , ";
		$strSQL .= "             '{$this->areadat[0]["ar_pref"]}' , ";
		IF( $this->areadat[0]["ar_prefcd"] != "" ){
			$strSQL .= "     '{$this->areadat[0]["ar_prefcd"]}' , ";
		}ELSE{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             '{$this->areadat[0]["ar_city"]}' , ";
		IF( $this->areadat[0]["ar_citycd"] != "" ){
			$strSQL .= "     '{$this->areadat[0]["ar_citycd"]}' , ";
		}ELSE{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             '{$this->areadat[0]["ar_add"]}' , ";
		$strSQL .= "             '{$this->areadat[0]["ar_estate"]}' , ";
		IF( $this->areadat[0]["ar_adminid"] != "" ){
			$strSQL .= "     '{$this->areadat[0]["ar_adminid"]}' , ";
		}ELSE{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	 //echo "AreaInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsArea(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsArea(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// ar_id�μ���
		$result = @pg_exec( $this->conn , " SELECT currval('t_area_ar_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsArea(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->areadat[0]["ar_id"] = @pg_result( $result , 0 , currval );
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsArea(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  �����Ծ���ơ��֥롡�գ������  */
	function basedb_UpdArea () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdArea(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_area ";
		$strSQL .= "  WHERE ar_id = '{$this->areadat[0]["ar_id"]}' ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
	// echo "AreaUpdSQL ... [".$strSQL."]<BR>";
			$this->php_error = "basedb_UpdArea(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->areadat[0]["ar_id"] != $arr["ar_id"] ) {
echo("#ar#1#");
			$this->php_error = "basedb_UpdArea(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->areadat[0]["ar_upddate"] != $arr["ar_upddate"] ) {
echo("#ar#2#");
			$this->php_error = "basedb_UpdArea(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}

		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE t_area ";
		$strSQL .= "    SET ";
		$strSQL .= "        ar_flg = '{$this->areadat[0]["ar_flg"]}' , ";
		$strSQL .= "        ar_zip = '{$this->areadat[0]["ar_zip"]}' , ";
		$strSQL .= "        ar_pref = '{$this->areadat[0]["ar_pref"]}' , ";
		IF( $this->areadat[0]["ar_prefcd"] != "" ){
			$strSQL .= "        ar_prefcd = '{$this->areadat[0]["ar_prefcd"]}' , ";
		}ELSE{
			$strSQL .= "        ar_prefcd = NULL , ";
		}
		$strSQL .= "        ar_city = '{$this->areadat[0]["ar_city"]}' , ";
		IF( $this->areadat[0]["ar_citycd"] != "" ){
			$strSQL .= "        ar_citycd = '{$this->areadat[0]["ar_citycd"]}' , ";
		}ELSE{
			$strSQL .= "        ar_citycd = NULL , ";
		}
		$strSQL .= "        ar_add = '{$this->areadat[0]["ar_add"]}' , ";
		$strSQL .= "        ar_estate = '{$this->areadat[0]["ar_estate"]}' , ";
		IF( $this->areadat[0]["ar_adminid"] != "" ){
			$strSQL .= "        ar_adminid = '{$this->areadat[0]["ar_adminid"]}' , ";
		}ELSE{
			$strSQL .= "        ar_adminid = NULL , ";
		}
		$strSQL .= "        ar_upddate = 'now' ";
		$strSQL .= "  WHERE ar_id = '{$this->areadat[0]["ar_id"]}' ";
	 //echo "AreaUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdArea(7):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdArea(8):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdArea(9):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*  �����Ծ���ơ��֥롡�ģ������  */
	function basedb_DelArea ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelArea(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_area ";
		$strSQL .= "  WHERE ar_id = {$this->areadat[0]["ar_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelArea(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->areadat[0]["ar_id"] != $arr["ar_id"] ) {
			$this->php_error = "basedb_DelArea(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE t_area ";
				$strSQL .= "    SET ar_deldate = 'now' ";
				$strSQL .= "  WHERE ar_id = '{$this->areadat[0]["ar_id"]}'";
			//echo "AreaDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelArea(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM t_area ";
				$strSQL .= "  WHERE ar_id = '{$this->areadat[0]["ar_id"]}'";
			//echo "AreaDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelArea(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelArea(6):Delete Failed";
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
