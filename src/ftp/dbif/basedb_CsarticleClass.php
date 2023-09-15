<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_CsarticleClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $csarticledat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_CsarticleClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->csarticledat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetCsarticle ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetCsarticle(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["csa_id"] != "" )       $sql_where .= " AND csa_id = {$this->jyoken["csa_id"]} ";
		if( $this->jyoken["csa_csid"] != "" )       $sql_where .= " AND csa_csid = {$this->jyoken["csa_csid"]} ";
		if( $this->jyoken["csa_stat"] != "" )    $sql_where .= " AND csa_stat = {$this->jyoken["csa_stat"]} ";
		if( $this->jyoken["csa_cateid"] != "" )    $sql_where .= " AND csa_cateid = '{$this->jyoken["csa_cateid"]}' ";
		if( $this->jyoken["csa_img"] != "" )    $sql_where .= " AND csa_img = '{$this->jyoken["csa_img"]}' ";
		if( $this->jyoken["csa_imgorg"] != "" )    $sql_where .= " AND csa_imgorg = '{$this->jyoken["csa_imgorg"]}' ";
		if( $this->jyoken["csa_title"] != "" )    $sql_where .= " AND csa_title = '{$this->jyoken["csa_title"]}' ";
		if( $this->jyoken["csa_contents"] != "" )    $sql_where .= " AND csa_contents = '{$this->jyoken["csa_contents"]}' ";
		if( $this->jyoken["csa_dispno"] != "" )    $sql_where .= " AND csa_dispno = '{$this->jyoken["csa_dispno"]}' ";
		if( $this->jyoken["csa_deldate"] != "" ) $sql_where .= " AND csa_deldate is NULL ";


		// �¤ӽ�
		$sql_order = "";
		IF( $this->sort["csa_upddate"] == 2 ){
			$sql_order = " ORDER BY csa_upddate desc ";
		}
		IF( $this->sort["csa_upddate"] == 1 ){
			$sql_order = " ORDER BY csa_upddate ";
		}
		IF( $this->sort["csa_dispno"] == 2 ){
			$sql_order = " ORDER BY csa_stat,csa_dispno desc ";
		}
		IF( $this->sort["csa_dispno"] == 1 ){
			$sql_order = " ORDER BY csa_stat,csa_dispno ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_csarticle ";
		$stmt2 = "";
		$stmt2 .= " WHERE csa_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetCsarticle_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCsarticle(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetCsarticle(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->csarticledat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(csa_id) FROM t_csarticle ";
		$strSQL .= $stmt2;
	//echo "GetCsarticle_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCsarticle(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetCsarticle(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetCsarticle(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_InsCsarticle () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsCsarticle(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_csarticle IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCsarticle(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  ɽ�����ʣ�����å�
		if($this->csarticledat[0]["csa_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_csarticle ";
			$strSQL .= "  WHERE csa_dispno = '{$this->csarticledat[0]["csa_dispno"]}' ";
			$strSQL .= "    AND csa_deldate is null ";
			$strSQL .= "    AND csa_stat <> 9 ";
			$strSQL .= "    AND csa_csid = '{$this->csarticledat[0]["csa_csid"]}' ";
//echo($strSQL);
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
		$strSQL .= " INSERT INTO t_csarticle ";
		$strSQL .= "           ( ";
		$strSQL .= "             csa_csid , ";
		$strSQL .= "             csa_stat , ";
		$strSQL .= "             csa_cateid , ";
		$strSQL .= "             csa_title , ";
		$strSQL .= "             csa_contents , ";
		if($this->csarticledat[0]["csa_imgorg"] != ""){
			$strSQL .= "             csa_imgorg , ";
		}
		if($this->csarticledat[0]["csa_img"] != ""){
			$strSQL .= "             csa_img , ";
		}
		$strSQL .= "             csa_dispno , ";
		$strSQL .= "             csa_adminid , ";
		$strSQL .= "             csa_insdate , ";
		$strSQL .= "             csa_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->csarticledat[0]["csa_csid"] != ""){
			$strSQL .= "        {$this->csarticledat[0]["csa_csid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->csarticledat[0]["csa_stat"] != ""){
			$strSQL .= "        {$this->csarticledat[0]["csa_stat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->csarticledat[0]["csa_cateid"] != ""){
			$strSQL .= "        {$this->csarticledat[0]["csa_cateid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->csarticledat[0]["csa_title"]}' , ";
		$strSQL .= "             '{$this->csarticledat[0]["csa_contents"]}' , ";
		if($this->csarticledat[0]["csa_imgorg"] != ""){
			$strSQL .= "             '{$this->csarticledat[0]["csa_imgorg"]}' , ";
		}
		if($this->csarticledat[0]["csa_img"] != ""){
			$strSQL .= "             '{$this->csarticledat[0]["csa_img"]}' , ";
		}
		if($this->csarticledat[0]["csa_dispno"] != ""){
			$strSQL .= "        {$this->csarticledat[0]["csa_dispno"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->csarticledat[0]["csa_adminid"] != ""){
			$strSQL .= "        {$this->csarticledat[0]["csa_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "CsarticleInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCsarticle(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsCsarticle(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_id�μ���
		$result = @pg_exec( $this->conn , " SELECT currval('t_csarticle_csa_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->csarticledat[0]["csa_id"] = @pg_result( $result , 0 , currval );

		//  �����Ծ�����
		if($this->csarticledat[0]["csa_img"] != ""){
			$csa_img = split("/",$this->csarticledat[0]["csa_img"]);
			$this->csarticledat[0]["csa_img"] = $csa_img[0].$this->csarticledat[0]["csa_id"].$csa_img[1];
		}

		if($this->csarticledat[0]["csa_img"] != ""){
			$strSQL = "";
			$strSQL .= " UPDATE t_csarticle ";
			$strSQL .= "    SET ";
			$strSQL2 ="";
			if($this->csarticledat[0]["csa_img"] != ""){
				$strSQL2 .= "        csa_img = '{$this->csarticledat[0]["csa_img"]}' ";
			}
			$strSQL = $strSQL.$strSQL2;
			$strSQL .= "  WHERE csa_id = {$this->csarticledat[0]["csa_id"]} ";
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
			$this->php_error = "basedb_InsCsarticle(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - ��������
	-----------------------------------------------------*/
	function basedb_UpdCsarticle () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCsarticle(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_csarticle ";
		$strSQL .= "  WHERE csa_id = {$this->csarticledat[0]["csa_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
			$this->php_error = "basedb_UpdCsarticle(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->csarticledat[0]["csa_id"] != $arr["csa_id"] ) {
//echo("##1##upd##");
			$this->php_error = "basedb_UpdCsarticle(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->csarticledat[0]["csa_csid"] != $arr["csa_csid"] ) {
//echo("##2##upd##");
			$this->php_error = "basedb_UpdCsarticle(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->csarticledat[0]["csa_upddate"] != $arr["csa_upddate"] ) {
//echo("##3##upd##");
			$this->php_error = "basedb_UpdCsarticle(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		//  ɽ�����ʣ�����å�
		if($this->csarticledat[0]["csa_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_csarticle ";
			$strSQL .= "  WHERE csa_dispno = '{$this->csarticledat[0]["csa_dispno"]}' ";
			$strSQL .= "    AND csa_deldate is null ";
			$strSQL .= "    AND csa_stat <> 9 ";
			$strSQL .= "    AND csa_csid = '{$this->csarticledat[0]["csa_csid"]}' ";
			$strSQL .= "    AND csa_id <> '{$this->csarticledat[0]["csa_id"]}' ";
	//	echo "LeftmenuUpdSQL ... [".$strSQL."]<BR>";
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
		$strSQL .= " UPDATE t_csarticle ";
		$strSQL .= "    SET ";
		if($this->csarticledat[0]["csa_csid"] != ""){
			$strSQL .= "        csa_csid = {$this->csarticledat[0]["csa_csid"]} , ";
		}else{
			$strSQL .= "        csa_csid = NULL , ";
		}
		if($this->csarticledat[0]["csa_stat"] != ""){
			$strSQL .= "        csa_stat = {$this->csarticledat[0]["csa_stat"]} , ";
		}else{
			$strSQL .= "        csa_stat = NULL , ";
		}
		if($this->csarticledat[0]["csa_cateid"] != ""){
			$strSQL .= "        csa_cateid = {$this->csarticledat[0]["csa_cateid"]} , ";
		}else{
			$strSQL .= "        csa_cateid = NULL , ";
		}
		$strSQL .= "        csa_title = '{$this->csarticledat[0]["csa_title"]}' , ";
		$strSQL .= "        csa_contents = '{$this->csarticledat[0]["csa_contents"]}' , ";
		if($this->csarticledat[0]["csa_img_del_chk"] == 1){
			$strSQL .= "        csa_img = NULL , ";
		}else if($this->csarticledat[0]["csa_img"] != ""){
			$strSQL .= "        csa_img = '{$this->csarticledat[0]["csa_img"]}' , ";
		}
		if($this->csarticledat[0]["csa_img_del_chk"] == 1){
			$strSQL .= "        csa_imgorg = NULL , ";
		}else if($this->csarticledat[0]["csa_imgorg"] != ""){
			$strSQL .= "        csa_imgorg = '{$this->csarticledat[0]["csa_imgorg"]}' , ";
		}
		if($this->csarticledat[0]["csa_dispno"] != ""){
			$strSQL .= "        csa_dispno = {$this->csarticledat[0]["csa_dispno"]} , ";
		}else{
			$strSQL .= "        csa_dispno = NULL , ";
		}
		$strSQL .= "        csa_upddate = 'now' ";
		$strSQL .= "  WHERE csa_id = {$this->csarticledat[0]["csa_id"]} ";
	//echo "CsarticleUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdCsarticle(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdCsarticle(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCsarticle(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - �������
	-----------------------------------------------------*/
	function basedb_DelCsarticle ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelCsarticle(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_csarticle ";
		$strSQL .= "  WHERE csa_id = {$this->csarticledat[0]["csa_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelCsarticle(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->csarticledat[0]["csa_id"] != $arr["csa_id"] ) {
			$this->php_error = "basedb_DelCsarticle(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE t_csarticle ";
				$strSQL .= "    SET csa_deldate = 'now' ";
				$strSQL .= "  WHERE csa_id = '{$this->csarticledat[0]["csa_id"]}' ";
			//echo "CsarticleDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCsarticle(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM t_csarticle ";
				$strSQL .= "  WHERE csa_id = '{$this->csarticledat[0]["csa_id"]}'";
			//echo "CsarticleDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCsarticle(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelCsarticle(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelCsarticle(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


	/*-----------------------------------------------------
	    ���Υ��ꥢ��ʥ�С� - ����
	-----------------------------------------------------*/
	function basedb_SerialCsarticle () {
		
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
		$strSQL = " SELECT last_value FROM t_csarticle_csa_id_seq ";

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
				$this->csarticledat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}

		$this->csarticledat[0]["last_value"]++;

		return ( $this->csarticledat[0]["last_value"] );
		
	}

}
?>
