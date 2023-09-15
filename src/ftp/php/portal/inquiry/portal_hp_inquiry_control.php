<?php

// ��¦������ʬ
//    => �����ͤ� $arrViewLeft �˳�Ǽ
//require_once( SYS_PATH."php/portal/disp_portal_left_menu.php" );
require_once( SYS_PATH."php/portal/disp_portal_right_menu.php" );


//---------------------------------------------------------------------------
// POST�ͤ��Ǽ
$arrInputData = Array();
$strInputHidden = "";
FOREACH( $_POST as $key => $val ){
	$arrInputData[$key] = htmlspecialchars( stripslashes( $val ) );
	$strInputHidden .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$arrInputData[$key]}\">\n";
	IF( is_array($val) ){
		FOREACH( $val as $key2 => $val2 ){
			$arrInputData[$key][$key2] = htmlspecialchars( stripslashes( $val2 ) );
			$strInputHidden .= "<input type=\"hidden\" name=\"{$key}[{$key2}]\" value=\"{$arrInputData[$key][$key2]}\">\n";
		}
	}
}


//---------------------------------------------------------------------------
// ɽ�����̥����å�
//	$_POST["form_flg"] ... �ɤβ��̤����褿��
//	$strDispFlg        ... ����ɽ����������
//---------------------------------------------------------------------------
$strDispFlg = "";
IF( $_GET["form_flg"] == "" ){
	// ����̵���Τ�index
	$strDispFlg = "INDEX";
}ELSE{
	SWITCH( $_GET["form_flg"] ){
		Case "INDEX":
			// �������ƥ����å�
			//   => OK:$intInputChkFlg=1  NG:$intInputChkFlg=9;
			require_once( SYS_PATH."php/portal/inquiry/portal_hp_inquiry_input_check.php" );
			$intInputChkFlg = 1;
			IF( $intInputChkFlg == 1 ){
				$strDispFlg = "CONFIRM";
			}ELSE{
				$strDispFlg = "INDEX";
			}
			break;
		Case "CONFIRM":
			$strDispFlg = "COMMIT";
			break;
	}
}


//---------------------------------------------------------------------------
// $strDispFlg �ˤ�ä�ɽ�����Ʒ���
$arrViewData = Array();
SWITCH( $strDispFlg ){
	// ���ϲ��� => �ƥ�ץ졼��ɽ���Τ�
	default:
	Case "INDEX":
		/*==============================================================
		    TOP�ڡ���ɽ�����������ե�����
		==============================================================*/
		//title
		$view_header_title = '';
		$view_header_title = '�Υ�����ˤĤ��ƤΤ���礻�óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
		//keywords
		$view_header_keywoeds = '';
		$view_header_keywoeds = '�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����,��Ω,��Ω,����礻';
		//description
		$view_header_description = '';
		$view_header_description = '�Υ��������礻�ڡ����Ǥ����Υ�����ˤĤ��ƤΤ���礻�Ϥ������餫��ɤ�����';
		$view_header_description .= '�Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ���';


		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/portal/inquiry/portal_hp_inquiry_index.tpl" );
		break;
		
	// ��ǧ����
	Case "CONFIRM":
		/*==============================================================
		    TOP�ڡ���ɽ�����������ե�����
		==============================================================*/
		//title
		$view_header_title = '';
		$view_header_title = '����礻���Ƥγ�ǧ�óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
		//keywords
		$view_header_keywoeds = '';
		$view_header_keywoeds = '�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����,��Ω,��Ω,����礻';
		//description
		$view_header_description = '';
		$view_header_description = '�Υ��������礻��ǧ�ڡ����Ǥ���';
		$view_header_description .= '�Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ���';

		// ɽ����������
		$arrViewData["email"]		= $arrInputData["email"];			// �᡼�륢�ɥ쥹
		$arrViewData["subject"]		= $arrInputData["subject"];			// ��̾
		$arrViewData["contents"]	= nl2br( $arrInputData["contents"] );		// ��ʸ

		// ��λ�ڡ����ǤΥڡ������������ػ���
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		$_SESSION["mst_hp"] = $strBuffMst;
		$arrViewData["mst_hp"] = $strBuffMst;

		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/portal/inquiry/portal_hp_inquiry_confirm.tpl" );
		break;

	Case "COMMIT":
		/*==============================================================
		    TOP�ڡ���ɽ�����������ե�����
		==============================================================*/
		//title
		$view_header_title = '';
		$view_header_title = '����礻��λ�óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
		//keywords
		$view_header_keywoeds = '';
		$view_header_keywoeds = '�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����,��Ω,��Ω,����礻';
		//description
		$view_header_description = '';
		$view_header_description = '�Υ��������礻��λ�ڡ����Ǥ���';
		$view_header_description .= '�Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ���';

		// �ڡ������������ػ���
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		IF( $_SESSION["mst_hp"] != $_POST["mst_hp"] ){
			$arrErr["ath_comment"] = "����礻�᡼�����������Ƥ���ޤ���";
			$obj_error->ViewErrMessage( "NO_RELOAD" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}

		// ����礻�᡼������
		require_once( SYS_PATH."php/portal/inquiry/portal_hp_inquiry_send_mail.php" );

		// �ڡ������������ػ���
		$_SESSION["mst_hp"] = $strBuffMst;

		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/portal/inquiry/portal_hp_inquiry_commit.tpl" );
		break;
}

?>