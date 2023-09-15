<?php
/*==============================================================
    TOPページ表示内容生成ファイル
==============================================================*/

//title
$view_header_title = "";
//$view_header_title = '学習塾・進学塾・塾探しのポータルサイト「塾タウン」−全国の小学校・中学校・高校の入試・受験をサポート−';
$view_header_title = '学習塾探しのポータル「塾タウン」−全国の個別指導塾や中学受験対策など進学塾を掲載';

//keywords
$view_header_keywoeds = "";
$view_header_keywoeds = "学習塾,進学塾,個別指導,中学受験,塾タウン";

//description
$view_header_description  = "";
$view_header_description .= "塾タウンは学習塾・進学塾探しのポータルサイトです。";
$view_header_description .= "地域や目的（中学受験対策・補習）、指導形式（個別指導・少人数指導・集団指導）などから";
$view_header_description .= "簡単に塾を検索できます。";

/*
$view_header_description = "塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補習）、指導形式（個別指導・少人数指導・集団指導）";
$view_header_description .= 'などから簡単に塾を検索できます。';
*/

/*==============================================================
    塾のある沿線の県のみプルダウンに表示する
==============================================================*/

	// viewdb_SearchLineClass.php
	/*=======================================================
	    県　件数抽出処理
	=======================================================*/
	$obj_sprefcnt = new viewdb_SLineClassTblAccess;
	$obj_sprefcnt->conn = $obj_conn->conn;
	$obj_sprefcnt->jyoken = array(); 
	$ret = $obj_sprefcnt->viewdb_CntSLPref( 1 , -1);
	$view_prefdat = array();
	foreach( $obj_sprefcnt->slinedat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_sprefcnt->slinedat[$key][$key2] );
			}else{
				$view_prefdat[$key][$key2] = $obj_sprefcnt->slinedat[$key][$key2];
				$view_prefdat[$key]['ar_prefcd'] = $view_prefdat[$key]['st_prefcd'];
			}
		}
	}
	unset($key, $key2, $val, $val2, $obj_sprefcnt->slinedat);
	
	$view_prefline_list = "";
	$view_prefline_list .= '<option value="" selected="selected">都道府県</option>';
	
	foreach( $view_prefdat as $key => $val){
		// 物件が存在する県のみプルダウンに表示
		$view_prefline_list .= '<option value="' . $view_prefdat[$key]['ar_prefcd'] . '">' . $psel[$view_prefdat[$key]['ar_prefcd']] . '</option>' . "\n";
	}
	
?>