<?php

// viewdb_SearchPrefClass.php
/*=======================================================
    ���������н���
=======================================================*/
$obj_sprefcnt = new viewdb_SPrefClassTblAccess;
$obj_sprefcnt->conn = $obj_conn->conn;
$obj_sprefcnt->jyoken = array(); 
$ret = $obj_sprefcnt->viewdb_CntSPref( 1 , -1);
$view_prefdat = array();
foreach( $obj_sprefcnt->sprefdat as $key => $val ){
	foreach( $val as $key2 => $val2 ){
		if( is_numeric( $key2 ) ){
			unset( $obj_sprefcnt->sprefdat[$key][$key2] );
		}else{
			$view_prefdat[$key][$key2] = $obj_sprefcnt->sprefdat[$key][$key2];
		}
	}
}
unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);

$view_pref_list = '';	// �ץ���������ѿ�

$view_pref_list .= '<option value="">��ƻ�ܸ�</option>'. "\n";

foreach( $view_prefdat as $key => $val ){
	$selected = "";
	//if( $ar_select_value == $view_prefdat[$key]['ar_prefcd'] ) $selected = ' selected="selected"';
	// ʪ�郎¸�ߤ��븩�Τߥץ�������ɽ��
	$view_pref_list .= '<option value="' . $view_prefdat[$key]['ar_prefcd'] . '"'.$selected.'>' . $psel[$view_prefdat[$key]['ar_prefcd']] . '</option>' . "\n";
}

$view_sc_age = "";
$view_sc_age .= '<option value="" selected="selected">�о�ǯ�������</option>';
for( $i=0; $i<7; $i++ ){
	$view_sc_age .= '<option value="'.$param_age["id"][$i].'">'.$param_age["val"][$i].'</option>';
}

$view_sc_classform = "";
for( $i=0; $i<3; $i++ ){
	$view_sc_classform .= '<input name="cl[]" type="checkbox" value="'.$param_classform["id"][$i].'"> '.$param_classform["val"][$i].'&nbsp;';
	if( $i < 2 ) $view_sc_classform .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}

?>