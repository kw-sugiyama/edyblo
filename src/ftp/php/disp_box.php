<?
if($obj_login->clientdat[0]['sc_mapimg']){
	$teacher_img='<img src="./img_thumbnail.php?w=112&h=200&dir='.$param_cl_staff_path.'&nm='.$obj_login->clientdat[0]['sc_mapimg'].'" alt=""/>';
}else{
	$teacher_img="";
}

$obj_area = new basedb_AreaClassTblAccess;
$obj_area->conn = $obj_conn->conn;
$obj_area->jyoken=array();
$obj_area->jyoken["ar_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_area->sort['ar_flg'] = 2;
$obj_area->areadat=array();
list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );


$area=array();
$area['zip'] ="〒".$obj_area->areadat[0]['ar_zip'];
$area['pref'] = $obj_area->areadat[0]['ar_pref'];
$area['city'] =$obj_area->areadat[0]['ar_city'];
$area['add'] =$obj_area->areadat[0]['ar_add'];
$area['ar_estate'] =" ".$obj_area->areadat[0]['ar_estate'];
$area['address']=$area['pref'].$area['city'].$area['add'].$area['ar_estate'];

$obj_ensen = new basedb_EnsenClassTblAccess;
$obj_ensen->conn = $obj_conn->conn;
$obj_ensen->jyoken["es_cd"]=$obj_login->clientdat[0]['cl_id'];
$obj_ensen->sort["es_dispno"]=1;

$obj_ensen->ensendat=array();
list( $intCnt_ensen , $intTotal_ensen ) = $obj_ensen->basedb_GetEnsen ( 1 , -1 );

$ensen=array();
$ensen['line1'] = $obj_ensen->ensendat[0]['es_line'];
if($obj_ensen->ensendat[0]['es_sta']) $ensen['sta1'] = $obj_ensen->ensendat[0]['es_sta']."駅";
if($obj_ensen->ensendat[0]['es_bus']) $ensen['bus1'] = " バス".$obj_ensen->ensendat[0]['es_bus']."分";
if($obj_ensen->ensendat[0]['es_walk']) $ensen['walk1'] =" 徒歩".$obj_ensen->ensendat[0]['es_walk']."分";
if($obj_ensen->ensendat[0]['es_biko']) $ensen['biko1'] =" ".$obj_ensen->ensendat[0]['es_biko'];

if($obj_ensen->ensendat[1]['es_line']){
	$ensen['line2'] =  $obj_ensen->ensendat[1]['es_line'];
	if($obj_ensen->ensendat[1]['es_sta'])$ensen['sta2'] = $obj_ensen->ensendat[1]['es_sta']."駅";
	if($obj_ensen->ensendat[1]['es_bus']) $ensen['bus2'] = "　バス".$obj_ensen->ensendat[1]['es_bus']."分";
	if($obj_ensen->ensendat[1]['es_walk']) $ensen['walk2'] ="　徒歩".$obj_ensen->ensendat[1]['es_walk']."分";
	if($obj_ensen->ensendat[1]['es_biko']) $ensen['biko2'] =" ".$obj_ensen->ensendat[1]['es_biko'];
}

?>