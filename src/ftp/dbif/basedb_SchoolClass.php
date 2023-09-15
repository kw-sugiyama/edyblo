<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_SchoolClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $blogdat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_BlogClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->blogdat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetSchool ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetBlog(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["sc_id"] != "" )       $sql_where .= " AND sc_id = '{$this->jyoken["sc_id"]}' ";
		if( $this->jyoken["sc_stat"] != "" )     $sql_where .= " AND sc_stat = '{$this->jyoken["sc_stat"]}' ";
		if( $this->jyoken["sc_clid"] != "" )    $sql_where .= " AND sc_clid = '{$this->jyoken["sc_clid"]}' ";
		if( $this->jyoken["sc_upddate"] != "" )   $sql_where .= " AND sc_upddate = '{$this->jyoken["sc_upddate"]}' ";
		if( $this->jyoken["sc_deldate"] != "" ) $sql_where .= " AND sc_deldate is NULL ";
		
		$strSQL = "";
		$strSQL = " SELECT * FROM t_school ";
		$stmt2 = "";
		$stmt2 .= " WHERE sc_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo "GetBlog_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetBlog(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetBlog(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->blogdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(sc_id) FROM t_school ";
		$strSQL .= $stmt2;
	//echo "GetBlog_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetBlog(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetBlog(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBlog(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 登録
	-----------------------------------------------------*/
	function basedb_InsSchool () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsBlog(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_school IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsBlog(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_school ";
		$strSQL .= "           ( ";
		$strSQL .= "             sc_clid , ";
		$strSQL .= "             sc_stat , ";
		$strSQL .= "             sc_infomnflg , ";
		$strSQL .= "             sc_infomntitle , ";
 		$strSQL .= "             sc_infomndispno , ";
		$strSQL .= "             sc_schoolmnflg , ";
		$strSQL .= "             sc_schoolmntitle , ";
		$strSQL .= "             sc_schoolmndispno , ";
		$strSQL .= "             sc_qamnflg , ";
		$strSQL .= "             sc_qamntitle , ";
		$strSQL .= "             sc_qamndispno , ";
		$strSQL .= "             sc_admissionmnflg , ";
		$strSQL .= "             sc_admissionmntitle , ";
		$strSQL .= "             sc_admissionmndispno , ";
		$strSQL .= "             sc_adminid , ";
		$strSQL .= "             sc_insdate , ";
		$strSQL .= "             sc_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->blogdat[0]["sc_clid"]}' , ";
		$strSQL .= "             '{$this->blogdat[0]["sc_stat"]}' , ";
		$strSQL .= "             1 , ";
		$strSQL .= "             '{$this->blogdat[0]["sc_infomntitle"]}' , ";
		$strSQL .= "             1 , ";
		$strSQL .= "             1 , ";
		$strSQL .= "             '{$this->blogdat[0]["sc_schoolmntitle"]}' , ";
		$strSQL .= "             2 , ";
		$strSQL .= "             1 , ";
		$strSQL .= "             '{$this->blogdat[0]["sc_qamntitle"]}' , ";
		$strSQL .= "             3 , ";
		$strSQL .= "             1 , ";
		$strSQL .= "             '{$this->blogdat[0]["sc_admissionmntitle"]}' , ";
		$strSQL .= "             4 , ";
		$strSQL .= "             '{$this->blogdat[0]["sc_adminid"]}' , ";
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "BlogInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
echo("1");
			$this->php_error = "basedb_InsBlog(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
echo("2");
			$this->php_error = "basedb_InsBlog(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
echo("3");
			$this->php_error = "basedb_InsBlog(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdSchool () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
//echo("#SC#0#SC#");
			$this->php_error = "basedb_UpdBlog(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_school ";
		$strSQL .= "  WHERE sc_id = {$this->blogdat[0]["sc_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo($strSQL."<br>");
		if ( !$result ) {
			$this->php_error = "basedb_UpdBlog(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->blogdat[0]["sc_id"] != $arr["sc_id"] ) {
echo("#SC#1#SC#");
			$this->php_error = "basedb_UpdBlog(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->blogdat[0]["sc_clid"] != $arr["sc_clid"] ) {
echo("#SC#2#SC#");
			$this->php_error = "basedb_UpdBlog(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->blogdat[0]["sc_upddate"] != $arr["sc_upddate"] ) {
			$this->php_error = "basedb_UpdBlog(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_school ";
		$strSQL .= "    SET ";
		$strSQL .= "        sc_stat = '{$this->blogdat[0]["sc_stat"]}' , ";

		if($this->blogdat[0]["sc_infomnflg"] != ""){
			$strSQL .= "        sc_infomnflg = {$this->blogdat[0]["sc_infomnflg"]} , ";
		}else{
			$strSQL .= "        sc_infomnflg = NULL , ";
		}
		$strSQL .= "        sc_infomntitle = '{$this->blogdat[0]["sc_infomntitle"]}' , ";
		if($this->blogdat[0]["sc_infomndispno"] != ""){
			$strSQL .= "        sc_infomndispno = {$this->blogdat[0]["sc_infomndispno"]} , ";
		}else{
			$strSQL .= "        sc_infomndispno = NULL , ";
		}
		if($this->blogdat[0]["sc_schoolmnflg"] != ""){
			$strSQL .= "        sc_schoolmnflg = {$this->blogdat[0]["sc_schoolmnflg"]} , ";
		}else{
			$strSQL .= "        sc_schoolmnflg = NULL , ";
		}
		$strSQL .= "        sc_schoolmntitle = '{$this->blogdat[0]["sc_schoolmntitle"]}' , ";
		if($this->blogdat[0]["sc_schoolmndispno"] != ""){
			$strSQL .= "        sc_schoolmndispno = {$this->blogdat[0]["sc_schoolmndispno"]} , ";
		}else{
			$strSQL .= "        sc_schoolmndispno = NULL , ";
		}
		if($this->blogdat[0]["sc_qamnflg"] != ""){
			$strSQL .= "        sc_qamnflg = {$this->blogdat[0]["sc_qamnflg"]} , ";
		}else{
			$strSQL .= "        sc_qamnflg = NULL , ";
		}
		$strSQL .= "        sc_qamntitle = '{$this->blogdat[0]["sc_qamntitle"]}' , ";
		if($this->blogdat[0]["sc_qamndispno"] != ""){
			$strSQL .= "        sc_qamndispno = {$this->blogdat[0]["sc_qamndispno"]} , ";
		}else{
			$strSQL .= "        sc_qamndispno = NULL , ";
		}
		if($this->blogdat[0]["sc_admissionmnflg"] != ""){
			$strSQL .= "        sc_admissionmnflg = {$this->blogdat[0]["sc_admissionmnflg"]} , ";
		}else{
			$strSQL .= "        sc_admissionmnflg = NULL , ";
		}
		$strSQL .= "        sc_admissionmntitle = '{$this->blogdat[0]["sc_admissionmntitle"]}' , ";
		if($this->blogdat[0]["sc_admissionmndispno"] != ""){
			$strSQL .= "        sc_admissionmndispno = {$this->blogdat[0]["sc_admissionmndispno"]} , ";
		}else{
			$strSQL .= "        sc_admissionmndispno = NULL , ";
		}

		$strSQL .= "        sc_title = '{$this->blogdat[0]["sc_title"]}' , ";
		$strSQL .= "        sc_keywd = '{$this->blogdat[0]["sc_keywd"]}' , ";
		$strSQL .= "        sc_introduce = '{$this->blogdat[0]["sc_introduce"]}' , ";
		if($this->blogdat[0]["sc_clr"] != ""){
			$strSQL .= "        sc_clr = {$this->blogdat[0]["sc_clr"]} , ";
		}else{
			$strSQL .= "        sc_clr = NULL , ";
		}
		$strSQL .= "        sc_upd = 'now' , ";
		$strSQL .= "        sc_master = '{$this->blogdat[0]["sc_master"]}' , ";
		$strSQL .= "        sc_position = '{$this->blogdat[0]["sc_position"]}' , ";
		if($this->blogdat[0]["sc_age"] != ""){
			$strSQL .= "        sc_age = {$this->blogdat[0]["sc_age"]} , ";
		}else{
			$strSQL .= "        sc_age = NULL , ";
		}
		if($this->blogdat[0]["sc_classform"] != ""){
			$strSQL .= "        sc_classform = {$this->blogdat[0]["sc_classform"]} , ";
		}else{
			$strSQL .= "        sc_classform = NULL , ";
		}
		$strSQL .= "        sc_results = '{$this->blogdat[0]["sc_results"]}' , ";
		$strSQL .= "        sc_students = '{$this->blogdat[0]["sc_students"]}' , ";
		$strSQL .= "        sc_movie = '{$this->blogdat[0]["sc_movie"]}' , ";
		$strSQL .= "        sc_start = '{$this->blogdat[0]["sc_start"]}' , ";
		$strSQL .= "        sc_end = '{$this->blogdat[0]["sc_end"]}' , ";
		$strSQL .= "        sc_holiday = '{$this->blogdat[0]["sc_holiday"]}' , ";
		$strSQL .= "        sc_hp = '{$this->blogdat[0]["sc_hp"]}' , ";
		$strSQL .= "        sc_entrymail = '{$this->blogdat[0]["sc_entrymail"]}' , ";
		$strSQL .= "        sc_infomail  = '{$this->blogdat[0]["sc_infomail"]}' , ";

		$strSQL .= "        sc_infomail2 = '{$this->blogdat[0]["sc_infomail2"]}' , ";
		$strSQL .= "        sc_entrymail2 = '{$this->blogdat[0]["sc_entrymail2"]}' , ";
//================================================================================		
		if($this->blogdat[0]["sc_logo_del_chk"] == 1 || $this->blogdat[0]["sc_logo"] != "" ){
			$strSQL .= "        sc_logo = '{$this->blogdat[0]["sc_logo"]}' , ";
			$strSQL .= "        sc_logoorg = '{$this->blogdat[0]["sc_logoorg"]}' , ";
		}
//携帯ロゴ対応
		if($this->blogdat[0]["sc_logo_mobile_del_chk"] == 1 || $this->blogdat[0]["sc_logo_mobile"] != "" ){
			$strSQL .= "        sc_logo_mobile = '{$this->blogdat[0]["sc_logo_mobile"]}' , ";
			$strSQL .= "        sc_logo_mobile_org = '{$this->blogdat[0]["sc_logo_mobile_org"]}' , ";
		}
//===============================================================================		
		if($this->blogdat[0]["sc_topimg_del_chk"] == 1 || $this->blogdat[0]["sc_topimg"] != "" ){
			$strSQL .= "        sc_topimg = '{$this->blogdat[0]["sc_topimg"]}' , ";
			$strSQL .= "        sc_topimgorg = '{$this->blogdat[0]["sc_topimgorg"]}' , ";
		}
		if($this->blogdat[0]["sc_img1_del_chk"] == 1 || $this->blogdat[0]["sc_img1"] != "" ){
			$strSQL .= "        sc_img1 = '{$this->blogdat[0]["sc_img1"]}' , ";
			$strSQL .= "        sc_imgorg1 = '{$this->blogdat[0]["sc_imgorg1"]}' , ";
		}
		if($this->blogdat[0]["sc_img2_del_chk"] == 1 || $this->blogdat[0]["sc_img2"] != "" ){
			$strSQL .= "        sc_img2 = '{$this->blogdat[0]["sc_img2"]}' , ";
			$strSQL .= "        sc_imgorg2 = '{$this->blogdat[0]["sc_imgorg2"]}' , ";
		}
		if($this->blogdat[0]["sc_img3_del_chk"] == 1 || $this->blogdat[0]["sc_img3"] != "" ){
			$strSQL .= "        sc_img3 = '{$this->blogdat[0]["sc_img3"]}' , ";
			$strSQL .= "        sc_imgorg3 = '{$this->blogdat[0]["sc_imgorg3"]}' , ";
		}
		if($this->blogdat[0]["sc_img4_del_chk"] == 1 || $this->blogdat[0]["sc_img4"] != "" ){
			$strSQL .= "        sc_img4 = '{$this->blogdat[0]["sc_img4"]}' , ";
			$strSQL .= "        sc_imgorg4 = '{$this->blogdat[0]["sc_imgorg4"]}' , ";
		}
		if($this->blogdat[0]["sc_mapimg_del_chk"] == 1 || $this->blogdat[0]["sc_mapimg"] != "" ){
			$strSQL .= "        sc_mapimg = '{$this->blogdat[0]["sc_mapimg"]}' , ";
			$strSQL .= "        sc_mapimgorg = '{$this->blogdat[0]["sc_mapimgorg"]}' , ";
		}
		$strSQL .= "        sc_pr = '{$this->blogdat[0]["sc_pr"]}' , ";
		$strSQL .= "        sc_rhtml = '{$this->blogdat[0]["sc_rhtml"]}' , ";
		$strSQL .= "        sc_lhtml = '{$this->blogdat[0]["sc_lhtml"]}' , ";
		$strSQL .= "        sc_thtml = '{$this->blogdat[0]["sc_thtml"]}' , ";
		if($this->blogdat[0]["sc_ido"] != ""){
			$strSQL .= "        sc_ido = {$this->blogdat[0]["sc_ido"]} , ";
		}else{
			$strSQL .= "        sc_ido = NULL , ";
		}
		if($this->blogdat[0]["sc_keido"] != ""){
			$strSQL .= "        sc_keido = {$this->blogdat[0]["sc_keido"]} , ";
		}else{
			$strSQL .= "        sc_keido = NULL , ";
		}
		if($this->blogdat[0]["sc_zoom"] != ""){
			$strSQL .= "        sc_zoom = {$this->blogdat[0]["sc_zoom"]} , ";
		}else{
			$strSQL .= "        sc_zoom = NULL , ";
		}
		$strSQL .= "        sc_privacy = '{$this->blogdat[0]["sc_privacy"]}' , ";

		$strSQL .= "        sc_headertitle = '{$this->blogdat[0]["sc_headertitle"]}' , ";
		$strSQL .= "        sc_toptitle = '{$this->blogdat[0]["sc_toptitle"]}' , ";
		$strSQL .= "        sc_topsubtitle = '{$this->blogdat[0]["sc_topsubtitle"]}' , ";
		$strSQL .= "        sc_campaintitle = '{$this->blogdat[0]["sc_campaintitle"]}' , ";
		$strSQL .= "        sc_coursetitle = '{$this->blogdat[0]["sc_coursetitle"]}' , ";
		$strSQL .= "        sc_diarytitle = '{$this->blogdat[0]["sc_diarytitle"]}' , ";
		$strSQL .= "        sc_topwindowtitle = '{$this->blogdat[0]["sc_topwindowtitle"]}' , ";
		$strSQL .= "        sc_company = '{$this->blogdat[0]["sc_company"]}' , ";
		$strSQL .= "        sc_addmission = '{$this->blogdat[0]["sc_addmission"]}' , ";

		if($this->blogdat[0]["sc_adminid"] != ""){
			$strSQL .= "        sc_adminid = {$this->blogdat[0]["sc_adminid"]} , ";
		}else{
			$strSQL .= "        sc_adminid = NULL , ";
		}
		$strSQL .= "        sc_upddate = 'now' ";
		$strSQL .= "  WHERE sc_id = {$this->blogdat[0]["sc_id"]} ";
		$strSQL .= "    AND sc_clid = {$this->blogdat[0]["sc_clid"]} ";
	//echo "BlogUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdBlog(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdBlog(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdBlog(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ＴＯＰレイアウト - 更新処理
	-----------------------------------------------------*/
	function basedb_TopSchool () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
echo("#SC#0#SC#");
			$this->php_error = "basedb_UpdBlog(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_school ";
		$strSQL .= "  WHERE sc_id = {$this->blogdat[0]["sc_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo($strSQL."<br>");
		if ( !$result ) {
			$this->php_error = "basedb_UpdBlog(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->blogdat[0]["sc_id"] != $arr["sc_id"] ) {
echo("#SC#1#SC#");
			$this->php_error = "basedb_UpdBlog(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->blogdat[0]["sc_clid"] != $arr["sc_clid"] ) {
echo("#SC#2#SC#");
			$this->php_error = "basedb_UpdBlog(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->blogdat[0]["sc_upddate"] != $arr["sc_upddate"] ) {
			$this->php_error = "basedb_UpdBlog(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_school ";
		$strSQL .= "    SET ";
		$strSQL .= "        sc_layout1 = '{$this->blogdat[0]["sc_layout1"]}' , ";
		$strSQL .= "        sc_layout2 = '{$this->blogdat[0]["sc_layout2"]}' , ";
		$strSQL .= "        sc_layout3 = '{$this->blogdat[0]["sc_layout3"]}' , ";
		$strSQL .= "        sc_layout4 = '{$this->blogdat[0]["sc_layout4"]}' , ";
		$strSQL .= "        sc_layout5 = '{$this->blogdat[0]["sc_layout5"]}' , ";
		$strSQL .= "        sc_layout6 = '{$this->blogdat[0]["sc_layout6"]}' , ";
		$strSQL .= "        sc_layout7 = '{$this->blogdat[0]["sc_layout7"]}' , ";
		$strSQL .= "        sc_layout8 = '{$this->blogdat[0]["sc_layout8"]}' , ";
//		$strSQL .= "        sc_layout9 = '{$this->blogdat[0]["sc_layout9"]}' , ";
		$strSQL .= "        sc_upddate = 'now' ";
		$strSQL .= "  WHERE sc_id = {$this->blogdat[0]["sc_id"]} ";
		$strSQL .= "    AND sc_clid = {$this->blogdat[0]["sc_clid"]} ";
	//echo "BlogUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdBlog(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdBlog(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdBlog(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - メニュー基本情報用更新処理
	-----------------------------------------------------*/
	function basedb_MenuSchool () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
echo("#SC#0#SC#");
			$this->php_error = "basedb_UpdBlog(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_school ";
		$strSQL .= "  WHERE sc_id = {$this->blogdat[0]["sc_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo($strSQL."<br>");
		if ( !$result ) {
			$this->php_error = "basedb_UpdBlog(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->blogdat[0]["sc_id"] != $arr["sc_id"] ) {
echo("#SC#1#SC#");
			$this->php_error = "basedb_UpdBlog(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->blogdat[0]["sc_clid"] != $arr["sc_clid"] ) {
echo("#SC#2#SC#");
			$this->php_error = "basedb_UpdBlog(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->blogdat[0]["sc_upddate"] != $arr["sc_upddate"] ) {
			$this->php_error = "basedb_UpdBlog(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_school ";
		$strSQL .= "    SET ";
		$strSQL .= "        sc_infomnflg = '{$this->blogdat[0]["sc_infomnflg"]}' , ";
		$strSQL .= "        sc_infomntitle = '{$this->blogdat[0]["sc_infomntitle"]}' , ";
		$strSQL .= "        sc_infomndispno = '{$this->blogdat[0]["sc_infomndispno"]}' , ";
		$strSQL .= "        sc_schoolmnflg = '{$this->blogdat[0]["sc_schoolmnflg"]}' , ";
		$strSQL .= "        sc_schoolmntitle = '{$this->blogdat[0]["sc_schoolmntitle"]}' , ";
		$strSQL .= "        sc_schoolmndispno = '{$this->blogdat[0]["sc_schoolmndispno"]}' , ";
		$strSQL .= "        sc_qamnflg = '{$this->blogdat[0]["sc_qamnflg"]}' , ";
		$strSQL .= "        sc_qamntitle = '{$this->blogdat[0]["sc_qamntitle"]}' , ";
		$strSQL .= "        sc_qamndispno = '{$this->blogdat[0]["sc_qamndispno"]}' , ";
		$strSQL .= "        sc_admissionmnflg = '{$this->blogdat[0]["sc_admissionmnflg"]}' , ";
		$strSQL .= "        sc_admissionmntitle = '{$this->blogdat[0]["sc_admissionmntitle"]}' , ";
		$strSQL .= "        sc_admissionmndispno = '{$this->blogdat[0]["sc_admissionmndispno"]}' ";
		$strSQL .= "  WHERE sc_id = {$this->blogdat[0]["sc_id"]} ";
		$strSQL .= "    AND sc_clid = {$this->blogdat[0]["sc_clid"]} ";
	//echo "BlogUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdBlog(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdBlog(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdBlog(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 削除処理
	-----------------------------------------------------*/
	function basedb_DelSchool ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelBlog(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_school ";
		$strSQL .= "  WHERE sc_id = {$this->blogdat[0]["sc_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelBlog(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->blogdat[0]["sc_id"] != $arr["sc_id"] ) {
			$this->php_error = "basedb_DelBlog(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE t_school ";
				$strSQL .= "    SET sc_upd = 'now' ";
				$strSQL .= "  WHERE sc_id = '{$this->blogdat[0]["sc_id"]}' ";
				$strSQL .= "    AND sc_clid = '{$this->blogdat[0]["sc_clid"]}' ";
			//echo "BlogDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelBlog(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM t_school ";
				$strSQL .= "  WHERE sc_id = '{$this->blogdat[0]["sc_id"]}'";
				$strSQL .= "    AND sc_clid = '{$this->blogdat[0]["sc_clid"]}' ";
			//echo "BlogDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelBlog(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelBlog(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelBlog(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}

}
?>
