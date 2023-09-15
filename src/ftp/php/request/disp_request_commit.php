<?php
/*----------------------------------------------------------
  処理部分
----------------------------------------------------------*/

// ページ更新処理禁止用
mt_srand(microtime()*100000);
$strBuffMst = md5(uniqid( mt_rand() , 1 ));
IF( $_SESSION["mst"] != $_POST["mst"] ){
	$arrErr["ath_comment"] = "物件リクエストメールは送信されております。";
	$obj_error->ViewErrMessage( "NO_RELOAD" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}



// 物件リクエストメール内容生成
if( count($_POST) != 0 ){
	foreach($_POST as $key => $val){
		if($key != "madori"){
			$val = htmlspecialchars(stripslashes($val));
			$arrRequestValue[$key] = $val;
			$arrRequestValue['hidden'] .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">";
		}
	}
}
if( count($_POST['madori']) != 0 ){
	foreach($_POST['madori'] as $key => $val){
		$arrRequestValue['hidden'] .= "<input type=\"hidden\" name=\"madori[$key]\" value=\"{$val}\">";
	}
}

$arrRequestValue["otherEquip"] = str_replace( "\r\n" , "\n" , $arrRequestValue["otherEquip"]);

if($arrRequestValue["sex"] == 1){
	$arrViewData["sex"][1] = "男性";
}else if($arrRequestValue["sex"] == 2){
	$arrViewData["sex"][2] = "女性";
}

if($arrRequestValue["report_type_1"] != ""){
	$arrViewData["report_type_1"] = "連絡OK<BR>";
}
if($arrRequestValue["report_type_2"] != ""){
	$arrViewData["report_type_2"] = " 連絡OK<BR>";
}
if($arrRequestValue["report_type_3"] != ""){
	$arrViewData["report_type_3"] = " 連絡OK<BR>";
}
if($arrRequestValue["report_type_4"] != ""){
	$arrViewData["report_type_4"] = " 連絡OK<BR>";
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

// 入居人数
reset( $param_request_number );
asort( $param_request_number["disp_no"] );
$request_menber_value = "";
FOREACH( $param_request_number["disp_no"] as $key => $val ){
	IF( $param_request_number['id'][$key] == $arrRequestValue["menber"] ){
		$request_menber_value = $param_request_number['val'][$key];
		break;
	}
}

// 希望間取り
reset( $param_room_floor );
asort( $param_room_floor["disp_no"] );
$room_floor_value = "";
$cnt = 0;
FOREACH( $param_room_floor["disp_no"] as $key => $val ){
	$checked = "";
	if(count($_POST["madori"]) != 0){
		FOREACH( $_POST["madori"] as $key2 => $val2 ){
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


// お問合せメール送信
require_once( SYS_PATH."php/request/request_send_mail.php" );


// 画面表示内容生成
$arrVD = Array();
$arrVD["company_name"] = $obj_login->clientdat[0]["cl_name"]." ".$obj_login->clientdat[0]["cl_shiten"];
$arrVD["company_address"] = $obj_login->clientdat[0]["cl_pref"].$obj_login->clientdat[0]["cl_address1"].$obj_login->clientdat[0]["cl_address2"]."　".$obj_login->clientdat[0]["cl_address3"];
$arrVD["company_tell"] = $obj_login->clientdat[0]["cl_tell"];
$arrVD["company_fax"] = $obj_login->clientdat[0]["cl_fax"];
$arrVD["company_time"] = $obj_login->clientdat[0]["blog_start_time"]."〜".$obj_login->clientdat[0]["blog_end_time"];
$arrVD["company_holiday"] = $obj_login->clientdat[0]["blog_holiday"];
$arrVD["company_build_no"] = $obj_login->clientdat[0]["blog_cl_build_no"];
$arrViewData = Array();
FOREACH( $arrVD as $key => $val ){
	$arrViewData[$key] = htmlspecialchars( stripslashes( $val ) );
}


// ページ更新処理禁止用
$_SESSION["mst"] = $strBuffMst;


?>
