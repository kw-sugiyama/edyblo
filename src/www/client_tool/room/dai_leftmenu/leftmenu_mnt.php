<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: category_main.php
	Version: 1.0.0
	Function: �����԰���
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
//require_once ( "../img_thumbnail.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_LeftmenuClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );


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

	/**************************************
	  �������ܾ��󸡺�
	**************************************/
	$obj2 = new basedb_LeftmenuClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["csa_deldate"] = 1;
	$obj2->jyoken["csa_csid"] = $_POST['cg_id'];
	$obj2->sort["csa_dispno"] = 1;
	list( $num , $intTotal ) = $obj2->basedb_GetLeftmenu( 1 , -1 );
	IF( $num == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}


	/**************************************
	  ɽ��������
	**************************************/
	// ���ƥ����������
	$csa_cateid = $obj2->leftmenudat[$i]['csa_cateid'];
	$obj_cate = new basedb_CategoryClassTblAccess;
	$obj_cate->conn = $obj_conn->conn;
	$obj_cate->jyoken["cg_deldate"] = 1;
	$obj_cate->jyoken["cg_stat"] = 1;
	$obj_cate->jyoken["cg_type"] = 7;
	$obj_cate->jyoken["cg_clid"] = $_SESSION['_cl_id'];
	$obj_cate->sort["cg_dispno"] = 2;
	list( $intCntCate , $intTotalCate ) = $obj_cate->basedb_GetCategory( 1 , -1 );
	IF( $intCntCate == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}
	$cateValue = "";
	for($iY=0;$iY<$intCntCate;$iY++){
		$cg_select ="";
		$category_name ="";
		$category_id ="";
		$category_name = $obj_cate->categorydat[$iY]["cg_stitle"];
		$category_id = $obj_cate->categorydat[$iY]["cg_id"];
		if($category_id == $csa_cateid && $csa_cateid!="")$cg_select = "selected";
		$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
	}
	$csa_new_form = "";
	$csa_new_form .= "        <img src=\"../share/images/leftmenu_new_button.gif\" alt=\"������򥯥�å������Ÿ��ɽ���Ǥ��ޤ�\" width=\"100\" height=\"20\" title=\"�ܺپ�︡���ǹʤ����\" />\n";
	$csa_new_form .= "        <div class=\"js_close\">\n";
	$csa_new_form .= "          <DIV id=��\"title\">����������ͳ������Ͽ</DIV>\n";
	$csa_new_form .= "      <br>\n";
	$csa_new_form .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$csa_new_form .= "        <TR>\n";
	$csa_new_form .= "          <TD class=\"td_cl\" style=\"width:350px\">����</TD>\n";
	$csa_new_form .= "          <TD class=\"td_cl\" style=\"width:200px\">���ƥ���</TD>\n";
	$csa_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$csa_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$csa_new_form .= "        </TR>\n";
	$csa_new_form .= "        <TR>\n";
	$csa_new_form .= "          <TD class=\"td_cl\" style=\"width:350px\" rowspan=\"2\">����</TD>\n";
	$csa_new_form .= "          <TD class=\"td_cl\" style=\"width:300px\">�����ȥ�</TD>\n";
	$csa_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">ɽ����</TD>\n";
	$csa_new_form .= "        </TR>\n";
	$csa_new_form .= "          <TD colspan=\"3\" class=\"td_cl\" style=\"width:400px\">����ƥ��</TD>\n";
	$csa_new_form .= "        <TR>\n";
	$csa_new_form .= "        </TR>\n";
	$csa_new_form .= "        </table>\n";
	$csa_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$csa_new_form .= "      <TR>\n";
	$csa_new_form .= "        <FORM method=\"POST\" action=\"leftmenu_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$csa_new_form .= "        <TD class=\"td_cm\" style=\"width:250\"><input type=\"radio\" name=\"csa_stat\" value=\"1\" {$csa_statFlg1}>ɽ��<input type=\"radio\" name=\"csa_stat\" value=\"9\" {$csa_statFlg2}>��ɽ��</TD>\n";
	$csa_new_form .= "        <TD class=\"td_cm\"style=\"width:200\"><select name=\"csa_cateid\">\n";
	$csa_new_form .= "        <option value-\"\">----</option>\n";
	$csa_new_form .= "        {$cateValue}\n";
	$csa_new_form .= "        </TD>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"submit\" name=\"go_mnt_2\" value=\"��������\" class=\"btn_leftmenu\" onclick=\"return LeftmenuInputCheck( this.form , this.form )\"/></TD>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><input type=\"reset\" value=\"���ꥢ\" class=\"btn_leftmenu\" ></TD>\n";
	$csa_new_form .= "      </TR>\n";
	$csa_new_form .= "      <TR>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"2\"><input type=\"file\" name=\"csa_img\"\"></TD>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" style=\"width:300\"><input type=\"text\" name=\"csa_title\" value=\"{$csa_title}\" style=\"width:300px\"></TD>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"csa_dispno\" value=\"{$csa_dispno}\" style=\"width:100px\"></TD>\n";
	$csa_new_form .= "      </TR>\n";
	$csa_new_form .= "      <TR>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"csa_contents\" rows=\"12\" cols=\"53\">{$csa_contents}</textarea></TD>\n";
	$csa_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$csa_new_form .= "        <INPUT type=\"hidden\" name=\"csa_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$csa_new_form .= "      </TR>\n";
	$csa_new_form .= "        </FORM>\n";
	$csa_new_form .= "      </TR>\n";
	$csa_new_form .= "      </table>\n";
	$csa_new_form .= "      </div>\n";

	$csa_new_form = "";
	$csa_new_form .= "        <img src=\"../share/images/leftmenu_new_button.gif\" alt=\"������򥯥�å������Ÿ��ɽ���Ǥ��ޤ�\" width=\"100\" height=\"20\" title=\"�ܺپ�︡���ǹʤ����\" />\n";
	$csa_new_form .= "        <div class=\"js_close\">\n";
//	$csa_new_form .= "          <DIV id=\"title\">����������ͳ������Ͽ</DIV>\n";
//	$csa_new_form .= "      <br>\n";
	$csa_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$csa_new_form .= "        <TR>\n";
	$csa_new_form .= "          <TD class=\"td_leftmenu_new\" style=\"width:350px\">����</TD>\n";
	$csa_new_form .= "          <TD class=\"td_leftmenu_new\" style=\"width:400px\" colspan=\"2\">&nbsp;</TD>\n";
	$csa_new_form .= "        </TR>\n";
	$csa_new_form .= "      <TR>\n";
	$csa_new_form .= "        <FORM method=\"POST\" action=\"leftmenu_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$csa_new_form .= "        <TD class=\"td_cm\" style=\"width:250\"><input type=\"radio\" name=\"csa_stat\" value=\"1\" {$csa_statFlg1}>ɽ��<input type=\"radio\" name=\"csa_stat\" value=\"9\" {$csa_statFlg2}>��ɽ��</TD>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:400;text-align:right;\" colspan=\"2\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"��������\" class=\"btn_leftmenu\" onclick=\"return LeftmenuInputCheck( this.form , this.form )\"/><input type=\"reset\" value=\"���ꥢ\" class=\"btn_leftmenu\" ></TD>\n";
	$csa_new_form .= "      </TR>\n";
	$csa_new_form .= "        <TR>\n";
	$csa_new_form .= "          <TD class=\"td_leftmenu_new\" style=\"width:350px\">����</TD>\n";
	$csa_new_form .= "          <TD class=\"td_leftmenu_new\" style=\"width:300px\">�����ȥ�</TD>\n";
	$csa_new_form .= "          <TD class=\"td_leftmenu_new\" style=\"width:100px\">ɽ����</TD>\n";
	$csa_new_form .= "        </TR>\n";
	$csa_new_form .= "      <TR>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"3\"><input type=\"file\" name=\"csa_img\"\"></TD>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" style=\"width:300\"><input type=\"text\" name=\"csa_title\" value=\"{$csa_title}\" style=\"width:300px\"></TD>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"csa_dispno\" value=\"{$csa_dispno}\" style=\"width:100px\"></TD>\n";
	$csa_new_form .= "      </TR>\n";
	$csa_new_form .= "        <TR>\n";
	$csa_new_form .= "          <TD colspan=\"2\" class=\"td_leftmenu_new\" style=\"width:400px\">����ƥ��</TD>\n";
	$csa_new_form .= "        </TR>\n";
	$csa_new_form .= "      <TR>\n";
	$csa_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"csa_contents\" rows=\"12\" cols=\"53\">{$csa_contents}</textarea></TD>\n";
	$csa_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$csa_new_form .= "        <INPUT type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />\n";
	$csa_new_form .= "        <INPUT type=\"hidden\" name=\"cs_id\" value=\"{$_POST['cs_id']}\" />\n";
	$csa_new_form .= "        <INPUT type=\"hidden\" name=\"csa_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$csa_new_form .= "        <INPUT type=\"hidden\" name=\"csa_csid\" value=\"{$_POST['cp_id']}\" />\n";
	$csa_new_form .= "      </TR>\n";
	$csa_new_form .= "        </FORM>\n";
	$csa_new_form .= "      </TR>\n";
	$csa_new_form .= "      </table>\n";
	$csa_new_form .= "      </div>\n";

	$csa_list_title = "";
	$csa_list_title .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$csa_list_title .= "        <TR>\n";
	$csa_list_title .= "          <TD class=\"td_cl\" style=\"width:350px\">����</TD>\n";
	$csa_list_title .= "          <TD class=\"td_cl\" style=\"width:400px\" colspan=\"2\">&nbsp;</TD>\n";
	$csa_list_title .= "        </TR>\n";
	$csa_list_title .= "        <TR>\n";
	$csa_list_title .= "          <TD class=\"td_cl\" style=\"width:350px\" rowspan=\"2\">����</TD>\n";
	$csa_list_title .= "          <TD class=\"td_cl\" style=\"width:300px\">�����ȥ�</TD>\n";
	$csa_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">ɽ����</TD>\n";
	$csa_list_title .= "        </TR>\n";
	$csa_list_title .= "        <TR>\n";
	$csa_list_title .= "          <TD colspan=\"2\" class=\"td_cl\" style=\"width:400px\">����ƥ��</TD>\n";
	$csa_list_title .= "        </TR>\n";

	if($intTotal==0){
		$csa_list_title .= "      <TR>\n";
		$csa_list_title .= "        <TD class=\"td_cm\" colspan=\"4\" style=\"width:750\"><br>��������Ͽ����Ƥ���ޤ���<br><br></TD>\n";
		$csa_list_title .= "      </TR>\n";
	}

	$csa_list_title .= "        </table>\n";


	for($i=0;$i<$intTotal;$i++){
		$csa_id = $obj2->leftmenudat[$i]['csa_id'];
		$csa_clid = $obj2->leftmenudat[$i]['csa_clid'];

		// ���־�������
		$csa_statFlg1 = "";
		$csa_statFlg2 = "";
		$dispnoClr = "";
		$csa_stat = $obj2->leftmenudat[$i]['csa_stat'];
		if($csa_stat == 1){
			$csa_statFlg1 = " checked";
		}else{
			$csa_statFlg2 = " checked";
			$dispnoClr = "background-color:#999999;";
		}

		// ���ƥ����������
		$cateValue = "";
		$csa_cateid = $obj2->leftmenudat[$i]['csa_cateid'];
		$obj_cate = new basedb_CategoryClassTblAccess;
		$obj_cate->conn = $obj_conn->conn;
		$obj_cate->jyoken["cg_deldate"] = 1;
		$obj_cate->jyoken["cg_stat"] = 1;
		$obj_cate->jyoken["cg_type"] = 6;
		$obj_cate->jyoken["cg_clid"] = $_SESSION['_cl_id'];
		$obj_cate->sort["cg_dispno"] = 2;
		list( $intCntCate2 , $intTotalCate2 ) = $obj_cate->basedb_GetCategory( 1 , -1 );
		IF( $intCntCate2 == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}
		for($iY=0;$iY<$intCntCate;$iY++){
			$cg_select ="";
			$category_name ="";
			$category_id ="";
			$category_name = $obj_cate->categorydat[$iY]["cg_stitle"];
			$category_id = $obj_cate->categorydat[$iY]["cg_id"];
			if($category_id == $csa_cateid && $csa_cateid!="")$cg_select = "selected";
			$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
		}

		$csa_title = $obj2->leftmenudat[$i]['csa_title'];
		$csa_img = $obj2->leftmenudat[$i]['csa_img'];
		$csa_imgorg = $obj2->leftmenudat[$i]['csa_imgorg'];
		$csa_contents = $obj2->leftmenudat[$i]['csa_contents'];
		$csa_dispno = $obj2->leftmenudat[$i]['csa_dispno'];
		$csa_adminid = $obj2->leftmenudat[$i]['csa_adminid'];
		$csa_insdate = $obj2->leftmenudat[$i]['csa_insdate'];
		$csa_upddate = $obj2->leftmenudat[$i]['csa_upddate'];
		$csa_deldate = $obj2->leftmenudat[$i]['csa_deldate'];

		// ����
		$csa_img_dir = $param_leftmenu_img_path;
		$csa_img_arr["org"] = $csa_imgorg;
		$csa_img_arr["chk_in"] = "1";
		$csa_img_arr["width"] = "150";
		$csa_img_arr["height"] = "150";
		$csa_img_txt =  form_ImgDisp( "csa_img" , $csa_img_dir , $obj2->leftmenudat[$i]["csa_img"] , "3" , $csa_img_arr );

		$viewData .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"leftmenu_upd.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\" enctype=\"multipart/form-data\">\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:350\"><input type=\"radio\" name=\"csa_stat\" value=\"1\" {$csa_statFlg1}>ɽ��<input type=\"radio\" name=\"csa_stat\" value=\"9\" {$csa_statFlg2}>��ɽ��</TD>\n";
		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:400;text-align:right;\" colspan=\"2\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"����\" class=\"btn\"  onclick=\"return LeftmenuInputCheck( this.form , this.form )\"/><INPUT type=\"button\" value=\"���\" class=\"btn\" onclick=\"document.del_leftmenu{$i}.submit();return false;\"/></TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"2\">{$csa_img_txt}</TD>\n";
//		$viewData .= "        <TD class=\"td_cm\" style=\"width:350px\"><input type=\"file\" name=\"csa_img\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:300;text-align:right;\"><input type=\"text\" name=\"csa_title\" value=\"{$csa_title}\" style=\"width:300px\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"csa_dispno\" value=\"{$csa_dispno}\" style=\"width:100px;{$dispnoClr}\"></TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        <TD class=\"td_cm\" colspan=\"2\" style=\"width:400;align:center\"><textarea name=\"csa_contents\" rows=\"12\" cols=\"53\">{$csa_contents}</textarea></TD>\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"csa_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"cs_id\" value=\"{$_POST['cs_id']}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"csa_id\" value=\"{$csa_id}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"csa_csid\" value=\"{$_POST['cp_id']}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"csa_upddate\" value=\"{$csa_upddate}\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"csa_img_lastupd\" value=\"{$csa_img}\" />\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      </table>\n";

		$viewData2 .= "<FORM name=\"del_leftmenu{$i}\" action=\"leftmenu_upd.php\" method=\"POST\">\n";

		$viewData2 .= "<INPUT type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"csa_upddate\" value=\"{$csa_upddate}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"cs_id\" value=\"{$_POST['cs_id']}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"csa_id\" value=\"{$csa_id}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />\n";

		$viewData2 .= "</FORM>\n";
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
    <TITLE>��ư���֥� - ���饤����ȥġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/leftmenu.css" />
    <SCRIPT type="text/javascript" src="../share/js/leftmenu.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/more.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><IMG src="../share/images/leftmenu_title.gif" alt="��������ͳ������Ͽ" /></TD>

        <FORM ACTION="leftmenu_select.php" METHOD="POST">
        <TD>
          <?=$csa_title_img?>
        </TD>
        </FORM>
        <FORM ACTION="leftmenu_main.php" METHOD="POST">
        <TD>
          <input type="hidden" name="cs_id" value="<?=$_POST['cs_id']?>">
          <input type="submit" value="��������ͳ�����ѥ��ƥ�����Ͽ�����" style="width:300px;" class="btn">
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <DIV id="title">����������ͳ������Ͽ</DIV>
<br>
<?=$csa_new_form?>
<br><br>
<?=$csa_list_title?>
<?=$viewData?>
<?=$viewData2?>

    <BR />
  </BODY>
</HTML>
