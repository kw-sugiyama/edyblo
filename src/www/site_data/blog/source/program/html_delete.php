<?php
/**********************************************************************

  �����ġ����ѥ����ִ��ؿ�

**********************************************************************/
function html_delete($str)
{

	require ( SYS_PATH."/configs/param_html.conf" );
	require ( SYS_PATH."/configs/param_file.conf" );

	$str = preg_replace_callback("/\[A\=\'(.*)\'\](.*)\[\/A\]/","TagReplace_URL2",$str);


	foreach( $param_html_replace[id] as $key => $val ){
		// �ִ�����
		$flg = 9;		// �ִ���λ�ե饰 9:�ִ�³��  1:�ִ���λ
		$str_mem = $str;	// �ִ���������ѿ�
		while( $flg == 9 ){
			if( $str != "" ){
				$str_mem = $str;
			}else{
				break;
			}
			$str = ereg_replace($param_html_replace[seiki][$key] ,"" ,$str_mem);
			if($str == $str_mem)$flg = 1;
		}
	}

	$str_mem = $str;	// �ִ���������ѿ�
	$str = str_replace( '[IMG1]' , '' , $str_mem );

	$str_mem = $str;	// �ִ���������ѿ�
	$str = str_replace( '[IMG2]' , '' , $str_mem );

	$str_mem = $str;	// �ִ���������ѿ�
	$str = str_replace( '[IMG3]' , '' , $str_mem );

	$str_mem = $str;	// �ִ���������ѿ�
	$str = str_replace( '[IMG4]' , '' , $str_mem );
	
	return $str;
}


function TagReplace_URL2($arr)
{
              $str = ereg_replace("\[A\=\'(.*)\'\](.*)\[/A\]" , "\\2" , $arr[0]);

        return($str);
}
?>
