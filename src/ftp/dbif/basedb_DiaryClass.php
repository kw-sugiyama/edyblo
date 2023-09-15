<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_DiaryClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $diarydat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_DiaryClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->diarydat = Array();	// ２次元連想配列
	}
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetDiary ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetDiary(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["dr_id"] != "" )       $sql_where .= " AND dr_id = {$this->jyoken["dr_id"]} ";
		if( $this->jyoken["dr_clid"] != "" )     $sql_where .= " AND dr_clid = {$this->jyoken["dr_clid"]} ";
		if( $this->jyoken["dr_scid"] != "" )     $sql_where .= " AND dr_clid = {$this->jyoken["dr_clid"]} ";
		if( $this->jyoken["dr_stat"] != "" )     $sql_where .= " AND dr_stat = {$this->jyoken["dr_stat"]} ";
		if( $this->jyoken["dr_cgid"] != "" )     $sql_where .= " AND dr_cgid = '{$this->jyoken["dr_cgid"]}' ";
		if( $this->jyoken["dr_title"] != "" )    $sql_where .= " AND dr_title = '{$this->jyoken["dr_title"]}' ";
		if( $this->jyoken["dr_contents"] != "" ) $sql_where .= " AND dr_contents = '{$this->jyoken["dr_contents"]}' ";
		if( $this->jyoken["dr_img1"] != "" )     $sql_where .= " AND dr_img1 = '{$this->jyoken["dr_img1"]}' ";
		if( $this->jyoken["dr_img2"] != "" )     $sql_where .= " AND dr_img2 = '{$this->jyoken["dr_img2"]}' ";
		if( $this->jyoken["dr_img3"] != "" )     $sql_where .= " AND dr_img3 = '{$this->jyoken["dr_img3"]}' ";
		if( $this->jyoken["dr_img4"] != "" )     $sql_where .= " AND dr_img4 = '{$this->jyoken["dr_img4"]}' ";
		if( $this->jyoken["dr_ido"] != "" )      $sql_where .= " AND dr_ido = '{$this->jyoken["dr_ido"]}' ";
		if( $this->jyoken["dr_keido"] != "" )    $sql_where .= " AND dr_keido = '{$this->jyoken["dr_keido"]}' ";
		if( $this->jyoken["dr_zoom"] != "" )     $sql_where .= " AND dr_zoom = '{$this->jyoken["dr_zoom"]}' ";
		if( $this->jyoken["dr_deldate"] != "" )  $sql_where .= " AND dr_deldate is NULL ";

		// 並び順
		$sql_order = "";
		IF( $this->sort["dr_upddate"] == 2 ){
			$sql_order = " ORDER BY dr_insdate desc ";
		}
		IF( $this->sort["dr_upddate"] == 1 ){
			$sql_order = " ORDER BY dr_insdate ";
		}
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_diary ";
		$stmt2 = "";
		$stmt2 .= " WHERE dr_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo $strSQL."<br>";
	//echo "GetDiary_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetDiary(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetDiary(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->diarydat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(dr_id) FROM t_diary ";
		$strSQL .= $stmt2;
	//echo "GetDiary_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetDiary(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetDiary(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetDiary(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 登録
	-----------------------------------------------------*/
	function basedb_InsDiary () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsDiary(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_diary IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsDiary(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_diary ";
		$strSQL .= "           ( ";
		$strSQL .= "             dr_clid , ";
		$strSQL .= "             dr_stat , ";
		$strSQL .= "             dr_cgid , ";
		$strSQL .= "             dr_tcid , ";
		$strSQL .= "             dr_title , ";
		$strSQL .= "             dr_contents , ";
		if($this->diarydat[0]["dr_imgorg1"] != ""){
			$strSQL .= "             dr_imgorg1 , ";
		}
		if($this->diarydat[0]["dr_imgorg2"] != ""){
			$strSQL .= "             dr_imgorg2 , ";
		}
		if($this->diarydat[0]["dr_imgorg3"] != ""){
			$strSQL .= "             dr_imgorg3 , ";
		}
		if($this->diarydat[0]["dr_imgorg4"] != ""){
			$strSQL .= "             dr_imgorg4 , ";
		}
		$strSQL .= "             dr_ido , ";
		$strSQL .= "             dr_keido , ";
		$strSQL .= "             dr_zoom , ";
		$strSQL .= "             dr_adminid , ";
		$strSQL .= "             dr_insdate , ";
		$strSQL .= "             dr_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->diarydat[0]["dr_clid"] != ""){
			$strSQL .= "        {$this->diarydat[0]["dr_clid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->diarydat[0]["dr_stat"] != ""){
			$strSQL .= "        {$this->diarydat[0]["dr_stat"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->diarydat[0]["dr_cgid"] != ""){
			$strSQL .= "        {$this->diarydat[0]["dr_cgid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->diarydat[0]["dr_tcid"] != ""){
			$strSQL .= "        {$this->diarydat[0]["dr_tcid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->diarydat[0]["dr_title"]}' , ";
		$strSQL .= "             '{$this->diarydat[0]["dr_contents"]}' , ";
		if($this->diarydat[0]["dr_imgorg1"] != ""){
			$strSQL .= "             '{$this->diarydat[0]["dr_imgorg1"]}' , ";
		}
		if($this->diarydat[0]["dr_imgorg2"] != ""){
			$strSQL .= "             '{$this->diarydat[0]["dr_imgorg2"]}' , ";
		}
		if($this->diarydat[0]["dr_imgorg3"] != ""){
			$strSQL .= "             '{$this->diarydat[0]["dr_imgorg3"]}' , ";
		}
		if($this->diarydat[0]["dr_imgorg4"] != ""){
			$strSQL .= "             '{$this->diarydat[0]["dr_imgorg4"]}' , ";
		}
		if($this->diarydat[0]["dr_ido"] != ""){
			$strSQL .= "        {$this->diarydat[0]["dr_ido"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->diarydat[0]["dr_keido"] != ""){
			$strSQL .= "        {$this->diarydat[0]["dr_keido"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->diarydat[0]["dr_zoom"] != ""){
			$strSQL .= "        {$this->diarydat[0]["dr_zoom"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->diarydat[0]["dr_adminid"] != ""){
			$strSQL .= "        {$this->diarydat[0]["dr_adminid"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "DiaryInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsDiary(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsDiary(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_idの取得
		$result = @pg_exec( $this->conn , " SELECT currval('t_diary_dr_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->diarydat[0]["dr_id"] = @pg_result( $result , 0 , currval );


		// 画像情報修正
		if($this->diarydat[0]["dr_img1"] != ""){
			$dr_img1 = split("/",$this->diarydat[0]["dr_img1"]);
			$this->diarydat[0]["dr_img1"] = $dr_img1[0].$this->diarydat[0]["dr_id"].$dr_img1[1];
		}
		if($this->diarydat[0]["dr_img2"] != ""){
			$dr_img2 = split("/",$this->diarydat[0]["dr_img2"]);
			$this->diarydat[0]["dr_img2"] = $dr_img2[0].$this->diarydat[0]["dr_id"].$dr_img2[1];
		}
		if($this->diarydat[0]["dr_img3"] != ""){
			$dr_img3 = split("/",$this->diarydat[0]["dr_img3"]);
			$this->diarydat[0]["dr_img3"] = $dr_img3[0].$this->diarydat[0]["dr_id"].$dr_img3[1];
		}
		if($this->diarydat[0]["dr_img4"] != ""){
			$dr_img4 = split("/",$this->diarydat[0]["dr_img4"]);
			$this->diarydat[0]["dr_img4"] = $dr_img4[0].$this->diarydat[0]["dr_id"].$dr_img4[1];
		}

		if($this->diarydat[0]["dr_img1"] != "" || $this->diarydat[0]["dr_img2"] != "" || $this->diarydat[0]["dr_img3"] != "" || $this->diarydat[0]["dr_img4"] != ""){
			$strSQL = "";
			$strSQL .= " UPDATE t_diary ";
			$strSQL .= "    SET ";
			$strSQL2 ="";
			if($this->diarydat[0]["dr_img1"] != ""){
				$strSQL2 .= "        dr_img1 = '{$this->diarydat[0]["dr_img1"]}' ";
			}
			if($this->diarydat[0]["dr_img2"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        dr_img2 = '{$this->diarydat[0]["dr_img2"]}' ";
			}
			if($this->diarydat[0]["dr_img3"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        dr_img3 = '{$this->diarydat[0]["dr_img3"]}' ";
			}
			if($this->diarydat[0]["dr_img4"] != ""){
				if($strSQL2 != "")$strSQL2 .= " , ";
				$strSQL2 .= "        dr_img4 = '{$this->diarydat[0]["dr_img4"]}' ";
			}
			$strSQL = $strSQL.$strSQL2;
			$strSQL .= "  WHERE dr_id = {$this->diarydat[0]["dr_id"]} ";
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
			$this->php_error = "basedb_InsDiary(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdDiary () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdDiary(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_diary ";
		$strSQL .= "  WHERE dr_id = {$this->diarydat[0]["dr_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo( $strSQL);
		if ( !$result ) {
			$this->php_error = "basedb_UpdDiary(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->diarydat[0]["dr_id"] != $arr["dr_id"] ) {
			$this->php_error = "basedb_UpdDiary(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->diarydat[0]["dr_clid"] != $arr["dr_clid"] ) {
			$this->php_error = "basedb_UpdDiary(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}

//echo $this->diarydat[0][dr_upddate];
//echo $arr->diarydat[0][dr_upddate];
		if ( $this->diarydat[0]["dr_upddate"] != $arr["dr_upddate"] ) {
			$this->php_error = "basedb_UpdDiary(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_diary ";
		$strSQL .= "    SET ";
		if($this->diarydat[0]["dr_clid"] != ""){
			$strSQL .= "        dr_clid = {$this->diarydat[0]["dr_clid"]} , ";
		}else{
			$strSQL .= "        dr_clid = NULL , ";
		}
		if($this->diarydat[0]["dr_stat"] != ""){
			$strSQL .= "        dr_stat = {$this->diarydat[0]["dr_stat"]} , ";
		}else{
			$strSQL .= "        dr_stat = NULL , ";
		}
		if($this->diarydat[0]["dr_cgid"] != ""){
			$strSQL .= "        dr_cgid = {$this->diarydat[0]["dr_cgid"]} , ";
		}else{
			$strSQL .= "        dr_cgid = NULL , ";
		}
		if($this->diarydat[0]["dr_tcid"] != ""){
			$strSQL .= "        dr_tcid = {$this->diarydat[0]["dr_tcid"]} , ";
		}else{
			$strSQL .= "        dr_tcid = NULL , ";
		}
		$strSQL .= "        dr_title = '{$this->diarydat[0]["dr_title"]}' , ";
		$strSQL .= "        dr_contents = '{$this->diarydat[0]["dr_contents"]}' , ";
		if($this->diarydat[0]["dr_img1_del_chk"] == 1){
			$strSQL .= "        dr_img1 = NULL , ";
		}else if($this->diarydat[0]["dr_img1"] != ""){
			$strSQL .= "        dr_img1 = '{$this->diarydat[0]["dr_img1"]}' , ";
		}
		if($this->diarydat[0]["dr_img1_del_chk"] == 1){
			$strSQL .= "        dr_imgorg1 = NULL , ";
		}else if($this->diarydat[0]["dr_imgorg1"] != ""){
			$strSQL .= "        dr_imgorg1 = '{$this->diarydat[0]["dr_imgorg1"]}' , ";
		}
		if($this->diarydat[0]["dr_img2_del_chk"] == 1){
			$strSQL .= "        dr_img2 = NULL , ";
		}else if($this->diarydat[0]["dr_img2"] != ""){
			$strSQL .= "        dr_img2 = '{$this->diarydat[0]["dr_img2"]}' , ";
		}
		if($this->diarydat[0]["dr_img2_del_chk"] == 1){
			$strSQL .= "        dr_imgorg2 = NULL , ";
		}else if($this->diarydat[0]["dr_imgorg2"] != ""){
			$strSQL .= "        dr_imgorg2 = '{$this->diarydat[0]["dr_imgorg2"]}' , ";
		}
		if($this->diarydat[0]["dr_img3_del_chk"] == 1){
			$strSQL .= "        dr_img3 = NULL , ";
		}else if($this->diarydat[0]["dr_img3"] != ""){
			$strSQL .= "        dr_img3 = '{$this->diarydat[0]["dr_img3"]}' , ";
		}
		if($this->diarydat[0]["dr_img3_del_chk"] == 1){
			$strSQL .= "        dr_imgorg3 = NULL , ";
		}else if($this->diarydat[0]["dr_imgorg3"] != ""){
			$strSQL .= "        dr_imgorg3 = '{$this->diarydat[0]["dr_imgorg3"]}' , ";
		}
		if($this->diarydat[0]["dr_img4_del_chk"] == 1){
			$strSQL .= "        dr_img4 = NULL , ";
		}else if($this->diarydat[0]["dr_img4"] != ""){
			$strSQL .= "        dr_img4 = '{$this->diarydat[0]["dr_img4"]}' , ";
		}
		if($this->diarydat[0]["dr_img4_del_chk"] == 1){
			$strSQL .= "        dr_imgorg4 = NULL , ";
		}else if($this->diarydat[0]["dr_imgorg4"] != ""){
			$strSQL .= "        dr_imgorg4 = '{$this->diarydat[0]["dr_imgorg4"]}' , ";
		}
		if($this->diarydat[0]["dr_ido"] == 1){
			$strSQL .= "        dr_ido = NULL , ";
		}else if($this->diarydat[0]["dr_ido"] != ""){
			$strSQL .= "        dr_ido = '{$this->diarydat[0]["dr_ido"]}' , ";
		}
		if($this->diarydat[0]["dr_keido"] == 1){
			$strSQL .= "        dr_keido = NULL , ";
		}else if($this->diarydat[0]["dr_keido"] != ""){
			$strSQL .= "        dr_keido = '{$this->diarydat[0]["dr_keido"]}' , ";
		}
		if($this->diarydat[0]["dr_zoom"] != ""){
			$strSQL .= "        dr_zoom = {$this->diarydat[0]["dr_zoom"]} , ";
		}else{
			$strSQL .= "        dr_zoom = NULL , ";
		}
		$strSQL .= "        dr_upddate = 'now' ";
		$strSQL .= "  WHERE dr_id = {$this->diarydat[0]["dr_id"]} ";
	//echo "DiaryUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdDiary(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdDiary(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdDiary(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 削除処理
	-----------------------------------------------------*/
	function basedb_DelDiary ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelDiary(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_diary ";
		$strSQL .= "  WHERE dr_id = {$this->diarydat[0]["dr_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelDiary(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->diarydat[0]["dr_id"] != $arr["dr_id"] ) {
			$this->php_error = "basedb_DelDiary(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE t_diary ";
				$strSQL .= "    SET dr_deldate = 'now' ";
				$strSQL .= "  WHERE dr_id = '{$this->diarydat[0]["dr_id"]}' ";
			//echo "DiaryDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelDiary(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM t_diary ";
				$strSQL .= "  WHERE dr_id = '{$this->diarydat[0]["dr_id"]}'";
			//echo "DiaryDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelDiary(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelDiary(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelDiary(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


	/*-----------------------------------------------------
	    次のシリアルナンバー - 検索
	-----------------------------------------------------*/
	function basedb_SerialDiary () {
		
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
		$strSQL = " SELECT last_value FROM t_diary_dr_id_seq ";

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
				$this->diarydat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
				
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return (-1);
		}

		$this->diarydat[0]["last_value"]++;

		return ( $this->diarydat[0]["last_value"] );
		
	}

}
?>
