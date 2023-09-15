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
	IF( is_array( $val ) === TRUE ){
		FOREACH( $val as $key2 => $val2 ){
			$arrInputData[$key][] = htmlspecialchars( stripslashes( $val2 ) );
			$strInputHidden .= "<INPUT type=\"hidden\" name=\"{$key}[]\" value=\"{$val2}\" />\n";
		}
	}ELSE{
		$arrInputData[$key] = htmlspecialchars( stripslashes( $val ) );
		$strInputHidden .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$arrInputData[$key]}\" />\n";
	}
}



//---------------------------------------------------------------------------
// ����ꥹ�ȥ����å�
//	�����ꥯ�饤����Ȥθ���ꥹ�Ȥ����İʾ�ʤ���Х��顼
//---------------------------------------------------------------------------
IF( is_array( $_SESSION["list"][_cl_id] ) === FALSE ){
	// ����ꥹ�Ȥ���̵��
	$obj_error->ViewErrMessage( "NO_KOUHO" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}ELSE{
	FOREACH( $_SESSION["list"][_cl_id] as $key => $val ){
		IF( $val == "" || ereg( "^[0-9]+$" , $val ) === FALSE ){
			// ����ꥹ�Ȥ��ݻ��ͤ�����
			$obj_error->ViewErrMessage( "SYSTEM" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}
	}
}


//---------------------------------------------------------------------------
// ����ꥹ����λ��������ɣľ������
//	�����������ɣĤ�����ˤ������Ǥ��ʤ���������ʤ�
//	$strViewRoomList ... ���̤ؽ��Ϥ�������
//	$strMailRoomList ... �᡼������������
//---------------------------------------------------------------------------
$strViewRoomList = "";
FOREACH( $_SESSION["list"][_cl_id] as $key => $val ){
	
	// ���������������
	$obj_room_box = NULL;
	$obj_room_box = new viewdb_BuildClassTblAccess();
	$obj_room_box->conn = $obj_conn->conn;
	$obj_room_box->jyoken["build_cl_id"] = "";	// ���ꥯ�饤����Ȥ�ʪ��
	$obj_room_box->jyoken["build_del_date"] = 1;	// ��ʪ���󤬺������Ƥ��ʤ�
	$obj_room_box->jyoken["room_del_date"] = 1;	// �������󤬺������Ƥ��ʤ�
	$obj_room_box->jyoken["room_id"] = $val;	// ���������ɣ�
	list( $intCnt_rb , $intTotal_rb ) = $obj_room_box->viewdb_GetBuild( 1 , -1 );
	IF( $intCnt_rb == -1 || $intCnt_rb > 1 ){
		// �����ƥ२�顼
		$obj_error->ViewErrMessage( "SYSTEM" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
		exit;
	}ELSEIF( $intCnt_rb == 0 ){
		// ����ꥹ�Ȥ����줿��˺��
		//	=> ���⤷�ʤ�
	}ELSE{
		// ɽ����������
		$arrBuffValue = Array();
		// ����������
		$arrBuffValue["room_code"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["room_code"] ) );
		$arrBuffValue["room_id"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["room_id"] ) );
		// ��̾
		$arrBuffString = Array();
		$arrBuffString["build_line_name"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["build_line_name_1"] ) );
		$arrBuffString["build_sta_name"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["build_sta_name_1"] ) );
		$arrBuffString["build_move"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["build_move_1"] ) );
		$arrBuffString["build_move_bus"] = htmlspecialchars( stripslashes( $obj_room_box->builddat[0]["build_move_bus_1"] ) );
		$arrBuffValue["build_station"] = $arrBuffString["build_line_name"].$arrBuffString["build_sta_name"]."�ؤ�������".$arrBuffString["build_move"]."ʬ";
		IF( $arrBuffString["build_move_bus"] != "" ){
			$arrBuffValue["build_station"] .= " �Х�".$arrBuffString["build_move_bus"]."ʬ";
		}
		// �ּ��
		reset( $param_room_floor );
		asort( $param_room_floor["disp_no"] );
		FOREACH( $param_room_floor["disp_no"] as $key => $val2 ){
			IF( $param_room_floor['id'][$key] == $obj_room_box->builddat[0]["room_madori"] ){
				$arrBuffValue["room_madori"] = $param_room_floor['val'][$key];
				break;
			}
		}
		// ����
		$arrBuffValue["room_price"] = number_format($obj_room_box->builddat[0]["room_price"])."��";
		
		
		// ����ɽ����������
		$strViewRoomList .= "  <table>\n";
		$strViewRoomList .= "    <tr>\n";
		$strViewRoomList .= "      <th>ʪ�拾����</th>\n";
		$strViewRoomList .= "      <td>{$arrBuffValue["room_code"]}</td>\n";
		$strViewRoomList .= "    </tr>\n";
		$strViewRoomList .= "    <tr>\n";
		$strViewRoomList .= "      <th>�Ǵ��</th>\n";
		$strViewRoomList .= "      <td>{$arrBuffValue["build_station"]}</td>\n";
		$strViewRoomList .= "    </tr>\n";
		$strViewRoomList .= "    <tr>\n";
		$strViewRoomList .= "      <th>�ּ��</th>\n";
		$strViewRoomList .= "      <td>{$arrBuffValue["room_madori"]}</td>\n";
		$strViewRoomList .= "    </tr>\n";
		$strViewRoomList .= "    <tr>\n";
		$strViewRoomList .= "      <th>����</th>\n";
		$strViewRoomList .= "      <td>{$arrBuffValue["room_price"]}</td>\n";
		$strViewRoomList .= "    </tr>\n";
		$strViewRoomList .= "  </table>\n";
		
		// �᡼��ɽ����������
		$strMailRoomList .= "��{$arrBuffValue["room_code"]}\n";
		$strMailRoomList .= "	�Ǵ�ء�{$arrBuffValue["build_station"]}\n";
		$strMailRoomList .= "	�ּ�ꡧ{$arrBuffValue["room_madori"]}\n";
		$strMailRoomList .= "	���¡�{$arrBuffValue["room_price"]}\n";
		$strMailRoomList .= "	URL��{$param_base_blog_addr_url}"._BLOG_SITE_URL_BASE."build_detail.php?rid={$arrBuffValue["room_id"]}\n\n";
		
	}
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
			require_once( SYS_PATH."php/applicate/applicate_input_check.php" );
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
		
		// ����礻����
		$intBuffQuest = 0;
		reset( $param_applicate_question );
		asort( $param_applicate_question["disp_no"] );
		FOREACH( $param_applicate_question["disp_no"] as $key2 => $val2 ){
			$strChk = "";
			IF( is_array( $_POST["question"] ) === TRUE ){
				IF( in_array( $param_applicate_question["id"][$key2] , $_POST["question"] ) === TRUE ) $strChk = " checked";
			}
			
			IF( $param_applicate_question["val"][$key2] != "����¾" ){
				IF( $intBuffQuest == 0 ){
					$arrViewData["question"] .= "  <tr>\n";
				}
				$arrViewData["question"] .= "    <td class=\"noborder\"><INPUT type=\"checkbox\" name=\"question[]\" id=\"{$param_applicate_question["val"][$key2]}\" value=\"{$param_applicate_question["id"][$key2]}\" {$strChk}/><label for=\"{$param_applicate_question["val"][$key2]}\">{$param_applicate_question["val"][$key2]}</label></td>\n";
				$intBuffQuest++;
				IF( $intBuffQuest == 3 ){
					$arrViewData["question"] .= "  </tr>\n";
					$intBuffQuest = 0;
				}
			}ELSE{
				$arrViewData["question_sonota"] = "<INPUT type=\"checkbox\" name=\"question[]\" id=\"{$param_applicate_question["val"][$key2]}_q\" value=\"{$param_applicate_question["id"][$key2]}\" {$strChk}/><label for=\"{$param_applicate_question["val"][$key2]}_q\">{$param_applicate_question["val"][$key2]}</label>\n";
			}
		}
		// ����
		$intBuffWork = 0;
		reset( $param_inquiry_work );
		asort( $param_inquiry_work["disp_no"] );
		FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
			$strChk = "";
			IF( $arrInputData["work_kind"] == $param_inquiry_work["id"][$key] ) $strChk = " checked";
			
			IF( $intBuffWork == 0 ){
				$arrViewData["work_kind"] .= "  <tr>\n";
			}
			$arrViewData["work_kind"] .= "    <td class=\"noborder\"><INPUT type=\"radio\" name=\"work_kind\" id=\"{$param_inquiry_work["val"][$key]}\" value=\"{$param_inquiry_work["id"][$key]}\"{$strChk}/><label for=\"{$param_inquiry_work["val"][$key]}\">{$param_inquiry_work["val"][$key]}</label></td>\n";
			$intBuffWork++;
			IF( $intBuffWork == 4 ){
				$arrViewData["work_kind"] .= "  </tr>\n";
				$intBuffWork = 0;
			}
		}
		IF( $intBuffWork != 4 && $intBuffWork != 0 ){
			FOR( $iX=$intBuffWork; $iX<4; $iX++ ){
				$arrViewData["work_kind"] .= "    <td class=\"noborder\">&nbsp;</td>\n";
			}
			$arrViewData["work_kind"] .= "  </tr>\n";
		}
		// ����
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
		require_once( SYS_PATH."templates/applicate/applicate_index.tpl" );
		break;
		
	// ��ǧ����
	Case "CONFIRM":
		
		// ɽ����������
		
		// ����礻����
		FOREACH( $_POST["question"] as $key => $val ){
			reset( $param_applicate_question["disp_no"] );
			asort( $param_applicate_question["disp_no"] );
			FOREACH( $param_applicate_question["disp_no"] as $key2 => $val2 ){
				IF( $val == $param_applicate_question["id"][$key2] ){
					$arrViewData["question"] .= $param_applicate_question["val"][$key2]."<br />\n";
					break;
				}
			}
		}
		$arrViewData["question_other"] = nl2br( $arrInputData["question_other"] );
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
			$arrViewData["tell"] = $arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"];
			$arrViewData["tell"] .= "<br />Ϣ����˾�λ�����:".$arrInputData["tell_time"];
		}
		IF( $arrInputData["report_type_2"] == 2 ){
			$arrViewData["fax"] = $arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"];
		}
		IF( $arrInputData["report_type_3"] == 3 ){
			$arrViewData["addr"] = "��".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."<br />";
			$arrViewData["addr"] .= $arrInputData["address_1"]."��".$arrInputData["address_2"];
		}
		IF( $arrInputData["report_type_4"] == 4 ){
			$arrViewData["email"] = $arrInputData["email"];
		}
		
		// ��λ�ڡ����ǤΥڡ������������ػ���
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		$_SESSION["mst"] = $strBuffMst;
		$arrViewData["mst"] = $strBuffMst;
		
		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/applicate/applicate_confirm.tpl" );
		break;
		
	Case "COMMIT":
		
		// �ڡ������������ػ���
		mt_srand(microtime()*100000);
		$strBuffMst = md5(uniqid( mt_rand() , 1 ));
		IF( $_SESSION["mst"] != $_POST["mst"] ){
			$arrError["ath_comment"] = "ʪ����Ф��뤪��礻�᡼�����������Ƥ���ޤ���";
			$obj_error->ViewErrMessage( "NO_RELOAD" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
		}
		
		// ����礻�᡼������
		require_once( SYS_PATH."php/applicate/applicate_send_mail.php" );
		
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
		
		// �䤤��碌��ʪ������ꥹ�Ȥ�����
		unset( $_SESSION["list"][_cl_id] );
		
		
		// ɽ���ƥ�ץ졼�ȸƤӽФ�
		require_once( SYS_PATH."templates/applicate/applicate_commit.tpl" );
		break;
}





?>
