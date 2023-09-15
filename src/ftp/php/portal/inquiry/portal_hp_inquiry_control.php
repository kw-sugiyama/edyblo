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
			require_once( SYS_PATH."php/portal/inquiry/portal_hp_inquiry_input_check.php" );
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
$arrViewData = Array();
SWITCH( $strDispFlg ){
	// 入力画面 => テンプレート表示のみ
	default:
	Case "INDEX":
		/*==============================================================
		    TOPページ表示内容生成ファイル
		==============================================================*/
		//title
		$view_header_title = '';
		$view_header_title = '塾タウンについてのお問合せ｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = '';
		$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,公立,私立,お問合せ';
		//description
		$view_header_description = '';
		$view_header_description = '塾タウンの問合せページです。塾タウンについてのお問合せはこちからからどうぞ。';
		$view_header_description .= '塾タウンは学習塾・進学塾探しのポータルサイトです。';


		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/portal/inquiry/portal_hp_inquiry_index.tpl" );
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
		$arrViewData["email"]		= $arrInputData["email"];			// メールアドレス
		$arrViewData["subject"]		= $arrInputData["subject"];			// 件名
		$arrViewData["contents"]	= nl2br( $arrInputData["contents"] );		// 本文

		// 完了ページでのページ更新処理禁止用
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		$_SESSION["mst_hp"] = $strBuffMst;
		$arrViewData["mst_hp"] = $strBuffMst;

		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/portal/inquiry/portal_hp_inquiry_confirm.tpl" );
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
		IF( $_SESSION["mst_hp"] != $_POST["mst_hp"] ){
			$arrErr["ath_comment"] = "お問合せメールは送信されております。";
			$obj_error->ViewErrMessage( "NO_RELOAD" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}

		// お問合せメール送信
		require_once( SYS_PATH."php/portal/inquiry/portal_hp_inquiry_send_mail.php" );

		// ページ更新処理禁止用
		$_SESSION["mst_hp"] = $strBuffMst;

		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/portal/inquiry/portal_hp_inquiry_commit.tpl" );
		break;
}

?>