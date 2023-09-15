<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_FreeClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $freedat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_FreeClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->freedat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetFree ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetFree(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["fr_id"] != "" )       $sql_where .= " AND fr_id = {$this->jyoken["fr_id"]} ";
		if( $this->jyoken["fr_clid"] != "" )       $sql_where .= " AND fr_clid = {$this->jyoken["fr_clid"]} ";


        //�����ɽ�����ʤ�
        if( $this->jyoken["fr_deldate"] == "" ) 
        {
            $sql_where .= " AND fr_deldate is NULL ";
        }
            $sql_where .= " AND fr_deldate is NULL ";

		
		// �¤ӽ�
		$sql_order = "";
		IF( $this->sort["fr_upddate"] == 2 ){
			$sql_order = " ORDER BY fr_upddate desc ";
		}
		IF( $this->sort["fr_upddate"] == 1 ){
			$sql_order = " ORDER BY fr_upddate ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_free ";
		$stmt2 = "";
		$stmt2 .= " WHERE fr_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetFree_SQL ... [".$strSQL."]<BR>";
        $result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetFree(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetFree(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
        }


        $numrows = pg_numrows( $result );
		$cnt = 0;
        for ( $curpos=0; $curpos<$numrows; $curpos++ ) 
        {
            $arr = pg_fetch_array( $result , $curpos );
            reset($arr);
            while( list( $key,$val ) = each( $arr ) )
            {
                $this->freedat[$curpos][$key] = $val;
            }
            $cnt++;
        }
		@pg_free_result( $result );


		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(fr_id) FROM t_free ";
		$strSQL .= $stmt2;
	//echo "GetFree_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetFree(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetFree(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetFree(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
    }



	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_Insfree () {
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_Insfree(1):".$obj->php_error;
			return (-1);
		}
		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO t_free ";
		$strSQL .= "           ( ";
		$strSQL .= "             fr_clid, ";
		$strSQL .= "             fr_title , ";
		$strSQL .= "             fr_html , ";
		$strSQL .= "             fr_insdate , ";
		$strSQL .= "             fr_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->freedat[0]["fr_clid"]}' , ";
		$strSQL .= "             '{$this->freedat[0]["fr_title"]}' , ";
		$strSQL .= "             '{$this->freedat[0]["fr_html"]}' , ";
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
        //echo "freeInsSQL ... [".$strSQL."]<BR>";

        $result = @pg_exec( $this->conn , $strSQL );
        //���顼
		if ( !$result ) {
			$this->php_error = "basedb_Insfree(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
        //�ѹ����ʤ���Х��顼
        if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_Insfree(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
        @pg_free_result( $result );
		//  �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_Insfree(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}
	/*-----------------------------------------------------
	    ���� - ��������
	-----------------------------------------------------*/
	function basedb_UpdFree() {

		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdTeacher(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_free ";
		$strSQL .= "  WHERE fr_id = {$this->freedat[0]["fr_id"]} ";
        $strSQL .= "    FOR UPDATE ";
//echo( $strSQL);

		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
//echo("##0##upd##");
			$this->php_error = "basedb_UpdTeacher(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}

		
		
		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE t_free ";
		$strSQL .= "    SET ";
		if($this->freedat[0]["fr_title"] != ""){
			$strSQL .= "        fr_title = '{$this->freedat[0]["fr_title"]}' , ";
		}else{
			$strSQL .= "        fr_title = NULL , ";
        }

		if($this->freedat[0]["fr_html"] != ""){
			$strSQL .= "        fr_html = '{$this->freedat[0]["fr_html"]}' , ";
		}else{
			$strSQL .= "        fr_html = NULL , ";
		}
	
		
		$strSQL .= "        fr_upddate = 'now' ";
		$strSQL .= "  WHERE fr_id = {$this->freedat[0]["fr_id"]} ";
//echo "TeacherUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdTeacher(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdTeacher(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdTeacher(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}

	/*-----------------------------------------------------
	    ���� - ��������
	-----------------------------------------------------*/
	function basedb_DelFree() {

		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdTeacher(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_free ";
		$strSQL .= "  WHERE fr_id = {$this->freedat[0]["fr_id"]} ";
        $strSQL .= "    FOR UPDATE ";
//echo( $strSQL);

		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
//echo("##0##upd##");
			$this->php_error = "basedb_UpdTeacher(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		
		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE t_free ";
        $strSQL .= "    SET ";
        /*
		if($this->freedat[0]["fr_title"] != ""){
			$strSQL .= "        fr_title = '{$this->freedat[0]["fr_title"]}' , ";
		}else{
			$strSQL .= "        fr_title = NULL , ";
        }

		if($this->freedat[0]["fr_html"] != ""){
			$strSQL .= "        fr_html = '{$this->freedat[0]["fr_html"]}' , ";
		}else{
			$strSQL .= "        fr_html = NULL , ";
        }
        */
		
		$strSQL .= "        fr_deldate = 'now' ";
		$strSQL .= "  WHERE fr_id = {$this->freedat[0]["fr_id"]} ";
//echo "TeacherUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdTeacher(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdTeacher(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdTeacher(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}
}
?>
