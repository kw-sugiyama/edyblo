<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
        Name: img_thumbnail.php
        Version: 1.0.0
        Function: �����̾�����
        Author: Click inc
        Date of creation: 2007/02
        History of modification:

        Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/
//ini_set ( "display_errors", "1" );

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
// system �ǥ��쥯�ȥ�ޤǤΥѥ�
define( 'SYS_PATH' , '../../../ftp/' );
require_once( SYS_PATH."common/ImageControl.class.php" );
/*
<img src="./img_thumbnail.php?w=120&amp;h=120&amp;dir=./cl_img/build_photo_img/&amp;nm=build_3_54526.JPG">
http://reblo.sp-jobnet.co.jp/client_tool/ctrl_room/img_thumbnail.php?w=120&h=120&dir=../cl_img/room_layout_img/&nm=layout_3_86798.JPG
*/


/*----------------------------------------------------------
  $_GET�ͥ����å�
----------------------------------------------------------*/
IF( !ereg( "^[0-9]+$" , $_GET["w"] ) ){
	echo "error-1#".$_GET["w"]."#";
	exit;
}
IF( !ereg( "^[0-9]+$" , $_GET["h"] ) ){
	echo "error-2#".$_GET["h"]."#";
	exit;
}
IF( $_GET["dir"] == "" ){
	echo "error-3";
	exit;
}

/*----------------------------------------------------------
  �����̾�������ɽ��
----------------------------------------------------------*/
$obj_img = new ImageControl();
$obj_img->gd_ver = 2;
$obj_img->standard = 1;
$obj_img->max_w = $_GET["w"];
$obj_img->max_h = $_GET["h"];
$obj_img->origin_dir = $_GET["dir"];
$obj_img->origin_img = $_GET["nm"];
$obj_img->ImageResize();


?>
