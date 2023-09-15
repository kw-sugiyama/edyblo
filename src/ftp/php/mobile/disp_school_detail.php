<?
//==================================
//school_detailで使う変数
//testimg
//school_list
//==================================

//mark 定数■
$mark= "<font size=\"1\" color=\"#C5BE97\">■</font><font size=\"1\">";

$obj_area                             = new basedb_AreaClassTblAccess;
$obj_area->conn                       = $obj_conn->conn;
$obj_area->jyoken["ar_clid"]          = $obj_login->clientdat[0]['cl_id'];
$obj_area->sort['ar_flg']             = 2;
$obj_area->areadat                    = array();
list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );
$area['address']                      = $obj_area->areadat[0]['ar_pref'].$obj_area->areadat[0]['ar_city'].$obj_area->areadat[0]['ar_add']." ".$obj_area->areadat[0]['ar_estate'];

//未入力項目は「−」を表示
if($obj_login->clientdat[0]['cl_kname']){
$cl_kname   = $obj_login->clientdat[0]['cl_kname'];
}else{
$cl_kname   = "−";
}
if($obj_login->clientdat[0]['sc_company']){
$sc_company = $obj_login->clientdat[0]['sc_company'];
}else{
$sc_company = "−";
}
if($obj_login->clientdat[0]['cl_phone']){
$cl_phone   = $obj_login->clientdat[0]['cl_phone'];
}else{
$cl_phone   = "−";
}
if($obj_login->clientdat[0]['cl_fax']){
$cl_fax     = $obj_login->clientdat[0]['cl_fax'];
}else{
$cl_fax     = "−";
}

//ブログイメージパス
if($obj_login->clientdat[0]['sc_topimg']){
		  $img_path='
					 <p class="marginr1">
					 <img src="./img_thumbnail.php?w=200&h=205&dir='.$param_cl_photo_path.'&nm='.$obj_login->clientdat[0]['sc_topimg'].'" alt=""   />
					 </p>
					 ';
}else{
		  $img_path='
					 <p class="marginr1">
					 </p>
					 ';
}

//変数にイメージを入れる（ブログ）
$testimg = $img_path;

//教室詳細ボックス
$school_listt.='
		  <div class="box"><!--box start-->
		  <span class="white">'.$obj_login->clientdat[0]['sc_toptitle'].'</span>
		  '.$img_path.'
		  <p>塾　名</p>
		  <p> 教室名</p>
		  <p>'.htmlspecialchars($obj_login->clientdat[0]['cl_jname']).'</p>
		  <p>'.htmlspecialchars($cl_kname).'</p>
		  <p>運営会社</p>
		  <p>'.htmlspecialchars($sc_company).'</p>
		  <p>住　所</p>
		  <p>'.htmlspecialchars($area['address']).'</p>
		  <p>電話番号</p>
		  <p>'.$cl_phone.'</p>
		  <p>ＦＡＸ</p>
		  <p>'.$cl_fax.'</p>
		  <p>受付時間</p>
		  <p>'.ltrim($obj_login->clientdat[0]['sc_start'],"0").' 〜 '.ltrim($obj_login->clientdat[0]['sc_end'],"0").'</p>
		  <p>定休日</p>
		  <p>'.htmlspecialchars($obj_login->clientdat[0]['sc_holiday']).'</p>
		  </div><!--box end-->
		  ';

$obj_category->jyoken                               = array();
$obj_category->jyoken["cg_clid"]                    = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]                    = 1;
$obj_category->jyoken["cg_type"]                    = 1;
$obj_category->jyoken["cg_deldate"]                 = 1;
$obj_category->sort["cg_dispno"]                    = 2;
$obj_category->categorydat                          = array();
list( $intCnt_category , $intTotal_category )       = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispno="";
$dispno=count($obj_category->categorydat)-1;
if($dispno>=0){
		  foreach($obj_category->categorydat as $key1 =>$val1){
		  $obj_article                                = new basedb_ArticleClassTblAccess;
		  $obj_article->conn                          = $obj_conn->conn;
		  $obj_article->jyoken                        = array();
		  $obj_article->jyoken["ac_clid"]             = $obj_login->clientdat[0]['cl_id'];
		  $obj_article->jyoken["ac_stat"]             = 1;
		  $obj_article->jyoken["ac_cateid"]           = $obj_category->categorydat[$key1]['cg_id'];
		  $obj_article->jyoken["ac_deldate"]          = 1;
		  $obj_article->sort["ac_dispno"]             = 1;
		  $obj_article->articledat                    = array();
		  list( $intCnt_article , $intTotal_article ) = $obj_article->basedb_GetArticle ( 1 , -1 );
		  $dispno                                     = "";
		  $img_path                                   = "";
					 $dispno=count($obj_article->articledat)-1;
		  if($dispno>=0){
					 foreach($obj_article->articledat as $key2=>$val2){
								// echo $obj_article->articledat[$key2][ac_id] ;
								$page = $obj_article->articledat[$key2][0];
								//urint($obj_article->articledat[$key2][0]);
								//
								//print_r($obj_article->articledat[$key2]);
								if($obj_article->articledat[$key2]['ac_img']){
										  $img_path='
													 <!--<p class="marginr1">携帯電話画像URL
													 <img src="./img_thumbnail.php?w=150&h=120&dir='.$param_article_img_path.'&nm='.$obj_article->articledat[$key2]['ac_img'].'" alt="" />
													 <br />-->
													 ';
								}else{
										  $img_path="";
								}
								if($key2==0){
										  $school_list.='
													 <div class="boxlittle"><!--box start-->                      
													'.$mark.'
													 </a><span class="white">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span>
													 ';
								}
								if($img_path){
										  /////
										  if($key2==$dispno){
												$school_list.='
													 <font size="1">
																<br />┗<a href="../school_detaild/p'.$page.'/"><span class="blue2">
<font size="1" color="#666666">
																'.htmlspecialchars($obj_article->articledat[$key2]['ac_title']).'</span>
																</a>
</font>
																';
										  }else{
													 $school_list.='
														  <font size="1">
																<br />┣<a href="../school_detaild/p'.$page.'/"><span class="blue2">
<font  size="1" color="#666666">
																'.htmlspecialchars($obj_article->articledat[$key2]['ac_title']).'</span>
																</a>
</font>
																<!--<p>'.nl2br($obj_article->articledat[$key2]['ac_contents']).'</p>-->
																';
										  }
								}else{
										  //必要箇所
										  if($key2==$dispno){
													 $school_list.='					                  
														  <font size="1">
																<br>┗<a href="../school_detaild/p'.$page.'/"><span class="blue2">
<font  size="1" color="#666666">
																'.htmlspecialchars($obj_article->articledat[$key2]['ac_title']).'</span>
																</a>
</font>
																<!--<p>'.nl2br($obj_article->articledat[$key2]['ac_contents']).'</p>-->
																';
										  }else{
													 $school_list.='					                  
														  <font size="1">
																<br>┣<a href="../school_detaild/p'.$page.'/"><span class="blue2">
<font size="1" color="#666666">
																'.htmlspecialchars($obj_article->articledat[$key2]['ac_title']).'
																</a>
</font>
																</span>
																';
										  }
								}
					 }
					 $school_list.='	
								</div><!--boxlittle end-->';
		  }else{
								$school_list.='
										  <div class="boxlittle"><!--box start-->                      
											'.$mark.'
										  </a><span>'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span>
										  </div><!--boxlittle end-->';
					 }
		  }
}

///foreach end
$school_lista.='
		  <div class="boxlittle "><!-- boxlittle start -->
		  <div id="gmap" style="width: 530px; height: 277px; overflow:hidden;border:1px solid #000000">
		  <noscript><br /><font style="color:#FF0000;font-size:10px;">※JavaScriptが有効でない場合、機能しません。</font></noscript>
		  </div>
		  <center><input type="button" value="元に戻す" style="width:100px;height:25px;" onclick="replace('.$obj_login->clientdat[0]['sc_ido'].','.$obj_login->clientdat[0]['sc_keido'].','.$obj_login->clientdat[0]['sc_zoom'].')" /></center>
		  <input type="hidden" name="marker_flg" value="" id="marker_flg" />
		  </div><!-- boxlittle end -->
		  ';

?>
