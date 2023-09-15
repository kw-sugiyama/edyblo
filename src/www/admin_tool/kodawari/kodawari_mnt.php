<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: kodawari_mnt.php
	Version: 1.0.0
	Function: ���饤�������Ͽ����������
	Author: Click inc
	Date of creation: 2007/06
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
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
require_once ( SYS_PATH."configs/param_kodawari.conf" );


/*----------------------------------------------------------
  ���å������Ͽ����
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  ���顼���饹 - ���󥹥���
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  �������������å�
----------------------------------------------------------*/
require_once("../login_chk.php");


/*--------------------------------------------------------
	������ʬ
--------------------------------------------------------*/


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
	ɽ���ꥹ�ȹ��ܺ���
--------------------------------------------------------*/
/*---------------------------------------------------------
    $_GET["mode"] �� "search" �Ǥ����硢
    ������긡�����̤�ɽ������
---------------------------------------------------------*/
	
// ��
reset( $param_search_pref );
asort( $param_search_pref["disp_no"] );
$search_pref_value = "";
FOREACH( $param_search_pref["disp_no"] as $key => $val ){
	$selected = "";
	if(count($_POST['ar'])!=0){
		foreach($_POST['ar'] as $key2 => $val2){
			IF( $param_search_pref['id'][$key] == $val2 ) $selected = " selected";
		}
	}
	$search_pref_value .= "<OPTION value=\"{$param_search_pref['id'][$key]}\"{$selected}>{$param_search_pref['val'][$key]}</OPTION>\n";
}

// ����(����)
reset( $param_search_price );
asort( $param_search_price["disp_no"] );
$search_price_value = "";
FOREACH( $param_search_price["disp_no"] as $key => $val ){
	$selected = "";
	IF( $param_search_price['price'][$key] == $_POST['search_price'] ) $selected = " selected";
	$search_price_value .= "<OPTION value=\"{$param_search_price['price'][$key]}\"{$selected}>{$param_search_price['val'][$key]}</OPTION>\n";
}

// ����(���)
reset( $param_search_price_limit );
asort( $param_search_price_limit["disp_no"] );
$search_price_limit_value = "";
FOREACH( $param_search_price_limit["disp_no"] as $key => $val ){
	$selected = "";
	IF( $param_search_price_limit['price'][$key] == $_POST['search_price_limit'] ) $selected = " selected";
	$search_price_limit_value .= "<OPTION value=\"{$param_search_price_limit['price'][$key]}\"{$selected}>{$param_search_price_limit['val'][$key]}</OPTION>\n";
}

// ��ͭ����(����)
reset( $param_search_area );
asort( $param_search_area["disp_no"] );
$search_area_value = "";
FOREACH( $param_search_area["disp_no"] as $key => $val ){
	$selected = "";
	IF( $param_search_area['area'][$key] == $_POST['search_area'] ) $selected = " selected";	
	$search_area_value .= "<OPTION value=\"{$param_search_area['area'][$key]}\"{$selected}>{$param_search_area['val'][$key]}</OPTION>\n";
}

// ��ͭ����(���)
reset( $param_search_area_limit );
asort( $param_search_area_limit["disp_no"] );
$search_area_limit_value = "";
FOREACH( $param_search_area_limit["disp_no"] as $key => $val ){
	$selected = "";
	IF( $param_search_area_limit['area'][$key] == $_POST['search_area_limit'] ) $selected = " selected";	
	$search_area_limit_value .= "<OPTION VALUE=\"{$param_search_area_limit['area'][$key]}\"{$selected}>{$param_search_area_limit['val'][$key]}</OPTION>\n";
}

// �ּ��
reset( $param_room_floor );
asort( $param_room_floor["disp_no"] );
$madori_value = "";
$cnt = 0;
FOREACH( $param_room_floor["disp_no"] as $key => $val ){
	$checked = "";
	IF( count($_POST['search_madori'] ) != 0 ){
		FOREACH( $_POST['search_madori'] as $key2 => $val2 ){
			IF( $param_room_floor['id'][$key] == $val2 ) $checked = " checked";
		}
	}
	
	IF( $cnt == 0 ){
		$madori_value .= "<tr>\n";
	}
	$madori_value .= "  <td class=\"zip\"><INPUT TYPE=\"checkbox\" name=\"search_madori[]\" id=\"�ּ�{$param_room_floor['val'][$key]}\" value=\"{$param_room_floor['id'][$key]}\"{$checked}><label for=\"�ּ�{$param_room_floor['val'][$key]}\">{$param_room_floor['val'][$key]}</label>\n";
	$cnt++;
	IF( $cnt == 7 ){
		$madori_value .= "</tr>\n";
		$cnt = 0;
	}
}
IF( $cnt != 0 ){
	FOR( $iX=$cnt; $iX<7; $iX++ ){
		$madori_value .= "  <td class=\"zip\">&nbsp;</td>\n";
	}
	$madori_value .= "</tr>\n";
}

// ��ʪ������
reset( $param_build_type );
asort( $param_build_type["disp_no"] );
$build_type_value = "";
$cnt = 0;
FOREACH( $param_build_type["disp_no"] as $key => $val ){
	$checked = "";
	IF( count($_POST['search_type']) != 0 ){
		FOREACH( $_POST['search_type'] as $key2 => $val2 ){
			IF( $param_build_type['id'][$key] == $val2 ) $checked = "checked";
		}
	}
	
	IF( $cnt == 0 ){
		$build_type_value .= "<tr>\n";
	}
	$build_type_value .= "  <td class=\"zip\"><INPUT TYPE=\"checkbox\" NAME=\"search_type[]\" id=\"{$param_build_type['val'][$key]}\" value=\"{$param_build_type['id'][$key]}\"{$checked}><label for=\"{$param_build_type['val'][$key]}\">{$param_build_type['val'][$key]}</label></td>\n";
	$cnt++;
	IF( $cnt == 4 ){
		$build_type_value .= "</tr>\n";
		$cnt = 0;
	}
}
IF( $cnt != 0 ){
	FOR( $iX=$cnt; $iX<4; $iX++ ){
		$build_type_value .= "  <td class=\"zip\">&nbsp;</td>\n";
	}
	$build_type_value .= "</tr>\n";
}

// ��¤
reset( $param_build_material );
asort( $param_build_material["disp_no"] );
$build_material_value = "";
$cnt = 0;
FOREACH( $param_build_material["disp_no"] as $key => $val ){
	$checked = "";
	IF( count($_POST['search_material']) != 0 ){
		FOREACH( $_POST['search_material'] as $key2 => $val2 ){
			IF( $param_build_material['id'][$key] == $val2 ) $checked = " checked";
		}
	}
	
	IF( $cnt == 0 ){
		$build_material_value .= "<tr>\n";
	}
	$build_material_value .= "  <td class=\"zip\"><INPUT type=\"checkbox\" name=\"search_material[]\" id=\"{$param_build_material['val'][$key]}\" value=\"{$param_build_material['id'][$key]}\"{$checked}><label for=\"{$param_build_material['val'][$key]}\">{$param_build_material['val'][$key]}</label></td>\n";
	$cnt++;
	IF( $cnt == 4 ){
		$build_material_value .= "</tr>\n";
		$cnt = 0;
	}
}
IF( $cnt != 0 ){
	FOR( $iX=$cnt; $iX<4; $iX++ ){
		$build_material_value .= "  <td class=\"zip\">&nbsp;</td>\n";
	}
	$build_material_value .= "</tr>\n";
}

// �ؤ��������
reset( $param_search_station );
asort( $param_search_station["disp_no"] );
$search_station_value = "";
$cnt = 0;
FOREACH( $param_search_station["disp_no"] as $key => $val ){
	$checked = "";
	IF( $param_search_station['move'][$key] == $_POST['search_station'] ) $checked = " checked";
	
	IF( $cnt == 0 ){
		$search_station_value .= "<tr>\n";
	}
	$search_station_value .= "  <td class=\"zip\"><INPUT type=\"radio\" name=\"search_station\" id=\"{$param_search_station['val'][$key]}\" value=\"{$param_search_station['move'][$key]}\"{$checked}><label for=\"{$param_search_station['val'][$key]}\">{$param_search_station['val'][$key]}</label></td>\n";
	$cnt++;
	IF( $cnt == 6 ){
		$search_station_value .= "</tr>\n";
		$cnt = 0;
	}
}
IF( $cnt != 0 ){
	FOR( $iX=$cnt; $iX<6; $iX++ ){
		$search_station_value .= "  <td class=\"zip\">&nbsp;</td>\n";
	}
	$search_station_value .= "</tr>\n";
}

// �۸�ǯ��
reset( $param_search_date );
asort( $param_search_date["disp_no"] );
$search_date_value = "";
$cnt = 0;
FOREACH( $param_search_date["disp_no"] as $key => $val ){
	$checked = "";
	IF( $param_search_date['date'][$key] == $_POST['search_date'] ) $checked = " checked";
	
	IF( $cnt == 0 ){
		$search_date_value .= "<tr>\n";
	}
	$search_date_value .= "  <td class=\"zip\"><INPUT type=\"radio\" name=\"search_date\" id=\"��ǯ��{$param_search_date['val'][$key]}\" value=\"{$param_search_date['date'][$key]}\"{$checked} /><label for=\"��ǯ��{$param_search_date['val'][$key]}\">{$param_search_date['val'][$key]}</label></td>\n";
	$cnt++;
	IF( $cnt == 5 ){
		$search_date_value .= "</tr>\n";
		$cnt = 0;
	}
}

asort( $param_room_equip["disp_no"] );
$equip_value = "";
$iX = 0;
FOREACH( $param_room_equip["disp_no"] as $key => $val ){
	$checked = "";
	if(count($_POST['search_equip'])!=0){
		foreach($_POST['search_equip'] as $key2 => $val2){
			if($param_room_equip['id'][$key] == $val2)$checked = "checked";
		}
	}
	$iX++;
	if($param_room_equip['val'][$key] != "����¾")$search_equip_value .= "<TD class=\"zip\"><INPUT TYPE=\"checkbox\" NAME=\"search_equip[{$iX}]\" VALUE=\"{$param_room_equip['id'][$key]}\" {$checked}>{$param_room_equip['val'][$key]}</TD>\n";	
	if( $iX % 4 == 0 )$search_equip_value .= "</TR><TR>";
}


// �߶⡦���̵��
if( $_POST['sikirei'] == 1 ){
	$sikirei_checked = " checked";
}

// ������ʬ����ͻ���
if($_POST['fa'] == "area"){
	$pf_check_1 = "checked";
}else if($_POST['fa'] == "line"){
	$pf_check_2 = "checked";
}else if($_POST['fa'] == "sta"){
	$pf_check_3 = "checked";
}else{
	$pf_check_1 = "checked";
}

// ɽ����������
$searchValue .= "  <table id=\"client\" cellspacing=\"0\">\n";
if($_POST['mode']=="search"){
	$searchValue .= "        <tr>\n";
	$searchValue .= "          <th id=\"must\">������ʬ</th>\n";
	$searchValue .= "          <td>\n";
	$searchValue .= "          <input type=\"radio\" name=\"fa\" value=\"area\" {$pf_check_1}>���ꥢ����\n";
	$searchValue .= "          ��<input type=\"radio\" name=\"fa\" value=\"line\" {$pf_check_2}>��������\n";
	$searchValue .= "          ��<input type=\"radio\" name=\"fa\" value=\"sta\" {$pf_check_3}>�ظ���\n";
	$searchValue .= "          </SELECT>\n";
	$searchValue .= "          </td>\n";
	$searchValue .= "        </tr>\n";
}
if($_POST['mode']=="result"){
	$searchValue .= "        <tr>\n";
	$searchValue .= "          <th>��ƻ�ܸ�</th>\n";
	$searchValue .= "          <td>\n";
	$searchValue .= "          <SELECT name=\"ar[]\" size=\"10\" multiple>\n";
	$searchValue .= $search_pref_value;
	$searchValue .= "          </SELECT><br><br>\n";
	$searchValue .= "          <font color=\"#ff0000\" size=\"1\">��ʣ�����򤹤���ϡ�Ctrl�ܥ���򲡤��ʤ������򤷤Ƥ���������</font></td>\n";
	$searchValue .= "        </tr>\n";
	$searchValue .= "        <tr>\n";
	$searchValue .= "          <th>�Զ�Į¼</th>\n";
	$searchValue .= "          <td>\n";
	$searchValue .= "            <INPUT type=\"button\" name=\"area_setting1\" value=\"�Զ�Į¼�ɲ�\" onClick=\"OpenPageArea('area_list','area_list','area_cd','area_cd','area_cd');\" />\n";
	$searchValue .= "            <INPUT type=\"button\" name=\"area_setting2\" value=\"�ꥻ�å�\" onClick=\"ListReset('area_cd','area_list');\" /><br />\n";
	$searchValue .= "            <TEXTAREA name=\"area_list\" rows=\"5\" cols=\"35\" id=\"area_list\" readonly>{$_POST['area_list']}</TEXTAREA>\n";
	$searchValue .= "            <input type=\"hidden\" name=\"area_cd\" id=\"area_cd\" value=\"{$_POST['area_cd']}\" />\n";
	$searchValue .= "          </td>\n";
	$searchValue .= "        </tr>\n";
	$searchValue .= "        <tr>\n";
	$searchValue .= "          <th>����</th>\n";
	$searchValue .= "          <td>\n";
	$searchValue .= "            <INPUT type=\"button\" name=\"line_setting1\" value=\"�����ɲ�\" onClick=\"OpenPageLine('line_list','line_list','line_cd','line_cd','line_cd');\" />\n";
	$searchValue .= "            <INPUT type=\"button\" name=\"area_setting2\" value=\"�ꥻ�å�\" onClick=\"ListReset('line_cd','line_list');\" /><br />\n";
	$searchValue .= "            <TEXTAREA name=\"line_list\" rows=\"5\" cols=\"35\" id=\"line_list\" readonly>{$_POST['line_list']}</TEXTAREA>\n";
	$searchValue .= "            <input type=\"hidden\" name=\"line_cd\" id=\"line_cd\" value=\"{$_POST['line_cd']}\" />\n";
	$searchValue .= "          </td>\n";
	$searchValue .= "        </tr>\n";
	$searchValue .= "        <tr>\n";
	$searchValue .= "          <th>��</th>\n";
	$searchValue .= "          <td>\n";
	$searchValue .= "            <INPUT type=\"button\" name=\"sta_setting1\" value=\"���ɲ�\" onClick=\"OpenPageSta('sta_list','sta_list','sta_cd','sta_cd','sta_cd');\" />\n";
	$searchValue .= "            <INPUT type=\"button\" name=\"area_setting2\" value=\"�ꥻ�å�\" onClick=\"ListReset('sta_cd','sta_list');\" /><br />\n";
	$searchValue .= "            <TEXTAREA name=\"sta_list\" rows=\"5\" cols=\"35\" id=\"sta_list\" readonly>{$_POST['sta_list']}</TEXTAREA>\n";
	$searchValue .= "            <input type=\"hidden\" name=\"sta_cd\" id=\"sta_cd\" value=\"{$_POST['sta_cd']}\" />\n";
	$searchValue .= "          </td>\n";
	$searchValue .= "        </tr>\n";
}
$searchValue .= "    <tr>\n";
$searchValue .= "      <th>����</th>\n";
$searchValue .= "      <td>\n";
$searchValue .= "        <SELECT name=\"search_price\">\n";
$searchValue .= $search_price_value;
$searchValue .= "        </SELECT>������\n";
$searchValue .= "        <SELECT name=\"search_price_limit\">\n";
$searchValue .= $search_price_limit_value;
$searchValue .= "        </SELECT>\n";
$searchValue .= "        ��<input type=\"checkbox\" name=\"sikirei\" value=\"1\"{$sikirei_checked}>�߶⎥���0\n";
$searchValue .= "      </td>\n";
$searchValue .= "    </tr>\n";
$searchValue .= "    <tr>\n";
$searchValue .= "      <th>�ּ�꥿����</th>\n";
$searchValue .= "      <td>\n";
$searchValue .= "        <table class=\"zip\">\n";
$searchValue .= $madori_value;
$searchValue .= "        </table>\n";
$searchValue .= "      </td>\n";
$searchValue .= "    </tr>\n";
$searchValue .= "    <tr>\n";
$searchValue .= "      <th>��ͭ����</th>\n";
$searchValue .= "      <td>\n";
$searchValue .= "        <SELECT name=\"search_area\">\n";
$searchValue .= $search_area_value;
$searchValue .= "        </SELECT>������\n";
$searchValue .= "        <SELECT name=\"search_area_limit\">\n";
$searchValue .= $search_area_limit_value;
$searchValue .= "        </SELECT>\n";
$searchValue .= "      </td>\n";
$searchValue .= "    </tr>\n";
$searchValue .= "    <tr>\n";
$searchValue .= "      <th>��ʪ����</th>\n";
$searchValue .= "      <td>\n";
$searchValue .= "        <table class=\"zip\">\n";
$searchValue .= $build_type_value;
$searchValue .= "        </table>\n";
$searchValue .= "      </td>\n";
$searchValue .= "    </tr>\n";
$searchValue .= "    <tr>\n";
$searchValue .= "      <th>��¤</th>\n";
$searchValue .= "      <td>\n";
$searchValue .= "        <table class=\"zip\">\n";
$searchValue .= $build_material_value;
$searchValue .= "        </table>\n";
$searchValue .= "      </td>\n";
$searchValue .= "    </tr>\n";
$searchValue .= "    <tr>\n";
$searchValue .= "      <th>����</th>\n";
$searchValue .= "      <td>\n";
$searchValue .= "        <table class=\"zip\">\n";
$searchValue .= $search_equip_value;
$searchValue .= "        </table>\n";
$searchValue .= "      </td>\n";
$searchValue .= "    </tr>\n";
$searchValue .= "    <tr>\n";
$searchValue .= "      <th>������</th>\n";
$searchValue .= "      <td>\n";
$searchValue .= "        <table class=\"zip\">\n";
$searchValue .= $search_station_value;
$searchValue .= "        </table>\n";
$searchValue .= "      </td>\n";
$searchValue .= "    </tr>\n";
$searchValue .= "    <tr>\n";
$searchValue .= "      <th>��ǯ��</th>\n";
$searchValue .= "      <td>\n";
$searchValue .= "        <table class=\"zip\">\n";
$searchValue .= $search_date_value;
$searchValue .= "        </table>\n";
$searchValue .= "      </td>\n";
$searchValue .= "      <input type=\"hidden\" name=\"mode\" value=\"{$_POST['mode']}\" >";
$searchValue .= "    </tr>\n";
$searchValue .= "  </table>\n";
$searchValue .= "  <br>\n";
$searchValue .= "  <table id=\"zip\" cellspacing=\"0\">\n";
$searchValue .= "        <tr>\n";
$searchValue .= "          <td id=\"zip\">\n";
$searchValue .= "	    <center><input type=\"submit\" value=\"���ɥ쥹����\" class=\"btn\"></center>\n";
$searchValue .= "          </td>\n";
$searchValue .= "          </form>\n";
$searchValue .= "          <form action=\"kodawari_main.php\" method=\"POST\" name=\"back\">\n";
$searchValue .= "          <td id=\"zip\">\n";
$searchValue .= "	    <center><input type=\"submit\" value=\"���\" class=\"btn\"></center>\n";
$searchValue .= "          </td>\n";
$searchValue .= "          </form>\n";
$searchValue .= "        </tr>\n";
$searchValue .= "  </table>\n";


/*=================================================
    �ȣԣͣ�ɽ��
=================================================*/
?>
<HTML>
  <HEAD>
    <TITLE>��ư���֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/kodawari.css" />
    <SCRIPT type="text/javascript" src="../share/js/kodawari.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
        <form action="kodawari_upd.php" method="POST" name="build">
	    <?=$searchValue?>
    </DIV>
  </body>
</HTML>
