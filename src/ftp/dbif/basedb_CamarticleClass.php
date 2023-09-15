<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_CamarticleClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $camarticledat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_CamarticleClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->camarticledat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetCamarticle ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetCamarticle(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["ca_id"] != "" )       $sql_where .= " AND ca_id = {$this->jyoken["ca_id"]} ";
		if( $this->jyoken["ca_cpid"] != "" )       $sql_where .= " AND ca_cpid = {$this->jyoken["ca_cpid"]} ";
		if( $this->jyoken["ca_stat"] != "" )    $sql_where .= " AND ca_stat = {$this->jyoken["ca_stat"]} ";
		if( $this->jyoken["ca_cateid"] != "" )    $sql_where .= " AND ca_cateid = '{$this->jyoken["ca_cateid"]}' ";
		if( $this->jyoken["ca_img"] != "" )    $sql_where .= " AND ca_img = '{$this->jyoken["ca_img"]}' ";
		if( $this->jyoken["ca_imgorg"] != "" )    $sql_where .= " AND ca_imgorg = '{$this->jyoken["ca_imgorg"]}' ";
		if( $this->jyoken["ca_title"] != "" )    $sql_where .= " AND ca_title = '{$this->jyoken["ca_title"]}' ";
		if( $this->jyoken["ca_contents"] != "" )    $sql_where .= " AND ca_contents = '{$this->jyoken["ca_contents"]}' ";
		if( $this->jyoken["ca_dispno"] != "" )    $sql_where .= " AND ca_dispno = '{$this->jyoken["ca_dispno"]}' ";
		if( $this->jyoken["ca_deldate"] != "" ) $sql_where .= " AND ca_deldate is NULL ";


		// �¤ӽ�
		$sql_order = "";
		IF( $this->sort["ca_upddate"] == 2 ){
			$sql_order = " ORDER BY ca_upddate desc ";
		}
		IF( $this->sort["ca_upddate"] == 1 ){
			$sql_order = " ORDER BY ca_upddate ";
		}
		IF( $this->sort["ca_dispno"] == 2 ){
			$sql_order = " ORDER BY ca_stat,ca_dispno desc ";
		}
		IF( $this->sort["ca_dispno"] == 1 ){
			$sql_order = " ORDER BY ca_stat,ca_dispno ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_camarticle ";
		$stmt2 = "";
		$stmt2 .= " WHERE ca_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetCamarticle_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCamarticle(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetCamarticle(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->camarticledat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(ca_id) FROM t_camarticle ";
		$strSQL .= $stmt2;
	//echo "GetCamarticle_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCamarticle(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetCamarticle(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetCamarticle(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_InsCamarticle () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsCamarticle(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_camarticle IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCamarticle(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  ɽ�����ʣ�����å�
		if($this->camarticledat[0]["ca_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_camarticle ";
			$strSQL .= "  WHERE ca_dispno = '{$this->camarticledat[0]["ca_dispno"]}' ";
			$strSQL .= "    AND ca_deldate is null ";
			$strSQL .= "    AND ca_stat <> 9 ";
			$strSQL .= "    AND ca_cpid = '{$this->camarticledat[0]["ca_cpid"]}' ";
			$result = @pg_exec( $this->conn , $strSQL );
//echo($strSQL);
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

		
		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO t_camarticle ";
		$strSQL .= "           ( ";
		$strSQL .= "             ca_cpid , ";
		$strSQL .= "             ca_stat , ";
		$strSQL .= "             ca_cateid , ";
		$strSQL .= "             ca_title , ";
		$strSQL .= "             ca_contents , ";
		if($this->camarticledat[0]["ca_imgorg"] != ""){
			$strSQL .= "             ca_imgorg , ";
		}
		if($this->camarticledat[0]["ca_img"] != ""){
			$strSQL .= "             ca_img , ";
		}
		$strSQL .= "             ca_dispno , ";
		$strSQL .= "             ca_adminid , ";
		$strSQL .= "             ca_insdate , ";
		$strSQL .= "             ca_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->camarticledat[0]["ca_cpid"] != ""){
			$strSQL .= "        {$this->camarticledat[0]["ca_cpid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->camarticledat[0]["ca_stat"] != ""){
			$strSQL .= "        {$this->camarticledat[0]["ca_stat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->camarticledat[0]["ca_cateid"] != ""){
			$strSQL .= "        {$this->camarticledat[0]["ca_cateid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->camarticledat[0]["ca_title"]}' , ";
		$strSQL .= "             '{$this->camarticledat[0]["ca_contents"]}' , ";
		if($this->camarticledat[0]["ca_imgorg"] != ""){
			$strSQL .= "             '{$this->camarticledat[0]["ca_imgorg"]}' , ";
		}
		if($this->camarticledat[0]["ca_img"] != ""){
			$strSQL .= "             '{$this->camarticledat[0]["ca_img"]}' , ";
		}
		if($this->camarticledat[0]["ca_dispno"] != ""){
			$strSQL .= "        {$this->camarticledat[0]["ca_dispno"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->camarticledat[0]["ca_adminid"] != ""){
			$strSQL .= "        {$this->camarticledat[0]["ca_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "CamarticleInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCamarticle(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsCamarticle(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_id�μ���
		$result = @pg_exec( $this->conn , " SELECT currval('t_camarticle_ca_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->camarticledat[0]["ca_id"] = @pg_result( $result , 0 , currval );

		//  �����Ծ�����
		if($this->camarticledat[0]["ca_img"] != ""){
			$ca_img = split("/",$this->camarticledat[0]["ca_img"]);
			$this->camarticledat[0]["ca_img"] = $ca_img[0].$this->camarticledat[0]["ca_id"].$ca_img[1];
		}

		if($this->camarticledat[0]["ca_img"] != ""){
			$strSQL = "";
			$strSQL .= " UPDATE t_camarticle ";
			$strSQL .= "    SET ";
			$strSQL2 ="";
			if($this->camarticledat[0]["ca_img"] != ""){
				$strSQL2 .= "        ca_img = '{$this->camarticledat[0]["ca_img"]}' ";
			}
			$strSQL = $strSQL.$strSQL2;
			$strSQL .= "  WHERE ca_id = {$this->camarticledat[0]["ca_id"]} ";
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
			$this->php_error = "basedb_InsCamarticle(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - ��������
	-----------------------------------------------------*/
	function basedb_UpdCamarticle () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCamarticle(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_camarticle ";
		$strSQL .= "  WHERE ca_id = {$this->camarticledat[0]["ca_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
			$this->php_error = "basedb_UpdCamarticle(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->camarticledat[0]["ca_id"] != $arr["ca_id"] ) {
//echo("##1##upd##");
			$this->php_error = "basedb_UpdCamarticle(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->camarticledat[0]["ca_cpid"] != $arr["ca_cpid"] ) {
//echo("##2##upd##");
			$this->php_error = "basedb_UpdCamarticle(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->camarticledat[0]["ca_upddate"] != $arr["ca_upddate"] ) {
//echo("##3##upd##");
			$this->php_error = "basedb_UpdCamarticle(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  ɽ�����ʣ�����å�
		if($this->camarticledat[0]["ca_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_camarticle ";
			$strSQL .= "  WHERE ca_dispno = '{$this->camarticledat[0]["ca_dispno"]}' ";
			$strSQL .= "    AND ca_deldate is null ";
			$strSQL .= "    AND ca_stat <> 9 ";
			$strSQL .= "    AND ca_cpid = '{$this->camarticledat[0]["ca_cpid"]}' ";
			$strSQL .= "    AND ca_id <> '{$this->camarticledat[0]["ca_id"]}' ";
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
		$strSQL .= " UPDATE t_camarticle ";
		$strSQL .= "    SET ";
		if($this->camarticledat[0]["ca_cpid"] != ""){
			$strSQL .= "        ca_cpid = {$this->camarticledat[0]["ca_cpid"]} , ";
		}else{
			$strSQL .= "        ca_cpid = NULL , ";
		}
		if($this->camarticledat[0]["ca_stat"] != ""){
			$strSQL .= "        ca_stat = {$this->camarticledat[0]["ca_stat"]} , ";
		}else{
			$strSQL .= "        ca_stat = NULL , ";
		}
		if($this->camarticledat[0]["ca_cateid"] != ""){
			$strSQL .= "        ca_cateid = {$this->camarticledat[0]["ca_cateid"]} , ";
		}else{
			$strSQL .= "        ca_cateid = NULL , ";
		}
		$strSQL .= "        ca_title = '{$this->camarticledat[0]["ca_title"]}' , ";
		$strSQL .= "        ca_contents = '{$this->camarticledat[0]["ca_contents"]}' , ";
		if($this->camarticledat[0]["ca_img_del_chk"] == 1){
			$strSQL .= "        ca_img = NULL , ";
		}else if($this->camarticledat[0]["ca_img"] != ""){
			$strSQL .= "        ca_img = '{$this->camarticledat[0]["ca_img"]}' , ";
		}
		if($this->camarticledat[0]["ca_img_del_chk"] == 1){
			$strSQL .= "        ca_imgorg = NULL , ";
		}else if($this->camarticledat[0]["ca_imgorg"] != ""){
			$strSQL .= "        ca_imgorg = '{$this->camarticledat[0]["ca_imgorg"]}' , ";
		}
		if($this->camarticledat[0]["ca_dispno"] != ""){
			$strSQL .= "        ca_dispno = {$this->camarticledat[0]["ca_dispno"]} , ";
		}else{
			$strSQL .= "        ca_dispno = NULL , ";
		}
		$strSQL .= "        ca_upddate = 'now' ";
		$strSQL .= "  WHERE ca_id = {$this->camarticledat[0]["ca_id"]} ";
	//echo "CamarticleUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdCamarticle(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdCamarticle(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCamarticle(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - �������
	-----------------------------------------------------*/
	function basedb_DelCamarticle ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelCamarticle(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_camarticle ";
		$strSQL .= "  WHERE ca_id = {$this->camarticledat[0]["ca_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelCamarticle(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->camarticledat[0]["ca_id"] != $arr["ca_id"] ) {
			$this->php_error = "basedb_DelCamarticle(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE t_camarticle ";
				$strSQL .= "    SET ca_deldate = 'now' ";
				$strSQL .= "  WHERE ca_id = '{$this->camarticledat[0]["ca_id"]}' ";
			//echo "CamarticleDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCamarticle(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM t_camarticle ";
				$strSQL .= "  WHERE ca_id = '{$this->camarticledat[0]["ca_id"]}'";
			//echo "CamarticleDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCamarticle(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelCamarticle(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelCamarticle(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


	/*-----------------------------------------------------
	    ���Υ��ꥢ��ʥ�С� - ����
	-----------------------------------------------------*/
	function basedb_SerialCamarticle () {
		
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
		$strSQL = " SELECT last_value FROM t_camarticle_ca_id_seq ";

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
				$this->camarticledat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}

		$this->camarticledat[0]["last_value"]++;

		return ( $this->camarticledat[0]["last_value"] );
		
	}

}
?>
