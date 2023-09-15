<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: station_select.php
	Version: 1.0.0
	Function: 最寄沿線・駅設定画面
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectMstClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/mstdb_LineClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
require_once ( SYS_PATH."configs/param_base.conf" );


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
require_once( SYS_PATH."common/db_connect_mst.php" );


/*----------------------------------------------------------
  ログイン情報チェック
----------------------------------------------------------*/
require_once("./login_chk.php");


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
IF( $_GET["fg"] >= 0 ){
	// エリア取得
	$obj1 = new mstdb_LineClassTblAccess;
	$obj1->conn = $obj_conn_mst->conn;
	list( $ret1 , $intCnt1 ) = $obj1->mstdb_GetLine( 2 );
	IF( $ret1 == -1 ){
		$obj_error->ViewErrMessage( "ACCESS" , "ALL" , "window.close();" , NULL );
		exit;
	}
}
IF( $_GET["fg"] >= 1 ){
	// 指定エリアの都道府県取得
	$obj2 = new mstdb_LineClassTblAccess;
	$obj2->conn = $obj_conn_mst->conn;
	$obj2->jyoken["line_area_no"] = $_GET["la"];
	list( $ret2 , $intCnt2 ) = $obj2->mstdb_GetLine( 3 );
	IF( $ret2 == -1 ){
		$obj_error->ViewErrMessage( "ACCESS" , "ALL" , "window.close();" , NULL );
		exit;
	}
}
IF( $_GET["fg"] >= 2 ){
	// 指定都道府県の沿線を取得
	$obj3 = new mstdb_LineClassTblAccess;
	$obj3->conn = $obj_conn_mst->conn;
	$obj3->jyoken["line_area_no"] = $_GET["la"];
	$obj3->jyoken["line_pref_cd"] = $_GET["lp"];
	list( $ret3 , $intCnt3 ) = $obj3->mstdb_GetLine( 4 );
	IF( $ret3 == -1 ){
		$obj_error->ViewErrMessage( "ACCESS" , "ALL" , "window.close();" , NULL );
		exit;
	}
}
IF( $_GET["fg"] >= 3 ){
	$obj4 = new mstdb_LineClassTblAccess;
	$obj4->conn = $obj_conn_mst->conn;
	$obj4->jyoken["line_cd"] = $_GET["lc"];
	$obj4->sort["line_sta_name"] = 1;
	list( $ret4 , $intCnt4 ) = $obj4->mstdb_GetLine( 1 );
	IF( $ret4 == -1 ){
		$obj_error->ViewErrMessage( "ACCESS" , "ALL" , "window.close();" , NULL );
		exit;
	}
}


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close_mst.php" );
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
  一覧表示内容生成
--------------------------------------------------------*/
$fname = $_GET["fn"];
$line = $_GET["line"];
$station = $_GET["station"];
$ln_cd = $_GET["ln_cd"];
$ln_cd_name = $_GET["ln_cd_name"];
$st_cd = $_GET["st_cd"];

$viewArea = "";
FOR( $iX=0; $iX<$intCnt1; $iX++ ){
	$strSel = "";
	IF( $_GET["la"] == $obj1->linedat[$iX]["line_area_no"] ) $strSel = " selected";
	$viewArea .= "            <OPTION value=\"{$obj1->linedat[$iX]["line_area_no"]}\"{$strSel}>{$obj1->linedat[$iX]["line_area_name"]}</OPTION>\n";
}


$viewPref = "";
FOR( $iX=0; $iX<$intCnt2; $iX++ ){
	$strSel = "";
	IF( $_GET["lp"] == $obj2->linedat[$iX]["line_pref_cd"] ){
		$strSel = " selected";
		$strHiddenPrefCode = $obj2->linedat[$iX]["line_pref_cd"];
	}
	$viewPref .= "            <OPTION value=\"{$obj2->linedat[$iX]["line_pref_cd"]}\"{$strSel}>{$obj2->linedat[$iX]["line_pref_name"]}</OPTION>\n";
}


$strHiddenLineName = "";
$viewLine = "";
FOR( $iX=0; $iX<$intCnt3; $iX++ ){
	$strSel = "";
	IF( $_GET["lc"] == $obj3->linedat[$iX]["line_cd"] ){
		$strSel = " selected";
		$strHiddenLineName = $obj3->linedat[$iX]["line_name"];
		$strHiddenLineCode = $obj3->linedat[$iX]["line_cd"];
	}
	$viewLine .= "            <OPTION value=\"{$obj3->linedat[$iX]["line_cd"]}\"{$strSel}>{$obj3->linedat[$iX]["line_name"]}</OPTION>\n";
}


$strHiddenLineStaCd = "";
$strHiddenLineStaName = "";
$viewStation = "";
FOR( $iX=0; $iX<$intCnt4; $iX++ ){
	$strSel = "";
	IF( $_GET["lsc"] == $obj4->linedat[$iX]["line_sta_cd"] ){
		$strSel = " selected";
		$strHiddenLineStaCd = $obj4->linedat[$iX]["line_sta_cd"];
		$strHiddenLineStaName = $obj4->linedat[$iX]["line_sta_name"];
	}
	$viewStation .= "            <OPTION value=\"{$obj4->linedat[$iX]["line_sta_cd"]}\"{$strSel}>{$obj4->linedat[$iX]["line_sta_name"]}</OPTION>\n";
}


$strHiddenLine = "";
$strHiddenLineCdName = "";
$viewStaLine = "";
FOR( $iX=0; $iX<$intCnt5; $iX++ ){
	$viewStaLine .= "・{$obj5->linedat[$iX]["line_name"]}<br />\n";
	IF( $strHiddenLine == "" ) $strHiddenLine .= "/";
	$strHiddenLine .= $obj5->linedat[$iX]["line_cd"]."/";
	IF( $strHiddenLineCdName == "" ) $strHiddenLineCdName .= "/";
	$strHiddenLineCdName .= $obj5->linedat[$iX]["line_name"]."/";
}



/*--------------------------------------------------------
	ＨＴＭＬ生成
--------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>不動産ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="./share/css/line.css" />
    <SCRIPT type="text/javascript" src="./share/js/line.js"></SCRIPT>
    <SCRIPT language="javascript">
    	<!--
    	function SetSelectData( parts )
    	{
		if(parts.l_name.value == "" ){
			alert("沿線を設定してください。");
			return false;
		}
	
    		window.opener.document.<?=$fname?>.<?=$line?>.value += '・' + parts.l_name.value + '\n';
		if(window.opener.document.<?=$fname?>.<?=$ln_cd?>.value != "" && window.opener.document.<?=$fname?>.<?=$ln_cd?>.value != null ){
			window.opener.document.<?=$fname?>.<?=$ln_cd?>.value += '<>'
		}
    		window.opener.document.<?=$fname?>.<?=$ln_cd?>.value += parts.l_name.value + '/' + parts.l_cd.value + '/' + parts.p_cd.value;
    		
    		window.close();
    		
    	}
	function DelSelectData( parts )
	{
    		
    		window.opener.document.<?=$fname?>.<?=$line?>.value = "";
    		window.opener.document.<?=$fname?>.<?=$ln_cd?>.value = "";
    		window.opener.document.<?=$fname?>.<?=$ln_cd_name?>.value = "";
    		
    		window.close();
    		
	}
    	//-->
    </SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <DIV id="line">
    <TABLE>
      <FORM name="go_upd" method="POST" action="" target="_self">
      <TR>
        <TH align="left">　1. エリアを選択</TH>
      </TR>
      <TR>
        <TD>
          <SELECT name="line_area" onChange="PageReload( this.form , 1 );">
            <OPTION value="">----</OPTION>
<?=$viewArea?>
          </SELECT>
        </TD>
      </TR>
      <TR>
        <TH align="left">　2. 都道府県を選択</TH>
      </TR>
      <TR>
        <TD>
          <SELECT name="line_pref" onChange="PageReload( this.form , 2 );">
            <OPTION value="">----</OPTION>
<?=$viewPref?>
          </SELECT>
        </TD>
      </TR>
      <TR>
        <TH align="left">　3. 沿線を選択</TH>
      </TR>
      <TR>
        <TD>
          <SELECT name="line_name" onChange="PageReload( this.form , 3 );">
            <OPTION value="">----</OPTION>
<?=$viewLine?>
          </SELECT>
        </TD>
      </TR>
      <TR>
        <TD>
          <INPUT type="button" value="追加する" style="width:150px" class="btn" onClick="return SetSelectData( this.form )" />
          　<INPUT TYPE="button" VALUE="閉じる" class="btn" onClick="window.close();" />
          <br />
          <INPUT type="hidden" name="p_cd" value="<?=$strHiddenPrefCode?>" />
          <INPUT type="hidden" name="l_cd" value="<?=$strHiddenLineCode?>" />
          <INPUT type="hidden" name="l_cd_name" value="<?=$strHiddenLineCdName?>" />
          <INPUT type="hidden" name="ls_cd" value="<?=$strHiddenLineStaCd?>" />
          <INPUT type="hidden" name="l_name" value="<?=$strHiddenLineName?>" />
          <INPUT type="hidden" name="ls_name" value="<?=$strHiddenLineStaName?>" />
          <INPUT type="hidden" name="fname" value="<?=$fname?>" />
          <INPUT type="hidden" name="line" value="<?=$line?>" />
          <INPUT type="hidden" name="station" value="<?=$station?>" />
          <INPUT type="hidden" name="ln_cd" value="<?=$ln_cd?>" />
          <INPUT type="hidden" name="ln_cd_name" value="<?=$ln_cd_name?>" />
          <INPUT type="hidden" name="st_cd" value="<?=$st_cd?>" />
        </TD>
      </TR>
      </FORM>
    </TABLE>
    </DIV>
  </BODY>
</HTML>
