<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_ArticleClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $articledat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_ArticleClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->articledat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetArticle ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetArticle(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["ac_id"] != "" )       $sql_where .= " AND ac_id = {$this->jyoken["ac_id"]} ";
		if( $this->jyoken["ac_clid"] != "" )       $sql_where .= " AND ac_clid = {$this->jyoken["ac_clid"]} ";
		if( $this->jyoken["ac_stat"] != "" )    $sql_where .= " AND ac_stat = {$this->jyoken["ac_stat"]} ";
		if( $this->jyoken["ac_cateid"] != "" )    $sql_where .= " AND ac_cateid = '{$this->jyoken["ac_cateid"]}' ";
		if( $this->jyoken["ac_img"] != "" )    $sql_where .= " AND ac_cateid = '{$this->jyoken["ac_img"]}' ";
		if( $this->jyoken["ac_imgorg"] != "" )    $sql_where .= " AND ac_cateid = '{$this->jyoken["ac_imgorg"]}' ";
		if( $this->jyoken["ac_title"] != "" )    $sql_where .= " AND ac_title = '{$this->jyoken["ac_title"]}' ";
		if( $this->jyoken["ac_contents"] != "" )    $sql_where .= " AND ac_contents = '{$this->jyoken["ac_contents"]}' ";
		if( $this->jyoken["ac_img"] != "" )    $sql_where .= " AND ac_img = '{$this->jyoken["ac_img"]}' ";
		if( $this->jyoken["ac_imgorg"] != "" )    $sql_where .= " AND ac_img = '{$this->jyoken["ac_imgorg"]}' ";
		if( $this->jyoken["ac_dispno"] != "" )    $sql_where .= " AND ac_img = '{$this->jyoken["ac_dispno"]}' ";
		if( $this->jyoken["ac_deldate"] != "" ) $sql_where .= " AND ac_deldate is NULL ";

		
		// �¤ӽ�
		$sql_order = "";
		IF( $this->sort["ac_upddate"] == 2 ){
			$sql_order = " ORDER BY ac_upddate desc ";
		}
		IF( $this->sort["ac_upddate"] == 1 ){
			$sql_order = " ORDER BY ac_upddate ";
		}
		IF( $this->sort["ac_dispno"] == 2 ){
			$sql_order = " ORDER BY ac_stat,ac_dispno desc ";
		}
		IF( $this->sort["ac_dispno"] == 1 ){
			$sql_order = " ORDER BY ac_stat,ac_dispno ";
		}
		IF( $this->sort["ac_catedisp"] == 2 ){
			$sql_order = " ORDER BY ac_stat,ac_cateid,ac_dispno desc ";
		}
		IF( $this->sort["ac_catedisp"] == 1 ){
			$sql_order = " ORDER BY ac_stat,ac_cateid,ac_dispno ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_article ";
		$stmt2 = "";
		$stmt2 .= " WHERE ac_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetArticle_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetArticle(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetArticle(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->articledat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(ac_id) FROM t_article ";
		$strSQL .= $stmt2;
	//echo "GetArticle_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetArticle(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetArticle(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetArticle(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_InsArticle () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsArticle(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_article IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsArticle(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  ɽ�����ʣ�����å�
		if($this->articledat[0]["ac_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_article ";
			$strSQL .= "  WHERE ac_dispno = '{$this->articledat[0]["ac_dispno"]}' ";
			$strSQL .= "    AND ac_deldate is null ";
			$strSQL .= "    AND ac_stat <> 9 ";
			$strSQL .= "    AND ac_cateid = '{$this->articledat[0]["ac_cateid"]}' ";
			$strSQL .= "    AND ac_clid = '{$this->articledat[0]["ac_clid"]}' ";
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
		$strSQL .= " INSERT INTO t_article ";
		$strSQL .= "           ( ";
		$strSQL .= "             ac_clid , ";
		$strSQL .= "             ac_stat , ";
		$strSQL .= "             ac_cateid , ";
		$strSQL .= "             ac_title , ";
		$strSQL .= "             ac_contents , ";
		if($this->articledat[0]["ac_imgorg"] != ""){
			$strSQL .= "             ac_imgorg , ";
		}
		if($this->articledat[0]["ac_img"] != ""){
			$strSQL .= "             ac_img , ";
		}
		$strSQL .= "             ac_dispno , ";
		$strSQL .= "             ac_adminid , ";
		$strSQL .= "             ac_insdate , ";
		$strSQL .= "             ac_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->articledat[0]["ac_clid"] != ""){
			$strSQL .= "        {$this->articledat[0]["ac_clid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->articledat[0]["ac_stat"] != ""){
			$strSQL .= "        {$this->articledat[0]["ac_stat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->articledat[0]["ac_cateid"] != ""){
			$strSQL .= "        {$this->articledat[0]["ac_cateid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->articledat[0]["ac_title"]}' , ";
		$strSQL .= "             '{$this->articledat[0]["ac_contents"]}' , ";
		if($this->articledat[0]["ac_imgorg"] != ""){
			$strSQL .= "             '{$this->articledat[0]["ac_imgorg"]}' , ";
		}
		if($this->articledat[0]["ac_img"] != ""){
			$strSQL .= "             '{$this->articledat[0]["ac_img"]}' , ";
		}
		if($this->articledat[0]["ac_dispno"] != ""){
			$strSQL .= "        {$this->articledat[0]["ac_dispno"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->articledat[0]["ac_adminid"] != ""){
			$strSQL .= "        {$this->articledat[0]["ac_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "ArticleInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsArticle(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsArticle(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_id�μ���
		$result = @pg_exec( $this->conn , " SELECT currval('t_article_ac_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->articledat[0]["ac_id"] = @pg_result( $result , 0 , currval );

		//  �����Ծ�����
		if($this->articledat[0]["ac_img"] != ""){
			$ac_img = split("/",$this->articledat[0]["ac_img"]);
			$this->articledat[0]["ac_img"] = $ac_img[0].$this->articledat[0]["ac_id"].$ac_img[1];
		}

		if($this->articledat[0]["ac_img"] != ""){
			$strSQL = "";
			$strSQL .= " UPDATE t_article ";
			$strSQL .= "    SET ";
			$strSQL2 ="";
			if($this->articledat[0]["ac_img"] != ""){
				$strSQL2 .= "        ac_img = '{$this->articledat[0]["ac_img"]}' ";
			}
			$strSQL = $strSQL.$strSQL2;
			$strSQL .= "  WHERE ac_id = {$this->articledat[0]["ac_id"]} ";
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
			$this->php_error = "basedb_InsArticle(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - ��������
	-----------------------------------------------------*/
	function basedb_UpdArticle () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdArticle(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_article ";
		$strSQL .= "  WHERE ac_id = {$this->articledat[0]["ac_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
			$this->php_error = "basedb_UpdArticle(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->articledat[0]["ac_id"] != $arr["ac_id"] ) {
//echo("##1##upd##");
			$this->php_error = "basedb_UpdArticle(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->articledat[0]["ac_clid"] != $arr["ac_clid"] ) {
//echo("##2##upd##");
			$this->php_error = "basedb_UpdArticle(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->articledat[0]["ac_upddate"] != $arr["ac_upddate"] ) {
//echo("##3##upd##");
			$this->php_error = "basedb_UpdArticle(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		//  ɽ�����ʣ�����å�
		if($this->articledat[0]["ac_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_article ";
			$strSQL .= "  WHERE ac_dispno = '{$this->articledat[0]["ac_dispno"]}' ";
			$strSQL .= "    AND ac_deldate is null ";
			$strSQL .= "    AND ac_stat <> 9 ";
			$strSQL .= "    AND ac_clid = '{$this->articledat[0]["ac_clid"]}' ";
			$strSQL .= "    AND ac_cateid = '{$this->articledat[0]["ac_cateid"]}' ";
			$strSQL .= "    AND ac_id <> '{$this->articledat[0]["ac_id"]}' ";
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
		$strSQL .= " UPDATE t_article ";
		$strSQL .= "    SET ";
		if($this->articledat[0]["ac_clid"] != ""){
			$strSQL .= "        ac_clid = {$this->articledat[0]["ac_clid"]} , ";
		}else{
			$strSQL .= "        ac_clid = NULL , ";
		}
		if($this->articledat[0]["ac_stat"] != ""){
			$strSQL .= "        ac_stat = {$this->articledat[0]["ac_stat"]} , ";
		}else{
			$strSQL .= "        ac_stat = NULL , ";
		}
		if($this->articledat[0]["ac_cateid"] != ""){
			$strSQL .= "        ac_cateid = {$this->articledat[0]["ac_cateid"]} , ";
		}else{
			$strSQL .= "        ac_cateid = NULL , ";
		}
		$strSQL .= "        ac_title = '{$this->articledat[0]["ac_title"]}' , ";
		$strSQL .= "        ac_contents = '{$this->articledat[0]["ac_contents"]}' , ";
		if($this->articledat[0]["ac_img_del_chk"] == 1){
			$strSQL .= "        ac_img = NULL , ";
		}else if($this->articledat[0]["ac_img"] != ""){
			$strSQL .= "        ac_img = '{$this->articledat[0]["ac_img"]}' , ";
		}
		if($this->articledat[0]["ac_img_del_chk"] == 1){
			$strSQL .= "        ac_imgorg = NULL , ";
		}else if($this->articledat[0]["ac_imgorg"] != ""){
			$strSQL .= "        ac_imgorg = '{$this->articledat[0]["ac_imgorg"]}' , ";
		}
		if($this->articledat[0]["ac_dispno"] != ""){
			$strSQL .= "        ac_dispno = {$this->articledat[0]["ac_dispno"]} , ";
		}else{
			$strSQL .= "        ac_dispno = NULL , ";
		}
		$strSQL .= "        ac_upddate = 'now' ";
		$strSQL .= "  WHERE ac_id = {$this->articledat[0]["ac_id"]} ";
	//echo "ArticleUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdArticle(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdArticle(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdArticle(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - �������
	-----------------------------------------------------*/
	function basedb_DelArticle ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelArticle(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_article ";
		$strSQL .= "  WHERE ac_id = {$this->articledat[0]["ac_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelArticle(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->articledat[0]["ac_id"] != $arr["ac_id"] ) {
			$this->php_error = "basedb_DelArticle(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE t_article ";
				$strSQL .= "    SET ac_deldate = 'now' ";
				$strSQL .= "  WHERE ac_id = '{$this->articledat[0]["ac_id"]}' ";
			//echo "ArticleDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelArticle(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM t_article ";
				$strSQL .= "  WHERE ac_id = '{$this->articledat[0]["ac_id"]}'";
			//echo "ArticleDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelArticle(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelArticle(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelArticle(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


	/*-----------------------------------------------------
	    ���Υ��ꥢ��ʥ�С� - ����
	-----------------------------------------------------*/
	function basedb_SerialArticle () {
		
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
		$strSQL = " SELECT last_value FROM t_article_ac_id_seq ";

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
				$this->articledat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}

		$this->articledat[0]["last_value"]++;

		return ( $this->articledat[0]["last_value"] );
		
	}

}
?>
