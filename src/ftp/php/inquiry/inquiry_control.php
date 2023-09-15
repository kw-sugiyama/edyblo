<?php

// ���饤����ȥ����å����쥤�����Ȼ���
//    => $obj_login �˻��ꥯ�饤����Ⱦ����Ǽ��
//    => _cl_id �˻��ꥯ�饤�����ID�ݻ�
//    => �쥤�����Ⱦ���ϡ����"_SITE_LAYOUT"���ݻ�
require_once( SYS_PATH."php/client_check.php" );


// �إå�����������
//    => ���̾��ɽ�����Ƥ�����
//    => �����ͤ� $arrHeaderView ���� $arrMetaHeader �˳�Ǽ
require_once( SYS_PATH."php/disp_header.php" );


// ���ƥ��꡼������������
//    => �����������ɽ�����Ƥ�����
//    => �����ͤ� $arrViewLeft �˳�Ǽ
require_once( SYS_PATH."php/disp_left.php" );


// ���ե�����ؽ񤭹��߽���
//    => ������ǥ��쥯�ȥ�ˤ���ե�����ؽ񤭹���
//    => ���ɥ쥹�� ���� �˳�Ǽ
require_once( SYS_PATH."php/disp_log_write.php" );




//---------------------------------------------------------------------------
// ���饤����Ⱦ�����Ǽ
$arrClientData = Array();
FOREACH( $obj_login->clientdat[0] as $key => $val ){
	$arrClientData[$key] = htmlspecialchars( stripslashes( $val ) );
}


//---------------------------------------------------------------------------
// POST�ͤ��Ǽ
$arrInputData = Array();
$strInputHidden = "";
FOREACH( $_POST as $key => $val ){
	$arrInputData[$key] = htmlspecialchars( stripslashes( $val ) );
	$strInputHidden .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$arrInputData[$key]}\" />\n";
}


//---------------------------------------------------------------------------
// ɽ�����̥����å�
//	$_POST["form_flg"] ... �ɤβ��̤����褿��
//	$strDispFlg        ... ����ɽ����������
//---------------------------------------------------------------------------
$strDispFlg = "";
IF( $_POST["form_flg"] == "" ){
	// ����̵���Τ�index
	$strDispFlg = "INDEX";
}ELSE{
	SWITCH( $_POST["form_flg"] ){
		Case "INDEX":
			// �������ƥ����å�
			//   => OK:$intInputChkFlg=1  NG:$intInputChkFlg=9;
			require_once( SYS_PATH."php/inquiry/inquiry_input_check.php" );
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
		
		$arrViewData = Array();
		reset( $param_inquiry_work );
		asort( $param_inquiry_work["disp_no"] );
		$intBuffCnt = 0;
		FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
			$strChk = "";
			IF( $arrInputData["work_kind"] == $param_inquiry_work["id"][$key] ) $strChk = " checked";
			IF( $intBuffCnt == 0 ){
				$arrViewData["work_kind"] .= "<tr>\n";
			}
			$arrViewData["work_kind"] .= "  <td class=\"noborder\">";
			$arrViewData["work_kind"] .= "<INPUT id=\"{$param_inquiry_work["val"][$key]}\" type=\"radio\" name=\"work_kind\" value=\"{$param_inquiry_work["id"][$key]}\" {$strChk}/>";
			$arrViewData["work_kind"] .= "<label for=\"{$param_inquiry_work["val"][$key]}\">{$param_inquiry_work["val"][$key]}</label>";
			$arrViewData["work_kind"] .= "</td>\n";
			$intBuffCnt++;
			IF( $intBuffCnt == 4 ){
				$arrViewData["work_kind"] .= "</tr>\n";
				$intBuffCnt = 0;
			}
		}
		IF( $intBuffCnt != 4 ){
			FOR( $iX=$intBuffCnt; $iX<4; $iX++ ){
				$arrViewData["work_kind"] .= "  <td class=\"noborder\">&nbsp;</td>\n";
			}
			$arrViewData["work_kind"] .= "</tr>\n";
		}
		
		IF( $arrInputData["sex"] == 1 ){
			$arrViewData["sex"][1] = " checked";
		}ELSEIF( $arrInputData["sex"] == 2 ){
			$arrViewData["sex"][2] = " checked";
		}
		IF( $arrInputData["report_type_1"] == 1 ) $arrViewData["report_type_1"] = " checked";
		IF( $arrInputData["report_type_2"] == 2 ) $arrViewData["report_type_2"] = " checked";
		IF( $arrInputData["report_type_3"] == 3 ) $arrViewData["report_type_3"] = " checked";
		IF( $arrInputData["report_type_4"] == 4 ) $arrViewData["report_type_4"] = " checked";
		
		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/inquiry/inquiry_index.tpl" );
		break;
		
	// ��ǧ����
	Case "CONFIRM":
		
		// ɽ����������
		$arrViewData["contents"] = nl2br( $arrInputData["contents"] );
		$arrViewData["name_kj"] = $arrInputData["name_kj_1"]."��".$arrInputData["name_kj_2"];
		$arrViewData["name_kn"] = $arrInputData["name_kn_1"]."��".$arrInputData["name_kn_2"];
		IF( $arrInputData["sex"] == 1 ){
			$arrViewData["sex"] = "����";
		}ELSEIF( $arrInputData["sex"] == 2 ){
			$arrViewData["sex"] = "����";
		}
		IF( $arrInputData["old"] != "" ){
			$arrViewData["old"] = $arrInputData["old"]." ��";
		}
		FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
			IF( $arrInputData["work_kind"] == $param_inquiry_work["id"][$key] ){
				$arrViewData["work_kind"] = $param_inquiry_work["val"][$key];
				break;
			}
		}
		IF( $arrInputData["report_type_1"] == 1 ){
			$arrViewData["tell"] = "";
			$arrViewData["tell"] .= $arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"];
			$arrViewData["tell"] .= "&nbsp;��Ϣ����˾�λ�����:".$arrInputData["tell_time"]."\n";
		}
		IF( $arrInputData["report_type_2"] == 2 ){
			$arrViewData["fax"] = "";
			$arrViewData["fax"] .= $arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"];
		}
		IF( $arrInputData["report_type_3"] == 3 ){
			$arrViewData["addr"] = "";
			$arrViewData["addr"] .= "��".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."&nbsp;";
			$arrViewData["addr"] .= $arrInputData["address_1"]."��".$arrInputData["address_2"];
		}
		IF( $arrInputData["report_type_4"] == 4 ){
			$arrViewData["email"] = "";
			$arrViewData["email"] .= $arrInputData["email"];
		}
		
		// ��λ�ڡ����ǤΥڡ������������ػ���
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		$_SESSION["mst"] = $strBuffMst;
		$arrViewData["mst"] = $strBuffMst;
		
		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/inquiry/inquiry_confirm.tpl" );
		break;
		
	Case "COMMIT":
		
		// �ڡ������������ػ���
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		IF( $_SESSION["mst"] != $_POST["mst"] ){
			$arrErr["ath_comment"] = "����礻�᡼�����������Ƥ���ޤ���";
			$obj_error->ViewErrMessage( "NO_RELOAD" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}
		
		// ����礻�᡼������
		require_once( SYS_PATH."php/inquiry/inquiry_send_mail.php" );
		
		// �ڡ������������ػ���
		$_SESSION["mst"] = $strBuffMst;
		
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
		require_once( SYS_PATH."templates/inquiry/inquiry_commit.tpl" );
		break;
}





?>
