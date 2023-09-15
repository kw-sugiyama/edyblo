<?php

/*=======================================================
    沿線検索用処理

    渡ってきたar[](県)を元に、駅マスタm_stationから
    その県にある沿線を全て取得
    沿線でv_search_lineのes_linecd(スラッシュ区切りで格納されている)をlike検索
    発生のある沿線のみ一覧表示する

=======================================================*/

// 県指定が無い場合はエラー
IF( count( $_GET["ar"] ) == 0 && count( $_POST["ar"] ) == 0 ){
	$arrErr['ath_comment'] = "<input type=\"hidden\" name=\"fa\" value=\"{$_GET['fa']}\">\n";
	$arrErr['ath_comment'] .= $hddnVal;
	$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/psearch-arealine/" , $arrErr );
	exit;
}

// GET値作成 ar
// hidden作成
FOREACH($_GET["ar"] as $key => $val){
	if ($get_str == ''){
		$get_str .= '?';
	} else {
		$get_str .= '&';
	}
	$hidden_str .= '<input type="hidden" name="ar[]" value="' . $val . '">' . "\n";
	$get_str .= 'ar[]=' . $val;
}

// 検索結果用モード 'ln' or 'st'
// javascriptでname,valueセット
$hidden_str .= '<input type="hidden" name="dummy" id="mode" value="">' . "\n";


//見出し表示内容生成
$view_select_pref .= '<h3 class="orange">選択した県</h3>'."\n";
$view_select_pref .= '<div class="box">'."\n";
$view_select_pref .= '<table class="search1">'."\n";
$view_select_pref .= '<tr>'."\n";
$view_select_pref .= '<td><div class="area">'."\n";

foreach( $_GET['ar'] as $ar_val ){
	$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
}
unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat,$view_prefdat);

$view_select_pref .= '</div></td>'."\n";
$view_select_pref .= '</tr>'."\n";
$view_select_pref .= '</table>'."\n";
$view_select_pref .= '</div>'."\n";
$view_select_pref .= '<br>'."\n";

/*=======================================================
   県指定時の処理
=======================================================*/
$line_cd_list = array();
foreach( $_GET['ar'] as $ar_key => $ar_val ){
	$line_cd[$ar_val] = array();
	//沿線データ抽出処理
	// viewdb_SearchLineClass.php
	/*=======================================================
	    沿線　抽出処理
	=======================================================*/
	
	//県コードから
	$obj_sline = new viewdb_SLineClassTblAccess;
	$obj_sline->conn = $obj_conn->conn;
	$obj_sline->jyoken = array(); 
	$obj_sline->jyoken["st_prefcd"] = $ar_val;
	$obj_sline->jyoken["sc_stat"] = 1;
	$obj_sline->jyoken["cl_stat"] = 1;
	$obj_sline->jyoken["cl_pstat"] = 1;
	$obj_sline->jyoken["cl_start"] = 1;
	$obj_sline->jyoken["cl_end"] = 1;
	$obj_sline->jyoken["cl_deldate"] = 1;
	$obj_sline->sort['line'] = 1;
	$ret = $obj_sline->viewdb_GetSLinecd( 1 , -1);
	foreach( $obj_sline->slinedat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_sline->slinedat[$key][$key2] );
			}else{
				$view_slilne[$ar_val][$key][$key2] = $obj_sline->slinedat[$key][$key2];
				array_push($line_cd[$ar_val], explode( "/", $obj_sline->slinedat[$key]['es_linecd'] ) );
			}
		}
	}
	
	
	//県コードから検索した塾の沿線コードを抽出
	foreach( $line_cd[$ar_val] as $cd_key => $cd_val ){
		foreach( $cd_val as $cd_key2 => $cd_val2 ){
			if( $cd_val2 == "" ){
				unset( $line_cd[$ar_val][$cd_key][$cd_key2] );
			}else{
				$line_cd_list[$ar_val][] = intval( $line_cd[$ar_val][$cd_key][$cd_key2] );
			}
		}
		//沿線コード順にソート
		sort( $line_cd_list[$ar_val] );
	}
	//重複する沿線コードを削除
	$line_cd_list[$ar_val] = array_unique( $line_cd_list[$ar_val] );
}

foreach( $line_cd_list as $ar_key => $ar_val ){
	foreach( $ar_val as $cd_key => $cd_val ){
		$obj_mline = new mstdb_LineClassTblAccess;
		$obj_mline->conn = $obj_conn->conn;
		$obj_mline->jyoken = array();
		$obj_mline->jyoken["st_linecd"] = $cd_val;
		$obj_mline->mstdb_GetLine( 5 );
		$line_name_list[$ar_key][$cd_key] = $obj_mline->linedat[0]['st_line'];
	}
}

foreach( $_GET['ar'] as $ar_key => $ar_val ){

	if( is_array( $view_slilne[$ar_val] ) && count( $view_slilne[$ar_val] ) > 0 ){
		
		foreach( $line_cd_list[$ar_val] as $cd_key => $cd_val ){
		
			if( $cd_key == 0 ){
				$view_line_list .= '<a name="'.$ar_val.'"></a>'."\n";
				$view_line_list .= '<h3>'.$psel[$ar_val].'</h3>'."\n";
				$view_line_list .= '<div class="box">'."\n";
				$view_line_list .= '<table class="search1">'."\n";
				$view_line_list .= '<tr>';
				$view_line_list .= '<td><p class="area">'."\n";
			}
			
			//件数抽出(選択した県＋沿線での件数)
			$obj_slinecnt = new viewdb_SLineClassTblAccess;
			$obj_slinecnt->conn = $obj_conn->conn;
			$obj_slinecnt->jyoken = array(); 
			$obj_slinecnt->jyoken["st_prefcd"] = $ar_val;
			$obj_slinecnt->jyoken["es_linecd"] = $cd_val;
			$ret = $obj_slinecnt->viewdb_CntSLLine( 1 , -1);
			

			$view_line_list .= '<label class="pl"><input type="checkbox" name="ln[]" value="'.$ar_val."/".$cd_val.'"> <a href="/psearch-result/page-1.html'.$get_str.'&ln[]='.$ar_val."/".$cd_val.'&mode=ln">'.$line_name_list[$ar_val][$cd_key].'（'.$obj_slinecnt->slinedat[0]['count'].'件）</a></label>';
		}
		
		$view_line_list .= '</p></td>'."\n";
		$view_line_list .= '</tr>'."\n";
		$view_line_list .= '</table>'."\n";
		$view_line_list .= '</div>'."\n";
		
	}else{
		$view_line_list .= '<a name="'.$ar_val.'"></a>'."\n";
		$view_line_list .= '<h3>'.$psel[$ar_val].'</h3>'."\n";
		$view_line_list .= '<div class="box">'."\n";
		$view_line_list .= '<table class="search1">'."\n";
		$view_line_list .= '<tr>'."\n";
		$view_line_list .= '<td><p class="area">'."\n";
		$view_line_list .= '<br>'."\n";
		$view_line_list .= '</p></td>'."\n";
		$view_line_list .= '</tr>'."\n";
		$view_line_list .= '</table>'."\n";
		$view_line_list .= '</div>'."\n";
	}
}



//県指定時のtitle,keywords,descriptionを作成
//県名の羅列を作成
$pref_name_list1 = '';
$pref_name_list2 = '';	
foreach( $_GET['ar'] as $ar_key => $ar_val){
//カンマ区切り県名リスト
$pref_name_list1 .= ','.$psel[$ar_val];

//・区切り県名リスト
if( $pref_name_list2 != '' ) $pref_name_list2 .= '・';
$pref_name_list2 .= $psel[$ar_val];
}

//title
$view_header_title = '';
$view_header_title = $pref_name_list2.'の学習塾を沿線・駅名から探す｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
//keywords
$view_header_keywoeds = '';
$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校'.$pref_name_list1;
//description
$view_header_description = '';
$view_header_description = '塾タウンの沿線・駅名から検索ページ（'.$pref_name_list2.'）です。塾タウンは学習塾・進学塾探しのポータルサイトです。';
$view_header_description .= '地域や目的（受験対策・補修）、指導形態（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';

?>