<?php
/****************************************************
  ��ư���֥� - �Ƽ︡������ - �������ƥ���ȥ���
****************************************************/


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
		Case "pref":
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/portal/search/disp_portal_search_pref.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/portal/search/portal_search_pref.tpl" );
			
			break;
		
		Case "area":
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/portal/search/disp_portal_search_area.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/portal/search/portal_search_area.tpl" );
			
			break;

		Case "arealine":
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/portal/search/disp_portal_search_area.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/portal/search/portal_search_arealine.tpl" );
			
			break;

		Case "line":
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/portal/search/disp_portal_search_line.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/portal/search/portal_search_line.tpl" );
			
			break;
		
		Case "staline":
			
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/portal/search/disp_portal_search_line.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/portal/search/portal_search_station_line.tpl" );
			
			break;
		
		Case "sta":
			
			// ���ꥢ��������ɽ�����ƽ���
			require_once( SYS_PATH."php/portal/search/disp_portal_search_station.php" );
			
			// ɽ���ƥ�ץ졼�ȸƤӽФ�
			require_once( SYS_PATH."templates/portal/search/portal_search_station.tpl" );
			
			break;
		
		
		
		
		
		// ����̵�����顼
		default:
			$obj_error->ViewErrMessage( "MENT" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
	}





?>