<?
/******************************************************************************
<< ��ư���֥���Ver.1.0.0 >>
    Name: menu.php
    Version: 1.0.0
    Function: ��˥塼����
    Author: Click inc
    Date of creation: 2007/02
    History of modification:

    Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."configs/param_base.conf" );


/*----------------------------------------------------------
  ���å���󳫻�
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  �������������å�
----------------------------------------------------------*/
require_once("./login_chk.php");
IF( $login_val["sc_stat"] == 1 ){
	$strMenuData = "";
//	$strMenuData .= "        <li><a href=\"./menu/menu_main.php\" class=\"bt_menu\">���ܥ�˥塼</a></li>\n";
	$strMenuData .= "        <li><a href=\"./layout/layout_main.php\" class=\"bt_menu\">TOP���̥쥤������</a></li>\n";
	$strMenuData .= "        <li><a href=\"./dai_leftmenu/leftmenu_main.php\" class=\"bt_menu\">����˥塼��Ͽ</a></li>\n";
	$strMenuData .= "        <li><a href=\"./category/category_select.php\" class=\"bt_menu\">���ƥ��꡼��Ͽ</a></li>\n";
	$strMenuData .= "        <li><a href=\"./menu_category.php\" class=\"bt_menu\">�Ƶ�����Ͽ</a></li>\n";
	$strMenuData .= "        <li><a href=\"./course/course_main.php\" class=\"bt_menu\">������������Ͽ</a></li>\n";
	$strMenuData .= "        <li><a href=\"./campain/campain_main.php\" class=\"bt_menu\">�����ڡ��󵭻���Ͽ</a></li>\n";
	$strMenuData .= "        <li><a href=\"./diary/diary_main.php\" class=\"bt_menu\">�����å�����</a></li>\n";
	$strMenuData .= "        <li><a href=\"./teacher/teacher_main.php\" class=\"bt_menu\">�ֻեޥ�����Ͽ</a></li>\n";
	$strMenuData .= "        <li><a href=\"./access/access_log.php\" class=\"bt_menu\">������������</a></li>\n";
	
	$strHomepageAddr = "<li><a class=\"hp_link\" href=\"{$param_base_blog_addr_url}{$param_base_blog_addr}{$login_val["cl_url_code"]}/\" target=\"_blank\">�֥���ɽ������</a></li>\n";
}ELSE{
	$strHomepageAddr = "<li>&nbsp;</li>\n";
}


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  �ȣԣͣ�����
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP">
    <TITLE>�Υ֥� - ���饤����ȥġ���</TITLE>
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="./share/css/menu.css" type="text/css" />
    <base target="home" />
    <script language="javascript">
    <!--
	function ChangeColor(parts){
		parts.backgroundColor='#FF6699';
	}
	function ChangeColor2(parts){
		parts.backgroundColor='#FFFFFF';
	}
	function LoginSub(){
		document.menu.submit();
	}
    //-->
    </script>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <FORM name="menu" method="post" action="index.php" target="_parent">
    <DIV id="navigation">
      <ul>
<?=$strHomepageAddr?>
        <li><a href="./cl/cl_main.php" class="bt_menu">��Ҿ�����</a></li>
        <li><a href="./blog/blog_main.php" class="bt_menu">�֥����ܾ�����Ͽ</a></li>
<?=$strMenuData?>
        <li><a href="javascript:void(0)" onclick="LoginSub()" class="bt_menu">��������</a></li>
        <li>&nbsp;</li>
        <li><DIV id="back" class="comment">���ڡ�����������<br />�����ƥ�Ρ����ץܥ����<br />���Ѥ��Ʋ�������</DIV></li>
      </ul>
    </DIV>
    </FORM>
  </BODY>
</HTML>
