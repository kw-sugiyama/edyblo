<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: room_main.php
	Version: 1.0.0
	Function: �����������
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_BuildClass.php" );
require_once ( SYS_PATH."dbif/basedb_RoomClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );


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
  ��ʪ���� - ������ʬ
	build_id       ... ���ꤵ�줿��ʪ����ɣ�
	build_del_date ... �������Ƥ��ʤ�
--------------------------------------------------------*/
$obj_build = new basedb_BuildClassTblAccess();
$obj_build->conn = $obj_conn->conn;
$obj_build->jyoken["build_id"] = $_POST["room_build_id"];
$obj_build->jyoken["build_del_date"] = 1;
list( $intCnt_build , $intTotal_build ) = $obj_build->basedb_GetBuild( 1 , -1 );
IF( $intCnt_build != 1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."build/build_main.php" , $arrOther );
	exit;
}
$strViewBuildName = htmlspecialchars($obj_build->builddat[0]["build_name"]);


/*--------------------------------------------------------
  �������� - ������ʬ
--------------------------------------------------------*/
IF( $_POST["room_stpos"] != "" ){
	$intStPos = intval($_POST["room_stpos"]);
}ELSE{
	$intStPos = 1;
}
$intGetNum = 10;

$obj = new basedb_RoomClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["room_del_date"] = 1;
$obj->jyoken["room_build_id"] = $_POST['room_build_id'];
$obj->sort["room_upd_date"] = 1;
list( $intCnt , $intTotal ) = $obj->basedb_GetRoom( $intStPos , $intGetNum );
IF( $intCnt == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."build/build_main.php" , $arrOther );
	exit;
}
$viewData = "";
IF( $intCnt == 0 ){
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD colspan=\"5\" class=\"td_cm\">����������������Ϥ���ޤ���</TD>\n";
	$viewData .= "      </TR>\n";
}
FOR( $i=0; $i<$intCnt; $i++){	
	$room_biko_2 = htmlspecialchars( $obj->roomdat[$i]["room_biko_2"] );
	$room_biko_3 = htmlspecialchars( $obj->roomdat[$i]["room_biko_3"] );
	$room_id = htmlspecialchars( $obj->roomdat[$i]["room_id"] );
	$room_id = htmlspecialchars( $obj->roomdat[$i]["room_id"] );
	$room_code = htmlspecialchars( $obj->roomdat[$i]["room_code"] );
	$room_madori = htmlspecialchars( $obj->roomdat[$i]["room_madori"] );
	$room_price = htmlspecialchars ($obj->roomdat[$i]["room_price"]);
	
	if($room_biko_2==1){
		$room_biko_2_val = "ɽ��";
	}else if($room_biko_3==9){
		$room_biko_2_val = "��ɽ��";
	}
	if($room_biko_3==1){
		$room_biko_3_val = "ɽ��";
	}else if($room_biko_3==9){
		$room_biko_3_val = "��ɽ��";
	}
	asort( $param_room_floor["disp_no"] );
	$madori_value = "";
	FOREACH( $param_room_floor["disp_no"] as $key => $val ){
		$selected = "";
		if($param_room_floor['id'][$key] == $room_madori)$madori_value = $param_room_floor['val'][$key];	
	}

	$viewData .= "      <TR>\n";
	$viewData .= "        <FORM name=\"go_edit_{$i}\" method=\"POST\" action=\"room_mnt.php\" target=\"_self\">\n";
	$viewData .= "        <TD class=\"td_cm\">{$room_biko_3_val}</TD>\n";
	$viewData .= "        <TD class=\"td_cm\">{$room_biko_2_val}</TD>\n";
	$viewData .= "        <TD class=\"td_cm\">{$room_code}</TD>\n";
	$viewData .= "        <TD class=\"td_cm\">{$madori_value}</TD>\n";
	$viewData .= "        <TD class=\"td_cm\">{$room_price}</TD>\n";
	$viewData .= "        <TD class=\"td_cm\"><INPUT type=\"submit\" name=\"go_mnt_2\" value=\"����\" class=\"btn\" /></TD>\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"room_build_id\" value=\"{$_POST['room_build_id']}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"room_id\" value=\"{$room_id}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"room_stpos\" value=\"{$_POST['room_stpos']}\" />\n";
	$viewData .= "        </FORM>\n";
	$viewData .= "        <FORM name=\"go_copy_{$i}\" method=\"POST\" action=\"room_upd.php\" target=\"_self\">\n";
	$viewData .= "        <TD class=\"td_cm\"><INPUT type=\"button\" name=\"go_copy\" value=\"ʣ��\" class=\"btn\" onClick=\"return RoomCopyCheck( this.form );\"/></TD>\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"COPY\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"room_build_id\" value=\"{$_POST['room_build_id']}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"room_id\" value=\"{$room_id}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"room_stpos\" value=\"{$_POST['room_stpos']}\" />\n";
	$viewData .= "        </FORM>\n";
	$viewData .= "      </TR>\n";
}


/*----------------------------------------------------------
   �ڡ���������
----------------------------------------------------------*/
$intPageNum = $intTotal / $intGetNum;
IF( !strpos( $intPageNum , "." ) ){
	$intPageNum = (int)$intPageNum;
}ELSE{
	$intPageNum = (int)$intPageNum + 1;
}
$intEdPos = $intGetNum + $intStPos - 1;
IF( $intEdPos > $intTotal ) $intEdPos = $intTotal;
$viewPageChangeValue = basecom_page_change_VAL( $intCnt , $intTotal , $intGetNum , $intStPos , $intCnt , $intPageNum , "room_page" , "room_stpos" , "btn_nosize" );


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
	�ȣԣͣ�����
--------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>��ư���֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/room.css" />
    <SCRIPT type="text/javascript" src="../share/js/room.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/room_title.gif" alt="��������" />
    <HR color="#96BC69" />
    <TABLE>
      <TR>
        <form method="POST" action="../build/build_main.php" name="room_back">
        <TD>
          <INPUT type="submit" value="��ʪ������������" class="btn_nosize" />
          <INPUT type="hidden" name="room_build_id" value="<?=$_POST['room_build_id']?>" />
          <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <TABLE width="700">
      <TR>
        <TD class="td_cl_nosize" style="width:130px">���򤵤줿��ʪ̾</TD>
        <TD class="td_cm"><?=$strViewBuildName?></TD>
      </TR>
    </TABLE>
    <BR>
    <TABLE>
      <TR>
        <FORM action="room_mnt.php" method="POST" name="room_new">
        <TD>
          <INPUT type="submit" name="new" value="����������ɲä���" class="btn_nosize" />
          <INPUT type="hidden" name="mode" value="NEW" />
          <INPUT type="hidden" name="room_build_id" value="<?=$_POST['room_build_id']?>" />
          <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
          <INPUT type="hidden" name="room_stpos" value="<?=$_POST['room_stpos']?>" />
        </TD>
        </FORM>
      </TR>
      <TR>
        <TD colspan="2">
          <FONT class="comment">
            ����ʣ���פ򥯥�å������Ʊ�����������ɲä���ޤ����ֽ����פ򥯥�å��������������Ƥ��ѹ����Ʋ�������
          </FONT>
	</TD>
      </TR>
    </TABLE>
    <TABLE width="700">
      <TR>
        <TD class="td_cl_nosize" width="300">����ɽ��</TD>
        <TD class="td_cl_nosize" width="300">�ݡ�����ɽ��</TD>
        <TD class="td_cl_nosize" width="300">����������</TD>
        <TD class="td_cl_nosize" width="150">�ּ�</TD>
        <TD class="td_cl_nosize" width="150">����</TD>
        <TD class="td_cl_nosize" width="50">&nbsp;</TD>
        <TD class="td_cl_nosize" width="50">&nbsp;</TD>
      </TR>
<?=$viewData?>
    </TABLE>
    <BR />
    <TABLE border="0" cellspacing="0" cellpadding="2" width="700" class="px12">
      <TR>
        <FORM name="room_page" method="POST" action="room_main.php">
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        <INPUT type="hidden" name="room_stpos" value="" />
        <INPUT type="hidden" name="room_build_id" value="<?=$_POST['room_build_id']?>" />
<?=$viewPageChangeValue?>
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
