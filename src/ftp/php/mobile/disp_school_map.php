<?
//======================================
//school tbl �ǻȤ��ѿ�
//map_html
//view_img_html
//school_list
//======================================

//DB��³����
//�����ģ¤�����
$obj_area                   = new basedb_AreaClassTblAccess;
$obj_area->conn             = $obj_conn->conn;
$obj_area->jyoken["ar_clid"]= $obj_login->clientdat[0]['cl_id'];
$obj_area->sort['ar_flg']   = 2;
$obj_area->areadat          = array();

list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );
$area['address']=$obj_area->areadat[0]['ar_pref'].$obj_area->areadat[0]['ar_city'].$obj_area->areadat[0]['ar_add']." ".$obj_area->areadat[0]['ar_estate'];

//���� ���� ��������ͤ�����
$ido	      = $obj_login->clientdat[0]['sc_ido']  ;
$keido	   = $obj_login->clientdat[0]['sc_keido'];
$zoom	      = $obj_login->clientdat[0]['sc_zoom'] ;
//title ����
$school_box_title    = $obj_login->clientdat[0]['cl_jname'];
$sc_top_title = "Title"; 
$sc_cl_jname  = "Title";

//�����ȥ� ���� ���� ������ɽ��
$school_list.='
	<!--box start-->
	<Marquee direction=\"right\">	'.$obj_login->clientdat[0]['sc_toptitle'].'
	</Marquee>
	'.$img_path.'
	<!--box end-->
	';

//googleAPI�ɤ߹���
require_once ( SYS_PATH."common/Google_mobilemap_class.php" );
//zoomup zoomdown����
if($_POST['zoom_up']){
	$zoom=$_POST['zoom_plus'];
}elseif($_POST['zoom_down']){
	$zoom=$_POST['zoom_minus'];
}else{
	//DB��zoom���ͤ��ʤ����12������
	if($obj_login->clientdat[0]['sc_zoom']){
		$zoom=$obj_login->clientdat[0]['sc_zoom'];
	}else{
		$zoom=12;
	}
}

/*----�ǥХå���ɽ��-----------
print("���ߤ���$zoom");
if($_POST[zoom_plus]){$zoom = $zoom;}
print("�ѹ����줿����$zoom");
------------------------------*/

//googleAPI class�ƤӽФ�
$gmap = new GoogleMobileMapView();

$map_ido	=$ido;
$map_keido	=$keido;

//zoom��19�ʾ� zoomup̵������
if($zoom<19){
	$zoom_plus  = $zoom+1;
}else{
	$zoom_plus  = $zoom;
}
if($zoom>0){
	$zoom_minus = $zoom-1;
}else{
	$zoom_minus = $zoom;
}

//���Ӳ���������
$width   ="200";
$height  ="200";
$k_width ="200";
$k_height="200";

$mark_flg=TRUE;
if($mark_flg == TRUE){
	$points   = array(); 
	$points[] = array('latitude' =>$map_ido ,'longitude' =>$map_keido ,'iconid' => "blue");
}

$map_img 
=$gmap
->setUrl
($map_ido,
$map_keido,
array('w' => $width,'h' => $height,'z'=> $zoom)
,$points,$param_mobile_api_key)        
;

$map_html='
<center><a name="map"><img src="'.$map_img.'" width="'.$k_width.'" height="'.$k_height.'" alt="����MAP" >
</a></center>';

//zoomup zoomdown�ܥ���ɽ����$view_img_html.�˥ǡ���������
$view_img_html.='
	<form method="post" action="./">
	 <center>
	 <input type="submit" value="��" name="zoom_up"> <input type="submit" value="��" name="zoom_down">
	 <input type="submit" value="�����᤹"  name="reset">
	 <input type="hidden" name="zoom_plus"  value="'.$zoom_plus.'">
	 <input type="hidden" name="zoom_minus" value="'.$zoom_minus.'">
	 </center>
	</form>
<a href=../school/>
<font color="#666666">
<p>
�����
</p>
</font>
</a>
';
?>

