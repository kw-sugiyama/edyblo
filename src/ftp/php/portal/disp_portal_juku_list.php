<?php
/*----------------------------------------------------------
    塾情報検索処理
	
	//----------- ページ判定用 -------------//
	$_GET['mode'] ... どの検索画面から来たか(各検索)
		"ar" : エリア指定画面 
		"ln" : 沿線指定画面
		"st" : 駅指定画面
		"sf" : 検索フォーム
		"fw" : フリーワードフォーム
	$_GET["p"]      ... 現在のページ番号(数字のみ)
	
	//----------- 通常検索用条件 -------------//
	$_GET["pf"][] ... 住所コード指定
	$_GET["ar"][] ... 県コード指定
	$_GET["ln"][] ... 沿線コード指定
	$_GET["st"][] ... 駅コード指定
	$_GET["fkwd"] ... フリーワード指定
	$_GET["cl"][] ... 指導形態
	$_GET["ag"]   ... 対象年齢
	
	//-------------- 並び順条件 --------------//
	$_GET["srt"]  ... ソート条件
		"1" ... 
		"2" ... 
	
//--------------------------------------------------------------------
//  HIDDEN値生成
//    $hidden_value      ... 全てのGET値をHIDDENに入れたもの
//    $strHiddenSearch   ... エリア検索などで設定された値のみをHIDDEN化
//    $strGetSearch      ... 検索条件をAリンクで飛ばす際の値
//--------------------------------------------------------------------
*/

/*=======================================================
    改行変換用文字列
=======================================================*/
// 改行文字配列
$linefeed = array("\r\n", "\n", "\r");
// 置き換え後の<br>配列
$html_br  = array("<br>", "<br>", "<br>");


/*=======================================================
    再検索窓の値を初期化（再検索窓からの検索字のみ値維持）
=======================================================*/

//値維持用に変数にセット
$ar_select_value = 0;
$pf_select_value = 0;
$ag_select_value = 0;
$cl_check_value = "";
$fw_text_value = "";


/*=======================================================
    ページ処理用設定
=======================================================*/
	// 1ページあたりの表示件数
	define( 'DATACOUNT',10);
	
	if( isset( $_GET['fw'] ) ){
		$free_word = $_GET['fw'];
		$_GET['fw'] = urlencode( $_GET['fw'] );
	}
	
	//ページ以外のGET配列全てをクエリに変換
	$query_all = "";
	if( is_array( $_GET ) ){
		foreach( $_GET as $get_key => $get_val ){
			if( is_array( $get_val ) ){
				foreach( $get_val as $get_key2 => $get_val2 ){
					if( $query_all == "" ){
						$query_all = "?".$get_key.'[]='.$get_val2;
					}else{
						$query_all .= "&".$get_key.'[]='.$get_val2;
					}
				}
			}elseif( $get_key != "p" && $get_key != "x" && $get_key != "y"){
				if( $query_all == "" ){
					$query_all = "?".$get_key.'='.$get_val;
				}else{
					$query_all .= "&".$get_key.'='.$get_val;
				}
			}
		}
	}


/*=======================================================
    エラーチェック
=======================================================*/
	switch( $_GET['mode'] ){
		//検索窓から一覧画面へ
		case "sf":
			//値の設定チェック（県コード・住所コード）
			if( !isset( $_GET['ar'] ) || $_GET['ar'][0] == "" && !isset( $_GET['fw'] ) ){
				$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
		
		//フリーワードから一覧画面へ
		case "fw":
			//値の設定チェック（県コード・住所コード）
			if( !isset( $_GET['fw'] ) || $_GET['fw'] == "" ){
				$obj_error->ViewErrMessage( "NO_WORD_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
		
		//エリア検索から一覧画面へ
		case "ar":
			//値の設定チェック（県コード・住所コード）
			if( !isset( $_GET['ar'],$_GET['pf'] ) || $_GET['ar'][0] == "" ||  $_GET['pf'][0] == "" ){
				$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
	
		//沿線・駅名検索から一覧画面へ
		case "ln":
			//値の設定チェック（県コード・沿線コード）
			if( !isset( $_GET['ar'],$_GET['ln'] ) || $_GET['ar'][0] == "" ||  $_GET['ln'][0] == "" ){
				$obj_error->ViewErrMessage( "NO_LINE_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
		
		//駅検索から一覧画面へ
		case "st":
			//値の設定チェック（県コード・沿線コード・駅コード）
			if( !isset( $_GET['ar'],$_GET['ln'],$_GET['st'] ) || $_GET['ar'][0] == "" ||  $_GET['ln'][0] == "" || $_GET['st'][0] == ""){
				$obj_error->ViewErrMessage( "NO_LINE_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
		
		//検索窓から一覧画面へ
		case "ms":
			//値の設定チェック（県コード・住所コード）
			if( !isset( $_GET['ar'] ) || $_GET['ar'][0] == "" && !isset( $_GET['fw'] ) ){
				$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;

		default:
			$obj_error->ViewErrMessage( "GET_PARAM" , "PORTAL-USER" , "/" , $arrErr );
			exit;
	}


/*=======================================================
    データ検索処理
=======================================================*/
switch( $_GET['mode'] ){

	/*=======================================================
	    検索窓から一覧画面へ
	=======================================================*/
	case "sf":
		
		//パンクズの生成
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>検索結果</strong></p>';

		//指導形態の値生成
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		$freeword = "";
		$arr_freeword = array();
		$freeword_list = array();
		if( $free_word !="" ){
			//全角スペースを半角スペースに変換
			$freeword = mb_convert_kana( $free_word, "s", "EUC-JP" ); 
			//半角スペースで分割
			$arr_freeword = explode( " ", $freeword ); 
			//トリム　、スペースのみの削除
			foreach( $arr_freeword as $fwkey => $fwval ){
				$fwval = trim( $fwval );
				if( $fwval != "" ){
					$freeword_list[] = $fwval;
				}
			}
		}

		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    市　エリア検索処理
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		if( $_GET['ar'][0] != "" && $_GET['pf'][0] == "" ){
			$obj_scity->jyoken["ar_prefcd_list"] = $_GET['ar'];   // 県コード
		}elseif( $_GET['ar'][0] != "" && $_GET['pf'][0] != "" ){
			$obj_scity->jyoken["ar_citycd_list"] = $_GET['pf'];   // 住所コード
		}
		if( is_array( $freeword_list ) && count( $freeword_list ) > 0 ){
			$obj_scity->jyoken["cl_yobi1_list"] = $freeword_list; // フリーワード
		}
		$obj_scity->jyoken["sc_age"] = $_GET['ag'];               // 対象年齢
		$obj_scity->jyoken["sc_classform_list"] = $_GET['cl'];    // 指導形態
		$obj_scity->jyoken["sc_stat"] = 1;                        // ブログ基本情報設定が終了しているかどうか
		$obj_scity->jyoken["cl_stat"] = 1;                        // ブログ掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_pstat"] = 1;                       // ポータル掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_start"] = 1;                       // ブログ掲載開始日時が今日以前かどうか
		$obj_scity->jyoken["cl_end"] = 1;                         // ブログ掲載終了日時が今日以降かどうか
		$obj_scity->jyoken["cl_deldate"] = 1;                     // クライアント情報が削除されていない
		$obj_scity->sort["city"] = 1;                             // 並び順 - 市コード順
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;


	/*=======================================================
	    フリーワードから一覧画面へ
	=======================================================*/
	case "fw":
		
		//パンクズの生成
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>検索結果</strong></p>';

		//指導形態の値生成
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		$freeword = "";
		$arr_freeword = array();
		$freeword_list = array();
		if( $free_word !="" ){
			$freeword = mb_convert_kana( $free_word, "s", "EUC-JP" ); //全角カナを半角カナに変換
			$arr_freeword = explode( " ", $freeword );
			foreach( $arr_freeword as $fwkey => $fwval ){
				$fwval = trim( $fwval );
				if( $fwval != "" ){
					$freeword_list[] = $fwval;
				}
			}
		}
		
		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    市　エリア検索処理
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		$obj_scity->jyoken["cl_yobi1_list"] = $freeword_list;    // フリーワード
		$obj_scity->jyoken["sc_stat"] = 1;                       // ブログ基本情報設定が終了しているかどうか
		$obj_scity->jyoken["cl_stat"] = 1;                       // ブログ掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_pstat"] = 1;                      // ポータル掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_start"] = 1;                      // ブログ掲載開始日時が今日以前かどうか
		$obj_scity->jyoken["cl_end"] = 1;                        // ブログ掲載終了日時が今日以降かどうか
		$obj_scity->jyoken["cl_deldate"] = 1;                    // クライアント情報が削除されていない
		$obj_scity->sort["city"] = 1;                            // 並び順 - 市コード順
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;


	/*=======================================================
	    エリア検索から一覧画面へ
	=======================================================*/
	case "ar":
		
		$query_str = "";
		foreach( $_GET['ar'] as $key => $val ){
			if( $key == 0 ){
				$query_str .= "?ar[]=".$val;
			}else{
				$query_str .= "&ar[]=".$val;
			}
		}
		
		//パンクズの生成
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-area/">エリア検索</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-pref/'.$query_str.'">県別一覧</a></strong><span class="paddinglr1">&gt;</span><strong>検索結果</strong></p>';

		//指導形態の値生成
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    市　エリア検索処理
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		$obj_scity->jyoken["ar_citycd_list"] = $_GET['pf'];   // 住所コード
		$obj_scity->jyoken["sc_stat"] = 1;                    // ブログ基本情報設定が終了しているかどうか
		$obj_scity->jyoken["cl_stat"] = 1;                    // ブログ掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_pstat"] = 1;                   // ポータル掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_start"] = 1;                   // ブログ掲載開始日時が今日以前かどうか
		$obj_scity->jyoken["cl_end"] = 1;                     // ブログ掲載終了日時が今日以降かどうか
		$obj_scity->jyoken["cl_deldate"] = 1;                 // クライアント情報が削除されていない
		$obj_scity->sort["city"] = 1;                         // 並び順 - 市コード順
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;

	/*=======================================================
	    沿線・駅名検索から一覧画面へ
	=======================================================*/
	case "ln":
		
		$query_str = "";
		foreach( $_GET['ar'] as $key => $val ){
			if( $key == 0 ){
				$query_str .= "?ar[]=".$val;
			}else{
				$query_str .= "&ar[]=".$val;
			}
		}
		
		$ln_data = array();
		$ln_pref = array();
		$ln_cd = array();
		foreach( $_GET['ln'] as $ln_key => $ln_val ){
			$ln_data = explode( "/", $ln_val );
			$ln_pref[] = pg_escape_string($ln_data[0]);
			$ln_cd[]= pg_escape_string($ln_data[1]);
		}
		
		//パンクズの生成
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-arealine/">沿線・駅名検索</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-line/'.$query_str.'">県別沿線一覧</a></strong><span class="paddinglr1">&gt;</span><strong>検索結果</strong></p>';

		//指導形態の値生成
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    市　エリア検索処理
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		$obj_scity->jyoken["es_linecd_list"] = $ln_cd;     // 沿線コード
		$obj_scity->jyoken["st_prefcd_list"] = $ln_pref;   // 県コード
		$obj_scity->jyoken["sc_stat"] = 1;                                      // ブログ基本情報設定が終了しているかどうか
		$obj_scity->jyoken["cl_stat"] = 1;                                      // ブログ掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_pstat"] = 1;                                     // ポータル掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_start"] = 1;                                     // ブログ掲載開始日時が今日以前かどうか
		$obj_scity->jyoken["cl_end"] = 1;                                       // ブログ掲載終了日時が今日以降かどうか
		$obj_scity->jyoken["cl_deldate"] = 1;                                   // クライアント情報が削除されていない
		$obj_scity->sort["sta"] = 1;                                            // 並び順 - 駅コード順
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;

	/*=======================================================
	    駅検索から一覧画面へ
	=======================================================*/
	case "st":
		

		$query_str = "";
		foreach( $_GET['ar'] as $key => $val ){
			if( $key == 0 ){
				$query_str .= "?ar[]=".$val;
			}else{
				$query_str .= "&ar[]=".$val;
			}
		}
		
		$query_str2 = "";
		foreach( $_GET['ln'] as $key => $val ){
				$query_str2 .= "&ln[]=".$val;
		}
		
		//パンクズの生成
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-arealine/">沿線・駅名検索</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-line/'.$query_str.'">県別沿線一覧</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-sta/'.$query_str.$query_str2.'">駅一覧</a></strong><span class="paddinglr1">&gt;</span><strong>検索結果</strong></p>';

		//指導形態の値生成
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    市　エリア検索処理
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		$obj_scity->jyoken["es_stacd_list"] = $_GET['st'];   // 沿線コード
		$obj_scity->jyoken["sc_stat"] = 1;                    // ブログ基本情報設定が終了しているかどうか
		$obj_scity->jyoken["cl_stat"] = 1;                    // ブログ掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_pstat"] = 1;                   // ポータル掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_start"] = 1;                   // ブログ掲載開始日時が今日以前かどうか
		$obj_scity->jyoken["cl_end"] = 1;                     // ブログ掲載終了日時が今日以降かどうか
		$obj_scity->jyoken["cl_deldate"] = 1;                 // クライアント情報が削除されていない
		$obj_scity->sort["sta"] = 1;                         // 並び順 - 駅コード順
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;


	/*=======================================================
	    再検索窓から一覧画面へ
	=======================================================*/
	case "ms":
		
		//パンクズの生成
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>検索結果</strong></p>';

		//指導形態の値生成
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		$freeword = "";
		$arr_freeword = array();
		$freeword_list = array();
		if( $free_word !="" ){
			//全角スペースを半角スペースに変換
			$freeword = mb_convert_kana( $free_word, "s", "EUC-JP" ); 
			//半角スペースで分割
			$arr_freeword = explode( " ", $freeword ); 
			//トリム　、スペースのみの削除
			foreach( $arr_freeword as $fwkey => $fwval ){
				$fwval = trim( $fwval );
				if( $fwval != "" ){
					$freeword_list[] = $fwval;
				}
			}
		}

		//値維持用に変数にセット
		if( $_GET['ar'][0] != "" ){
			$ar_select_value = $_GET['ar'][0];
		}
		if( $_GET['pf'][0] != "" ){
			$pf_select_value = $_GET['pf'][0];
		}
		if( $_GET['ag'] != "" ){
			$ag_select_value = $_GET['ag'];
		}
		if( $_GET['cl'] != "" ){
			$cl_check_value = $_GET['cl'];
		}
		if( $_GET['fw'] != "" ){
			$fw_text_value = htmlspecialchars( $_GET['fw'] );
		}


		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    市　エリア検索処理
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		if( $_GET['ar'][0] != "" && $_GET['pf'][0] == "" ){
			$obj_scity->jyoken["ar_prefcd_list"] = $_GET['ar'];   // 県コード
		}elseif( $_GET['ar'][0] != "" && $_GET['pf'][0] != "" ){
			$obj_scity->jyoken["ar_citycd_list"] = $_GET['pf'];   // 住所コード
		}
		if( is_array( $freeword_list ) && count( $freeword_list ) > 0 ){
			$obj_scity->jyoken["cl_yobi1_list"] = $freeword_list; // フリーワード
		}
		$obj_scity->jyoken["sc_age"] = $_GET['ag'];               // 対象年齢
		$obj_scity->jyoken["sc_classform_list"] = $_GET['cl'];    // 指導形態
		$obj_scity->jyoken["sc_stat"] = 1;                        // ブログ基本情報設定が終了しているかどうか
		$obj_scity->jyoken["cl_stat"] = 1;                        // ブログ掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_pstat"] = 1;                       // ポータル掲載フラグが有効かどうか
		$obj_scity->jyoken["cl_start"] = 1;                       // ブログ掲載開始日時が今日以前かどうか
		$obj_scity->jyoken["cl_end"] = 1;                         // ブログ掲載終了日時が今日以降かどうか
		$obj_scity->jyoken["cl_deldate"] = 1;                     // クライアント情報が削除されていない
		$obj_scity->sort["city"] = 1;                             // 並び順 - 市コード順
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;



}



/*=======================================================
    表示内容生成
=======================================================*/

//title
$view_header_title = "";
$view_header_title = '検索結果一覧｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
//keywords
$view_header_keywoeds = "";
$view_header_keywoeds = "学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,公立,私立,検索結果";
//description
$view_header_description = "";
$view_header_description = "検索結果一覧ページです。塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、";
$view_header_description .= '指導形式（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';

/*---------------------------------------------------------
    ページ遷移部品作成
	$strViewPageNowCount    ... 現在表示している件数コメント
	$strViewPageMove        ... ページ遷移リンク
	$strViewPageMove_before ... 「前へ」
	$strViewPageMove_after  ... 「後へ」
	$_GET["p"]              ... 現在のページ
	DATACOUNT               ... 表示件数(上限)
					(上にて指定済み)
	$intTotal_juku     ... 検索対象全体数
---------------------------------------------------------*/
	IF( $intCnt_juku > 0 ){
		$strBuffStartCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + 1;
		$strBuffEndCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + $intCnt_juku;
	
		$intBuffMove = $intTotal_juku / DATACOUNT;
		IF( is_int($intBuffMove) === FALSE ){
			$intBuffMove = ceil($intBuffMove);
		}
	
	
		$link_URL1 = '<a href="/psearch-result/page-';
		$link_URL2 = '.html'.$query_all.'">';
	
	
		if( $intBuffMove > 1 ){
			// 前ページ
			$strViewPageMove_before = "";
			IF( $_GET["p"] != 1 && $intBuffMove != 1 ){
				$intBuffCnt_be = $_GET["p"] - 1;
				$strViewPageMove_before .= $link_URL1 . $intBuffCnt_be . $link_URL2 . "前の" . DATACOUNT . "件</A>\n";
			}
		
			// 次ページ
			$strViewPageMove_after = "";
			IF( $intBuffMove > $_GET["p"] ){
				// 残り件数を表示
				// DATACOUNT件以上あったら 次のDATACOUNT件
				$next_cnt = $intTotal_juku - $strBuffEndCnt;
				IF($next_cnt >= DATACOUNT){
					$next_cnt = DATACOUNT;
				}
				$intBuffCnt_af = $_GET["p"] + 1;
				$strViewPageMove_after .= $link_URL1 . $intBuffCnt_af . $link_URL2 . "次の{$next_cnt}件</A>\n";
			}
		
			// ページへの直接ジャンプリンク作成
			$strViewPageMove_Cnt = "";
			$strViewPageMove_Cnt_more_before = "";
			$strViewPageMove_Cnt_more_after = "";
			$intCnt = 5;
			FOR( $iX=1; $iX<=$intBuffMove; $iX++ ){
				// 現在いるページの前後XX件ずつは表示
				IF ($iX < $_GET["p"] - $intCnt) {
					// はみ出した場合は...で省略
					$strViewPageMove_Cnt_more_before = "...";
				} ELSE IF ($iX > $_GET["p"] + $intCnt) {
					// はみ出した場合は...で省略
					$strViewPageMove_Cnt_more_after = "...";
				} ELSE IF ($iX == $_GET["p"]) {
					// 現在いるページはリンク無し
					$strViewPageMove_Cnt .= "<b>" .$iX . "</b>\n";
				} ELSE {
					$strViewPageMove_Cnt .= $link_URL1 . $iX . $link_URL2 . $iX . "</A>\n";
				}
			}
			// ...3 4 5 6 7 8 9 10 11 12 13... みたいな感じ
			//$strViewPageMove_Cnt = $strViewPageMove_Cnt_more_before . $strViewPageMove_Cnt . $strViewPageMove_Cnt_more_after;
			// 3 4 5 6 7 8 9 10 11 12 13 みたいな感じ
			$strViewPageMove_Cnt = $strViewPageMove_Cnt;
		}

/*		//フリーワード検索なら検索ワードを表示
		if( $_GET['mode'] == "fw" ){
			$view_page_list='<div class="pagenavi">
	<p class="pagenavileft">'.$free_word.' に一致する塾一覧</p><br>
	<p class="pagenavileft">全'.$intTotal_juku.'件&nbsp;&nbsp;'.$strBuffStartCnt.'-'.$strBuffEndCnt.'件を表示中</p>
	<p class="pagenaviright">'.$strViewPageMove_before.$strViewPageMove_Cnt.$strViewPageMove_after.'</p><br class="clear">
	</div>
	';
		}else{
		$view_page_list='<div class="pagenavi">
	<p class="pagenavileft">全'.$intTotal_juku.'件&nbsp;&nbsp;'.$strBuffStartCnt.'-'.$strBuffEndCnt.'件を表示中</p>
	<p class="pagenaviright">'.$strViewPageMove_before.$strViewPageMove_Cnt.$strViewPageMove_after.'</p><br class="clear">
	</div>
	';
		}
*/
		$view_page_list='<div class="pagenavi">
	<p class="pagenavileft">全'.$intTotal_juku.'件&nbsp;&nbsp;'.$strBuffStartCnt.'-'.$strBuffEndCnt.'件を表示中</p>
	<p class="pagenaviright">'.$strViewPageMove_before.$strViewPageMove_Cnt.$strViewPageMove_after.'</p><br class="clear">
	</div>
	';
	}

$view_school_list = "";
$view_school_list .= $view_page_list;
if( isset( $view_search_result ) && is_array( $view_search_result ) ){
	foreach( $view_search_result as $key => $val ){
	
		
		//塾名・教室名
			$view_school_name = "";
			if( $view_search_result[$key]['cl_kname'] != "" ){
				$view_school_name = $view_search_result[$key]['cl_jname'].' '.$view_search_result[$key]['cl_kname'];
			}else{
				$view_school_name = $view_search_result[$key]['cl_jname'];
			}
		
		//ブログURLの生成
			//独自ドメインの場合
			if( $view_search_result[$key]['cl_dokuji_flg']  == 1 ){
				$school_url = $view_search_result[$key]['cl_dokuji_domain'];
			//独自ドメインでない場合
			}else{
				$school_url = _BLOG_SITE_URL_BASE.'/'.$view_search_result[$key]['cl_urlcd'].'/';
			}
		
		//画像表示内容生成
			//講師画像
			if( $view_search_result[$key]['sc_topimg'] ){
				//小
				$ts_image = '<img src="./img_thumbnail.php?w=78&h=59&dir='.$param_cl_staff_path.'&nm='.$view_search_result[$key]['sc_mapimg'].'" alt="teacher_image">';
				//大
				$tb_image = '<div class="imagebox">';
				$tb_image .= '<img src="./img_thumbnail.php?w=206&h=147&dir='.$param_cl_photo_path.'&nm='.$view_search_result[$key]['sc_topimg'].'" alt="school_image" class="school_image1">';
				$tb_image .= '<img src="share/css/css1/images/transparent.gif" width="1" height="147" class="school_image2" alt="">';
				$tb_image .= '</div>';
			}else{
				$ts_image = "";//"&nbsp;";
				$tb_image = "";//"&nbsp;";
			}
	
			//教室画像
			if( $view_search_result[$key]['sc_topimg'] ){
				$s_image = '<img src="./img_thumbnail.php?w=206&h=147&dir='.$param_cl_photo_path.'&nm='.$view_search_result[$key]['sc_topimg'].'" alt="school_image" style="vertical-align:middle">';
			}else{
				$s_image = "&nbsp;";
			}
	
		//アイコンの生成
			$icon = "";
			//対象年齢
			$age_of = $view_search_result[$key]['sc_age'];
			$age_icon = array();
			$age_icon_list = "";
			if( ( $age_of & 64 ) == 64 ){
				$age_icon[7] = '<img src="share/icons/bg_syakaijin.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 64;
			}
			if( ( $age_of & 32 ) == 32 ){
				$age_icon[6] = '<img src="share/icons/bg_daigakusei.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 32;
			}
			if( ( $age_of & 16 ) == 16 ){
				$age_icon[5] = '<img src="share/icons/bg_roninsei.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 16;
			}
			if( ( $age_of & 8 ) ==8 ){
				$age_icon[4] = '<img src="share/icons/bg_koukou.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 8;
			}
			if( ( $age_of & 4 ) ==4 ){
				$age_icon[3] = '<img src="share/icons/bg_chugaku.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 4;
			}
			if( ( $age_of & 2) == 2 ){
				$age_icon[2] = '<img src="share/icons/bg_shogaku.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 2;
			}
			if( ( $age_of & 1 ) == 1 ){
				$age_icon[1] = '<img src="share/icons/bg_youji.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 1;
			}
			
			$cnt = 1;
			if( count( $age_icon ) ){
				ksort( $age_icon );
				
				foreach( $age_icon as $age_key => $age_val ){
					if( $cnt % 8 == 0 ){ $icon .= "\n&nbsp;&nbsp;"; }
					$icon .= $age_val;
					$cnt++;
				}
			}
	
			//指導形態		
			$cls_of = $view_search_result[$key]['sc_classform'];
			$cls_icon = array();
			$cls_icon_list = "";
			if( ( $cls_of & 4 ) == 4 ){
				$cls_icon[3] = '<img src="share/icons/bg_kobetsu.gif" width="62" height="20" class="paddingr2" alt="">';
				$cls_of -= 4;
			}
			if( ( $cls_of & 2 ) == 2 ){
				$cls_icon[2] = '<img src="share/icons/bg_shounin.gif" width="62" height="20" class="paddingr2" alt="">';
				$cls_of -= 2;
			}
			if( ( $cls_of & 1 ) == 1 ){
				$cls_icon[1] = '<img src="share/icons/bg_shudan.gif" width="62" height="20" class="paddingr2" alt="">';
				$cls_of -= 1;
			}
			if( count( $cls_icon ) ){
				ksort( $cls_icon );
				foreach( $cls_icon as $cls_key => $cls_val ){
					if( $cnt % 8 == 0 ){ $icon .= "\n&nbsp;&nbsp;"; }
					$icon .= $cls_val;
					$cnt++;
				}
			}
			
		//住所情報の整形（ar_area disp_no1の住所を持ってくる）
			$obj_area = new basedb_AreaClassTblAccess;
			$obj_area->conn = $obj_conn->conn;
			$obj_area->jyoken = array();
			$obj_area->jyoken["ar_clid"] = $view_search_result[$key]['sc_clid'];
			$obj_area->sort['ar_flg'] = 2;
			$obj_area->areadat = array();
			list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );
			$area = array();
			$area_address = "";
			$area['zip'] = "〒".$obj_area->areadat[0]['ar_zip'];
			$area['pref'] = $obj_area->areadat[0]['ar_pref'];
			$area['city'] = $obj_area->areadat[0]['ar_city'];
			$area['add'] = $obj_area->areadat[0]['ar_add'];
			$area['ar_estate'] =" ".$obj_area->areadat[0]['ar_estate'];
			$area_address = $area['zip']." ".$area['pref'].$area['city'].$area['add'].$area['ar_estate'];
		
		//電話番号の整形
			if( $view_search_result[$key]['cl_phone'] !="" ){
				$tel_no = $view_search_result[$key]['cl_phone'];
			}else{
				$tel_no = " -";
			}
		
		//沿線情報の整形
			$ensen =array();
			if( $view_search_result[$key]['es_bus'] ) $ensen['bus'] = " バス".$view_search_result[$key]['es_bus']."分";
			if( $view_search_result[$key]['es_walk'] ) $ensen['walk'] = " 徒歩".$view_search_result[$key]['es_walk']."分";
			if( $view_search_result[$key]['es_biko'] ) $ensen['biko'] = " ".$view_search_result[$key]['es_biko'];
			$ensen_name = $view_search_result[$key]['es_line'].$view_search_result[$key]['es_sta'].'駅'.$ensen['bus'].$ensen['walk'].$ensen['biko'];
		

		$view_school_list .= '

<div class="schoolinfo">
<div class="kekka"></div>
<div class="schoolheader">'.$view_search_result[$key]['sc_topsubtitle'].'</div>
<div class="schoolname"><a href="'.$school_url.'" target="_blank">'.$view_school_name.'</a></div>
<div class="kekkaul"></div>
<div class="schoolicon">'.$icon.'</div>
<div class="kekkaul"></div>
<div class="schoolinfo2">
'.$tb_image.'
<div class="schoolchara">
<p><img src="share/css/css1/images/bg_tokucho2.gif" alt="塾の特徴" width="290" height="25"></p>
<p>'.str_replace( $linefeed, $html_br , $view_search_result[$key]['sc_pr'] ).'
</p>
</div><table class="schooldetail">
<tr>
<td>
<p class="schoolchara"><br>住　所：'.$area_address.'<br>
ＴＥＬ：'.$tel_no.'<br>
最寄駅：'.$ensen_name.'
</td>
<td class="todetail paddingt1"><a href="'.$school_url.'" target="_blank"></a></td>
</tr>
</table>
</div>
<div class="kekkaul"></div>
</div>
';
	}
}else{

	if( $_GET['mode'] == "fw" || ( $_GET['mode'] == "ms" && $_GET['ar'][0] == "" && $_GET['pf'][0] == "" ) ){
		$view_school_list .= '
<div class="box3"><!--box start-->
<table class="search3">
<tr>
<th>
<p class="center"><strong>'.$free_word.'　に一致する塾は見つかりませんでした。</strong></p>
</th>
</tr>
</table>
</div><!--box end-->
';
	}else{
		$view_school_list .= '
<div class="box3"><!--box start-->
<table class="search3">
<tr>
<th>
<p class="center"><strong>検索条件に一致する塾は見つかりませんでした。</strong></p>
</th>
</tr>
</table>
</div><!--box end-->
';
	}
}

$view_school_list .= $view_page_list;

?>