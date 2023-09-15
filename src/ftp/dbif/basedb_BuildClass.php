<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_BuildClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $builddat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_BuildClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->builddat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetBuild ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetBuild(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["build_id"] != "" )       $sql_where .= " AND build_id = '{$this->jyoken["build_id"]}' ";
		if( $this->jyoken["build_cl_id"] != "" )    $sql_where .= " AND build_cl_id = '{$this->jyoken["build_cl_id"]}' ";
		if( $this->jyoken["build_name"] != "" )    $sql_where .= " AND build_name = '{$this->jyoken["build_name"]}' ";
		if( $this->jyoken["build_name_disp"] != "" )    $sql_where .= " AND build_name_disp = '{$this->jyoken["build_name_disp"]}' ";
		if( $this->jyoken["build_address"] != "" )    $sql_where .= " AND build_address = '{$this->jyoken["build_address"]}' ";
		if( $this->jyoken["build_zip"] != "" )    $sql_where .= " AND build_zip = '{$this->jyoken["build_zip"]}' ";
		if( $this->jyoken["build_pref"] != "" )    $sql_where .= " AND build_pref = '{$this->jyoken["build_pref"]}' ";
		if( $this->jyoken["build_pref_cd"] != "" )    $sql_where .= " AND build_pref_cd = '{$this->jyoken["build_pref_cd"]}' ";
		if( $this->jyoken["build_address1"] != "" )    $sql_where .= " AND build_address1 = '{$this->jyoken["build_address1"]}' ";
		if( $this->jyoken["build_addr_cd"] != "" )    $sql_where .= " AND build_addr_cd = '{$this->jyoken["build_addr_cd"]}' ";
		if( $this->jyoken["build_address2"] != "" )    $sql_where .= " AND build_address2 = '{$this->jyoken["build_address2"]}' ";
		if( $this->jyoken["build_line_cd"] != "" )    $sql_where .= " AND build_line_cd = '{$this->jyoken["build_line_cd"]}' ";
		if( $this->jyoken["build_line_name_1"] != "" )    $sql_where .= " AND build_line_name_1 = '{$this->jyoken["build_line_name_1"]}' ";
		if( $this->jyoken["build_sta_cd"] != "" )    $sql_where .= " AND build_sta_cd = '{$this->jyoken["build_sta_cd"]}' ";
		if( $this->jyoken["build_sta_name_1"] != "" )    $sql_where .= " AND build_sta_name_1 = '{$this->jyoken["build_sta_name_1"]}' ";
		if( $this->jyoken["build_move_1"] != "" )    $sql_where .= " AND build_move_1 = '{$this->jyoken["build_move_1"]}' ";
		if( $this->jyoken["build_line_name_2"] != "" )    $sql_where .= " AND build_line_name_2 = '{$this->jyoken["build_line_name_2"]}' ";
		if( $this->jyoken["build_sta_name_2"] != "" )    $sql_where .= " AND build_sta_name_2 = '{$this->jyoken["build_sta_name_2"]}' ";
		if( $this->jyoken["build_move_2"] != "" )    $sql_where .= " AND build_move_2 = '{$this->jyoken["build_move_2"]}' ";
		if( $this->jyoken["build_date"] != "" )    $sql_where .= " AND build_date = '{$this->jyoken["build_date"]}' ";
		if( $this->jyoken["build_material"] != "" )    $sql_where .= " AND build_material = '{$this->jyoken["build_material"]}' ";
		if( $this->jyoken["build_all_floor"] != "" )    $sql_where .= " AND build_all_floor = '{$this->jyoken["build_all_floor"]}' ";
		if( $this->jyoken["build_type"] != "" )    $sql_where .= " AND build_type = '{$this->jyoken["build_type"]}' ";
		if( $this->jyoken["build_photo"] != "" )    $sql_where .= " AND build_photo = '{$this->jyoken["build_photo"]}' ";
		if( $this->jyoken["build_photo_org"] != "" )    $sql_where .= " AND build_photo_org = '{$this->jyoken["build_photo_org"]}' ";
		if( $this->jyoken["build_map"] != "" )    $sql_where .= " AND build_map = '{$this->jyoken["build_map"]}' ";
		if( $this->jyoken["build_disp_no"] != "" )    $sql_where .= " AND build_disp_no = '{$this->jyoken["build_disp_no"]}' ";
		if( $this->jyoken["build_update"] != "" )   $sql_where .= " AND build_update = '{$this->jyoken["build_update"]}' ";
		if( $this->jyoken["build_del_date"] != "" ) $sql_where .= " AND build_del_date is NULL ";
		if( $this->jyoken["search_build_name"] != "" )      $sql_where .= " AND build_name LIKE '%{$this->jyoken["search_build_name"]}%' ";
		if( $this->jyoken["search_address"] != "" )      $sql_where .= " AND build_address LIKE '%{$this->jyoken["search_address"]}%' ";


		// ＳＱＬソート条件作成
		if ( $this->sort["build_disp_no"] == 1 ){
			$sql_order .= " ORDER BY build_disp_no desc ";
		}else if( $this->sort["build_disp_no"] == 2 ){
			$sql_order .= " ORDER BY build_disp_no ";
		}
		if ( $this->sort["build_upd_date"] == 1 ){
			$sql_order .= " ORDER BY build_upd_date desc ";
		}else if( $this->sort["build_upd_date"] == 2 ){
			$sql_order .= " ORDER BY build_upd_date ";
		}

		
		$strSQL = "";
		$strSQL = " SELECT * FROM base_t_build ";
		$stmt2 = "";
		$stmt2 .= " WHERE build_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo "GetBuild_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetBuild(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetBuild(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->builddat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(build_id) FROM base_t_build ";
		$strSQL .= $stmt2;
	//echo "GetBuild_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetBuild(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetBuild(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetBuild(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 登録
	-----------------------------------------------------*/
	function basedb_InsBuild () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsBuild(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE base_t_build IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsBuild(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}

		@pg_free_result( $result );
		
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO base_t_build ";
		$strSQL .= "           ( ";
		$strSQL .= "             build_cl_id , ";
		$strSQL .= "             build_name , ";
		$strSQL .= "             build_name_disp , ";
		$strSQL .= "             build_address , ";
		$strSQL .= "             build_zip , ";
		$strSQL .= "             build_pref , ";
		$strSQL .= "             build_pref_cd , ";
		$strSQL .= "             build_address1 , ";
		$strSQL .= "             build_addr_cd , ";
		$strSQL .= "             build_address2 , ";
		$strSQL .= "             build_line_cd , ";
		$strSQL .= "             build_line_cd_name , ";
		$strSQL .= "             build_line_name_1 , ";
		$strSQL .= "             build_sta_cd , ";
		$strSQL .= "             build_sta_name_1 , ";
		$strSQL .= "             build_move_1 , ";
		$strSQL .= "             build_move_bus_1 , ";
		$strSQL .= "             build_line_name_2 , ";
		$strSQL .= "             build_sta_name_2 , ";
		$strSQL .= "             build_move_2 , ";
		$strSQL .= "             build_move_bus_2 , ";
		$strSQL .= "             build_date , ";
		$strSQL .= "             build_material , ";
		$strSQL .= "             build_all_floor , ";
		$strSQL .= "             build_type , ";
		$strSQL .= "             build_photo_org , ";
		$strSQL .= "             build_map , ";
		$strSQL .= "             build_pr , ";
		$strSQL .= "             build_biko_1 , ";
		$strSQL .= "             build_disp_no , ";
		$strSQL .= "             build_admin_id , ";
		$strSQL .= "             build_ins_date , ";
		$strSQL .= "             build_upd_date";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->builddat[0]["build_cl_id"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_name"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_name_disp"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_address"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_zip"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_pref"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_pref_cd"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_address1"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_addr_cd"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_address2"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_line_cd"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_line_cd_name"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_line_name_1"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_sta_cd"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_sta_name_1"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_move_1"]}' , ";
		if($this->builddat[0]["build_move_bus_1"] != ""){
			$strSQL .= "        {$this->builddat[0]["build_move_bus_1"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->builddat[0]["build_line_name_2"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_sta_name_2"]}' , ";
		if($this->builddat[0]["build_move_2"] != ""){
			$strSQL .= "        {$this->builddat[0]["build_move_2"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->builddat[0]["build_move_bus_2"] != ""){
			$strSQL .= "        {$this->builddat[0]["build_move_bus_2"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             '{$this->builddat[0]["build_date"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_material"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_all_floor"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_type"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_photo_org"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_map"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_pr"]}' , ";
		$strSQL .= "             '{$this->builddat[0]["build_biko_1"]}' , ";
		if($this->builddat[0]["build_disp_no"] != ""){
			$strSQL .= "        {$this->builddat[0]["build_disp_no"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		if($this->builddat[0]["build_admin_id"] != ""){
			$strSQL .= "        {$this->builddat[0]["build_admin_id"]} , ";
		}else{
			$strSQL .= "        NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "BuildInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsBuild(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsBuild(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_idの取得
		$result = @pg_exec( $this->conn , " SELECT currval('base_t_build_build_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsClient(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->builddat[0]["build_id"] = @pg_result( $result , 0 , currval );

		//  管理者情報修正
		$build_photo = split("/",$this->builddat[0]["build_photo"]);
		$this->builddat[0]["build_photo"] = $build_photo[0].$this->builddat[0]["build_id"].$build_photo[1];

		$strSQL = "";
		$strSQL .= " UPDATE base_t_build ";
		$strSQL .= "    SET ";
		if($this->builddat[0]["build_photo"] != ""){
			$strSQL .= "        build_photo = '{$this->builddat[0]["build_photo"]}' ";
		}
		$strSQL .= "  WHERE build_id = {$this->builddat[0]["build_id"]} ";
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
		
		//  トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsBuild(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdBuild () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdBuild(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_build ";
		$strSQL .= "  WHERE build_id = {$this->builddat[0]["build_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_UpdBuild(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->builddat[0]["build_id"] != $arr["build_id"] ) {
			$this->php_error = "basedb_UpdBuild(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->builddat[0]["build_cl_id"] != $arr["build_cl_id"] ) {
			$this->php_error = "basedb_UpdBuild(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->builddat[0]["build_upd_date"] != $arr["build_upd_date"] ) {
			$this->php_error = "basedb_UpdBuild(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}

		@pg_free_result( $result );
		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE base_t_build ";
		$strSQL .= "    SET ";
		$strSQL .= "        build_cl_id = '{$this->builddat[0]["build_cl_id"]}' , ";
		$strSQL .= "        build_name = '{$this->builddat[0]["build_name"]}' , ";
		$strSQL .= "        build_name_disp = '{$this->builddat[0]["build_name_disp"]}' , ";
		$strSQL .= "        build_address = '{$this->builddat[0]["build_address"]}' , ";
		$strSQL .= "        build_zip = '{$this->builddat[0]["build_zip"]}' , ";
		$strSQL .= "        build_pref = '{$this->builddat[0]["build_pref"]}' , ";
		if($this->builddat[0]["build_pref_cd"] != ""){
			$strSQL .= "        build_pref_cd = {$this->builddat[0]["build_pref_cd"]} , ";
		}else{
			$strSQL .= "        build_pref_cd = NULL , ";
		}
		$strSQL .= "        build_address1 = '{$this->builddat[0]["build_address1"]}' , ";
		if($this->builddat[0]["build_addr_cd"] != ""){
			$strSQL .= "        build_addr_cd = {$this->builddat[0]["build_addr_cd"]} , ";
		}else{
			$strSQL .= "        build_addr_cd = NULL , ";
		}
		$strSQL .= "        build_address2 = '{$this->builddat[0]["build_address2"]}' , ";
		$strSQL .= "        build_line_cd = '{$this->builddat[0]["build_line_cd"]}' , ";
		$strSQL .= "        build_line_cd_name = '{$this->builddat[0]["build_line_cd_name"]}' , ";
		$strSQL .= "        build_sta_cd = '{$this->builddat[0]["build_sta_cd"]}' , ";
		$strSQL .= "        build_line_name_1 = '{$this->builddat[0]["build_line_name_1"]}' , ";
		$strSQL .= "        build_sta_name_1 = '{$this->builddat[0]["build_sta_name_1"]}' , ";
		if($this->builddat[0]["build_move_1"] != ""){
			$strSQL .= "        build_move_1 = {$this->builddat[0]["build_move_1"]} , ";
		}else{
			$strSQL .= "        build_move_1 = NULL , ";
		}
		if($this->builddat[0]["build_move_bus_1"] != ""){
			$strSQL .= "        build_move_bus_1 = {$this->builddat[0]["build_move_bus_1"]} , ";
		}else{
			$strSQL .= "        build_move_bus_1 = NULL , ";
		}
		$strSQL .= "        build_line_name_2 = '{$this->builddat[0]["build_line_name_2"]}' , ";
		$strSQL .= "        build_sta_name_2 = '{$this->builddat[0]["build_sta_name_2"]}' , ";
		if($this->builddat[0]["build_move_2"] != ""){
			$strSQL .= "        build_move_2 = {$this->builddat[0]["build_move_2"]} , ";
		}else{
			$strSQL .= "        build_move_2 = NULL , ";
		}
		if($this->builddat[0]["build_move_bus_2"] != ""){
			$strSQL .= "        build_move_bus_2 = {$this->builddat[0]["build_move_bus_2"]} , ";
		}else{
			$strSQL .= "        build_move_bus_2 = NULL , ";
		}
		if($this->builddat[0]["build_date"] != ""){
			$strSQL .= "        build_date = {$this->builddat[0]["build_date"]} , ";
		}else{
			$strSQL .= "        build_date = NULL , ";
		}
		$strSQL .= "        build_material = '{$this->builddat[0]["build_material"]}' , ";
		if($this->builddat[0]["build_all_floor"] != ""){
			$strSQL .= "        build_all_floor = {$this->builddat[0]["build_all_floor"]} , ";
		}else{
			$strSQL .= "        build_all_floor = NULL , ";
		}
		if($this->builddat[0]["build_type"] != ""){
			$strSQL .= "        build_type = {$this->builddat[0]["build_type"]} , ";
		}else{
			$strSQL .= "        build_type = NULL , ";
		}
		if($this->builddat[0]["build_photo"] != ""){
			$strSQL .= "        build_photo = '{$this->builddat[0]["build_photo"]}' , ";
		}
		if($this->builddat[0]["build_photo_org"] != ""){
			$strSQL .= "        build_photo_org = '{$this->builddat[0]["build_photo_org"]}' , ";
		}
		if($this->builddat[0]["build_map"] != ""){
			$strSQL .= "        build_map = '{$this->builddat[0]["build_map"]}' , ";
		}
		$strSQL .= "        build_pr = '{$this->builddat[0]["build_pr"]}' , ";
		$strSQL .= "        build_biko_1 = '{$this->builddat[0]["build_biko_1"]}' , ";
		if($this->builddat[0]["build_disp_no"] != ""){
			$strSQL .= "        build_disp_no = {$this->builddat[0]["build_disp_no"]} , ";
		}else{
			$strSQL .= "        build_disp_no = NULL , ";
		}
		if($this->builddat[0]["build_admin_id"] != ""){
			$strSQL .= "        build_admin_id = {$this->builddat[0]["build_admin_id"]} , ";
		}else{
			$strSQL .= "        build_admin_id = NULL , ";
		}
		$strSQL .= "        build_upd_date = 'now' ";
		$strSQL .= "  WHERE build_id = {$this->builddat[0]["build_id"]} ";
	//echo "BuildUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdBuild(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdBuild(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdBuild(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 削除処理
	-----------------------------------------------------*/
	function basedb_DelBuild ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelBuild(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_build ";
		$strSQL .= "  WHERE build_id = {$this->builddat[0]["build_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelBuild(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->builddat[0]["build_id"] != $arr["build_id"] ) {
			$this->php_error = "basedb_DelBuild(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE base_t_build ";
				$strSQL .= "    SET build_del_date = 'now' ";
				$strSQL .= "  WHERE build_id = '{$this->builddat[0]["build_id"]}' ";
			//echo "BuildDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelBuild(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM base_t_build ";
				$strSQL .= "  WHERE build_id = '{$this->builddat[0]["build_id"]}'";
			//echo "BuildDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelBuild(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelBuild(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelBuild(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


}

?>
