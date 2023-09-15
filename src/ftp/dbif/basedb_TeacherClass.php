<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/
require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");
/**
 * basedb_TeacherClassTblAccess 
 * 
 * @uses dbcom
 * @uses _DBcontroll
 * @package 
 * @version $id$
 * @copyright 2011-2011 �� Corporation.
 * @author Hatori  
 * @license  XXXX Lisence
 */
class basedb_TeacherClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $teacherdat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_TeacherClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->teacherdat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetTeacher ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetTeacher(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["tc_id"] != "" )       $sql_where .= " AND tc_id = {$this->jyoken["tc_id"]} ";
		if( $this->jyoken["tc_clid"] != "" )       $sql_where .= " AND tc_cpid = {$this->jyoken["tc_clid"]} ";
		if( $this->jyoken["tc_stat"] != "" )    $sql_where .= " AND tc_stat = {$this->jyoken["tc_stat"]} ";
		if( $this->jyoken["tc_name"] != "" )    $sql_where .= " AND tc_name = '{$this->jyoken["tc_name"]}' ";
		if( $this->jyoken["tc_img"] != "" )    $sql_where .= " AND tc_cateid = '{$this->jyoken["tc_img"]}' ";
		if( $this->jyoken["tc_imgorg"] != "" )    $sql_where .= " AND tc_cateid = '{$this->jyoken["tc_imgorg"]}' ";
		if( $this->jyoken["tc_contents"] != "" )    $sql_where .= " AND tc_contents = '{$this->jyoken["tc_contents"]}' ";
		if( $this->jyoken["tc_comment"] != "" )    $sql_where .= " AND tc_comment = '{$this->jyoken["tc_comment"]}' ";
		if( $this->jyoken["tc_subject"] != "" )    $sql_where .= " AND tc_subject = '{$this->jyoken["tc_subject"]}' ";
		if( $this->jyoken["tc_age"] != "" )    $sql_where .= " AND tc_age = '{$this->jyoken["tc_age"]}' ";
		if( $this->jyoken["tc_deldate"] != "" ) $sql_where .= " AND tc_deldate is NULL ";
		
		// �¤ӽ�
		$sql_order = "";
		IF( $this->sort["tc_upddate"] == 2 ){
			$sql_order = " ORDER BY tc_upddate desc ";
		}
		IF( $this->sort["tc_upddate"] == 1 ){
			$sql_order = " ORDER BY tc_upddate ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_teacher ";
		$stmt2 = "";
		$stmt2 .= " WHERE tc_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetTeacher_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetTeacher(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetTeacher(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->teacherdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(tc_id) FROM t_teacher ";
		$strSQL .= $stmt2;
	//echo "GetTeacher_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetTeacher(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetTeacher(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetTeacher(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_InsTeacher () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsTeacher(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_teacher IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsTeacher(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO t_teacher ";
		$strSQL .= "           ( ";
		$strSQL .= "             tc_cpid , ";
		$strSQL .= "             tc_stat , ";
		$strSQL .= "             tc_name , ";
		if($this->teacherdat[0]["tc_img"] != ""){
			$strSQL .= "             tc_img , ";
		}
		if($this->teacherdat[0]["tc_imgorg"] != ""){
			$strSQL .= "             tc_imgorg , ";
		}
		$strSQL .= "             tc_contents , ";
		$strSQL .= "             tc_comment , ";
		$strSQL .= "             tc_subject , ";
		$strSQL .= "             tc_age , ";
		$strSQL .= "             tc_adminid , ";
		$strSQL .= "             tc_insdate , ";
		$strSQL .= "             tc_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->teacherdat[0]["tc_cpid"] != ""){
			$strSQL .= "        {$this->teacherdat[0]["tc_cpid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->teacherdat[0]["tc_stat"] != ""){
			$strSQL .= "        {$this->teacherdat[0]["tc_stat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->teacherdat[0]["tc_name"] != ""){
			$strSQL .= "        '{$this->teacherdat[0]["tc_name"]}' , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->teacherdat[0]["tc_img"] != ""){
			$strSQL .= "             '{$this->teacherdat[0]["tc_img"]}' , ";
		}
		if($this->teacherdat[0]["tc_imgorg"] != ""){
			$strSQL .= "             '{$this->teacherdat[0]["tc_imgorg"]}' , ";
		}
		$strSQL .= "             '{$this->teacherdat[0]["tc_contents"]}' , ";
		$strSQL .= "             '{$this->teacherdat[0]["tc_comment"]}' , ";
		$strSQL .= "             '{$this->teacherdat[0]["tc_subject"]}' , ";
		if($this->teacherdat[0]["tc_age"] != ""){
			$strSQL .= "        {$this->teacherdat[0]["tc_age"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->teacherdat[0]["tc_adminid"] != ""){
			$strSQL .= "        {$this->teacherdat[0]["tc_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "TeacherInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsTeacher(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsTeacher(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_id�μ���
		$result = @pg_exec( $this->conn , " SELECT currval('t_teacher_tc_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->teacherdat[0]["tc_id"] = @pg_result( $result , 0 , currval );
		//  �����Ծ�����
		if($this->teacherdat[0]["tc_img"] != ""){
			$tc_img = split("/",$this->teacherdat[0]["tc_img"]);
			$this->teacherdat[0]["tc_img"] = $tc_img[0].$this->teacherdat[0]["tc_id"].$tc_img[1];
		}
		if($this->teacherdat[0]["tc_img"] != ""){
			$strSQL = "";
			$strSQL .= " UPDATE t_teacher ";
			$strSQL .= "    SET ";
			$strSQL2 ="";
			if($this->teacherdat[0]["tc_img"] != ""){
				$strSQL2 .= "        tc_img = '{$this->teacherdat[0]["tc_img"]}' ";
			}
			$strSQL = $strSQL.$strSQL2;
			$strSQL .= "  WHERE tc_id = {$this->teacherdat[0]["tc_id"]} ";
		//echo "BuildUpdSQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ){
				$this->php_error = "basedb_UpdBuild(6):".pg_errormessage ($this->conn);
				$obj->dbcom_DbRollback ();
				return (-1);
			}
                	if ( pg_cmdtuples( $result ) != 1 ) {
               	        	$this->php_error = "basedb_InsBuild(6):Insert Failed";
	                        $obj->dbcom_DbRollback ();
	                        return (-1);
	                }
			@pg_free_result( $result );
		}
		//  �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsTeacher(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��������
	-----------------------------------------------------*/
	function basedb_UpdTeacher () {
		
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
		$strSQL .= " SELECT * FROM t_teacher ";
		$strSQL .= "  WHERE tc_id = {$this->teacherdat[0]["tc_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
//echo("##0##upd##");
			$this->php_error = "basedb_UpdTeacher(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->teacherdat[0]["tc_id"] != $arr["tc_id"] ) {
//echo("##1##upd##");
			$this->php_error = "basedb_UpdTeacher(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->teacherdat[0]["tc_clid"] != $arr["tc_clid"] ) {
//echo("##2##upd##");
			$this->php_error = "basedb_UpdTeacher(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->teacherdat[0]["tc_upddate"] != $arr["tc_upddate"] ) {
//echo("##3##upd##");
			$this->php_error = "basedb_UpdTeacher(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE t_teacher ";
		$strSQL .= "    SET ";
		if($this->teacherdat[0]["tc_cpid"] != ""){
			$strSQL .= "        tc_cpid = {$this->teacherdat[0]["tc_cpid"]} , ";
		}else{
			$strSQL .= "        tc_cpid = NULL , ";
		}
		if($this->teacherdat[0]["tc_stat"] != ""){
			$strSQL .= "        tc_stat = {$this->teacherdat[0]["tc_stat"]} , ";
		}else{
			$strSQL .= "        tc_stat = NULL , ";
		}
		$strSQL .= "        tc_name = '{$this->teacherdat[0]["tc_name"]}' , ";
		if($this->teacherdat[0]["tc_img_del_chk"] == 1){
			$strSQL .= "        tc_img = NULL , ";
		}else if($this->teacherdat[0]["tc_img"] != ""){
			$strSQL .= "        tc_img = '{$this->teacherdat[0]["tc_img"]}' , ";
		}
		if($this->teacherdat[0]["tc_img_del_chk"] == 1){
			$strSQL .= "        tc_imgorg = NULL , ";
		}else if($this->teacherdat[0]["tc_imgorg"] != ""){
			$strSQL .= "        tc_imgorg = '{$this->teacherdat[0]["tc_imgorg"]}' , ";
		}
		$strSQL .= "        tc_contents = '{$this->teacherdat[0]["tc_contents"]}' , ";
		$strSQL .= "        tc_comment = '{$this->teacherdat[0]["tc_comment"]}' , ";
		$strSQL .= "        tc_subject = '{$this->teacherdat[0]["tc_subject"]}' , ";
		if($this->teacherdat[0]["tc_age"] != ""){
			$strSQL .= "        tc_age = {$this->teacherdat[0]["tc_age"]} , ";
		}else{
			$strSQL .= "        tc_age = NULL , ";
		}
		$strSQL .= "        tc_upddate = 'now' ";
		$strSQL .= "  WHERE tc_id = {$this->teacherdat[0]["tc_id"]} ";
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
	    �֥����ܾ��� - �������
	-----------------------------------------------------*/
	function basedb_DelTeacher ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelTeacher(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_teacher ";
		$strSQL .= "  WHERE tc_id = {$this->teacherdat[0]["tc_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelTeacher(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->teacherdat[0]["tc_id"] != $arr["tc_id"] ) {
			$this->php_error = "basedb_DelTeacher(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE t_teacher ";
				$strSQL .= "    SET tc_deldate = 'now' ";
				$strSQL .= "  WHERE tc_id = '{$this->teacherdat[0]["tc_id"]}' ";
			//echo "TeacherDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelTeacher(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM t_teacher ";
				$strSQL .= "  WHERE tc_id = '{$this->teacherdat[0]["tc_id"]}'";
			//echo "TeacherDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelTeacher(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelTeacher(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelTeacher(7):".$this->php_error;
			return (-1);
		}
		return (0);
	}
	/*-----------------------------------------------------
	    ���Υ��ꥢ��ʥ�С� - ����
	-----------------------------------------------------*/
	function basedb_SerialTeacher () {
		
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
		$strSQL = " SELECT last_value FROM t_teacher_tc_id_seq ";
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
				$this->teacherdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}
		$this->teacherdat[0]["last_value"]++;
		return ( $this->teacherdat[0]["last_value"] );
		
	}
}
?>
