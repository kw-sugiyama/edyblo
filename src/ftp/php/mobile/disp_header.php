<?php
/*===================================================================
    画面上部／HEADタグ内情報生成
	※必ず「client_check.php」を読み込んだ後に実行して下さい。
===================================================================*/

// 取得されたクライアント情報をヘッダー生成用変数へ
//    => $obj_login では１件しかない。
$arrHeaderView = Array();
FOREACH( $obj_login->clientdat[0] as $key => $val ){
	$arrHeaderView[$key] = htmlspecialchars( $val );
}


//-------------------------------------------------------------------
// <HEAD> タグ内情報
//-------------------------------------------------------------------
$arrMetaHeader = Array();

// <TITLE> タグ部分 - ブログタイトル
$arrMetaHeader["title"] = $arrHeaderView["sc_title"];

// <TITLE> タグ部分 - 会社名
$arrMetaHeader["title_corp"] = $arrHeaderView["cl_jname"]." ".$arrHeaderView["cl_kname"];

// HTMLキーワード
$arrMetaHeader["keyword"] = str_replace( "-" , "," , $arrHeaderView["sc_keyword"] );

// サイト説明文
$arrMetaHeader["description"] = str_replace( "\n" , "" , str_replace( "\r" , "\n" , $arrHeaderView["sc_introduce"] ) );



//-------------------------------------------------------------------
// 画面上部情報
//-------------------------------------------------------------------
// 表示用会社ロゴ - IMGタグ生成
IF( $arrHeaderView["blog_cl_logo"] != "" ){
	$arrHeaderView["blog_cl_logo"] = "<img src=\"./img_thumbnail.php?w=200&h=60&dir={$param_cl_logo_path}&nm={$arrHeaderView["sc_logo"]}\" alt=\"{$arrHeaderView["cl_jname"]} {$arrHeaderView["cl_kname"]}\">";
}

// ブログ説明文の改行処理
IF( $arrHeaderView["sc_introduce"] != "" ){
	$arrHeaderView["sc_introduce"] = nl2br( $arrHeaderView["sc_introduce"] );
}

//-------------------------------------------------------------------
// エラー戻り時のMETA/HEADER値をメンバー変数へ
//-------------------------------------------------------------------
$arrErr["meta"] = $arrMetaHeader;
$arrErr["header"] = $arrHeaderView;

$obj_topmenu = new basedb_MenuClassTblAccess;
$obj_topmenu->conn = $obj_conn->conn;
$obj_topmenu->jyoken["mn_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_topmenu->jyoken["mn_hstat_list"][]=1;
$obj_topmenu->jyoken["mn_hstat_list"][]=3;
$obj_topmenu->jyoken["mn_deldate"]=1;
$obj_topmenu->sort["mn_hdispno"] = 1;

list( $intCnt_menu , $intTotal_menu ) = $obj_topmenu->basedb_GetMenu ( 1 , -1 );

$linkurl=array();
$linkurl[]=_BLOG_SITE_URL_BASE.'school/';
$linkurl[]=_BLOG_SITE_URL_BASE.'qa/';
$linkurl[]=_BLOG_SITE_URL_BASE.'flow/';
$linkurl[]='javascript:void(0)" onclick="document.inquire.submit(); return false';

$dispcnt="";
$urlflag="";
$flag="";
$topmenu="";
$dispcnt=count($obj_topmenu->menudat)-1;
if($dispcnt>=0){
	for($cnt=0;$cnt<=3;$cnt++){
		$urlflag=$cnt+2;
		$flag=$obj_topmenu->menudat[$cnt]['mn_flg'];
		switch($obj_topmenu->menudat[$cnt]['mn_hstat']){
			case 1:
				 $topmenu.='<li class="globalmenu'.$urlflag.'"><a href="'.$linkurl[$flag-1].'">
<font color="#666666">
					  '.htmlspecialchars($obj_topmenu->menudat[$cnt]['mn_hname']).'
</font>					  
</a></li>
				';
				break;
			case 3:
				 $topmenu.='<li class="globalmenu'.$urlflag.'"><a href="'.$obj_topmenu->menudat[$cnt]['mn_hurl'].'">
					  
<font color="#666666">
					  '.htmlspecialchars($obj_topmenu->menudat[$cnt]['mn_hname']).'
					  
</font>
</a></li>
				';
				break;
			/*default:
				$topmenu.='<li class="globalmenu'.$urlflag.'"><a href="#"></a></li>
				';*/
		}
	}
}


// 携帯ロゴ - IMGタグ生成
$sc_logo="";
if($obj_login->clientdat[0]['sc_logo_mobile']){
	 $sc_logo='
		  <img src="./img_thumbnail.php?w=200&h=60&dir='.$param_cl_logo_mobile_path.'&nm='.$arrHeaderView["sc_logo_mobile"].'" alt="" />
		  ';
}


//echo $obj_login->clientdat[0]['sc_logo_mobile'];

//画像等の色
$img_color="";
switch($obj_login->clientdat[0]['sc_clr']){
	case 1://青
		$img_color="_1";
//
		break;
	case 2://緑
		$img_color="_2";
		break;
	case 3://オレンジ
		$img_color="_3";
		break;
	case 4://ブラウン
		$img_color="_4";
		break;
	case 5://紫
		$img_color="_5";
		break;
}
// 広告タグ挿入
$advertisement  = "";
if ( ($obj_login->clientdat[0]['cl_advertisement_flg'] == "1") and ($obj_login->clientdat[0]['cl_advertisement_tag'] != "")){
	$advertisement .= "<div class=\"adver_box\">\n";
	$advertisement .= "  <table class=\"adver_table\">\n";
	$advertisement .= "    <tr>\n";
	$advertisement .= "      <td class=\"adver_td_01\">\n";
	$advertisement .= "        <span class=\"adver_title\">お役立ち<br>リンク</span>\n";
	$advertisement .= "      </td>\n";
	$advertisement .= "      <td class=\"adver_td_02\">\n";
	$advertisement .= stripslashes( $obj_login->clientdat[0]['cl_advertisement_tag'] );
	$advertisement .= "      </td>\n";
	$advertisement .= "    </tr>\n";
	$advertisement .= "  </table>\n";
	$advertisement .= "</div>\n";
}

$_buffGoto=_BLOG_SITE_URL_BASE;
$buffViewString='エラーが発生しました。<br />TOPへお戻り下さい。';
?>
