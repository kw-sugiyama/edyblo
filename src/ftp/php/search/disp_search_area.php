<?
/*=======================================================
    エリア検索用処理
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




// 指定クライアントの物件を検索
$obj_build = new viewdb_BuildClassTblAccess();
$obj_build->conn = $obj_conn->conn;
$obj_build->jyoken["build_cl_id"] = _cl_id;	// 指定クライアント
$obj_build->jyoken["build_del_date"] = 1;	// 物件情報が削除されていない
$obj_build->jyoken["room_del_date"] = 1;	// 部屋情報が削除されていない
$obj_build->sort["search_area"] = 1;		// 並び順 - 県コード＆住所コードの降順
list( $intCnt_b_area , $intTotal_b_area ) = $obj_build->viewdb_GetBuild( 1 , -1 );
IF( $intCnt_b_area == -1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}


//------------------------------------------------------------------------------
// 表示値の取得／整理
//    $arrBuffList[pref_cd][name]           ... 都道府県名
//                [pref_cd][addr_cd][name]  ... 市区郡名
//                [pref_cd][addr_cd][count] ... 件数
//------------------------------------------------------------------------------
$arrBuffList = Array();
FOR( $iX=0; $iX<$intCnt_b_area; $iX++ ){
	
	$strBuffBuildPrefCd = "";
	$strBuffBuildAddrCd = "";
	$strBuffBuildPrefCd = $obj_build->builddat[$iX]["build_pref_cd"];
	$strBuffBuildAddrCd = $obj_build->builddat[$iX]["build_addr_cd"];
	
	// 既に $arrBuffList[県コード] があるかどうか
	IF( isset( $arrBuffList[$strBuffBuildPrefCd] ) === FALSE ){
		$arrBuffList[$strBuffBuildPrefCd] = Array();
		$arrBuffList[$strBuffBuildPrefCd]["name"] = $obj_build->builddat[$iX]["build_pref"];
	}
	
	// 既に $arrBuffList[県コード][住所コード] があるかどうか
	IF( isset( $arrBuffList[$strBuffBuildPrefCd][$strBuffBuildAddrCd] ) === FALSE ){
		$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildAddrCd]["count"] = 1;
		$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildAddrCd]["name"] = $obj_build->builddat[$iX]["build_address1"];
	}ELSE{
		$arrBuffList[$strBuffBuildPrefCd][$strBuffBuildAddrCd]["count"]++;
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
	$arrViewData["list"] .= "<TABLE class=\"wide\"><tr>\n";
			$buffCnt = 0;
	FOREACH( $val as $key2 => $val2 ){
		IF( $key2 != "name" ){
			$buffAddrName = htmlspecialchars( $val2["name"] );
			$buffAddrCnt = intval( $val2["count"] );
			$buffAddrNameED = urlencode( $buffAddrName );
			
			$arrViewData["list"] .= "      <td><INPUT type=\"checkbox\" name=\"pf[]\" id=\"{$key}{$key2}\" value=\"{$key2}/{$buffAddrName}\" /><a href=\""._BLOG_SITE_URL_BASE."search-result/page-1.html?pf[]={$key2}/{$buffAddrNameED}&mode=search\">";
			$arrViewData["list"] .= "{$buffAddrName}({$buffAddrCnt}件)</a></td>\n";
			$buffCnt++;
			
			IF( $buffCnt == 3 ){
				$arrViewData["list"] .= "    </TR><TR>\n";
				$buffCnt = 0;
			}
			
		}
	}
	$arrViewData["list"] .= "</tr></TABLE>\n";
	$arrViewData["list"] .= "  </TD></TR>\n";
	
}


?>
