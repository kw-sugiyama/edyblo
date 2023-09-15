<?
/*****************************************************************************
	���饤�����DB���饹
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_CltpcontentsClassTblAccess extends dbcom_DBcontroll {
	
	/*  ���С��ѿ����  */
	var $conn;		// �ģ���³�ɣ�
	var $php_error;		// �������顼���Υ�å�����
	var $jyoken;		// ���������Ǽ��������
	var $sort;		// ����ɽ��������
	var $cltpcontentsdat;		// ������̤��Ǽ���룲����Ϣ������
	
	/*  ���󥹥ȥ饯���ʥ��С��ѿ��ν������  */
	function basedb_CltpcontentsClassTblAccess () {
		$this->conn = NULL;		// �ģ���³�ɣ�
		$this->php_error = NULL;	// �������顼��å�����
		$this->jyoken = Array();	// �������
		$this->sort = NULL;		// ����ɽ��������
		$this->cltpcontentsdat = Array();	// ������Ϣ������
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ����
	-----------------------------------------------------*/
	function basedb_GetCltpcontents ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetCltpcontents(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//�ӣѣ̾�����
		$sql_where = "";
		if( $this->jyoken["cltpcate_id"] != "" )       $sql_where .= " AND cltpcate_id = '{$this->jyoken["cltpcate_id"]}' ";
		if( $this->jyoken["cltpcate_stat"] != "" )       $sql_where .= " AND cltpcate_stat = '{$this->jyoken["cltpcate_stat"]}' ";
		if( $this->jyoken["cltpcontents_id"] != "" )       $sql_where .= " AND cltpcontents_id = '{$this->jyoken["cltpcontents_id"]}' ";
		if( $this->jyoken["cltpcontents_cate_id"] != "" )     $sql_where .= " AND cltpcontents_cate_id = '{$this->jyoken["cltpcontents_cate_id"]}' ";
		if( $this->jyoken["cltpcontents_stat"] != "" )     $sql_where .= " AND cltpcontents_stat = '{$this->jyoken["cltpcontents_stat"]}' ";
		if( $this->jyoken["cltpcontents_date"] != "" )     $sql_where .= " AND cltpcontents_date = '{$this->jyoken["cltpcontents_date"]}' ";
		if( $this->jyoken["cltpcontents_del_date"] != "" )     $sql_where .= " AND cltpcontents_del_date is null ";
		if( $this->jyoken["cltpcontents_date_s"] != "--" AND $this->jyoken["cltpcontents_date_s"] != "")   $sql_where .= " AND cltpcontents_date >= '{$this->jyoken["cltpcontents_date_s"]}' ";
		if( $this->jyoken["cltpcontents_date_e"] != "--" AND $this->jyoken["cltpcontents_date_e"] != "")   $sql_where .= " AND cltpcontents_date <= '{$this->jyoken["cltpcontents_date_e"]}' ";

		// �ӣѣ̥����Ⱦ�����
		if ( $this->sort['cl_ins_date'] == 1 ){
			$sql_order .= " ORDER BY cl_ins_date desc ";
		}else if ( $this->sort['cl_ins_date'] == 2 ){
			$sql_order .= " ORDER BY cl_ins_date ";
		}
		if ( $this->sort['cltpcontents_upd_date'] == 1 ){
			$sql_order .= " ORDER BY cltpcontents_upd_date desc ";
		}else if ( $this->sort['cltpcontents_upd_date'] == 2 ){
			$sql_order .= " ORDER BY cltpcontents_upd_date ";
		}
		if ( $this->sort['cltpcontents_date'] == 1 ){
			$sql_order .= " ORDER BY cltpcontents_date desc ";
		}else if ( $this->sort['cltpcontents_date'] == 2 ){
			$sql_order .= " ORDER BY cltpcontents_date ";
		}
		
		$strSQL = "";
		$strSQL = " SELECT * FROM base_v_cltpcontents ";
		$stmt2 = "";
		$stmt2 .= " WHERE cltpcontents_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT��OFFSET����
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//���ӣѣ̼¹�
	//echo "GetCltpcontents_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCltpcontents(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetCltpcontents(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->cltpcontentsdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//�����������
		$strSQL = "";
		$strSQL .= " SELECT count(cltpcontents_id) FROM base_v_cltpcontents ";
		$strSQL .= $stmt2;
	//echo "GetCltpcontents_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCltpcontents(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetCltpcontents(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetCltpcontents(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    �֥����ܾ��� - ��Ͽ
	-----------------------------------------------------*/
	function basedb_InsCltpcontents () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsCltpcontents(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " LOCK TABLE base_t_cltpcontents IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCltpcontents(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  ���饤����Ⱦ�����Ͽ
		$strSQL = "";
		$strSQL .= " INSERT INTO base_t_cltpcontents ";
		$strSQL .= "           ( ";
		$strSQL .= "             cltpcontents_cate_id , ";
		$strSQL .= "             cltpcontents_stat , ";
		$strSQL .= "             cltpcontents_date , ";
		$strSQL .= "             cltpcontents_title , ";
		$strSQL .= "             cltpcontents_contents , ";
		$strSQL .= "             cltpcontents_biko_1 , ";
		$strSQL .= "             cltpcontents_biko_2 , ";
		$strSQL .= "             cltpcontents_biko_3 , ";
		$strSQL .= "             cltpcontents_biko_4 , ";
		$strSQL .= "             cltpcontents_biko_5 , ";
		if($this->cltpcontentsdat[0]["cltpcontents_img_org_1"] != ""){
			$strSQL .= "             cltpcontents_img_org_1 , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_org_2"] != ""){
			$strSQL .= "             cltpcontents_img_org_2 , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_org_3"] != ""){
			$strSQL .= "             cltpcontents_img_org_3 , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_org_4"] != ""){
			$strSQL .= "             cltpcontents_img_org_4 , ";
		}
		$strSQL .= "             cltpcontents_ins_date , ";
		$strSQL .= "             cltpcontents_upd_date";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_cate_id"]}' , ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_stat"]}' , ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_date"]}' , ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_title"]}' , ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_contents"]}' , ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_biko_1"]}' , ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_biko_2"]}' , ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_biko_3"]}' , ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_biko_4"]}' , ";
		$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_biko_5"]}' , ";
		if($this->cltpcontentsdat[0]["cltpcontents_img_org_1"] != ""){
			$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_img_org_1"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_org_2"] != ""){
			$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_img_org_2"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_org_3"] != ""){
			$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_img_org_3"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_org_4"] != ""){
			$strSQL .= "             '{$this->cltpcontentsdat[0]["cltpcontents_img_org_4"]}' , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "CltpcontentsInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCltpcontents(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsCltpcontents(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );

		// cl_id�μ���
		$result = @pg_exec( $this->conn , " SELECT currval('base_t_cltpcontents_cltpcontents_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsCltpcontents(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->cltpcontentsdat[0]["cltpcontents_id"] = @pg_result( $result , 0 , currval );

		//  �����Ծ�����
		if($this->cltpcontentsdat[0]["cltpcontents_img_1"] != ""){
			$cltpcontents_img_1 = split("/",$this->cltpcontentsdat[0]["cltpcontents_img_1"]);
			$this->cltpcontentsdat[0]["cltpcontents_img_1"] = $cltpcontents_img_1[0].$this->cltpcontentsdat[0]["cltpcontents_id"].$cltpcontents_img_1[1];
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_2"] != ""){
			$cltpcontents_img_2 = split("/",$this->cltpcontentsdat[0]["cltpcontents_img_2"]);
			$this->cltpcontentsdat[0]["cltpcontents_img_2"] = $cltpcontents_img_2[0].$this->cltpcontentsdat[0]["cltpcontents_id"].$cltpcontents_img_2[1];
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_3"] != ""){
			$cltpcontents_img_3 = split("/",$this->cltpcontentsdat[0]["cltpcontents_img_3"]);
			$this->cltpcontentsdat[0]["cltpcontents_img_3"] = $cltpcontents_img_3[0].$this->cltpcontentsdat[0]["cltpcontents_id"].$cltpcontents_img_3[1];
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_4"] != ""){
			$cltpcontents_img_4 = split("/",$this->cltpcontentsdat[0]["cltpcontents_img_4"]);
			$this->cltpcontentsdat[0]["cltpcontents_img_4"] = $cltpcontents_img_4[0].$this->cltpcontentsdat[0]["cltpcontents_id"].$cltpcontents_img_4[1];
		}		

		if($this->cltpcontentsdat[0]["cltpcontents_img_1"] != "" || $this->cltpcontentsdat[0]["cltpcontents_img_2"] != "" || $this->cltpcontentsdat[0]["cltpcontents_img_3"] != "" || $this->cltpcontentsdat[0]["cltpcontents_img_4"] != ""){
			$strSQL = "";
			$strSQL .= " UPDATE base_t_cltpcontents ";
			$strSQL .= "    SET ";
			$strSQL2 ="";
			if($this->cltpcontentsdat[0]["cltpcontents_img_1"] != ""){
				$strSQL2 .= "        cltpcontents_img_1 = '{$this->cltpcontentsdat[0]["cltpcontents_img_1"]}' ";
			}
			if($this->cltpcontentsdat[0]["cltpcontents_img_2"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cltpcontents_img_2 = '{$this->cltpcontentsdat[0]["cltpcontents_img_2"]}' ";
			}
			if($this->cltpcontentsdat[0]["cltpcontents_img_3"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cltpcontents_img_3 = '{$this->cltpcontentsdat[0]["cltpcontents_img_3"]}' ";
			}
			if($this->cltpcontentsdat[0]["cltpcontents_img_4"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cltpcontents_img_4 = '{$this->cltpcontentsdat[0]["cltpcontents_img_4"]}' ";
			}
			$strSQL = $strSQL.$strSQL2;
			$strSQL .= "  WHERE cltpcontents_id = {$this->cltpcontentsdat[0]["cltpcontents_id"]} ";
		//echo "BuildUpdSQL ... [".$strSQL."]<BR>";
			$result = @pg_exec( $this->conn , $strSQL );
			if ( !$result ){
				$this->php_error = "basedb_InsCltpcontents(8):".pg_errormessage ($this->conn);
				$obj->dbcom_DbRollback ();
				return (-1);
			}
			if ( pg_cmdtuples( $result ) != 1 ) {
				$this->php_error = "basedb_InsCltpcontents(9):Insert Failed";
				$obj->dbcom_DbRollback ();
				return (-1);
			}
			@pg_free_result( $result );
		}

		//  �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsCltpcontents(10):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - ��������
	-----------------------------------------------------*/
	function basedb_UpdCltpcontents () {
		
		//  �ȥ�󥶥�����󳫻�
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCltpcontents(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_cltpcontents ";
		$strSQL .= "  WHERE cltpcontents_id = {$this->cltpcontentsdat[0]["cltpcontents_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_UpdCltpcontents(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ������裳�Ԥ���˹����������Υ����å�
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->cltpcontentsdat[0]["cltpcontents_id"] != $arr["cltpcontents_id"] ) {
			$this->php_error = "basedb_UpdCltpcontents(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->cltpcontentsdat[0]["cltpcontents_upd_date"] != $arr["cltpcontents_upd_date"] ) {
			$this->php_error = "basedb_UpdCltpcontents(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  �����Ծ�����
		$strSQL = "";
		$strSQL .= " UPDATE base_t_cltpcontents ";
		$strSQL .= "    SET ";
		$strSQL .= "        cltpcontents_cate_id = '{$this->cltpcontentsdat[0]["cltpcontents_cate_id"]}' , ";
		$strSQL .= "        cltpcontents_stat = '{$this->cltpcontentsdat[0]["cltpcontents_stat"]}' , ";
		$strSQL .= "        cltpcontents_date = '{$this->cltpcontentsdat[0]["cltpcontents_date"]}' , ";
		$strSQL .= "        cltpcontents_title = '{$this->cltpcontentsdat[0]["cltpcontents_title"]}' , ";
		$strSQL .= "        cltpcontents_contents = '{$this->cltpcontentsdat[0]["cltpcontents_contents"]}' , ";
		$strSQL .= "        cltpcontents_biko_1 = '{$this->cltpcontentsdat[0]["cltpcontents_biko_1"]}' , ";
		$strSQL .= "        cltpcontents_biko_2 = '{$this->cltpcontentsdat[0]["cltpcontents_biko_2"]}' , ";
		$strSQL .= "        cltpcontents_biko_3 = '{$this->cltpcontentsdat[0]["cltpcontents_biko_3"]}' , ";
		$strSQL .= "        cltpcontents_biko_4 = '{$this->cltpcontentsdat[0]["cltpcontents_biko_4"]}' , ";
		$strSQL .= "        cltpcontents_biko_5 = '{$this->cltpcontentsdat[0]["cltpcontents_biko_5"]}' , ";
		if($this->cltpcontentsdat[0]["cltpcontents_img_1_del_chk"] == 1){
			$strSQL .= "        cltpcontents_img_1 = NULL , ";
		}else if($this->cltpcontentsdat[0]["cltpcontents_img_1"] != ""){
			$strSQL .= "        cltpcontents_img_1 = '{$this->cltpcontentsdat[0]["cltpcontents_img_1"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_1_del_chk"] == 1){
			$strSQL .= "        cltpcontents_img_org_1 = NULL , ";
		}else if($this->cltpcontentsdat[0]["cltpcontents_img_org_1"] != ""){
			$strSQL .= "        cltpcontents_img_org_1 = '{$this->cltpcontentsdat[0]["cltpcontents_img_org_1"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_2_del_chk"] == 1){
			$strSQL .= "        cltpcontents_img_2 = NULL , ";
		}else if($this->cltpcontentsdat[0]["cltpcontents_img_2"] != ""){
			$strSQL .= "        cltpcontents_img_2 = '{$this->cltpcontentsdat[0]["cltpcontents_img_2"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_2_del_chk"] == 1){
			$strSQL .= "        cltpcontents_img_org_2 = NULL , ";
		}else if($this->cltpcontentsdat[0]["cltpcontents_img_org_2"] != ""){
			$strSQL .= "        cltpcontents_img_org_2 = '{$this->cltpcontentsdat[0]["cltpcontents_img_org_2"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_3_del_chk"] == 1){
			$strSQL .= "        cltpcontents_img_3 = NULL , ";
		}else if($this->cltpcontentsdat[0]["cltpcontents_img_3"] != ""){
			$strSQL .= "        cltpcontents_img_3 = '{$this->cltpcontentsdat[0]["cltpcontents_img_3"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_3_del_chk"] == 1){
			$strSQL .= "        cltpcontents_img_org_3 = NULL , ";
		}else if($this->cltpcontentsdat[0]["cltpcontents_img_org_3"] != ""){
			$strSQL .= "        cltpcontents_img_org_3 = '{$this->cltpcontentsdat[0]["cltpcontents_img_org_3"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_4_del_chk"] == 1){
			$strSQL .= "        cltpcontents_img_4 = NULL , ";
		}else if($this->cltpcontentsdat[0]["cltpcontents_img_4"] != ""){
			$strSQL .= "        cltpcontents_img_4 = '{$this->cltpcontentsdat[0]["cltpcontents_img_4"]}' , ";
		}
		if($this->cltpcontentsdat[0]["cltpcontents_img_4_del_chk"] == 1){
			$strSQL .= "        cltpcontents_img_org_4 = NULL , ";
		}else if($this->cltpcontentsdat[0]["cltpcontents_img_org_4"] != ""){
			$strSQL .= "        cltpcontents_img_org_4 = '{$this->cltpcontentsdat[0]["cltpcontents_img_org_4"]}' , ";
		}
		$strSQL .= "        cltpcontents_upd_date = 'now' ";
		$strSQL .= "  WHERE cltpcontents_id = {$this->cltpcontentsdat[0]["cltpcontents_id"]} ";
//	echo "CltpcontentsUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdCltpcontents(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdCltpcontents(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCltpcontents(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    �֥����ܾ��� - �������
	-----------------------------------------------------*/
	function basedb_DelCltpcontents ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//���ȥ�󥶥�����󳫻�
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelCltpcontents(1):".$obj->php_error;
			return (-1);
		}
		
		//  �쥳���ɥ�å�
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_cltpcontents ";
		$strSQL .= "  WHERE cltpcontents_id = {$this->cltpcontentsdat[0]["cltpcontents_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelCltpcontents(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  �����ǡ��������å�
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->cltpcontentsdat[0]["cltpcontents_id"] != $arr["cltpcontents_id"] ) {
			$this->php_error = "basedb_DelCltpcontents(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  ���ǯ�������å�
				$strSQL = "";
				$strSQL .= " UPDATE base_t_cltpcontents ";
				$strSQL .= "    SET cltpcontents_del_date = 'now' ";
				$strSQL .= "  WHERE cltpcontents_id = '{$this->cltpcontentsdat[0]["cltpcontents_id"]}' ";
		//	echo "CltpcontentsDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCltpcontents(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  �����Ծ�����
				$strSQL = "";
				$strSQL .= " DELETE FROM base_t_cltpcontents ";
				$strSQL .= "  WHERE cltpcontents_id = '{$this->cltpcontentsdat[0]["cltpcontents_id"]}'";
		//	echo "CltpcontentsDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCltpcontents(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelCltpcontents(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// �ȥ�󥶥������λ
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelCltpcontents(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}

}
?>
