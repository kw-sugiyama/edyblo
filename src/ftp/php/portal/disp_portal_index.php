<?php
/*==============================================================
    TOP�ڡ���ɽ�����������ե�����
==============================================================*/

//title
$view_header_title = "";
//$view_header_title = '�ؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ�����ס�����ξ��ع�����ع����⹻����������򥵥ݡ��ȡ�';
$view_header_title = '�ؽ���õ���Υݡ�����ֽΥ�����ס�����θ��̻�Ƴ�Τ���ؼ����к��ʤɿʳؽΤ�Ǻ�';

//keywords
$view_header_keywoeds = "";
$view_header_keywoeds = "�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����";

//description
$view_header_description  = "";
$view_header_description .= "�Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ���";
$view_header_description .= "�ϰ����Ū����ؼ����к����佬�ˡ���Ƴ�����ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˤʤɤ���";
$view_header_description .= "��ñ�˽Τ򸡺��Ǥ��ޤ���";

/*
$view_header_description = "�Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ����ϰ����Ū�ʼ����к����佬�ˡ���Ƴ�����ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ��";
$view_header_description .= '�ʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';
*/

/*==============================================================
    �ΤΤ�������θ��Τߥץ�������ɽ������
==============================================================*/

	// viewdb_SearchLineClass.php
	/*=======================================================
	    ���������н���
	=======================================================*/
	$obj_sprefcnt = new viewdb_SLineClassTblAccess;
	$obj_sprefcnt->conn = $obj_conn->conn;
	$obj_sprefcnt->jyoken = array(); 
	$ret = $obj_sprefcnt->viewdb_CntSLPref( 1 , -1);
	$view_prefdat = array();
	foreach( $obj_sprefcnt->slinedat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_sprefcnt->slinedat[$key][$key2] );
			}else{
				$view_prefdat[$key][$key2] = $obj_sprefcnt->slinedat[$key][$key2];
				$view_prefdat[$key]['ar_prefcd'] = $view_prefdat[$key]['st_prefcd'];
			}
		}
	}
	unset($key, $key2, $val, $val2, $obj_sprefcnt->slinedat);
	
	$view_prefline_list = "";
	$view_prefline_list .= '<option value="" selected="selected">��ƻ�ܸ�</option>';
	
	foreach( $view_prefdat as $key => $val){
		// ʪ�郎¸�ߤ��븩�Τߥץ�������ɽ��
		$view_prefline_list .= '<option value="' . $view_prefdat[$key]['ar_prefcd'] . '">' . $psel[$view_prefdat[$key]['ar_prefcd']] . '</option>' . "\n";
	}
	
?>