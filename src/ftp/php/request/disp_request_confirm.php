<?php
/*----------------------------------------------------------
  処理部分
----------------------------------------------------------*/


// 表示内容生成
$blog_cl_kojin = htmlspecialchars($obj_login->blogdat[0]['blog_cl_kojin']);


if( count($_POST) != 0 ){
	foreach($_POST as $key => $val){
		if($key != "madori"){
			$val = htmlspecialchars(stripslashes($val));
			$arrRequestValue[$key] = $val;
			$arrRequestValue['hidden'] .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">";
		}
	}
}
if(count($_POST['madori'])!=0){
	foreach($_POST['madori'] as $key => $val){
		$arrRequestValue['hidden'] .= "<input type=\"hidden\" name=\"madori[$key]\" value=\"{$val}\">";
	}
}

// 入力内容チェック
require_once( SYS_PATH."php/request/request_input_check.php" );


$arrRequestValue["otherEquip"] = str_replace("\r\n","<BR>",$arrRequestValue["otherEquip"]);

IF( $arrRequestValue["sex"] == 1 ){
	$arrViewData["sex"] = "男性";
}ELSEIF( $arrRequestValue["sex"] == 2 ){
	$arrViewData["sex"] = "女性";
}

IF( $arrRequestValue["old"] != "" ){
	$arrViewData["old"] = $arrRequestValue["old"]."歳";
}

if($arrRequestValue["report_type_1"] != ""){
	$arrViewData["tell"] = "";
        $arrViewData["tell"] .= $arrRequestValue["tell_1"]."-".$arrRequestValue["tell_2"]."-".$arrRequestValue["tell_3"]."&nbsp;";
        $arrViewData["tell"] .= "※連絡ご希望の時間帯：".$arrRequestValue["tell_time"];
}
if($arrRequestValue["report_type_2"] != ""){
	$arrViewData["fax"] = "";
	$arrViewData["fax"] .= $arrRequestValue["fax_1"]."-".$arrRequestValue["fax_2"]."-".$arrRequestValue["fax_3"];
}
if($arrRequestValue["report_type_3"] != ""){
	$arrViewData["address"] = "";
	$arrViewData["address"] .= "〒".$arrRequestValue["addr_cd_1"]."-".$arrRequestValue["addr_cd_2"]."&nbsp;";
	$arrViewData["address"] .= $arrRequestValue["address_1"]."　".$arrRequestValue["address_2"];
}
if($arrRequestValue["report_type_4"] != ""){
	$arrViewData["email"] = "";
	$arrViewData["email"] = $arrRequestValue["email"];
}


// 職業
reset( $param_request_work );
asort( $param_request_work["disp_no"] );
$request_work_value = "";
FOREACH( $param_request_work["disp_no"] as $key => $val ){
	IF( $param_request_work['id'][$key] == $arrRequestValue["work"] ){
		$request_work_value = $param_request_work['val'][$key];
		break;
	}
}

// 入居予定人数
reset( $param_request_number );
asort( $param_request_number["disp_no"] );
$request_menber_value = "";
FOREACH( $param_request_number["disp_no"] as $key => $val ){
	IF( $param_request_number['id'][$key] == $arrRequestValue["menber"] ){
		$request_menber_value = $param_request_number['val'][$key];
		break;
	}
}

// 部屋間取り
reset( $param_room_floor );
asort( $param_room_floor["disp_no"] );
$room_floor_value = "";
$cnt = 0;
FOREACH( $param_room_floor["disp_no"] as $key => $val ){
	$checked = "";
	if(count($_POST["madori"]) != 0){
		foreach($_POST["madori"] as $key2 => $val2){
			IF( $param_room_floor['id'][$key] == $val2 ){
				$room_floor_value .= $param_room_floor['val'][$key]."　";
			}
		}	
	}
	$cnt++;
}

// 勤務先・通学先までの希望所要時間
reset( $param_request_move_time );
asort( $param_request_move_time["disp_no"] );
$request_move_time_value = "";
FOREACH( $param_request_move_time["disp_no"] as $key => $val ){
        IF( $param_request_move_time["id"][$key] == $arrRequestValue["move"] ){
	        $request_move_time_value = $param_request_move_time["val"][$key];
		break;
	}
}

// 現在の家賃
reset( $param_request_now_price );
asort( $param_request_now_price["disp_no"] );
$request_now_price_value = "";
FOREACH( $param_request_now_price["disp_no"] as $key => $val ){
        IF( $param_request_now_price["id"][$key] == $arrRequestValue["nowPrice"] ){
	        $request_now_price_value = $param_request_now_price["val"][$key];
		break;
	}
}

// 入居予定時期
reset( $param_request_move_jiki );
asort( $param_request_move_jiki["disp_no"] );
$request_move_jiki_value = "";
FOREACH( $param_request_move_jiki["disp_no"] as $key => $val ){
        IF( $param_request_move_jiki["id"][$key] == $arrRequestValue["moveTime"] ){
	        $request_move_jiki_value = $param_request_move_jiki["val"][$key];
		break;
	}
}

// 希望の家賃（下限・上限）
reset( $param_request_price_down );
asort( $param_request_price_down["disp_no"] );
$request_price1_value = "";
$request_price2_value = "";
FOREACH( $param_request_price_down["disp_no"] as $key => $val ){

        IF( $param_request_price_down["id"][$key] == $arrRequestValue["price1"] ){
	        $request_price1_value = $param_request_price_down["val"][$key]."以上";
	}

        IF( $param_request_price_down["id"][$key] == $arrRequestValue["price2"] ){
	        $request_price2_value = $param_request_price_down["val"][$key]."未満";
	}
}




// 完了ページでのページ更新処理禁止用
mt_srand(microtime()*100000);
$strBuffMst = md5(uniqid( mt_rand() , 1 ));
$_SESSION["mst"] = $strBuffMst;
$arrViewData["mst"] = $strBuffMst;


?>
