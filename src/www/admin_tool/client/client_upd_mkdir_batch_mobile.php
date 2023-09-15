<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: client_upd.php
	Version: 1.0.0
	Function: クライアント登録／修正／削除登録
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

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


/*----------------------------------------------------------
  クライアント一覧取得
----------------------------------------------------------*/
$obj2 = new basedb_ClientClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["cl_deldate"] = 0;	// del_date条件無し
list( $intCnt , $intTotal ) = $obj2->basedb_GetClient( 1 , -1 );
if( $intCnt == -1 ){
        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , NULL );
        exit;
}

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );

//--------------------------------------------------------------------
// 独自ドメイン用ディレクトリ、htaccess作成
//--------------------------------------------------------------------
$intCount = 0;
FOREACH( $obj2->clientdat as $key => $val ) {
	// cl_urlcdが未設定ならスルー
	if ($val["cl_urlcd"] == "") continue;

	//20091021追加///////////////////////////////////////////////////////////////////////////////////////////
 		//携帯独自ドメイン用ファイルの作成
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 携帯独自ドメイン用ディレクトリ生成
	@mkdir( $param_mobile_dokuji_path.$val["cl_urlcd"] , 0755);

	// 携帯独自ドメイン用.htaccessファイル生成
	$mobile_htaccess_fp = fopen($param_mobile_dokuji_path.$val["cl_urlcd"]."/.htaccess","w");
	if($mobile_htaccess_fp===flase)exit("ファイルオープン失敗");
	flock($mobile_htaccess_fp,LOCK_EX);
	$mobile_htaccess_str = "";
	$mobile_htaccess_str .= "#############################################################\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# php setting - site_data\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "#############################################################\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# base setting\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "php_flag register_globals off\n";
	$mobile_htaccess_str .= "php_flag magic_quotes_gpc on\n";
	$mobile_htaccess_str .= "php_flag display_errors on\n";
	$mobile_htaccess_str .= "php_flag magic_quotes_sybase off\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# mbstring setting\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "php_value mbstring.language Japanese\n";
	$mobile_htaccess_str .= "php_value mbstring.internal_encoding EUC-JP\n";
	$mobile_htaccess_str .= "php_value mbstring.http_input pass\n";
	$mobile_htaccess_str .= "php_flag  mbstring.encoding_translation on\n";
	$mobile_htaccess_str .= "php_value mbstring.substitute_character none\n";
	$mobile_htaccess_str .= "php_value mbstring.detect_order ASCII,EUC-JP,JIS,UTF-8,SJIS\n";
	$mobile_htaccess_str .= "php_value mbstring.func_overload 0\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# session setting\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "php_value session.name \"edyblo_mobile_blog_site_sess\"\n";
	$mobile_htaccess_str .= "php_flag  session.use_only_cookies on\n";
	$mobile_htaccess_str .= "php_value session.cache_limiter \"nocache\"\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "#############################################################\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# basic setting\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "#############################################################\n";
	$mobile_htaccess_str .= "#AuthUserFile /home/jukutown.com/www/.htpasswd\n";
	$mobile_htaccess_str .= "#AuthGroupFile /dev/null\n";
	$mobile_htaccess_str .= "#AuthName \"Slash Area\"\n";
	$mobile_htaccess_str .= "#AuthType Basic\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "#require valid-user\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "#<Files ~ \"^.(htpasswd|htaccess)$\">\n";
	$mobile_htaccess_str .= "#    deny from all\n";
	$mobile_htaccess_str .= "#</Files> \n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "############################################################\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# re-direct\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "###########################################################\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "#redirect permanent /dev/slash/estate/www/slash/ http://219.163.62.35/dev/slash/estate/www/click/ \n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "#############################################################\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# mod_rewrite setting - site_data\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "#############################################################\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "RewriteEngine On\n";
	$mobile_htaccess_str .= "RewriteBase   /\n";
	$mobile_htaccess_str .= "RewriteCond   %{REQUEST_FILENAME} !-f\n";
	$mobile_htaccess_str .= "RewriteCond   %{REQUEST_FILENAME} !-d\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "#####################################################################################################################\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# blog setting\n";
	$mobile_htaccess_str .= "\n";

//	$mobile_htaccess_str .= "# 日記詳細1\n";
//	$mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/([a-z]{1}.*)$                          program/$2?cl={$val["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
//	$mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/$                                      program/blog.php?cl={$val["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
//	$mobile_htaccess_str .= "\n";

	$mobile_htaccess_str .= "# 日記詳細1\n";
	$mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/$                                      program/blog.php?cl={$val["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/img([0-9]+)/([a-z]{1}.*)$              program/$3?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&img=$2 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/img([0-9]+)/$                          program/blog.php?cl={$val["cl_urlcd"]}&dd=1&drid=$1&img=$2 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";

	$mobile_htaccess_str .= "# 日記詳細2\n";
	$mobile_htaccess_str .= "RewriteRule   ^blogd-([0-9]+)/([a-z]{1}.*)$                         program/$2?cl={$val["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^blogd-([0-9]+)/$                                     program/blog_detail.php?cl={$val["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# 日記詳細3(画像)\n";
	$mobile_htaccess_str .= "RewriteRule   ^blog-img([0-9]+)/([a-z]{1}.*)$                       program/$2?cl={$val["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^blog-img([0-9]+)/$                                   program/blog_img.php?cl={$val["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# キャンペーン詳細1\n";
	$mobile_htaccess_str .= "RewriteRule   ^campaign-detail-([0-9]+)/([a-z]{1}.*)$               program/$2?cl={$val["cl_urlcd"]}&dd=1&cpid=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^campaign-detail-([0-9]+)/$                           program/campaigndetail.php?cl={$val["cl_urlcd"]}&dd=1&cpid=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# キャンペーン詳細2\n";
	$mobile_htaccess_str .= "RewriteRule   ^campaign-detaild-([0-9]+)/([a-z]{1}.*)$              program/$2?cl={$val["cl_urlcd"]}&dd=1&caid=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^campaign-detaild-([0-9]+)/$                          program/campaigndetaild.php?cl={$val["cl_urlcd"]}&dd=1&caid=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# 資料請求フォーム\n";
	$mobile_htaccess_str .= "RewriteRule   ^req/([a-z]{1}.*)$                                    program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^req/$                                                program/req.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# 資料請求確認ページ\n";
	$mobile_htaccess_str .= "RewriteRule   ^req-confirm/([a-z]{1}.*)$                            program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^req-confirm/$                                        program/reqconfirm.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# お問い合わせフォーム\n";
	$mobile_htaccess_str .= "RewriteRule   ^inquire/([a-z]{1}.*)$                                program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^inquire/$                                            program/inquire.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# お問い合わせ確認ページ\n";
	$mobile_htaccess_str .= "RewriteRule   ^inq-confirm/([a-z]{1}.*)$                            program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^inq-confirm/$                                        program/inqconfirm.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# 資料請求メール送信ページ\n";
	$mobile_htaccess_str .= "RewriteRule   ^req_finish/([a-z]{1}.*)$                             program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^req_finish/$                                         program/req_finish.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# お問い合わせメール送信ページ\n";
	$mobile_htaccess_str .= "RewriteRule   ^inq_finish/([a-z]{1}.*)$                             program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^inq_finish/$                                         program/inq_finish.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# 資料請求サンキューページ\n";
	$mobile_htaccess_str .= "RewriteRule   ^req_end/([a-z]{1}.*)$                                program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^req_end/$                                            program/req_end.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# お問い合わせサンキューページ\n";
	$mobile_htaccess_str .= "RewriteRule   ^inq_end/([a-z]{1}.*)$                                program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^inq_end/$                                            program/inq_end.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# 教室案内\n";
	$mobile_htaccess_str .= "RewriteRule   ^school/([a-z]{1}.*)$                                 program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^school/$                                             program/school.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# 教室案内(教室詳細1)\n";
	$mobile_htaccess_str .= "RewriteRule   ^school_detail/([a-z]{1}.*)$                          program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^school_detail/$                                      program/school_detail.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";

//	$mobile_htaccess_str .= "# 教室案内(教室詳細2)\n";
//	$mobile_htaccess_str .= "RewriteRule   ^school_detaild/([a-z]{1}.*)$                         program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
//	$mobile_htaccess_str .= "RewriteRule   ^school_detaild/$                                     program/school_detaild.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
//	$mobile_htaccess_str .= "\n";

	$mobile_htaccess_str .= "# 教室案内(教室詳細2)\n";
	$mobile_htaccess_str .= "RewriteRule   ^school_detaild/p([0-9]+)/([a-z]{1}.*)$               program/$2?cl={$val["cl_urlcd"]}&dd=1&get=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^school_detaild/p([0-9]+)/$                           program/school_detaild.php?cl={$val["cl_urlcd"]}&dd=1&get=$1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";

	$mobile_htaccess_str .= "# 教室案内(MAP表示)\n";
	$mobile_htaccess_str .= "RewriteRule   ^school_map/([a-z]{1}.*)$                             program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^school_map/$                                         program/school_map.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# キャンペーン一覧\n";
	$mobile_htaccess_str .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/([a-z]{1}.*)$    program/$3?cl={$val["cl_urlcd"]}&dd=1&page=$1&cpid=$2 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/$                program/campaignlist.php?cl={$val["cl_urlcd"]}&dd=1&page=$1&cpid=$2 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# 日記一覧\n";
	$mobile_htaccess_str .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/([a-z]{1}.*)$      program/$3?cl={$val["cl_urlcd"]}&dd=1&page=$1&drid=$2 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/$                  program/bloglist.php?cl={$val["cl_urlcd"]}&dd=1&page=$1&drid=$2 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# 個人情報保護方針\n";
	$mobile_htaccess_str .= "RewriteRule   ^kojin/([a-z]{1}.*)$                                  program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^kojin/$                                              program/privacy.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# Q&A\n";
	$mobile_htaccess_str .= "RewriteRule   ^qa/([a-z]{1}.*)$                                     program/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^qa/$                                                 program/QA.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";
	$mobile_htaccess_str .= "# index\n";
	$mobile_htaccess_str .= "RewriteRule   ^img_thumbnail.php$                                   program/img_thumbnail.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^cl_img/(.*)$                                         program/cl_img/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^share/(.*)$                                          program/share/$1?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "RewriteRule   ^$                                                    program/index.php?cl={$val["cl_urlcd"]}&dd=1 [QSA,L]\n";
	$mobile_htaccess_str .= "\n";

	fputs($mobile_htaccess_fp,$mobile_htaccess_str);
	flock($mobile_htaccess_fp,LOCK_UN);
	fclose($mobile_htaccess_fp);

	// 携帯独自ドメイン用シンボリックリンク生成
	@symlink( $param_mobile_dokuji_path."source/program" , $param_mobile_dokuji_path.$val["cl_urlcd"]."/program" );

	// 件数カウント
	$intCount++;
}

$message = "独自ドメイン用ディレクトリ、<br>ファイル作成バッチ処理完了！<br>{$intCount}件";

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
    <TITLE>塾ブログ - アカウント管理ツール</title>
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
    </div>
  </body>
</html>
