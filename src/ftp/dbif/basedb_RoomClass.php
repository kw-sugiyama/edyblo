<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_RoomClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $roomdat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_RoomClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->roomdat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetRoom ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetRoom(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["room_id"] != "" )       $sql_where .= " AND room_id = '{$this->jyoken["room_id"]}' ";
		if( $this->jyoken["room_build_id"] != "" )    $sql_where .= " AND room_build_id = '{$this->jyoken["room_build_id"]}' ";
		if( $this->jyoken["room_cate_id"] != "" )    $sql_where .= " AND room_cate_id = '{$this->jyoken["room_cate_id"]}' ";
		if( $this->jyoken["room_code"] != "" )    $sql_where .= " AND room_code = '{$this->jyoken["room_code"]}' ";
		if( $this->jyoken["room_madori"] != "" )    $sql_where .= " AND room_madori = '{$this->jyoken["room_madori"]}' ";
		if( $this->jyoken["room_madori_detail"] != "" )    $sql_where .= " AND room_madori_detail = '{$this->jyoken["room_madori_detail"]}' ";
		if( $this->jyoken["room_price"] != "" )    $sql_where .= " AND room_price = '{$this->jyoken["room_price"]}' ";
		if( $this->jyoken["room_cntrl_price"] != "" )    $sql_where .= " AND room_cntrl_price = '{$this->jyoken["room_cntrl_price"]}' ";
		if( $this->jyoken["room_siki"] != "" )    $sql_where .= " AND room_siki = '{$this->jyoken["room_siki"]}' ";
		if( $this->jyoken["room_rei"] != "" )    $sql_where .= " AND room_rei = '{$this->jyoken["room_rei"]}' ";
		if( $this->jyoken["room_syou"] != "" )    $sql_where .= " AND room_syou = '{$this->jyoken["room_syou"]}' ";
		if( $this->jyoken["room_sikibiki"] != "" )    $sql_where .= " AND room_sikibiki = '{$this->jyoken["room_sikibiki"]}' ";
		if( $this->jyoken["room_sec_price"] != "" )    $sql_where .= " AND room_sec_price = '{$this->jyoken["room_sec_price"]}' ";
		if( $this->jyoken["room_contract"] != "" )    $sql_where .= " AND room_contract = '{$this->jyoken["room_contract"]}' ";
		if( $this->jyoken["room_upd_price"] != "" )    $sql_where .= " AND room_upd_price = '{$this->jyoken["room_upd_price"]}' ";
		if( $this->jyoken["room_upd_year"] != "" )    $sql_where .= " AND room_upd_year = '{$this->jyoken["room_upd_year"]}' ";
		if( $this->jyoken["room_area"] != "" )    $sql_where .= " AND room_area = '{$this->jyoken["room_area"]}' ";
		if( $this->jyoken["room_floor"] != "" )    $sql_where .= " AND room_floor = '{$this->jyoken["room_floor"]}' ";
		if( $this->jyoken["room_face"] != "" )    $sql_where .= " AND room_face = '{$this->jyoken["room_face"]}' ";
		if( $this->jyoken["room_layout_img"] != "" )    $sql_where .= " AND room_layout_img = '{$this->jyoken["room_layout_img"]}' ";
		if( $this->jyoken["room_layout_img_org"] != "" )    $sql_where .= " AND room_layout_img_org = '{$this->jyoken["room_layout_img_org"]}' ";
		if( $this->jyoken["room_other_img_1"] != "" )    $sql_where .= " AND room_other_img_1 = '{$this->jyoken["room_other_img_1"]}' ";
		if( $this->jyoken["room_other_img_org_1"] != "" )    $sql_where .= " AND room_other_img_org_1 = '{$this->jyoken["room_other_img_org_1"]}' ";
		if( $this->jyoken["room_other_img_2"] != "" )    $sql_where .= " AND room_other_img_2 = '{$this->jyoken["room_other_img_2"]}' ";
		if( $this->jyoken["room_other_img_org_2"] != "" )    $sql_where .= " AND room_other_img_org_2 = '{$this->jyoken["room_other_img_org_2"]}' ";
		if( $this->jyoken["room_other_img_3"] != "" )    $sql_where .= " AND room_other_img_3 = '{$this->jyoken["room_other_img_3"]}' ";
		if( $this->jyoken["room_other_img_org_3"] != "" )    $sql_where .= " AND room_other_img_org_3 = '{$this->jyoken["room_other_img_org_3"]}' ";
		if( $this->jyoken["room_other_img_4"] != "" )   $sql_where .= " AND room_other_img_4 = '{$this->jyoken["room_other_img_4"]}' ";
		if( $this->jyoken["room_other_img_org_4"] != "" )    $sql_where .= " AND room_other_img_org_4 = '{$this->jyoken["room_other_img_org_4"]}' ";
		if( $this->jyoken["room_equip"] != "" )   $sql_where .= " AND room_equip = '{$this->jyoken["room_equip"]}' ";
		if( $this->jyoken["room_equip_other"] != "" )   $sql_where .= " AND room_equip_other = '{$this->jyoken["room_equip_other"]}' ";
		if( $this->jyoken["room_move_date"] != "" )   $sql_where .= " AND room_move_date = '{$this->jyoken["room_move_date"]}' ";
		if( $this->jyoken["room_now_move"] != "" )   $sql_where .= " AND room_now_move = '{$this->jyoken["room_now_move"]}' ";
		if( $this->jyoken["room_trade"] != "" )   $sql_where .= " AND room_trade = '{$this->jyoken["room_trade"]}' ";
		if( $this->jyoken["room_pr"] != "" )   $sql_where .= " AND room_pr = '{$this->jyoken["room_pr"]}' ";
		if( $this->jyoken["room_vacant"] != "" )   $sql_where .= " AND room_vacant = '{$this->jyoken["room_vacant"]}' ";
		if( $this->jyoken["room_disp_no"] != "" )   $sql_where .= " AND room_disp_no = '{$this->jyoken["room_disp_no"]}' ";
		if( $this->jyoken["room_flg"] != "" )   $sql_where .= " AND room_biko_3 = 1 ";
		if( $this->jyoken["room_del_date"] != "" ) $sql_where .= " AND room_del_date is NULL ";
		if( $this->jyoken["room_biko_3"] != "" )   $sql_where .= " AND ( room_biko_3 = '1' OR room_biko_3 is null ) ";
		if( $this->jyoken["room_start_date"] != "" && $this->jyoken["room_end_date"] != "" )   $sql_where .= " AND ((room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date is null) OR (room_start_date is null AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date is null AND room_end_date is null)) ";
		


		//ＳＱＬ条件作成
		if( $this->jyoken["not_room_id"] != "" )       $sql_where .= " AND room_id <> '{$this->jyoken["not_room_id"]}' ";


		if ( $this->sort["room_upd_date"] == 1 ){
			$sql_order .= " ORDER BY room_upd_date desc ";
		}else if( $this->sort["room_upd_date"] == 2 ){
			$sql_order .= " ORDER BY room_upd_date ";
		}

		$strSQL = "";
		$strSQL = " SELECT * FROM base_t_room ";
		$stmt2 = "";
		$stmt2 .= " WHERE room_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo "GetRoom_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->roomdat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(room_id) FROM base_t_room ";
		$strSQL .= $stmt2;
	//echo "GetRoom_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetRoom(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetRoom(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetRoom(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    部屋情報 - 新規登録
	-----------------------------------------------------*/
	function basedb_InsRoom () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsRoom(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE base_t_room IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsRoom(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}

		@pg_free_result( $result );
		
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO base_t_room ";
		$strSQL .= "           ( ";
		$strSQL .= "             room_build_id , ";
		$strSQL .= "             room_cate_id , ";
		$strSQL .= "             room_code , ";
		$strSQL .= "             room_madori , ";
		$strSQL .= "             room_madori_detail , ";
		$strSQL .= "             room_price , ";
		$strSQL .= "             room_cntrl_price , ";
		$strSQL .= "             room_siki , ";
		$strSQL .= "             room_rei , ";
		$strSQL .= "             room_syou , ";
		$strSQL .= "             room_sikibiki , ";
		$strSQL .= "             room_sec_price , ";
		$strSQL .= "             room_contract , ";
		$strSQL .= "             room_upd_price , ";
		$strSQL .= "             room_upd_year , ";
		$strSQL .= "             room_area , ";
		$strSQL .= "             room_floor , ";
		$strSQL .= "             room_face , ";
		$strSQL .= "             room_layout_img_org , ";
		if($this->roomdat[0]["room_other_img_org_1"] != ""){
			$strSQL .= "             room_other_img_org_1 , ";
		}
		if($this->roomdat[0]["room_other_img_org_2"] != ""){
			$strSQL .= "             room_other_img_org_2 , ";
		}
		if($this->roomdat[0]["room_other_img_org_3"] != ""){
			$strSQL .= "             room_other_img_org_3 , ";
		}
		if($this->roomdat[0]["room_other_img_org_4"] != ""){
			$strSQL .= "             room_other_img_org_4 , ";
		}
		$strSQL .= "             room_equip , ";
		$strSQL .= "             room_equip_other , ";
		$strSQL .= "             room_move_date , ";
		$strSQL .= "             room_now_move , ";
		$strSQL .= "             room_trade , ";
		$strSQL .= "             room_pr , ";
		$strSQL .= "             room_vacant , ";
		$strSQL .= "             room_biko_1 , ";
		$strSQL .= "             room_biko_2 , ";
		$strSQL .= "             room_biko_3 , ";
		$strSQL .= "             room_biko_4 , ";
		$strSQL .= "             room_biko_5 , ";
		$strSQL .= "             room_start_date , ";
		$strSQL .= "             room_end_date , ";
		$strSQL .= "             room_disp_no , ";
		$strSQL .= "             room_siki_unit , ";
		$strSQL .= "             room_rei_unit , ";
		$strSQL .= "             room_syou_unit , ";
		$strSQL .= "             room_sikibiki_unit , ";
		$strSQL .= "             room_sec_price_unit , ";
		$strSQL .= "             room_upd_price_unit , ";
		$strSQL .= "             room_cntrl_price_unit , ";
		$strSQL .= "             room_other_price , ";
		$strSQL .= "             room_admin_id , ";
		$strSQL .= "             room_ins_date , ";
		$strSQL .= "             room_upd_date";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		$strSQL .= "             '{$this->roomdat[0]["room_build_id"]}' , ";
		if($this->roomdat[0]["room_cate_id"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_cate_id"]}' , ";
		}else{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             '{$this->roomdat[0]["room_code"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_madori"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_madori_detail"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_price"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_cntrl_price"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_siki"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_rei"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_syou"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_sikibiki"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_sec_price"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_contract"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_upd_price"]}' , ";
		if($this->roomdat[0]["room_upd_year"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_upd_year"]}' , ";
		}else{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             '{$this->roomdat[0]["room_area"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_floor"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_face"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_layout_img_org"]}' , ";
		if($this->roomdat[0]["room_other_img_1_del_chk"] == 1){
			$strSQL .= "        room_other_img_org_1 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_org_1"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_other_img_org_1"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_2_del_chk"] == 1){
			$strSQL .= "        room_other_img_org_2 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_org_2"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_other_img_org_2"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_3_del_chk"] == 1){
			$strSQL .= "        room_other_img_org_3 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_org_3"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_other_img_org_3"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_4_del_chk"] == 1){
			$strSQL .= "        room_other_img_org_4 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_org_4"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_other_img_org_4"]}' , ";
		}
		$strSQL .= "             '{$this->roomdat[0]["room_equip"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_equip_other"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_move_date"]}' , ";
		if($this->roomdat[0]["room_now_move"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_now_move"]}' , ";
		}else{
			$strSQL .= "     NULL , ";
		}
		if($this->roomdat[0]["room_trade"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_trade"]}' , ";
		}else{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             '{$this->roomdat[0]["room_pr"]}' , ";
		if($this->roomdat[0]["room_vacant"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_vacant"]}' , ";
		}else{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             '{$this->roomdat[0]["room_biko_1"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_biko_2"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_biko_3"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_biko_4"]}' , ";
		$strSQL .= "             '{$this->roomdat[0]["room_biko_5"]}' , ";
		if($this->roomdat[0]["room_start_date"]!=""){
			$strSQL .= "             '{$this->roomdat[0]["room_start_date"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->roomdat[0]["room_end_date"]!=""){
			$strSQL .= "             '{$this->roomdat[0]["room_end_date"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             '{$this->roomdat[0]["room_disp_no"]}' , ";
		$strSQL .= "             {$this->roomdat[0]["room_siki_unit"]} , ";
		$strSQL .= "             {$this->roomdat[0]["room_rei_unit"]} , ";
		$strSQL .= "             {$this->roomdat[0]["room_syou_unit"]} , ";
		$strSQL .= "             {$this->roomdat[0]["room_sikibiki_unit"]} , ";
		$strSQL .= "             {$this->roomdat[0]["room_sec_price_unit"]} , ";
		$strSQL .= "             {$this->roomdat[0]["room_upd_price_unit"]} , ";
		$strSQL .= "             {$this->roomdat[0]["room_cntrl_price_unit"]} , ";
		$strSQL .= "             '{$this->roomdat[0]["room_other_price"]}' , ";
		if($this->roomdat[0]["room_admin_id"] != ""){
			$strSQL .= "     '{$this->roomdat[0]["room_admin_id"]}' , ";
		}else{
			$strSQL .= "     NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "RoomInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsRoom(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_InsRoom(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// cl_idの取得
		$result = @pg_exec( $this->conn , " SELECT currval('base_t_room_room_id_seq')" );
		IF( $result === FALSE ){
			$this->php_error = "basedb_InsRoom(7):".pg_errormessage( $result );
			$obj->dbcom_DbRollback();
			return (-1);
		}
		$this->roomdat[0]["room_id"] = @pg_result( $result , 0 , currval );
		
		
		// UP画像名を付加
		$room_layout_img = split("/",$this->roomdat[0]["room_layout_img"]);
		$this->roomdat[0]["room_layout_img"] = $room_layout_img[0].$this->roomdat[0]["room_id"].$room_layout_img[1];
		IF( $this->roomdat[0]["room_other_img_1"] != "" ){
			$room_other_img_1 = split("/",$this->roomdat[0]["room_other_img_1"]);
			$this->roomdat[0]["room_other_img_1"] = $room_other_img_1[0].$this->roomdat[0]["room_id"].$room_other_img_1[1];
		}
		IF( $this->roomdat[0]["room_other_img_2"] != "" ){
			$room_other_img_2 = split("/",$this->roomdat[0]["room_other_img_2"]);
			$this->roomdat[0]["room_other_img_2"] = $room_other_img_2[0].$this->roomdat[0]["room_id"].$room_other_img_2[1];
		}
		IF( $this->roomdat[0]["room_other_img_3"] != "" ){
			$room_other_img_3 = split("/",$this->roomdat[0]["room_other_img_3"]);
			$this->roomdat[0]["room_other_img_3"] = $room_other_img_3[0].$this->roomdat[0]["room_id"].$room_other_img_3[1];
		}
		IF( $this->roomdat[0]["room_other_img_4"] != "" ){
			$room_other_img_4 = split("/",$this->roomdat[0]["room_other_img_4"]);
			$this->roomdat[0]["room_other_img_4"] = $room_other_img_4[0].$this->roomdat[0]["room_id"].$room_other_img_4[1];
		}
		
		$strSQL2 = "";
		$strSQL2 .= "                room_layout_img = '{$this->roomdat[0]["room_layout_img"]}' ";
		if($this->roomdat[0]["room_other_img_1_del_chk"] == 1){
			$strSQL .= "        room_other_img_1 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_1"] != ""){
			IF( $strSQL2 != "" ) $strSQL2 .= " , ";
			$strSQL2 .= "        room_other_img_1 = '{$this->roomdat[0]["room_other_img_1"]}' ";
		}
		if($this->roomdat[0]["room_other_img_2_del_chk"] == 1){
			$strSQL .= "        room_other_img_2 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_2"] != ""){
			IF( $strSQL2 != "" ) $strSQL2 .= " , ";
			$strSQL2 .= "        room_other_img_2 = '{$this->roomdat[0]["room_other_img_2"]}' ";
		}
		if($this->roomdat[0]["room_other_img_3_del_chk"] == 1){
			$strSQL .= "        room_other_img_3 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_3"] != ""){
			IF( $strSQL2 != "" ) $strSQL2 .= " , ";
			$strSQL2 .= "        room_other_img_3 = '{$this->roomdat[0]["room_other_img_3"]}' ";
		}
		if($this->roomdat[0]["room_other_img_4_del_chk"] == 1){
			$strSQL .= "        room_other_img_4 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_4"] != ""){
			IF( $strSQL2 != "" ) $strSQL2 .= " , ";
			$strSQL2 .= "        room_other_img_4 = '{$this->roomdat[0]["room_other_img_4"]}' ";
		}
		
		$strSQL = "";
		$strSQL .= " UPDATE base_t_room ";
		$strSQL .= "    SET ";
		$strSQL .= $strSQL2;
		$strSQL .= "  WHERE room_id = {$this->roomdat[0]["room_id"]} ";
	//echo "RoomInsAfterUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_InsRoom(8):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
                if ( pg_cmdtuples( $result ) != 1 ) {
                        $this->php_error = "basedb_InsRoom(9):Insert Failed";
                        $obj->dbcom_DbRollback ();
                        return (-1);
                }
		@pg_free_result( $result );
		
		
		//  トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_InsRoom(10):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    部屋情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdRoom () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_UpdRoom(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_room ";
		$strSQL .= "  WHERE room_id = {$this->roomdat[0]["room_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_UpdRoom(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->roomdat[0]["room_id"] != $arr["room_id"] ) {
			$this->php_error = "basedb_UpdRoom(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->roomdat[0]["room_cl_id"] != $arr["room_cl_id"] ) {
			$this->php_error = "basedb_UpdRoom(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->roomdat[0]["room_upd_date"] != $arr["room_upd_date"] ) {
			$this->php_error = "basedb_UpdRoom(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  部屋情報修正
		$strSQL = "";
		$strSQL .= " UPDATE base_t_room ";
		$strSQL .= "    SET ";
		$strSQL .= "        room_build_id = {$this->roomdat[0]["room_build_id"]} , ";
		if($this->roomdat[0]["room_cate_id"] != ""){
			$strSQL .= "        room_cate_id = '{$this->roomdat[0]["room_cate_id"]}' , ";
		}else{
			$strSQL .= "        room_cate_id = NULL , ";
		}
		$strSQL .= "        room_code = '{$this->roomdat[0]["room_code"]}' , ";
		$strSQL .= "        room_madori = {$this->roomdat[0]["room_madori"]} , ";
		$strSQL .= "        room_madori_detail = '{$this->roomdat[0]["room_madori_detail"]}' , ";
		$strSQL .= "        room_price = '{$this->roomdat[0]["room_price"]}' , ";
		$strSQL .= "        room_cntrl_price = '{$this->roomdat[0]["room_cntrl_price"]}' , ";
		$strSQL .= "        room_siki = '{$this->roomdat[0]["room_siki"]}' , ";
		$strSQL .= "        room_rei = '{$this->roomdat[0]["room_rei"]}' , ";
		$strSQL .= "        room_syou = '{$this->roomdat[0]["room_syou"]}' , ";
		$strSQL .= "        room_sikibiki = '{$this->roomdat[0]["room_sikibiki"]}' , ";
		$strSQL .= "        room_sec_price = '{$this->roomdat[0]["room_sec_price"]}' , ";
		$strSQL .= "        room_contract = '{$this->roomdat[0]["room_contract"]}' , ";
		$strSQL .= "        room_upd_price = '{$this->roomdat[0]["room_upd_price"]}' , ";
		if($this->roomdat[0]["room_upd_year"] != ""){
			$strSQL .= "        room_upd_year = '{$this->roomdat[0]["room_upd_year"]}' , ";
		}else{
			$strSQL .= "        room_upd_year = NULL , ";
		}
		$strSQL .= "        room_area = {$this->roomdat[0]["room_area"]} , ";
		$strSQL .= "        room_floor = '{$this->roomdat[0]["room_floor"]}' , ";
		$strSQL .= "        room_face = {$this->roomdat[0]["room_face"]} , ";
		if($this->roomdat[0]["room_layout_img"] != ""){
			$strSQL .= "        room_layout_img = '{$this->roomdat[0]["room_layout_img"]}' , ";
		}
		if($this->roomdat[0]["room_layout_img_del_chk"] == 1){
			$strSQL .= "        room_layout_img_org = NULL , ";
		}else if($this->roomdat[0]["room_layout_img_org"] != ""){
			$strSQL .= "        room_layout_img_org = '{$this->roomdat[0]["room_layout_img_org"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_1_del_chk"] == 1){
			$strSQL .= "        room_other_img_1 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_1"] != ""){
			$strSQL .= "        room_other_img_1 = '{$this->roomdat[0]["room_other_img_1"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_1_del_chk"] == 1){
			$strSQL .= "        room_other_img_org_1 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_org_1"] != ""){
			$strSQL .= "        room_other_img_org_1 = '{$this->roomdat[0]["room_other_img_org_1"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_2_del_chk"] == 1){
			$strSQL .= "        room_other_img_2 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_2"] != ""){
			$strSQL .= "        room_other_img_2 = '{$this->roomdat[0]["room_other_img_2"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_2_del_chk"] == 1){
			$strSQL .= "        room_other_img_org_2 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_org_2"] != ""){
			$strSQL .= "        room_other_img_org_2 = '{$this->roomdat[0]["room_other_img_org_2"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_3_del_chk"] == 1){
			$strSQL .= "        room_other_img_3 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_3"] != ""){
			$strSQL .= "        room_other_img_3 = '{$this->roomdat[0]["room_other_img_3"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_3_del_chk"] == 1){
			$strSQL .= "        room_other_img_org_3 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_org_3"] != ""){
			$strSQL .= "        room_other_img_org_3 = '{$this->roomdat[0]["room_other_img_org_3"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_4_del_chk"] == 1){
			$strSQL .= "        room_other_img_4 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_4"] != ""){
			$strSQL .= "        room_other_img_4 = '{$this->roomdat[0]["room_other_img_4"]}' , ";
		}
		if($this->roomdat[0]["room_other_img_4_del_chk"] == 1){
			$strSQL .= "        room_other_img_org_4 = NULL , ";
		}else if($this->roomdat[0]["room_other_img_org_4"] != ""){
			$strSQL .= "        room_other_img_org_4 = '{$this->roomdat[0]["room_other_img_org_4"]}' , ";
		}
		$strSQL .= "        room_equip = '{$this->roomdat[0]["room_equip"]}' , ";
		$strSQL .= "        room_equip_other = '{$this->roomdat[0]["room_equip_other"]}' , ";
		$strSQL .= "        room_move_date = '{$this->roomdat[0]["room_move_date"]}' , ";
		if($this->roomdat[0]["room_now_move"] != ""){
			$strSQL .= "        room_now_move = {$this->roomdat[0]["room_now_move"]} , ";
		}else{
			$strSQL .= "        room_now_move = NULL , ";
		}
		if($this->roomdat[0]["room_trade"] != ""){
			$strSQL .= "        room_trade = {$this->roomdat[0]["room_trade"]} , ";
		}else{
			$strSQL .= "        room_trade = NULL , ";
		}
		$strSQL .= "        room_pr = '{$this->roomdat[0]["room_pr"]}' , ";
		if($this->roomdat[0]["room_vacant"] != ""){
			$strSQL .= "        room_vacant = {$this->roomdat[0]["room_vacant"]} , ";
		}else{
			$strSQL .= "        room_vacant = NULL , ";
		}
		$strSQL .= "        room_biko_1 = '{$this->roomdat[0]["room_biko_1"]}' , ";
		$strSQL .= "        room_biko_2 = '{$this->roomdat[0]["room_biko_2"]}' , ";
		$strSQL .= "        room_biko_3 = '{$this->roomdat[0]["room_biko_3"]}' , ";
		$strSQL .= "        room_biko_4 = '{$this->roomdat[0]["room_biko_4"]}' , ";
		$strSQL .= "        room_biko_5 = '{$this->roomdat[0]["room_biko_5"]}' , ";
		if($this->roomdat[0]["room_start_date"]!=""){
			$strSQL .= "        room_start_date = '{$this->roomdat[0]["room_start_date"]}' , ";
		}else{
			$strSQL .= "        room_start_date = NULL , ";
		}
		if($this->roomdat[0]["room_end_date"]!=""){
			$strSQL .= "        room_end_date = '{$this->roomdat[0]["room_end_date"]}' , ";
		}else{
			$strSQL .= "        room_end_date = NULL , ";
		}
		$strSQL .= "        room_disp_no = '{$this->roomdat[0]["room_disp_no"]}' , ";
		$strSQL .= "        room_siki_unit = {$this->roomdat[0]["room_siki_unit"]} , ";
		$strSQL .= "        room_rei_unit = {$this->roomdat[0]["room_rei_unit"]} , ";
		$strSQL .= "        room_syou_unit = {$this->roomdat[0]["room_syou_unit"]} , ";
		$strSQL .= "        room_sikibiki_unit = {$this->roomdat[0]["room_sikibiki_unit"]} , ";
		$strSQL .= "        room_sec_price_unit = {$this->roomdat[0]["room_sec_price_unit"]} , ";
		$strSQL .= "        room_upd_price_unit = {$this->roomdat[0]["room_upd_price_unit"]} , ";
		$strSQL .= "        room_cntrl_price_unit = {$this->roomdat[0]["room_cntrl_price_unit"]} , ";
		$strSQL .= "        room_other_price = '{$this->roomdat[0]["room_other_price"]}' , ";
		if($this->roomdat[0]["room_admin_id"] != ""){
			$strSQL .= "        room_admin_id = {$this->roomdat[0]["room_admin_id"]} , ";
		}else{
			$strSQL .= "        room_admin_id = NULL , ";
		}
		$strSQL .= "        room_upd_date = 'now' ";
		$strSQL .= "  WHERE room_id = {$this->roomdat[0]["room_id"]} ";
	//echo "RoomUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdRoom(8):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdRoom(9):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdRoom(10):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    部屋情報 - 削除処理
	-----------------------------------------------------*/
	function basedb_DelRoom ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelRoom(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM base_t_room ";
		$strSQL .= "  WHERE room_id = {$this->roomdat[0]["room_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelRoom(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->roomdat[0]["room_id"] != $arr["room_id"] ) {
			$this->php_error = "basedb_DelRoom(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE base_t_room ";
				$strSQL .= "    SET room_del_date = 'now' ";
				$strSQL .= "  WHERE room_id = '{$this->roomdat[0]["room_id"]}' ";
			//echo "RoomDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelRoom(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM base_t_room ";
				$strSQL .= "  WHERE room_id = '{$this->roomdat[0]["room_id"]}'";
			//echo "RoomDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelRoom(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelRoom(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelRoom(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}


}
?>
