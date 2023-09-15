<?
/******************************************************************************
	<< 不動産ブログ Ver.1.0.0 >>
	Name: img_list.php
	Version: 1.0.0
	Function: イメージBOX
	Author: Click inc
	Date of creation: 2010/05
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

// 最大登録可能件数□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□
define(_LIMIT , 500);

$syserr_msg = "img_list.phpでシステムエラーが発生しました。管理者に連絡して下さい！";
$syserr_msg1 = "ログイン情報がありません。";
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_sql_class.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_image_extension.conf" );

/*----------------------------------------------------------
  セッション登録開始
----------------------------------------------------------*/
session_start();
/*----------------------------------------------------------
        エラークラス - インスタンス
----------------------------------------------------------*/
$obj_error = new DispErrMessage();
/*----------------------------------------------------------
  DB接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );
/*----------------------------------------------------------
  ログイン情報チェック
----------------------------------------------------------*/
require_once("../login_chk.php");
/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
// 画像ディレクトリ作成
define(_IMG_DIR, $param_img_list_path . $_SESSION["_cl_id"] . "/");
define(_IMG_DIR_ADMIN, $param_img_list_path_admin . $_SESSION["_cl_id"] . "/");
if ( !is_dir(_IMG_DIR_ADMIN)  ) {
	mkdir(_IMG_DIR_ADMIN);
	chmod(_IMG_DIR_ADMIN, 0777);
}


/*--------------------------------------------------------
	POST値を格納するhiddenを作成
--------------------------------------------------------*/
$athComment = "";
FOREACH( $_POST as $key => $val ){
	$val = stripslashes(htmlspecialchars($val));
	$athComment .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
	
	if (
		$key == "search_title"
		or $key == "search_sort"
	) {
		$search_hidden .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
	}
}

// 多重投稿防止
$ttoken = $_POST['tt'];
$sesToken = $_SESSION['tt'];

if( $_POST["mode"] == "ins" ){
	// 画像追加□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□
	
	// キーが一致したら更新可
	if($ttoken === $sesToken){
		unset( $_SESSION['tt'] );

		$strErrorComment = "ファイルが不正です。<br />UPしたファイルを確認して下さい。";
		IF( is_uploaded_file( $_FILES['img_name']['tmp_name'] ) ){
		
			// ファイルサイズ 2Mまで
			if( filesize($_FILES['img_name']['tmp_name']) > (1024*1024*2) ) {
				// 画像が不正
				$arrOther["ath_comment"] .= $athComment;
				$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "img_list.php" , $arrOther );
				exit;
			}
			
			$image_ret = @getimagesize( $_FILES['img_name']['tmp_name'] );
			// gif or jpg は画像と判断
			if ( $image_ret[2] == IMAGETYPE_GIF or $image_ret[2] == IMAGETYPE_JPEG ) {
				// 拡張子
				$ext = $param_image_extension[ $image_ret[2] ];
			} else {
				//それ以外は元ファイル名から拡張子を取得
				$ext = end(explode('.', $_FILES['img_name']['name']));
			}
			
			// insert
			$obj_ins = new basedb_sql_class;
			$obj_ins->set_conn ( $obj_conn->conn );
			$obj_ins->set_table ( "base_t_img_list" );
			$obj_ins->set_serial ( "img_id" );
			$arr_data = array();
			$arr_data["img_cl_id"]		= $_SESSION["_cl_id"];
			$arr_data["img_title"]		= $_POST["img_title"];
			$arr_data["img_url"]		= $_POST["img_url"];
			$arr_data["img_link_type"]	= $_POST["img_link_type"];
//			$arr_data["img_org_name"]	= basename( $_FILES['img_name']['name']); // basename php5ではマルチバイトが来た時にバグがある php6で解消予定 2013/05/01 Wed 大塚 2013/05/09 移植 高木
			$arr_data["img_org_name"]	= end(split('/', $_FILES['img_name']['name']));

			$arr_data["img_ins_date"]	= "now";
			$arr_data["img_upd_date"]	= "now";
			$obj_ins->set_data ($arr_data);
//			$obj_ins->set_debug ( true );
			$ret = $obj_ins->db_insert();
			
			// insertした行のid
			$ins_id = $obj_ins->data[$obj_ins->serial];
			
			// idを持ってさらにupdate
			$obj_upd = new basedb_sql_class;
			$obj_upd->set_conn ( $obj_conn->conn );
			$obj_upd->set_table ( "base_t_img_list" );
			$obj_upd->set_tbl_rows ( 1 );
			$arr_data = array();
			$arr_data["img_id"] = $ins_id;
			$obj_upd->set_tbl_key ( $arr_data );

			// ファイル名
			$files_name = $ins_id.'.'.$ext;
			// 元画像ファイル名
			//$files_name_org =  $_FILES['img_name']["name"];
			
			$arr_data = array();
//			$arr_data["img_name"]		= pg_escape_string( $files_name );
			$arr_data["img_name"]		= $files_name;
			$arr_data["img_ext"]		= $ext;
			$arr_data["img_upd_date"]	= "now";
			$obj_upd->set_data ( $arr_data );
//			$obj_upd->set_debug ( true );
			$ret = $obj_upd->db_update();

			if( $ret == "0" )
			{
				//処理続行
				if (is_uploaded_file($_FILES['img_name']['tmp_name']) && $files_name )
				{
					// 画像ファイルを保存
					move_uploaded_file($_FILES['img_name']['tmp_name'], _IMG_DIR . $files_name);
					chmod(_IMG_DIR . $files_name, 0777);
				}
			}
		}else{
			//処理中断
		}

		IF( $ret != 0 ){
			// 登録処理中にエラー
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "img_list.php" , $arrOther );
			exit;
		}

	}
}else if ( $_POST["mode"] == "del" ){
	
	// 画像削除□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□■□
	// キーが一致したら更新可
	if($ttoken === $sesToken){
		unset( $_SESSION['tt'] );

		$obj_del = new basedb_sql_class;
		$obj_del->set_conn ( $obj_conn->conn );
		$obj_del->set_table ( "base_t_img_list" );
		$obj_del->set_tbl_rows ( 1 );
		$arr_data = array();
//		$arr_data["img_id"] = pg_escape_string($_POST["del_img_id"]);
		$arr_data["img_id"] = $_POST["del_img_id"];
		$obj_del->set_tbl_key ( $arr_data );
//		$obj_del->set_debug ( true );
		$ret = $obj_del->db_delete();

		if( $ret != "0" )
		{
			// 削除処理中にエラー
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "img_list.php" , $arrOther );
			exit;
		}

		// 画像ファイルを削除
		if ( file_exists(_IMG_DIR . $_POST["del_img_name"]) ) {
			unlink(_IMG_DIR . $_POST["del_img_name"]);
		}
	}
}

// 多重投稿防止 ある程度一意な文字列を生成する
$_SESSION['tt'] = uniqid('transactiontoken');

// イメージBOX情報
$obj_img = new basedb_sql_class;
$obj_img->set_conn ( $obj_conn->conn );
$obj_img->set_table ( "base_t_img_list" );
$arr_data = array();
$arr_data["img_cl_id"][0] = "=";
$arr_data["img_cl_id"][1] = $_SESSION["_cl_id"];

if ( isset($_POST["search_title"]) and $_POST["search_title"] != "" ) {
	$arr_data["img_title"][0] = "like";
//	$arr_data["img_title"][1] = pg_escape_string($_POST["search_title"]);
	$arr_data["img_title"][1] = $_POST["search_title"];
	$search_title = htmlspecialchars($_POST["search_title"]);
}

$obj_img->set_jyoken ($arr_data);

$arr_data = array();
if ( isset($_POST["search_sort"]) and $_POST["search_sort"] == 9 ) {
	// search_sort:9 名前順
	$arr_data["img_title"] = "asc";
	$search_sort_checked_9 = "checked";
} else {
	// search_sort:1 登録順
	$arr_data["img_upd_date"] = "desc";
	$search_sort_checked_1 = "checked";
}

$obj_img->set_sort ($arr_data);
//$obj_img->set_debug ( true );

list( $imglistcnt , $imglistTotal ) = $obj_img->db_select( _LIMIT, 0 );

$disp_data = "";
for( $ix = 0; $ix < $imglistcnt; $ix++ ) {
	$img_id			= htmlspecialchars($obj_img->data[$ix]["img_id"]);
	$img_title		= htmlspecialchars($obj_img->data[$ix]["img_title"]);
	$img_url		= htmlspecialchars($obj_img->data[$ix]["img_url"]);
	$img_link_type	= htmlspecialchars($obj_img->data[$ix]["img_link_type"]);
	$img_name		= htmlspecialchars($obj_img->data[$ix]["img_name"]);
	$img_org_name	= htmlspecialchars($obj_img->data[$ix]["img_org_name"]);
	$ext			= htmlspecialchars($obj_img->data[$ix]["img_ext"]);
	
	// httpパス設定
	if($login_val["cl_googlemap_key"]!="" && $login_val["cl_dokuji_flg"]=="1" && $login_val["cl_dokuji_domain"]!=""){
		$http_path = $login_val["cl_dokuji_domain"] . $param_img_list_path_http;
	}else{
		$http_path = $param_base_blog_addr_url . $param_base_blog_addr . $login_val["cl_url_code"] . "/" . $param_img_list_path_http;
	}
	
	//画像の場合の処理
	if($ext == 'gif' || $ext == 'jpg' || false){
		// 画像サイズ取得
		$img_arr = @getimagesize( _IMG_DIR . $obj_img->data[$ix]["img_name"] );
		// 貼り付け用タグを生成
		$img_tag		= '<img src="' . $http_path . $_SESSION["_cl_id"] . "/" . $obj_img->data[$ix]["img_name"]
					. '" alt="' . $obj_img->data[$ix]["img_title"]
					. '" title="' . $obj_img->data[$ix]["img_title"]
					. '" width="' . $img_arr[0]
					. '" height="' . $img_arr[1]
					. '"/>';
		
		// リンク先URLが入力されていた場合、aタグで囲む
		if ( $img_url != "" ) {
			if ( $img_link_type == 1 ) {
				// リンクタイプ 1:self
				$target = '_self';
			} else {
				// リンクタイプ 9:blank
				$target = '_blank';
			}
			$input_val = '<a href="' . $obj_img->data[$ix]["img_url"] . '" target="' . $target . '">' . $img_tag . '</a>';
		} else {
			$input_val = $img_tag;
		}
		$input_val = htmlspecialchars($input_val);
		
		$disp_data .= "        <li class=\"li_img\">\n";
		$disp_data .= "          <a href=\"" . _IMG_DIR . "{$img_name}\" class=\"highslide\" onclick=\"return hs.expand(this)\" onkeypress=\"return hs.expand(this)\" >\n";
		$disp_data .= "            <img src=\"./img_thumbnail.php?w=150&h=150&dir=" . _IMG_DIR . "&nm={$img_name}\" alt=\"{$img_title}\" title=\"{$img_title}\" />\n";
		$disp_data .= "          </a>\n";
		
		// ポップアップ内部
		$disp_data .= "          <div class=\"highslide-caption\">\n";
		$disp_data .= "            <form name=\"img_form_{$ix}\" action=\"img_list.php\" method=\"POST\" >\n";
		$disp_data .= "              {$img_title}<br />\n";
		$disp_data .= "              <input type=\"text\" name=\"tag\" value=\"{$input_val}\" onFocus=\"this.select();\" style=\"width:100%;\" />\n";
		$disp_data .= "              <input type=\"button\" name=\"img_del\" value=\"削除\" onClick=\"fn_del_img(this.form);\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"mode\" value=\"del\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"del_img_id\" value=\"{$img_id}\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"del_img_name\" value=\"{$img_name}\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"tt\" value=\"{$_SESSION['tt']}\" />\n";
		$disp_data .= $search_hidden;
		$disp_data .= "            </form>\n";
		
		$disp_data .= "          </div>\n";
		
		$disp_data .= "        </li>\n";
		
	//それ以外の場合の処理
	}else{
		
		// 貼り付け用タグを生成
		// aタグで囲む
		if ( $img_link_type == 1 ) {
			// リンクタイプ 1:self
			$target = '_self';
		} else {
			// リンクタイプ 9:blank
			$target = '_blank';
		}
		$input_val = '<a href="' . $http_path . $_SESSION["_cl_id"] . '/' . $img_name . '" target="' . $target . '">' . $img_title . '</a>';
		$input_val = htmlspecialchars($input_val);
		
		$disp_data .= "        <li class=\"li_img\">\n";
		$disp_data .= "          <a href=\"./file_img.gif\" class=\"highslide\" onclick=\"return hs.expand(this)\" onkeypress=\"return hs.expand(this)\" >\n";
		$disp_data .= "            <img src=\"./img_thumbnail.php?w=150&h=150&dir=./&nm=file_img.gif\" alt=\"{$img_title}\" title=\"{$img_title}\" />\n";
		$disp_data .= "          </a>\n";
		
		// ポップアップ内部
		$disp_data .= "          <div class=\"highslide-caption\">\n";
		$disp_data .= "            <form name=\"img_form_{$ix}\" action=\"img_list.php\" method=\"POST\" >\n";
		$disp_data .= "              {$img_title}<br />\n";
		$disp_data .= "              <input type=\"text\" name=\"tag\" value=\"{$input_val}\" onFocus=\"this.select();\" style=\"width:100%;\" />\n";
		$disp_data .= "              <input type=\"button\" name=\"img_del\" value=\"削除\" onClick=\"fn_del_img(this.form);\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"mode\" value=\"del\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"del_img_id\" value=\"{$img_id}\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"del_img_name\" value=\"{$img_name}\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"tt\" value=\"{$_SESSION['tt']}\" />\n";
		$disp_data .= $search_hidden;
		$disp_data .= "            </form>\n";
		
		$disp_data .= "          </div>\n";
		
		$disp_data .= "        </li>\n";
		
	}
}
if ( $imglistcnt <= 0 ) {
	$disp_data .= "        <li>ファイルの登録がありません。</li>\n";
}

// 件数制限の為にもう一回取得
$obj_total_img = new basedb_sql_class;
$obj_total_img->set_conn ( $obj_conn->conn );
$obj_total_img->set_table ( "base_t_img_list" );
$arr_data = array();
$arr_data["img_cl_id"][0] = "=";
$arr_data["img_cl_id"][1] = $_SESSION["_cl_id"];
$obj_total_img->set_jyoken ($arr_data);

//$obj_total_img->set_debug ( true );

list( $allcnt , $allcnt_total ) = $obj_total_img->db_select( _LIMIT, 0 );

if ( $allcnt >= _LIMIT ) {
	// 最大件数に達してるよ警告
	$js_str = "return fn_limit_alert();";
} else {
	// 登録チェック
	$js_str = "return fn_check(this.form);";
}


/*----------------------------------------------------------
  DB切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );
/*--------------------------------------------------------
	HTML生成
--------------------------------------------------------*/
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <title>不動産ブログ - クライアント管理ツール</title>
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <link rel="stylesheet" type="text/css" href="../share/css/img_list.css" />
    <script type="text/javascript" src="../share/js/input_check.js"></script>
    <script type="text/javascript" src="../share/js/img_list.js"></script>
    <link rel="stylesheet" type="text/css" href="../share/highslide/highslide.css" />
    <script type="text/javascript" src="../share/highslide/highslide.js"></script>
    <script type="text/javascript" src="../share/highslide/highslide_config.js"></script>
    <noscript><meta http-equiv="Refresh" content="1;URL=../jserror.html"></noscript>
 </head>
  <body>
<div style="text-align:right">
<?=$Msg?>
</div>
    <span class="title">ファイルBOX</span>
    <p>ファイルをアップロードすると、画像（gif または jpg）の場合&lt;img&gt;タグ、それ以外の場合は、&lt;a&gt;タグが発行されます。</p>
    <p>発行されたタグはhtml自由表記部分等に使用することが出来ます。</p>
    <p>画像の場合、リンク先URLを入力すると、&lt;a&gt;タグ付きで発行されます。</p>
    <hr color="#96BC69" />
    <span class="sub_title">登録</span> <span class="alert"><?=$allcnt?> / <?php print _LIMIT; ?> 件</span>
    <table id="table_ins">
      <form name="ins_form" action="img_list.php" method="POST" enctype="multipart/form-data">
      <tr>
        <td class="td_title">ファイルタイトル</td>
        <td class="td_val01"><input type="text" name="img_title" value="" maxlength="50" style="width:200px;" /></td>
        <td class="td_title">ファイル</td>
        <td class="td_val02"><input type="file" name="img_name"></td>
        <td class="td_val03" align="center" rowspan="2">
          <input type="submit" value="登録" onclick="<?=$js_str?>" class="btn" />
        </td>
      </tr>
      <tr>
        <td class="td_title">リンク先URL<br /><span style="font-size:smaller">（画像のみ有効）</span></td>
        <td class="td_val01"><input type="text" name="img_url" value="" maxlength="500" style="width:200px;" /></td>
        <td class="td_title">リンクタイプ</td>
        <td class="td_val02">
          <input type="radio" name="img_link_type" id="img_link_type_1" value="1" checked /><label for="img_link_type_1">同じウインドウで開く</label>
          <br /><input type="radio" name="img_link_type" id="img_link_type_9" value="9" /><label for="img_link_type_9">別のウインドウで開く</label>
        </td>
      </tr>
      <input type="hidden" name="mode" value="ins" />
      <input type="hidden" name="tt" value="<?=$_SESSION['tt']?>" />
<?=$search_hidden?>
      </form>
    </table>
    
    <hr color="#96BC69" />

    <span class="sub_title">検索</span>
    <table id="table_search">
      <tr>
        <form name="serach_form" action="img_list.php" method="POST" enctype="multipart/form-data">
          <td class="td_title">タイトル</td>
          <td class="td_search01">
            <input type="text" name="search_title" maxlength="50" style="width:200px;" value="<?=$search_title?>" />
          </td>
          <td class="td_title">表示順</td>
          <td class="td_search02">
            <input type="radio" name="search_sort" value="1" id="search_sort_1" <?=$search_sort_checked_1?> /><label for="search_sort_1">▽登録順</label>
            <br /><input type="radio" name="search_sort" value="9" id="search_sort_9" <?=$search_sort_checked_9?> /><label for="search_sort_9">△名前順</label>
          </td>
          <td class="td_search03" align="center" >
            <input type="submit" value="検索" class="btn" id="search_btn" style="display:inline;" />
            <br /><input type="button" value="解除" onclick="location.href='img_list.php'" class="btn" id="search_btn" />
          </td>
        </form>
      </tr>
    </table>
    <hr color="#96BC69" />

    <ul>
<?=$disp_data?>
    </ul>


    <hr color="#96BC69" />
<br />
  </body>
</html>



