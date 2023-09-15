<?
//=====================================================================
//関数追加(htmltag除去 変換)
require"taglist.php";
function strip_between_tag( $str, $tag=array() ) {
foreach( $tag as $val){
$pattern = "/<{$val}.*?>.*?<\/{$val}>/ims";
$str = preg_replace( $pattern , '[ 携帯表示不可 ]', $str);
}
return $str;
}
//=====================================================================
$title = $_GET[page];

$timestamp='(timestamp \''.date("Y").'-'.date("m").'-'.date("d").' 00:00:00\')';
$obj_campaign                            = new basedb_CampainClassTblAccess;
$obj_campaign->conn                      = $obj_conn->conn;
$obj_campaign->jyoken                    = array();
$obj_campaign->jyoken["cp_id"]           = $title;

$obj_campaign->campaindat=array();

list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( 1 , -1 );
$bigtitle=$obj_campaign->campaindat[0][cp_title];

$texttitle = $obj_campaign->campaindat[0][cp_title];
if($_GET['caid']){
  $caid=$_GET['caid'];
}else{
  $caid="error";
}
$obj_campaign                            = new basedb_CampainClassTblAccess;
$obj_campaign->conn                      = $obj_conn->conn;

list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( 1 , -1 );

$obj_category= new basedb_CategoryClassTblAccess;
$obj_category->conn = $obj_conn->conn;
$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]    = $obj_campaign->campaindat[0]['cp_id'];
$obj_category->jyoken["cg_type"]    = 8;
$obj_category->jyoken["cg_deldate"] = 1;
$obj_category->sort["cg_dispno"]    = 2;
$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt="";
$dispcnt=count($obj_category->categorydat)-1;

    $obj_camarticle = new basedb_CamarticleClassTblAccess;
    $obj_camarticle->conn = $obj_conn->conn;
    $obj_camarticle->jyoken=array();
    $obj_camarticle->jyoken["ca_id"]=$caid;
    $obj_camarticle->camarticledat=array();
    list( $intCnt_camarticle , $intTotal_camarticle ) = $obj_camarticle->basedb_GetCamarticle ( 1 , -1 );

//ここまで
    $dispcnt="";
    $dispcnt=count($obj_camarticle->camarticledat)-1;
foreach($obj_camarticle->camarticledat as $key2=>$va2){

//実際の表示
$text1 = ($obj_camarticle->camarticledat[0][7]);
//$text1 = $obj_camarticle->camarticledat[0][7];
$text1 = strip_between_tag($text1,$srr_tag); 
$text1 = strip_tags($text1); 
$text1 = htmlspecialchars($text1);
$text1 = nl2br($text1);

$text2 =($obj_camarticle->camarticledat[0][ca_cateid]);
$text1title = htmlspecialchars($obj_camarticle->camarticledat[0][4]);

	if($obj_camarticle->camarticledat[0]['ca_img']){
	  $img_path='
	   <p><center>
	<img src="./img_thumbnail.php?w=150&h=120&dir='.$param_camarticle_img_path.'&nm='.$obj_camarticle->camarticledat[0]['ca_img'].'" alt=""  /></a>
	    </p></center>
';
	}else{
	  $img_path='
	    ';
	}	
}
?>
