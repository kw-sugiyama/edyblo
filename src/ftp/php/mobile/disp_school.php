<?
///////////////////////////////
// school.tpl�ǻȤ��ѿ��ꥹ��
//$map_html
//$view_img_html
//$school_list 
///////////////////////////////

//�ޡ������
$mark= "<font size=\"1\" color=\"#C5BE97\">��</font>";

//�ģ���³
$obj_area                   = new basedb_AreaClassTblAccess;
$obj_area->conn             = $obj_conn ->conn;
$obj_area->jyoken["ar_clid"]= $obj_login->clientdat[0]['cl_id'];
$obj_area->sort['ar_flg']   = 2;
$obj_area->areadat=array();

//�Ͽ�ɽ��
list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );
$area['address']=$obj_area->areadat[0]['ar_pref'].$obj_area->areadat[0]['ar_city'].$obj_area->areadat[0]['ar_add']." ".$obj_area->areadat[0]['ar_estate'];

//���� ���� ��������ͤ�����
$ido	      = $obj_login->clientdat[0]['sc_ido']  ;
$keido	      = $obj_login->clientdat[0]['sc_keido'];
$zoom	      = $obj_login->clientdat[0]['sc_zoom'] ;
//title ����
$school_box_title    = $obj_login->clientdat[0]['cl_jname'];

$sc_top_title = "Title"; 
$sc_cl_jname  = "Title";

//�����ȥ� ���� ���� ������ɽ��
$school_list.='
	<!--box start-->
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
$width   ="180";
$height  ="180";
$k_width ="180";
$k_height="180";

$mark_flg=TRUE;
if($mark_flg == TRUE){
	$points   = array(); 
	$points[] = array('latitude' =>$map_ido ,'longitude' =>$map_keido ,'iconid' => "blue");
}
$map_img 
=$gmap->setUrl
($map_ido,$map_keido,array('w' => $width,'h' => $height,'z'=> $zoom),$points,$param_mobile_api_key)        
;

$map_html='
<center><a name="map"><img src="'.$map_img.'" width="'.$k_width.'" height="'.$k_height.'" alt="����MAP" >
</a></center>';

//zoomup zoomdown�ܥ���ɽ��view_img_html.�˥ǡ���������
$view_img_html.='
	<form method="post" action="./">
	 <center>
	 <input type="submit" value="��" name="zoom_up"> <input type="submit" value="��" name="zoom_down">
	 <input type="hidden" name="zoom_plus"  value="'.$zoom_plus.'">
	 <input type="hidden" name="zoom_minus" value="'.$zoom_minus.'">
	 </center>
	</form>
</a>
';
//<!-- <input type="submit" value="�����᤹"  name="reset"> -->

list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );
$area['address']=$obj_area->areadat[0]['ar_pref'].$obj_area->areadat[0]['ar_city'].$obj_area->areadat[0]['ar_add']." ".$obj_area->areadat[0]['ar_estate'];

//̤���Ϲ��ܤϡ֡ݡפ�ɽ��
if($obj_login->clientdat[0]['cl_kname']){
	$cl_kname  =$obj_login->clientdat[0]['cl_kname'];
}

if($obj_login->clientdat[0]['sc_company']){
	$sc_company=$obj_login->clientdat[0]['sc_company'];
}else{
	$sc_company="��";
}
if($obj_login->clientdat[0]['cl_phone']){
	$cl_phone  =$obj_login->clientdat[0]['cl_phone'];
}else{
	$cl_phone  ="��";
}
if($obj_login->clientdat[0]['cl_fax']){
	$cl_fax    =$obj_login->clientdat[0]['cl_fax'];
}else{
	$cl_fax    ="";
}

//�������ܾ���ģ¤������Ǥ����(�����������ɽ��)
if($obj_login->clientdat[0]['sc_topimg']){
	$img_path  ='
		<br><center><img src="./img_thumbnail.php?w=100&h=105&dir='.$param_cl_photo_path.'&nm='.$obj_login->clientdat[0]['sc_topimg'].'" alt="" />
		<br /></center>
		';
}else{
	$img_path='
		<br />
		';
}
//��������
$obj_ensen = new basedb_EnsenClassTblAccess;
$obj_ensen->conn = $obj_conn->conn;
$obj_ensen->jyoken["es_cd"]=$obj_login->clientdat[0]['cl_id'];
$obj_ensen->sort["es_dispno"]=1;

$obj_ensen->ensendat=array();
list( $intCnt_ensen , $intTotal_ensen ) = $obj_ensen->basedb_GetEnsen ( 1 , -1 );

$ensen=array();
$ensen['line1'] = $obj_ensen->ensendat[0]['es_line'];
if($obj_ensen->ensendat[0]['es_sta']) $ensen['sta1']   = $obj_ensen->ensendat[0]['es_sta']."��";
if($obj_ensen->ensendat[0]['es_bus']) $ensen['bus1']   = " �Х�".$obj_ensen->ensendat[0]['es_bus']."ʬ";
if($obj_ensen->ensendat[0]['es_walk']) $ensen['walk1'] =" ����".$obj_ensen->ensendat[0]['es_walk']."ʬ";
if($obj_ensen->ensendat[0]['es_biko']) $ensen['biko1'] =" ".$obj_ensen->ensendat[0]['es_biko'];

if($obj_ensen->ensendat[1]['es_line']){
	$ensen['line2'] =  $obj_ensen->ensendat[1]['es_line'];
	if($obj_ensen->ensendat[1]['es_sta'])$ensen['sta2']    = $obj_ensen->ensendat[1]['es_sta']."��";
	if($obj_ensen->ensendat[1]['es_bus']) $ensen['bus2']   = "���Х�".$obj_ensen->ensendat[1]['es_bus']."ʬ";
	if($obj_ensen->ensendat[1]['es_walk']) $ensen['walk2'] ="������".$obj_ensen->ensendat[1]['es_walk']."ʬ";
	if($obj_ensen->ensendat[1]['es_biko']) $ensen['biko2'] =" ".$obj_ensen->ensendat[1]['es_biko'];
}

//��������
$a = $ensen;
foreach( $a as $key => $value ){
$ensendate .=$value;
}

//�ɲå����ȥ�
#$sc_top_title = $obj_login->clientdat[0]['sc_toptitle'];
#$sc_cl_jname  = $obj_login->clientdat[1]['cl_jname'];
$school_box_title    = $obj_login->clientdat[0]['cl_jname'];

if(!$cl_fax){
$cl_faxprint="";
}else{
$cl_faxprint="$mark FAX $cl_fax<br>";
}

//HTMLɽ��
$school_list.='
		  <!--box start-->
		  '.$mark.'
		  
		  '.htmlspecialchars($obj_login->clientdat[0]['cl_jname']).'
		  '.htmlspecialchars($cl_kname).'<br />
		  '.$mark.'
		  	'.htmlspecialchars($area['address']).'<br />
		  '.$mark.'
		  	'.htmlspecialchars($ensendate).'<br />
		  </a> 
		  '.$mark.'
		   TEL
		  </span><font size="1">
<a href="tel:'.$cl_phone.'">
<font color="#666666">
'.$cl_phone.'<BR>
</font>
</a><font size="1">
		  '.$cl_faxprint.'

		  '.$mark.'
		   ���ջ���
		  '.ltrim($obj_login->clientdat[0]['sc_start'],"0").' �� '.ltrim($obj_login->clientdat[0]['sc_end'],"0").'<br />
		  '.$mark.'
		   �����
		  '.htmlspecialchars($obj_login->clientdat[0]['sc_holiday']).'<br />
		  </a>
		  '.$mark.'
<a href="'._BLOG_SITE_URL_BASE.'school_detail/">
<font color="#666666">
�ܺ٤Ϥ�����
</font>
</a> 
';
?>
