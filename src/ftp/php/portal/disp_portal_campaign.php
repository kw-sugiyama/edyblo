<?php

/*==============================================================
    イベント一覧
==============================================================*/
// 1ページあたりの表示件数
define( 'DATACOUNT',10);

/*==============================================================
    キャンペーン最新情報一覧
==============================================================*/
$obj_campaign = new viewdb_CampainClassTblAccess;
$obj_campaign->jyoken = array();
$obj_campaign->conn = $obj_conn->conn;
$obj_campaign->jyoken["cp_stat"] = 1;       // イベントが有効かどうか
$obj_campaign->jyoken["cp_deldate"] = 1;	// キャンペーン情報が削除されていない
$obj_campaign->jyoken["cp_start"] = 1;      // イベント掲載開始日時が今日以前かどうか
$obj_campaign->jyoken["cp_end"] = 1;        // イベント掲載終了日時が今日以降かどうか
$obj_campaign->jyoken["cl_stat"] = 1;       // ブログ掲載フラグが有効かどうか
$obj_campaign->jyoken["cl_pstat"] = 1;      // ポータル掲載フラグが有効かどうか
$obj_campaign->jyoken["cl_start"] = 1;      // ブログ掲載開始日時が今日以前かどうか
$obj_campaign->jyoken["cl_end"] = 1;        // ブログ掲載終了日時が今日以降かどうか
$obj_campaign->jyoken["cl_deldate"] = 1;    // キャンペーン情報が削除されていない

$obj_campaign->sort["cp_upddate"] = 2;      // 並び順 - 最終更新日時降順

list( $intCnt_cam , $intTotal_cam ) = $obj_campaign->viewdb_GetCampain( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
$ret = $obj_campaign->viewdb_CntCampain( 0,0 );
if( is_array( $obj_campaign->campaindat ) ){
	foreach( $obj_campaign->campaindat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_campaign->campaindat[$key][$key2] );
			}else{
				$view_campaigndat[$key][$key2] = htmlspecialchars( $obj_campaign->campaindat[$key][$key2] );
			}
		}
	}
	unset($key,$key2,$val,$val2);
}

// 全体の件数
$total_campaign_cnt = $intTotal_cam;


$view_campaign_main_list = "";
if( $intCnt_cam < 1 ){
	$view_campaign_main_list = '
<div class="box2">
<p>現在、イベントはありません。</p>
</div>
';
}else{
	foreach( $view_campaigndat as $key => $val ){
	
		$remake_upddate = substr( $view_campaigndat[$key]['cp_upddate'] ,0 ,10);
		
		//塾名・教室名
		$view_school_name = "";
		if( $view_campaigndat[$key]['cl_kname'] != "" ){
			$view_school_name = $view_campaigndat[$key]['cl_jname']."・".$view_campaigndat[$key]['cl_kname'];
		}else{
			$view_school_name = $view_campaigndat[$key]['cl_jname'];
		}
		
		//独自ドメインの場合
		if( $view_campaigndat[$key]['cl_dokuji_flg']  == 1 ){
			$campaign_url = $view_campaigndat[$key]['cl_dokuji_domain'].'campaign-detail-'.$view_campaigndat[$key]['cp_id']."/";
		//独自ドメインでない場合
		}else{
			$campaign_url = _BLOG_SITE_URL_BASE.'/'.$view_campaigndat[$key]['cl_urlcd'].'/campaign-detail-'.$view_campaigndat[$key]['cp_id'].'/';
		}

		$view_campaign_main_list .= '
<div class="box2">
<p class="arrow"><strong><a href="'.$campaign_url.'" target="_blank">'.$remake_upddate.'&nbsp;'.$view_campaigndat[$key]['cp_title'].'('.$view_school_name.')'.'</a></strong></p>'
.'<p class="margint1">' . html_delete($view_campaigndat[$key]['cp_contents']) .'</p>
</div>';
	}
}

//パンクズの生成
$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>イベント一覧</strong></p>';
		
/*---------------------------------------------------------
    ページ遷移部品作成
	$strViewPageNowCount    ... 現在表示している件数コメント
	$strViewPageMove        ... ページ遷移リンク
	$strViewPageMove_before ... 「前へ」
	$strViewPageMove_after  ... 「後へ」
	$_GET["p"]              ... 現在のページ
	DATACOUNT               ... 表示件数(上限)
					(上にて指定済み)
	$total_campaign_cnt     ... 検索対象全体数
---------------------------------------------------------*/
IF( $intCnt_cam > 0 ){
	$strBuffStartCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + 1;
	$strBuffEndCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + $intCnt_cam;

	$intBuffMove = $total_campaign_cnt / DATACOUNT;
	IF( is_int($intBuffMove) === FALSE ){
		$intBuffMove = ceil($intBuffMove);
	}

	$link_URL1 = "<a href=\"" . _BLOG_SITE_URL_BASE."/campaign-";
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
			$next_cnt = $total_campaign_cnt - $strBuffEndCnt;
			IF($next_cnt >= DATACOUNT){
				$next_cnt = DATACOUNT;
			}
			$intBuffCnt_af = $_GET["p"] + 1;
			$strViewPageMove_after .= $link_URL1 . $intBuffCnt_af . $link_URL2 . "次の{$next_cnt}件</a>\n";
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
				$strViewPageMove_Cnt .= $link_URL1 . $iX . $link_URL2 . $iX . "</A>\n";
			}
		}
		// ...3 4 5 6 7 8 9 10 11 12 13... みたいな感じ
		//$strViewPageMove_Cnt = $strViewPageMove_Cnt_more_before . $strViewPageMove_Cnt . $strViewPageMove_Cnt_more_after;
		// 3 4 5 6 7 8 9 10 11 12 13 みたいな感じ
		$strViewPageMove_Cnt = $strViewPageMove_Cnt;

	}

	$view_page_list='<div class="pagenavi">
<p class="pagenavileft">全'.$total_campaign_cnt.'件&nbsp;&nbsp;'.$strBuffStartCnt.'-'.$strBuffEndCnt.'件を表示中</p>
<p class="pagenaviright">'.$strViewPageMove_before.$strViewPageMove_Cnt.$strViewPageMove_after.'</p><br class="clear">
</div>
';
}

unset( $obj_campaign, $view_campaigndat );

/*==============================================================
    TOPページ表示内容生成ファイル
==============================================================*/

//title
$view_header_title = '';
$view_header_title = '新着イベント情報一覧｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
//keywords
$view_header_keywoeds = '';
$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,夏期講習,冬期講習,無料体験授業,イベント';
//description
$view_header_description = '';
$view_header_description = '塾タウンの新着イベント一覧ページです。夏期講習・冬期講習・無料体験授業などの各種イベントを掲載。';
$view_header_description .= '塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、指導形式（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';

?>