<?php
/**********************************************************************

  ユーザー画面用タグ置換関数

**********************************************************************/
function html_replace( $str , $img_name1 , $img_name2 , $img_name3 , $img_name4 )
{
	require ( "./ini_sets_1.php" );
	require ( SYS_PATH."configs/param_html.conf" );
	require ( SYS_PATH."configs/param_file.conf" );


	$str = preg_replace_callback("/\[A\=\'(.*)\'\](.*)\[\/A\]/","TagReplace_URL",$str);


	foreach( $param_html_replace[id] as $key => $val ){
		// 置換処理
		$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
		$str_mem = $str;	// 置換後比較用変数
		while( $flg == 9 ){
			if($str!="")$str_mem = $str;
			$str = ereg_replace($param_html_replace[seiki][$key] ,$param_html_replace[after][$key] ,$str_mem);
			if($str == $str_mem)$flg = 1;
		}
	}

	$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
	$str_mem = $str;	// 置換後比較用変数
	while( $flg == 9 ){
		if( $str != "" )$str_mem = $str;
		if( $img_name1 != "" ){
			$str = ereg_replace( '(\[IMG1\])' , '<IMG SRC="./img_thumbnail.php?w=150&h=150&dir='.$param_diary_img_1_path.'&nm='.$img_name1.'">' , $str_mem );
		}else{
			$str = ereg_replace( '(\[IMG1\])' , '' , $str_mem );
		}
		if($str == $str_mem)$flg = 1;
	}

	$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
	$str_mem = $str;	// 置換後比較用変数
	while( $flg == 9 ){
		if($str!="")$str_mem = $str;
		if($img_name2 != ""){
			$str = ereg_replace('(\[IMG2\])','<IMG SRC="./img_thumbnail.php?w=150&h=150&dir='.$param_diary_img_2_path.'&nm='.$img_name2.'">',$str_mem);
		}else{
			$str = ereg_replace('(\[IMG2\])','',$str_mem);
		}
		if($str == $str_mem)$flg = 1;
	}

	$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
	$str_mem = $str;	// 置換後比較用変数
	while( $flg == 9 ){
		if($str!="")$str_mem = $str;
		if($img_name3 != ""){
			$str = ereg_replace('(\[IMG3\])','<IMG SRC="./img_thumbnail.php?w=150&h=150&dir='.$param_diary_img_3_path.'&nm='.$img_name3.'">',$str_mem);
		}else{
			$str = ereg_replace('(\[IMG3\])','',$str_mem);
		}
		if($str == $str_mem)$flg = 1;
	}

	$flg = 9;		// 置換完了フラグ 9:置換続行  1:置換終了
	$str_mem = $str;	// 置換後比較用変数
	while( $flg == 9 ){
		if($str!="")$str_mem = $str;
		if($img_name4 != ""){
			$str = ereg_replace('(\[IMG4\])','<IMG SRC="./img_thumbnail.php?w=150&h=150&dir='.$param_diary_img_4_path.'&nm='.$img_name4.'">',$str_mem);
		}else{
			$str = ereg_replace('(\[IMG4\])','',$str_mem);
		}
		if($str == $str_mem)$flg = 1;
	}
	
	return $str;
}


function TagReplace_URL($arr)
{
              $str = ereg_replace("\[A\=\'(.*)\'\](.*)\[/A\]" , "<a href=\"\\1\" target=\"_blank\">\\2</a>" , $arr[0]);

        return($str);
}
?>
