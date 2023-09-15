<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_CampainClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $campaindat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_CampainClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->campaindat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetCampain ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetCampain(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cp_id"] != "" )       $sql_where .= " AND cp_id = {$this->jyoken["cp_id"]} ";
		if( $this->jyoken["cp_clid"] != "" )       $sql_where .= " AND cp_clid = {$this->jyoken["cp_clid"]} ";
		if( $this->jyoken["cp_stat"] != "" )    $sql_where .= " AND cp_stat = {$this->jyoken["cp_stat"]} ";

		if( $this->jyoken["cp_flg"] != "" )    $sql_where .= " AND cp_flg = '{$this->jyoken["cp_flg"]}' ";
		if( $this->jyoken["cp_start"] != "" )    $sql_where .= " AND cp_start = '{$this->jyoken["cp_start"]}' ";
		if( $this->jyoken["cp_end"] != "" )    $sql_where .= " AND cp_end = '{$this->jyoken["cp_end"]}' ";
		if( $this->jyoken["cp_camstart"] != "" )    $sql_where .= " AND cp_camstart = '{$this->jyoken["cp_camstart"]}' ";
		if( $this->jyoken["cp_camend"] != "" )    $sql_where .= " AND cp_camend = '{$this->jyoken["cp_camend"]}' ";
		if( $this->jyoken["cp_cgid"] != "" )    $sql_where .= " AND cp_cgid = '{$this->jyoken["cp_cgid"]}' ";
		if( $this->jyoken["cp_title"] != "" )    $sql_where .= " AND cp_title = '{$this->jyoken["cp_title"]}' ";
		if( $this->jyoken["cp_subtitle"] != "" )    $sql_where .= " AND cp_subtitle = '{$this->jyoken["cp_subtitle"]}' ";
		if( $this->jyoken["cp_linktext"] != "" )    $sql_where .= " AND cp_linktext = '{$this->jyoken["cp_linktext"]}' ";
		if( $this->jyoken["cp_btntext"] != "" )    $sql_where .= " AND cp_btntext = '{$this->jyoken["cp_btntext"]}' ";
		if( $this->jyoken["cp_contents"] != "" )    $sql_where .= " AND cp_contents = '{$this->jyoken["cp_contents"]}' ";
		if( $this->jyoken["cp_age"] != "" )    $sql_where .= " AND cp_age = '{$this->jyoken["cp_age"]}' ";
		if( $this->jyoken["cp_bkgdimg"] != "" )    $sql_where .= " AND cp_bkgdimg = '{$this->jyoken["cp_bkgdimg"]}' ";
		if( $this->jyoken["cp_bkgdimgorg"] != "" )    $sql_where .= " AND cp_bkgdimgorg = '{$this->jyoken["cp_bkgdimgorg"]}' ";
		if( $this->jyoken["cp_img1"] != "" )    $sql_where .= " AND cp_img1 = '{$this->jyoken["cp_img1"]}' ";
		if( $this->jyoken["cp_imgorg1"] != "" )    $sql_where .= " AND cp_imgorg1 = '{$this->jyoken["cp_imgorg1"]}' ";
		if( $this->jyoken["cp_img2"] != "" )    $sql_where .= " AND cp_img2 = '{$this->jyoken["cp_img2"]}' ";
		if( $this->jyoken["cp_imgorg2"] != "" )    $sql_where .= " AND cp_imgorg2 = '{$this->jyoken["cp_imgorg2"]}' ";
		if( $this->jyoken["cp_img3"] != "" )    $sql_where .= " AND cp_img3 = '{$this->jyoken["cp_img3"]}' ";
		if( $this->jyoken["cp_imgorg3"] != "" )    $sql_where .= " AND cp_imgorg3 = '{$this->jyoken["cp_imgorg3"]}' ";
		if( $this->jyoken["cp_img4"] != "" )    $sql_where .= " AND cp_img4 = '{$this->jyoken["cp_img4"]}' ";
		if( $this->jyoken["cp_imgorg4"] != "" )    $sql_where .= " AND cp_imgorg4 = '{$this->jyoken["cp_imgorg4"]}' ";
		if( $this->jyoken["cp_topflg"] != "" )    $sql_where .= " AND cp_topflg = '{$this->jyoken["cp_topflg"]}' ";
		
		if( $this->jyoken["cp_upddate"] != "" )    $sql_where .= " AND cp_upddate = '{$this->jyoken["cp_upddate"]}' ";
		
		if( $this->jyoken["cp_ido"] != "" )    $sql_where .= " AND cp_ido = '{$this->jyoken["cp_ido"]}' ";

		if( $this->jyoken["cp_keido"] != "" )    $sql_where .= " AND cp_keido = '{$this->jyoken["cp_keido"]}' ";
		if( $this->jyoken["cp_zoom"] != "" )    $sql_where .= " AND cp_zoom = '{$this->jyoken["cp_zoom"]}' ";
		if( $this->jyoken["cp_adminid"] != "" )    $sql_where .= " AND cp_adminid = '{$this->jyoken["cp_adminid"]}' ";
		if( $this->jyoken["cp_deldate"] != "" ) $sql_where .= " AND cp_deldate is NULL ";

		if( $this->jyoken["cp_publishstart"] != "" )    $sql_where .= " AND (cp_start <= {$this->jyoken["cp_publishstart"]} OR cp_start is NULL)";
		if( $this->jyoken["cp_publishend"] != "" )    $sql_where .= " AND (cp_end >= {$this->jyoken["cp_publishend"]} OR cp_end is NULL)";
		
		// 並び順
		$sql_order = "";
		IF( $this->sort["cp_upddate"] == 2 ){
			$sql_order = " ORDER BY cp_upddate desc ";
		}
		IF( $this->sort["cp_upddate"] == 1 ){
			$sql_order = " ORDER BY cp_upddate ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_campain ";
		$stmt2 = "";
		$stmt2 .= " WHERE cp_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo "GetCampain_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCampain(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetCampain(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->campaindat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cp_id) FROM t_campain ";
		$strSQL .= $stmt2;
	//echo "GetCampain_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetCampain(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetCampain(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetCampain(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 登録
	-----------------------------------------------------*/
	function basedb_InsCampain () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsCampain(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_campain IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCampain(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_campain ";
		$strSQL .= "           ( ";
		$strSQL .= "             cp_clid , ";
		$strSQL .= "             cp_stat , ";

		$strSQL .= "             cp_flg , ";
		$strSQL .= "             cp_topflg , ";
		$strSQL .= "             cp_tcid , ";
		$strSQL .= "             cp_tccomment , ";
		$strSQL .= "             cp_start , ";
		$strSQL .= "             cp_end , ";
		$strSQL .= "             cp_camstart , ";
		$strSQL .= "             cp_camend , ";
		$strSQL .= "             cp_cgid , ";
		$strSQL .= "             cp_title , ";
		$strSQL .= "             cp_subtitle , ";

		$strSQL .= "             cp_linktext , ";
		$strSQL .= "             cp_btntext , ";
		$strSQL .= "             cp_contents , ";
		$strSQL .= "             cp_age , ";
		$strSQL .= "             cp_bkgdimg , ";

//		if($this->campaindat[0]["cp_bkgdimgorg"] != ""){
//			$strSQL .= "             cp_bkgdimgorg , ";
//		}
		if($this->campaindat[0]["cp_imgorg1"] != ""){
			$strSQL .= "             cp_imgorg1 , ";
		}
		if($this->campaindat[0]["cp_imgorg2"] != ""){
			$strSQL .= "             cp_imgorg2 , ";
		}
		if($this->campaindat[0]["cp_imgorg3"] != ""){
			$strSQL .= "             cp_imgorg3 , ";
		}
		if($this->campaindat[0]["cp_imgorg4"] != ""){
			$strSQL .= "             cp_imgorg4 , ";
		}

		$strSQL .= "             cp_ido , ";

		$strSQL .= "             cp_keido , ";
		$strSQL .= "             cp_zoom , ";
		$strSQL .= "             cp_adminid , ";
		$strSQL .= "             cp_insdate , ";
		$strSQL .= "             cp_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->campaindat[0]["cp_clid"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_clid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->campaindat[0]["cp_stat"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_stat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		if($this->campaindat[0]["cp_flg"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_flg"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		if($this->campaindat[0]["cp_topflg"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_topflg"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		if($this->campaindat[0]["cp_tcid"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_tcid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->campaindat[0]["cp_tccomment"]}' , ";

		if($this->campaindat[0]["cp_start"] != "" && $this->campaindat[0]["cp_start"] != "DEL"){
			$strSQL .= "        '{$this->campaindat[0]["cp_start"]}' , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		if($this->campaindat[0]["cp_end"] != "" && $this->campaindat[0]["cp_end"] != "DEL"){
			$strSQL .= "        '{$this->campaindat[0]["cp_end"]}' , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		if($this->campaindat[0]["cp_camstart"] != "" && $this->campaindat[0]["cp_camstart"] != "DEL"){
			$strSQL .= "       '{$this->campaindat[0]["cp_camstart"]}' , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->campaindat[0]["cp_camend"] != "" && $this->campaindat[0]["cp_camend"] != "DEL"){
			$strSQL .= "        '{$this->campaindat[0]["cp_camend"]}' , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->campaindat[0]["cp_cgid"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_cgid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->campaindat[0]["cp_title"]}' , ";
		$strSQL .= "             '{$this->campaindat[0]["cp_subtitle"]}' , ";

		$strSQL .= "             '{$this->campaindat[0]["cp_linktext"]}' , ";

		$strSQL .= "             '{$this->campaindat[0]["cp_btntext"]}' , ";
		$strSQL .= "             '{$this->campaindat[0]["cp_contents"]}' , ";
		if($this->campaindat[0]["cp_age"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_age"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		$strSQL .= "             '{$this->campaindat[0]["cp_bkgdimg"]}' , ";
//		if($this->campaindat[0]["cp_bkgdimgorg"] != ""){
//			$strSQL .= "             '{$this->campaindat[0]["cp_bkgdimgorg"]}' , ";
//		}
		if($this->campaindat[0]["cp_imgorg1"] != ""){
			$strSQL .= "             '{$this->campaindat[0]["cp_imgorg1"]}' , ";
		}
		if($this->campaindat[0]["cp_imgorg2"] != ""){
			$strSQL .= "             '{$this->campaindat[0]["cp_imgorg2"]}' , ";
		}
		if($this->campaindat[0]["cp_imgorg3"] != ""){
			$strSQL .= "             '{$this->campaindat[0]["cp_imgorg3"]}' , ";
		}
		if($this->campaindat[0]["cp_imgorg4"] != ""){
			$strSQL .= "             '{$this->campaindat[0]["cp_imgorg4"]}' , ";
		}

		if($this->campaindat[0]["cp_ido"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_ido"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->campaindat[0]["cp_keido"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_keido"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		if($this->campaindat[0]["cp_zoom"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_zoom"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->campaindat[0]["cp_adminid"] != ""){
			$strSQL .= "        {$this->campaindat[0]["cp_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}

		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "CampainInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsCampain(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsCampain(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_idの取得
		$result = @pg_exec( $this->conn , " SELECT currval('t_campain_cp_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->campaindat[0]["cp_id"] = @pg_result( $result , 0 , currval );

		//  管理者情報修正
		if($this->campaindat[0]["cp_img1"] != ""){
			$cp_img1 = split("/",$this->campaindat[0]["cp_img1"]);
			$this->campaindat[0]["cp_img1"] = $cp_img1[0].$this->campaindat[0]["cp_id"].$cp_img1[1];
		}
		if($this->campaindat[0]["cp_img2"] != ""){
			$cp_img2 = split("/",$this->campaindat[0]["cp_img2"]);
			$this->campaindat[0]["cp_img2"] = $cp_img2[0].$this->campaindat[0]["cp_id"].$cp_img2[1];
		}
		if($this->campaindat[0]["cp_img3"] != ""){
			$cp_img3 = split("/",$this->campaindat[0]["cp_img3"]);
			$this->campaindat[0]["cp_img3"] = $cp_img3[0].$this->campaindat[0]["cp_id"].$cp_img3[1];
		}
		if($this->campaindat[0]["cp_img4"] != ""){
			$cp_img4 = split("/",$this->campaindat[0]["cp_img4"]);
			$this->campaindat[0]["cp_img4"] = $cp_img4[0].$this->campaindat[0]["cp_id"].$cp_img4[1];
		}		
//		if($this->campaindat[0]["cp_bkgdimg"] != ""){
//			$cp_bkgdimg = split("/",$this->campaindat[0]["cp_bkgdimg"]);
//			$this->campaindat[0]["cp_bkgdimg"] = $cp_bkgdimg[0].$this->campaindat[0]["cp_id"].$cp_bkgdimg[1];
//		}		

		if($this->campaindat[0]["cp_img1"] != "" || $this->campaindat[0]["cp_img2"] != "" || $this->campaindat[0]["cp_img3"] != "" || $this->campaindat[0]["cp_img4"] != ""){
			$strSQL = "";
			$strSQL .= " UPDATE t_campain ";
			$strSQL .= "    SET ";
			$strSQL2 ="";
			if($this->campaindat[0]["cp_img1"] != ""){
				$strSQL2 .= "        cp_img1 = '{$this->campaindat[0]["cp_img1"]}' ";
			}
			if($this->campaindat[0]["cp_img2"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cp_img2 = '{$this->campaindat[0]["cp_img2"]}' ";
			}
			if($this->campaindat[0]["cp_img3"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cp_img3 = '{$this->campaindat[0]["cp_img3"]}' ";
			}
			if($this->campaindat[0]["cp_img4"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        cp_img4 = '{$this->campaindat[0]["cp_img4"]}' ";
			}
//			if($this->campaindat[0]["cp_bkgdimg"] != ""){
//				if($strSQL2 != "")$strSQL2 .= " , ";
//				$strSQL2 .= "        cp_bkgdimg = '{$this->campaindat[0]["cp_bkgdimg"]}' ";
//			}
			$strSQL = $strSQL.$strSQL2;
			$strSQL .= "  WHERE cp_id = {$this->campaindat[0]["cp_id"]} ";
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
			$this->php_error = "basedb_InsCampain(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdCampain () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdCampain(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_campain ";
		$strSQL .= "  WHERE cp_id = {$this->campaindat[0]["cp_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
			$this->php_error = "basedb_UpdCampain(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->campaindat[0]["cp_id"] != $arr["cp_id"] ) {
			$this->php_error = "basedb_UpdCampain(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->campaindat[0]["cp_clid"] != $arr["cp_clid"] ) {
			$this->php_error = "basedb_UpdCampain(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->campaindat[0]["cp_upddate"] != $arr["cp_upddate"] ) {
			$this->php_error = "basedb_UpdCampain(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_campain ";
		$strSQL .= "    SET ";
		if($this->campaindat[0]["cp_clid"] != ""){
			$strSQL .= "        cp_clid = {$this->campaindat[0]["cp_clid"]} , ";
		}else{
			$strSQL .= "        cp_clid = NULL , ";
		}
		if($this->campaindat[0]["cp_stat"] != ""){
			$strSQL .= "        cp_stat = {$this->campaindat[0]["cp_stat"]} , ";
		}else{
			$strSQL .= "        cp_stat = NULL , ";
		}
		if($this->campaindat[0]["cp_flg"] != ""){
			$strSQL .= "        cp_flg = {$this->campaindat[0]["cp_flg"]} , ";
		}else{
			$strSQL .= "        cp_flg = NULL , ";
		}
		if($this->campaindat[0]["cp_topflg"] != ""){
			$strSQL .= "        cp_topflg = {$this->campaindat[0]["cp_topflg"]} , ";
		}else{
			$strSQL .= "        cp_topflg = NULL , ";
		}
		if($this->campaindat[0]["cp_tcid"] != ""){
			$strSQL .= "        cp_tcid = {$this->campaindat[0]["cp_tcid"]} , ";
		}else{
			$strSQL .= "        cp_tcid = NULL , ";
		}
		$strSQL .= "        cp_tccomment = '{$this->campaindat[0]["cp_tccomment"]}' , ";
		if($this->campaindat[0]["cp_start"] != "" && $this->campaindat[0]["cp_start"] != "DEL"){
			$strSQL .= "        cp_start = '{$this->campaindat[0]["cp_start"]}' , ";
		}else if($this->campaindat[0]["cp_start"] == "DEL"){
			$strSQL .= "        cp_start = NULL , ";
		}
		if($this->campaindat[0]["cp_end"] != "" && $this->campaindat[0]["cp_end"] != "DEL"){
			$strSQL .= "        cp_end = '{$this->campaindat[0]["cp_end"]}' , ";
		}else if($this->campaindat[0]["cp_end"] == "DEL"){
			$strSQL .= "        cp_end = NULL , ";
		}
		if($this->campaindat[0]["cp_camstart"] != "" && $this->campaindat[0]["cp_camstart"] != "DEL"){
			$strSQL .= "        cp_camstart = '{$this->campaindat[0]["cp_camstart"]}' , ";
		}else if($this->campaindat[0]["cp_camstart"] == "DEL"){
			$strSQL .= "        cp_camstart = NULL , ";
		}
		if($this->campaindat[0]["cp_camend"] != "" && $this->campaindat[0]["cp_camend"] != "DEL"){
			$strSQL .= "        cp_camend = '{$this->campaindat[0]["cp_camend"]}' , ";
		}else if($this->campaindat[0]["cp_camend"] == "DEL"){
			$strSQL .= "        cp_camend = NULL , ";
		}
		if($this->campaindat[0]["cp_cgid"] != ""){
			$strSQL .= "        cp_cgid = {$this->campaindat[0]["cp_cgid"]} , ";
		}else{
			$strSQL .= "        cp_cgid = NULL , ";
		}

		$strSQL .= "        cp_title = '{$this->campaindat[0]["cp_title"]}' , ";
		$strSQL .= "        cp_subtitle = '{$this->campaindat[0]["cp_subtitle"]}' , ";
		$strSQL .= "        cp_linktext = '{$this->campaindat[0]["cp_linktext"]}' , ";

		$strSQL .= "        cp_btntext = '{$this->campaindat[0]["cp_btntext"]}' , ";
		$strSQL .= "        cp_contents = '{$this->campaindat[0]["cp_contents"]}' , ";

		if($this->campaindat[0]["cp_age"] != ""){
			$strSQL .= "        cp_age = {$this->campaindat[0]["cp_age"]} , ";
		}else{
			$strSQL .= "        cp_age = NULL , ";
		}

		$strSQL .= "        cp_bkgdimg = '{$this->campaindat[0]["cp_bkgdimg"]}' , ";
//		if($this->campaindat[0]["cp_bkgdimg_del_chk"] == 1){
//			$strSQL .= "        cp_bkgdimg = NULL , ";
//		}else if($this->campaindat[0]["cp_bkgdimg"] != ""){
//			$strSQL .= "        cp_bkgdimg = '{$this->campaindat[0]["cp_bkgdimg"]}' , ";
//		}
//		if($this->campaindat[0]["cp_bkgdimg_del_chk"] == 1){
//			$strSQL .= "        cp_bkgdimgorg = NULL , ";
//		}else if($this->campaindat[0]["cp_bkgdimgorg"] != ""){
//			$strSQL .= "        cp_bkgdimgorg = '{$this->campaindat[0]["cp_bkgdimgorg"]}' , ";
//		}
		if($this->campaindat[0]["cp_img1_del_chk"] == 1){
			$strSQL .= "        cp_img1 = NULL , ";
		}else if($this->campaindat[0]["cp_img1"] != ""){
			$strSQL .= "        cp_img1 = '{$this->campaindat[0]["cp_img1"]}' , ";
		}
		if($this->campaindat[0]["cp_img1_del_chk"] == 1){
			$strSQL .= "        cp_imgorg1 = NULL , ";
		}else if($this->campaindat[0]["cp_imgorg1"] != ""){
			$strSQL .= "        cp_imgorg1 = '{$this->campaindat[0]["cp_imgorg1"]}' , ";
		}
		if($this->campaindat[0]["cp_img2_del_chk"] == 1){
			$strSQL .= "        cp_img2 = NULL , ";
		}else if($this->campaindat[0]["cp_img2"] != ""){
			$strSQL .= "        cp_img2 = '{$this->campaindat[0]["cp_img2"]}' , ";
		}
		if($this->campaindat[0]["cp_img2_del_chk"] == 1){
			$strSQL .= "        cp_imgorg2 = NULL , ";
		}else if($this->campaindat[0]["cp_imgorg2"] != ""){
			$strSQL .= "        cp_imgorg2 = '{$this->campaindat[0]["cp_imgorg2"]}' , ";
		}
		if($this->campaindat[0]["cp_img3_del_chk"] == 1){
			$strSQL .= "        cp_img3 = NULL , ";
		}else if($this->campaindat[0]["cp_img3"] != ""){
			$strSQL .= "        cp_img3 = '{$this->campaindat[0]["cp_img3"]}' , ";
		}
		if($this->campaindat[0]["cp_img3_del_chk"] == 1){
			$strSQL .= "        cp_imgorg3 = NULL , ";
		}else if($this->campaindat[0]["cp_imgorg3"] != ""){
			$strSQL .= "        cp_imgorg3 = '{$this->campaindat[0]["cp_imgorg3"]}' , ";
		}
		if($this->campaindat[0]["cp_img4_del_chk"] == 1){
			$strSQL .= "        cp_img4 = NULL , ";
		}else if($this->campaindat[0]["cp_img4"] != ""){
			$strSQL .= "        cp_img4 = '{$this->campaindat[0]["cp_img4"]}' , ";
		}
		if($this->campaindat[0]["cp_img4_del_chk"] == 1){
			$strSQL .= "        cp_imgorg4 = NULL , ";
		}else if($this->campaindat[0]["cp_imgorg4"] != ""){
			$strSQL .= "        cp_imgorg4 = '{$this->campaindat[0]["cp_imgorg4"]}' , ";
		}

		if($this->campaindat[0]["cp_ido"] != ""){
			$strSQL .= "        cp_ido = {$this->campaindat[0]["cp_ido"]} , ";
		}else{
			$strSQL .= "        cp_ido = NULL , ";
		}
		if($this->campaindat[0]["cp_keido"] != ""){
			$strSQL .= "        cp_keido = {$this->campaindat[0]["cp_keido"]} , ";
		}else{
			$strSQL .= "        cp_keido = NULL , ";
		}
		if($this->campaindat[0]["cp_zoom"] != ""){
			$strSQL .= "        cp_zoom = {$this->campaindat[0]["cp_zoom"]} , ";
		}else{
			$strSQL .= "        cp_zoom = NULL , ";
		}
		if($this->campaindat[0]["cp_adminid"] != ""){
			$strSQL .= "        cp_adminid = {$this->campaindat[0]["cp_adminid"]} , ";
		}else{
			$strSQL .= "        cp_adminid = NULL , ";
		}
		$strSQL .= "        cp_upddate = 'now' ";
		$strSQL .= "  WHERE cp_id = {$this->campaindat[0]["cp_id"]} ";
	//echo "CampainUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdCampain(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdCampain(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdCampain(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 削除処理
	-----------------------------------------------------*/
	function basedb_DelCampain ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelCampain(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_campain ";
		$strSQL .= "  WHERE cp_id = {$this->campaindat[0]["cp_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelCampain(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->campaindat[0]["cp_id"] != $arr["cp_id"] ) {
			$this->php_error = "basedb_DelCampain(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE t_campain ";
				$strSQL .= "    SET cp_deldate = 'now' ";
				$strSQL .= "  WHERE cp_id = '{$this->campaindat[0]["cp_id"]}' ";
			//echo "CampainDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCampain(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM t_campain ";
				$strSQL .= "  WHERE cp_id = '{$this->campaindat[0]["cp_id"]}'";
			//echo "CampainDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelCampain(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelCampain(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelCampain(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


	/*-----------------------------------------------------
	    次のシリアルナンバー - 検索
	-----------------------------------------------------*/
	function basedb_SerialCampain () {
		
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
		$strSQL = " SELECT last_value FROM t_campain_cp_id_seq ";

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
				$this->campaindat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}

		$this->campaindat[0]["last_value"]++;

		return ( $this->campaindat[0]["last_value"] );
		
	}

}
?>
