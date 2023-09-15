<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_CltpbaseClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $cltpbasedat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_CltpbaseClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->cltpbasedat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetCltpbase ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetCltpbase(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["cltpbase_id"] != "" )       $sql_where .= " AND cltpbase_id = '{$this->jyoken["cltpbase_id"]}' ";
		if( $this->jyoken["cltpbase_cl_id"] != "" )     $sql_where .= " AND cltpbase_stat = '{$this->jyoken["cltpbase_stat"]}' ";
		if( $this->jyoken["cltpbase_del_date"] != "" )     $sql_where .= " AND cltpbase_del_date is null ";
		
		$strSQL = "";
		$strSQL = " SELECT * FROM base_t_cltpbase ";
		$stmt2 = "";
		$stmt2 .= " WHERE cltpbase_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		// �ӣѣ̥����Ⱦ�����
		if ( $this->sort['cl_ins_date'] == 1 ){
			$sql_order .= " ORDER BY cl_ins_date desc ";
		}else if ( $this->sort['cl_ins_date'] == 2 ){
			$sql_order .= " ORDER BY cl_ins_date ";
		}
		if ( $this->sort['cl_upd_date'] == 1 ){
			$sql_order .= " ORDER BY cl_upd_date desc ";
		}else if ( $this->sort['cl_upd_date'] == 2 ){
			$sql_order .= " ORDER BY cl_upd_date ";
		}
		
		
		//���ӣѣ̼¹�
	////echo "GetCltpbase_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCltpbase(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetCltpbase(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->cltpbasedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(cltpbase_id) FROM base_t_cltpbase ";
		$strSQL .= $stmt2;
	//echo "GetCltpbase_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCltpbase(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetCltpbase(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetCltpbase(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_InsCltpbase () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsCltpbase(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE base_t_cltpbase IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCltpbase(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO base_t_cltpbase ";
		$strSQL .= "           ( ";
		$strSQL .= "             cltpbase_cl_id , ";
		$strSQL .= "             cltpbase_topic_title_1 , ";
		$strSQL .= "             cltpbase_topic_contents_1 , ";
		$strSQL .= "             cltpbase_topic_link_1 , ";
		$strSQL .= "             cltpbase_topic_title_2 , ";
		$strSQL .= "             cltpbase_topic_contents_2 , ";
		$strSQL .= "             cltpbase_topic_link_2 , ";
		$strSQL .= "             cltpbase_topic_title_3 , ";
		$strSQL .= "             cltpbase_topic_contents_3 , ";
		$strSQL .= "             cltpbase_topic_link_3 , ";
		$strSQL .= "             cltpbase_html , ";
		$strSQL .= "             cltpbase_biko_1 , ";
		$strSQL .= "             cltpbase_biko_2 , ";
		$strSQL .= "             cltpbase_biko_3 , ";
		$strSQL .= "             cltpbase_biko_4 , ";
		$strSQL .= "             cltpbase_biko_5 , ";
		$strSQL .= "             cltpbase_ins_date , ";
		$strSQL .= "             cltpbase_upd_date";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_cl_id"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_topic_title_1"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_topic_contents_1"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_topic_link_1"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_topic_title_2"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_topic_contents_2"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_topic_link_2"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_topic_title_3"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_topic_contents_3"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_topic_link_3"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_html"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_biko_1"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_biko_2"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_biko_3"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_biko_4"]}' , ";
		$strSQL .= "             '{$this->cltpbasedat[0]["cltpbase_biko_5"]}' , ";
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "CltpbaseInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCltpbase(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsCltpbase(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsCltpbase(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - ��������
	-----------------------------------------------------*/
	function basedb_UpdCltpbase () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCltpbase(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_cltpbase ";
		$strSQL .= "  WHERE cltpbase_id = {$this->cltpbasedat[0]["cltpbase_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_UpdCltpbase(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		//  ��å�����Ƥ���Ȥ���ǥ��顼
		$arr = @pg_fetch_array ( $result , 0 );
//echo  $this->cltpbasedat[0]["cltpbase_id"] .'---'. $arr["cltpbase_id"];
		if ( $this->cltpbasedat[0]["cltpbase_id"] != $arr["cltpbase_id"] ) {
			$this->php_error = "basedb_UpdCltpbase(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->cltpbasedat[0]["cltpbase_cl_id"] != $arr["cltpbase_cl_id"] ) {
			$this->php_error = "basedb_UpdCltpbase(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->cltpbasedat[0]["cltpbase_upd_date"] != $arr["cltpbase_upd_date"] ) {
			$this->php_error = "basedb_UpdCltpbase(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE base_t_cltpbase ";
		$strSQL .= "    SET ";
		$strSQL .= "        cltpbase_cl_id = '{$this->cltpbasedat[0]["cltpbase_cl_id"]}' , ";
		$strSQL .= "        cltpbase_topic_title_1 = '{$this->cltpbasedat[0]["cltpbase_topic_title_1"]}' , ";
		$strSQL .= "        cltpbase_topic_contents_1 = '{$this->cltpbasedat[0]["cltpbase_topic_contents_1"]}' , ";
		$strSQL .= "        cltpbase_topic_link_1 = '{$this->cltpbasedat[0]["cltpbase_topic_link_1"]}' , ";
		$strSQL .= "        cltpbase_topic_title_2 = '{$this->cltpbasedat[0]["cltpbase_topic_title_2"]}' , ";
		$strSQL .= "        cltpbase_topic_contents_2 = '{$this->cltpbasedat[0]["cltpbase_topic_contents_2"]}' , ";
		$strSQL .= "        cltpbase_topic_link_2 = '{$this->cltpbasedat[0]["cltpbase_topic_link_2"]}' , ";
		$strSQL .= "        cltpbase_topic_title_3 = '{$this->cltpbasedat[0]["cltpbase_topic_title_3"]}' , ";
		$strSQL .= "        cltpbase_topic_contents_3 = '{$this->cltpbasedat[0]["cltpbase_topic_contents_3"]}' , ";
		$strSQL .= "        cltpbase_topic_link_3 = '{$this->cltpbasedat[0]["cltpbase_topic_link_3"]}' , ";
		$strSQL .= "        cltpbase_html = '{$this->cltpbasedat[0]["cltpbase_html"]}' , ";
		$strSQL .= "        cltpbase_biko_1 = '{$this->cltpbasedat[0]["cltpbase_biko_1"]}' , ";
		$strSQL .= "        cltpbase_biko_2 = '{$this->cltpbasedat[0]["cltpbase_biko_2"]}' , ";
		$strSQL .= "        cltpbase_biko_3 = '{$this->cltpbasedat[0]["cltpbase_biko_3"]}' , ";
		$strSQL .= "        cltpbase_biko_4 = '{$this->cltpbasedat[0]["cltpbase_biko_4"]}' , ";
		$strSQL .= "        cltpbase_biko_5 = '{$this->cltpbasedat[0]["cltpbase_biko_5"]}' , ";
		$strSQL .= "        cltpbase_upd_date = 'now' ";
		$strSQL .= "  WHERE cltpbase_id = {$this->cltpbasedat[0]["cltpbase_id"]} ";
		$strSQL .= "    AND cltpbase_cl_id = {$this->cltpbasedat[0]["cltpbase_cl_id"]} ";
	//echo "CltpbaseUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdCltpbase(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdCltpbase(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCltpbase(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - �������
	-----------------------------------------------------*/
	function basedb_DelCltpbase ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelCltpbase(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_cltpbase ";
		$strSQL .= "  WHERE cltpbase_id = {$this->cltpbasedat[0]["cltpbase_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelCltpbase(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->cltpbasedat[0]["cltpbase_id"] != $arr["cltpbase_id"] ) {
			$this->php_error = "basedb_DelCltpbase(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE base_t_cltpbase ";
				$strSQL .= "    SET cltpbase_del_date = 'now' ";
				$strSQL .= "  WHERE cltpbase_id = '{$this->cltpbasedat[0]["cltpbase_id"]}' ";
				$strSQL .= "    AND cltpbase_cl_id = '{$this->cltpbasedat[0]["cltpbase_cl_id"]}' ";
			////echo "CltpbaseDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCltpbase(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM base_t_cltpbase ";
				$strSQL .= "  WHERE cltpbase_id = '{$this->cltpbasedat[0]["cltpbase_id"]}'";
				$strSQL .= "    AND cltpbase_cl_id = '{$this->cltpbasedat[0]["cltpbase_cl_id"]}' ";
			//echo "CltpbaseDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCltpbase(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelCltpbase(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelCltpbase(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}

}
?>
