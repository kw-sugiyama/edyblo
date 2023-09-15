<?php
/*----------------------------------------------------------
  処理部分
----------------------------------------------------------*/
// ブログ情報取得
$obj_blog = new viewdb_ClientClassTblAccess;
$obj_blog->conn = $obj_conn->conn;
$obj_blog->jyoken["blog_del_date"] = 1;
$obj_blog->jyoken["cl_id"] = _cl_id;
list( $intCnt2 , $intTotal2 ) = $obj_blog->viewdb_GetClient ( 1 , -1 );
IF( $intCnt2 == -1 ){
	$obj_error->ViewErrMessage( "SYSTEM" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}
IF( $intCnt2 != 1 ){
	$obj_error->ViewErrMessage( "SYSTEM" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}


// 表示内容生成
$blog_cl_kojin = htmlspecialchars($obj_blog->clientdat[0]['blog_cl_kojin']);

if( count($_POST) != 0 ){
	foreach($_POST as $key => $val){
		if($key != "madori"){
			$arrRequestValue[$key] = htmlspecialchars(stripslashes($val));
		}
	}
}

// 性別チェック
if($arrRequestValue["sex"] == 1){
	$arrViewData["sex"][1] = " checked";
}else if($arrRequestValue["sex"] == 2){
	$arrViewData["sex"][2] = " checked";
}

// 連絡方法チェック
if($arrRequestValue["report_type_1"] != ""){
	$arrViewData["report_type_1"] = " checked";
}
if($arrRequestValue["report_type_2"] != ""){
	$arrViewData["report_type_2"] = " checked";
}
if($arrRequestValue["report_type_3"] != ""){
	$arrViewData["report_type_3"] = " checked";
}
if($arrRequestValue["report_type_4"] != ""){
	$arrViewData["report_type_4"] = " checked";
}

// 職業
asort( $param_request_work["disp_no"] );
$request_work_value = "";
$buffReqCnt = 0;
FOREACH( $param_request_work["disp_no"] as $key => $val ){
	$checked = "";
	if($param_request_work['id'][$key] == $arrRequestValue["work"])$checked = " checked";
	IF( $buffReqCnt == 0 ){
		$request_work_value .= "  <tr>\n";
	}
	$request_work_value .= "    <td class=\"noborder\"><input type=\"radio\" name=\"work\" id=\"{$param_request_work['val'][$key]}\" value=\"{$param_request_work['id'][$key]}\"{$checked} /><label for=\"{$param_request_work['val'][$key]}\">{$param_request_work['val'][$key]}</label></td>\n";
	$buffReqCnt++;
	IF( $buffReqCnt == 4 ){
		$request_work_value .= "  </tr>\n";
		$buffReqCnt = 0;
	}
}
IF( $buffReqCnt != 4 ){
	FOR( $iX=$buffReqCnt; $iX<4; $iX++ ){
		$request_work_value .= "    <td class=\"noborder\">&nbsp;</td>\n";
	}
	$request_work_value .= "  </tr>\n";
}

// 入居予定人数
reset( $param_request_number );
asort( $param_request_number["disp_no"] );
$request_menber_value = "";
FOREACH( $param_request_number["disp_no"] as $key => $val ){
	$checked = "";
	if($param_request_number['id'][$key] == $arrRequestValue["menber"])$checked = " checked";	
	$request_menber_value .= "  <td class=\"noborder\"><input type=\"radio\" name=\"menber\" id=\"{$param_request_number['val'][$key]}\" value=\"{$param_request_number['id'][$key]}\"{$checked} /><label for=\"{$param_request_number['val'][$key]}\">{$param_request_number['val'][$key]}</label></td>\n";
}

// 部屋間取り
asort( $param_room_floor["disp_no"] );
$room_floor_value = "";
$cnt = 0;
FOREACH( $param_room_floor["disp_no"] as $key => $val ){
	$checked = "";
	if(count($_POST["madori"]) != 0){
		foreach($_POST["madori"] as $key2 => $val2){
			if($param_room_floor['id'][$key] == $val2)$checked = " checked";
		}	
	}
	$room_floor_value .= "<input type=\"checkbox\" name=\"madori[$cnt]\" value=\"{$param_room_floor['id'][$key]}\"{$checked}>{$param_room_floor['val'][$key]}";
	$cnt++;
}

// 勤務先・通学先までの希望所要時間
reset( $param_request_move_time );
asort( $param_request_move_time["disp_no"] );
$request_move_time_value = "";
$strChk = "";
IF( $arrRequestValue["move"] == "" ) $strChk = " selected";
$request_move_time_value .= "  <OPTION value=\"\"{$strChk}>選択して下さい</OPTION>\n";
FOREACH( $param_request_move_time["disp_no"] as $key => $val ){
	$strChk = "";
	IF( $param_request_move_time["id"][$key] == $arrRequestValue["move"] ) $strChk = " selected";
	$request_move_time_value .= "  <OPTION value=\"{$param_request_move_time["id"][$key]}\"{$strChk}>{$param_request_move_time["val"][$key]}</OPTION>\n";
}


// 現在の家賃
reset( $param_request_now_price );
asort( $param_request_now_price["disp_no"] );
$request_now_price_value = "";
$strChk = "";
IF( $arrRequestValue["nowPrice"] == "" ) $strChk = " selected";
$request_now_price_value .= "  <OPTION value=\"\"{$strChk}>選択して下さい</OPTION>\n";
FOREACH( $param_request_now_price["disp_no"] as $key => $val ){
	$strChk = "";
	IF( $param_request_now_price["id"][$key] == $arrRequestValue["nowPrice"] ) $strChk = " selected";
	$request_now_price_value .= "  <OPTION value=\"{$param_request_now_price["id"][$key]}\"{$strChk}>{$param_request_now_price["val"][$key]}</OPTION>\n";
}


// 入居予定時期
reset( $param_request_move_jiki );
asort( $param_request_move_jiki["disp_no"] );
$request_move_jiki_value = "";
$strChk = "";
IF( $arrRequestValue["moveTime"] == "" ) $strChk = " selected";
$request_move_jiki_value .= "  <OPTION value=\"\"{$strChk}>選択して下さい</OPTION>\n";
FOREACH( $param_request_move_jiki["disp_no"] as $key => $val ){
	$strChk = "";
	IF( $param_request_move_jiki["id"][$key] == $arrRequestValue["moveTime"] ) $strChk = " selected";
	$request_move_jiki_value .= "  <OPTION value=\"{$param_request_move_jiki["id"][$key]}\"{$strChk}>{$param_request_move_jiki["val"][$key]}</OPTION>\n";
}


// 希望の家賃（下限・上限）
reset( $param_request_price_down );
asort( $param_request_price_down["disp_no"] );
$request_price1_value = "";
$request_price2_value = "";

$strChk = "";
IF( $arrRequestValue["price1"] == "" ) $strChk = " selected";
$request_price1_value .= "  <OPTION value=\"\"{$strChk}>選択して下さい</OPTION>\n";
$strChk = "";
IF( $arrRequestValue["price2"] == "" ) $strChk = " selected";
$request_price2_value .= "  <OPTION value=\"\"{$strChk}>選択して下さい</OPTION>\n";

FOREACH( $param_request_price_down["disp_no"] as $key => $val ){
	
	$strChk = "";
	IF( $param_request_price_down["id"][$key] == $arrRequestValue["price1"] ) $strChk = " selected";
	$request_price1_value .= "  <OPTION value=\"{$param_request_price_down["id"][$key]}\"{$strChk}>{$param_request_price_down["val"][$key]}以上</OPTION>\n";
	
	$strChk = "";
	IF( $param_request_price_down["id"][$key] == $arrRequestValue["price2"] ) $strChk = " selected";
	$request_price2_value .= "  <OPTION value=\"{$param_request_price_down["id"][$key]}\"{$strChk}>{$param_request_price_down["val"][$key]}未満</OPTION>\n";

}


?>
