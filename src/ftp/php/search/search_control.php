<?php
/****************************************************
  ��ư���֥� - �Ƽ︡������ - �������ƥ���ȥ���
****************************************************/


// ---------------- �������鶦�̽��� -----------------//


// ���饤����ȥ����å����쥤�����Ȼ���
//    => $obj_login �˻��ꥯ�饤����Ⱦ����Ǽ��
//    => SESSION["_cl_id"]�˻��ꥯ�饤�����ID�ݻ�
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



// ---------------- ����������̽��� -----------------//


	//----------------------------------------------
	// $_GET["page_flg"] ... �����ɤ߹�����ڡ���
	//    "area"     : ���ꥢ��������
	//    "line"     : ������������
	//    "sta-line" : �ظ��� - �����ʹ��߲���
	//    "sta"      : �ظ�������
	//----------------------------------------------

	SWITCH( $_GET["page_flg"] ){
		// ���ꥢ���������ɤ߹���
		Case "area":
			
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/search/disp_search_area.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/search/search_area.tpl" );
			
			break;
		
		Case "line":
			
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/search/disp_search_line.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/search/search_line.tpl" );
			
			break;
		
		Case "staline":
			
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/search/disp_search_line.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/search/search_station_line.tpl" );
			
			break;
		
		Case "sta":
			
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/search/disp_search_station.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/search/search_station.tpl" );
			
			break;
		
		
		
		
		// ����̵�����顼
		default:
			$obj_error->ViewErrMessage( "MENT" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
	}





?>
