<?php

/*==============================================================
    日記一覧
==============================================================*/
// 1ページあたりの表示件数
define( 'DATACOUNT',10);

/*==============================================================
    キャンペーン最新情報一覧
==============================================================*/
$obj_diary = new viewdb_DiaryClassTblAccess;
$obj_diary->jyoken = array();
$obj_diary->conn = $obj_conn->conn;
$obj_diary->jyoken["dr_stat"] = 1;       // 日記が有効かどうか
$obj_diary->jyoken["dr_deldate"] = 1;	// キャンペーン情報が削除されていない
$obj_diary->jyoken["dr_start"] = 1;      // 日記掲載開始日時が今日以前かどうか
$obj_diary->jyoken["dr_end"] = 1;        // 日記掲載終了日時が今日以降かどうか
$obj_diary->jyoken["cl_stat"] = 1;       // ブログ掲載フラグが有効かどうか
$obj_diary->jyoken["cl_pstat"] = 1;      // ポータル掲載フラグが有効かどうか
$obj_diary->jyoken["cl_start"] = 1;      // ブログ掲載開始日時が今日以前かどうか
$obj_diary->jyoken["cl_end"] = 1;        // ブログ掲載終了日時が今日以降かどうか
$obj_diary->jyoken["cl_deldate"] = 1;    // キャンペーン情報が削除されていない

$obj_diary->sort["dr_upddate"] = 2;      // 並び順 - 最終更新日時降順

list( $intCnt_dir , $intTotal_dir ) = $obj_diary->viewdb_GetDiary( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
$ret = $obj_diary->viewdb_CntDiary( 0,0 );
if( is_array( $obj_diary->diarydat ) ){
	foreach( $obj_diary->diarydat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_diary->diarydat[$key][$key2] );
			}else{
				$view_diarydat[$key][$key2] = htmlspecialchars( $obj_diary->diarydat[$key][$key2] );
			}
		}
	}
	unset($key,$key2,$val,$val2);
}

// 全体の件数
$total_diary_cnt = $intTotal_dir;


$view_diary_main_list = "";
if( $intCnt_dir < 1 ){
	$view_diary_main_list = '
<div class="box2">
<p>現在、日記はありません。</p>
</div>
';
}else{
	foreach( $view_diarydat as $key => $val ){
	
		$remake_upddate = substr( $view_diarydat[$key]['dr_upddate'] ,0 ,10);
		
		//塾名・教室名
		$view_school_name = "";
		if( $view_diarydat[$key]['cl_kname'] != "" ){
			$view_school_name = $view_diarydat[$key]['cl_jname']."・".$view_diarydat[$key]['cl_kname'];
		}else{
			$view_school_name = $view_diarydat[$key]['cl_jname'];
		}

		//独自ドメインの場合
		if( $view_diarydat[$key]['cl_dokuji_flg']  == 1 ){
			$diary_url = $view_diarydat[$key]['cl_dokuji_domain'].'blog-'.$view_diarydat[$key]['dr_id']."/";
		//独自ドメインでない場合
		}else{
			$diary_url = _BLOG_SITE_URL_BASE.'/'.$view_diarydat[$key]['cl_urlcd'].'/blog-'.$view_diarydat[$key]['dr_id'].'/';
		}
		$view_diary_main_list .= '
<div class="box2">
<p class="arrow"><strong><a href="'.$diary_url.'" target="_blank">'.$remake_upddate.'&nbsp;'.$view_diarydat[$key]['dr_title'].'('.$view_school_name.')'.'</a></strong></p>'
.'<p class="margint1">' . html_delete($view_diarydat[$key]['dr_contents']) .'</p>
</div>';
	}
}

//パンクズの生成
$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>日記一覧</strong></p>';
		
/*---------------------------------------------------------
    ページ遷移部品作成
	$strViewPageNowCount    ... 現在表示している件数コメント
	$strViewPageMove        ... ページ遷移リンク
	$strViewPageMove_before ... 「前へ」
	$strViewPageMove_after  ... 「後へ」
	$_GET["p"]              ... 現在のページ
	DATACOUNT               ... 表示件数(上限)
					(上にて指定済み)
	$total_diary_cnt     ... 検索対象全体数
---------------------------------------------------------*/
IF( $intCnt_dir > 0 ){
	$strBuffStartCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + 1;
	$strBuffEndCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + $intCnt_dir;

	$intBuffMove = $total_diary_cnt / DATACOUNT;
	IF( is_int($intBuffMove) === FALSE ){
		$intBuffMove = ceil($intBuffMove);
	}

	$link_URL1 = "<A href=\"" . _BLOG_SITE_URL_BASE."/diary-";
	$link_URL2 = ".html\" target=\"_self\" >";

	// 2ページ以上ある場合のみ直接リンクを作成
	if ($intBuffMove > 1){
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
			$next_cnt = $total_diary_cnt - $strBuffEndCnt;
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
				$strViewPageMove_Cnt .= "<b>". $iX . "</b>\n";
			} ELSE {
				$strViewPageMove_Cnt .= $link_URL1 . $iX . $link_URL2 . $iX . "</a>\n";
			}
		}
		// ...3 4 5 6 7 8 9 10 11 12 13... みたいな感じ
		//$strViewPageMove_Cnt = $strViewPageMove_Cnt_more_before . $strViewPageMove_Cnt . $strViewPageMove_Cnt_more_after;
		// 3 4 5 6 7 8 9 10 11 12 13 みたいな感じ
		$strViewPageMove_Cnt = $strViewPageMove_Cnt;
	}
	$view_page_list='<div class="pagenavi">
<p class="pagenavileft">全'.$total_diary_cnt.'件&nbsp;&nbsp;'.$strBuffStartCnt.'-'.$strBuffEndCnt.'件を表示中</p>
<p class="pagenaviright">'.$strViewPageMove_before.$strViewPageMove_Cnt.$strViewPageMove_after.'</p><br class="clear">
</div>
';
}

unset( $obj_diary, $view_diarydat );

/*==============================================================
    TOPページ表示内容生成ファイル
==============================================================*/

//title
$view_header_title = '';
$view_header_title = '塾からのお知らせ・日記一覧｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
//keywords
$view_header_keywoeds = '';
$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,お知らせ,日記';
//description
$view_header_description = '';
$view_header_description = '塾タウンのお知らせ・日記一覧ページです。塾からのお知らせや、日記などを多数掲載。';
$view_header_description .= '塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、指導形式（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';

?>