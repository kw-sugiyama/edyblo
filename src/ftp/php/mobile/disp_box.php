<?
//======================================================================
//tplのフッターに使われる関数
//$tc_box2   
//$scholl_form
//$boxmobileB
//$boxmobile
//$boxmobile2
//define("printa", "eacho");
//======================================================================
if($obj_login->clientdat[0]['sc_mapimg']){
	$teacher_img='<img src="./img_thumbnail.php?w=112&h=200&dir='.$param_cl_staff_path.'&nm='.$obj_login->clientdat[0]['sc_mapimg'].'" alt=""/>';
}else{
	$teacher_img="";
}

$urlbase = _BLOG_SITE_URL_BASE;
$obj_area                    = new basedb_AreaClassTblAccess;
$obj_area->conn              = $obj_conn->conn;
$obj_area->jyoken            = array();
$obj_area->jyoken["ar_clid"] = $obj_login->clientdat[0]['cl_id'];
$obj_area->sort['ar_flg']    = 2;
$obj_area->areadat           = array();
list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );

$area              = array();
$area['zip']       = "〒".$obj_area->areadat[0]['ar_zip'];
$area['pref']      = $obj_area->areadat[0]['ar_pref'];
$area['city']      = $obj_area->areadat[0]['ar_city'];
$area['add']       = $obj_area->areadat[0]['ar_add'];
$area['ar_estate'] = " ".$obj_area->areadat[0]['ar_estate'];
$area['address']   = $area['pref'].$area['city'].$area['add'].$area['ar_estate'];

$obj_ensen                    = new basedb_EnsenClassTblAccess;
$obj_ensen->conn              = $obj_conn->conn;
$obj_ensen->jyoken["es_cd"]   = $obj_login->clientdat[0]['cl_id'];
$obj_ensen->sort["es_dispno"] = 1;
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
	if($obj_ensen->ensendat[1]['es_sta']) $ensen['sta2']  = $obj_ensen->ensendat[1]['es_sta']."駅";
	if($obj_ensen->ensendat[1]['es_bus']) $ensen['bus2'] = "　バス".$obj_ensen->ensendat[1]['es_bus']."分";
	if($obj_ensen->ensendat[1]['es_walk']) $ensen['walk2'] ="　徒歩".$obj_ensen->ensendat[1]['es_walk']."分";
	if($obj_ensen->ensendat[1]['es_biko']) $ensen['biko2'] =" ".$obj_ensen->ensendat[1]['es_biko'];
}
//=====================================================================
//モバイル用 画像定数作成
//=====================================================================
$gazou='<img src="'._BLOG_SITE_URL_BASE.'./share/images/futaba.gif">';
$boxmobileB='<Div Align="right">
<span><a href="#top">
<font size="1" color="#666666">
▲上に戻る</Div>
</a>
</font>
';
$boxmobile='<div>
<div>
'.$gazou.'
<a href="'._BLOG_SITE_URL_BASE.'">
<font size="1" color="#666666">
ﾄｯﾌﾟﾍﾟｰｼﾞ
</font>
</a><br /><!--to pagetop-->
'.$gazou.'
<a href="'._BLOG_SITE_URL_BASE.'kojin/">
<font size="1" color="#666666">
ﾌﾟﾗｲﾊﾞｼｰﾎﾟﾘｼｰ
</a><br>
</font>
'.$gazou.'
<a href="mailto:?subject=&amp;body=http://'.$_SERVER["HTTP_HOST"].''._BLOG_SITE_URL_BASE.'">
<font size="1" color="#666666">
このｻｲﾄを教える
</a>
<br />
'.$gazou.'
<a href="mailto:?subject=&amp;body='._PC_BLOG_ADDR_URL.'">
<font size="1" color="#666666">
ﾊﾟｿｺﾝで見る
</a>
</font>
<br /><!--to pagetop-->
';

list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );
$area['address']=$obj_area->areadat[0]['ar_pref'].$obj_area->areadat[0]['ar_city'].$obj_area->areadat[0]['ar_add']." ".$obj_area->areadat[0]['ar_estate'];

//未入力項目は「−」を表示
if($obj_login->clientdat[0]['cl_kname']){
	$cl_kname  =$obj_login->clientdat[0]['cl_kname'];
}else{
	$cl_kname  ="−";
}
if($obj_login->clientdat[0]['sc_company']){
	$sc_company=$obj_login->clientdat[0]['sc_company'];
}else{
	$sc_company="−";
}
if($obj_login->clientdat[0]['cl_phone']){
	$cl_phone  =htmlspecialchars($obj_login->clientdat[0]['cl_phone']);
}else{
	$cl_phone  ="−";
}
if($obj_login->clientdat[0]['cl_fax']){
	$cl_fax    =$obj_login->clientdat[0]['cl_fax'];
}else{
	$cl_fax    ="−";
}
$boxmobile2='
<font size="1" color="#000000">
	 <span>'.$arrMetaHeader["title_corp"].'';
$boxmobile2.='</span><br /><a href="tel:'.htmlspecialchars($cl_phone).'">
<font size="1" color="#666666">
'.htmlspecialchars($cl_phone).'';
$boxmobile2.='</font></a><font color="red">　　　</font><br />';
$boxmobile2.=''.htmlspecialchars($area[address]).'</p> ';
//資料請求へのリンク
//$req='<form method="post" action="'._BLOG_SITE_URL_BASE.'req/"><input type="submit" value="資料請求"></form>';
$req='<a href="'._BLOG_SITE_URL_BASE.'req/"><IMG SRC="'.$urlbase.'./share/images/shiryou.gif" border="0"></a>';
//問い合わせページへのリンク
//$inq='<form method="POST" action="'._BLOG_SITE_URL_BASE.'inquire/"><input type="submit" value="お問い合わせ"></form>';
$inq='<a href="'._BLOG_SITE_URL_BASE.'inquire/"><IMG SRC="'.$urlbase.'./share/images/otoiawase.gif" border="0"></a>';
//$inq=' <IMG SRC="./link/link.jpg" align="top">';
$scholl_form='
<table border="0" width="100%">
<tr>
<td width="50%" Align="center">
'.$inq.'
</td>
<td width="50%" Align="center">
'.$req.'
</td>
</tr>
</table>
 ';
$urlbase = _BLOG_SITE_URL_BASE;
$boxmap=''.$mark.' <a href="'.$urlbase.'school/">
	 <font size="1" color="#666666">
	 地図
	 </font>
	 </a>';
$privacy='<a href="'._BLOG_SITE_URL_BASE.'kojin/">
	 <font size="1" color="#666666" >
	 ﾌﾟﾗｲﾊﾞｼｰﾎﾟﾘｼｰ
	 </font>
	 </a>';
?>
