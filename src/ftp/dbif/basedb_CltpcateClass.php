<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_CltpcateClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $cltpcatedat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_CltpcateClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->cltpcatedat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetCltpcate ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetCltpcate(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["cltpcate_id"] != "" )       $sql_where .= " AND cltpcate_id = '{$this->jyoken["cltpcate_id"]}' ";
		if( $this->jyoken["cltpcate_cl_id"] != "" )     $sql_where .= " AND cltpcate_cl_id = '{$this->jyoken["cltpcate_cl_id"]}' ";
		if( $this->jyoken["cltpcate_stat"] != "" )     $sql_where .= " AND cltpcate_stat = '{$this->jyoken["cltpcate_stat"]}' ";
		if( $this->jyoken["cltpcate_disp_no"] != "" )     $sql_where .= " AND cltpcate_disp_no = '{$this->jyoken["cltpcate_disp_no"]}' ";
		if( $this->jyoken["cltpcate_del_date"] != "" )     $sql_where .= " AND cltpcate_del_date is null ";


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
		if ( $this->sort['cltpcate_main'] == 1 ){
			$sql_order .= " ORDER BY cltpcate_stat,cltpcate_disp_no desc ";
		}else if ( $this->sort['cltpcate_main'] == 2 ){
			$sql_order .= " ORDER BY cltpcate_stat,cltpcate_disp_no ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM base_t_cltpcate ";
		$stmt2 = "";
		$stmt2 .= " WHERE cltpcate_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	////echo "GetCltpcate_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCltpcate(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetCltpcate(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->cltpcatedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(cltpcate_id) FROM base_t_cltpcate ";
		$strSQL .= $stmt2;
	//echo "GetCltpcate_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCltpcate(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetCltpcate(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetCltpcate(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_InsCltpcate () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsCltpcate(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE base_t_cltpcate IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCltpcate(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO base_t_cltpcate ";
		$strSQL .= "           ( ";
		$strSQL .= "             cltpcate_cl_id , ";
		$strSQL .= "             cltpcate_stat , ";
		$strSQL .= "             cltpcate_disp_no , ";
		$strSQL .= "             cltpcate_name , ";
		$strSQL .= "             cltpcate_biko_1 , ";
		$strSQL .= "             cltpcate_biko_2 , ";
		$strSQL .= "             cltpcate_biko_3 , ";
		$strSQL .= "             cltpcate_biko_4 , ";
		$strSQL .= "             cltpcate_biko_5 , ";
		$strSQL .= "             cltpcate_ins_date , ";
		$strSQL .= "             cltpcate_upd_date";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             1 , ";
		$strSQL .= "             '{$this->cltpcatedat[0]["cltpcate_stat"]}' , ";
		$strSQL .= "             '{$this->cltpcatedat[0]["cltpcate_disp_no"]}' , ";
		$strSQL .= "             '{$this->cltpcatedat[0]["cltpcate_name"]}' , ";
		$strSQL .= "             '{$this->cltpcatedat[0]["cltpcate_biko_1"]}' , ";
		$strSQL .= "             '{$this->cltpcatedat[0]["cltpcate_biko_2"]}' , ";
		$strSQL .= "             '{$this->cltpcatedat[0]["cltpcate_biko_3"]}' , ";
		$strSQL .= "             '{$this->cltpcatedat[0]["cltpcate_biko_4"]}' , ";
		$strSQL .= "             '{$this->cltpcatedat[0]["cltpcate_biko_5"]}' , ";
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "CltpcateInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCltpcate(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsCltpcate(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsCltpcate(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - ��������
	-----------------------------------------------------*/
	function basedb_UpdCltpcate () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCltpcate(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_cltpcate ";
		$strSQL .= "  WHERE cltpcate_id = {$this->cltpcatedat[0]["cltpcate_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
//echo($strSQL."<BR>#dbif-erorr#1#");
			$this->php_error = "basedb_UpdCltpcate(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->cltpcatedat[0]["cltpcate_id"] != $arr["cltpcate_id"] ) {
//echo("#dbif-erorr#2#");
			$this->php_error = "basedb_UpdCltpcate(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->cltpcatedat[0]["cltpcate_upd_date"] != $arr["cltpcate_upd_date"] ) {
//echo("#dbif-erorr#3#");
			$this->php_error = "basedb_UpdCltpcate(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE base_t_cltpcate ";
		$strSQL .= "    SET ";
		$strSQL .= "        cltpcate_cl_id = 1 , ";
		$strSQL .= "        cltpcate_stat = '{$this->cltpcatedat[0]["cltpcate_stat"]}' , ";
		$strSQL .= "        cltpcate_disp_no = '{$this->cltpcatedat[0]["cltpcate_disp_no"]}' , ";
		$strSQL .= "        cltpcate_name = '{$this->cltpcatedat[0]["cltpcate_name"]}' , ";
		$strSQL .= "        cltpcate_biko_1 = '{$this->cltpcatedat[0]["cltpcate_biko_1"]}' , ";
		$strSQL .= "        cltpcate_biko_2 = '{$this->cltpcatedat[0]["cltpcate_biko_2"]}' , ";
		$strSQL .= "        cltpcate_biko_3 = '{$this->cltpcatedat[0]["cltpcate_biko_3"]}' , ";
		$strSQL .= "        cltpcate_biko_4 = '{$this->cltpcatedat[0]["cltpcate_biko_4"]}' , ";
		$strSQL .= "        cltpcate_biko_5 = '{$this->cltpcatedat[0]["cltpcate_biko_5"]}' , ";
		$strSQL .= "        cltpcate_upd_date = 'now' ";
		$strSQL .= "  WHERE cltpcate_id = {$this->cltpcatedat[0]["cltpcate_id"]} ";
	//echo "CltpcateUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdCltpcate(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdCltpcate(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCltpcate(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - �������
	-----------------------------------------------------*/
	function basedb_DelCltpcate ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelCltpcate(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_cltpcate ";
		$strSQL .= "  WHERE cltpcate_id = {$this->cltpcatedat[0]["cltpcate_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelCltpcate(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->cltpcatedat[0]["cltpcate_id"] != $arr["cltpcate_id"] ) {
			$this->php_error = "basedb_DelCltpcate(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE base_t_cltpcate ";
				$strSQL .= "    SET cltpcate_del_date = 'now' ";
				$strSQL .= "  WHERE cltpcate_id = '{$this->cltpcatedat[0]["cltpcate_id"]}' ";
			//echo "CltpcateDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCltpcate(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM base_t_cltpcate ";
				$strSQL .= "  WHERE cltpcate_id = '{$this->cltpcatedat[0]["cltpcate_id"]}'";
			//echo "CltpcateDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCltpcate(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelCltpcate(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelCltpcate(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}

	/*  ɽ����ȿ�ǡ��ģ���  */
	function basedb_DspCltpcate () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCltpcate(1):".$obj->php_error;
			return (-1);
		}

		$flg = true;
		for ( $vX = 0; $vX < $this->cltpcatedat[0]["intCnt"]; $vX++ ) {
			for ( $jX = 0; $jX < $this->cltpcatedat[0]["intCnt"]; $jX++ ) {
				if ($vX != $jX && $this->cltpcatedat[$vX]["cltpcate_disp_no"] == $this->cltpcatedat[$jX]["cltpcate_disp_no"] ) {
					$flg = false;
					break;
				}
			}
		}
		if($flg == false){
				$this->php_error = "basedb_DspCltpcate(2):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (2);
		}

		for($iX=0;$iX<$this->cltpcatedat[0]["intCnt"];$iX++){

			//  �쥳���ɥ�å�
			$strSQL = "";
			$strSQL .= " SELECT * FROM base_t_cltpcate ";
			$strSQL .= "  WHERE cltpcate_id = '{$this->cltpcatedat[$iX]["cltpcate_id"]}' ";
			$strSQL .= "    FOR UPDATE ";
			$result = @pg_exec ( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "basedb_UpdCltpcate(2):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			//  �����ǡ������裳�Ԥ���˹����������Υ����å�
			$arr = @pg_fetch_array ( $result , 0 );
			if ( $this->cltpcatedat[$iX]["cltpcate_id"] != $arr["cltpcate_id"] ) {
				$this->php_error = "basedb_UpdCltpcate(3):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( $this->cltpcatedat[$iX]["cltpcate_upd_date"] != $arr["cltpcate_upd_date"] ) {
				$this->php_error = "basedb_UpdCltpcate(4):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (1);
			}
			@pg_free_result( $result );

			//  �����Ծ�����
			$strSQL = "";
			$strSQL .= " UPDATE base_t_cltpcate ";
			$strSQL .= "    SET ";
			$strSQL .= "        cltpcate_disp_no = '{$this->cltpcatedat[$iX]["cltpcate_disp_no"]}' , ";
			$strSQL .= "        cltpcate_upd_date = 'now' ";
			$strSQL .= "  WHERE cltpcate_id = '{$this->cltpcatedat[$iX]["cltpcate_id"]}' ";
	//echo "CltpcateDspSQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ){
				$this->php_error = "basedb_UpdCltpcate(7):".pg_errormessage ($this->conn);
				$obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_cmdtuples( $result ) != 1 ) {
				$this->php_error = "basedb_UpdCltpcate(8):Update Failed";
				$obj->dbcom_DbRollback ();
				return (-1);
			}
		
		}

		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCltpcate(9):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}

}
?>
