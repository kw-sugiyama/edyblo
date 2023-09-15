<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: master_line_upd.php
	Version: 1.0.0
	Function: �����إޥ����գн���
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

// fgetcsv��ʸ����������� 2010/06/14����
setlocale(LC_ALL,'ja_JP');

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectMstClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/mstdb_LineClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."configs/param_file.conf" );


/*----------------------------------------------------------
  ���å������Ͽ����
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
require_once( SYS_PATH."common/db_connect_mst.php" );


/*----------------------------------------------------------
  �������������å�
----------------------------------------------------------*/
require_once("../login_chk.php");
if( $login_val["ad_auth"] != "0" ){
	$obj_error->ViewErrMessage( "ACCESS" , "ALL" , SITE_PATH."blank.php" , NULL );
	exit;
}


/*--------------------------------------------------------
  �գХե������ǧ
--------------------------------------------------------*/
mt_srand(microtime()*100000);
$strRand = md5( uniqid( mt_rand() , 1 ) );

$strFileName = "";
if ( is_uploaded_file( $_FILES['line_master']['tmp_name'] ) ) {
	$strFileName = "mst_line_".$strRand.".csv";
	move_uploaded_file( $_FILES['line_master']['tmp_name'] , $param_mst_file_path.$strFileName );
	chmod( $param_mst_file_path.$strFileName , 0600 );
} else {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	exit;
}
if ( ! ( $fp = fopen( $param_mst_file_path.$strFileName ,"r" ) ) ) {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	exit;
}


/*--------------------------------------------------------
  ʸ���������Ѵ���ե���������
--------------------------------------------------------*/
$strChangeFile = "mst_line_insert_".$strRand.".csv";
if ( ! ( $fp2 = fopen( $param_mst_file_path.$strChangeFile , "w" ) ) ) {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	unlink( $param_mst_file_path.$strFileName );
	exit;
}
$iX= 0;
WHILE( $arrBuffLine = fgetcsv ( $fp , 4096 , "\t" ) ) {
	$strBuffCsv = "";
	$strBuffCsv .= "{$arrBuffLine[0]}	";	// ���ꥢ�ֹ�
	$strBuffCsv .= "{$arrBuffLine[1]}	";	// ���ꥢ̾
	$strBuffCsv .= "{$arrBuffLine[2]}	";	// ��������
	$strBuffCsv .= "{$arrBuffLine[3]}	";	// ��̾
	$strBuffCsv .= "{$arrBuffLine[4]}	";	// ����������
	$strBuffCsv .= "{$arrBuffLine[5]}	";	// ����̾
	$strBuffCsv .= "{$arrBuffLine[6]}	";	// ����̾�ʤ��ʡ�
	$strBuffCsv .= "{$arrBuffLine[7]}	";	// �إ�����
	$strBuffCsv .= "{$arrBuffLine[8]}	";	// ��̾
	$strBuffCsv .= "{$arrBuffLine[9]}";		// ��̾�ʤ��ʡ�
	$strBuffCsv .= "\n";
	
// EUC�Υե�����򤽤Τޤޥ��åץ��ɤ���褦���ѹ� 2010/06/14����	$strCsv = mb_convert_encoding( $strBuffCsv , "EUC" , "SJIS" );
	
	//fwrite( $fp2 , $strCsv );
	fwrite( $fp2 , $strBuffCsv );
	
	$iX++;
}
fclose( $fp2 );
fclose( $fp );


/* �ţգå������Ѵ��ãӣ֥ե����륪���ץ� */
if ( ! ( $fp3 = fopen( $param_mst_file_path.$strChangeFile , "r" ) ) ) {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	unlink( $param_mst_file_path.$strFileName );
	unlink( $param_mst_file_path.$strChangeFile );
	exit;
}


/*--------------------------------------------------------
  ������ʬ
--------------------------------------------------------*/
$obj_line = new mstdb_LineClassTblAccess;
$obj_line->conn = $obj_conn_mst->conn;
$iY = 0;
WHILE( $arrBuffLine2 = fgetcsv( $fp3 , 4096 , "\t" ) ) {
	$obj_line->linedat[$iY]["st_areacd"] = $arrBuffLine2[0];
	$obj_line->linedat[$iY]["st_area"] = $arrBuffLine2[1];
	$obj_line->linedat[$iY]["st_prefcd"] = $arrBuffLine2[2];
	$obj_line->linedat[$iY]["st_pref"] = $arrBuffLine2[3];
	$obj_line->linedat[$iY]["st_linecd"] = $arrBuffLine2[4];
	$obj_line->linedat[$iY]["st_line"] = $arrBuffLine2[5];
	$obj_line->linedat[$iY]["st_linekana"] = $arrBuffLine2[6];
	$obj_line->linedat[$iY]["st_stacd"] = $arrBuffLine2[7];
	$obj_line->linedat[$iY]["st_sta"] = $arrBuffLine2[8];
	$obj_line->linedat[$iY]["st_stakana"] = $arrBuffLine2[9];
	$iY++;
}
list( $ret , $intInsCnt ) = $obj_line->mstdb_InsLineAll();
IF( $ret == "-1" ){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	exit;
}ELSEIF( $ret == 1 ){
	$viewComment = "��¸�Υǡ�����¸�ߤ��Ƥ��뤿�ᡢ��Ͽ������Ԥ��ޤ���Ǥ�����<br />���ٺ���򤷤Ƥ�����Ͽ������ԤäƲ�������";
}ELSE{
	$viewComment = $intInsCnt."��α����ؾ�����Ͽ����ޤ�����";
}

// �ե�������
unlink( $param_mst_file_path.$strFileName );
unlink( $param_mst_file_path.$strChangeFile );


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );
require_once( SYS_PATH."common/db_close_mst.php" );


/*----------------------------------------------------------
  �ȣԣͣ�����
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>��ư���֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="./share/css/master.css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
            <br /><br /><br /><br /><br />
            <font size="3" color="#FF6600"><?=$viewComment?></font>
            <br /><br /><br />
          </td>
        </tr>
      </table>
      <form name="form1" method="POST" action="master_main.php"> 
        <input type="submit" value=" �� �� " class="btn" />
      </form>
    </div>
  </BODY>
</HTML>
