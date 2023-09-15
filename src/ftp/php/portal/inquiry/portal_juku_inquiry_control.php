<?php

// 右側処理部分
//    => 生成値は $arrViewLeft に格納
//require_once( SYS_PATH."php/portal/disp_portal_left_menu.php" );
require_once( SYS_PATH."php/portal/disp_portal_right_menu.php" );


//---------------------------------------------------------------------------
// POST値を格納
$arrInputData = Array();
$strInputHidden = "";
FOREACH( $_POST as $key => $val ){
	$arrInputData[$key] = htmlspecialchars( stripslashes( $val ) );
	$strInputHidden .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$arrInputData[$key]}\">\n";
	IF( is_array($val) ){
		FOREACH( $val as $key2 => $val2 ){
			$arrInputData[$key][$key2] = htmlspecialchars( stripslashes( $val2 ) );
			$strInputHidden .= "<input type=\"hidden\" name=\"{$key}[{$key2}]\" value=\"{$arrInputData[$key][$key2]}\">\n";
		}
	}
}


//---------------------------------------------------------------------------
// 表示画面チェック
//	$_POST["form_flg"] ... どの画面から来たか
//	$strDispFlg        ... 次に表示する内容
//---------------------------------------------------------------------------
$strDispFlg = "";
IF( $_GET["form_flg"] == "" ){
	// 何も無いのでindex
	$strDispFlg = "INDEX";
}ELSE{
	SWITCH( $_GET["form_flg"] ){
		Case "INDEX":
			// 入力内容チェック
			//   => OK:$intInputChkFlg=1  NG:$intInputChkFlg=9;
			require_once( SYS_PATH."php/portal/inquiry/portal_juku_inquiry_input_check.php" );
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
		/*==============================================================
		    TOPページ表示内容生成ファイル
		==============================================================*/
		//title
		$view_header_title = '';
		$view_header_title = 'ホームページ作成・広告掲載についてのお問合せ｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = '';
		$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,お問合せ,ホームページ作成,ポータル,掲載';
		//description
		$view_header_description = '';
		$view_header_description = '塾タウンの問合せページです。ホームページ作成・広告掲載についてのお問合せはこちからからどうぞ。';
		$view_header_description .= '塾タウンは学習塾・進学塾探しのポータルサイトです。';

		$arrViewData = Array();
		
		IF( $arrInputData["title"][0] == 1 ){
			$arrViewData["title"][0] = " checked";
		}
		IF( $arrInputData["title"][1] == 1 ){
			$arrViewData["title"][1] = " checked";
		}
		IF( $arrInputData["title"][2] == 1 ){
			$arrViewData["title"][2] = " checked";
		}
		IF( $arrInputData["title"][3] == 1 ){
			$arrViewData["title"][3] = " checked";
		}

		IF( $arrInputData["device"][0] == 1 ){
			$arrViewData["device"][0] = " checked";
		}
		IF( $arrInputData["device"][1] == 1 ){
			$arrViewData["device"][1] = " checked";
		}
		IF( $arrInputData["device"][2] == 1 ){
			$arrViewData["device"][2] = " checked";
		}
		IF( $arrInputData["device"][3] == 1 ){
			$arrViewData["device"][3] = " checked";
		}

		// 選択した県のSelectを選択状態に
		$arrPrefSel = array();
		IF( $arrInputData["pref"] != ""){
			for ($ix=1;$ix<=47;$ix++){
				IF( $arrInputData["pref"] == $ix){
					$arrPrefSel[$ix] = "selected";
				}
			}
		}
		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/portal/inquiry/portal_juku_inquiry_index.tpl" );
		break;
		
	// 確認画面
	Case "CONFIRM":
		/*==============================================================
		    TOPページ表示内容生成ファイル
		==============================================================*/
		//title
		$view_header_title = '';
		$view_header_title = 'お問合せ内容の確認｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = '';
		$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,公立,私立,お問合せ';
		//description
		$view_header_description = '';
		$view_header_description = '塾タウンの問合せ確認ページです。';
		$view_header_description .= '塾タウンは学習塾・進学塾探しのポータルサイトです。';

		// 表示内容生成
		$arrViewData["contents"] = nl2br( $arrInputData["contents"] );
		$arrViewData["name_kj"] = $arrInputData["name_kj_1"]."　".$arrInputData["name_kj_2"];
		$arrViewData["name_kn"] = $arrInputData["name_kn_1"]."　".$arrInputData["name_kn_2"];

		IF( $arrInputData["title"][0] == 1 ){
			$arrViewData["title"] .= "塾タウンの掲載について\n";
		}
		IF( $arrInputData["title"][1] == 1 ){
			IF($arrViewData["title"]!="")$arrViewData["title"] .= "<BR>";
			$arrViewData["title"] .= "バナー・広告等の掲載について\n";
		}
		IF( $arrInputData["title"][2] == 1 ){
			IF($arrViewData["title"]!="")$arrViewData["title"] .= "<BR>";
			$arrViewData["title"] .= "ホームページ作成について\n";
		}
		IF( $arrInputData["title"][3] == 1 ){
			IF($arrViewData["title"]!="")$arrViewData["title"] .= "<BR>";
			$arrViewData["title"] .= "その他\n";
		}

		IF( $arrInputData["device"][0] == 1 ){
			$arrViewData["device"] .= "資料を送付して欲しい\n";
		}
		IF( $arrInputData["device"][1] == 1 ){
			IF($arrViewData["device"]!="")$arrViewData["device"] .= "<BR>";
			$arrViewData["device"] .= "詳細を知りたいので電話して欲しい\n";
		}
		IF( $arrInputData["device"][2] == 1 ){
			IF($arrViewData["device"]!="")$arrViewData["device"] .= "<BR>";
			$arrViewData["device"] .= "詳細を知りたいので来社して欲しい\n";
		}
		IF( $arrInputData["device"][3] == 1 ){
			IF($arrViewData["device"]!="")$arrViewData["device"] .= "<BR>";
			$arrViewData["device"] .= "質問内容に答えて欲しい\n";
		}
		IF( $arrInputData["addr_cd_1"] != "" && $arrInputData["addr_cd_2"] != "" && $arrInputData["pref"] != 0 && $arrInputData["address_1"] !="" ){
			$arrViewData["addr_cd"] .= "〒".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."\n";
			$arrViewData["pref"] .= $psel[$arrInputData["pref"]];
			$arrViewData["addr"] .= $arrInputData["address_1"].$arrInputData["address_2"]."\n";
		}

		IF( $arrInputData["tell_1"] != "" && $arrInputData["tell_2"] != "" && $arrInputData["tell_3"] != "" ){
			$arrViewData["tell"] .= $arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"]."\n";
		}
		IF( $arrInputData["fax_1"] != "" && $arrInputData["fax_2"] != "" && $arrInputData["fax_3"] != "" ){
			$arrViewData["fax"] .= $arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"]."\n";
		}
		
		// 完了ページでのページ更新処理禁止用
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		$_SESSION["mst_juku"] = $strBuffMst;
		$arrViewData["mst_juku"] = $strBuffMst;
		
		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/portal/inquiry/portal_juku_inquiry_confirm.tpl" );
		break;
		
	Case "COMMIT":
		/*==============================================================
		    TOPページ表示内容生成ファイル
		==============================================================*/
		//title
		$view_header_title = '';
		$view_header_title = 'お問合せ完了｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = '';
		$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,公立,私立,お問合せ';
		//description
		$view_header_description = '';
		$view_header_description = '塾タウンの問合せ完了ページです。';
		$view_header_description .= '塾タウンは学習塾・進学塾探しのポータルサイトです。';

		// ページ更新処理禁止用
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		IF( $_SESSION["mst_juku"] != $_POST["mst_juku"] ){
			$arrErr["ath_comment"] = "お問合せメールは送信されております。";
			$obj_error->ViewErrMessage( "NO_RELOAD" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}

		// 表示内容生成
		$arrViewData["name_kj"] = $arrInputData["name_kj_1"]."　".$arrInputData["name_kj_2"];
		$arrViewData["name_kn"] = $arrInputData["name_kn_1"]."　".$arrInputData["name_kn_2"];

		IF( $arrInputData["title"][0] == 1 ){
			$arrViewData["title"] .= "塾タウンの掲載について\n";
		}
		IF( $arrInputData["title"][1] == 1 ){
			$arrViewData["title"] .= "バナー・広告等の掲載について\n";
		}
		IF( $arrInputData["title"][2] == 1 ){
			$arrViewData["title"] .= "ホームページ作成について\n";
		}
		IF( $arrInputData["title"][3] == 1 ){
			$arrViewData["title"] .= "その他\n";
		}

		IF( $arrInputData["device"][0] == 1 ){
			$arrViewData["device"] .= "資料を送付して欲しい\n";
		}
		IF( $arrInputData["device"][1] == 1 ){
			$arrViewData["device"] .= "詳細を知りたいので電話して欲しい\n";
		}
		IF( $arrInputData["device"][2] == 1 ){
			$arrViewData["device"] .= "詳細を知りたいので来社して欲しい\n";
		}
		IF( $arrInputData["device"][3] == 1 ){
			$arrViewData["device"] .= "質問内容に答えて欲しい\n";
		}

		// お問合せメール送信
		require_once( SYS_PATH."php/portal/inquiry/portal_juku_inquiry_send_mail.php" );

		// ページ更新処理禁止用
		$_SESSION["mst_juku"] = $strBuffMst;
		
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
		require_once( SYS_PATH."templates/portal/inquiry/portal_juku_inquiry_commit.tpl" );
		break;
}

?>