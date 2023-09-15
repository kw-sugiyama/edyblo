<?php

// クライアントチェック＆レイアウト指定
//    => $obj_login に指定クライアント情報格納済
//    => _cl_id に指定クライアントID保持
//    => レイアウト情報は、定数"_SITE_LAYOUT"に保持
require_once( SYS_PATH."php/client_check.php" );


// ヘッダー情報生成
//    => 画面上の表示内容を生成
//    => 生成値は $arrHeaderView 又は $arrMetaHeader に格納
require_once( SYS_PATH."php/disp_header.php" );


// カテゴリー一覧情報生成
//    => 画面中央左の表示内容を生成
//    => 生成値は $arrViewLeft に格納
require_once( SYS_PATH."php/disp_left.php" );


// ログファイルへ書き込み処理
//    => 指定ログディレクトリにあるファイルへ書き込み
//    => アドレスは ○○ に格納
require_once( SYS_PATH."php/disp_log_write.php" );




//---------------------------------------------------------------------------
// クライアント情報を格納
$arrClientData = Array();
FOREACH( $obj_login->clientdat[0] as $key => $val ){
	$arrClientData[$key] = htmlspecialchars( stripslashes( $val ) );
}


//---------------------------------------------------------------------------
// POST値を格納
$arrInputData = Array();
$strInputHidden = "";
FOREACH( $_POST as $key => $val ){
	$arrInputData[$key] = htmlspecialchars( stripslashes( $val ) );
	$strInputHidden .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$arrInputData[$key]}\" />\n";
}


//---------------------------------------------------------------------------
// 表示画面チェック
//	$_POST["form_flg"] ... どの画面から来たか
//	$strDispFlg        ... 次に表示する内容
//---------------------------------------------------------------------------
$strDispFlg = "";
IF( $_POST["form_flg"] == "" ){
	// 何も無いのでindex
	$strDispFlg = "INDEX";
}ELSE{
	SWITCH( $_POST["form_flg"] ){
		Case "INDEX":
			// 入力内容チェック
			//   => OK:$intInputChkFlg=1  NG:$intInputChkFlg=9;
			require_once( SYS_PATH."php/inquiry/inquiry_input_check.php" );
			$intInputChkFlg = 1;
			IF( $intInputChkFlg == 1 ){
				$strDispFlg = "CONFIRM";
			}ELSE{
				$strDispFlg = "INDEX";
			}
			break;
		Case "CONFIRM":
			$strDispFlg = "COMMIT";
			break;
	}
}


//---------------------------------------------------------------------------
// $strDispFlg によって表示内容決定
SWITCH( $strDispFlg ){
	// 入力画面 => テンプレート表示のみ
	default:
	Case "INDEX":
		
		$arrViewData = Array();
		reset( $param_inquiry_work );
		asort( $param_inquiry_work["disp_no"] );
		$intBuffCnt = 0;
		FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
			$strChk = "";
			IF( $arrInputData["work_kind"] == $param_inquiry_work["id"][$key] ) $strChk = " checked";
			IF( $intBuffCnt == 0 ){
				$arrViewData["work_kind"] .= "<tr>\n";
			}
			$arrViewData["work_kind"] .= "  <td class=\"noborder\">";
			$arrViewData["work_kind"] .= "<INPUT id=\"{$param_inquiry_work["val"][$key]}\" type=\"radio\" name=\"work_kind\" value=\"{$param_inquiry_work["id"][$key]}\" {$strChk}/>";
			$arrViewData["work_kind"] .= "<label for=\"{$param_inquiry_work["val"][$key]}\">{$param_inquiry_work["val"][$key]}</label>";
			$arrViewData["work_kind"] .= "</td>\n";
			$intBuffCnt++;
			IF( $intBuffCnt == 4 ){
				$arrViewData["work_kind"] .= "</tr>\n";
				$intBuffCnt = 0;
			}
		}
		IF( $intBuffCnt != 4 ){
			FOR( $iX=$intBuffCnt; $iX<4; $iX++ ){
				$arrViewData["work_kind"] .= "  <td class=\"noborder\">&nbsp;</td>\n";
			}
			$arrViewData["work_kind"] .= "</tr>\n";
		}
		
		IF( $arrInputData["sex"] == 1 ){
			$arrViewData["sex"][1] = " checked";
		}ELSEIF( $arrInputData["sex"] == 2 ){
			$arrViewData["sex"][2] = " checked";
		}
		IF( $arrInputData["report_type_1"] == 1 ) $arrViewData["report_type_1"] = " checked";
		IF( $arrInputData["report_type_2"] == 2 ) $arrViewData["report_type_2"] = " checked";
		IF( $arrInputData["report_type_3"] == 3 ) $arrViewData["report_type_3"] = " checked";
		IF( $arrInputData["report_type_4"] == 4 ) $arrViewData["report_type_4"] = " checked";
		
		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/inquiry/inquiry_index.tpl" );
		break;
		
	// 確認画面
	Case "CONFIRM":
		
		// 表示内容生成
		$arrViewData["contents"] = nl2br( $arrInputData["contents"] );
		$arrViewData["name_kj"] = $arrInputData["name_kj_1"]."　".$arrInputData["name_kj_2"];
		$arrViewData["name_kn"] = $arrInputData["name_kn_1"]."　".$arrInputData["name_kn_2"];
		IF( $arrInputData["sex"] == 1 ){
			$arrViewData["sex"] = "男性";
		}ELSEIF( $arrInputData["sex"] == 2 ){
			$arrViewData["sex"] = "女性";
		}
		IF( $arrInputData["old"] != "" ){
			$arrViewData["old"] = $arrInputData["old"]." 歳";
		}
		FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
			IF( $arrInputData["work_kind"] == $param_inquiry_work["id"][$key] ){
				$arrViewData["work_kind"] = $param_inquiry_work["val"][$key];
				break;
			}
		}
		IF( $arrInputData["report_type_1"] == 1 ){
			$arrViewData["tell"] = "";
			$arrViewData["tell"] .= $arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"];
			$arrViewData["tell"] .= "&nbsp;※連絡ご希望の時間帯:".$arrInputData["tell_time"]."\n";
		}
		IF( $arrInputData["report_type_2"] == 2 ){
			$arrViewData["fax"] = "";
			$arrViewData["fax"] .= $arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"];
		}
		IF( $arrInputData["report_type_3"] == 3 ){
			$arrViewData["addr"] = "";
			$arrViewData["addr"] .= "〒".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."&nbsp;";
			$arrViewData["addr"] .= $arrInputData["address_1"]."　".$arrInputData["address_2"];
		}
		IF( $arrInputData["report_type_4"] == 4 ){
			$arrViewData["email"] = "";
			$arrViewData["email"] .= $arrInputData["email"];
		}
		
		// 完了ページでのページ更新処理禁止用
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		$_SESSION["mst"] = $strBuffMst;
		$arrViewData["mst"] = $strBuffMst;
		
		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/inquiry/inquiry_confirm.tpl" );
		break;
		
	Case "COMMIT":
		
		// ページ更新処理禁止用
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		IF( $_SESSION["mst"] != $_POST["mst"] ){
			$arrErr["ath_comment"] = "お問合せメールは送信されております。";
			$obj_error->ViewErrMessage( "NO_RELOAD" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}
		
		// お問合せメール送信
		require_once( SYS_PATH."php/inquiry/inquiry_send_mail.php" );
		
		// ページ更新処理禁止用
		$_SESSION["mst"] = $strBuffMst;
		
		// 表示内容生成
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
		
		
		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/inquiry/inquiry_commit.tpl" );
		break;
}





?>
