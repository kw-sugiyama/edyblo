<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_BlogClassTblAccess extends dbcom_DBcontroll {
	
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
	function basedb_GetBlog ( $stpos , $getnum ) {
		
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
		if( $this->jyoken["blog_id"] != "" )       $sql_where .= " AND blog_id = '{$this->jyoken["blog_id"]}' ";
		if( $this->jyoken["blog_stat"] != "" )     $sql_where .= " AND blog_stat = '{$this->jyoken["blog_stat"]}' ";
		if( $this->jyoken["blog_cl_id"] != "" )    $sql_where .= " AND blog_cl_id = '{$this->jyoken["blog_cl_id"]}' ";
		if( $this->jyoken["blog_update"] != "" )   $sql_where .= " AND blog_update = '{$this->jyoken["blog_update"]}' ";
		if( $this->jyoken["blog_del_date"] != "" ) $sql_where .= " AND blog_del_date is NULL ";
		
		$strSQL = "";
		$strSQL = " SELECT * FROM base_t_blog ";
		$stmt2 = "";
		$stmt2 .= " WHERE blog_id is NOT NULL ";
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
		$strSQL .= " SELECT count(blog_id) FROM base_t_blog ";
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
	function basedb_InsBlog () {
		
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
		$strSQL .= " LOCK TABLE base_t_blog IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsBlog(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO base_t_blog ";
		$strSQL .= "           ( ";
		$strSQL .= "             blog_cl_id , ";
		$strSQL .= "             blog_stat , ";
		$strSQL .= "             blog_admin_id , ";
		$strSQL .= "             blog_ins_date , ";
		$strSQL .= "             blog_upd_date";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->blogdat[0]["blog_cl_id"]}' , ";
		$strSQL .= "             '{$this->blogdat[0]["blog_stat"]}' , ";
		$strSQL .= "             '{$this->blogdat[0]["blog_admin_id"]}' , ";
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "BlogInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsBlog(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsBlog(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsBlog(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdBlog () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdBlog(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_blog ";
		$strSQL .= "  WHERE blog_id = {$this->blogdat[0]["blog_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_UpdBlog(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->blogdat[0]["blog_id"] != $arr["blog_id"] ) {
			$this->php_error = "basedb_UpdBlog(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->blogdat[0]["blog_cl_id"] != $arr["blog_cl_id"] ) {
			$this->php_error = "basedb_UpdBlog(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->blogdat[0]["blog_upd_date"] != $arr["blog_upd_date"] ) {
			$this->php_error = "basedb_UpdBlog(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE base_t_blog ";
		$strSQL .= "    SET ";
		$strSQL .= "        blog_stat = '{$this->blogdat[0]["blog_stat"]}' , ";
		$strSQL .= "        blog_title = '{$this->blogdat[0]["blog_title"]}' , ";
		$strSQL .= "        blog_keyword = '{$this->blogdat[0]["blog_keyword"]}' , ";
		$strSQL .= "        blog_discription = '{$this->blogdat[0]["blog_discription"]}' , ";
		$strSQL .= "        blog_layout = '{$this->blogdat[0]["blog_layout"]}' , ";
		$strSQL .= "        blog_update = 'now' , ";
		$strSQL .= "        blog_line = '{$this->blogdat[0]["blog_line"]}' , ";
		$strSQL .= "        blog_line_cd = '{$this->blogdat[0]["blog_line_cd"]}' , ";
		$strSQL .= "        blog_line_cd_name = '{$this->blogdat[0]["blog_line_cd_name"]}' , ";
		$strSQL .= "        blog_station = '{$this->blogdat[0]["blog_station"]}' , ";
		$strSQL .= "        blog_station_cd = '{$this->blogdat[0]["blog_station_cd"]}' , ";
		$strSQL .= "        blog_move = '{$this->blogdat[0]["blog_move"]}' , ";
		if($this->blogdat[0]["blog_move_bus"] != ""){
			$strSQL .= "        blog_move_bus = {$this->blogdat[0]["blog_move_bus"]} , ";
		}else{
			$strSQL .= "        blog_move_bus = NULL , ";
		}

		$strSQL .= "        blog_line2 = '{$this->blogdat[0]["blog_line2"]}' , ";
		$strSQL .= "        blog_line_cd2 = '{$this->blogdat[0]["blog_line_cd2"]}' , ";
		$strSQL .= "        blog_line_cd_name2 = '{$this->blogdat[0]["blog_line_cd_name2"]}' , ";
		$strSQL .= "        blog_station2 = '{$this->blogdat[0]["blog_station2"]}' , ";
		if($this->blogdat[0]["blog_station_cd2"] != ""){
			$strSQL .= "        blog_station_cd2 = {$this->blogdat[0]["blog_station_cd2"]} , ";
		}else{
			$strSQL .= "        blog_station_cd2 = NULL , ";
		}
		if($this->blogdat[0]["blog_move2"] != ""){
			$strSQL .= "        blog_move2 = {$this->blogdat[0]["blog_move2"]} , ";
		}else{
			$strSQL .= "        blog_move2 = NULL , ";
		}
		if($this->blogdat[0]["blog_move_bus2"] != ""){
			$strSQL .= "        blog_move_bus2 = {$this->blogdat[0]["blog_move_bus2"]} , ";
		}else{
			$strSQL .= "        blog_move_bus2 = NULL , ";
		}

		$strSQL .= "        blog_start_time = '{$this->blogdat[0]["blog_start_time"]}' , ";
		$strSQL .= "        blog_end_time = '{$this->blogdat[0]["blog_end_time"]}' , ";
		$strSQL .= "        blog_holiday = '{$this->blogdat[0]["blog_holiday"]}' , ";
		$strSQL .= "        blog_homepage = '{$this->blogdat[0]["blog_homepage"]}' , ";
		$strSQL .= "        blog_entry_mail = '{$this->blogdat[0]["blog_entry_mail"]}' , ";
		$strSQL .= "        blog_info_mail = '{$this->blogdat[0]["blog_info_mail"]}' , ";
		$strSQL .= "        blog_request_mail = '{$this->blogdat[0]["blog_request_mail"]}' , ";
		if($this->blogdat[0]["blog_cl_logo"] != "" && $this->blogdat[0]["blog_cl_logo_del_chk"] != 1){
			$strSQL .= "        blog_cl_logo = '{$this->blogdat[0]["blog_cl_logo"]}' , ";
		}
		if($this->blogdat[0]["blog_cl_logo_del_chk"] == 1){
			$strSQL .= "        blog_cl_logo = NULL , ";
		}
		if($this->blogdat[0]["blog_cl_photo"] != "" && $this->blogdat[0]["blog_cl_photo_del_chk"] != 1){
			$strSQL .= "        blog_cl_photo = '{$this->blogdat[0]["blog_cl_photo"]}' , ";
		}
		if($this->blogdat[0]["blog_cl_photo_del_chk"] == 1){
			$strSQL .= "        blog_cl_photo = NULL , ";
		}
		if($this->blogdat[0]["blog_cl_staff_photo"] != "" && $this->blogdat[0]["blog_cl_staff_photo_del_chk"] != 1){
			$strSQL .= "        blog_cl_staff_photo = '{$this->blogdat[0]["blog_cl_staff_photo"]}' , ";
		}
		if($this->blogdat[0]["blog_cl_staff_photo_del_chk"] == 1){
			$strSQL .= "        blog_cl_staff_photo = NULL , ";
		}
		if($this->blogdat[0]["blog_cl_logo_org"] != "" && $this->blogdat[0]["blog_cl_logo_del_chk"] != 1){
			$strSQL .= "        blog_cl_logo_org = '{$this->blogdat[0]["blog_cl_logo_org"]}' , ";
		}
		if($this->blogdat[0]["blog_cl_logo_del_chk"] == 1){
			$strSQL .= "        blog_cl_logo_org = NULL , ";
		}
		if($this->blogdat[0]["blog_cl_photo_org"] != "" && $this->blogdat[0]["blog_cl_photo_del_chk"] != 1){
			$strSQL .= "        blog_cl_photo_org = '{$this->blogdat[0]["blog_cl_photo_org"]}' , ";
		}
		if($this->blogdat[0]["blog_cl_photo_del_chk"] == 1){
			$strSQL .= "        blog_cl_photo_org = NULL , ";
		}
		if($this->blogdat[0]["blog_cl_staff_photo_org"] != "" && $this->blogdat[0]["blog_cl_staff_photo_del_chk"] == 1){
			$strSQL .= "        blog_cl_staff_photo_org = '{$this->blogdat[0]["blog_cl_staff_photo_org"]}' , ";
		}
		if($this->blogdat[0]["blog_cl_staff_photo_del_chk"] == 1){
			$strSQL .= "        blog_cl_staff_photo_org = NULL , ";
		}
		$strSQL .= "        blog_cl_movie = '{$this->blogdat[0]["blog_cl_movie"]}' , ";
		$strSQL .= "        blog_cl_pr = '{$this->blogdat[0]["blog_cl_pr"]}' , ";
		$strSQL .= "        blog_cl_free_html = '{$this->blogdat[0]["blog_cl_free_html"]}' , ";
		$strSQL .= "        blog_biko_3 = '{$this->blogdat[0]["blog_biko_3"]}' , ";
		if($this->blogdat[0]["blog_cl_map"] != ""){
			$strSQL .= "        blog_cl_map = '{$this->blogdat[0]["blog_cl_map"]}' , ";
		}
		$strSQL .= "        blog_cl_build_no = '{$this->blogdat[0]["blog_cl_build_no"]}' , ";
		$strSQL .= "        blog_cl_kojin = '{$this->blogdat[0]["blog_cl_kojin"]}' , ";
		$strSQL .= "        blog_cl_assign_group = '{$this->blogdat[0]["blog_cl_assign_group"]}' , ";
		$strSQL .= "        blog_cl_security_group = '{$this->blogdat[0]["blog_cl_security_group"]}' , ";
		$strSQL .= "        blog_biko_1 = '{$this->blogdat[0]["blog_biko_1"]}' , ";
		$strSQL .= "        blog_biko_2 = '{$this->blogdat[0]["blog_biko_2"]}' , ";
		if($this->blogdat[0]["blog_admin_id"] != ""){
			$strSQL .= "        blog_admin_id = {$this->blogdat[0]["blog_admin_id"]} , ";
		}else{
			$strSQL .= "        blog_admin_id = NULL , ";
		}
		$strSQL .= "        blog_upd_date = 'now' ";
		$strSQL .= "  WHERE blog_id = {$this->blogdat[0]["blog_id"]} ";
		$strSQL .= "    AND blog_cl_id = {$this->blogdat[0]["blog_cl_id"]} ";
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
	function basedb_DelBlog ($mode) {
		
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
		$strSQL .= " SELECT * FROM base_t_blog ";
		$strSQL .= "  WHERE blog_id = {$this->blogdat[0]["blog_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelBlog(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->blogdat[0]["blog_id"] != $arr["blog_id"] ) {
			$this->php_error = "basedb_DelBlog(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE base_t_blog ";
				$strSQL .= "    SET blog_del_date = 'now' ";
				$strSQL .= "  WHERE blog_id = '{$this->blogdat[0]["blog_id"]}' ";
				$strSQL .= "    AND blog_cl_id = '{$this->blogdat[0]["blog_cl_id"]}' ";
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
				$strSQL .= " DELETE FROM base_t_blog ";
				$strSQL .= "  WHERE blog_id = '{$this->blogdat[0]["blog_id"]}'";
				$strSQL .= "    AND blog_cl_id = '{$this->blogdat[0]["blog_cl_id"]}' ";
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
