<?
/******************************************************************************
	�ե꡼��ɸ�����ʸ���󹹿��Хå�����
******************************************************************************/

/*
echo'<PRE>';
print_r($_SESSION);
print_r($_POST);
echo'</PRE>';
*/

/*---------------------------------------------------------
	�ե꡼����Ѿ�������
	&���夤�Ƥ���Τϻ����Ϥ�
---------------------------------------------------------*/
function fn_create_freeword( $p_conn , $p_cl_id , &$p_cl_yobi1 , $p_cl_jname , $p_cl_kname) {
	$p_cl_yobi1 = '';

	// ������������
	//  �֥����ܾ�����Ͽ
	$obj_blog = new basedb_SchoolClassTblAccess;
	$obj_blog->conn = $p_conn;
	$obj_blog->jyoken["sc_clid"] = $p_cl_id;		// ���饤�����ID
	list( $intCnt , $intTotal ) = $obj_blog->basedb_GetSchool( 0 , -1 );
	if( $intCnt == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= $athComment;
	        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "" , $arrOther );
	        exit;
	}

	// ���ꥢ��������
	$obj_area = new basedb_AreaClassTblAccess;
	$obj_area->conn = $p_conn;
	$obj_area->jyoken["ar_clid"]	= $p_cl_id;	// ���饤�����ID
	$obj_area->sort['ar_flg']	= 2;			// �оݥ��ꥢ��
	list( $intCnt , $intTotal ) = $obj_area->basedb_GetArea( 0 , -1 );
	if( $intCnt == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= $athComment;
	        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "" , $arrOther );
	        exit;
	}

	// ������������
	$obj_ensen = new basedb_EnsenClassTblAccess;
	$obj_ensen->conn = $p_conn;
	//$obj_ensen->jyoken["es_cd"]	= $obj_blog->blogdat[0]['sc_id'];	// ����ID
	$obj_ensen->jyoken["es_cd"]	= $p_cl_id;	// ���饤�����ID
	$obj_ensen->jyoken["es_dispno"]	= 1;					// ɽ����=1
	list( $intCnt , $intTotal ) = $obj_ensen->basedb_GetEnsen( 0 , -1 );
				
	//print_r($obj_blog->blogdat);
	//print_r($obj_area->areadat);
	//print_r($obj_ensen->ensendat);
	// ��̾
	$str = $p_cl_jname;
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ����̾
	$str = $p_cl_kname;
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ��̾+����̾
	$str = $p_cl_jname . $p_cl_kname;
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ���ꥢ���� $obj_area->areadat�˶������ꡢ���ꥢ1��3��4�쥳�����֤äƤ���
	FOREACH($obj_area->areadat as $key => $val ){

		// ͹���ֹ� ���쥳���ɤ˥ϥ��ե����äƤ�Τǲ���
		$str = $val["ar_zip"];
		if($str!="" and $str!="-")$p_cl_yobi1 .= $str . '/';
		// ��ƻ�ܸ�̾
		$str = $val["ar_pref"];
		if($str!="")$p_cl_yobi1 .= $str . '/';
		// �Զ�Į¼̾
		$str = $val["ar_city"];
		if($str!="")$p_cl_yobi1 .= $str . '/';
		// $key=0(�ǽ�Υ쥳����)=�Τν��� �ξ��Τ� ���� ��ʪ̾
		if ($key == 0) {
			// ����
			$str = $val["ar_add"];
			if($str!="")$p_cl_yobi1 .= $str . '/';
			// ��ʪ̾
			$str = $val["ar_estate"];
			if($str!="")$p_cl_yobi1 .= $str . '/';

			// ��ƻ�ܸ�̾+�Զ�Į¼̾+����+��ʪ̾
			$buff_add_str = '';
			$buff_add_str = $val["ar_pref"] . $val["ar_city"] . $val["ar_add"] . $val["ar_estate"];
		} else {
			// ��ƻ�ܸ�̾+�Զ�Į¼̾
			$buff_add_str = '';
			$buff_add_str = $val["ar_pref"] . $val["ar_city"];
		}
		if($buff_add_str!="") $p_cl_yobi1 .= $buff_add_str . '/';
	}

	// �֥��Ҳ�ʸ
	$str = $obj_blog->blogdat[0]["sc_introduce"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ���Ĳ��
	$str = $obj_blog->blogdat[0]["sc_company"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP������ɥ������ȥ�
	$str = $obj_blog->blogdat[0]["sc_topwindowtitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// �إå����ѥ����ȥ�
	$str = $obj_blog->blogdat[0]["sc_headertitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP�������󥿥��ȥ�
	$str = $obj_blog->blogdat[0]["sc_toptitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP�������󥵥֥����ȥ�
	$str = $obj_blog->blogdat[0]["sc_topsubtitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP�����ڡ��󥤥٥��
	$str = $obj_blog->blogdat[0]["sc_campaintitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP���������󥿥��ȥ�
	$str = $obj_blog->blogdat[0]["sc_coursetitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP�������󥿥��ȥ�
	$str = $obj_blog->blogdat[0]["sc_diarytitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ��������ʸ
	$str = $obj_blog->blogdat[0]["sc_addmission"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// �оݳ�ǯ
	$sc_age = htmlspecialchars ($obj_blog->blogdat[0]["sc_age"]);
	if(($sc_age & 64) == 64 ){
		$p_cl_yobi1 .= "�Ҳ��" . '/';
		$sc_age -= 64;
	}
	if(($sc_age & 32) == 32 ){
		$p_cl_yobi1 .= "�����" . '/';
		$sc_age -= 32;
	}
	if(($sc_age & 16) == 16 ){
		$p_cl_yobi1 .= "ϲ����" . '/';
		$sc_age -= 16;
	}
	if(($sc_age & 8) == 8 ){
		$p_cl_yobi1 .= "�⹻��" . '/';
		$sc_age -= 8;
	}
	if(($sc_age & 4) == 4 ){
		$p_cl_yobi1 .= "�����" . '/';
		$sc_age -= 4;
	}
	if(($sc_age & 2) == 2 ){
		$p_cl_yobi1 .= "������" . '/';
		$sc_age -= 2;
	}
	if(($sc_age & 1) == 1 ){
		$p_cl_yobi1 .= "�Ļ�" . '/';
		$sc_age -= 1;
	}

	// ���ȷ���
	$sc_classform = htmlspecialchars ($obj_blog->blogdat[0]["sc_classform"]);
	if(($sc_classform & 4) == 4 ){
		$p_cl_yobi1 .= "����" . '/';
		$sc_classform -= 4;
	}
	if(($sc_classform & 2) == 2 ){
		$p_cl_yobi1 .= "���Ϳ�" . '/';
		$sc_classform -= 2;
	}
	if(($sc_classform & 1) == 1 ){
		$p_cl_yobi1 .= "����" . '/';
		$sc_age -= 1;
	}

	// �Ǵ����̾
	$str = $obj_ensen->ensendat[0]["es_line"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// �Ǵ��̾
	$str = $obj_ensen->ensendat[0]["es_sta"];
	if($str!="")$p_cl_yobi1 .= $str . '��' . '/';

	// ����
	$str = $obj_ensen->ensendat[0]["es_walk"];
	if($str!="")$p_cl_yobi1 .= '����' . $str . 'ʬ' . '/';

	// �Х�
	$str = $obj_ensen->ensendat[0]["es_bus"];
	if($str!="")$p_cl_yobi1 .= '�Х�' . $str . 'ʬ' . '/';

	// ����PRʸ
	$str = $obj_blog->blogdat[0]["sc_pr"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// �Ǹ��Ƭ�˥���å����Ĥ��� (������ʤ����)
	if ($p_cl_yobi1 != "") $p_cl_yobi1 = '/' . $p_cl_yobi1;

}
// �ե꡼����Ѿ�������--END


/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
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



//echo("#".$_POST["cl_upddate"]."#");
/*----------------------------------------------------------
  ���顼��HIDDEN������
----------------------------------------------------------*/
$strErrHidden = "";
$strErrHidden .= "<INPUT type=\"hidden\" name=\"err_mode\" value=\"ERR\">\n";
FOREACH( $_POST as $key => $val ){
	
	$arrPostView[$key] = htmlspecialchars( stripslashes( $val ) );
	
	$buffData_err = "";
	$buffData_err = htmlspecialchars( stripslashes( $val ) );
	$strErrHidden .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$buffData_err}\">\n";
}

// �����饤����Ⱦ�������
$obj_Client = new basedb_ClientClassTblAccess;
$obj_Client->conn = $obj_conn->conn;
$obj_Client->jyoken["cl_deldate"]	= 0;	// cl_deldate�ξ�����̵��
$obj_Client->sort["cl_id"]		= 2;	// cl_id��

list( $intCnt , $intTotal ) = $obj_Client->basedb_GetClient( 0 , -1 );
if( $intCnt == -1 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= $athComment;
        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "" , $arrOther );
        exit;
}

// ���饹���Ϥ��Ѥ��������
$arr_updrec = array();
FOREACH($obj_Client->clientdat as $key => $val ){
	// ���饤����Ⱦ���Υե꡼��ɸ����ѥե�����ɤ򹹿�
	// �ե꡼��ɸ�����ʸ���������
	fn_create_freeword($obj_conn->conn , $val["cl_id"] , $cl_yobi1 , $val["cl_jname"] , $val["cl_kname"]);
	
	$arr_updrec[$key]["cl_id"]	= $val["cl_id"];	// ���饤�����ID
	$arr_updrec[$key]["cl_upddate"]	= $val["cl_upddate"];	// ��������
	$arr_updrec[$key]["cl_yobi1"]	= $cl_yobi1;		// �ե꡼��ɸ�����ʸ����
}
//print_r($arr_updrec);
//exit;

$obj_batch = new basedb_ClientClassTblAccess;
$obj_batch->conn = $obj_conn->conn;
$obj_batch->clientdat[0]["arr_updrec"]	= $arr_updrec;

$suc = $obj_batch->basedb_UpdClient_freeword_batch();
switch( $suc ){
	case "-1":
		$arrErr["ath_comment"] = $strErrHidden;
		$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "" , $arrErr );
		exit;
	case "1":
		$arrErr["ath_comment"] = $strErrHidden;
		$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "" , $arrErr );
		exit;
}

$message = "����˹������ޤ�����";

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
    <TITLE>�Υ֥� - ��������ȴ����ġ��� - �ե꡼��ɸ�����ʸ������Ͽ�Хå�����</title>
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
      <form name="form1" action="client_main.php" method="POST"> 
        <INPUT type="hidden" name="stpos" value="<?=$arrPostView['stpos']?>" />
        <INPUT type="hidden" name="sea_cl_name_like" value="<?=$arrPostView['sea_cl_name_like']?>" />
        <INPUT type="hidden" name="sea_cl_pref" value="<?=$arrPostView['sea_cl_pref']?>" />
        <INPUT type="hidden" name="sea_cl_stat" value="<?=$arrPostView['sea_cl_stat']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_y" value="<?=$arrPostView['sea_cl_limit_date_s_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_m" value="<?=$arrPostView['sea_cl_limit_date_s_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_d" value="<?=$arrPostView['sea_cl_limit_date_s_d']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_y" value="<?=$arrPostView['sea_cl_limit_date_e_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_m" value="<?=$arrPostView['sea_cl_limit_date_e_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_d" value="<?=$arrPostView['sea_cl_limit_date_e_d']?>" />
	<INPUT type="hidden" name="search_flg" value="<?=$arrPostView['search_flg']?>" />
        <input type="submit" value=" �� �� " class="btn" />
      </form>
    </div>
  </body>
</html>
