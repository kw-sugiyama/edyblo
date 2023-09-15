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
			require_once( SYS_PATH."php/portal/inquiry/portal_juku_inquiry_input_check.php" );
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
SWITCH( $strDispFlg ){
	// ���ϲ��� => �ƥ�ץ졼��ɽ���Τ�
	default:
	Case "INDEX":
		/*==============================================================
		    TOP�ڡ���ɽ�����������ե�����
		==============================================================*/
		//title
		$view_header_title = '';
		$view_header_title = '�ۡ���ڡ�������������ǺܤˤĤ��ƤΤ���礻�óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
		//keywords
		$view_header_keywoeds = '';
		$view_header_keywoeds = '�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����,����礻,�ۡ���ڡ�������,�ݡ�����,�Ǻ�';
		//description
		$view_header_description = '';
		$view_header_description = '�Υ��������礻�ڡ����Ǥ����ۡ���ڡ�������������ǺܤˤĤ��ƤΤ���礻�Ϥ������餫��ɤ�����';
		$view_header_description .= '�Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ���';

		$arrViewData = Array();
		
		IF( $arrInputData["title"][0] == 1 ){
			$arrViewData["title"][0] = " checked";
		}
		IF( $arrInputData["title"][1] == 1 ){
			$arrViewData["title"][1] = " checked";
		}
		IF( $arrInputData["title"][2] == 1 ){
			$arrViewData["title"][2] = " checked";
		}
		IF( $arrInputData["title"][3] == 1 ){
			$arrViewData["title"][3] = " checked";
		}

		IF( $arrInputData["device"][0] == 1 ){
			$arrViewData["device"][0] = " checked";
		}
		IF( $arrInputData["device"][1] == 1 ){
			$arrViewData["device"][1] = " checked";
		}
		IF( $arrInputData["device"][2] == 1 ){
			$arrViewData["device"][2] = " checked";
		}
		IF( $arrInputData["device"][3] == 1 ){
			$arrViewData["device"][3] = " checked";
		}

		// ���򤷤�����Select��������֤�
		$arrPrefSel = array();
		IF( $arrInputData["pref"] != ""){
			for ($ix=1;$ix<=47;$ix++){
				IF( $arrInputData["pref"] == $ix){
					$arrPrefSel[$ix] = "selected";
				}
			}
		}
		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/portal/inquiry/portal_juku_inquiry_index.tpl" );
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
		$arrViewData["contents"] = nl2br( $arrInputData["contents"] );
		$arrViewData["name_kj"] = $arrInputData["name_kj_1"]."��".$arrInputData["name_kj_2"];
		$arrViewData["name_kn"] = $arrInputData["name_kn_1"]."��".$arrInputData["name_kn_2"];

		IF( $arrInputData["title"][0] == 1 ){
			$arrViewData["title"] .= "�Υ�����ηǺܤˤĤ���\n";
		}
		IF( $arrInputData["title"][1] == 1 ){
			IF($arrViewData["title"]!="")$arrViewData["title"] .= "<BR>";
			$arrViewData["title"] .= "�Хʡ����������ηǺܤˤĤ���\n";
		}
		IF( $arrInputData["title"][2] == 1 ){
			IF($arrViewData["title"]!="")$arrViewData["title"] .= "<BR>";
			$arrViewData["title"] .= "�ۡ���ڡ��������ˤĤ���\n";
		}
		IF( $arrInputData["title"][3] == 1 ){
			IF($arrViewData["title"]!="")$arrViewData["title"] .= "<BR>";
			$arrViewData["title"] .= "����¾\n";
		}

		IF( $arrInputData["device"][0] == 1 ){
			$arrViewData["device"] .= "���������դ����ߤ���\n";
		}
		IF( $arrInputData["device"][1] == 1 ){
			IF($arrViewData["device"]!="")$arrViewData["device"] .= "<BR>";
			$arrViewData["device"] .= "�ܺ٤��Τꤿ���Τ����ä����ߤ���\n";
		}
		IF( $arrInputData["device"][2] == 1 ){
			IF($arrViewData["device"]!="")$arrViewData["device"] .= "<BR>";
			$arrViewData["device"] .= "�ܺ٤��Τꤿ���Τ���Ҥ����ߤ���\n";
		}
		IF( $arrInputData["device"][3] == 1 ){
			IF($arrViewData["device"]!="")$arrViewData["device"] .= "<BR>";
			$arrViewData["device"] .= "�������Ƥ��������ߤ���\n";
		}
		IF( $arrInputData["addr_cd_1"] != "" && $arrInputData["addr_cd_2"] != "" && $arrInputData["pref"] != 0 && $arrInputData["address_1"] !="" ){
			$arrViewData["addr_cd"] .= "��".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."\n";
			$arrViewData["pref"] .= $psel[$arrInputData["pref"]];
			$arrViewData["addr"] .= $arrInputData["address_1"].$arrInputData["address_2"]."\n";
		}

		IF( $arrInputData["tell_1"] != "" && $arrInputData["tell_2"] != "" && $arrInputData["tell_3"] != "" ){
			$arrViewData["tell"] .= $arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"]."\n";
		}
		IF( $arrInputData["fax_1"] != "" && $arrInputData["fax_2"] != "" && $arrInputData["fax_3"] != "" ){
			$arrViewData["fax"] .= $arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"]."\n";
		}
		
		// ��λ�ڡ����ǤΥڡ������������ػ���
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		$_SESSION["mst_juku"] = $strBuffMst;
		$arrViewData["mst_juku"] = $strBuffMst;
		
		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/portal/inquiry/portal_juku_inquiry_confirm.tpl" );
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
		IF( $_SESSION["mst_juku"] != $_POST["mst_juku"] ){
			$arrErr["ath_comment"] = "����礻�᡼�����������Ƥ���ޤ���";
			$obj_error->ViewErrMessage( "NO_RELOAD" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}

		// ɽ����������
		$arrViewData["name_kj"] = $arrInputData["name_kj_1"]."��".$arrInputData["name_kj_2"];
		$arrViewData["name_kn"] = $arrInputData["name_kn_1"]."��".$arrInputData["name_kn_2"];

		IF( $arrInputData["title"][0] == 1 ){
			$arrViewData["title"] .= "�Υ�����ηǺܤˤĤ���\n";
		}
		IF( $arrInputData["title"][1] == 1 ){
			$arrViewData["title"] .= "�Хʡ����������ηǺܤˤĤ���\n";
		}
		IF( $arrInputData["title"][2] == 1 ){
			$arrViewData["title"] .= "�ۡ���ڡ��������ˤĤ���\n";
		}
		IF( $arrInputData["title"][3] == 1 ){
			$arrViewData["title"] .= "����¾\n";
		}

		IF( $arrInputData["device"][0] == 1 ){
			$arrViewData["device"] .= "���������դ����ߤ���\n";
		}
		IF( $arrInputData["device"][1] == 1 ){
			$arrViewData["device"] .= "�ܺ٤��Τꤿ���Τ����ä����ߤ���\n";
		}
		IF( $arrInputData["device"][2] == 1 ){
			$arrViewData["device"] .= "�ܺ٤��Τꤿ���Τ���Ҥ����ߤ���\n";
		}
		IF( $arrInputData["device"][3] == 1 ){
			$arrViewData["device"] .= "�������Ƥ��������ߤ���\n";
		}

		// ����礻�᡼������
		require_once( SYS_PATH."php/portal/inquiry/portal_juku_inquiry_send_mail.php" );

		// �ڡ������������ػ���
		$_SESSION["mst_juku"] = $strBuffMst;
		
		// ɽ����������
		$arrVD = Array();
		$arrVD["company_name"] = $obj_login->clientdat[0]["cl_name"]." ".$obj_login->clientdat[0]["cl_shiten"];
		$arrVD["company_address"] = $obj_login->clientdat[0]["cl_pref"].$obj_login->clientdat[0]["cl_address1"].$obj_login->clientdat[0]["cl_address2"]."��".$obj_login->clientdat[0]["cl_address3"];
		$arrVD["company_tell"] = $obj_login->clientdat[0]["cl_tell"];
		$arrVD["company_fax"] = $obj_login->clientdat[0]["cl_fax"];
		$arrVD["company_time"] = $obj_login->clientdat[0]["blog_start_time"]."��".$obj_login->clientdat[0]["blog_end_time"];
		$arrVD["company_holiday"] = $obj_login->clientdat[0]["blog_holiday"];
		$arrVD["company_build_no"] = $obj_login->clientdat[0]["blog_cl_build_no"];
		$arrViewData = Array();
		FOREACH( $arrVD as $key => $val ){
			$arrViewData[$key] = htmlspecialchars( stripslashes( $val ) );
		}
		
		
		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/portal/inquiry/portal_juku_inquiry_commit.tpl" );
		break;
}

?>