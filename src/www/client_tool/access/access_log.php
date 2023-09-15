<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
        Name: access_log.php
        Version: 1.0.0
        Function: アクセス解析一覧
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
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_log.conf" );


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
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  処理部分
----------------------------------------------------------*/
IF( $_POST["sea_date_y"] != "" ){
	
	// 日付指定あり
	$intBuffYear = $_POST["sea_date_y"];
	$intBuffMonth = $_POST["sea_date_m"];
	$intBuffDay = $_POST["sea_date_d"];
	
	// 解析部分を見せるかどうか
	$flgViewCheck = "inline";
	
	// ファイル名作成
	$buffNameDate = $intBuffYear.$intBuffMonth.$intBuffDay;
	$buffLogFileName = $buffNameDate."_".$_SESSION["_cl_id"]."_log.txt";
	$buffLogFileAll = $param_log_dir.$_SESSION["_cl_id"]."/".$buffLogFileName;
	
	// ファイル存在チェック
	IF( file_exists( $buffLogFileAll ) === TRUE ){
		
		// ファイル読み込み
		$fp_log = fopen( $buffLogFileAll , "r" );
		IF( !$fp_log ){
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "access_log.php" , $arrOther );
			exit;
		}
		
		// ファイル内容解析
		$arrViewAddr = Array();
		$arrViewCount = Array();
		FOR( $iX=1; !feof($fp_log); $iX++ ){
			// 変数初期化
			$strLine = "";
			$arrLine = Array();
			// 変数に値挿入
			$strLine = fgets( $fp_log );
			$arrLine = explode( "\t" , $strLine );
			//
			// arrLine[0] ... 時
			// arrLine[1] ... 分
			// arrLine[2] ... IPアドレス
			// arrLine[3] ... 表示ページ
			// arrLine[4] ... ブラウザ情報
			// arrLine[5] ... 経路元アドレス
			// arrLine[6] ... 検索キーワード
			//
			IF( $arrLine[3] != "" ){
				IF( array_search( $arrLine[3] , $arrViewAddr ) === FALSE ){
					// まだ無いので配列に入れる
					$arrViewAddr[] = $arrLine[3];
					$arrViewCount[] = 1;
				}ELSE{
					// すでに配列にあるので既存データの件数を増やす
					$buffMatch = array_search( $arrLine[3] , $arrViewAddr );
					$arrViewCount[$buffMatch]++;
				}
			}
		}
		
		// 表示内容生成
		$strViewData = "";
		$intCntData = count( $arrViewCount );
		arsort( $arrViewCount );
		$intBuffMaxCnt = 0;
		FOREACH( $arrViewCount as $key => $val ){
			
			// 割合画像幅設定
			$buffImgWidth = 0;
			IF( $intBuffMaxCnt == 0 ){
				$buffImgWidth = 100;
				$intBuffMaxCnt = $val;
			}ELSE{
				$buffImgWidth = intval( ( $val / $intBuffMaxCnt ) * 100 );
			}
			
			// 表示タグ生成
			$strViewData .= "<TR>\n";
			$strViewData .= "  <FORM name=\"form1\" method=\"POST\" action=\"access_referer.php\" target=\"_self\">\n";
                        $strViewData .= "  <TD><A href=\"{$arrViewAddr[$key]}\" target=\"_blank\">{$arrViewAddr[$key]}</A></TD>\n";
                        $strViewData .= "  <TD><IMG src=\"../share/images/access_log_bar.gif\" border=\"0\" width=\"{$buffImgWidth}\" height=\"15\" />&nbsp;({$arrViewCount[$key]})</TD>\n";
                        $strViewData .= "  <TD><INPUT type=\"submit\" value=\"経路元\" class=\"btn_nosize\" /></TD>\n";
                        $strViewData .= "  <INPUT type=\"hidden\" name=\"referer\" value=\"{$arrViewAddr[$key]}\" />\n";
                        $strViewData .= "  <INPUT type=\"hidden\" name=\"sea_date_y\" value=\"{$_POST["sea_date_y"]}\" />\n";
                        $strViewData .= "  <INPUT type=\"hidden\" name=\"sea_date_m\" value=\"{$_POST["sea_date_m"]}\" />\n";
                        $strViewData .= "  <INPUT type=\"hidden\" name=\"sea_date_d\" value=\"{$_POST["sea_date_d"]}\" />\n";
                        $strViewData .= "  </FORM>\n";
                        $strViewData .= "</TR>\n";
		}
		
	}ELSE{
		$strViewData = "";
		$strViewData .= "<TR>\n";
		$strViewData .= "  <TD colspan=\"3\">この日のログはありません。</TD>\n";
		$strViewData .= "</TR>\n";
	}
	
}ELSE{
	$flgViewCheck = "none";
}


// ログ日付(年)
$intStartYear = 2007;
$intEndYear = date("Y");
$viewSeaDate_y = "";
FOR( $iX=$intStartYear; $iX<=$intEndYear; $iX++ ){
	$strSel = "";
	IF( $intBuffYear == $iX ) $strSel = " selected";
	$viewSeaDate_y .= "<OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// ログ日付(月)
$viewSeaDate_m = "";
FOR( $iX=1; $iX<=12; $iX++ ){
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $intBuffMonth == $buffInt ) $strSel = " selected";
	$viewSeaDate_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$iX}</OPTION>\n";
}

// ログ日付(日)
$viewSeaDate_d = "";
FOR( $iX=1; $iX<=31; $iX++ ){
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $intBuffDay == $buffInt ) $strSel = " selected";
	$viewSeaDate_d .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$iX}</OPTION>\n";
}




/*----------------------------------------------------------
  ＨＴＭＬ生成
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>不動産ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/access_log.css" />
    <SCRIPT type="text/javascript" src="../share/js/access_log.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/access_title.gif" alt="アクセス解析" />
    <HR color="#96BC69" />
      <TABLE id="access_log">
        <TR>
          <FORM name="sea_date" method="POST" action="access_log.php" target="_self">
          <TH class="must">解析日付</TH>
          <TD>
            <SELECT name="sea_date_y">
              <OPTION value="">----</OPTION>
<?=$viewSeaDate_y?>
            </SELECT>
            年
            <SELECT name="sea_date_m">
              <OPTION value="">--</OPTION>
<?=$viewSeaDate_m?>
            </SELECT>
            月
            <SELECT name="sea_date_d">
              <OPTION value="">--</OPTION>
<?=$viewSeaDate_d?>
            </SELECT>
            日
            <INPUT type="button" value="解析" onClick="return AccessSelCheck( this.form )" class="btn" />
          </TD>
          </FORM>
        </TR>
      </TABLE>
      <BR />
      <DIV id="check_log" style="display: <?=$flgViewCheck?>;">
        <DIV id="title"><?=$intBuffYear?>年<?=$intBuffMonth?>月<?=$intBuffDay?>日　のアクセス解析</DIV>
        <BR />
        <TABLE>
          <TR>
            <TH width="550">閲覧アドレス</TH>
            <TH width="150">割合(件数)</TH>
            <TH width="100"></TH>
          </TR>
<?=$strViewData?>
        </TABLE>
      </DIV>
  </BODY>
</HTML>
