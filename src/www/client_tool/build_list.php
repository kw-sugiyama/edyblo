<?php
/****************************************************
		ʪ������ڡ���
****************************************************/


require_once ( "./ini_sets_1.php" );
require_once ( "./html_replace.php" );
require_once ( SYS_PATH."/dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."/dbif/basedb_RoomClass.php" );
require_once ( SYS_PATH."/dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."/dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."/dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."/dbif/basedb_BlogClass.php" );
require_once ( SYS_PATH."/common/base_common.php" );
require_once ( SYS_PATH."/common/sys_common.php" );
require_once ( SYS_PATH."/common/form_common.php" );
require_once ( SYS_PATH."/common/error.class.php" );
require_once ( SYS_PATH."/configs/param_base.conf" );
require_once ( SYS_PATH."/configs/param_build.conf" );
require_once ( SYS_PATH."/configs/param_file.conf" );
require_once ( SYS_PATH."/configs/param_map.conf" );
require_once ( SYS_PATH."/configs/param_room.conf" );
require_once ( SYS_PATH."/configs/param_search.conf" );


/*-------------------------------------------
   ���å���󥹥�����
-------------------------------------------*/
session_start();


/*-------------------------------------------
	���顼���饹 - ���󥹥���
-------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
    �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
    �����ե�����ƤӽФ�
----------------------------------------------------------*/

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


// TOP�ڡ�����������
//    => TOP�ڡ�����ɽ�����Ƥ�����
//    => �����ͤ� $arrViewIndex �˳�Ǽ
require_once( SYS_PATH."php/disp_build_list.php" );

// ���ե�����ؽ񤭹��߽���
//    => ������ǥ��쥯�ȥ�ˤ���ե�����ؽ񤭹���
//    => ���ɥ쥹�� ���� �˳�Ǽ
require_once( SYS_PATH."php/disp_log_write.php" );


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*-------------------------------------------
   �١����ƥ�ץ졼��ɽ��
-------------------------------------------*/
include( SYS_PATH."templates/build_list.tpl" );

?>
