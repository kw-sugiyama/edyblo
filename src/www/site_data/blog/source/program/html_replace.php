<?php
/**********************************************************************

  ユーザー画面用タグ置換関数

**********************************************************************/
function html_replace( $str , $img_name1="" , $img_name2="" , $img_name3="" , $img_name4="" )
{
	require ( "./ini_sets_1.php" );
	require ( SYS_PATH."configs/param_html.conf" );
	require ( SYS_PATH."configs/param_file.conf" );


	$str = preg_replace_callback("/\[A\=\'(.*?)\'\](.*?)\[\/A\]/","TagReplace_URL",$str);


	foreach( $param_html_replace[id] as $key => $val ){
		// 置換処理
		$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
		$str_mem = $str;	// 置換後比較用変数
		while( $flg == 9 ){
			if( $str != "" ){
				$str_mem = $str;
			}else{
				break;
			}
			$str = ereg_replace($param_html_replace[seiki][$key] ,$param_html_replace[after][$key] ,$str_mem);
			if($str == $str_mem)$flg = 1;
		}
	}

	$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
	$str_mem = $str;	// 置換後比較用変数
	while( $flg == 9 ){
		if( $str != "" ){
			$str_mem = $str;
		}else{
			break;
		}
		if( $img_name1 != "" ){
			$str = ereg_replace( '(\[IMG1\])' , '<a href="'.$param_dr_img1_path.$img_name1.'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=218&h=137&dir='.$param_dr_img1_path.'&nm='.$img_name1.'" alt="img1" /></a>' , $str_mem );
		}else{
			$str = ereg_replace( '(\[IMG1\])' , '' , $str_mem );
		}
		if($str == $str_mem)$flg = 1;
	}

	$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
	$str_mem = $str;	// 置換後比較用変数
	while( $flg == 9 ){
		if( $str != "" ){
			$str_mem = $str;
		}else{
			break;
		}
		if($img_name2 != ""){
			$str = ereg_replace('(\[IMG2\])','<a href="'.$param_dr_img2_path.$img_name2.'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=218&h=137&dir='.$param_dr_img2_path.'&nm='.$img_name2.'" alt="img2" /></a>',$str_mem);
		}else{
			$str = ereg_replace('(\[IMG2\])','',$str_mem);
		}
		if($str == $str_mem)$flg = 1;
	}

	$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
	$str_mem = $str;	// 置換後比較用変数
	while( $flg == 9 ){
		if( $str != "" ){
			$str_mem = $str;
		}else{
			break;
		}
		if($img_name3 != ""){
			$str = ereg_replace('(\[IMG3\])','<a href="'.$param_dr_img3_path.$img_name3.'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=218&h=137&dir='.$param_dr_img3_path.'&nm='.$img_name3.'" alt="img3" /></a>',$str_mem);
		}else{
			$str = ereg_replace('(\[IMG3\])','',$str_mem);
		}
		if($str == $str_mem)$flg = 1;
	}

	$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
	$str_mem = $str;	// 置換後比較用変数
	while( $flg == 9 ){
		if( $str != "" ){
			$str_mem = $str;
		}else{
			break;
		}
		if($img_name4 != ""){
			$str = ereg_replace('(\[IMG4\])','<a href="'.$param_dr_img4_path.$img_name4.'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=218&h=137&dir='.$param_dr_img4_path.'&nm='.$img_name4.'" alt="img4" /></a>',$str_mem);
		}else{
			$str = ereg_replace('(\[IMG4\])','',$str_mem);
		}
		if($str == $str_mem)$flg = 1;
	}

	
	/*if($kind==2){
		$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
		$str_mem = $str;	// 置換後比較用変数
		while( $flg == 9 ){
			if( $str != "" ){
				$str_mem = $str;
			}else{
				break;
			}
			if( $img_name1 != "" ){
				$str = ereg_replace( '(\[IMG1\])' , '<a href="'.$param_tc_img_path.$img_name1.'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=84&h=100&dir='.$param_tc_img_path.'&nm='.$img_name1.'" alt="" /></a>' , $str_mem );
			}else{
				$str = ereg_replace( '(\[IMG1\])' , '' , $str_mem );
			}
			if($str == $str_mem)$flg = 1;
		}
		
	}*/
	return $str;
}


function TagReplace_URL($arr)
{
              $str = preg_replace("/\[A='(.*?)'\](.*?)\[\/A\]/" , "<a href=\"\\1\" target=\"_blank\">\\2</a>" , $arr[0]);

        return($str);
}
?>
