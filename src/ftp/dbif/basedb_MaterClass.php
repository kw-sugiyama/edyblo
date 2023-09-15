<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_RoomClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $roomdat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_RoomClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->roomdat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetCnt ( $id ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetRoom(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�����饤����ȥơ��֥�
		$strSQL = "";
		$strSQL = " SELECT count(cl_id) FROM base_t_client ";
		$strSQL .= " WHERE cl_id = {$id} ";
		
		//���ӣѣ̼¹�
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//���֥����ܾ���ơ��֥�
		$strSQL = "";
		$strSQL = " SELECT count(blog_cl_id) FROM base_t_blog ";
		$strSQL .= " WHERE blog_cl_id = {$id} ";
		
		//���ӣѣ̼¹�
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows += @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//�����ƥ������ơ��֥�
		$strSQL = "";
		$strSQL = " SELECT count(cate_cl_id) FROM base_t_category ";
		$strSQL .= " WHERE cate_cl_id = {$id} ";
		
		//���ӣѣ̼¹�
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows += @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//����ʪ��������ơ��֥�
		$strSQL = "";
		$strSQL = " SELECT count(build_id) FROM base_v_buiroom ";
		$strSQL .= " WHERE build_cl_id = {$id} ";
		
		//���ӣѣ̼¹�
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows += @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//����������ơ��֥�
		$strSQL = "";
		$strSQL = " SELECT count(diary_id) FROM base_t_diary ";
		$strSQL .= " WHERE diary_cl_id = {$id} ";
		
		//���ӣѣ̼¹�
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows += @pg_result( $result , 0 , count );
//echo($numrows."<br>");
		@pg_free_result( $result );
		
		//�����饤����ȥơ��֥롡���������
		$strSQL = "";
		$strSQL .= " SELECT count(cl_id) FROM base_t_client ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		//���֥����ܾ���ơ��֥롡���������
		$strSQL = "";
		$strSQL .= " SELECT count(blog_id) FROM base_t_blog ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total += @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		//�����ƥ������ơ��֥롡���������
		$strSQL = "";
		$strSQL .= " SELECT count(cate_id) FROM base_t_category ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total += @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		//����ʪ��������ơ��֥롡���������
		$strSQL = "";
		$strSQL .= " SELECT count(build_id) FROM base_v_buiroom ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total += @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		//����������ơ��֥롡���������
		$strSQL = "";
		$strSQL .= " SELECT count(diary_id) FROM base_t_diary ";
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total += @pg_result( $result , 0 , count );
//echo($total."<br>");
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetRoom(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $numrows , $total );
		
	}
	
}
?>
