<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_AdmissionClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $admissiondat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_AdmissionClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->admissiondat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetAdmission ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetAdmission(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["as_id"] != "" )       $sql_where .= " AND as_id = {$this->jyoken["as_id"]} ";
		if( $this->jyoken["as_clid"] != "" )       $sql_where .= " AND as_clid = {$this->jyoken["as_clid"]} ";
		if( $this->jyoken["as_stat"] != "" )    $sql_where .= " AND as_stat = {$this->jyoken["as_stat"]} ";
		if( $this->jyoken["as_cgid"] != "" )    $sql_where .= " AND as_cgid = '{$this->jyoken["as_cgid"]}' ";
		if( $this->jyoken["as_img"] != "" )    $sql_where .= " AND as_cgid = '{$this->jyoken["as_img"]}' ";
		if( $this->jyoken["as_imgorg"] != "" )    $sql_where .= " AND as_cgid = '{$this->jyoken["as_imgorg"]}' ";
		if( $this->jyoken["as_title"] != "" )    $sql_where .= " AND as_title = '{$this->jyoken["as_title"]}' ";
		if( $this->jyoken["as_contents"] != "" )    $sql_where .= " AND as_contents = '{$this->jyoken["as_contents"]}' ";
		if( $this->jyoken["as_img"] != "" )    $sql_where .= " AND as_img = '{$this->jyoken["as_img"]}' ";
		if( $this->jyoken["as_imgorg"] != "" )    $sql_where .= " AND as_img = '{$this->jyoken["as_imgorg"]}' ";
		if( $this->jyoken["as_dispno"] != "" )    $sql_where .= " AND as_img = '{$this->jyoken["as_dispno"]}' ";
		if( $this->jyoken["as_deldate"] != "" ) $sql_where .= " AND as_deldate is NULL ";

		
		// 並び順
		$sql_order = "";
		IF( $this->sort["as_upddate"] == 2 ){
			$sql_order = " ORDER BY as_upddate desc ";
		}
		IF( $this->sort["as_upddate"] == 1 ){
			$sql_order = " ORDER BY as_upddate ";
		}
		IF( $this->sort["as_dispno"] == 2 ){
			$sql_order = " ORDER BY as_stat,as_dispno desc ";
		}
		IF( $this->sort["as_dispno"] == 1 ){
			$sql_order = " ORDER BY as_stat,as_dispno ";
		}
		IF( $this->sort["as_dispno"] == 3 ){
			$sql_order = " ORDER BY as_stat,as_cgid,as_dispno ";
		}
		
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_admission ";
		$stmt2 = "";
		$stmt2 .= " WHERE as_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo "GetAdmission_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetAdmission(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetAdmission(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->admissiondat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(as_id) FROM t_admission ";
		$strSQL .= $stmt2;
	//echo "GetAdmission_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetAdmission(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetAdmission(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetAdmission(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 登録
	-----------------------------------------------------*/
	function basedb_InsAdmission () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsAdmission(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_admission IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsAdmission(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  表示順重複チェック
		if($this->admissiondat[0]["as_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_admission ";
			$strSQL .= "  WHERE as_dispno = '{$this->admissiondat[0]["as_dispno"]}' ";
			$strSQL .= "    AND as_deldate is null ";
			$strSQL .= "    AND as_stat <> 9 ";
			$strSQL .= "    AND as_clid = '{$this->admissiondat[0]["as_clid"]}' ";
			$strSQL .= "    AND as_cgid = '{$this->admissiondat[0]["as_cgid"]}' ";
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
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_admission ";
		$strSQL .= "           ( ";
		$strSQL .= "             as_clid , ";
		$strSQL .= "             as_stat , ";
		$strSQL .= "             as_cgid , ";
		$strSQL .= "             as_title , ";
		$strSQL .= "             as_contents , ";
		if($this->admissiondat[0]["as_imgorg"] != ""){
			$strSQL .= "             as_imgorg , ";
		}
		if($this->admissiondat[0]["as_img"] != ""){
			$strSQL .= "             as_img , ";
		}
		$strSQL .= "             as_dispno , ";
		$strSQL .= "             as_adminid , ";
		$strSQL .= "             as_insdate , ";
		$strSQL .= "             as_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->admissiondat[0]["as_clid"] != ""){
			$strSQL .= "        {$this->admissiondat[0]["as_clid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->admissiondat[0]["as_stat"] != ""){
			$strSQL .= "        {$this->admissiondat[0]["as_stat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->admissiondat[0]["as_cgid"] != ""){
			$strSQL .= "        {$this->admissiondat[0]["as_cgid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->admissiondat[0]["as_title"]}' , ";
		$strSQL .= "             '{$this->admissiondat[0]["as_contents"]}' , ";
		if($this->admissiondat[0]["as_imgorg"] != ""){
			$strSQL .= "             '{$this->admissiondat[0]["as_imgorg"]}' , ";
		}
		if($this->admissiondat[0]["as_img"] != ""){
			$strSQL .= "             '{$this->admissiondat[0]["as_img"]}' , ";
		}
		if($this->admissiondat[0]["as_dispno"] != ""){
			$strSQL .= "        {$this->admissiondat[0]["as_dispno"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->admissiondat[0]["as_adminid"] != ""){
			$strSQL .= "        {$this->admissiondat[0]["as_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "AdmissionInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsAdmission(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsAdmission(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_idの取得
		$result = @pg_exec( $this->conn , " SELECT currval('t_admission_as_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->admissiondat[0]["as_id"] = @pg_result( $result , 0 , currval );

		//  管理者情報修正
		if($this->admissiondat[0]["as_img"] != ""){
			$as_img = split("/",$this->admissiondat[0]["as_img"]);
			$this->admissiondat[0]["as_img"] = $as_img[0].$this->admissiondat[0]["as_id"].$as_img[1];
		}

		if($this->admissiondat[0]["as_img"] != ""){
			$strSQL = "";
			$strSQL .= " UPDATE t_admission ";
			$strSQL .= "    SET ";
			$strSQL2 ="";
			if($this->admissiondat[0]["as_img"] != ""){
				$strSQL2 .= "        as_img = '{$this->admissiondat[0]["as_img"]}' ";
			}
			$strSQL = $strSQL.$strSQL2;
			$strSQL .= "  WHERE as_id = {$this->admissiondat[0]["as_id"]} ";
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
			$this->php_error = "basedb_InsAdmission(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdAdmission () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdAdmission(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_admission ";
		$strSQL .= "  WHERE as_id = {$this->admissiondat[0]["as_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
			$this->php_error = "basedb_UpdAdmission(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->admissiondat[0]["as_id"] != $arr["as_id"] ) {
//echo("##1##upd##");
			$this->php_error = "basedb_UpdAdmission(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->admissiondat[0]["as_clid"] != $arr["as_clid"] ) {
//echo("##2##upd##");
			$this->php_error = "basedb_UpdAdmission(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->admissiondat[0]["as_upddate"] != $arr["as_upddate"] ) {
//echo("##3##upd##");
			$this->php_error = "basedb_UpdAdmission(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		//  表示順重複チェック
		if($this->admissiondat[0]["as_stat"]==1){
			$strSQL = "";
			$strSQL .= " SELECT * FROM t_admission ";
			$strSQL .= "  WHERE as_dispno = '{$this->admissiondat[0]["as_dispno"]}' ";
			$strSQL .= "    AND as_deldate is null ";
			$strSQL .= "    AND as_stat <> 9 ";
			$strSQL .= "    AND as_clid = '{$this->admissiondat[0]["as_clid"]}' ";
			$strSQL .= "    AND as_cgid = '{$this->admissiondat[0]["as_cgid"]}' ";
			$strSQL .= "    AND as_id <> '{$this->admissiondat[0]["as_id"]}' ";
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

		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_admission ";
		$strSQL .= "    SET ";
		if($this->admissiondat[0]["as_clid"] != ""){
			$strSQL .= "        as_clid = {$this->admissiondat[0]["as_clid"]} , ";
		}else{
			$strSQL .= "        as_clid = NULL , ";
		}
		if($this->admissiondat[0]["as_stat"] != ""){
			$strSQL .= "        as_stat = {$this->admissiondat[0]["as_stat"]} , ";
		}else{
			$strSQL .= "        as_stat = NULL , ";
		}
		if($this->admissiondat[0]["as_cgid"] != ""){
			$strSQL .= "        as_cgid = {$this->admissiondat[0]["as_cgid"]} , ";
		}else{
			$strSQL .= "        as_cgid = NULL , ";
		}
		$strSQL .= "        as_title = '{$this->admissiondat[0]["as_title"]}' , ";
		$strSQL .= "        as_contents = '{$this->admissiondat[0]["as_contents"]}' , ";
		if($this->admissiondat[0]["as_img_del_chk"] == 1){
			$strSQL .= "        as_img = NULL , ";
		}else if($this->admissiondat[0]["as_img"] != ""){
			$strSQL .= "        as_img = '{$this->admissiondat[0]["as_img"]}' , ";
		}
		if($this->admissiondat[0]["as_img_del_chk"] == 1){
			$strSQL .= "        as_imgorg = NULL , ";
		}else if($this->admissiondat[0]["as_imgorg"] != ""){
			$strSQL .= "        as_imgorg = '{$this->admissiondat[0]["as_imgorg"]}' , ";
		}
		if($this->admissiondat[0]["as_dispno"] != ""){
			$strSQL .= "        as_dispno = {$this->admissiondat[0]["as_dispno"]} , ";
		}else{
			$strSQL .= "        as_dispno = NULL , ";
		}
		$strSQL .= "        as_upddate = 'now' ";
		$strSQL .= "  WHERE as_id = {$this->admissiondat[0]["as_id"]} ";
	//echo "AdmissionUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdAdmission(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdAdmission(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdAdmission(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 削除処理
	-----------------------------------------------------*/
	function basedb_DelAdmission ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelAdmission(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_admission ";
		$strSQL .= "  WHERE as_id = {$this->admissiondat[0]["as_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelAdmission(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->admissiondat[0]["as_id"] != $arr["as_id"] ) {
			$this->php_error = "basedb_DelAdmission(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE t_admission ";
				$strSQL .= "    SET as_deldate = 'now' ";
				$strSQL .= "  WHERE as_id = '{$this->admissiondat[0]["as_id"]}' ";
			//echo "AdmissionDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelAdmission(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM t_admission ";
				$strSQL .= "  WHERE as_id = '{$this->admissiondat[0]["as_id"]}'";
			//echo "AdmissionDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelAdmission(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelAdmission(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelAdmission(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


	/*-----------------------------------------------------
	    次のシリアルナンバー - 検索
	-----------------------------------------------------*/
	function basedb_SerialAdmission () {
		
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
		$strSQL = " SELECT last_value FROM t_admission_as_id_seq ";

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
				$this->admissiondat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}

		$this->admissiondat[0]["last_value"]++;

		return ( $this->admissiondat[0]["last_value"] );
		
	}

}
?>
