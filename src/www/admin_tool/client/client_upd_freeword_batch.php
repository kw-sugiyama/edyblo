<?
/******************************************************************************
	フリーワード検索用文字列更新バッチ処理
******************************************************************************/

/*
echo'<PRE>';
print_r($_SESSION);
print_r($_POST);
echo'</PRE>';
*/

/*---------------------------------------------------------
	フリーワード用情報生成
	&が着いているのは参照渡し
---------------------------------------------------------*/
function fn_create_freeword( $p_conn , $p_cl_id , &$p_cl_yobi1 , $p_cl_jname , $p_cl_kname) {
	$p_cl_yobi1 = '';

	// 教室情報を取得
	//  ブログ基本情報登録
	$obj_blog = new basedb_SchoolClassTblAccess;
	$obj_blog->conn = $p_conn;
	$obj_blog->jyoken["sc_clid"] = $p_cl_id;		// クライアントID
	list( $intCnt , $intTotal ) = $obj_blog->basedb_GetSchool( 0 , -1 );
	if( $intCnt == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= $athComment;
	        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "" , $arrOther );
	        exit;
	}

	// エリア情報を取得
	$obj_area = new basedb_AreaClassTblAccess;
	$obj_area->conn = $p_conn;
	$obj_area->jyoken["ar_clid"]	= $p_cl_id;	// クライアントID
	$obj_area->sort['ar_flg']	= 2;			// 対象エリア順
	list( $intCnt , $intTotal ) = $obj_area->basedb_GetArea( 0 , -1 );
	if( $intCnt == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= $athComment;
	        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "" , $arrOther );
	        exit;
	}

	// 沿線情報を取得
	$obj_ensen = new basedb_EnsenClassTblAccess;
	$obj_ensen->conn = $p_conn;
	//$obj_ensen->jyoken["es_cd"]	= $obj_blog->blogdat[0]['sc_id'];	// 教室ID
	$obj_ensen->jyoken["es_cd"]	= $p_cl_id;	// クライアントID
	$obj_ensen->jyoken["es_dispno"]	= 1;					// 表示順=1
	list( $intCnt , $intTotal ) = $obj_ensen->basedb_GetEnsen( 0 , -1 );
				
	//print_r($obj_blog->blogdat);
	//print_r($obj_area->areadat);
	//print_r($obj_ensen->ensendat);
	// 塾名
	$str = $p_cl_jname;
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// 教室名
	$str = $p_cl_kname;
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// 塾名+教室名
	$str = $p_cl_jname . $p_cl_kname;
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// エリア情報 $obj_area->areadatに教室住所、エリア1〜3の4レコード返ってくる
	FOREACH($obj_area->areadat as $key => $val ){

		// 郵便番号 空レコードにハイフンが入ってるので回避
		$str = $val["ar_zip"];
		if($str!="" and $str!="-")$p_cl_yobi1 .= $str . '/';
		// 都道府県名
		$str = $val["ar_pref"];
		if($str!="")$p_cl_yobi1 .= $str . '/';
		// 市区町村名
		$str = $val["ar_city"];
		if($str!="")$p_cl_yobi1 .= $str . '/';
		// $key=0(最初のレコード)=塾の住所 の場合のみ 番地 建物名
		if ($key == 0) {
			// 番地
			$str = $val["ar_add"];
			if($str!="")$p_cl_yobi1 .= $str . '/';
			// 建物名
			$str = $val["ar_estate"];
			if($str!="")$p_cl_yobi1 .= $str . '/';

			// 都道府県名+市区町村名+番地+建物名
			$buff_add_str = '';
			$buff_add_str = $val["ar_pref"] . $val["ar_city"] . $val["ar_add"] . $val["ar_estate"];
		} else {
			// 都道府県名+市区町村名
			$buff_add_str = '';
			$buff_add_str = $val["ar_pref"] . $val["ar_city"];
		}
		if($buff_add_str!="") $p_cl_yobi1 .= $buff_add_str . '/';
	}

	// ブログ紹介文
	$str = $obj_blog->blogdat[0]["sc_introduce"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// 運営会社
	$str = $obj_blog->blogdat[0]["sc_company"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOPウインドウタイトル
	$str = $obj_blog->blogdat[0]["sc_topwindowtitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ヘッダー用タイトル
	$str = $obj_blog->blogdat[0]["sc_headertitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP教室情報タイトル
	$str = $obj_blog->blogdat[0]["sc_toptitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP教室情報サブタイトル
	$str = $obj_blog->blogdat[0]["sc_topsubtitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOPキャンペーンイベント
	$str = $obj_blog->blogdat[0]["sc_campaintitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOPコース情報タイトル
	$str = $obj_blog->blogdat[0]["sc_coursetitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP日記情報タイトル
	$str = $obj_blog->blogdat[0]["sc_diarytitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// 入塾説明文
	$str = $obj_blog->blogdat[0]["sc_addmission"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// 対象学年
	$sc_age = htmlspecialchars ($obj_blog->blogdat[0]["sc_age"]);
	if(($sc_age & 64) == 64 ){
		$p_cl_yobi1 .= "社会人" . '/';
		$sc_age -= 64;
	}
	if(($sc_age & 32) == 32 ){
		$p_cl_yobi1 .= "大学生" . '/';
		$sc_age -= 32;
	}
	if(($sc_age & 16) == 16 ){
		$p_cl_yobi1 .= "浪人生" . '/';
		$sc_age -= 16;
	}
	if(($sc_age & 8) == 8 ){
		$p_cl_yobi1 .= "高校生" . '/';
		$sc_age -= 8;
	}
	if(($sc_age & 4) == 4 ){
		$p_cl_yobi1 .= "中学生" . '/';
		$sc_age -= 4;
	}
	if(($sc_age & 2) == 2 ){
		$p_cl_yobi1 .= "小学生" . '/';
		$sc_age -= 2;
	}
	if(($sc_age & 1) == 1 ){
		$p_cl_yobi1 .= "幼児" . '/';
		$sc_age -= 1;
	}

	// 授業形態
	$sc_classform = htmlspecialchars ($obj_blog->blogdat[0]["sc_classform"]);
	if(($sc_classform & 4) == 4 ){
		$p_cl_yobi1 .= "個別" . '/';
		$sc_classform -= 4;
	}
	if(($sc_classform & 2) == 2 ){
		$p_cl_yobi1 .= "少人数" . '/';
		$sc_classform -= 2;
	}
	if(($sc_classform & 1) == 1 ){
		$p_cl_yobi1 .= "集団" . '/';
		$sc_age -= 1;
	}

	// 最寄沿線名
	$str = $obj_ensen->ensendat[0]["es_line"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// 最寄駅名
	$str = $obj_ensen->ensendat[0]["es_sta"];
	if($str!="")$p_cl_yobi1 .= $str . '駅' . '/';

	// 徒歩
	$str = $obj_ensen->ensendat[0]["es_walk"];
	if($str!="")$p_cl_yobi1 .= '徒歩' . $str . '分' . '/';

	// バス
	$str = $obj_ensen->ensendat[0]["es_bus"];
	if($str!="")$p_cl_yobi1 .= 'バス' . $str . '分' . '/';

	// 教室PR文
	$str = $obj_blog->blogdat[0]["sc_pr"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// 最後に頭にスラッシュをつける (空じゃなければ)
	if ($p_cl_yobi1 != "") $p_cl_yobi1 = '/' . $p_cl_yobi1;

}
// フリーワード用情報生成--END


/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_BlogClass.php" );
require_once ( SYS_PATH."dbif/basedb_MenuClass.php" );
require_once ( SYS_PATH."dbif/basedb_LeftmenuClass.php" );
require_once ( SYS_PATH."dbif/basedb_AreaClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."dbif/basedb_EnsenClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."configs/param_file.conf" );


/*----------------------------------------------------------
  セッション登録開始
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  エラークラス - インスタンス
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  ＤＢ接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  ログイン情報チェック
----------------------------------------------------------*/
require_once("../login_chk.php");



//echo("#".$_POST["cl_upddate"]."#");
/*----------------------------------------------------------
  エラー用HIDDEN値生成
----------------------------------------------------------*/
$strErrHidden = "";
$strErrHidden .= "<INPUT type=\"hidden\" name=\"err_mode\" value=\"ERR\">\n";
FOREACH( $_POST as $key => $val ){
	
	$arrPostView[$key] = htmlspecialchars( stripslashes( $val ) );
	
	$buffData_err = "";
	$buffData_err = htmlspecialchars( stripslashes( $val ) );
	$strErrHidden .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$buffData_err}\">\n";
}

// 全クライアント情報を取得
$obj_Client = new basedb_ClientClassTblAccess;
$obj_Client->conn = $obj_conn->conn;
$obj_Client->jyoken["cl_deldate"]	= 0;	// cl_deldateの条件指定無し
$obj_Client->sort["cl_id"]		= 2;	// cl_id順

list( $intCnt , $intTotal ) = $obj_Client->basedb_GetClient( 0 , -1 );
if( $intCnt == -1 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= $athComment;
        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "" , $arrOther );
        exit;
}

// クラスに渡す用の配列を作る
$arr_updrec = array();
FOREACH($obj_Client->clientdat as $key => $val ){
	// クライアント情報のフリーワード検索用フィールドを更新
	// フリーワード検索用文字列を生成
	fn_create_freeword($obj_conn->conn , $val["cl_id"] , $cl_yobi1 , $val["cl_jname"] , $val["cl_kname"]);
	
	$arr_updrec[$key]["cl_id"]	= $val["cl_id"];	// クライアントID
	$arr_updrec[$key]["cl_upddate"]	= $val["cl_upddate"];	// 更新日時
	$arr_updrec[$key]["cl_yobi1"]	= $cl_yobi1;		// フリーワード検索用文字列
}
//print_r($arr_updrec);
//exit;

$obj_batch = new basedb_ClientClassTblAccess;
$obj_batch->conn = $obj_conn->conn;
$obj_batch->clientdat[0]["arr_updrec"]	= $arr_updrec;

$suc = $obj_batch->basedb_UpdClient_freeword_batch();
switch( $suc ){
	case "-1":
		$arrErr["ath_comment"] = $strErrHidden;
		$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "" , $arrErr );
		exit;
	case "1":
		$arrErr["ath_comment"] = $strErrHidden;
		$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "" , $arrErr );
		exit;
}

$message = "正常に更新しました。";

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  ＨＴＭＬ生成
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>塾ブログ - アカウント管理ツール - フリーワード検索用文字列登録バッチ処理</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/client.css" type="text/css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <input type="hidden" name="stpos" value="1">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
            <br /><br /><br /><br /><br />
            <font size="3" color="#FF6600"><?=$message?></font>
            <br /><br /><br />
          </td>
        </tr>
      </table>
      <form name="form1" action="client_main.php" method="POST"> 
        <INPUT type="hidden" name="stpos" value="<?=$arrPostView['stpos']?>" />
        <INPUT type="hidden" name="sea_cl_name_like" value="<?=$arrPostView['sea_cl_name_like']?>" />
        <INPUT type="hidden" name="sea_cl_pref" value="<?=$arrPostView['sea_cl_pref']?>" />
        <INPUT type="hidden" name="sea_cl_stat" value="<?=$arrPostView['sea_cl_stat']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_y" value="<?=$arrPostView['sea_cl_limit_date_s_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_m" value="<?=$arrPostView['sea_cl_limit_date_s_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_d" value="<?=$arrPostView['sea_cl_limit_date_s_d']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_y" value="<?=$arrPostView['sea_cl_limit_date_e_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_m" value="<?=$arrPostView['sea_cl_limit_date_e_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_d" value="<?=$arrPostView['sea_cl_limit_date_e_d']?>" />
	<INPUT type="hidden" name="search_flg" value="<?=$arrPostView['search_flg']?>" />
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </body>
</html>
