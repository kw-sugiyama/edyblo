<?php
/****************************************************
  �Υ֥� - �ݡ�����TOP�ڡ���
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
require_once ( SYS_PATH."dbif/mstdb_LineClass.php" );

require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/error.class.php" );

require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );

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


// ��︡���ѥܥå�������
require_once( SYS_PATH."php/portal/disp_portal_search_jyokenbox.php" );

// TOP�ڡ�����������
//    => TOP�ڡ�����ɽ�����Ƥ�����
//    => �����ͤ� $arrViewIndex �˳�Ǽ
require_once( SYS_PATH."php/portal/disp_portal_index.php" );


// ����˥塼��������
require_once( SYS_PATH."php/portal/disp_portal_right_menu.php" );

/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*-------------------------------------------
   �ƥ�ץ졼��ɽ��
-------------------------------------------*/
require_once( SYS_PATH."templates/portal/portal_index.tpl" );


?>