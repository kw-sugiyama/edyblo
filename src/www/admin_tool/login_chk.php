<?php

/*----------------------------------------------------------
  ���������������̆����������Î���
----------------------------------------------------------*/
if ( ! $_SESSION['ad_logincd'] || ! $_SESSION['ad_passcd'] || $_SESSION['ad_id'] == ""  ) {
	$obj_error->ViewErrMessage( "LOGIN" , "ALL" , "" , NULL );
	exit;
}
list( $login_stat , $login_val ) = syscom_LoginChk_CL( $obj_conn->conn , $_SESSION['ad_logincd'] , $_SESSION['ad_passcd'] , $_SESSION['ad_id'] );
if( $login_stat == "-1" ){
	$obj_error->ViewErrMessage( "LOGIN" , "ALL" , SITE_PATH."index.php" , NULL );
	exit;
}

/*===================================================
    �A�h���X�ݒ�
===================================================*/
define( "_BLOG_SITE_URL_BASE" , $param_base_blog_addr );


?>
