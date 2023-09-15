<?php
/*=======================================================
    エリア検索用処理
=======================================================*/
if( isset( $_GET['ar_flg'] ) && $_GET['ar_flg'] != "" ){

	$area_name = "";
	$_GET['ar'] = array();
	switch ( $_GET['ar_flg'] ){
		case 1:
			$_GET['ar'] = array( 1 );                          //北海道
			$area_name = "北海道";
			break;
		case 2:
			$_GET['ar'] = array( 2,3,4,5,6,7 );                //東北
			$area_name = "東北";
			break;
		case 3:
			$_GET['ar'] = array( 8,9,10,11,12,13,14 );         //関東
			$area_name = "関東";
			break;
		case 4:
			$_GET['ar'] = array( 15,16,17,18,19,20 );          //北陸
			$area_name = "北陸・甲信越";
			break;
		case 5:
			$_GET['ar'] = array( 21,22,23,24 );                //東海
			$area_name = "東海";
			break;
		case 6:
			$_GET['ar'] = array( 25,26,27,28,29,30 );          //関西
			$area_name = "関西";
			break;
		case 7:
			$_GET['ar'] = array( 31,32,33,34,35,36,37,38,39 ); //四国
			$area_name = "中国・四国";
			break;
		case 8:
			$_GET['ar'] = array( 40,41,42,43,44,45,46,47 );    //九州
			$area_name = "九州";
			break;
		default :
			$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , "/" , $arrErr );
			exit;
	}
	
	//エリア用のtitle,keywords,descriptionを作成
		
		//エリア毎に県名の羅列を作成
		$pref_name_list1 = "";
		$pref_name_list2 = "";	
		foreach( $_GET['ar'] as $ar_key => $ar_val){
			//カンマ区切り県名リスト
			$pref_name_list1 .= ",".$psel[$ar_val];

			//・区切り県名リスト
			if( $pref_name_list2 != "" ) $pref_name_list2 .= "・";
			$pref_name_list2 .= $psel[$ar_val];
		}
	
		//title
		$view_header_title = "";
		$view_header_title = $area_name.'の学習塾を探す（'.$pref_name_list2.'）｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "学習塾,進学塾,個別指導,中学受験,塾タウン,".$area_name.$pref_name_list1;
		//description
		$view_header_description = "";
		$view_header_description = '塾タウンのエリアから検索ページ（'.$area_name.'版）です。'.$pref_name_list2.'の学習塾を検索できます。塾タウンは学習塾・進学塾探しのポータルサイトです。';
		$view_header_description .= '地域や目的（受験対策・補修）、指導形態（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単検索！';
	
}

if( isset( $_GET['ar'] ) && is_array( $_GET['ar'] ) && count( $_GET['ar'] ) > 0 ){

	//県コードに重複があったら省く
	$_GET['ar'] = array_unique( $_GET['ar'] );

	//hiddenでar[]を作成
	$view_hidden_list = "";
	foreach( $_GET['ar'] as $key => $val ){
		$view_hidden_list .= '<input type="hidden" name="ar[]" value="'.$val.'">'."\n";
	}

	$view_select_pref = ""; 
	switch( true ){//検索する県コード郡がエリアの県コードと同じならFLASHを挿入
	
		/*=======================================================
		    北海道エリアの処理
		=======================================================*/
		case ( $_GET['ar_flg'] == 1 ):
		
			$view_select_pref .= '<div class="areasearch4_01">&nbsp;</div><!--search start-->'."\n";
			$view_select_pref .= '<div class="areasearch4_02">'."\n";
			$view_select_pref .= '<table>'."\n";
			$view_select_pref .= '<tr>'."\n";
			$view_select_pref .= '<td class="td4a">'."\n";
			$view_select_pref .= '<div class="flash3">'."\n";
			$view_select_pref .= '<script type="text/javascript">'."\n";
			$view_select_pref .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','190','height','127','title','area_hokkaido','src','share/css/css1/images/hokkaido','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/hokkaido' ); //end AC code \n";
			$view_select_pref .= '</script><noscript>'."\n";
			$view_select_pref .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="190" height="127" title="area_hokkaido">'."\n";
			$view_select_pref .= '<param name="movie" value="share/css/css1/images/hokkaido.swf">'."\n";
			$view_select_pref .= '<param name="quality" value="high">'."\n";
			$view_select_pref .= '<param name="width" value="190">'."\n";
			$view_select_pref .= '<param name="hegiht" value="127">'."\n";
			$view_select_pref .= '<param name="type" value="application/x-shockwave-flash">'."\n";
			$view_select_pref .= '</object></noscript>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '<td>'."\n";
			$view_select_pref .= '<div class="arealist">'."\n";

			$cnt = 0;
			foreach( $_GET['ar'] as $ar_val ){
				$cnt++;
				if( $cnt%3 == 0 ){
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
//					$view_select_pref .= '<div class="clear"></div>'."\n";
				}else{
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
				}
				unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);
			}
			
			$view_select_pref .= '<div class="clear"></div>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '</tr>'."\n";
			$view_select_pref .= '</table>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '<div class="areasearch4_03">&nbsp;</div><!--search end-->'."\n";

			break;

		/*=======================================================
		   東北エリアの処理
		=======================================================*/
		case ( $_GET['ar_flg'] == 2 ):

			$view_select_pref .= '<div class="areasearch4_01">&nbsp;</div><!--search start-->'."\n";
			$view_select_pref .= '<div class="areasearch4_02">'."\n";
			$view_select_pref .= '<table>'."\n";
			$view_select_pref .= '<tr>'."\n";
			$view_select_pref .= '<td class="td4a">'."\n";
			$view_select_pref .= '<div class="flash3">'."\n";
			$view_select_pref .= '<script type="text/javascript">'."\n";
			$view_select_pref .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','190','height','169','src','share/css/css1/images/tohoku','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/tohoku' ); //end AC code \n";
			$view_select_pref .= '</script><noscript>'."\n";
			$view_select_pref .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="190" height="169">'."\n";
			$view_select_pref .= '<param name="movie" value="share/css/css1/images/tohoku.swf">'."\n";
			$view_select_pref .= '<param name="quality" value="high">'."\n";
			$view_select_pref .= '<param name="width" value="190">'."\n";
			$view_select_pref .= '<param name="hegiht" value="169">'."\n";
			$view_select_pref .= '<param name="type" value="application/x-shockwave-flash">'."\n";
			$view_select_pref .= '</object></noscript>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '<td>'."\n";
			$view_select_pref .= '<div class="arealist">'."\n";

			$cnt = 0;
			foreach( $_GET['ar'] as $ar_val ){
			
				$cnt++;
				if( $cnt%3 == 0 ){
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
//					$view_select_pref .= '<div class="clear"></div>'."\n";
				}else{
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
				}
				unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);
			}
			
			$view_select_pref .= '<div class="clear"></div>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '</tr>'."\n";
			$view_select_pref .= '</table>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '<div class="areasearch4_03">&nbsp;</div><!--search end-->'."\n";

			break;

		/*=======================================================
		   関東エリアの処理
		=======================================================*/
		case ( $_GET['ar_flg'] == 3 ):

			$view_select_pref .= '<div class="areasearch4_01">&nbsp;</div><!--search start-->'."\n";
			$view_select_pref .= '<div class="areasearch4_02">'."\n";
			$view_select_pref .= '<table>'."\n";
			$view_select_pref .= '<tr>'."\n";
			$view_select_pref .= '<td class="td4a">'."\n";
			$view_select_pref .= '<div class="flash3">'."\n";
			$view_select_pref .= '<script type="text/javascript">'."\n";
			$view_select_pref .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','190','height','167','src','share/css/css1/images/kanto','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/kanto' ); //end AC code \n";
			$view_select_pref .= '</script><noscript>'."\n";
			$view_select_pref .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="190" height="167">'."\n";
			$view_select_pref .= '<param name="movie" value="share/css/css1/images/kanto.swf">'."\n";
			$view_select_pref .= '<param name="quality" value="high">'."\n";
			$view_select_pref .= '<param name="width" value="190">'."\n";
			$view_select_pref .= '<param name="hegiht" value="167">'."\n";
			$view_select_pref .= '<param name="type" value="application/x-shockwave-flash">'."\n";
			$view_select_pref .= '</object></noscript>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '<td>'."\n";
			$view_select_pref .= '<div class="arealist">'."\n";

			$cnt = 0;
			foreach( $_GET['ar'] as $ar_val ){
			
				$cnt++;
				if( $cnt%3 == 0 ){
//					$view_select_pref .= '<div class="clear"></div>'."\n";
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
				}else{
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
				}
				unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);
			}
			
			$view_select_pref .= '<div class="clear"></div>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '</tr>'."\n";
			$view_select_pref .= '</table>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '<div class="areasearch4_03">&nbsp;</div><!--search end-->'."\n";

			break;

		/*=======================================================
		   北陸エリアの処理
		=======================================================*/
		case ( $_GET['ar_flg'] == 4 ):

			$view_select_pref .= '<div class="areasearch4_01">&nbsp;</div><!--search start-->'."\n";
			$view_select_pref .= '<div class="areasearch4_02">'."\n";
			$view_select_pref .= '<table>'."\n";
			$view_select_pref .= '<tr>'."\n";
			$view_select_pref .= '<td class="td4a">'."\n";
			$view_select_pref .= '<div class="flash3">'."\n";
			$view_select_pref .= '<script type="text/javascript">'."\n";
			$view_select_pref .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','190','height','172','src','share/css/css1/images/hokuriku','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/hokuriku' ); //end AC code \n";
			$view_select_pref .= '</script><noscript>'."\n";
			$view_select_pref .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="190" height="172">'."\n";
			$view_select_pref .= '<param name="movie" value="share/css/css1/images/hokuriku.swf">'."\n";
			$view_select_pref .= '<param name="quality" value="high">'."\n";
			$view_select_pref .= '<param name="width" value="190">'."\n";
			$view_select_pref .= '<param name="hegiht" value="172">'."\n";
			$view_select_pref .= '<param name="type" value="application/x-shockwave-flash">'."\n";
			$view_select_pref .= '</object></noscript>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '<td>'."\n";
			$view_select_pref .= '<div class="arealist">'."\n";

			$cnt = 0;
			foreach( $_GET['ar'] as $ar_val ){
			
				$cnt++;
				if( $cnt%3 == 0 ){
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
//					$view_select_pref .= '<div class="clear"></div>'."\n";
				}else{
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
				}
				unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);
			}
			
			$view_select_pref .= '<div class="clear"></div>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '</tr>'."\n";
			$view_select_pref .= '</table>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '<div class="areasearch4_03">&nbsp;</div><!--search end-->'."\n";

			break;

		/*=======================================================
		   東海エリアの処理
		=======================================================*/
		case ( $_GET['ar_flg'] == 5 ):

			$view_select_pref .= '<div class="areasearch4_01">&nbsp;</div><!--search start-->'."\n";
			$view_select_pref .= '<div class="areasearch4_02">'."\n";
			$view_select_pref .= '<table>'."\n";
			$view_select_pref .= '<tr>'."\n";
			$view_select_pref .= '<td class="td4a">'."\n";
			$view_select_pref .= '<div class="flash3">'."\n";
			$view_select_pref .= '<script type="text/javascript">'."\n";
			$view_select_pref .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','190','height','148','src','share/css/css1/images/tokai','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/tokai' ); //end AC code \n";
			$view_select_pref .= '</script><noscript>'."\n";
			$view_select_pref .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="190" height="148">'."\n";
			$view_select_pref .= '<param name="movie" value="share/css/css1/images/tokai.swf">'."\n";
			$view_select_pref .= '<param name="quality" value="high">'."\n";
			$view_select_pref .= '<param name="width" value="190">'."\n";
			$view_select_pref .= '<param name="hegiht" value="148">'."\n";
			$view_select_pref .= '<param name="type" value="application/x-shockwave-flash">'."\n";
			$view_select_pref .= '</object></noscript>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '<td>'."\n";
			$view_select_pref .= '<div class="arealist">'."\n";

			$cnt = 0;
			foreach( $_GET['ar'] as $ar_val ){
			
				$cnt++;
				if( $cnt%3 == 0 ){
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
//					$view_select_pref .= '<div class="clear"></div>'."\n";
				}else{
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
				}
				unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);
			}
			
			$view_select_pref .= '<div class="clear"></div>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '</tr>'."\n";
			$view_select_pref .= '</table>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '<div class="areasearch4_03">&nbsp;</div><!--search end-->'."\n";

			break;

		/*=======================================================
		   関西エリアの処理
		=======================================================*/
		case ( $_GET['ar_flg'] == 6 ):

			$view_select_pref .= '<div class="areasearch4_01">&nbsp;</div><!--search start-->'."\n";
			$view_select_pref .= '<div class="areasearch4_02">'."\n";
			$view_select_pref .= '<table>'."\n";
			$view_select_pref .= '<tr>'."\n";
			$view_select_pref .= '<td class="td4a">'."\n";
			$view_select_pref .= '<div class="flash3">'."\n";
			$view_select_pref .= '<script type="text/javascript">'."\n";
			$view_select_pref .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','190','height','174','src','share/css/css1/images/kansai','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/kansai' ); //end AC code \n";
			$view_select_pref .= '</script><noscript>'."\n";
			$view_select_pref .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="190" height="174">'."\n";
			$view_select_pref .= '<param name="movie" value="share/css/css1/images/kansai.swf">'."\n";
			$view_select_pref .= '<param name="quality" value="high">'."\n";
			$view_select_pref .= '<param name="width" value="190">'."\n";
			$view_select_pref .= '<param name="hegiht" value="174">'."\n";
			$view_select_pref .= '<param name="type" value="application/x-shockwave-flash">'."\n";
			$view_select_pref .= '</object></noscript>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '<td>'."\n";
			$view_select_pref .= '<div class="arealist">'."\n";

			$cnt = 0;
			foreach( $_GET['ar'] as $ar_val ){
			
				$cnt++;
				if( $cnt%3 == 0 ){
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
//					$view_select_pref .= '<div class="clear"></div>'."\n";
				}else{
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
				}
				unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);
			}
			
			$view_select_pref .= '<div class="clear"></div>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '</tr>'."\n";
			$view_select_pref .= '</table>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '<div class="areasearch4_03">&nbsp;</div><!--search end-->'."\n";

			break;

		/*=======================================================
		   四国エリアの処理
		=======================================================*/
		case ( $_GET['ar_flg'] == 7 ):

			$view_select_pref .= '<div class="areasearch4_01">&nbsp;</div><!--search start-->'."\n";
			$view_select_pref .= '<div class="areasearch4_02">'."\n";
			$view_select_pref .= '<table>'."\n";
			$view_select_pref .= '<tr>'."\n";
			$view_select_pref .= '<td class="td4a">'."\n";
			$view_select_pref .= '<div class="flash3">'."\n";
			$view_select_pref .= '<script type="text/javascript">'."\n";
			$view_select_pref .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','190','height','174','src','share/css/css1/images/shikoku','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/shikoku' ); //end AC code \n";
			$view_select_pref .= '</script><noscript>'."\n";
			$view_select_pref .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="190" height="174">'."\n";
			$view_select_pref .= '<param name="movie" value="share/css/css1/images/shikoku.swf">'."\n";
			$view_select_pref .= '<param name="quality" value="high">'."\n";
			$view_select_pref .= '<param name="width" value="190">'."\n";
			$view_select_pref .= '<param name="hegiht" value="174">'."\n";
			$view_select_pref .= '<param name="type" value="application/x-shockwave-flash">'."\n";
			$view_select_pref .= '</object></noscript>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '<td>'."\n";
			$view_select_pref .= '<div class="arealist">'."\n";

			$cnt = 0;
			foreach( $_GET['ar'] as $ar_val ){
			
				$cnt++;
				if( $cnt%3 == 0 ){
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
//					$view_select_pref .= '<div class="clear"></div>'."\n";
				}else{
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
				}
				unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);
			}
			
			$view_select_pref .= '<div class="clear"></div>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '</tr>'."\n";
			$view_select_pref .= '</table>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '<div class="areasearch4_03">&nbsp;</div><!--search end-->'."\n";

			break;

		/*=======================================================
		   九州エリアの処理
		=======================================================*/
		case ( $_GET['ar_flg'] == 8 ):

			$view_select_pref .= '<div class="areasearch4_01">&nbsp;</div><!--search start-->'."\n";
			$view_select_pref .= '<div class="areasearch4_02">'."\n";
			$view_select_pref .= '<table>'."\n";
			$view_select_pref .= '<tr>'."\n";
			$view_select_pref .= '<td class="td4a">'."\n";
			$view_select_pref .= '<div class="flash3">'."\n";
			$view_select_pref .= '<script type="text/javascript">'."\n";
			$view_select_pref .= "AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','190','height','204','src','share/css/css1/images/kyushu','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/kyushu' ); //end AC code \n";
			$view_select_pref .= '</script><noscript>'."\n";
			$view_select_pref .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="190" height="204">'."\n";
			$view_select_pref .= '<param name="movie" value="share/css/css1/images/kyushu.swf">'."\n";
			$view_select_pref .= '<param name="quality" value="high">'."\n";
			$view_select_pref .= '<param name="width" value="190">'."\n";
			$view_select_pref .= '<param name="hegiht" value="204">'."\n";
			$view_select_pref .= '<param name="type" value="application/x-shockwave-flash">'."\n";
			$view_select_pref .= '</object></noscript>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '<td>'."\n";
			$view_select_pref .= '<div class="arealist">'."\n";

			$cnt = 0;
			foreach( $_GET['ar'] as $ar_val ){
			
				$cnt++;
				if( $cnt%3 == 0 ){
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
//					$view_select_pref .= '<div class="clear"></div>'."\n";
				}else{
					$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
				}
				unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);
			}
			
			$view_select_pref .= '<div class="clear"></div>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '</td>'."\n";
			$view_select_pref .= '</tr>'."\n";
			$view_select_pref .= '</table>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '<div class="areasearch4_03">&nbsp;</div><!--search end-->'."\n";

			break;
			
			
		/*=======================================================
		   県指定時の処理
		=======================================================*/
		default:

			//県指定時のtitle,keywords,descriptionを作成
				
				//県名の羅列を作成
				$pref_name_list1 = "";
				$pref_name_list2 = "";	
				foreach( $_GET['ar'] as $ar_key => $ar_val){
					//カンマ区切り県名リスト
					$pref_name_list1 .= ",".$psel[$ar_val];
		
					//・区切り県名リスト
					if( $pref_name_list2 != "" ) $pref_name_list2 .= "・";
					$pref_name_list2 .= $psel[$ar_val];
				}
			
				//title
				$view_header_title = "";
				$view_header_title = $pref_name_list2.'の学習塾を探す｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
				//keywords
				$view_header_keywoeds = "";
				$view_header_keywoeds = '学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校'.$pref_name_list1;
				//description
				$view_header_description = "";
				$view_header_description = '塾タウンのエリアから検索ページ（'.$pref_name_list2.'）です。塾タウンは学習塾・進学塾探しのポータルサイトです。';
				$view_header_description .= '地域や目的（受験対策・補修）、指導形態（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';

			//見出し表示内容生成
			$view_select_pref .= '<h3 class="orange">選択した県</h3>'."\n";
			$view_select_pref .= '<div class="box">'."\n";
			$view_select_pref .= '<table class="search1">'."\n";
			$view_select_pref .= '<tr>'."\n";
			$view_select_pref .= '<td><div class="area">'."\n";

			foreach( $_GET['ar'] as $ar_val ){
				$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
			}
			unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat,$view_prefdat);
			
			$view_select_pref .= '</div></td>'."\n";
			$view_select_pref .= '</tr>'."\n";
			$view_select_pref .= '</table>'."\n";
			$view_select_pref .= '</div>'."\n";
			$view_select_pref .= '<br>'."\n";

			break;
	}



	$view_scitycnt = array();
	foreach( $_GET['ar'] as $ar_val ){
		//一覧データ処理
		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    市　件数抽出処理
		=======================================================*/
		$obj_scitycnt = new viewdb_SCityClassTblAccess;
		$obj_scitycnt->conn = $obj_conn->conn;
		$obj_scitycnt->jyoken = array(); 
		$obj_scitycnt->jyoken["ar_prefcd"] = $ar_val;
		$ret = $obj_scitycnt->viewdb_CntSCity( 1 , -1);
		foreach( $obj_scitycnt->scitydat as $key => $val ){
			foreach( $val as $key2 => $val2 ){
				if( is_numeric( $key2 ) ){
					unset( $obj_scitycnt->scitydat[$key][$key2] );
				}else{
					$view_scitycnt[$ar_val][$key][$key2] = $obj_scitycnt->scitydat[$key][$key2];
				}
			}
		}
	}
	unset($key, $key2, $val, $val2, $obj_scitycnt->scitydat);
	
	
	foreach( $_GET['ar'] as $ar_key => $ar_val ){
	
		if( is_array( $view_scitycnt[$ar_val] ) && count( $view_scitycnt[$ar_val] ) > 0 ){
			
			$cnt = 0;
			foreach( $view_scitycnt[$ar_val] as $city_key => $city_val ){
			
				if( $city_key == 0 ){
					$view_city_list .= '<a name="'.$ar_val.'"></a>'."\n";
					$view_city_list .= '<h3>'.$psel[$ar_val].'</h3>'."\n";
					$view_city_list .= '<div class="box">'."\n";
					$view_city_list .= '<table class="search1">'."\n";
					$view_city_list .= '<tr>';
					$view_city_list .= '<td><p class="area">'."\n";
				}
				
				$view_city_list .= '<label class="pl"><input type="checkbox" name="pf[]" value="'.$view_scitycnt[$ar_val][$city_key]['ar_citycd'].'"> <a href="/psearch-result/page-1.html?ar[]='.$ar_val.'&pf[]='.$view_scitycnt[$ar_val][$city_key]['ar_citycd'].'&mode=ar">'.$view_scitycnt[$ar_val][$city_key]['ar_city'].'（'.$view_scitycnt[$ar_val][$city_key]['count'].'件）</a></label>';
			}
			
//			$view_city_list .= '<br>'."\n";
			$view_city_list .= '</p></td>'."\n";
			$view_city_list .= '</tr>'."\n";
			$view_city_list .= '</table>'."\n";
			$view_city_list .= '</div>'."\n";
			
		}else{
		
			$view_city_list .= '<a name="'.$ar_val.'"></a>'."\n";
			$view_city_list .= '<h3>'.$psel[$ar_val].'</h3>'."\n";
			$view_city_list .= '<div class="box">'."\n";
			$view_city_list .= '<table class="search1">'."\n";
			$view_city_list .= '<tr>'."\n";
			$view_city_list .= '<td><p class="area">'."\n";
			/*if( isset( $_GET['ar_flg'] ) )*/$view_city_list .='現在、掲載中の学習塾はございません。 順次掲載予定となっております。';
			$view_city_list .= '<br>'."\n";
			$view_city_list .= '</p></td>'."\n";
			$view_city_list .= '</tr>'."\n";
			$view_city_list .= '</table>'."\n";
			$view_city_list .= '</div>'."\n";
		}
	}
	$view_city_list .= $view_hidden_list;
}else{
	$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , "/" , $arrErr );
	exit;
}

?>