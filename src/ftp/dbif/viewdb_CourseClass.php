<?
/*****************************************************************************
	Course View DBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class viewdb_CourseClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $coursedat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function viewdb_CourseClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->coursedat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    Course View情報 - 検索
	-----------------------------------------------------*/
	function viewdb_GetCourse ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetCourse(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cs_id"] != "" )       $sql_where .= " AND cs_id = {$this->jyoken["cs_id"]} ";
		if( $this->jyoken["cs_clid"] != "" )    $sql_where .= " AND cs_clid = {$this->jyoken["cs_clid"]} ";
		if( $this->jyoken["cs_name"] != "" )    $sql_where .= " AND cs_name = '{$this->jyoken["cs_name"]}' ";
		if( $this->jyoken["cs_name_disp"] != "" )    $sql_where .= " AND cs_name_disp = '{$this->jyoken["cs_name_disp"]}' ";
		if( $this->jyoken["cs_address"] != "" )    $sql_where .= " AND cs_address = '{$this->jyoken["cs_address"]}' ";
		if( $this->jyoken["cs_zip"] != "" )    $sql_where .= " AND cs_zip = '{$this->jyoken["cs_zip"]}' ";
		if( $this->jyoken["cs_pref"] != "" )    $sql_where .= " AND cs_pref = '{$this->jyoken["cs_pref"]}' ";
		if( $this->jyoken["cs_pref_cd"] != "" )    $sql_where .= " AND cs_pref_cd = '{$this->jyoken["cs_pref_cd"]}' ";
		if( $this->jyoken["cs_address1"] != "" )    $sql_where .= " AND cs_address1 = '{$this->jyoken["cs_address1"]}' ";
		if( $this->jyoken["cs_addr_cd"] != "" )    $sql_where .= " AND cs_addr_cd = '{$this->jyoken["cs_addr_cd"]}' ";
		if( $this->jyoken["tar"] != "" )    $sql_where .= " AND cs_pref like '%{$this->jyoken["tar"]}%' ";
		if( $this->jyoken["tnk"] != "" )    $sql_where .= " AND cs_address1 like '%{$this->jyoken["tnk"]}%' ";
		if( $this->jyoken["room_start_date"] != "" && $this->jyoken["room_end_date"] != "" )   $sql_where .= " AND ((room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date is null) OR (room_start_date is null AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date is null AND room_end_date is null)) ";
		if( $this->jyoken["cs_deldate"] != "" )  $sql_where .= " AND cs_deldate is null ";

		//ＳＱＬ条件作成
		if( $this->jyoken["not_room_id"] != "" )       $sql_where .= " AND room_id <> {$this->jyoken["not_room_id"]} ";


		// ＳＱＬソート条件作成
		if ( $this->sort["cs_disp_no"] == 1 ){
			$sql_order .= " ORDER BY cs_disp_no desc ";
		}else if( $this->sort["cs_disp_no"] == 2 ){
			$sql_order .= " ORDER BY cs_disp_no ";
		}
		if ( $this->sort["cs_upddate"] == 1 ){
			$sql_order .= " ORDER BY cs_upddate desc ";
		}else if( $this->sort["cs_upddate"] == 2 ){
			$sql_order .= " ORDER BY cs_upddate ";
		}
		if ( $this->sort["cs_id"] == 1 ){
			$sql_order .= " ORDER BY cs_id desc ";
		}else if( $this->sort["cs_id"] == 2 ){
			$sql_order .= " ORDER BY cs_id ";
		}
		if ( $this->sort["room_upd_date"] != "" ){
			SWITCH( $this->sort["room_upd_date"] ){
				Case 1:
					$sql_order .= " ORDER BY room_upd_date desc ";
					break;
				Case 2:
					$sql_order .= " ORDER BY room_vacant desc , room_upd_date desc ";
					break;
			}
		}
		if ( $this->sort["search_area"] != "" ){
			$sql_order .= " ORDER BY cs_pref_cd , cs_addr_cd ";
		}
		if ( $this->sort["v_cs_move_1"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , cs_move_1 ";
		}
		if ( $this->sort["v_room_price"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , lpad(replace(room_price,'-','00000000000000000000'),20,'0') ";
		}
		if ( $this->sort["v_room_cntrl_price"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , lpad(replace(room_cntrl_price,'-','00000000000000000000'),20,'0') ";
		}
		if ( $this->sort["v_room_area"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , room_area DESC ";
		}
		if ( $this->sort["v_room_madori"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , room_madori DESC ";
		}
		if ( $this->sort["v_cs_type"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , cs_type ";
		}
		if ( $this->sort["v_cs_date"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , cs_date DESC ";
		}
		
		IF( $this->jyoken["arr_mode"] == "search_als" ){
			$strSQL = "";
			$strSQL = " SELECT cs_pref_cd,cs_addr_cd,cs_pref,cs_address1,cs_line_cd,cs_line_cd_name,cs_sta_cd,cs_sta_name_1,cs_sta_name_2 FROM v_course ";
		}ELSE IF( $this->jyoken["arr_mode"] == "search_map" ){
			$strSQL = "";
			$strSQL = " SELECT room_id,cs_map,room_cs_id,room_code,cs_photo,cs_line_name_1,cs_sta_name_1,cs_move_1,cs_move_bus_1,room_madori,room_price,room_area,room_vacant FROM v_course ";
		}ELSE{
			$strSQL = "";
			$strSQL = " SELECT * FROM v_course ";
		}
		$stmt2 = "";
		$stmt2 .= " WHERE cs_id is NOT NULL AND cl_id is not null ";
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
			$this->php_error = "viewdb_GetCourse(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetCourse(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );

		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				if($this->jyoken["arr_mode"]=="search_als"){
					if($key == "cs_pref_cd" || $key == "cs_addr_cd" || $key == "cs_pref" || $key == "cs_address1" || $key == "cs_line_cd" || $key == "cs_line_cd_name" || $key == "cs_sta_cd" || $key == "cs_sta_name_1" || $key == "cs_sta_name_2" )$this->coursedat[$curpos][$key] = $val;
				}
				$this->coursedat[$curpos][$key] = $val;
			}
			$cnt++;
		}

		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cs_id) FROM v_course ";
		$strSQL .= $stmt2;
	//echo "GetCourse_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetCourse(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetCourse(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetCourse(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}


	function viewdb_GetBiko ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetCourse(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cs_id"] != "" )       $sql_where .= " AND cs_id = {$this->jyoken["cs_id"]} ";
		if( $this->jyoken["cs_clid"] != "" )    $sql_where .= " AND cs_clid = {$this->jyoken["cs_clid"]} ";
		if( $this->jyoken["cs_name"] != "" )    $sql_where .= " AND cs_name = '{$this->jyoken["cs_name"]}' ";
		if( $this->jyoken["cs_name_disp"] != "" )    $sql_where .= " AND cs_name_disp = '{$this->jyoken["cs_name_disp"]}' ";
		if( $this->jyoken["cs_address"] != "" )    $sql_where .= " AND cs_address = '{$this->jyoken["cs_address"]}' ";
		if( $this->jyoken["cs_zip"] != "" )    $sql_where .= " AND cs_zip = '{$this->jyoken["cs_zip"]}' ";
		if( $this->jyoken["cs_pref"] != "" )    $sql_where .= " AND cs_pref = '{$this->jyoken["cs_pref"]}' ";
		if( $this->jyoken["cs_pref_cd"] != "" )    $sql_where .= " AND cs_pref_cd = '{$this->jyoken["cs_pref_cd"]}' ";
		if( $this->jyoken["cs_address1"] != "" )    $sql_where .= " AND cs_address1 = '{$this->jyoken["cs_address1"]}' ";
		if( $this->jyoken["cs_addr_cd"] != "" )    $sql_where .= " AND cs_addr_cd = '{$this->jyoken["cs_addr_cd"]}' ";
		if( $this->jyoken["tar"] != "" )    $sql_where .= " AND cs_pref like '%{$this->jyoken["tar"]}%' ";
		if( $this->jyoken["tnk"] != "" )    $sql_where .= " AND cs_address1 like '%{$this->jyoken["tnk"]}%' ";
		IF( count( $this->jyoken["fkwd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["fkwd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " AND ";
				$buffsql .= " cs_biko_1||' '||room_biko_1 like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["cs_clid_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cs_clid_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cs_clid = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pf"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pf"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cs_addr_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pref_cd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pref_cd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cs_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["line"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["line"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cs_line_cd like '%/{$val}/%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["sta"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cs_sta_cd like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		if( $this->jyoken["cs_address2"] != "" )    $sql_where .= " AND cs_address2 = '{$this->jyoken["cs_address2"]}' ";
		if( $this->jyoken["cs_line_cd"] != "" )    $sql_where .= " AND cs_line_cd = '{$this->jyoken["cs_line_cd"]}' ";
		if( $this->jyoken["cs_line_name_1"] != "" )    $sql_where .= " AND cs_line_name_1 = '{$this->jyoken["cs_line_name_1"]}' ";
		if( $this->jyoken["cs_sta_cd"] != "" )    $sql_where .= " AND cs_sta_cd = '{$this->jyoken["cs_sta_cd"]}' ";
		if( $this->jyoken["cs_sta_name_1"] != "" )    $sql_where .= " AND cs_sta_name_1 = '{$this->jyoken["cs_sta_name_1"]}' ";
		if( $this->jyoken["cs_move_1"] != "")	$sql_where .= " AND cs_move_1 = {$this->jyoken["cs_move_1"]} ";
		if( $this->jyoken["cs_move_1_search"] != "")	$sql_where .= " AND cs_move_1 <= {$this->jyoken["cs_move_1_search"]} ";
		if( $this->jyoken["cs_line_name_2"] != "" )    $sql_where .= " AND cs_line_name_2 = '{$this->jyoken["cs_line_name_2"]}' ";
		if( $this->jyoken["cs_sta_name_2"] != "" )    $sql_where .= " AND cs_sta_name_2 = '{$this->jyoken["cs_sta_name_2"]}' ";
		if( $this->jyoken["cs_move_2"] != "" )    $sql_where .= " AND cs_move_2 = '{$this->jyoken["cs_move_2"]}' ";
		if( $this->jyoken["cs_date"] != "" )    $sql_where .= " AND cs_date = '{$this->jyoken["cs_date"]}' ";
		if( $this->jyoken["cs_date_search"] != "" )    $sql_where .= " AND cs_date >= '{$this->jyoken["cs_date_search"]}' ";
		if( $this->jyoken["cs_material"] != "" )    $sql_where .= " AND cs_material = '{$this->jyoken["cs_material"]}' ";
		if( count($this->jyoken["cs_material_search"]) != 0 ){
								$sql_where .= " AND (";
								$material_cnt = 0;
								foreach($this->jyoken["cs_material_search"] as $key => $val){
			    						if($material_cnt != 0)$sql_where .= " OR";
									$sql_where .= " cs_material = '{$val}' ";
									$material_cnt++;
								}
								$sql_where .= " )";
		}
		if( $this->jyoken["cs_all_floor"] != "" )    $sql_where .= " AND cs_all_floor = '{$this->jyoken["cs_all_floor"]}' ";
		if( $this->jyoken["cs_type"] != "" )    $sql_where .= " AND cs_type = '{$this->jyoken["cs_type"]}' ";
		if( count($this->jyoken["cs_type_search"]) != 0 ){
								$sql_where .= " AND (";
								$type_cnt = 0;
								foreach($this->jyoken["cs_type_search"] as $key => $val){
			    						if($type_cnt != 0)$sql_where .= " OR";
									$sql_where .= " cs_type = '{$val}' ";
									$type_cnt++;
								}
								$sql_where .= " )";
		}
		if( $this->jyoken["cs_photo"] != "" )    $sql_where .= " AND cs_photo = '{$this->jyoken["cs_photo"]}' ";
		if( $this->jyoken["cs_photo_org"] != "" )    $sql_where .= " AND cs_photo_org = '{$this->jyoken["cs_photo_org"]}' ";
		if( $this->jyoken["cs_map"] != "" )    $sql_where .= " AND cs_map = '{$this->jyoken["cs_map"]}' ";
		if( $this->jyoken["cs_disp_no"] != "" )    $sql_where .= " AND cs_disp_no = '{$this->jyoken["cs_disp_no"]}' ";
		if( $this->jyoken["cs_update"] != "" )   $sql_where .= " AND cs_update = '{$this->jyoken["cs_update"]}' ";
		if( $this->jyoken["cs_del_date"] != "" ) $sql_where .= " AND cs_del_date is NULL ";

		if( $this->jyoken["room_id"] != "" )       $sql_where .= " AND room_id = {$this->jyoken["room_id"]} ";
		if( $this->jyoken["room_cs_id"] != "" )    $sql_where .= " AND room_cs_id = '{$this->jyoken["room_cs_id"]}' ";
		if( $this->jyoken["room_cate_id"] != "" )	$sql_where .= " AND room_cate_id LIKE '%/{$this->jyoken["room_cate_id"]}/%' ";
		if( $this->jyoken["room_code"] != "" )    $sql_where .= " AND room_code = '{$this->jyoken["room_code"]}' ";
		if( $this->jyoken["room_madori"] != "" )    $sql_where .= " AND room_madori = '{$this->jyoken["room_madori"]}' ";
		if( count($this->jyoken["room_madori_search"]) != 0 ){
								$sql_where .= " AND (";
								$madori_cnt = 0;
								foreach($this->jyoken["room_madori_search"] as $key => $val){
			    						if($madori_cnt != 0)$sql_where .= " OR";
									$sql_where .= " room_madori = '{$val}' ";
									$madori_cnt++;
								}
								$sql_where .= " )";
		}
		if( $this->jyoken["room_madori_detail"] != "" )    $sql_where .= " AND room_madori_detail = '{$this->jyoken["room_madori_detail"]}' ";
		if( $this->jyoken["room_price"] != "" )    $sql_where .= " AND room_price = '{$this->jyoken["room_price"]}' ";
		if( $this->jyoken["room_price_start_search"] != "" )    $sql_where .= " AND room_price >= {$this->jyoken["room_price_start_search"]} ";
		if( $this->jyoken["room_price_limit_search"] != "" )    $sql_where .= " AND room_price < {$this->jyoken["room_price_limit_search"]} ";
		if( $this->jyoken["room_cntrl_price"] != "" )    $sql_where .= " AND room_cntrl_price = '{$this->jyoken["room_cntrl_price"]}' ";
		if( $this->jyoken["room_siki"] != "" )    $sql_where .= " AND room_siki = {$this->jyoken["room_siki"]} ";
		if( $this->jyoken["room_rei"] != "" )    $sql_where .= " AND room_rei = {$this->jyoken["room_rei"]} ";
		if( $this->jyoken["room_sikirei"] != "" )    $sql_where .= " AND ( room_siki = '0' OR room_siki = '-' ) AND ( room_rei = '0' OR room_rei = '-' ) ";
		if( $this->jyoken["room_syou"] != "" )    $sql_where .= " AND room_syou = '{$this->jyoken["room_syou"]}' ";
		if( $this->jyoken["room_sikibiki"] != "" )    $sql_where .= " AND room_sikibiki = '{$this->jyoken["room_sikibiki"]}' ";
		if( $this->jyoken["room_sec_price"] != "" )    $sql_where .= " AND room_sec_price = '{$this->jyoken["room_sec_price"]}' ";
		if( $this->jyoken["room_contract"] != "" )    $sql_where .= " AND room_contract = '{$this->jyoken["room_contract"]}' ";
		if( $this->jyoken["room_upd_price"] != "" )    $sql_where .= " AND room_upd_price = '{$this->jyoken["room_upd_price"]}' ";
		if( $this->jyoken["room_upd_year"] != "" )    $sql_where .= " AND room_upd_year = '{$this->jyoken["room_upd_year"]}' ";
		if( $this->jyoken["room_area"] != "" )    $sql_where .= " AND room_area = '{$this->jyoken["room_area"]}' ";
		if( $this->jyoken["room_area_start_search"] != "" )    $sql_where .= " AND room_area >= '{$this->jyoken["room_area_start_search"]}' ";
		if( $this->jyoken["room_area_limit_search"] != "" )    $sql_where .= " AND room_area < '{$this->jyoken["room_area_limit_search"]}' ";
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
		if( $this->jyoken["room_del_date"] != "" ) $sql_where .= " AND room_del_date is NULL ";
		if( $this->jyoken["biko_1"] != "" ) $sql_where .= " AND cs_biko_1||' '||room_biko_1 like '%{$val}%' ";


		//ＳＱＬ条件作成
		if( $this->jyoken["not_room_id"] != "" )       $sql_where .= " AND room_id <> {$this->jyoken["not_room_id"]} ";


		// ＳＱＬソート条件作成
		if ( $this->sort["cs_disp_no"] == 1 ){
			$sql_order .= " ORDER BY cs_disp_no desc ";
		}else if( $this->sort["cs_disp_no"] == 2 ){
			$sql_order .= " ORDER BY cs_disp_no ";
		}
		if ( $this->sort["cs_id"] == 1 ){
			$sql_order .= " ORDER BY cs_id desc ";
		}else if( $this->sort["cs_id"] == 2 ){
			$sql_order .= " ORDER BY cs_id ";
		}
		if ( $this->sort["room_upd_date"] != "" ){
			SWITCH( $this->sort["room_upd_date"] ){
				Case 1:
					$sql_order .= " ORDER BY room_upd_date desc ";
					break;
				Case 2:
					$sql_order .= " ORDER BY room_vacant desc , room_upd_date desc ";
					break;
			}
		}
		if ( $this->sort["search_area"] != "" ){
			$sql_order .= " ORDER BY cs_pref_cd , cs_addr_cd ";
		}
		if ( $this->sort["v_cs_move_1"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , cs_move_1 ";
		}
		if ( $this->sort["v_room_price"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , lpad(replace(room_price,'-','00000000000000000000'),20,'0') ";
		}
		if ( $this->sort["v_room_cntrl_price"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , lpad(replace(room_cntrl_price,'-','00000000000000000000'),20,'0') ";
		}
		if ( $this->sort["v_room_area"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , room_area DESC ";
		}
		if ( $this->sort["v_room_madori"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , room_madori DESC ";
		}
		if ( $this->sort["v_cs_type"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , cs_type ";
		}
		if ( $this->sort["v_cs_date"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , cs_date DESC ";
		}
		

		IF( $this->jyoken["DISTINCT"] == "cs_id" ){
			$strSQL = "";
			$strSQL = " SELECT DISTINCT cs_id FROM v_course ";
		}ELSE{
			$strSQL = "";
			$strSQL = " SELECT cs_id FROM v_course ";
		}
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
			$this->php_error = "viewdb_GetCourse(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetCourse(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;

		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				if($key != "cs_biko_1")$this->coursedat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cs_id) FROM v_course ";
		$strSQL .= $stmt2;
	//echo "GetCourse_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetCourse(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetCourse(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetCourse(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}

	/*-----------------------------------------------------
	    Course View情報 - 検索
	-----------------------------------------------------*/
	function viewdb_GetCourseCnt ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetCourse(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["cs_id"] != "" )       $sql_where .= " AND cs_id = {$this->jyoken["cs_id"]} ";
		if( $this->jyoken["cs_clid"] != "" )    $sql_where .= " AND cs_clid = {$this->jyoken["cs_clid"]} ";
		if( $this->jyoken["cs_name"] != "" )    $sql_where .= " AND cs_name = '{$this->jyoken["cs_name"]}' ";
		if( $this->jyoken["cs_name_disp"] != "" )    $sql_where .= " AND cs_name_disp = '{$this->jyoken["cs_name_disp"]}' ";
		if( $this->jyoken["cs_address"] != "" )    $sql_where .= " AND cs_address = '{$this->jyoken["cs_address"]}' ";
		if( $this->jyoken["cs_zip"] != "" )    $sql_where .= " AND cs_zip = '{$this->jyoken["cs_zip"]}' ";
		if( $this->jyoken["cs_pref"] != "" )    $sql_where .= " AND cs_pref = '{$this->jyoken["cs_pref"]}' ";
		if( $this->jyoken["cs_pref_cd"] != "" )    $sql_where .= " AND cs_pref_cd = '{$this->jyoken["cs_pref_cd"]}' ";
		if( $this->jyoken["cs_address1"] != "" )    $sql_where .= " AND cs_address1 = '{$this->jyoken["cs_address1"]}' ";
		if( $this->jyoken["cs_addr_cd"] != "" )    $sql_where .= " AND cs_addr_cd = '{$this->jyoken["cs_addr_cd"]}' ";
		if( $this->jyoken["tar"] != "" )    $sql_where .= " AND cs_pref like '%{$this->jyoken["tar"]}%' ";
		if( $this->jyoken["tnk"] != "" )    $sql_where .= " AND cs_address1 like '%{$this->jyoken["tnk"]}%' ";
		if( $this->jyoken["room_start_date"] != "" && $this->jyoken["room_end_date"] != "" )   $sql_where .= " AND ((room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date is null) OR (room_start_date is null AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date is null AND room_end_date is null)) ";
		if( $this->jyoken["cs_address2"] != "" )    $sql_where .= " AND cs_address2 = '{$this->jyoken["cs_address2"]}' ";
		if( $this->jyoken["cs_line_cd"] != "" )    $sql_where .= " AND cs_line_cd = '{$this->jyoken["cs_line_cd"]}' ";
		if( $this->jyoken["cs_line_name_1"] != "" )    $sql_where .= " AND cs_line_name_1 = '{$this->jyoken["cs_line_name_1"]}' ";
		if( $this->jyoken["cs_sta_cd"] != "" )    $sql_where .= " AND cs_sta_cd = '{$this->jyoken["cs_sta_cd"]}' ";
		if( $this->jyoken["cs_sta_name_1"] != "" )    $sql_where .= " AND cs_sta_name_1 = '{$this->jyoken["cs_sta_name_1"]}' ";
		if( $this->jyoken["cs_move_1"] != "")	$sql_where .= " AND cs_move_1 = {$this->jyoken["cs_move_1"]} ";
		if( $this->jyoken["cs_move_1_search"] != "")	$sql_where .= " AND cs_move_1 <= {$this->jyoken["cs_move_1_search"]} ";
		if( $this->jyoken["cs_line_name_2"] != "" )    $sql_where .= " AND cs_line_name_2 = '{$this->jyoken["cs_line_name_2"]}' ";
		if( $this->jyoken["cs_sta_name_2"] != "" )    $sql_where .= " AND cs_sta_name_2 = '{$this->jyoken["cs_sta_name_2"]}' ";
		if( $this->jyoken["cs_move_2"] != "" )    $sql_where .= " AND cs_move_2 = '{$this->jyoken["cs_move_2"]}' ";
		if( $this->jyoken["cs_date"] != "" )    $sql_where .= " AND cs_date = '{$this->jyoken["cs_date"]}' ";
		if( $this->jyoken["cs_date_search"] != "" )    $sql_where .= " AND cs_date >= '{$this->jyoken["cs_date_search"]}' ";
		if( $this->jyoken["cs_material"] != "" )    $sql_where .= " AND cs_material = '{$this->jyoken["cs_material"]}' ";
		if( $this->jyoken["cs_photo"] != "" )    $sql_where .= " AND cs_photo = '{$this->jyoken["cs_photo"]}' ";
		if( $this->jyoken["cs_photo_org"] != "" )    $sql_where .= " AND cs_photo_org = '{$this->jyoken["cs_photo_org"]}' ";
		if( $this->jyoken["cs_map"] != "" )    $sql_where .= " AND cs_map = '{$this->jyoken["cs_map"]}' ";
		if( $this->jyoken["cs_disp_no"] != "" )    $sql_where .= " AND cs_disp_no = '{$this->jyoken["cs_disp_no"]}' ";
		if( $this->jyoken["cs_update"] != "" )   $sql_where .= " AND cs_update = '{$this->jyoken["cs_update"]}' ";
		if( $this->jyoken["cs_del_date"] != "" ) $sql_where .= " AND cs_del_date is NULL ";
		if( $this->jyoken["room_id"] != "" )       $sql_where .= " AND room_id = {$this->jyoken["room_id"]} ";
		if( $this->jyoken["room_cs_id"] != "" )    $sql_where .= " AND room_cs_id = '{$this->jyoken["room_cs_id"]}' ";
		if( $this->jyoken["room_cate_id"] != "" )	$sql_where .= " AND room_cate_id LIKE '%/{$this->jyoken["room_cate_id"]}/%' ";
		if( $this->jyoken["room_code"] != "" )    $sql_where .= " AND room_code = '{$this->jyoken["room_code"]}' ";
		if( $this->jyoken["room_madori"] != "" )    $sql_where .= " AND room_madori = '{$this->jyoken["room_madori"]}' ";
		if( $this->jyoken["room_madori_detail"] != "" )    $sql_where .= " AND room_madori_detail = '{$this->jyoken["room_madori_detail"]}' ";
		if( $this->jyoken["room_price"] != "" )    $sql_where .= " AND room_price = '{$this->jyoken["room_price"]}' ";
		if( $this->jyoken["room_price_start_search"] != "" )    $sql_where .= " AND room_price >= {$this->jyoken["room_price_start_search"]} ";
		if( $this->jyoken["room_price_limit_search"] != "" )    $sql_where .= " AND room_price < {$this->jyoken["room_price_limit_search"]} ";
		if( $this->jyoken["room_cntrl_price"] != "" )    $sql_where .= " AND room_cntrl_price = '{$this->jyoken["room_cntrl_price"]}' ";
		if( $this->jyoken["room_siki"] != "" )    $sql_where .= " AND room_siki = {$this->jyoken["room_siki"]} ";
		if( $this->jyoken["room_rei"] != "" )    $sql_where .= " AND room_rei = {$this->jyoken["room_rei"]} ";
		if( $this->jyoken["room_sikirei"] != "" )    $sql_where .= " AND ( room_siki = '0' OR room_siki = '-' ) AND ( room_rei = '0' OR room_rei = '-' ) ";
		if( $this->jyoken["room_syou"] != "" )    $sql_where .= " AND room_syou = '{$this->jyoken["room_syou"]}' ";
		if( $this->jyoken["room_sikibiki"] != "" )    $sql_where .= " AND room_sikibiki = '{$this->jyoken["room_sikibiki"]}' ";
		if( $this->jyoken["room_sec_price"] != "" )    $sql_where .= " AND room_sec_price = '{$this->jyoken["room_sec_price"]}' ";
		if( $this->jyoken["room_contract"] != "" )    $sql_where .= " AND room_contract = '{$this->jyoken["room_contract"]}' ";
		if( $this->jyoken["room_upd_price"] != "" )    $sql_where .= " AND room_upd_price = '{$this->jyoken["room_upd_price"]}' ";
		if( $this->jyoken["room_upd_year"] != "" )    $sql_where .= " AND room_upd_year = '{$this->jyoken["room_upd_year"]}' ";
		if( $this->jyoken["room_area"] != "" )    $sql_where .= " AND room_area = '{$this->jyoken["room_area"]}' ";
		if( $this->jyoken["room_area_start_search"] != "" )    $sql_where .= " AND room_area >= '{$this->jyoken["room_area_start_search"]}' ";
		if( $this->jyoken["room_area_limit_search"] != "" )    $sql_where .= " AND room_area < '{$this->jyoken["room_area_limit_search"]}' ";
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
		if( $this->jyoken["room_biko_2"] != "" )   $sql_where .= " AND room_biko_2 != '9' ";
		if( $this->jyoken["room_biko_3"] != "" )   $sql_where .= " AND ( room_biko_3 = '1' OR room_biko_3 is null ) ";
		if( $this->jyoken["room_disp_no"] != "" )   $sql_where .= " AND room_disp_no = '{$this->jyoken["room_disp_no"]}' ";
		if( $this->jyoken["room_del_date"] != "" ) $sql_where .= " AND room_ins_date is NOT NULL ";
		if( $this->jyoken["room_del_date"] != "" ) $sql_where .= " AND room_del_date is NULL ";
		IF( count( $this->jyoken["cs_clid_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["cs_clid_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " cs_clid = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}


		//ＳＱＬ条件作成
		if( $this->jyoken["not_room_id"] != "" )       $sql_where .= " AND room_id <> {$this->jyoken["not_room_id"]} ";


		// ＳＱＬソート条件作成
		if ( $this->sort["cs_disp_no"] == 1 ){
			$sql_order .= " ORDER BY cs_disp_no desc ";
		}else if( $this->sort["cs_disp_no"] == 2 ){
			$sql_order .= " ORDER BY cs_disp_no ";
		}
		if ( $this->sort["cs_id"] == 1 ){
			$sql_order .= " ORDER BY cs_id desc ";
		}else if( $this->sort["cs_id"] == 2 ){
			$sql_order .= " ORDER BY cs_id ";
		}
		if ( $this->sort["room_upd_date"] != "" ){
			SWITCH( $this->sort["room_upd_date"] ){
				Case 1:
					$sql_order .= " ORDER BY room_upd_date desc ";
					break;
				Case 2:
					$sql_order .= " ORDER BY room_vacant desc , room_upd_date desc ";
					break;
			}
		}
		if ( $this->sort["search_area"] != "" ){
			$sql_order .= " ORDER BY cs_pref_cd , cs_addr_cd ";
		}
		if ( $this->sort["v_cs_move_1"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , cs_move_1 ";
		}
		if ( $this->sort["v_room_price"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , lpad(replace(room_price,'-','00000000000000000000'),20,'0') ";
		}
		if ( $this->sort["v_room_cntrl_price"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , lpad(replace(room_cntrl_price,'-','00000000000000000000'),20,'0') ";
		}
		if ( $this->sort["v_room_area"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , room_area DESC ";
		}
		if ( $this->sort["v_room_madori"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , room_madori DESC ";
		}
		if ( $this->sort["v_cs_type"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , cs_type ";
		}
		if ( $this->sort["v_cs_date"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , cs_date DESC ";
		}
		
		$strSQL = "";
		$strSQL = " SELECT count(*),cs_pref_cd,rtrim(rtrim(rtrim(cs_pref,'県'),'都'),'府') as cs_pref FROM v_course ";
		$stmt2 = "";
		$stmt2 .= " WHERE cs_id is NOT NULL AND cl_id is not null ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= " group by cs_pref_cd,cs_pref ";
		$strSQL .= " order by cs_pref_cd ";
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo "GetCourse_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetCourse(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetCourse(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );

		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				if($this->jyoken["arr_mode"]=="search_als"){
					if($key == "cs_pref_cd" || $key == "cs_addr_cd" || $key == "cs_pref" || $key == "cs_address1" || $key == "cs_line_cd" || $key == "cs_line_cd_name" || $key == "cs_sta_cd" || $key == "cs_sta_name_1" || $key == "cs_sta_name_2" )$this->coursedat[$curpos][$key] = $val;
				}
				$this->coursedat[$curpos][$key] = $val;
			}
			$cnt++;
		}

		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(cs_id) FROM v_course ";
		$strSQL .= $stmt2;
	//echo "GetCourse_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetCourse(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetCourse(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetCourse(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}

}

?>
