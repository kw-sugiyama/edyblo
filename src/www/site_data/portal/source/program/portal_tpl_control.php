<?php
/****************************************************
  �Υ֥� - �ݡ�������Ū�ڡ���
****************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( "./html_replace.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/viewdb_CampainClass.php" );
require_once ( SYS_PATH."dbif/viewdb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchCtiyClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchLineClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchPrefClass.php" );

require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/error.class.php" );

require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_mail.conf" );

/*----------------------------------------------------------
    ���å���󥹥�����
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
    �����ե�����ƤӽФ�
----------------------------------------------------------*/

// �إå�����������
//    => ���̾��ɽ�����Ƥ�����
//    => �����ͤ� $arrHeaderView ���� $arrMetaHeader �˳�Ǽ
require_once( SYS_PATH."php/portal/disp_portal_header.php" );

require_once( SYS_PATH."php/portal/disp_static.php" );

// ����˥塼��������
require_once( SYS_PATH."php/portal/disp_portal_right_menu.php" );

/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );

/*-------------------------------------------
	ɽ���ƥ�ץ졼�ȸƤӽФ�
-------------------------------------------*/
	SWITCH( $_GET["tpl_flg"] ){
		// �����ȥޥå�
		Case "sitemap":
			require_once( SYS_PATH."templates/portal/portal_sitemap.tpl" );
			break;
		// �����ȵ���
		Case "kiyaku":
			require_once( SYS_PATH."templates/portal/portal_kiyaku.tpl" );
			break;
		// ���Ĳ��
		Case "com":
			require_once( SYS_PATH."templates/portal/portal_com.tpl" );
			break;
		// �Ŀ;����ݸ�����
		Case "privacy":
			require_once( SYS_PATH."templates/portal/portal_privacy.tpl" );
			break;
		// ���䤤��碌
		Case "inquiry":
			require_once( SYS_PATH."templates/portal/portal_inquiry.tpl" );
			break;
		// ����̵�����顼
		default:
			$obj_error->ViewErrMessage( "MENT" , "PORTAL-USER" , "/" , $arrErr );
			exit;
	}

?>
