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

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once( "../ini_sets_2.php" );
require_once( SYS_PATH."common/ImageControl.class.php" );


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
