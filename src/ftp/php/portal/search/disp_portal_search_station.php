<?php

/*=======================================================
    駅検索用処理
=======================================================*/

// 県指定が無い場合はエラー
IF( count( $_GET["ar"] ) == 0 && count( $_POST["ar"] ) == 0 ){
	$arrErr['ath_comment'] = "<input type=\"hidden\" name=\"fa\" value=\"{$_GET['fa']}\">\n";
	$arrErr['ath_comment'] .= $hddnVal;
	$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/psearch-arealine/" , $arrErr );
	exit;
}
// 沿線指定が無い場合はエラー
IF( count( $_GET["ln"] ) == 0 && count( $_POST["ln"] ) == 0 ){
	$arrErr['ath_comment'] = "<input type=\"hidden\" name=\"fa\" value=\"{$_GET['fa']}\">\n";
	$arrErr['ath_comment'] .= $hddnVal;
	$obj_error->ViewErrMessage( "NO_LINE_SITEI" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/psearch-arealine/" , $arrErr );
	exit;
}


$ln_data = array();
$ln_pref = array();
$ln_cd = array();
foreach( $_GET['ln'] as $ln_key => $ln_val ){
	$ln_data = explode( "/", $ln_val );
	$ln_pref[] = pg_escape_string($ln_data[0]);
	$ln_cd[]= pg_escape_string($ln_data[1]);
}

//print_r ($ln_cd);


// viewdb_SearchLineClass.php
/*=======================================================
   沿線検索処理
=======================================================*/
$obj_sline = new viewdb_SLineClassTblAccess;
$obj_sline->conn = $obj_conn->conn;
$obj_sline->jyoken = array();
$obj_sline->jyoken["es_linecd_list"] = $ln_cd;  // 沿線コードを指定
$obj_sline->jyoken["st_prefcd_list"] = $ln_pref;  // 沿線コードを指定
$obj_sline->jyoken["sc_stat"] = 1;              // ブログ基本情報設定済みフラグが有効かどうか
$obj_sline->jyoken["cl_stat"] = 1;              // ブログ掲載フラグが有効かどうか
$obj_sline->jyoken["cl_pstat"] = 1;             // ポータル掲載フラグが有効かどうか
$obj_sline->jyoken["cl_start"] = 1;             // ブログ掲載開始日時が今日以前かどうか
$obj_sline->jyoken["cl_end"] = 1;               // ブログ掲載終了日時が今日以降かどうか
$obj_sline->jyoken["cl_deldate"] = 1;           // クライアント情報が削除されていない
$obj_sline->sort["sta"] = 1;                    // 並び順 - 駅コード順
list( $intCnt , $intTotal ) = $obj_sline->viewdb_GetSLine( 1 , -1 );
//IF( $intCnt == -1 ){
//	$obj_error->ViewErrMessage( "NO_LINE_SITEI" , "PORTAL-USER" , _BLOG_SITE_URL_BASE . "/psearch-arealine/" , $arrErr );
//	exit;
//}
foreach( $obj_sline->slinedat as $key => $val ){
	foreach( $val as $key2 => $val2 ){
		if( is_numeric( $key2 ) ) {
			unset( $obj_sline->slinedat[$key][$key2] );
		} else {
			$view_stationdat[$key][$key2] = $obj_sline->slinedat[$key][$key2];
		}
	}
}
unset($key,$key2,$val,$val2,$obj_sline->slinedat);

// viewdb_SearchLineClass.php
/*=======================================================
    沿線　件数抽出処理
=======================================================*/
$obj_slinecnt = new viewdb_SLineClassTblAccess;
$obj_slinecnt->conn = $obj_conn->conn;
$obj_slinecnt->jyoken = array();
$obj_slinecnt->jyoken["sc_stat"] = 1;			// ブログ基本情報設定済みフラグが有効かどうか
$obj_slinecnt->jyoken["cl_stat"] = 1;			// ブログ掲載フラグが有効かどうか
$obj_slinecnt->jyoken["cl_pstat"] = 1;			// ポータル掲載フラグが有効かどうか
$obj_slinecnt->jyoken["cl_start"] = 1;			// ブログ掲載開始日時が今日以前かどうか
$obj_slinecnt->jyoken["cl_end"] = 1;			// ブログ掲載終了日時が今日以降かどうか
$obj_slinecnt->jyoken["cl_deldate"] = 1;		// クライアント情報が削除されていない

$view_exp_stationdat = array();
$Cnt = 0;
// 最寄り沿線(スラッシュで区切られている)の数だけ行を複製
// かつ_GETで渡ってきている沿線のみ
FOREACH( $view_stationdat as $key => $val){
	// 最寄り沿線(スラッシュで区切られている)をバラす
	$buf_arr_cd = explode("/",$val["es_linecd"]);
	$buf_arr_nm = explode("/",$val["es_linecdname"]);
	$arr_cd = array();
	$arr_nm = array();

	// 配列最初と最後に空っぽが入ってしまうので削除
	FOREACH( $buf_arr_cd as $buf_key => $buf_val ){
		if ($buf_val != "") $arr_cd[] = $buf_val;
	}
	FOREACH( $buf_arr_nm as $buf_key => $buf_val ){
		if ($buf_val != "") $arr_nm[] = $buf_val;
	}

	FOREACH( $arr_cd as $expkey => $expval ){
		// 検索対象の沿線であればレコードを作成 それ以外の沿線はスルー
		if ( in_array($expval,$ln_cd) ) {
			$view_exp_stationdat[$Cnt]["es_linecd"]	= $expval;		// 沿線コード
			$view_exp_stationdat[$Cnt]["es_line"]	= $arr_nm[$expkey];	// 沿線名
			$view_exp_stationdat[$Cnt]["st_stacd"]	= $val["st_stacd"];	// 駅コード
			$view_exp_stationdat[$Cnt]["st_sta"]	= $val["st_sta"];	// 駅名

			// その駅の件数を取得
			$obj_slinecnt->jyoken["st_stacd_list"] = array( $val["st_stacd"] );	// 駅コードを指定
			$ret = $obj_slinecnt->viewdb_CntSLine( 1 , -1);
			if( is_array( $obj_slinecnt->slinedat ) ){
				foreach( $obj_slinecnt->slinedat as $cnt_key => $cnt_val ){
					foreach( $cnt_val as $cnt_key2 => $cnt_val2 ){
						if( is_numeric( $cnt_key2 ) ) {
							unset( $obj_slinecnt->slinedat[$cnt_key][$cnt_key2] );
						}
					}
				}
			}
			$view_exp_stationdat[$Cnt]["count"]	= $obj_slinecnt->slinedat[0]["count"];		// その駅の件数
			unset($cnt_key,$cnt_key2,$cnt_val,$cnt_val2);

			$Cnt++;
		}
	}
	$Cnt++;
}
//print_r($view_exp_stationdat);

// 結果レコードの重複レコードを削除
$tmp = array();
FOREACH($view_exp_stationdat as $key => $val ){
	if(!in_array($val,$tmp)){
		$tmp[] = $val;
	}
}
$view_exp_stationdat = $tmp;

//print_r($view_exp_stationdat);

// 沿線コード(es_linecd)、駅コード(st_stacd) でソート
// 列方向の配列を得る
foreach ($view_exp_stationdat as $key => $row) {
	$es_linecd[$key]	= $row['es_linecd'];
	$st_stacd[$key]		= $row['st_stacd'];
}

// データを st_stacd の降順、st_stacd の昇順にソートする。
// $data を最後のパラメータとして渡し、同じキーでソートする。
array_multisort($es_linecd, SORT_ASC, $st_stacd, SORT_ASC, $view_exp_stationdat);

//print_r($view_exp_stationdat);

//------------------------------------------------------------------------------
// 表示値の取得／整理
//------------------------------------------------------------------------------
$arrBuffList = Array();
$Cnt = 0;
FOREACH( $view_exp_stationdat as $key => $val){

	// $arrBuffList[県コード][配列カウント(沿線)][フィールド名]

	// 前回と沿線コードが変わったら 配列カウントを0に
	// Select結果はst_prefcdでOrderする
	if ($prefcd != $val["es_linecd"]){
		$Cnt = 0;
	}

	$ix = $val["es_linecd"];
	$arrBuffList[$ix][$Cnt]["es_linecd"]	= $val["es_linecd"];		// 沿線コード
	$arrBuffList[$ix][$Cnt]["es_line"]	= $val["es_line"];		// 沿線名
	$arrBuffList[$ix][$Cnt]["st_stacd"]	= $val["st_stacd"];		// 駅コード
	$arrBuffList[$ix][$Cnt]["st_sta"]	= $val["st_sta"];		// 駅名
	$arrBuffList[$ix][$Cnt]["count"]	= $val["count"];		// 駅の物件数

	// 前回の沿線コードを保存
	$prefcd	= $val["es_linecd"];
	$Cnt++;
}

//print_r($arrBuffList);

// GET値作成 ar
// hidden作成
FOREACH($_GET["ar"] as $key => $val){
	if ($get_str_ar == ''){
		$get_str_ar .= '?';
	} else {
		$get_str_ar .= '&';
	}
	$hidden_str .= '<input type="hidden" name="ar[]" value="' . $val . '">' . "\n";
	$get_str_ar .= 'ar[]=' . $val;
}
FOREACH($ln_cd as $key => $val){
	if ($get_str_ar == ''){
		$get_str_ar .= '?';
	} else {
		$get_str_ar .= '&';
	}
	$hidden_str .= '<input type="hidden" name="ln[]" value="' . $val . '">' . "\n";
	$get_str_ar .= 'ln[]=' . $val;
}
// 検索結果用モード 'ln' or 'st'
$hidden_str .= '<input type="hidden" name="mode" value="st">' . "\n";

// 選択した県一覧
$view_select_line .= '<h3 class="orange">選択した沿線</h3>' . "\n";
$view_select_line .= '<div class="box">' . "\n";
$view_select_line .= '    <table class="search1">' . "\n";
$view_select_line .= '        <tr>' . "\n";
$view_select_line .= '            <td><div class="area">' . "\n";

$line_name_list1 = '';
$line_name_list2 = '';	

$cnt = 0;
FOREACH( $arrBuffList as $key => $val){

	//カンマ区切り沿線名リスト
	$line_name_list1 .= ','.$val[0]["es_line"];

	//・区切り沿線名リスト
	if( $line_name_list2 != '' ) $line_name_list2 .= '・';
	$line_name_list2 .= $val[0]["es_line"];

	//$view_select_line .= '                <div class="areatext"><p><a href="#'.$key.'">'.$val[0]["es_line"].'（'.count($val).'件）</a></p></div>'."\n";

	$cnt++;
	// 沿線名は長いから5つじゃはみ出ちゃう…
	//if( $cnt%5 == 0 ){
	if( $cnt%3 == 0 ){
		$view_select_line .= '                <div class="areatext2"><p><a href="#'.$key.'">'.$val[0]["es_line"].'</a></p></div>'."\n";
//		$view_select_line .= '                <div class="clear"></div>'."\n";
	}else{
		$view_select_line .= '                <div class="areatext2"><p><a href="#'.$key.'">'.$val[0]["es_line"].'</a></p></div>'."\n";
	}

	// 沿線一覧
	$view_station_list .= '<a name="'.$key.'"></a>';
	$view_station_list .= '<h3>' . $val[0]["es_line"] . '</h3>' . "\n";
	$view_station_list .= '<div class="box">' . "\n";
	$view_station_list .= '    <table class="search1">' . "\n";
	$view_station_list .= '        <tr>' . "\n";
	$view_station_list .= '            <td><p class="area">' . "\n";

	$cnt_br = 0;
	FOREACH( $val as $key2 => $val2){
		$view_station_list .= '                <label class="pl">';
		$view_station_list .= '<input type="checkbox" name="st[]" value="' . $val2["st_stacd"] . '">';
		$view_station_list .= ' <a href="/psearch-result/page-1.html' . $get_str_ar . '&st[]=' . $val2["st_stacd"] . '&mode=st' . '">' . $val2["st_sta"] . '駅（' . $val2["count"] . '件）</a></label>' . "\n";
		$cnt_br++;
		if( $cnt_br%3 == 0 ){
//			$view_station_list .= '                <br>'."\n";
		}
	}

	$view_station_list .= '            </p></td>' . "\n";
	$view_station_list .= '        </tr>' . "\n";
	$view_station_list .= '    </table>' . "\n";
	$view_station_list .= '</div>' . "\n";

}
$view_select_line .= '            </div></td>' . "\n";
$view_select_line .= '        </tr>' . "\n";
$view_select_line .= '    </table>' . "\n";
$view_select_line .= '</div>' . "\n";

//沿線指定時のtitle,keywords,descriptionを作成
//沿線名の羅列を作成

//title
$view_header_title = '';
$view_header_title = $line_name_list2.'沿線の学習塾を探す｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
//keywords
$view_header_keywoeds = '';
$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校'.$line_name_list1;
//description
$view_header_description = '';
$view_header_description = '塾タウンの沿線・駅名から検索ページ（'.$line_name_list2.'）です。塾タウンは学習塾・進学塾探しのポータルサイトです。';
$view_header_description .= '地域や目的（受験対策・補修）、指導形態（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';


//パンクズの生成
$query_str = "";
foreach( $_GET['ar'] as $key => $val ){
	if( $key == 0 ){
		$query_str .= "?ar[]=".$val;
	}else{
		$query_str .= "&ar[]=".$val;
	}
}
$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-arealine/">沿線・駅名検索</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-line/'.$query_str.'">県別沿線一覧</a></strong><span class="paddinglr1">&gt;</span><strong>駅一覧</strong></p>';

?>