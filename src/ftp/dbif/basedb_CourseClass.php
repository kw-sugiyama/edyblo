<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_CourseClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $coursedat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_CourseClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->coursedat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetCourse ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetCourse(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cs_id"] != "" )       $sql_where .= " AND cs_id = {$this->jyoken["cs_id"]} ";
		if( $this->jyoken["cs_clid"] != "" )       $sql_where .= " AND cs_clid = {$this->jyoken["cs_clid"]} ";
		if( $this->jyoken["cs_stat"] != "" )    $sql_where .= " AND cs_stat = {$this->jyoken["cs_stat"]} ";
		if( $this->jyoken["cs_cgid"] != "" )    $sql_where .= " AND cs_cgid = '{$this->jyoken["cs_cgid"]}' ";
		if( $this->jyoken["cs_title"] != "" )    $sql_where .= " AND cs_title = '{$this->jyoken["cs_title"]}' ";
		if( $this->jyoken["cs_jtitle"] != "" )    $sql_where .= " AND cs_contents = '{$this->jyoken["cs_jtitle"]}' ";
		if( $this->jyoken["cs_organize"] != "" )    $sql_where .= " AND cs_img1 = '{$this->jyoken["cs_organize"]}' ";
		if( $this->jyoken["cs_price"] != "" )    $sql_where .= " AND cs_img2 = '{$this->jyoken["cs_price"]}' ";
		if( $this->jyoken["cs_entrance"] != "" )    $sql_where .= " AND cs_img3 = '{$this->jyoken["cs_entrance"]}' ";
		if( $this->jyoken["cs_shisetsu"] != "" )    $sql_where .= " AND cs_img4 = '{$this->jyoken["cs_shisetsu"]}' ";
		if( $this->jyoken["cs_textfee"] != "" )    $sql_where .= " AND cs_ido = '{$this->jyoken["cs_textfee"]}' ";
		if( $this->jyoken["cs_monthlyfee"] != "" )    $sql_where .= " AND cs_keido = '{$this->jyoken["cs_monthlyfee"]}' ";
		if( $this->jyoken["cs_age"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_age"]}' ";
		if( $this->jyoken["cs_level"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_level"]}' ";
		if( $this->jyoken["cs_purpose"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_purpose"]}' ";
		if( $this->jyoken["cs_subject"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_subject"]}' ";
		if( $this->jyoken["cs_pr"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_pr"]}' ";
		if( $this->jyoken["cs_tcid"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_tcid"]}' ";
		if( $this->jyoken["cs_tcflg"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_tcflg"]}' ";
		if( $this->jyoken["cs_img1"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_img1"]}' ";
		if( $this->jyoken["cs_imgorg1"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_imgorg1"]}' ";
		if( $this->jyoken["cs_img2"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_img2"]}' ";
		if( $this->jyoken["cs_imgorg2"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_imgorg2"]}' ";
		if( $this->jyoken["cs_img3"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_img3"]}' ";
		if( $this->jyoken["cs_imgorg3"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_imgorg3"]}' ";
		if( $this->jyoken["cs_img4"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_img4"]}' ";
		if( $this->jyoken["cs_imgorg4"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_imgorg4"]}' ";
		if( $this->jyoken["cs_img5"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_img5"]}' ";
		if( $this->jyoken["cs_imgorg5"] != "" )    $sql_where .= " AND cs_zoom = '{$this->jyoken["cs_imgorg5"]}' ";
		if( $this->jyoken["cs_topflg"] != "" )    $sql_where .= " AND cs_topflg = '{$this->jyoken["cs_topflg"]}' ";
		if( $this->jyoken["cs_dispno"] != "" )    $sql_where .= " AND cs_dispno = '{$this->jyoken["cs_dispno"]}' ";
		if( $this->jyoken["cs_upddate"] != "" )       $sql_where .= " AND cs_upddate = '{$this->jyoken["cs_upddate"]}' ";
		if( $this->jyoken["cs_deldate"] != "" ) $sql_where .= " AND cs_deldate is NULL ";

		
		// 並び順
		$sql_order = "";
		IF( $this->sort["cs_upddate"] == 2 ){
			$sql_order = " ORDER BY cs_upddate desc ";
		}
		IF( $this->sort["cs_upddate"] == 1 ){
			$sql_order = " ORDER BY cs_upddate ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_course ";
		$stmt2 = "";
		$stmt2 .= " WHERE cs_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
//echo "GetCourse_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCourse(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetCourse(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->coursedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cs_id) FROM t_course ";
		$strSQL .= $stmt2;
//echo "GetCourse_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCourse(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetCourse(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetCourse(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 登録
	-----------------------------------------------------*/
	function basedb_InsCourse () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsCourse(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_course IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCourse(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_course ";
		$strSQL .= "           ( ";
		$strSQL .= "             cs_clid , ";
		$strSQL .= "             cs_stat , ";
		$strSQL .= "             cs_cgid , ";
		$strSQL .= "             cs_title , ";
		$strSQL .= "             cs_jtitle , ";
		$strSQL .= "             cs_tccomment , ";
		$strSQL .= "             cs_organize , ";

		$strSQL .= "             cs_start , ";
		$strSQL .= "             cs_end , ";
		$strSQL .= "             cs_week , ";

		$strSQL .= "             cs_price , ";
		$strSQL .= "             cs_entrance , ";
		$strSQL .= "             cs_shisetsu , ";
		$strSQL .= "             cs_textfee , ";
		$strSQL .= "             cs_monthlyfee , ";
		$strSQL .= "             cs_age , ";
		$strSQL .= "             cs_level , ";
		$strSQL .= "             cs_purpose , ";
		$strSQL .= "             cs_subject , ";
		$strSQL .= "             cs_pr , ";
		$strSQL .= "             cs_tcid , ";
		$strSQL .= "             cs_tcflg , ";

		if($this->coursedat[0]["cs_imgorg1"] != ""){
			$strSQL .= "             cs_imgorg1 , ";
		}
		if($this->coursedat[0]["cs_imgorg2"] != ""){
			$strSQL .= "             cs_imgorg2 , ";
		}
		if($this->coursedat[0]["cs_imgorg3"] != ""){
			$strSQL .= "             cs_imgorg3 , ";
		}
		if($this->coursedat[0]["cs_imgorg4"] != ""){
			$strSQL .= "             cs_imgorg4 , ";
		}
		if($this->coursedat[0]["cs_imgorg5"] != ""){
			$strSQL .= "             cs_imgorg5 , ";
		}
		$strSQL .= "             cs_dispno , ";
		$strSQL .= "             cs_topflg , ";
		$strSQL .= "             cs_classform , ";
		$strSQL .= "             cs_adminid , ";
		$strSQL .= "             cs_insdate , ";
		$strSQL .= "             cs_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->coursedat[0]["cs_clid"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_clid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->coursedat[0]["cs_stat"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_stat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->coursedat[0]["cs_cgid"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_cgid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->coursedat[0]["cs_title"]}' , ";
		$strSQL .= "             '{$this->coursedat[0]["cs_jtitle"]}' , ";
		$strSQL .= "             '{$this->coursedat[0]["cs_tccomment"]}' , ";

		$strSQL .= "             '{$this->coursedat[0]["cs_organize"]}' , ";

		if($this->coursedat[0]["cs_start"]!=""){
			$strSQL .= "             '{$this->coursedat[0]["cs_start"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->coursedat[0]["cs_end"]!=""){
			$strSQL .= "             '{$this->coursedat[0]["cs_end"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             '{$this->coursedat[0]["cs_week"]}' , ";

		$strSQL .= "             '{$this->coursedat[0]["cs_price"]}' , ";
		$strSQL .= "             '{$this->coursedat[0]["cs_entrance"]}' , ";
		$strSQL .= "             '{$this->coursedat[0]["cs_shisetsu"]}' , ";
		$strSQL .= "             '{$this->coursedat[0]["cs_textfee"]}' , ";
		$strSQL .= "             '{$this->coursedat[0]["cs_monthlyfee"]}' , ";

		if($this->coursedat[0]["cs_age"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_age"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->coursedat[0]["cs_level"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_level"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		$strSQL .= "             '{$this->coursedat[0]["cs_purpose"]}' , ";
		if($this->coursedat[0]["cs_subject"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_subject"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->coursedat[0]["cs_pr"]}' , ";

		if($this->coursedat[0]["cs_tcid"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_tcid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->coursedat[0]["cs_tcflg"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_tcflg"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		if($this->coursedat[0]["cs_imgorg1"] != ""){
			$strSQL .= "             '{$this->coursedat[0]["cs_imgorg1"]}' , ";
		}
		if($this->coursedat[0]["cs_imgorg2"] != ""){
			$strSQL .= "             '{$this->coursedat[0]["cs_imgorg2"]}' , ";
		}
		if($this->coursedat[0]["cs_imgorg3"] != ""){
			$strSQL .= "             '{$this->coursedat[0]["cs_imgorg3"]}' , ";
		}
		if($this->coursedat[0]["cs_imgorg4"] != ""){
			$strSQL .= "             '{$this->coursedat[0]["cs_imgorg4"]}' , ";
		}
		if($this->coursedat[0]["cs_imgorg5"] != ""){
			$strSQL .= "             '{$this->coursedat[0]["cs_imgorg5"]}' , ";
		}


		if($this->coursedat[0]["cs_dispno"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_dispno"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->coursedat[0]["cs_topflg"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_topflg"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->coursedat[0]["cs_classform"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_classform"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->coursedat[0]["cs_adminid"] != ""){
			$strSQL .= "        {$this->coursedat[0]["cs_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "CourseInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCourse(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsCourse(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_idの取得
		$result = @pg_exec( $this->conn , " SELECT currval('t_course_cs_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->coursedat[0]["cs_id"] = @pg_result( $result , 0 , currval );

		//  管理者情報修正
		if($this->coursedat[0]["cs_img1"] != ""){
			$cs_img1 = split("/",$this->coursedat[0]["cs_img1"]);
			$this->coursedat[0]["cs_img1"] = $cs_img1[0].$this->coursedat[0]["cs_id"].$cs_img1[1];
		}
		if($this->coursedat[0]["cs_img2"] != ""){
			$cs_img2 = split("/",$this->coursedat[0]["cs_img2"]);
			$this->coursedat[0]["cs_img2"] = $cs_img2[0].$this->coursedat[0]["cs_id"].$cs_img2[1];
		}
		if($this->coursedat[0]["cs_img3"] != ""){
			$cs_img3 = split("/",$this->coursedat[0]["cs_img3"]);
			$this->coursedat[0]["cs_img3"] = $cs_img3[0].$this->coursedat[0]["cs_id"].$cs_img3[1];
		}
		if($this->coursedat[0]["cs_img4"] != ""){
			$cs_img4 = split("/",$this->coursedat[0]["cs_img4"]);
			$this->coursedat[0]["cs_img4"] = $cs_img4[0].$this->coursedat[0]["cs_id"].$cs_img4[1];
		}		
		if($this->coursedat[0]["cs_img5"] != ""){
			$cs_img5 = split("/",$this->coursedat[0]["cs_img5"]);
			$this->coursedat[0]["cs_img5"] = $cs_img5[0].$this->coursedat[0]["cs_id"].$cs_img5[1];
		}		

		if($this->coursedat[0]["cs_img1"] != "" || $this->coursedat[0]["cs_img2"] != "" || $this->coursedat[0]["cs_img3"] != "" || $this->coursedat[0]["cs_img4"] != ""){
			$strSQL = "";
			$strSQL .= " UPDATE t_course ";
			$strSQL .= "    SET ";
			$strSQL2 ="";
			if($this->coursedat[0]["cs_img1"] != ""){
				$strSQL2 .= "        cs_img1 = '{$this->coursedat[0]["cs_img1"]}' ";
			}
			if($this->coursedat[0]["cs_img2"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cs_img2 = '{$this->coursedat[0]["cs_img2"]}' ";
			}
			if($this->coursedat[0]["cs_img3"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cs_img3 = '{$this->coursedat[0]["cs_img3"]}' ";
			}
			if($this->coursedat[0]["cs_img4"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cs_img4 = '{$this->coursedat[0]["cs_img4"]}' ";
			}
			if($this->coursedat[0]["cs_img5"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cs_img5 = '{$this->coursedat[0]["cs_img5"]}' ";
			}
			$strSQL = $strSQL.$strSQL2;
			$strSQL .= "  WHERE cs_id = {$this->coursedat[0]["cs_id"]} ";
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

		//  トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsCourse(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdCourse () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCourse(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_course ";
		$strSQL .= "  WHERE cs_id = {$this->coursedat[0]["cs_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
			$this->php_error = "basedb_UpdCourse(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->coursedat[0]["cs_id"] != $arr["cs_id"] ) {
			$this->php_error = "basedb_UpdCourse(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->coursedat[0]["cs_clid"] != $arr["cs_clid"] ) {
			$this->php_error = "basedb_UpdCourse(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->coursedat[0]["cs_upddate"] != $arr["cs_upddate"] ) {
			$this->php_error = "basedb_UpdCourse(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_course ";
		$strSQL .= "    SET ";
		if($this->coursedat[0]["cs_clid"] != ""){
			$strSQL .= "        cs_clid = {$this->coursedat[0]["cs_clid"]} , ";
		}else{
			$strSQL .= "        cs_clid = NULL , ";
		}
		if($this->coursedat[0]["cs_stat"] != ""){
			$strSQL .= "        cs_stat = {$this->coursedat[0]["cs_stat"]} , ";
		}else{
			$strSQL .= "        cs_stat = NULL , ";
		}
		if($this->coursedat[0]["cs_cgid"] != ""){
			$strSQL .= "        cs_cgid = {$this->coursedat[0]["cs_cgid"]} , ";
		}else{
			$strSQL .= "        cs_cgid = NULL , ";
		}

		$strSQL .= "        cs_title = '{$this->coursedat[0]["cs_title"]}' , ";
		$strSQL .= "        cs_jtitle = '{$this->coursedat[0]["cs_jtitle"]}' , ";
		$strSQL .= "        cs_tccomment = '{$this->coursedat[0]["cs_tccomment"]}' , ";
		$strSQL .= "        cs_organize = '{$this->coursedat[0]["cs_organize"]}' , ";

		if($this->coursedat[0]["cs_start"]!=""){
			$strSQL .= "  cs_start = '{$this->coursedat[0]["cs_start"]}' , ";
		}else{
			$strSQL .= "      cs_start = NULL , ";
		}
		if($this->coursedat[0]["cs_end"]!=""){
			$strSQL .= "     cs_end = '{$this->coursedat[0]["cs_end"]}' , ";
		}else{
			$strSQL .= "       cs_end = NULL , ";
		}
		$strSQL .= "        cs_week = '{$this->coursedat[0]["cs_week"]}' , ";

		$strSQL .= "        cs_price = '{$this->coursedat[0]["cs_price"]}' , ";
		$strSQL .= "        cs_entrance = '{$this->coursedat[0]["cs_entrance"]}' , ";
		$strSQL .= "        cs_shisetsu = '{$this->coursedat[0]["cs_shisetsu"]}' , ";
		$strSQL .= "        cs_textfee = '{$this->coursedat[0]["cs_textfee"]}' , ";
		$strSQL .= "        cs_monthlyfee = '{$this->coursedat[0]["cs_monthlyfee"]}' , ";

		if($this->coursedat[0]["cs_age"] != ""){
			$strSQL .= "        cs_age = {$this->coursedat[0]["cs_age"]} , ";
		}else{
			$strSQL .= "        cs_age = NULL , ";
		}
		if($this->coursedat[0]["cs_level"] != ""){
			$strSQL .= "        cs_level = {$this->coursedat[0]["cs_level"]} , ";
		}else{
			$strSQL .= "        cs_level = NULL , ";
		}
		if($this->coursedat[0]["cs_purpose"] != ""){
			$strSQL .= "        cs_purpose = {$this->coursedat[0]["cs_purpose"]} , ";
		}else{
			$strSQL .= "        cs_purpose = NULL , ";
		}
		if($this->coursedat[0]["cs_subject"] != ""){
			$strSQL .= "        cs_subject = {$this->coursedat[0]["cs_subject"]} , ";
		}else{
			$strSQL .= "        cs_subject = NULL , ";
		}

		$strSQL .= "        cs_pr = '{$this->coursedat[0]["cs_pr"]}' , ";

		if($this->coursedat[0]["cs_tcid"] != ""){
			$strSQL .= "        cs_tcid = {$this->coursedat[0]["cs_tcid"]} , ";
		}else{
			$strSQL .= "        cs_tcid = NULL , ";
		}
		if($this->coursedat[0]["cs_tcflg"] != ""){
			$strSQL .= "        cs_tcflg = {$this->coursedat[0]["cs_tcflg"]} , ";
		}else{
			$strSQL .= "        cs_tcflg = NULL , ";
		}

		if($this->coursedat[0]["cs_img1_del_chk"] == 1){
			$strSQL .= "        cs_img1 = NULL , ";
		}else if($this->coursedat[0]["cs_img1"] != ""){
			$strSQL .= "        cs_img1 = '{$this->coursedat[0]["cs_img1"]}' , ";
		}
		if($this->coursedat[0]["cs_img1_del_chk"] == 1){
			$strSQL .= "        cs_imgorg1 = NULL , ";
		}else if($this->coursedat[0]["cs_imgorg1"] != ""){
			$strSQL .= "        cs_imgorg1 = '{$this->coursedat[0]["cs_imgorg1"]}' , ";
		}
		if($this->coursedat[0]["cs_img2_del_chk"] == 1){
			$strSQL .= "        cs_img2 = NULL , ";
		}else if($this->coursedat[0]["cs_img2"] != ""){
			$strSQL .= "        cs_img2 = '{$this->coursedat[0]["cs_img2"]}' , ";
		}
		if($this->coursedat[0]["cs_img2_del_chk"] == 1){
			$strSQL .= "        cs_imgorg2 = NULL , ";
		}else if($this->coursedat[0]["cs_imgorg2"] != ""){
			$strSQL .= "        cs_imgorg2 = '{$this->coursedat[0]["cs_imgorg2"]}' , ";
		}
		if($this->coursedat[0]["cs_img3_del_chk"] == 1){
			$strSQL .= "        cs_img3 = NULL , ";
		}else if($this->coursedat[0]["cs_img3"] != ""){
			$strSQL .= "        cs_img3 = '{$this->coursedat[0]["cs_img3"]}' , ";
		}
		if($this->coursedat[0]["cs_img3_del_chk"] == 1){
			$strSQL .= "        cs_imgorg3 = NULL , ";
		}else if($this->coursedat[0]["cs_imgorg3"] != ""){
			$strSQL .= "        cs_imgorg3 = '{$this->coursedat[0]["cs_imgorg3"]}' , ";
		}
		if($this->coursedat[0]["cs_img4_del_chk"] == 1){
			$strSQL .= "        cs_img4 = NULL , ";
		}else if($this->coursedat[0]["cs_img4"] != ""){
			$strSQL .= "        cs_img4 = '{$this->coursedat[0]["cs_img4"]}' , ";
		}
		if($this->coursedat[0]["cs_img4_del_chk"] == 1){
			$strSQL .= "        cs_imgorg4 = NULL , ";
		}else if($this->coursedat[0]["cs_imgorg4"] != ""){
			$strSQL .= "        cs_imgorg4 = '{$this->coursedat[0]["cs_imgorg4"]}' , ";
		}
		if($this->coursedat[0]["cs_img5_del_chk"] == 1){
			$strSQL .= "        cs_img5 = NULL , ";
		}else if($this->coursedat[0]["cs_img5"] != ""){
			$strSQL .= "        cs_img5 = '{$this->coursedat[0]["cs_img5"]}' , ";
		}
		if($this->coursedat[0]["cs_img5_del_chk"] == 1){
			$strSQL .= "        cs_imgorg5 = NULL , ";
		}else if($this->coursedat[0]["cs_imgorg5"] != ""){
			$strSQL .= "        cs_imgorg5 = '{$this->coursedat[0]["cs_imgorg5"]}' , ";
		}

		if($this->coursedat[0]["cs_dispno"] != ""){
			$strSQL .= "        cs_dispno = {$this->coursedat[0]["cs_dispno"]} , ";
		}else{
			$strSQL .= "        cs_dispno = NULL , ";
		}
		if($this->coursedat[0]["cs_classform"] != ""){
			$strSQL .= "        cs_classform = {$this->coursedat[0]["cs_classform"]} , ";
		}else{
			$strSQL .= "        cs_classform = NULL , ";
		}
		if($this->coursedat[0]["cs_topflg"] != ""){
			$strSQL .= "        cs_topflg = {$this->coursedat[0]["cs_topflg"]} , ";
		}else{
			$strSQL .= "        cs_topflg = NULL , ";
		}
		if($this->coursedat[0]["cs_adminid"] != ""){
			$strSQL .= "        cs_adminid = {$this->coursedat[0]["cs_adminid"]} , ";
		}else{
			$strSQL .= "        cs_adminid = NULL , ";
		}
		$strSQL .= "        cs_upddate = 'now' ";
		$strSQL .= "  WHERE cs_id = {$this->coursedat[0]["cs_id"]} ";
	//echo "CourseUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdCourse(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdCourse(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCourse(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 削除処理
	-----------------------------------------------------*/
	function basedb_DelCourse ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelCourse(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_course ";
		$strSQL .= "  WHERE cs_id = {$this->coursedat[0]["cs_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelCourse(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->coursedat[0]["cs_id"] != $arr["cs_id"] ) {
			$this->php_error = "basedb_DelCourse(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE t_course ";
				$strSQL .= "    SET cs_deldate = 'now' ";
				$strSQL .= "  WHERE cs_id = '{$this->coursedat[0]["cs_id"]}' ";
			//echo "CourseDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCourse(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM t_course ";
				$strSQL .= "  WHERE cs_id = '{$this->coursedat[0]["cs_id"]}'";
			//echo "CourseDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCourse(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelCourse(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelCourse(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


	/*-----------------------------------------------------
	    次のシリアルナンバー - 検索
	-----------------------------------------------------*/
	function basedb_SerialCourse () {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetBuild(1):".$obj->php_error;
			return (-1);
		}
		
		//ＳＱＬ条件作成
		$strSQL = "";
		$strSQL = " SELECT last_value FROM t_course_cs_id_seq ";

		//　ＳＱＬ実行
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
				$this->coursedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}

		$this->coursedat[0]["last_value"]++;

		return ( $this->coursedat[0]["last_value"] );
		
	}

}
?>
