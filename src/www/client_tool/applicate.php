<?php
/****************************************************
  ��ư���֥� - �������ߥե�����
****************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( "./html_replace.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_RoomClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."dbif/basedb_BlogClass.php" );
require_once ( SYS_PATH."dbif/basedb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_map.conf" );
require_once ( SYS_PATH."configs/param_inquiry.conf" );
require_once ( SYS_PATH."configs/param_applicate.conf" );


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

// applicate �Τ�Τ�ɬ�����ν����������
//    => �������Ƥ�������
//		�����饤����ȥ����å�
//		���إå�����������
//		�����ե�����񤭹��߽���
//		��$_POST �ˤ������ڤ��ؤ�
require_once( SYS_PATH."php/applicate/applicate_control.php" );


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );



?>
