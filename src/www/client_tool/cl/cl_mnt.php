<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: client_mnt.php
	Version: 1.0.0
	Function: クライアント登録／修正画面
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
require_once ( SYS_PATH."dbif/basedb_AreaClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_kodawari.conf" );


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
if($_POST['error_mode']=="on"){
	foreach($_POST as $key => $val){
		$arrData[$key] = stripslashes($val);
	}

		$strClientId = $arrData["cl_id"];
		$cl_id = intval($_POST["cl_id"]);
		if( $arrData["cl_stat"] == 1 ){
			$stat_1 = " checked";
		}elseif( $arrData["cl_stat"] == 9 ){
			$stat_9 = " checked";
		}
		$cl_loginid = htmlspecialchars( $arrData["cl_loginid"] );
		$cl_passwd = htmlspecialchars( $arrData["cl_passwd"] );
		$cl_logincd = htmlspecialchars( $arrData["cl_logincd"] );
		$cl_passcd = htmlspecialchars( $arrData["cl_passcd"] );
		$cl_urlcd = htmlspecialchars( $arrData["cl_urlcd"] );
		$cl_stat = htmlspecialchars( $arrData["cl_stat"] );
		$cl_pstat = htmlspecialchars( $arrData["cl_pstat"] );
		$cl_start = htmlspecialchars( $arrData["cl_start"] );
		$cl_end = htmlspecialchars( $arrData["cl_end"] );
		$cl_jname = htmlspecialchars( $arrData["cl_jname"] );
		$cl_kname = htmlspecialchars( $arrData["cl_kname"] );
		$cl_agent = htmlspecialchars( $arrData["cl_agent"] );
		$cl_mail = htmlspecialchars( $arrData["cl_mail"] );
		$zipcode = split("-", $arrData["ar_zip"] );
		$ar_zip1 = htmlspecialchars( $zipcode[0] );
		$ar_zip2 = htmlspecialchars( $zipcode[1] );
		$ar_zip = htmlspecialchars( $arrData["ar_zip"] );
		$ar_pref = htmlspecialchars( $arrData["ar_pref"] );
		$ar_prefcd = intval( $arrData["ar_prefcd"] );
		$ar_city = htmlspecialchars( $arrData["ar_city"] );
		$ar_citycd = intval( $arrData["ar_citycd"] );
		$ar_add = htmlspecialchars( $arrData["ar_add"] );
		$ar_estate = htmlspecialchars( $arrData["ar_estate"] );
		$cl_phone = htmlspecialchars( $arrData["cl_phone"] );
		$cl_fax = htmlspecialchars( $arrData["cl_fax"] );
		$cl_biko = htmlspecialchars( $arrData["cl_biko"] );
		$cl_upddate = htmlspecialchars( $arrData["cl_upddate"] );
		$cl_dokuji_flg = htmlspecialchars( $arrData["cl_dokuji_flg"] );
		$cl_googlemap_key = htmlspecialchars( $arrData["cl_googlemap_key"] );
		$cl_dokuji_domain = htmlspecialchars( $arrData["cl_dokuji_domain"] );
		
		$strButtonVal = "修正する";
	
}else{
	$strClientId = $_POST["cl_id"];
	$obj2 = new basedb_ClientClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["cl_id"] = intval( $strClientId );
	$obj2->jyoken["cl_deldate"] = 1;
	list( $num , $total ) = $obj2->basedb_GetClient( 1 , -1 );
	IF( $num != 1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , $arrOther );
		exit;
	}	
		$cl_id = intval($obj2->clientdat[0]["cl_id"]);
		if( $obj2->clientdat[0]["cl_stat"] == 1 ){
			$stat_1 = " checked";
		}elseif( $obj2->clientdat[0]["cl_stat"] == 9 ){
			$stat_9 = " checked";
		}
		$cl_loginid = htmlspecialchars( $obj2->clientdat[0]["cl_loginid"] );
		$cl_passwd = htmlspecialchars( $obj2->clientdat[0]["cl_passwd"] );
		$cl_logincd= htmlspecialchars( sha1($obj2->clientdat[0]["cl_loginid"]) );
		$cl_passcd = htmlspecialchars( sha1($obj2->clientdat[0]["cl_passwd"]) );
		$cl_urlcd = htmlspecialchars( $obj2->clientdat[0]["cl_urlcd"] );
		$cl_stat = htmlspecialchars( $obj2->clientdat[0]["cl_stat"] );
		$cl_pstat = htmlspecialchars( $obj2->clientdat[0]["cl_pstat"] );
		$cl_start = htmlspecialchars( $obj2->clientdat[0]["cl_start"] );
		$cl_end = htmlspecialchars( $obj2->clientdat[0]["cl_end"] );
		$cl_jname = htmlspecialchars( $obj2->clientdat[0]["cl_jname"] );
		$cl_kname = htmlspecialchars( $obj2->clientdat[0]["cl_kname"] );
		$cl_agent = htmlspecialchars( $obj2->clientdat[0]["cl_agent"] );
		$cl_mail = htmlspecialchars( $obj2->clientdat[0]["cl_mail"] );
		$zipcode = split("-", $obj2->clientdat[0]["ar_zip"] );
		$ar_zip1 = htmlspecialchars( $zipcode[0] );
		$ar_zip2 = htmlspecialchars( $zipcode[1] );
		$ar_zip = htmlspecialchars( $obj2->clientdat[0]["ar_zip"] );
		$ar_pref = htmlspecialchars( $obj2->clientdat[0]["ar_pref"] );
		$ar_prefcd = intval( $obj2->clientdat[0]["ar_prefcd"] );
		$ar_city = htmlspecialchars( $obj2->clientdat[0]["ar_city"] );
		$ar_citycd = intval( $obj2->clientdat[0]["ar_citycd"] );
		$ar_add = htmlspecialchars( $obj2->clientdat[0]["ar_add"] );
		$ar_estate = htmlspecialchars( $obj2->clientdat[0]["ar_estate"] );
		$cl_phone = htmlspecialchars( $obj2->clientdat[0]["cl_phone"] );
		$cl_fax = htmlspecialchars( $obj2->clientdat[0]["cl_fax"] );
		$cl_biko = htmlspecialchars( $obj2->clientdat[0]["cl_biko"] );
		$cl_upddate = htmlspecialchars( $obj2->clientdat[0]["cl_upddate"] );
		$cl_dokuji_flg = htmlspecialchars( $obj2->clientdat[0]["cl_dokuji_flg"] );
		$cl_googlemap_key = htmlspecialchars( $obj2->clientdat[0]["cl_googlemap_key"] );
		$cl_dokuji_domain = htmlspecialchars( $obj2->clientdat[0]["cl_dokuji_domain"] );
		
		$strButtonVal = "修正する";
}

	// 指定クライアントIDを検索
	$obj_area = new basedb_AreaClassTblAccess;
	$obj_area->conn = $obj_conn->conn;
	$obj_area->jyoken["ar_clid"] = $_SESSION['_cl_id'];
	$obj_area->jyoken["ar_flg"] = 1;
	list( $areanum , $areatotal ) = $obj_area->basedb_GetArea( 1 , -1 );
	IF( $areanum == -1 ){
echo("b");
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode = split( "-" , $obj_area->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip1"] = $zipcode[0];
	$arrPostView["ar_zip2"] = $zipcode[1];

	// エリア１
	$obj_area1 = new basedb_AreaClassTblAccess;
	$obj_area1->conn = $obj_conn->conn;
	$obj_area1->jyoken["ar_clid"] = $_SESSION['_cl_id'];
	$obj_area1->jyoken["ar_flg"] = 2;
	list( $areanum1 , $areatotal1 ) = $obj_area1->basedb_GetArea( 1 , -1 );
	IF( $areanum1 == -1 ){
echo("c");
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode1 = split( "-" , $obj_area1->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip1_1"] = $zipcode1[0];
	$arrPostView["ar_zip1_2"] = $zipcode1[1];

	// エリア２
	$obj_area2 = new basedb_AreaClassTblAccess;
	$obj_area2->conn = $obj_conn->conn;
	$obj_area2->jyoken["ar_clid"] = $_SESSION['_cl_id'];
	$obj_area2->jyoken["ar_flg"] = 3;
	list( $areanum2 , $areatotal2 ) = $obj_area2->basedb_GetArea( 1 , -1 );
	IF( $areanum2 == -1 ){
echo("d");
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode2 = split( "-" , $obj_area2->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip2_1"] = $zipcode2[0];
	$arrPostView["ar_zip2_2"] = $zipcode2[1];

	// エリア３
	$obj_area3 = new basedb_AreaClassTblAccess;
	$obj_area3->conn = $obj_conn->conn;
	$obj_area3->jyoken["ar_clid"] = $_SESSION['_cl_id'];
	$obj_area3->jyoken["ar_flg"] = 4;
	list( $areanum3 , $areatotal3 ) = $obj_area3->basedb_GetArea( 1 , -1 );
	IF( $areanum3 == -1 ){
echo("e");
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode3 = split( "-" , $obj_area3->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip3_1"] = $zipcode3[0];
	$arrPostView["ar_zip3_2"] = $zipcode3[1];


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
	表示リスト項目作成
--------------------------------------------------------*/
// 県名
$intCntPsel = count( $psel );
$list_psel = "";
FOR( $iX=1; $iX<$intCntPsel; $iX++ ){
	$strSel = "";
	IF( $iX == $ar_pref ) $strSel = " selected";
	$list_psel .= "              <OPTION value=\"{$iX}\"{$strSel}>{$psel[$iX]}</OPTION>\n";
}


// 県
reset( $param_search_pref );
asort( $param_search_pref["disp_no"] );
$build_pref_value = "";
FOREACH( $param_search_pref["disp_no"] as $key => $val ){
	$selected = "";
	IF( $param_search_pref['val2'][$key] == $ar_pref ) $selected = " selected";
	$ar_pref_value .= "<OPTION value=\"{$param_search_pref['val2'][$key]}\"{$selected}>{$param_search_pref['val2'][$key]}</OPTION>\n";
}

/*=================================================
    ＨＴＭＬ表示
=================================================*/
?>
<HTML>
  <HEAD>
    <TITLE>塾ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/cl.css" />
    <SCRIPT type="text/javascript" src="../share/js/client.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <table id="client" cellspacing="0">
          <form action="cl_upd.php" method="POST" name="client">
            <input type="hidden" name="cl_stat" value="<?=$cl_stat?>"/>
        <tr>
          <th class="must">塾名</th>
          <td class="half"><input id="i1" type="text" name="cl_jname" value="<?=$cl_jname?>" maxlength="50" style="width:150px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /></td>
          <th>教室名</th>
          <td class="half"><input id="i2" type="text" name="cl_kname" value="<?=$cl_kname?>" maxlength="50" style="width:150px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /></td>
        </tr>
        <tr>
          <th>担当者名</th>
          <td class="half"><input id="i3" type="text" name="cl_agent" value="<?=$cl_agent?>" maxlength="50" style="width:150px" onFocus='Text("i3", 1)' onBlur='Text("i3", 2)' /></td>
          <th class="must">担当者Ｅメール</th>
          <td class="half"><input id="i7" type="text" name="cl_mail" value="<?=$cl_mail?>" maxlength="50" style="width:150px" onFocus='Text("i7", 1)' onBlur='Text("i7", 2)' /></td>
        </tr>
        <tr>
          <th>電話番号<br />（ロゴ右・各ページ最下部基本情報）</th>
          <td class="half"><input id="i5" type="text" name="cl_phone" value="<?=$cl_phone?>" maxlength="15" style="width:150px" onFocus='Text("i5", 1)' onBlur='Text("i5", 2)' /></td>
          <th>FAX番号<br />（教室案内ページ内）</th>
          <td class="half"><input id="i6" type="text" name="cl_fax" value="<?=$cl_fax?>" maxlength="15" style="width:150px" onFocus='Text("i6", 1)' onBlur='Text("i6", 2)' /></td>
        </tr>
        <tr>
          <th class="must">パスワード</th>
          <td colspan="3"><input id="i9" type="text" name="cl_passwd" value="<?=$cl_passwd?>" maxlength="15" style="width:150px" onFocus='Text("i9", 1)' onBlur='Text("i9", 2)' /><em>（半角英数字で入力）</em></td>
        </tr>
        <tr>
          <th class="must">住所<br />（各ページ最下部基本情報）</th>
          <td colspan="3">
            <table class="add"><tr>
            <td class="add1">
              <input type="text" id="address_word" name="address_word" value="" style="width:100px"><input type="button" value="検索" onclick="sendDataAdd(this.form)" style="width:35px"><br>
              <div id="hello">
              <select name="address_list" id="address_list" size="10" style="width:190px">
                <option value=""> </option>
              </select>
              </div>
            </td>
            <td class="add2">
              <input type="button" value="→" onclick="sendDataAdd2(this.form)" style="width:35px">
            </td>
            <td class="add3">
              <div id="hello2">
	      <table class="tzip"><tr>
	      <td class="ziptitle">〒</td>
	      <td class="zip"><input id="i4" type="text" name="ar_zip1" value="<?=$arrPostView["ar_zip1"]?>" style="width:40px" maxlength="3" onFocus='Text("i4", 1)' onBlur='Text("i4", 2)' />
	      -<input id="i11" type="text" name="ar_zip2" value="<?=$arrPostView["ar_zip2"]?>" style="width:50px" maxlength="4" onFocus='Text("i11", 1)' onBlur='Text("i11", 2)' />
	      <input type="button" value="住所取得" style="width:80px" onclick="return zipSearch()"></td>
	      </tr><tr>
              <td class="ziptitle">都道府県</td>
	      <td class="zip"><input type="text" name="ar_pref" value="<?=$obj_area->areadat[0]['ar_pref']?>" maxlength="80" style="width:150px" readonly /></td>
	      </tr><tr>
              <td class="ziptitle">市区町村</td>
	      <td class="zip"><input type="text" name="ar_city" value="<?=$obj_area->areadat[0]['ar_city']?>" maxlength="80" style="width:150px" readonly /></td>
	      </tr><tr>
              <td class="ziptitle">番地</td>
	      <td class="zip"><input id="i14" type="text" name="ar_add" value="<?=$obj_area->areadat[0]['ar_add']?>" maxlength="80" style="width:150px" onFocus='Text("i14", 1)' onBlur='Text("i14", 2)' /><br><em>(例：南青山1-16-2)</em><td>
	      </tr><tr>
              <td class="ziptitle">建物名</td>
	      <td class="zip"><input id="i15" type="text" name="ar_estate" value="<?=$obj_area->areadat[0]['ar_estate']?>" maxlength="80" style="width:150px" onFocus='Text("i15", 1)' onBlur='Text("i15", 2)' /><br><em>(例：SASAKIビル3F)</em>
	      <input type="hidden" name="ar_prefcd" value="<?=$obj_area->areadat[0]['ar_prefcd']?>">
	      <input type="hidden" name="ar_citycd" value="<?=$obj_area->areadat[0]['ar_citycd']?>">
              </td>
	      </tr></table>
              </div>
            </td>
            </tr></table>
          </td>
        </tr>
 <!--       <tr>
          <th class="half">エリア１</th>
          <td colspan="3">
            <table class="add"><tr>
            <td class="add1">
              <input type="text" id="address_word1" name="address_word1" value="" style="width:100px"><input type="button" value="検索" onclick="sendDataAdd1_1(this.form)" style="width:35px"><br>
              <div id="hello1_1">
              <select name="address_list1" id="address_list1" size="10" style="width:190px">
                <option value=""> </option>
              </select>
              </div>
            </td>
            <td class="add2">
              <input type="button" value="→" onclick="sendDataAdd1_2(this.form)" style="width:35px">
            </td>
            <td class="add3">
              <div id="hello1_2">
	      <table class="tzip"><tr>
	      <td class="ziptitle">〒</td>
	      <td class="zip"><input id="i4" type="text" name="ar_zip1_1" value="<?=$arrPostView["ar_zip1_1"]?>" style="width:40px" maxlength="3" onFocus='Text("i4", 1)' onBlur='Text("i4", 2)' />
	      -<input id="i11" type="text" name="ar_zip1_2" value="<?=$arrPostView["ar_zip1_2"]?>" style="width:50px" maxlength="4" onFocus='Text("i11", 1)' onBlur='Text("i11", 2)' />
	      <input type="button" value="住所取得" style="width:80px" onclick="return zipSearch1()"></td>
	      </tr><tr>
              <td class="ziptitle">都道府県</td>
	      <td class="zip"><input type="text" name="ar_pref1" value="<?=$obj_area1->areadat[0]['ar_pref']?>" maxlength="80" style="width:150px" readonly /></td>
	      </tr><tr>
              <td class="ziptitle">市区町村</td>
	      <td class="zip"><input type="text" name="ar_city1" value="<?=$obj_area1->areadat[0]['ar_city']?>" maxlength="80" style="width:150px" readonly /></td>
	      <input id="i15" type="hidden" name="ar_estate1" value="<?=$obj_area1->areadat[0]['ar_estate']?>" maxlength="80" style="width:150px" onFocus='Text("i15", 1)' onBlur='Text("i15", 2)' />
	      <input id="i14" type="hidden" name="ar_add1" value="<?=$obj_area1->areadat[0]['ar_add']?>" maxlength="80" style="width:150px" onFocus='Text("i14", 1)' onBlur='Text("i14", 2)' />
	      <input type="hidden" name="ar_prefcd1" value="<?=$obj_area1->areadat[0]['ar_prefcd']?>">
	      <input type="hidden" name="ar_citycd1" value="<?=$obj_area1->areadat[0]['ar_citycd']?>">
	      </tr></table>
              </div>
            </td>
            </tr></table>
          </td>
        </tr>
        <tr>
          <th class="half">エリア２</th>
          <td colspan="3">
            <table class="add"><tr>
            <td class="add1">
              <input type="text" id="address_word2" name="address_word2" value="" style="width:100px"><input type="button" value="検索" onclick="sendDataAdd2_1(this.form)" style="width:35px"><br>
              <div id="hello2_1">
              <select name="address_list2" id="address_list2" size="10" style="width:190px">
                <option value=""> </option>
              </select>
              </div>
            </td>
            <td class="add2">
              <input type="button" value="→" onclick="sendDataAdd2_2(this.form)" style="width:35px">
            </td>
            <td class="add3">
              <div id="hello2_2">
	      <table class="tzip"><tr>
	      <td class="ziptitle">〒</td>
	      <td class="zip"><input id="i4" type="text" name="ar_zip2_1" value="<?=$arrPostView["ar_zip2_1"]?>" style="width:40px" maxlength="3" onFocus='Text("i4", 1)' onBlur='Text("i4", 2)' />
	      -<input id="i11" type="text" name="ar_zip2_2" value="<?=$arrPostView["ar_zip2_2"]?>" style="width:50px" maxlength="4" onFocus='Text("i11", 1)' onBlur='Text("i11", 2)' />
	      <input type="button" value="住所取得" style="width:80px" onclick="return zipSearch2()"></td>
	      </tr><tr>
              <td class="ziptitle">都道府県</td>
	      <td class="zip"><input type="text" name="ar_pref2" value="<?=$obj_area2->areadat[0]['ar_pref']?>" maxlength="80" style="width:150px" readonly /></td>
	      </tr><tr>
              <td class="ziptitle">市区町村</td>
	      <td class="zip"><input type="text" name="ar_city2" value="<?=$obj_area2->areadat[0]['ar_city']?>" maxlength="80" style="width:150px" readonly /></td>
	      <input id="i15" type="hidden" name="ar_estate2" value="<?=$obj_area2->areadat[0]['ar_estate']?>" maxlength="80" style="width:150px" onFocus='Text("i15", 1)' onBlur='Text("i15", 2)' />
	      <input id="i14" type="hidden" name="ar_add2" value="<?=$obj_area2->areadat[0]['ar_add']?>" maxlength="80" style="width:150px" onFocus='Text("i14", 1)' onBlur='Text("i14", 2)' />
	      <input type="hidden" name="ar_prefcd2" value="<?=$obj_area2->areadat[0]['ar_prefcd']?>">
	      <input type="hidden" name="ar_citycd2" value="<?=$obj_area2->areadat[0]['ar_citycd']?>">
	      </tr></table>
              </div>
            </td>
            </tr></table>
          </td>
        </tr>
        <tr>
          <th class="half">エリア３</th>
          <td colspan="3">
            <table class="add"><tr>
            <td class="add1">
              <input type="text" id="address_word3" name="address_word3" value="" style="width:100px"><input type="button" value="検索" onclick="sendDataAdd3_1(this.form)" style="width:35px"><br>
              <div id="hello3_1">
              <select name="address_list3" id="address_list3" size="10" style="width:190px">
                <option value=""> </option>
              </select>
              </div>
            </td>
            <td class="add2">
              <input type="button" value="→" onclick="sendDataAdd3_2(this.form)" style="width:35px">
            </td>
            <td class="add3">
              <div id="hello3_2">
	      <table class="tzip"><tr>
	      <td class="ziptitle">〒</td>
	      <td class="zip"><input id="i4" type="text" name="ar_zip3_1" value="<?=$arrPostView["ar_zip3_1"]?>" style="width:40px" maxlength="3" onFocus='Text("i4", 1)' onBlur='Text("i4", 2)' />
	      -<input id="i11" type="text" name="ar_zip3_2" value="<?=$arrPostView["ar_zip3_2"]?>" style="width:50px" maxlength="4" onFocus='Text("i11", 1)' onBlur='Text("i11", 2)' />
	      <input type="button" value="住所取得" style="width:80px" onclick="return zipSearch3()"></td>
	      </tr><tr>
              <td class="ziptitle">都道府県</td>
	      <td class="zip"><input type="text" name="ar_pref3" value="<?=$obj_area3->areadat[0]['ar_pref']?>" maxlength="80" style="width:150px" readonly /></td>
	      </tr><tr>
              <td class="ziptitle">市区町村</td>
	      <td class="zip"><input type="text" name="ar_city3" value="<?=$obj_area3->areadat[0]['ar_city']?>" maxlength="80" style="width:150px" readonly /></td>
	      <input id="i15" type="hidden" name="ar_estate3" value="<?=$obj_area3->areadat[0]['ar_estate']?>" maxlength="80" style="width:150px" onFocus='Text("i15", 1)' onBlur='Text("i15", 2)' />
	      <input id="i14" type="hidden" name="ar_add3" value="<?=$obj_area3->areadat[0]['ar_add']?>" maxlength="80" style="width:150px" onFocus='Text("i14", 1)' onBlur='Text("i14", 2)' />
	      <input type="hidden" name="ar_prefcd3" value="<?=$obj_area3->areadat[0]['ar_prefcd']?>">
	      <input type="hidden" name="ar_citycd3" value="<?=$obj_area3->areadat[0]['ar_citycd']?>">
	      </tr></table>
              </div>
            </td>
            </tr></table>
          </td>
        </tr> -->
          <input type="hidden" name="cl_urlcd" value="<?=$cl_urlcd?>"/>
          <input type="hidden" name="cl_loginid" value="<?=$cl_loginid?>"/>
	<input type="hidden" name="cl_limit_date_y" value="<?=$arrLimitDate[0]?>">
	<input type="hidden" name="cl_limit_date_m" value="<?=$arrLimitDate[1]?>">
	<input type="hidden" name="cl_limit_date_d" value="<?=$arrLimitDate[2]?>">
      </table>
      <br />
      <table>
        <tr>
          <td align="center" valign="top">
            <input type="button" value="<?=$strButtonVal?>" class="btn_nosize" onclick="ClientInputCheck( this.form , this.form )" />
            <input type="hidden" name="mode" value="EDIT" />
            <input type="hidden" name="cl_id" value="<?=$cl_id?>" />
            <input type="hidden" name="cl_upddate" value="<?=$cl_upddate?>" />
            <input type="hidden" name="cl_stat" value="<?=$cl_stat?>" />
            <input type="hidden" name="cl_pstat" value="<?=$cl_pstat?>" />
            <input type="hidden" name="cl_logincd" value="<?=$cl_logincd?>" />
            <input type="hidden" name="cl_biko" value="<?=$cl_biko?>" />
            <input type="hidden" name="cl_start" value="<?=$cl_start?>" />
            <input type="hidden" name="cl_end" value="<?=$cl_end?>" />
            <input type="hidden" name="cl_yobi1" value="<?=$cl_yobi1?>" />
            <input type="hidden" name="cl_yobi2" value="<?=$cl_yobi2?>" />
            <input type="hidden" name="cl_yobi3" value="<?=$cl_yobi3?>" />
            <input type="hidden" name="cl_yobi4" value="<?=$cl_yobi4?>" />
            <input type="hidden" name="cl_yobi5" value="<?=$cl_yobi5?>" />
            <input type="hidden" name="cl_dokuji_flg" value="<?=$cl_dokuji_flg?>" />
            <input type="hidden" name="cl_googlemap_key" value="<?=$cl_googlemap_key?>" />
            <input type="hidden" name="cl_dokuji_domain" value="<?=$cl_dokuji_domain?>" />
            <input type="hidden" name="ar_id" value="<?=$obj_area->areadat[0]['ar_id']?>" />
            <input type="hidden" name="ar_id1" value="<?=$obj_area1->areadat[0]['ar_id']?>" />
            <input type="hidden" name="ar_id2" value="<?=$obj_area2->areadat[0]['ar_id']?>" />
            <input type="hidden" name="ar_id3" value="<?=$obj_area3->areadat[0]['ar_id']?>" />
            <input type="hidden" name="ar_upddate" value="<?=$obj_area->areadat[0]['ar_upddate']?>" />
            <input type="hidden" name="ar_upddate1" value="<?=$obj_area1->areadat[0]['ar_upddate']?>" />
            <input type="hidden" name="ar_upddate2" value="<?=$obj_area2->areadat[0]['ar_upddate']?>" />
            <input type="hidden" name="ar_upddate3" value="<?=$obj_area3->areadat[0]['ar_upddate']?>" />
          </td>
          </form>
          <form method="POST" action="cl_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="戻る" class="btn_nosize" />
          </td>
          </form>
        </tr>
      </table>
    </DIV>
  </body>
</HTML>
