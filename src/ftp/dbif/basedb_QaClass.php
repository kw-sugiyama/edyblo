<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_QaClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $qadat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_QaClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->qadat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetQa ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetQa(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["qa_id"] != "" )       $sql_where .= " AND qa_id = {$this->jyoken["qa_id"]} ";
		if( $this->jyoken["qa_clid"] != "" )       $sql_where .= " AND qa_clid = {$this->jyoken["qa_clid"]} ";
		if( $this->jyoken["qa_stat"] != "" )    $sql_where .= " AND qa_stat = {$this->jyoken["qa_stat"]} ";
		if( $this->jyoken["qa_cgid"] != "" )    $sql_where .= " AND qa_cgid = '{$this->jyoken["qa_cgid"]}' ";
		if( $this->jyoken["qa_question"] != "" )    $sql_where .= " AND qa_question = '{$this->jyoken["qa_question"]}' ";
		if( $this->jyoken["qa_answer"] != "" )    $sql_where .= " AND qa_answer = '{$this->jyoken["qa_answer"]}' ";
		if( $this->jyoken["qa_dispno"] != "" )    $sql_where .= " AND qa_img = '{$this->jyoken["qa_dispno"]}' ";
		if( $this->jyoken["qa_deldate"] != "" ) $sql_where .= " AND qa_deldate is NULL ";

		
		// �¤ӽ�
		$sql_order = "";
		IF( $this->sort["qa_upddate"] == 2 ){
			$sql_order = " ORDER BY qa_upddate desc ";
		}
		IF( $this->sort["qa_upddate"] == 1 ){
			$sql_order = " ORDER BY qa_upddate ";
		}
		IF( $this->sort["qa_dispno"] == 2 ){
			$sql_order = " ORDER BY qa_stat,qa_dispno desc ";
		}
		IF( $this->sort["qa_dispno"] == 1 ){
			$sql_order = " ORDER BY qa_stat,qa_dispno ";
		}
		IF( $this->sort["qa_cgid"] == 2 ){
			$sql_order = " ORDER BY qa_stat,qa_cgid,qa_dispno desc ";
		}
		IF( $this->sort["qa_cgid"] == 1 ){
			$sql_order = " ORDER BY qa_stat,qa_cgid,qa_dispno ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_qa ";
		$stmt2 = "";
		$stmt2 .= " WHERE qa_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetQa_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetQa(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetQa(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->qadat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(qa_id) FROM t_qa ";
		$strSQL .= $stmt2;
	//echo "GetQa_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetQa(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetQa(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetQa(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_InsQa () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsQa(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_qa IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsQa(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  ɽ�����ʣ�����å�
		if($this->qadat[0]["qa_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_qa ";
			$strSQL .= "  WHERE qa_dispno = '{$this->qadat[0]["qa_dispno"]}' ";
			$strSQL .= "    AND qa_deldate is null ";
			$strSQL .= "    AND qa_stat <> 9 ";
			$strSQL .= "    AND qa_clid = '{$this->qadat[0]["qa_clid"]}' ";
			$strSQL .= "    AND qa_cgid = '{$this->qadat[0]["qa_cgid"]}' ";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ) {
				$this->php_error = "basedb_InsClient(3):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_numrows ( $result ) != 0 ) {
				$obj->dbcom_DbRollback ();
				return (2);
			}
		}
		@pg_free_result( $result );

		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO t_qa ";
		$strSQL .= "           ( ";
		$strSQL .= "             qa_clid , ";
		$strSQL .= "             qa_stat , ";
		$strSQL .= "             qa_cgid , ";
		$strSQL .= "             qa_question , ";
		$strSQL .= "             qa_answer , ";
		$strSQL .= "             qa_dispno , ";
		$strSQL .= "             qa_adminid , ";
		$strSQL .= "             qa_insdate , ";
		$strSQL .= "             qa_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->qadat[0]["qa_clid"] != ""){
			$strSQL .= "        {$this->qadat[0]["qa_clid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->qadat[0]["qa_stat"] != ""){
			$strSQL .= "        {$this->qadat[0]["qa_stat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->qadat[0]["qa_cgid"] != ""){
			$strSQL .= "        {$this->qadat[0]["qa_cgid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->qadat[0]["qa_question"]}' , ";
		$strSQL .= "             '{$this->qadat[0]["qa_answer"]}' , ";
		if($this->qadat[0]["qa_dispno"] != ""){
			$strSQL .= "        {$this->qadat[0]["qa_dispno"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->qadat[0]["qa_adminid"] != ""){
			$strSQL .= "        {$this->qadat[0]["qa_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "QaInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );

		if ( !$result ) {
			$this->php_error = "basedb_InsQa(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsQa(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_id�μ���
		$result = @pg_exec( $this->conn , " SELECT currval('t_qa_qa_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->qadat[0]["qa_id"] = @pg_result( $result , 0 , currval );

		@pg_free_result( $result );

		//  �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsQa(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - ��������
	-----------------------------------------------------*/
	function basedb_UpdQa () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdQa(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_qa ";
		$strSQL .= "  WHERE qa_id = {$this->qadat[0]["qa_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
			$this->php_error = "basedb_UpdQa(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->qadat[0]["qa_id"] != $arr["qa_id"] ) {
echo("##1##upd##");
			$this->php_error = "basedb_UpdQa(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->qadat[0]["qa_clid"] != $arr["qa_clid"] ) {
echo("##2##upd##");
			$this->php_error = "basedb_UpdQa(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->qadat[0]["qa_upddate"] != $arr["qa_upddate"] ) {
echo("##3##upd##");
			$this->php_error = "basedb_UpdQa(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		//  ɽ�����ʣ�����å�
		if($this->qadat[0]["qa_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_qa ";
			$strSQL .= "  WHERE qa_dispno = '{$this->qadat[0]["qa_dispno"]}' ";
			$strSQL .= "    AND qa_deldate is null ";
			$strSQL .= "    AND qa_stat <> 9 ";
			$strSQL .= "    AND qa_clid = '{$this->qadat[0]["qa_clid"]}' ";
			$strSQL .= "    AND qa_cgid = '{$this->qadat[0]["qa_cgid"]}' ";
			$strSQL .= "    AND qa_id <> '{$this->qadat[0]["qa_id"]}' ";
		//echo "LeftmenuUpdSQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ) {
//echo("##4##");
				$this->php_error = "basedb_InsClient(3):".pg_errormessage ($this->conn);
				$ret = $obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_numrows ( $result ) != 0 ) {
//echo("##5##");
				$obj->dbcom_DbRollback ();
				return (2);
			}
		}
		@pg_free_result( $result );

		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE t_qa ";
		$strSQL .= "    SET ";
		if($this->qadat[0]["qa_clid"] != ""){
			$strSQL .= "        qa_clid = {$this->qadat[0]["qa_clid"]} , ";
		}else{
			$strSQL .= "        qa_clid = NULL , ";
		}
		if($this->qadat[0]["qa_stat"] != ""){
			$strSQL .= "        qa_stat = {$this->qadat[0]["qa_stat"]} , ";
		}else{
			$strSQL .= "        qa_stat = NULL , ";
		}
		if($this->qadat[0]["qa_cgid"] != ""){
			$strSQL .= "        qa_cgid = {$this->qadat[0]["qa_cgid"]} , ";
		}else{
			$strSQL .= "        qa_cgid = NULL , ";
		}
		$strSQL .= "        qa_question = '{$this->qadat[0]["qa_question"]}' , ";
		$strSQL .= "        qa_answer = '{$this->qadat[0]["qa_answer"]}' , ";
		if($this->qadat[0]["qa_dispno"] != ""){
			$strSQL .= "        qa_dispno = {$this->qadat[0]["qa_dispno"]} , ";
		}else{
			$strSQL .= "        qa_dispno = NULL , ";
		}
		$strSQL .= "        qa_upddate = 'now' ";
		$strSQL .= "  WHERE qa_id = {$this->qadat[0]["qa_id"]} ";
	//echo "QaUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdQa(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdQa(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdQa(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - �������
	-----------------------------------------------------*/
	function basedb_DelQa ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelQa(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_qa ";
		$strSQL .= "  WHERE qa_id = {$this->qadat[0]["qa_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelQa(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->qadat[0]["qa_id"] != $arr["qa_id"] ) {
			$this->php_error = "basedb_DelQa(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE t_qa ";
				$strSQL .= "    SET qa_deldate = 'now' ";
				$strSQL .= "  WHERE qa_id = '{$this->qadat[0]["qa_id"]}' ";
			//echo "QaDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelQa(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM t_qa ";
				$strSQL .= "  WHERE qa_id = '{$this->qadat[0]["qa_id"]}'";
			//echo "QaDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelQa(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelQa(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelQa(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


	/*-----------------------------------------------------
	    ���Υ��ꥢ��ʥ�С� - ����
	-----------------------------------------------------*/
	function basedb_SerialQa () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetBuild(1):".$obj->php_error;
			return (-1);
		}
		
		//�ӣѣ̾�����
		$strSQL = "";
		$strSQL = " SELECT last_value FROM t_qa_qa_id_seq ";

		//���ӣѣ̼¹�
	//echo "GetBuild_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetBuild(2):".pg_errormessage ($this->conn);
			return (-1);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetBuild(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->qadat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}

		$this->qadat[0]["last_value"]++;

		return ( $this->qadat[0]["last_value"] );
		
	}

}
?>
