<?
/*=======================================================
    駅名検索用処理
=======================================================*/
if($_POST['fa'] != "")$_GET['fa'] = $_POST['fa'];

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



// 沿線指定が無い場合はエラー
IF( $_GET["ln"] == "" ){
	$obj_error->ViewErrMessage( "NO_LINE_SITEI" , "USER" , _BLOG_SITE_URL_BASE."search-staline/" , $arrErr );
	exit;
}

$_GET["ln"] = array_unique($_GET["ln"]);
foreach( $_GET["ln"] as $key => $val){
	$getLine[$key] = split( "/",$val );
}
// 指定クライアントの物件を検索
$obj_build = new viewdb_BuildClassTblAccess();
$obj_build->conn = $obj_conn->conn;
$obj_build->jyoken["build_cl_id"] = _cl_id;			// 指定クライアント
$obj_build->jyoken["build_del_date"] = 1;			// 物件情報が削除されていない
$obj_build->jyoken["room_del_date"] = 1;			// 部屋情報が削除されていない
IF( count( $_GET["ln"] ) != 0 ){
	FOREACH( $getLine as $key => $val ){
		$pref_cd[] = $val[2];
		$obj_build->jyoken["line"][] = $val[1];
	}
	$pref_cd = array_unique($pref_cd);
	FOREACH( $pref_cd as $key => $val ){
		$obj_build->jyoken["pref_cd"][] = $val;
	}
}
$obj_build->sort["search_area"] = 1;				// 並び順 - 県コード＆住所コードの降順
list( $intCnt_b_line , $intTotal_b_line ) = $obj_build->viewdb_GetBuild( 1 , -1 );
IF( $intCnt_b_area == -1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}


//------------------------------------------------------------------------------
// 表示値の取得／整理
//    $arrBuffList[pref_cd][line_cd][name]  ... 市区郡名
//                [pref_cd][line_cd][count] ... 件数
//------------------------------------------------------------------------------
$arrBuffList = Array();
FOR( $iX=0; $iX<$intCnt_b_line; $iX++ ){
	
	$strBuffBuildLineNameCd = "";
	$strBuffBuildStaNameCd = "";
	$strBuffBuildLineCd = "";
	$strBuffBuildLineCd = split("-",$obj_build->builddat[$iX]["build_line_cd"]);
	$strBuffBuildLineCd[0] = split("/",$strBuffBuildLineCd[0]);
	$strBuffBuildLineCd[1] = split("/",$strBuffBuildLineCd[1]);
	$strBuffBuildLineNameCd = split("-",$obj_build->builddat[$iX]["build_line_cd_name"]);
	$strBuffBuildLineNameCd[0] = split("/",$strBuffBuildLineNameCd[0]);
	$strBuffBuildLineNameCd[1] = split("/",$strBuffBuildLineNameCd[1]);
	$strBuffBuildStaNameCd = split("-",$obj_build->builddat[$iX]["build_sta_cd"]);
	
	// 既に $arrBuffList[県コード] があるかどうか
	FOREACH( $getLine as $key => $val ){
		IF( isset( $arrBuffList[$val[1]] ) === FALSE ){
			$arrBuffList[$val[1]] = Array();
			$arrBuffList[$val[1]]["name"] = $val[0];
		}
	}
	
	// 既に $arrBuffList[県コード] があるかどうか
	foreach( $getLine as $key => $val ){
		$line_cd[] = $val[1];
	}
	$line_cd = array_unique($line_cd);
	FOREACH( $line_cd as $key => $val ){
		for($jX=0;$jX<count($strBuffBuildLineCd[0]);$jX++){
			IF( $strBuffBuildLineCd[0][$jX] == $val ){
				if(!isset($arrBuffList[$strBuffBuildLineCd[0][$jX]][$strBuffBuildStaNameCd[0]]["name"])){
					$arrBuffList[$strBuffBuildLineCd[0][$jX]][$strBuffBuildStaNameCd[0]]["count"] = 1;
					$arrBuffList[$strBuffBuildLineCd[0][$jX]][$strBuffBuildStaNameCd[0]]["name"] = $obj_build->builddat[$iX]["build_sta_name_1"];
					$arrBuffList[$strBuffBuildLineCd[0][$jX]][$strBuffBuildStaNameCd[0]]["code"] = $strBuffBuildStaNameCd[0];
				}else{
					$arrBuffList[$strBuffBuildLineCd[0][$jX]][$strBuffBuildStaNameCd[0]]["count"]++;
				}
			}
		}
	}
	FOREACH( $line_cd as $key => $val ){
		for($jX=0;$jX<count($strBuffBuildLineCd[1]);$jX++){
			IF( $strBuffBuildLineCd[1][$jX] == $val ){
				if(!isset($arrBuffList[$strBuffBuildLineCd[1][$jX]][$strBuffBuildStaNameCd[1]]["name"])){
					$arrBuffList[$strBuffBuildLineCd[1][$jX]][$strBuffBuildStaNameCd[1]]["count"] = 1;
					$arrBuffList[$strBuffBuildLineCd[1][$jX]][$strBuffBuildStaNameCd[1]]["name"] = $obj_build->builddat[$iX]["build_sta_name_2"];
					$arrBuffList[$strBuffBuildLineCd[1][$jX]][$strBuffBuildStaNameCd[1]]["code"] = $strBuffBuildStaNameCd[1];
				}else{
					$arrBuffList[$strBuffBuildLineCd[1][$jX]][$strBuffBuildStaNameCd[1]]["count"]++;
				}
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
	
	$arrViewData["list"] .= "<TR>\n";
	$arrViewData["list"] .= "  <TR>\n";
	$arrViewData["list"] .= "    <TH>{$buffPrefName}<a name=\"{$key}\" id=\"{$key}\"></a></TH>\n";
	$arrViewData["list"] .= "  <TR><TD>\n";
	$arrViewData["list"] .= "<TABLE class=\"wide\"><TR>\n";
			$buffCnt = 0;
	FOREACH( $val as $key2 => $val2 ){
		IF( $key2 != "name" ){
			$buffStaName = htmlspecialchars( $val2["name"] );
			$buffStaCode = htmlspecialchars( $val2["code"] );
			$buffStaCnt = intval( $val2["count"] );
			$buffStaNameED = urlencode($buffStaName);

			$arrViewData["list"] .= "      <TD><INPUT type=\"checkbox\" name=\"st[]\" id=\"{$key}{$key2}\" value=\"{$buffStaCode}/{$buffStaName}\" /><a href=\""._BLOG_SITE_URL_BASE."search-result/page-1.html?st[]={$key2}/{$buffStaNameED}&s_mode=st&mode=search\">";
			$arrViewData["list"] .= "{$buffStaName}({$buffStaCnt}件)</a></TD>\n";
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
