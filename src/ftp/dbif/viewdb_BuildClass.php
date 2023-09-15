<?
/*****************************************************************************
	Build View DBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class viewdb_BuildClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $builddat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function viewdb_BuildClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->builddat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    Build View情報 - 検索
	-----------------------------------------------------*/
	function viewdb_GetBuild ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetBuild(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["build_id"] != "" )       $sql_where .= " AND build_id = {$this->jyoken["build_id"]} ";
		if( $this->jyoken["build_cl_id"] != "" )    $sql_where .= " AND build_cl_id = {$this->jyoken["build_cl_id"]} ";
		if( $this->jyoken["build_name"] != "" )    $sql_where .= " AND build_name = '{$this->jyoken["build_name"]}' ";
		if( $this->jyoken["build_name_disp"] != "" )    $sql_where .= " AND build_name_disp = '{$this->jyoken["build_name_disp"]}' ";
		if( $this->jyoken["build_address"] != "" )    $sql_where .= " AND build_address = '{$this->jyoken["build_address"]}' ";
		if( $this->jyoken["build_zip"] != "" )    $sql_where .= " AND build_zip = '{$this->jyoken["build_zip"]}' ";
		if( $this->jyoken["build_pref"] != "" )    $sql_where .= " AND build_pref = '{$this->jyoken["build_pref"]}' ";
		if( $this->jyoken["build_pref_cd"] != "" )    $sql_where .= " AND build_pref_cd = '{$this->jyoken["build_pref_cd"]}' ";
		if( $this->jyoken["build_address1"] != "" )    $sql_where .= " AND build_address1 = '{$this->jyoken["build_address1"]}' ";
		if( $this->jyoken["build_addr_cd"] != "" )    $sql_where .= " AND build_addr_cd = '{$this->jyoken["build_addr_cd"]}' ";
		if( $this->jyoken["tar"] != "" )    $sql_where .= " AND build_pref like '%{$this->jyoken["tar"]}%' ";
		if( $this->jyoken["tnk"] != "" )    $sql_where .= " AND build_address1 like '%{$this->jyoken["tnk"]}%' ";
		if( $this->jyoken["room_start_date"] != "" && $this->jyoken["room_end_date"] != "" )   $sql_where .= " AND ((room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date is null) OR (room_start_date is null AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date is null AND room_end_date is null)) ";
		IF( count( $this->jyoken["MST"] ) != "" ){
			$sql_where .= " AND ( ";
			$sql_where .= " build_pref like '%{$this->jyoken["MST"]}%' ";
			$sql_where .= " OR build_address1 like '%{$this->jyoken["MST"]}%' ";
			$sql_where .= " OR build_address2 like '%{$this->jyoken["MST"]}%' ";
			$sql_where .= " OR build_line_name_1 like '%{$this->jyoken["MST"]}%' ";
			$sql_where .= " OR build_line_name_2 like '%{$this->jyoken["MST"]}%' ";
			$sql_where .= " OR build_sta_name_1 like '%{$this->jyoken["MST"]}%' ";
			$sql_where .= " OR build_sta_name_2 like '%{$this->jyoken["MST"]}%' ";
			$sql_where .= " OR build_zip like '%{$this->jyoken["MST"]}%' ";
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["fkwd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["fkwd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " AND ";
				$buffsql .= " build_biko_1||' '||room_biko_1 like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["build_cl_id_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["build_cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_cl_id = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pf"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pf"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_addr_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["ar"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["ar"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pref_cd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pref_cd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["line"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["line"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_line_cd like '%/{$val}/%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["sta"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_sta_cd like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		if( $this->jyoken["build_address2"] != "" )    $sql_where .= " AND build_address2 = '{$this->jyoken["build_address2"]}' ";
		if( $this->jyoken["build_line_cd"] != "" )    $sql_where .= " AND build_line_cd = '{$this->jyoken["build_line_cd"]}' ";
		if( $this->jyoken["build_line_name_1"] != "" )    $sql_where .= " AND build_line_name_1 = '{$this->jyoken["build_line_name_1"]}' ";
		if( $this->jyoken["build_sta_cd"] != "" )    $sql_where .= " AND build_sta_cd = '{$this->jyoken["build_sta_cd"]}' ";
		if( $this->jyoken["build_sta_name_1"] != "" )    $sql_where .= " AND build_sta_name_1 = '{$this->jyoken["build_sta_name_1"]}' ";
		if( $this->jyoken["build_move_1"] != "")	$sql_where .= " AND build_move_1 = {$this->jyoken["build_move_1"]} ";
		if( $this->jyoken["build_move_1_search"] != "")	$sql_where .= " AND build_move_1 <= {$this->jyoken["build_move_1_search"]} ";
		if( $this->jyoken["build_line_name_2"] != "" )    $sql_where .= " AND build_line_name_2 = '{$this->jyoken["build_line_name_2"]}' ";
		if( $this->jyoken["build_sta_name_2"] != "" )    $sql_where .= " AND build_sta_name_2 = '{$this->jyoken["build_sta_name_2"]}' ";
		if( $this->jyoken["build_move_2"] != "" )    $sql_where .= " AND build_move_2 = '{$this->jyoken["build_move_2"]}' ";
		if( $this->jyoken["build_date"] != "" )    $sql_where .= " AND build_date = '{$this->jyoken["build_date"]}' ";
		if( $this->jyoken["build_date_search"] != "" )    $sql_where .= " AND build_date >= '{$this->jyoken["build_date_search"]}' ";
		if( $this->jyoken["build_material"] != "" )    $sql_where .= " AND build_material = '{$this->jyoken["build_material"]}' ";
		if( count($this->jyoken["build_material_search"]) != 0 ){
								$sql_where .= " AND (";
								$material_cnt = 0;
								foreach($this->jyoken["build_material_search"] as $key => $val){
			    						if($material_cnt != 0)$sql_where .= " OR";
									$sql_where .= " build_material = '{$val}' ";
									$material_cnt++;
								}
								$sql_where .= " )";
		}
		if( $this->jyoken["build_all_floor"] != "" )    $sql_where .= " AND build_all_floor = '{$this->jyoken["build_all_floor"]}' ";
		if( $this->jyoken["build_type"] != "" )    $sql_where .= " AND build_type = '{$this->jyoken["build_type"]}' ";
		if( count($this->jyoken["build_type_search"]) != 0 ){
								$sql_where .= " AND (";
								$type_cnt = 0;
								foreach($this->jyoken["build_type_search"] as $key => $val){
			    						if($type_cnt != 0)$sql_where .= " OR";
									$sql_where .= " build_type = '{$val}' ";
									$type_cnt++;
								}
								$sql_where .= " )";
		}
		if( count($this->jyoken["room_equip_search"]) != 0 ){
								$sql_where .= " AND (";
								$equip_cnt = 0;
								foreach($this->jyoken["room_equip_search"] as $key => $val){
			    						if($equip_cnt != 0)$sql_where .= " AND";
									$sql_where .= " room_equip like '%{$val}%' ";
									$equip_cnt++;
								}
								$sql_where .= " )";
		}
		if( $this->jyoken["build_photo"] != "" )    $sql_where .= " AND build_photo = '{$this->jyoken["build_photo"]}' ";
		if( $this->jyoken["build_photo_org"] != "" )    $sql_where .= " AND build_photo_org = '{$this->jyoken["build_photo_org"]}' ";
		if( $this->jyoken["build_map"] != "" )    $sql_where .= " AND build_map = '{$this->jyoken["build_map"]}' ";
		if( $this->jyoken["build_disp_no"] != "" )    $sql_where .= " AND build_disp_no = '{$this->jyoken["build_disp_no"]}' ";
		if( $this->jyoken["build_update"] != "" )   $sql_where .= " AND build_update = '{$this->jyoken["build_update"]}' ";
		if( $this->jyoken["build_del_date"] != "" ) $sql_where .= " AND build_del_date is NULL ";

		if( $this->jyoken["room_id"] != "" )       $sql_where .= " AND room_id = {$this->jyoken["room_id"]} ";
		if( $this->jyoken["room_build_id"] != "" )    $sql_where .= " AND room_build_id = '{$this->jyoken["room_build_id"]}' ";
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
		if( $this->jyoken["room_biko_2"] != "" )   $sql_where .= " AND room_biko_2 != '9' ";
		if( $this->jyoken["room_biko_3"] != "" )   $sql_where .= " AND ( room_biko_3 = '1' OR room_biko_3 is null ) ";
		if( $this->jyoken["room_disp_no"] != "" )   $sql_where .= " AND room_disp_no = '{$this->jyoken["room_disp_no"]}' ";
		if( $this->jyoken["room_del_date"] != "" ) $sql_where .= " AND room_ins_date is NOT NULL ";
		if( $this->jyoken["room_del_date"] != "" ) $sql_where .= " AND room_del_date is NULL ";


		//ＳＱＬ条件作成
		if( $this->jyoken["not_room_id"] != "" )       $sql_where .= " AND room_id <> {$this->jyoken["not_room_id"]} ";


		// ＳＱＬソート条件作成
		if ( $this->sort["build_disp_no"] == 1 ){
			$sql_order .= " ORDER BY build_disp_no desc ";
		}else if( $this->sort["build_disp_no"] == 2 ){
			$sql_order .= " ORDER BY build_disp_no ";
		}
		if ( $this->sort["build_id"] == 1 ){
			$sql_order .= " ORDER BY build_id desc ";
		}else if( $this->sort["build_id"] == 2 ){
			$sql_order .= " ORDER BY build_id ";
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
			$sql_order .= " ORDER BY build_pref_cd , build_addr_cd ";
		}
		if ( $this->sort["v_build_move_1"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , build_move_1 ";
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
		if ( $this->sort["v_build_type"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , build_type ";
		}
		if ( $this->sort["v_build_date"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , build_date DESC ";
		}
		
		IF( $this->jyoken["arr_mode"] == "search_als" ){
			$strSQL = "";
			$strSQL = " SELECT build_pref_cd,build_addr_cd,build_pref,build_address1,build_line_cd,build_line_cd_name,build_sta_cd,build_sta_name_1,build_sta_name_2 FROM base_v_build ";
		}ELSE IF( $this->jyoken["arr_mode"] == "search_map" ){
			$strSQL = "";
			$strSQL = " SELECT room_id,build_map,room_build_id,room_code,build_photo,build_line_name_1,build_sta_name_1,build_move_1,build_move_bus_1,room_madori,room_price,room_area,room_vacant FROM base_v_build ";
		}ELSE{
			$strSQL = "";
			$strSQL = " SELECT * FROM base_v_build ";
		}
		$stmt2 = "";
		$stmt2 .= " WHERE build_id is NOT NULL AND cl_id is not null ";
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
			$this->php_error = "viewdb_GetBuild(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetBuild(3):Get Failed";
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
					if($key == "build_pref_cd" || $key == "build_addr_cd" || $key == "build_pref" || $key == "build_address1" || $key == "build_line_cd" || $key == "build_line_cd_name" || $key == "build_sta_cd" || $key == "build_sta_name_1" || $key == "build_sta_name_2" )$this->builddat[$curpos][$key] = $val;
				}
				$this->builddat[$curpos][$key] = $val;
			}
			$cnt++;
		}

		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(build_id) FROM base_v_build ";
		$strSQL .= $stmt2;
	//echo "GetBuild_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetBuild(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetBuild(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetBuild(6):Get Failed";
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
			$this->php_error = "viewdb_GetBuild(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["build_id"] != "" )       $sql_where .= " AND build_id = {$this->jyoken["build_id"]} ";
		if( $this->jyoken["build_cl_id"] != "" )    $sql_where .= " AND build_cl_id = {$this->jyoken["build_cl_id"]} ";
		if( $this->jyoken["build_name"] != "" )    $sql_where .= " AND build_name = '{$this->jyoken["build_name"]}' ";
		if( $this->jyoken["build_name_disp"] != "" )    $sql_where .= " AND build_name_disp = '{$this->jyoken["build_name_disp"]}' ";
		if( $this->jyoken["build_address"] != "" )    $sql_where .= " AND build_address = '{$this->jyoken["build_address"]}' ";
		if( $this->jyoken["build_zip"] != "" )    $sql_where .= " AND build_zip = '{$this->jyoken["build_zip"]}' ";
		if( $this->jyoken["build_pref"] != "" )    $sql_where .= " AND build_pref = '{$this->jyoken["build_pref"]}' ";
		if( $this->jyoken["build_pref_cd"] != "" )    $sql_where .= " AND build_pref_cd = '{$this->jyoken["build_pref_cd"]}' ";
		if( $this->jyoken["build_address1"] != "" )    $sql_where .= " AND build_address1 = '{$this->jyoken["build_address1"]}' ";
		if( $this->jyoken["build_addr_cd"] != "" )    $sql_where .= " AND build_addr_cd = '{$this->jyoken["build_addr_cd"]}' ";
		if( $this->jyoken["tar"] != "" )    $sql_where .= " AND build_pref like '%{$this->jyoken["tar"]}%' ";
		if( $this->jyoken["tnk"] != "" )    $sql_where .= " AND build_address1 like '%{$this->jyoken["tnk"]}%' ";
		IF( count( $this->jyoken["fkwd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["fkwd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " AND ";
				$buffsql .= " build_biko_1||' '||room_biko_1 like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["build_cl_id_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["build_cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_cl_id = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pf"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pf"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_addr_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["pref_cd"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["pref_cd"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_pref_cd = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["line"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["line"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_line_cd like '%/{$val}/%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		IF( count( $this->jyoken["sta"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["sta"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_sta_cd like '%{$val}%' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}
		if( $this->jyoken["build_address2"] != "" )    $sql_where .= " AND build_address2 = '{$this->jyoken["build_address2"]}' ";
		if( $this->jyoken["build_line_cd"] != "" )    $sql_where .= " AND build_line_cd = '{$this->jyoken["build_line_cd"]}' ";
		if( $this->jyoken["build_line_name_1"] != "" )    $sql_where .= " AND build_line_name_1 = '{$this->jyoken["build_line_name_1"]}' ";
		if( $this->jyoken["build_sta_cd"] != "" )    $sql_where .= " AND build_sta_cd = '{$this->jyoken["build_sta_cd"]}' ";
		if( $this->jyoken["build_sta_name_1"] != "" )    $sql_where .= " AND build_sta_name_1 = '{$this->jyoken["build_sta_name_1"]}' ";
		if( $this->jyoken["build_move_1"] != "")	$sql_where .= " AND build_move_1 = {$this->jyoken["build_move_1"]} ";
		if( $this->jyoken["build_move_1_search"] != "")	$sql_where .= " AND build_move_1 <= {$this->jyoken["build_move_1_search"]} ";
		if( $this->jyoken["build_line_name_2"] != "" )    $sql_where .= " AND build_line_name_2 = '{$this->jyoken["build_line_name_2"]}' ";
		if( $this->jyoken["build_sta_name_2"] != "" )    $sql_where .= " AND build_sta_name_2 = '{$this->jyoken["build_sta_name_2"]}' ";
		if( $this->jyoken["build_move_2"] != "" )    $sql_where .= " AND build_move_2 = '{$this->jyoken["build_move_2"]}' ";
		if( $this->jyoken["build_date"] != "" )    $sql_where .= " AND build_date = '{$this->jyoken["build_date"]}' ";
		if( $this->jyoken["build_date_search"] != "" )    $sql_where .= " AND build_date >= '{$this->jyoken["build_date_search"]}' ";
		if( $this->jyoken["build_material"] != "" )    $sql_where .= " AND build_material = '{$this->jyoken["build_material"]}' ";
		if( count($this->jyoken["build_material_search"]) != 0 ){
								$sql_where .= " AND (";
								$material_cnt = 0;
								foreach($this->jyoken["build_material_search"] as $key => $val){
			    						if($material_cnt != 0)$sql_where .= " OR";
									$sql_where .= " build_material = '{$val}' ";
									$material_cnt++;
								}
								$sql_where .= " )";
		}
		if( $this->jyoken["build_all_floor"] != "" )    $sql_where .= " AND build_all_floor = '{$this->jyoken["build_all_floor"]}' ";
		if( $this->jyoken["build_type"] != "" )    $sql_where .= " AND build_type = '{$this->jyoken["build_type"]}' ";
		if( count($this->jyoken["build_type_search"]) != 0 ){
								$sql_where .= " AND (";
								$type_cnt = 0;
								foreach($this->jyoken["build_type_search"] as $key => $val){
			    						if($type_cnt != 0)$sql_where .= " OR";
									$sql_where .= " build_type = '{$val}' ";
									$type_cnt++;
								}
								$sql_where .= " )";
		}
		if( $this->jyoken["build_photo"] != "" )    $sql_where .= " AND build_photo = '{$this->jyoken["build_photo"]}' ";
		if( $this->jyoken["build_photo_org"] != "" )    $sql_where .= " AND build_photo_org = '{$this->jyoken["build_photo_org"]}' ";
		if( $this->jyoken["build_map"] != "" )    $sql_where .= " AND build_map = '{$this->jyoken["build_map"]}' ";
		if( $this->jyoken["build_disp_no"] != "" )    $sql_where .= " AND build_disp_no = '{$this->jyoken["build_disp_no"]}' ";
		if( $this->jyoken["build_update"] != "" )   $sql_where .= " AND build_update = '{$this->jyoken["build_update"]}' ";
		if( $this->jyoken["build_del_date"] != "" ) $sql_where .= " AND build_del_date is NULL ";

		if( $this->jyoken["room_id"] != "" )       $sql_where .= " AND room_id = {$this->jyoken["room_id"]} ";
		if( $this->jyoken["room_build_id"] != "" )    $sql_where .= " AND room_build_id = '{$this->jyoken["room_build_id"]}' ";
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
		if( $this->jyoken["biko_1"] != "" ) $sql_where .= " AND build_biko_1||' '||room_biko_1 like '%{$val}%' ";


		//ＳＱＬ条件作成
		if( $this->jyoken["not_room_id"] != "" )       $sql_where .= " AND room_id <> {$this->jyoken["not_room_id"]} ";


		// ＳＱＬソート条件作成
		if ( $this->sort["build_disp_no"] == 1 ){
			$sql_order .= " ORDER BY build_disp_no desc ";
		}else if( $this->sort["build_disp_no"] == 2 ){
			$sql_order .= " ORDER BY build_disp_no ";
		}
		if ( $this->sort["build_id"] == 1 ){
			$sql_order .= " ORDER BY build_id desc ";
		}else if( $this->sort["build_id"] == 2 ){
			$sql_order .= " ORDER BY build_id ";
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
			$sql_order .= " ORDER BY build_pref_cd , build_addr_cd ";
		}
		if ( $this->sort["v_build_move_1"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , build_move_1 ";
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
		if ( $this->sort["v_build_type"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , build_type ";
		}
		if ( $this->sort["v_build_date"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , build_date DESC ";
		}
		

		IF( $this->jyoken["DISTINCT"] == "build_id" ){
			$strSQL = "";
			$strSQL = " SELECT DISTINCT build_id FROM base_v_build ";
		}ELSE{
			$strSQL = "";
			$strSQL = " SELECT build_id FROM base_v_build ";
		}
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
			$this->php_error = "viewdb_GetBuild(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetBuild(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;

		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				if($key != "build_biko_1")$this->builddat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(build_id) FROM base_v_build ";
		$strSQL .= $stmt2;
	//echo "GetBuild_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetBuild(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetBuild(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetBuild(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}

	/*-----------------------------------------------------
	    Build View情報 - 検索
	-----------------------------------------------------*/
	function viewdb_GetBuildCnt ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "viewdb_GetBuild(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["build_id"] != "" )       $sql_where .= " AND build_id = {$this->jyoken["build_id"]} ";
		if( $this->jyoken["build_cl_id"] != "" )    $sql_where .= " AND build_cl_id = {$this->jyoken["build_cl_id"]} ";
		if( $this->jyoken["build_name"] != "" )    $sql_where .= " AND build_name = '{$this->jyoken["build_name"]}' ";
		if( $this->jyoken["build_name_disp"] != "" )    $sql_where .= " AND build_name_disp = '{$this->jyoken["build_name_disp"]}' ";
		if( $this->jyoken["build_address"] != "" )    $sql_where .= " AND build_address = '{$this->jyoken["build_address"]}' ";
		if( $this->jyoken["build_zip"] != "" )    $sql_where .= " AND build_zip = '{$this->jyoken["build_zip"]}' ";
		if( $this->jyoken["build_pref"] != "" )    $sql_where .= " AND build_pref = '{$this->jyoken["build_pref"]}' ";
		if( $this->jyoken["build_pref_cd"] != "" )    $sql_where .= " AND build_pref_cd = '{$this->jyoken["build_pref_cd"]}' ";
		if( $this->jyoken["build_address1"] != "" )    $sql_where .= " AND build_address1 = '{$this->jyoken["build_address1"]}' ";
		if( $this->jyoken["build_addr_cd"] != "" )    $sql_where .= " AND build_addr_cd = '{$this->jyoken["build_addr_cd"]}' ";
		if( $this->jyoken["tar"] != "" )    $sql_where .= " AND build_pref like '%{$this->jyoken["tar"]}%' ";
		if( $this->jyoken["tnk"] != "" )    $sql_where .= " AND build_address1 like '%{$this->jyoken["tnk"]}%' ";
		if( $this->jyoken["room_start_date"] != "" && $this->jyoken["room_end_date"] != "" )   $sql_where .= " AND ((room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date <= '{$this->jyoken["room_start_date"]}' AND room_end_date is null) OR (room_start_date is null AND room_end_date >= '{$this->jyoken["room_end_date"]}') OR (room_start_date is null AND room_end_date is null)) ";
		if( $this->jyoken["build_address2"] != "" )    $sql_where .= " AND build_address2 = '{$this->jyoken["build_address2"]}' ";
		if( $this->jyoken["build_line_cd"] != "" )    $sql_where .= " AND build_line_cd = '{$this->jyoken["build_line_cd"]}' ";
		if( $this->jyoken["build_line_name_1"] != "" )    $sql_where .= " AND build_line_name_1 = '{$this->jyoken["build_line_name_1"]}' ";
		if( $this->jyoken["build_sta_cd"] != "" )    $sql_where .= " AND build_sta_cd = '{$this->jyoken["build_sta_cd"]}' ";
		if( $this->jyoken["build_sta_name_1"] != "" )    $sql_where .= " AND build_sta_name_1 = '{$this->jyoken["build_sta_name_1"]}' ";
		if( $this->jyoken["build_move_1"] != "")	$sql_where .= " AND build_move_1 = {$this->jyoken["build_move_1"]} ";
		if( $this->jyoken["build_move_1_search"] != "")	$sql_where .= " AND build_move_1 <= {$this->jyoken["build_move_1_search"]} ";
		if( $this->jyoken["build_line_name_2"] != "" )    $sql_where .= " AND build_line_name_2 = '{$this->jyoken["build_line_name_2"]}' ";
		if( $this->jyoken["build_sta_name_2"] != "" )    $sql_where .= " AND build_sta_name_2 = '{$this->jyoken["build_sta_name_2"]}' ";
		if( $this->jyoken["build_move_2"] != "" )    $sql_where .= " AND build_move_2 = '{$this->jyoken["build_move_2"]}' ";
		if( $this->jyoken["build_date"] != "" )    $sql_where .= " AND build_date = '{$this->jyoken["build_date"]}' ";
		if( $this->jyoken["build_date_search"] != "" )    $sql_where .= " AND build_date >= '{$this->jyoken["build_date_search"]}' ";
		if( $this->jyoken["build_material"] != "" )    $sql_where .= " AND build_material = '{$this->jyoken["build_material"]}' ";
		if( $this->jyoken["build_photo"] != "" )    $sql_where .= " AND build_photo = '{$this->jyoken["build_photo"]}' ";
		if( $this->jyoken["build_photo_org"] != "" )    $sql_where .= " AND build_photo_org = '{$this->jyoken["build_photo_org"]}' ";
		if( $this->jyoken["build_map"] != "" )    $sql_where .= " AND build_map = '{$this->jyoken["build_map"]}' ";
		if( $this->jyoken["build_disp_no"] != "" )    $sql_where .= " AND build_disp_no = '{$this->jyoken["build_disp_no"]}' ";
		if( $this->jyoken["build_update"] != "" )   $sql_where .= " AND build_update = '{$this->jyoken["build_update"]}' ";
		if( $this->jyoken["build_del_date"] != "" ) $sql_where .= " AND build_del_date is NULL ";
		if( $this->jyoken["room_id"] != "" )       $sql_where .= " AND room_id = {$this->jyoken["room_id"]} ";
		if( $this->jyoken["room_build_id"] != "" )    $sql_where .= " AND room_build_id = '{$this->jyoken["room_build_id"]}' ";
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
		IF( count( $this->jyoken["build_cl_id_list"] ) != 0 ){
			$sql_where .= " AND ( ";
			$buffsql = "";
			FOREACH( $this->jyoken["build_cl_id_list"] as $key => $val ){
				IF( $buffsql != "" ) $buffsql .= " OR ";
				$buffsql .= " build_cl_id = '{$val}' ";
			}
			$sql_where .= $buffsql;
			$sql_where .= " ) ";
		}


		//ＳＱＬ条件作成
		if( $this->jyoken["not_room_id"] != "" )       $sql_where .= " AND room_id <> {$this->jyoken["not_room_id"]} ";


		// ＳＱＬソート条件作成
		if ( $this->sort["build_disp_no"] == 1 ){
			$sql_order .= " ORDER BY build_disp_no desc ";
		}else if( $this->sort["build_disp_no"] == 2 ){
			$sql_order .= " ORDER BY build_disp_no ";
		}
		if ( $this->sort["build_id"] == 1 ){
			$sql_order .= " ORDER BY build_id desc ";
		}else if( $this->sort["build_id"] == 2 ){
			$sql_order .= " ORDER BY build_id ";
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
			$sql_order .= " ORDER BY build_pref_cd , build_addr_cd ";
		}
		if ( $this->sort["v_build_move_1"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , build_move_1 ";
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
		if ( $this->sort["v_build_type"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , build_type ";
		}
		if ( $this->sort["v_build_date"] != "" ){
			$sql_order .= " ORDER BY room_vacant desc , build_date DESC ";
		}
		
		$strSQL = "";
		$strSQL = " SELECT count(*),build_pref_cd,rtrim(rtrim(rtrim(build_pref,'県'),'都'),'府') as build_pref FROM base_v_build ";
		$stmt2 = "";
		$stmt2 .= " WHERE build_id is NOT NULL AND cl_id is not null ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= " group by build_pref_cd,build_pref ";
		$strSQL .= " order by build_pref_cd ";
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo "GetBuild_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetBuild(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "viewdb_GetBuild(3):Get Failed";
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
					if($key == "build_pref_cd" || $key == "build_addr_cd" || $key == "build_pref" || $key == "build_address1" || $key == "build_line_cd" || $key == "build_line_cd_name" || $key == "build_sta_cd" || $key == "build_sta_name_1" || $key == "build_sta_name_2" )$this->builddat[$curpos][$key] = $val;
				}
				$this->builddat[$curpos][$key] = $val;
			}
			$cnt++;
		}

		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(build_id) FROM base_v_build ";
		$strSQL .= $stmt2;
	//echo "GetBuild_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "viewdb_GetBuild(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "viewdb_GetBuild(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "viewdb_GetBuild(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}

}

?>
