<?
/*=======================================================
    沿線検索用処理
=======================================================*/
if($_POST['fa'] != "")$_GET['fa'] = $_POST['fa'];

// 飛び先指定
if($_GET['page_flg']=="line"){
	$formAct = _BLOG_SITE_URL_BASE."search-result/page-1.html";
	$lineTitleVal1 = "沿線名";
}
if($_GET['page_flg']=="staline"){
	$formAct = _BLOG_SITE_URL_BASE."search-sta/";
	$lineTitleVal1 = "駅名";
}


// こだわり条件エラー戻りPOST値をGETにリストア
IF( count( $_POST['search_equip'] ) != 0 ){
	FOREACH( $_POST['search_equip'] as $key => $val ){
		$_GET['search_equip'][$key] = $val;
	}
}
IF( count( $_POST['search_madori'] ) != 0 ){
	FOREACH( $_POST['search_madori'] as $key => $val ){
		$_GET['search_madori'][$key] = $val;
	}
}
IF( count( $_POST['search_type'] ) != 0 ){
	FOREACH( $_POST['search_type'] as $key => $val ){
		$_GET['search_type'][$key] = $val;
	}
}
IF( count( $_POST['search_material'] ) != 0 ){
	FOREACH( $_POST['search_material'] as $key => $val ){
		$_GET['search_material'][$key] = $val;
	}
}
if($_POST['sikirei']!=0 && $_POST['sikirei']!="" && $_POST['sikirei']!=null ){
		$_GET['sikirei'] = $_POST['sikirei'];
}
if($_POST['search_price']!=0 && $_POST['search_price']!="" && $_POST['search_price']!=null ){
		$_GET['search_price'] = $_POST['search_price'];
}
if($_POST['search_price_limit']!=0 && $_POST['search_price_limit']!="" && $_POST['search_price_limit']!=null ){
		$_GET['search_price_limit'] = $_POST['search_price_limit'];
}
if($_POST['search_area']!=0 && $_POST['search_area']!="" && $_POST['search_area']!=null ){
		$_GET['search_area'] = $_POST['search_area'];
}
if($_POST['search_area_limit']!=0 && $_POST['search_area_limit']!="" && $_POST['search_area_limit']!=null ){
		$_GET['search_area_limit'] = $_POST['search_area_limit'];
}
if($_POST['search_station']!=0 && $_POST['search_station']!="" && $_POST['search_station']!=null ){
		$_GET['search_station'] = $_POST['search_station'];
}
if($_POST['search_date']!=0 && $_POST['search_date']!="" && $_POST['search_date']!=null ){
		$_GET['search_date'] = $_POST['search_date'];
}


// こだわり条件Hidden値作成
IF( count( $_GET['search_equip'] ) != 0 ){
	FOREACH( $_GET['search_equip'] as $key => $val ){
		$hddnVal .= "<input type=\"hidden\" name=\"search_equip[{$key}]\" value=\"{$val}\">\n";
		$addrVal .= "&search_equip[{$key}]=".$val;
	}
}
IF( count( $_GET['search_madori'] ) != 0 ){
	FOREACH( $_GET['search_madori'] as $key => $val ){
		$hddnVal .= "<input type=\"hidden\" name=\"search_madori[]\" value=\"{$val}\">\n";
		$addrVal .= "&search_madori[]=".$val;
	}
}
IF( count( $_GET['search_type'] ) != 0 ){
	FOREACH( $_GET['search_type'] as $key => $val ){
		$hddnVal .= "<input type=\"hidden\" name=\"search_type[]\" value=\"{$val}\">\n";
		$addrVal .= "&search_type[]=".$val;
	}
}
IF( count( $_GET['search_material'] ) != 0 ){
	FOREACH( $_GET['search_material'] as $key => $val ){
		$hddnVal .= "<input type=\"hidden\" name=\"search_material[]\" value=\"{$val}\">\n";
		$addrVal .= "&search_material[]=".$val;
	}
}
if($_GET['sikirei']!=0 && $_GET['sikirei']!="" && $_GET['sikirei']!=null ){
	$hddnVal .= "<input type=\"hidden\" name=\"sikirei\" value=\"{$_GET['sikirei']}\">\n";
	$addrVal .= "&sikirei=".$_GET['sikirei'];
}
if($_GET['search_price']!=0 && $_GET['search_price']!="" && $_GET['search_price']!=null ){
	$hddnVal .= "<input type=\"hidden\" name=\"search_price\" value=\"{$_GET['search_price']}\">\n";
	$addrVal .= "&search_price=".$_GET['search_price'];
}
if($_GET['search_price_limit']!=0 && $_GET['search_price_limit']!="" && $_GET['search_price_limit']!=null ){
	$hddnVal .= "<input type=\"hidden\" name=\"search_price_limit\" value=\"{$_GET['search_price_limit']}\">\n";
	$addrVal .= "&search_price_limit=".$_GET['search_price_limit'];
}
if($_GET['search_area']!=0 && $_GET['search_area']!="" && $_GET['search_area']!=null ){
	$hddnVal .= "<input type=\"hidden\" name=\"search_area\" value=\"{$_GET['search_area']}\">\n";
	$addrVal .= "&search_area=".$_GET['search_area'];
}
if($_GET['search_area_limit']!=0 && $_GET['search_area_limit']!="" && $_GET['search_area_limit']!=null ){
	$hddnVal .= "<input type=\"hidden\" name=\"search_area_limit\" value=\"{$_GET['search_area_limit']}\">\n";
	$addrVal .= "&search_area_limit=".$_GET['search_area_limit'];
}
if($_GET['search_station']!=0 && $_GET['search_station']!="" && $_GET['search_station']!=null ){
	$hddnVal .= "<input type=\"hidden\" name=\"search_station\" value=\"{$_GET['search_station']}\">\n";
	$addrVal .= "&search_station=".$_GET['search_station'];
}
if($_GET['search_date']!=0 && $_GET['search_date']!="" && $_GET['search_date']!=null ){
	$hddnVal .= "<input type=\"hidden\" name=\"search_date\" value=\"{$_GET['search_date']}\">\n";
	$addrVal .= "&search_date=".$_GET['search_date'];
}


// 指定クライアントの物件を検索
$obj_build = new viewdb_BuildClassTblAccess();
$obj_build->conn = $obj_conn->conn;
$obj_build->jyoken["build_cl_id"] = _cl_id;	// 指定クライアント
$obj_build->jyoken["build_del_date"] = 1;	// 物件情報が削除されていない
$obj_build->jyoken["room_del_date"] = 1;	// 部屋情報が削除されていない
$obj_build->sort["search_area"] = 1;		// 並び順 - 県コード＆住所コードの降順
list( $intCnt_b_line , $intTotal_b_line ) = $obj_build->viewdb_GetBuild( 1 , -1 );
IF( $intCnt_b_area == -1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}

//------------------------------------------------------------------------------
// 表示値の取得／整理
//    $arrBuffList[pref_cd][name]           ... 都道府県名
//                [pref_cd][line_cd][name]  ... 市区郡名
//                [pref_cd][line_cd][count] ... 件数
//------------------------------------------------------------------------------
$arrBuffList = Array();
FOR( $iX=0; $iX<$intCnt_b_line; $iX++ ){
	
	$strBuffBuildPrefCd = "";
	$strBuffBuildLineCd = "";
	$strBuffBuildPrefCd = $obj_build->builddat[$iX]["build_pref_cd"];
if($strBuffBuildPrefCd == 3)echo($obj_build->builddat[$iX]["build_line_cd"]);
	$strBuffBuildLineCd = split("-",$obj_build->builddat[$iX]["build_line_cd"]);
	$strBuffBuildLineCd[0] = split("/",$strBuffBuildLineCd[0]);
	$strBuffBuildLineCd[1] = split("/",$strBuffBuildLineCd[1]);
	$strBuffBuildLineNameCd = split("-",$obj_build->builddat[$iX]["build_line_cd_name"]);
	$strBuffBuildLineNameCd[0] = split("/",$strBuffBuildLineNameCd[0]);
	$strBuffBuildLineNameCd[1] = split("/",$strBuffBuildLineNameCd[1]);
	// 既に $arrBuffList[県コード] があるかどうか
	IF( isset( $arrBuffList[$strBuffBuildPrefCd] ) === FALSE ){
		$arrBuffList[$strBuffBuildPrefCd] = Array();
		$arrBuffList[$strBuffBuildPrefCd]["name"] = $obj_build->builddat[$iX]["build_pref"];
	}
	// 既に $arrBuffList[県コード][沿線コード1] があるかどうか
	$line1Cnt = count($strBuffBuildLineCd[0])-1;
	for($jX=1;$jX<$line1Cnt;$jX++){
		if($strBuffBuildLineCd[0][$jX] != ""){
			IF( isset( $arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[0][$jX]] ) === FALSE ){
				$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[0][$jX]]["count"] = 1;
				$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[0][$jX]]["name"] = $strBuffBuildLineNameCd[0][$jX];
				$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[0][$jX]]["code"] = $strBuffBuildLineCd[0][$jX];
			}ELSE{
				$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[0][$jX]]["count"]++;
			}
		}
	}

	// 既に $arrBuffList[県コード][沿線コード2] があるかどうか
	$line2Cnt = count($strBuffBuildLineCd[1])-1;
	for($kX=1;$kX<$line2Cnt;$kX++){
		$doubleFlg = 0;
		foreach($strBuffBuildLineCd[0] as $key => $val){
			if($strBuffBuildLineCd[1][$kX] == $val)$doubleFlg = 9;
		}
		if($strBuffBuildLineCd[1][$kX] != "" && $doubleFlg != 9){
			IF( isset( $arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[1][$kX]] ) === FALSE ){
				$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[1][$kX]]["count"] = 1;
				$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[1][$kX]]["name"] = $strBuffBuildLineNameCd[1][$kX];
				$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[1][$kX]]["code"] = $strBuffBuildLineCd[1][$kX];
			}ELSE{
				$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildLineCd[1][$kX]]["count"]++;
			}
		}
	}
	
}



//------------------------------------------------------------------------------
// 表示内容生成
$arrViewData = Array();

FOREACH( $arrBuffList as $key => $val ){
	
	$buffPrefName = htmlspecialchars( $val["name"] );
	
	$arrViewData["index"] .= "      <A href=\"#{$key}\">{$buffPrefName}</A>";
	
	$arrViewData["list"] .= "  <TR>\n";
	$arrViewData["list"] .= "    <TH>{$buffPrefName}<a name=\"{$key}\" id=\"{$key}\"></a></TH>\n";
	$arrViewData["list"] .= "  </TR>\n";
	$arrViewData["list"] .= "  <TR><TD>\n";
	$arrViewData["list"] .= "<TABLE class=\"wide\"><TR>\n";
	$buffCnt = 0;
	FOREACH( $val as $key2 => $val2 ){
		IF( $key2 != "name" ){
			$buffLineName = htmlspecialchars( $val2["name"] );
			$buffLineCode = htmlspecialchars( $val2["code"] );
			$buffLineCnt = intval( $val2["count"] );
			$buffLineNameED = urlencode($buffLineName);
			
			$arrViewData["list"] .= "      <TD><INPUT type=\"checkbox\" name=\"ln[]\" id=\"{$key}{$key2}\" value=\"{$buffLineName}/{$buffLineCode}/{$key}\" /><a href=\"{$formAct}?ln[]={$buffLineNameED}/{$buffLineCode}/{$key}&s_mode=ln&mode=search\">";
			$arrViewData["list"] .= "{$buffLineName}({$buffLineCnt}件)</a></TD>\n";
			$buffCnt++;
			
			IF( $buffCnt == 3 ){
				$arrViewData["list"] .= "    </TR><TR>\n";
				$buffCnt = 0;
			}
		}
	}
	$arrViewData["list"] .= "  </TR>\n";
	$arrViewData["list"] .= "</TABLE>\n";
	$arrViewData["list"] .= "<br />\n";
	
}


?>
