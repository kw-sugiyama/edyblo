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
	IF( is_array( $val ) === TRUE ){
		FOREACH( $val as $key2 => $val2 ){
			$arrInputData[$key][] = htmlspecialchars( stripslashes( $val2 ) );
			$strInputHidden .= "<INPUT type=\"hidden\" name=\"{$key}[]\" value=\"{$val2}\" />\n";
		}
	}ELSE{
		$arrInputData[$key] = htmlspecialchars( stripslashes( $val ) );
		$strInputHidden .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$arrInputData[$key]}\" />\n";
	}
}



//---------------------------------------------------------------------------
// 候補リストチェック
//	※指定クライアントの候補リストが１つ以上なければエラー
//---------------------------------------------------------------------------
IF( is_array( $_SESSION["list"][_cl_id] ) === FALSE ){
	// 候補リストに値無し
	$obj_error->ViewErrMessage( "NO_KOUHO" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}ELSE{
	FOREACH( $_SESSION["list"][_cl_id] as $key => $val ){
		IF( $val == "" || ereg( "^[0-9]+$" , $val ) === FALSE ){
			// 候補リストの保持値が不正
			$obj_error->ViewErrMessage( "SYSTEM" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}
	}
}


//---------------------------------------------------------------------------
// 候補リスト内の指定部屋ＩＤ情報取得
//	※指定部屋ＩＤが解除により取得できない場合は入れない
//	$strViewRoomList ... 画面へ出力する内容
//	$strMailRoomList ... メールへ入れる内容
//---------------------------------------------------------------------------
$strViewRoomList = "";
FOREACH( $_SESSION["list"][_cl_id] as $key => $val ){
	
	// 指定部屋情報取得
	$obj_room_box = NULL;
	$obj_room_box = new viewdb_BuildClassTblAccess();
	$obj_room_box->conn = $obj_conn->conn;
	$obj_room_box->jyoken["build_cl_id"] = "";	// 指定クライアントの物件
	$obj_room_box->jyoken["build_del_date"] = 1;	// 建物情報が削除されていない
	$obj_room_box->jyoken["room_del_date"] = 1;	// 部屋情報が削除されていない
	$obj_room_box->jyoken["room_id"] = $val;	// 指定部屋ＩＤ
	list( $intCnt_rb , $intTotal_rb ) = $obj_room_box->viewdb_GetBuild( 1 , -1 );
	IF( $intCnt_rb == -1 || $intCnt_rb > 1 ){
		// システムエラー
		$obj_error->ViewErrMessage( "SYSTEM" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
		exit;
	}ELSEIF( $intCnt_rb == 0 ){
		// 候補リストへ入れた後に削除
		//	=> 何もしない
	}ELSE{
		// 表示内容生成
		$arrBuffValue = Array();
		// 部屋コード
		$arrBuffValue["room_code"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["room_code"] ) );
		$arrBuffValue["room_id"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["room_id"] ) );
		// 駅名
		$arrBuffString = Array();
		$arrBuffString["build_line_name"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["build_line_name_1"] ) );
		$arrBuffString["build_sta_name"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["build_sta_name_1"] ) );
		$arrBuffString["build_move"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["build_move_1"] ) );
		$arrBuffString["build_move_bus"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["build_move_bus_1"] ) );
		$arrBuffValue["build_station"] = $arrBuffString["build_line_name"].$arrBuffString["build_sta_name"]."駅から徒歩".$arrBuffString["build_move"]."分";
		IF( $arrBuffString["build_move_bus"] != "" ){
			$arrBuffValue["build_station"] .= " バス".$arrBuffString["build_move_bus"]."分";
		}
		// 間取り
		reset( $param_room_floor );
		asort( $param_room_floor["disp_no"] );
		FOREACH( $param_room_floor["disp_no"] as $key => $val2 ){
			IF( $param_room_floor['id'][$key] == $obj_room_box->builddat[0]["room_madori"] ){
				$arrBuffValue["room_madori"] = $param_room_floor['val'][$key];
				break;
			}
		}
		// 家賃
		$arrBuffValue["room_price"] = number_format($obj_room_box->builddat[0]["room_price"])."円";
		
		
		// 画面表示用値生成
		$strViewRoomList .= "  <table>\n";
		$strViewRoomList .= "    <tr>\n";
		$strViewRoomList .= "      <th>物件コード</th>\n";
		$strViewRoomList .= "      <td>{$arrBuffValue["room_code"]}</td>\n";
		$strViewRoomList .= "    </tr>\n";
		$strViewRoomList .= "    <tr>\n";
		$strViewRoomList .= "      <th>最寄駅</th>\n";
		$strViewRoomList .= "      <td>{$arrBuffValue["build_station"]}</td>\n";
		$strViewRoomList .= "    </tr>\n";
		$strViewRoomList .= "    <tr>\n";
		$strViewRoomList .= "      <th>間取り</th>\n";
		$strViewRoomList .= "      <td>{$arrBuffValue["room_madori"]}</td>\n";
		$strViewRoomList .= "    </tr>\n";
		$strViewRoomList .= "    <tr>\n";
		$strViewRoomList .= "      <th>賃料</th>\n";
		$strViewRoomList .= "      <td>{$arrBuffValue["room_price"]}</td>\n";
		$strViewRoomList .= "    </tr>\n";
		$strViewRoomList .= "  </table>\n";
		
		// メール表示用値生成
		$strMailRoomList .= "・{$arrBuffValue["room_code"]}\n";
		$strMailRoomList .= "	最寄駅：{$arrBuffValue["build_station"]}\n";
		$strMailRoomList .= "	間取り：{$arrBuffValue["room_madori"]}\n";
		$strMailRoomList .= "	家賃：{$arrBuffValue["room_price"]}\n";
		$strMailRoomList .= "	URL：{$param_base_blog_addr_url}"._BLOG_SITE_URL_BASE."build_detail.php?rid={$arrBuffValue["room_id"]}\n\n";
		
	}
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
			require_once( SYS_PATH."php/applicate/applicate_input_check.php" );
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
		
		// お問合せ内容
		$intBuffQuest = 0;
		reset( $param_applicate_question );
		asort( $param_applicate_question["disp_no"] );
		FOREACH( $param_applicate_question["disp_no"] as $key2 => $val2 ){
			$strChk = "";
			IF( is_array( $_POST["question"] ) === TRUE ){
				IF( in_array( $param_applicate_question["id"][$key2] , $_POST["question"] ) === TRUE ) $strChk = " checked";
			}
			
			IF( $param_applicate_question["val"][$key2] != "その他" ){
				IF( $intBuffQuest == 0 ){
					$arrViewData["question"] .= "  <tr>\n";
				}
				$arrViewData["question"] .= "    <td class=\"noborder\"><INPUT type=\"checkbox\" name=\"question[]\" id=\"{$param_applicate_question["val"][$key2]}\" value=\"{$param_applicate_question["id"][$key2]}\" {$strChk}/><label for=\"{$param_applicate_question["val"][$key2]}\">{$param_applicate_question["val"][$key2]}</label></td>\n";
				$intBuffQuest++;
				IF( $intBuffQuest == 3 ){
					$arrViewData["question"] .= "  </tr>\n";
					$intBuffQuest = 0;
				}
			}ELSE{
				$arrViewData["question_sonota"] = "<INPUT type=\"checkbox\" name=\"question[]\" id=\"{$param_applicate_question["val"][$key2]}_q\" value=\"{$param_applicate_question["id"][$key2]}\" {$strChk}/><label for=\"{$param_applicate_question["val"][$key2]}_q\">{$param_applicate_question["val"][$key2]}</label>\n";
			}
		}
		// 職業
		$intBuffWork = 0;
		reset( $param_inquiry_work );
		asort( $param_inquiry_work["disp_no"] );
		FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
			$strChk = "";
			IF( $arrInputData["work_kind"] == $param_inquiry_work["id"][$key] ) $strChk = " checked";
			
			IF( $intBuffWork == 0 ){
				$arrViewData["work_kind"] .= "  <tr>\n";
			}
			$arrViewData["work_kind"] .= "    <td class=\"noborder\"><INPUT type=\"radio\" name=\"work_kind\" id=\"{$param_inquiry_work["val"][$key]}\" value=\"{$param_inquiry_work["id"][$key]}\"{$strChk}/><label for=\"{$param_inquiry_work["val"][$key]}\">{$param_inquiry_work["val"][$key]}</label></td>\n";
			$intBuffWork++;
			IF( $intBuffWork == 4 ){
				$arrViewData["work_kind"] .= "  </tr>\n";
				$intBuffWork = 0;
			}
		}
		IF( $intBuffWork != 4 && $intBuffWork != 0 ){
			FOR( $iX=$intBuffWork; $iX<4; $iX++ ){
				$arrViewData["work_kind"] .= "    <td class=\"noborder\">&nbsp;</td>\n";
			}
			$arrViewData["work_kind"] .= "  </tr>\n";
		}
		// 性別
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
		require_once( SYS_PATH."templates/applicate/applicate_index.tpl" );
		break;
		
	// 確認画面
	Case "CONFIRM":
		
		// 表示内容生成
		
		// お問合せ内容
		FOREACH( $_POST["question"] as $key => $val ){
			reset( $param_applicate_question["disp_no"] );
			asort( $param_applicate_question["disp_no"] );
			FOREACH( $param_applicate_question["disp_no"] as $key2 => $val2 ){
				IF( $val == $param_applicate_question["id"][$key2] ){
					$arrViewData["question"] .= $param_applicate_question["val"][$key2]."<br />\n";
					break;
				}
			}
		}
		$arrViewData["question_other"] = nl2br( $arrInputData["question_other"] );
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
			$arrViewData["tell"] = $arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"];
			$arrViewData["tell"] .= "<br />連絡ご希望の時間帯:".$arrInputData["tell_time"];
		}
		IF( $arrInputData["report_type_2"] == 2 ){
			$arrViewData["fax"] = $arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"];
		}
		IF( $arrInputData["report_type_3"] == 3 ){
			$arrViewData["addr"] = "〒".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."<br />";
			$arrViewData["addr"] .= $arrInputData["address_1"]."　".$arrInputData["address_2"];
		}
		IF( $arrInputData["report_type_4"] == 4 ){
			$arrViewData["email"] = $arrInputData["email"];
		}
		
		// 完了ページでのページ更新処理禁止用
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		$_SESSION["mst"] = $strBuffMst;
		$arrViewData["mst"] = $strBuffMst;
		
		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/applicate/applicate_confirm.tpl" );
		break;
		
	Case "COMMIT":
		
		// ページ更新処理禁止用
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		IF( $_SESSION["mst"] != $_POST["mst"] ){
			$arrError["ath_comment"] = "物件に対するお問合せメールは送信されております。";
			$obj_error->ViewErrMessage( "NO_RELOAD" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}
		
		// お問合せメール送信
		require_once( SYS_PATH."php/applicate/applicate_send_mail.php" );
		
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
		
		// 問い合わせた物件を候補リストから削除
		unset( $_SESSION["list"][_cl_id] );
		
		
		// 表示テンプレート呼び出し
		require_once( SYS_PATH."templates/applicate/applicate_commit.tpl" );
		break;
}





?>
