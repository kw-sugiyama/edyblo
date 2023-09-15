<?php

/*=======================================================
    エリア検索用処理
=======================================================*/

// 飛び先指定
IF ($_GET["page_flg"] == "arealine"){
// 沿線検索

	//title
	$view_header_title = '';
	$view_header_title = '全国の沿線・駅名から学習塾を探す｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
	//keywords
	$view_header_keywoeds = '';
	$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,公立,私立,検索,沿線';
	//description
	$view_header_description = '';
	$view_header_description = '塾タウンの沿線・駅名から検索ページ（全国版）です。塾タウンは学習塾・進学塾探しのポータルサイトです。';
	$view_header_description .= '地域や目的（受験対策・補修）、指導形態（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';

//	全国の沿線コードを県別に分けて取得
//	v_search_line es_linecd_listでその県の沿線検索
//	発生があれば表示

	// 飛び先指定
	$link = "/psearch-line/";

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

} ELSE {
// エリア検索

	//title
	$view_header_title = '';
	$view_header_title = '全国のエリアから学習塾を探す｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
	//keywords
	$view_header_keywoeds = '';
	$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,公立,私立,検索';
	//description
	$view_header_description = '';
	$view_header_description = '塾タウンのエリアから検索ページ（全国版）です。塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、';
	$view_header_description .= '指導形態（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';

	// 飛び先指定
	$link = "/psearch-pref/";
	
	// viewdb_SearchPrefClass.php
	/*=======================================================
	    県　件数抽出処理
	=======================================================*/
	$obj_sprefcnt = new viewdb_SPrefClassTblAccess;
	$obj_sprefcnt->conn = $obj_conn->conn;
	$obj_sprefcnt->jyoken = array(); 
	$ret = $obj_sprefcnt->viewdb_CntSPref( 1 , -1);
	$view_prefdat = array();
	foreach( $obj_sprefcnt->sprefdat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_sprefcnt->sprefdat[$key][$key2] );
			}else{
				$view_prefdat[$key][$key2] = $obj_sprefcnt->sprefdat[$key][$key2];
			}
		}
	}
	unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);

};

$view_hokkaido = "";
$view_tohoku = "";
$view_kanto = "";
$view_hokuriku = "";
$view_tokai = "";
$view_kansai = "";
$view_shikoku = "";
$view_kyushu = "";

$tohoku_cnt = 0;
$kanto_cnt = 0;
$hokuriku_cnt = 0;
$tokai_cnt = 0;
$kansai_cnt = 0;
$shikoku_cnt = 0;
$kyushu_cnt = 0;

$select_val = '';	// プルダウン用変数

foreach( $view_prefdat as $key => $val){
/*　$psel[$view_prefdat[$key]['ar_prefcd']]　は県名　*/
	switch( TRUE ){
		
		
		/*北海道エリアの表示内容*/
		case ( $view_prefdat[$key]['ar_prefcd'] == 1) :
				$view_hokkaido .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'（'.$view_prefdat[$key]['count'].'件）</a></label>'."\n";
			break;
			
			
		/*東北エリアの表示内容*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 2 && $view_prefdat[$key]['ar_prefcd'] <= 7 ) :
			if( $tohoku_cnt != 0 && $tohoku_cnt%3 == 0 ) $view_tohoku .= "<br>\n";
				$view_tohoku .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'（'.$view_prefdat[$key]['count'].'件）</a></label>'."\n";
			$tohoku_cnt ++;
			break;
		
		
		/*関東エリアの表示内容*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 8 && $view_prefdat[$key]['ar_prefcd'] <= 14 ) :
			if( $kanto_cnt != 0 && $kanto_cnt%3 == 0 ) $view_kanto .= "<br>\n";
				$view_kanto .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'（'.$view_prefdat[$key]['count'].'件）</a></label>'."\n";
			$kanto_cnt ++;
			break;
		
		
		/*北陸エリアの表示内容*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 15 && $view_prefdat[$key]['ar_prefcd'] <= 20 ) :
			if( $hokuriku_cnt != 0 && $hokuriku_cnt%3 == 0 ) $view_hokuriku .= "<br>\n";
				$view_hokuriku .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'（'.$view_prefdat[$key]['count'].'件）</a></label>'."\n";
			$hokuriku_cnt ++;
			break;
		
		
		/*東海エリアの表示内容*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 21 && $view_prefdat[$key]['ar_prefcd'] <= 24 ) :
			if( $tokai_cnt != 0 && $tokai_cnt%3 == 0 ) $view_tokai .= "<br>\n";
				$view_tokai .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'（'.$view_prefdat[$key]['count'].'件）</a></label>'."\n";
			$tokai_cnt ++;
			break;
		
		
		/*関西エリアの表示内容*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 25 && $view_prefdat[$key]['ar_prefcd'] <= 30 ) :
			if( $kansai_cnt != 0 && $kansai_cnt%3 == 0 ) $view_kansai .= "<br>\n";
				$view_kansai .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'（'.$view_prefdat[$key]['count'].'件）</a></label>'."\n";
			$kansai_cnt ++;
			break;
		
		
		/*四国エリアの表示内容*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 31 && $view_prefdat[$key]['ar_prefcd'] <= 39 ) :
			if( $shikoku_cnt != 0 && $shikoku_cnt%3 == 0 ) $view_shikoku .= "<br>\n";
				$view_shikoku .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'（'.$view_prefdat[$key]['count'].'件）</a></label>'."\n";
			$shikoku_cnt ++;
			break;
		
		
		/*九州エリアの表示内容*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 40 && $view_prefdat[$key]['ar_prefcd'] <= 47 ) :
			if( $kyushu_cnt != 0 && $kyushu_cnt%3 == 0 ) $view_kyushu .= "<br>\n";
				$view_kyushu .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'（'.$view_prefdat[$key]['count'].'件）</a></label>'."\n";
			$kyushu_cnt ++;
			break;
	}

	// 物件が存在する県のみプルダウンに表示
	$select_val .= '<option value="' . $view_prefdat[$key]['ar_prefcd'] . '">' . $psel[$view_prefdat[$key]['ar_prefcd']] . '</option>' . "\n";
}

if( $view_hokkaido == "" ) $view_hokkaido = "&nbsp;\n";
if( $view_tohoku == "" ) $view_tohoku = "&nbsp;\n";
if( $view_kanto == "" ) $view_kanto = "&nbsp;\n";
if( $view_hokuriku == "" ) $view_hokuriku = "&nbsp;\n";
if( $view_tokai == "" ) $view_tokai = "&nbsp;\n";
if( $view_kansai == "" ) $view_kansai = "&nbsp;\n";
if( $view_shikoku == "" ) $view_shikoku = "&nbsp;\n";
if( $view_kyushu == "" ) $view_kyushu = "&nbsp;\n";

$view_pref_list = '
<div class="box">
<table class="search1">
<tr>
<th>
<p class="area"><strong>北海道</strong></p>
</th>
<td>
<p class="area">'.$view_hokkaido.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>東北</strong></p>
</th>
<td>
<p class="area">
'.$view_tohoku.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>関東</strong></p>
</th>
<td>
<p class="area">
'.$view_kanto.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>北陸・甲信越</strong></p>
</th>
<td>
<p class="area">
'.$view_hokuriku.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>東海</strong></p>
</th>
<td>
<p class="area">
'.$view_tokai.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>関西</strong></p>
</th>
<td>
<p class="area">
'.$view_kansai.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>中国・四国</strong></p>
</th>
<td>
<p class="area">
'.$view_shikoku.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>九州</strong></p>
</th>
<td>
<p class="area">
'.$view_kyushu.'</p>
</td>
</tr>
</table>

</div><!--search end-->
';

unset( $view_prefdat );

?>