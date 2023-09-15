<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_MenuClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $menudat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_MenuClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->menudat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetMenu ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetMenu(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["mn_id"] != "" )       $sql_where .= " AND mn_id = {$this->jyoken["mn_id"]} ";
		if( $this->jyoken["mn_clid"] != "" )       $sql_where .= " AND mn_clid = {$this->jyoken["mn_clid"]} ";
		if( $this->jyoken["mn_lstat"] != "" )    $sql_where .= " AND mn_lstat = {$this->jyoken["mn_lstat"]} ";
		if( $this->jyoken["mn_flg"] != "" )    $sql_where .= " AND mn_flg = {$this->jyoken["mn_flg"]} ";
		if( $this->jyoken["mn_lname"] != "" )    $sql_where .= " AND mn_lname = '{$this->jyoken["mn_lname"]}' ";
		if( $this->jyoken["mn_ldispno"] != "" )    $sql_where .= " AND mn_ldispno = '{$this->jyoken["mn_ldispno"]}' ";
		if( $this->jyoken["mn_hstat"] != "" )    $sql_where .= " AND mn_hstat = '{$this->jyoken["mn_hstat"]}' ";
		if( $this->jyoken["mn_hdispno"] != "" )    $sql_where .= " AND mn_hdispno = '{$this->jyoken["mn_hdispno"]}' ";

		if( $this->jyoken["mn_hname"] != "" )    $sql_where .= " AND mn_hname = '{$this->jyoken["mn_hname"]}' ";
		if( $this->jyoken["mn_hurl"] != "" )    $sql_where .= " AND mn_hurl = '{$this->jyoken["mn_hurl"]}' ";
		if( $this->jyoken["mn_adminid"] != "" )    $sql_where .= " AND mn_adminid = '{$this->jyoken["mn_adminid"]}' ";

		if( $this->jyoken["mn_deldate"] != "" ) $sql_where .= " AND mn_deldate is NULL ";

		IF( count( $this->jyoken["mn_hstat_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["mn_hstat_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " mn_hstat = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		
		// �¤ӽ�
		$sql_order = "";
		IF( $this->sort["mn_upddate"] == 2 ){
			$sql_order = " ORDER BY mn_upddate desc ";
		}
		IF( $this->sort["mn_upddate"] == 1 ){
			$sql_order = " ORDER BY mn_upddate ";
		}
		IF( $this->sort["mn_ldispno"] == 2 ){
			$sql_order = " ORDER BY mn_lstat,mn_ldispno desc ";
		}
		IF( $this->sort["mn_ldispno"] == 1 ){
			$sql_order = " ORDER BY mn_lstat,mn_ldispno ";
		}
		IF( $this->sort["mn_hdispno"] == 2 ){
			$sql_order = " ORDER BY mn_lstat,mn_hdispno desc ";
		}
		IF( $this->sort["mn_hdispno"] == 1 ){
			$sql_order = " ORDER BY mn_lstat,mn_hdispno ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_menu ";
		$stmt2 = "";
		$stmt2 .= " WHERE mn_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetMenu_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetMenu(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetMenu(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->menudat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(mn_id) FROM t_menu ";
		$strSQL .= $stmt2;
	//echo "GetMenu_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetMenu(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetMenu(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetMenu(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_InsMenu () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsMenu(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_menu IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsMenu(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO t_menu ";
		$strSQL .= "           ( ";
		$strSQL .= "             mn_clid , ";
		$strSQL .= "             mn_lstat , ";
		$strSQL .= "             mn_lname , ";
		$strSQL .= "             mn_ldispno , ";
		$strSQL .= "             mn_hstat , ";
		$strSQL .= "             mn_flg , ";
		$strSQL .= "             mn_hdispno , ";
		$strSQL .= "             mn_hname , ";
		$strSQL .= "             mn_hurl , ";
		$strSQL .= "             mn_adminid , ";
		$strSQL .= "             mn_insdate , ";
		$strSQL .= "             mn_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->menudat[0]["mn_clid"] != ""){
			$strSQL .= "        {$this->menudat[0]["mn_clid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->menudat[0]["mn_lstat"] != ""){
			$strSQL .= "        {$this->menudat[0]["mn_lstat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->menudat[0]["mn_lname"]}' , ";
		if($this->menudat[0]["mn_ldispno"] != ""){
			$strSQL .= "        {$this->menudat[0]["mn_ldispno"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->menudat[0]["mn_hstat"] != ""){
			$strSQL .= "        {$this->menudat[0]["mn_hstat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->menudat[0]["mn_flg"] != ""){
			$strSQL .= "        {$this->menudat[0]["mn_flg"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->menudat[0]["mn_hdispno"] != ""){
			$strSQL .= "        {$this->menudat[0]["mn_hdispno"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->menudat[0]["mn_hname"]}' , ";
		$strSQL .= "             '{$this->menudat[0]["mn_hurl"]}' , ";
		if($this->menudat[0]["mn_adminid"] != ""){
			$strSQL .= "        {$this->menudat[0]["mn_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "MenuInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );

		if ( !$result ) {
			$this->php_error = "basedb_InsMenu(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsMenu(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_id�μ���
		$result = @pg_exec( $this->conn , " SELECT currval('t_menu_mn_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->menudat[0]["mn_id"] = @pg_result( $result , 0 , currval );

		@pg_free_result( $result );

		//  �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsMenu(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - ��������
	-----------------------------------------------------*/
	function basedb_UpdMenu () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdMenu(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_menu ";
		$strSQL .= "  WHERE mn_id = {$this->menudat[0]["mn_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
			$this->php_error = "basedb_UpdMenu(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->menudat[0]["mn_id"] != $arr["mn_id"] ) {
//echo("##1##upd##");
			$this->php_error = "basedb_UpdMenu(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->menudat[0]["mn_clid"] != $arr["mn_clid"] ) {
//echo("##2##upd##");
			$this->php_error = "basedb_UpdMenu(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->menudat[0]["mn_upddate"] != $arr["mn_upddate"] ) {
//echo("##3##upd##");
			$this->php_error = "basedb_UpdMenu(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE t_menu ";
		$strSQL .= "    SET ";
		if($this->menudat[0]["mn_clid"] != ""){
			$strSQL .= "        mn_clid = {$this->menudat[0]["mn_clid"]} , ";
		}else{
			$strSQL .= "        mn_clid = NULL , ";
		}
		if($this->menudat[0]["mn_lstat"] != ""){
			$strSQL .= "        mn_lstat = {$this->menudat[0]["mn_lstat"]} , ";
		}else{
			$strSQL .= "        mn_lstat = NULL , ";
		}
		$strSQL .= "        mn_lname = '{$this->menudat[0]["mn_lname"]}' , ";
		if($this->menudat[0]["mn_ldispno"] != ""){
			$strSQL .= "        mn_ldispno = {$this->menudat[0]["mn_ldispno"]} , ";
		}else{
			$strSQL .= "        mn_ldispno = NULL , ";
		}
		if($this->menudat[0]["mn_hstat"] != ""){
			$strSQL .= "        mn_hstat = {$this->menudat[0]["mn_hstat"]} , ";
		}else{
			$strSQL .= "        mn_hstat = NULL , ";
		}
		if($this->menudat[0]["mn_flg"] != ""){
			$strSQL .= "        mn_flg = {$this->menudat[0]["mn_flg"]} , ";
		}else{
			$strSQL .= "        mn_flg = NULL , ";
		}
		if($this->menudat[0]["mn_hdispno"] != ""){
			$strSQL .= "        mn_hdispno = {$this->menudat[0]["mn_hdispno"]} , ";
		}else{
			$strSQL .= "        mn_hdispno = NULL , ";
		}
		$strSQL .= "        mn_hname = '{$this->menudat[0]["mn_hname"]}' , ";
		$strSQL .= "        mn_hurl = '{$this->menudat[0]["mn_hurl"]}' , ";
		if($this->menudat[0]["mn_adminid"] != ""){
			$strSQL .= "        mn_adminid = {$this->menudat[0]["mn_adminid"]} , ";
		}else{
			$strSQL .= "        mn_adminid = NULL , ";
		}
		$strSQL .= "        mn_upddate = 'now' ";
		$strSQL .= "  WHERE mn_id = {$this->menudat[0]["mn_id"]} ";
	//echo "MenuUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdMenu(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdMenu(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdMenu(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - �������
	-----------------------------------------------------*/
	function basedb_DelMenu ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelMenu(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_menu ";
		$strSQL .= "  WHERE mn_id = {$this->menudat[0]["mn_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelMenu(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->menudat[0]["mn_id"] != $arr["mn_id"] ) {
			$this->php_error = "basedb_DelMenu(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE t_menu ";
				$strSQL .= "    SET mn_deldate = 'now' ";
				$strSQL .= "  WHERE mn_id = '{$this->menudat[0]["mn_id"]}' ";
			//echo "MenuDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelMenu(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM t_menu ";
				$strSQL .= "  WHERE mn_id = '{$this->menudat[0]["mn_id"]}'";
			//echo "MenuDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelMenu(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelMenu(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelMenu(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


	/*-----------------------------------------------------
	    ���Υ��ꥢ��ʥ�С� - ����
	-----------------------------------------------------*/
	function basedb_SerialMenu () {
		
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
		$strSQL = " SELECT last_value FROM t_menu_mn_id_seq ";

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
				$this->menudat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}

		$this->menudat[0]["last_value"]++;

		return ( $this->menudat[0]["last_value"] );
		
	}

}
?>
