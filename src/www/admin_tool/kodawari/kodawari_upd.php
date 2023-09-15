<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: kodawari_upd.php
	Version: 1.0.0
	Function: こだわり用アドレス生成機能 アドレス発行画面
	Author: Click inc
	Date of creation: 2007/06
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
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_build.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_search.conf" );


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


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
// 飛び先ページ判定
if( $_POST['mode'] == "result" ){
	$modeVal = "psearch-result/page-1.html";
}else if( $_POST['mode'] == "search" ){
	$modeVal = "psearch-pref/";
	$addVal = "?fa=".$_POST['fa'];
}else{
	$obj_error->ViewErrMessage( "SYSTEM" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}


$hddnVal .= "<input type=\"hidden\" name=\"mode\" value=\"{$_POST["mode"]}\">\n";
$hddnVal .= "<input type=\"hidden\" name=\"area_list\" value=\"{$_POST["area_list"]}\">\n";
$hddnVal .= "<input type=\"hidden\" name=\"line_list\" value=\"{$_POST["line_list"]}\">\n";
$hddnVal .= "<input type=\"hidden\" name=\"sta_list\" value=\"{$_POST["sta_list"]}\">\n";
$hddnVal .= "<input type=\"hidden\" name=\"fa\" value=\"{$_POST["fa"]}\">\n";

$hddnVal .= "<input type=\"hidden\" name=\"line_cd\" value=\"{$_POST["line_cd"]}\">\n";
$line_cd = split( "<>" , $_POST["line_cd"] );
IF( count($line_cd) != 0 ){
	FOREACH( $line_cd as $key => $val ){	
		$arrBuffLn = Array();
		$arrBuffLn = split( "/" , $val );
		$_GET['ln'][] = $arrBuffLn[1];
		if( $addVal == "" && $val != "" ){
			$addVal = "?ln[]=".urlencode($val);
		}else if( $addVal != "" && $val != "" ){
			$addVal .= "&ln[]=".urlencode($val);
		}
	}
}

$hddnVal .= "<input type=\"hidden\" name=\"sta_cd\" value=\"{$_POST["sta_cd"]}\">\n";
$sta_cd = split( "<>" , $_POST["sta_cd"] );
IF( count( $sta_cd ) != 0 ){
	FOREACH( $sta_cd as $key => $val ){
		if( $addVal == "" && $val != "" ){
			$addVal = "?st[]=".urlencode($val);
		}else if( $addVal != "" && $val != "" ){
			$addVal .= "&st[]=".urlencode($val);
		}
	}
}

$hddnVal .= "<input type=\"hidden\" name=\"area_cd\" value=\"{$_POST["area_cd"]}\">\n";
$area_cd = split( "<>" , $_POST["area_cd"] );
IF( count( $area_cd ) != 0 ){
	FOREACH( $area_cd as $key => $val ){
		if( $addVal == "" && $val != "" ){
			$addVal = "?pf[]=".urlencode($val);
		}else if( $addVal != "" && $val != "" ){
			$addVal .= "&pf[]=".urlencode($val);
		}
	}
}

IF( count( $_POST['ar'] ) != 0 ){
	FOREACH( $_POST['ar'] as $key => $val ){
		$hddnVal .= "<input type=\"hidden\" name=\"ar[]\" value=\"{$val}\">\n";
	}
}


IF( count( $_POST['search_equip'] ) != 0 ){
	FOREACH( $_POST['search_equip'] as $key => $val ){
		$hddnVal .= "<input type=\"hidden\" name=\"search_equip[{$key}]\" value=\"{$val}\">\n";
		if( $addVal == "" && $val != "" && $val != null ){
			$addVal = "?search_equip[{$key}]=/".$val."/";
		}else if($addVal != "" && $val != "" && $val != null){
			$addVal .= "&search_equip[{$key}]=/".$val."/";
		}
	}
}



foreach($_POST as $key => $val){
	if(is_array($val)){
		foreach($val as $key2 => $val2){
			if($key != "mode" && $key != "area_list" && $key != "area_cd" && $key != "line_list" && $key != "line_cd" && $key != "sta_list" && $key != "sta_cd" && $key != "search_equip" && $key != "fa"){
				if( $addVal == "" && $val2 != "" && $val2 != null && $val2 != 0 ){
					$addVal = "?".$key."[]=".$val2;
					$hddnVal .= "<input type=\"hidden\" name=\"{$key}[]\" value=\"{$val2}\">\n";
				}else if($val2 != "" && $val2 != null && $val2 != 0 ){
					$addVal .= "&".$key."[]=".$val2;
					$hddnVal .= "<input type=\"hidden\" name=\"{$key}[]\" value=\"{$val2}\">\n";
				}
			}
		}
	}else{
		if($key != "mode" && $key != "area_list" && $key != "area_cd" && $key != "line_list" && $key != "line_cd" && $key != "sta_list" && $key != "sta_cd" && $key != "search_equip" && $key != "fa"){
			if( $addVal == "" && $val != "" && $val != null && $val != 0 ){
				$addVal = "?".$key."=".$val;
				$hddnVal .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
			}else if($val != "" && $val != null && $val != 0 ){
				$addVal .= "&".$key."=".$val;
				$hddnVal .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
			}
		}
	}
}

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
	表示リスト項目作成
--------------------------------------------------------*/


/*=================================================
    ＨＴＭＬ表示
=================================================*/
?>
<HTML>
  <HEAD>
    <TITLE>不動産ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/kodawari.css" />
    <SCRIPT type="text/javascript" src="../share/js/client.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <table id="client" cellspacing="0">
        <tr>
          <td id="zip">
          </td>
        </tr>
        <tr>
          <td id="zip">
	    <center><textarea rows="10" cols="80" readonly><?=_BLOG_SITE_URL_BASE?><?=$modeVal?><?=$addVal?></textarea></center>
          </td>
        </tr>
      </table>
      <table id="zip">
        <tr>
          <form action="<?=_BLOG_SITE_URL_BASE?><?=$modeVal?><?=$addVal?>" method="POST" target="_blank">
            <td id="zip">
              <center><input class="btn" type="submit" value="リンク先表示"></center>
            </td>
          </form>
          <form action="kodawari_mnt.php" method="POST" >
            <td id="zip">
              <center><input class="btn" type="submit" value="戻る"></center>
<?=$hddnVal?>
            </td>
          </form>
        </tr>
      </table>
    </DIV>
  </body>
</HTML>
