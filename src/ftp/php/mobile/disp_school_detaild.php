<?
//==============================
//school_detaild.tblで使う変数
//ac_title
//imgA
//ac_contents
//==============================

//==================================
//関数追加(htmltag除去 変換)
require"taglist.php";
function strip_between_tag( $str, $tag=array() ) {
foreach( $tag as $val){
$pattern = "/<{$val}.*?>.*?<\/{$val}>/ims";
$str = preg_replace( $pattern , '[携帯表示不可]', $str);
}
return $str;
}
//==================================

$get = $_GET[get];

$obj_category->jyoken                         = array();
$obj_category->jyoken["cg_clid"]              = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]              = 1;
$obj_category->jyoken["cg_type"]              = 1;
$obj_category->jyoken["cg_deldate"]           = 1;
$obj_category->sort["cg_dispno"]              = 2;
$obj_category->categorydat                    = array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispno="";
$dispno=count($obj_category->categorydat)-1;
if($dispno>=0){
		  $obj_article                                = new basedb_ArticleClassTblAccess;
		  $obj_article->conn                          = $obj_conn->conn;
		  $obj_article->jyoken                        = array();
		  $obj_article->jyoken["ac_clid"]             = $obj_login->clientdat[0]['cl_id'];
		  $obj_article->jyoken["ac_stat"]             = 1;
		  //
		  $obj_article->jyoken["ac_id"]               = $get;
		  $obj_article->jyoken["ac_cateid"]           = $obj_category->categorydat[$key1]['cg_id'];
		  $obj_article->jyoken["ac_deldate"]          = 1;
		  $obj_article->sort["ac_dispno"]             = 1;
		  $obj_article->articledat                    = array();
		  list( $intCnt_article , $intTotal_article ) = $obj_article->basedb_GetArticle ( 1 , -1 );
		  $dispno                                     = "";
		  $img_path                                   = "";
		  $dispno                                     = count($obj_article->articledat)-1;
//print_r($obj_article->articledat);

//print($obj_article->articledat[0][ac_contents]);
//print($obj_article->articledat[0][ac_img]);


$ac_title    = htmlspecialchars($obj_article->articledat[0][ac_title]);

//$ac_contents = htmlspecialchars($obj_article->articledat[0][ac_contents]);
$ac_contents = strip_between_tag($obj_article->articledat[0][ac_contents],$srr_tag);
$ac_contents = strip_tags($ac_contents);
$ac_contents = htmlspecialchars($ac_contents);
$ac_contents = nl2br($ac_contents);
$ac_img      = htmlspecialchars($obj_article->articledat[0][ac_img]);


if($dispno>=0){
					 foreach($obj_article->articledat as $key2=>$val2){

						  $temp=$obj_article->articledat[$key2]['ac_img'];
//print_r($obj_article->articledat);
if($temp==""){}else{
	$imgB='<img src="./img_thumbnail.php?w=120&h=80&dir='.$param_article_img_path.'&nm='.$obj_article->articledat[$key2]['ac_img'].'" alt="" />
';
}		
}
}

}
//画像を表示する処理
if($obj_login->clientdat[0]['sc_topimg']){
		  $img_path='
					 <p class="marginr1">
					 <img src="./img_thumbnail.php?w=200&h=205&dir='.$param_cl_photo_path.'&nm='.$obj_login->clientdat[0]['sc_topimg'].'" alt="" />
					 </p>
					 ';
}else{//画像がなかったら
		  $img_path='
					 <p class="marginr1">
					 </p>
					 ';
}

$imgA= $img_path;

?>
