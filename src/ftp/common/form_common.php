<?php
/*-------------------------------------------------------
	FORM��Ϣɽ���ؿ���
--------------------------------------------------------*/

//�饸���ܥ�����ɽ��
function form_RadioDisp( $objname,$param,$get,$mode,$option=array() )
{
        //$objname ���֥�������̾
        //$param �ѥ�᡼����
        //$get   ������֤ˤ�����
        //$mode  1:�饸���ܥ�����֤���2:���򤵤줿�ƥ����Ȥ��֤�
        //$option       ��˥��ץ�����ɲ��Ѥ�����

        $ret = NULL;
        switch( $mode )
        {
                default:
                        return(-1);
                        break;

                case "1":
                        for( $i=0;$i<count($param["val"]);$i++ )
                        {
                                if( $get == $param["val"][$i] ) $chk = " checked";
                                else $chk = NULL;
				if( $option[ivent] == 1 ){
					$ivent = "onclick=\"return sendData(this)\"";
				}
                                $ret[] = "<input type=\"radio\" name=\"{$objname}\" value=\"{$param["val"][$i]}\"{$chk} {$ivent}>{$param["name"][$i]}";

                        }
                        $ret = join("\n",$ret);
                        break;
                case "2":
                        for( $i=0;$i<count($param["val"]);$i++ )
                        {
                                if( $get == $param["val"][$i] )
                                {
                                        $ret[] = "{$param["name"][$i]}";
                                }
                        }
                        if( is_array($ret) )
                        {
                        	$ret = join("\n",$ret);
                        }
                        else
                        {
                                $ret = NULL;
                        }
                        break;

        }

        return ($ret);

}

//�������ȥܥ���
function form_ImgDisp( $objname,$dir,$get,$mode,$option=array() )
{
        //$objname ���֥�������̾
        //$dir 	  ������Ǽ�ǥ��쥯�ȥ�
        //$get   ��¸�β����ե�����
        //$mode  1:���ȥܥ�����֤���2:���򤵤줿�ƥ����Ȥ��֤�
        //$option       ��˥��ץ�����ɲ��Ѥ�����
		//$option["org"] = �����Υ��å׸�̾��
		//$option["chk_in"] = ������������å��ܥå�����ɽ������ɽ��
		//                      "1":ɽ������  "9":ɽ�����ʤ�
		//$option["class"] = �����Υ��饹����ꤹ��
		//$option["width"] = �����β�����������ꤹ��
		//$option["height"] = �����β�����������ꤹ��
        $ret = NULL;
        switch( $mode )
        {
                default:
                        return(-1);
                        break;

                case "1":
				//�֥饦���Υ���å��������Τ��ᡢ�ե�����̾���ˤĤ���
				$time = time();

                                $ret[] = "<input type=\"file\" name=\"{$objname}\" value=\"\">";
				//$get = ��¸��ͭ����ϡ������������å�������̾HIDDEN
				if( $get )
				{
					$get = htmlspecialchars( $get );
					if( $option["chk_in"] == 1 ){
	                                	$ret[] = "<input type=\"checkbox\" name=\"{$objname}_del_chk\" value=\"1\">�������˲�����������<br>";
					}
                                	$ret[] = "<input type=\"hidden\" name=\"{$objname}_lastupd\" value=\"{$get}\">";
					if( $option["org"]  )
						$ret[] = "<hr>\n�ڸ������ե�����̾��".htmlspecialchars( $option["org"]  )."��<br>";
					$ret[] = "�ڥ��å׸�β����ե�����̾��".$get."��<br>";
					if( file_exists("{$dir}{$get}") ){
                                		$ret[] = "<img src=\"{$dir}{$get}?{$time}\" />";
					}else{
						$ret[] = "<img src=\"{$dir}no_image.gif\" />";
					}
				}
                        $ret = join("\n",$ret);
                        break;
                case "2":

			//$ret[] = htmlspecialchars( $get );
			if( $get )
			{
                        	list($width, $height, $type, $attr,$mine) = getimagesize("{$dir}{$get}",$image_info);
				//�������̥ѥ�����
                                if( $option["gd"] == "./imgview.php" )
				{
					$ret = "<img src=\"./imgview.php?i=".htmlspecialchars( $get )."\" />";
				}
				else
				{
					$ret = "<img src=\"".htmlspecialchars( $dir.$get )."\" {$attr} />";
				}
				//���饹����ѥ�����
				if( $option["class"] == "1" ){
					if($width <= 270 ){
						$ret = "<img src=\"".htmlspecialchars( $dir.$get )."\" class=\"floatImg\" {$attr} />";
					}else{
						$ret = "<img src=\"".htmlspecialchars( $dir.$get )."\" {$attr} />";
					}
				}
				//����������������ѥ�����
				if( $option["width"] == "2" ){
				$size = explode(" ",$attr);
					$ret = "<img src=\"".htmlspecialchars( $dir.$get )."\" width=\"310\" {$size[1]} /}>";
				}
					
					
			}
			else
			{
				$ret = NULL;
			}
                        break;
                case "3":
				//�֥饦���Υ���å��������Τ��ᡢ�ե�����̾���ˤĤ���
				$time = time();

                                $ret[] = "<input type=\"file\" name=\"{$objname}\" value=\"\">";
				//$get = ��¸��ͭ����ϡ������������å�������̾HIDDEN
				if( $get )
				{
					$get = htmlspecialchars( $get );
					if( $option["chk_in"] == 1 ){
	                                	$ret[] = "<input type=\"checkbox\" name=\"{$objname}_del_chk\" value=\"1\">�������˲�����������<br>";
					}
                                	$ret[] = "<input type=\"hidden\" name=\"{$objname}_lastupd\" value=\"{$get}\">";
					if( $option["org"]  )
						$ret[] = "<hr>\n�ڸ������ե�����̾��".htmlspecialchars( $option["org"]  )."��<br>";
					$ret[] = "�ڥ��å׸�β����ե�����̾��".$get."��<br>";
					if( file_exists("{$dir}{$get}") ){
                                		$ret[] = "<img src=\"./img_thumbnail.php?w={$option['width']}&h={$option['height']}&dir={$dir}&nm={$get}\" />";
//                                		$ret[] = "<img src=\"{$dir}{$get}?{$time}\" />";
					}else{
						$ret[] = "<img src=\"{$dir}no_image.gif\" />";
					}
				}
                        $ret = join("\n",$ret);
                        break;

        }

        return ($ret);

}

//�饸���ܥ�����ɽ��
function form_SelectDisp( $objname,$param,$get,$mode,$option=array() )
{
        //$objname ���֥�������̾
        //$param �ѥ�᡼����
        //$get   ������֤ˤ�����
        //$mode  1:�饸���ܥ�����֤���2:���򤵤줿�ƥ����Ȥ��֤�
        //$option       ��˥��ץ�����ɲ��Ѥ�����
		//style������������ɲ�
		//onchange��onChange���٥�Ȥ��ɲ�

        $ret = NULL;
        switch( $mode )
        {
                default:
                        return(-1);
                        break;

                case "1":
                        $ret[]  = "<select name=\"{$objname}\"{$option["style"]}{$option["onchange"]}>";
			//���򤷤Ƥ���������ͭ��С������
			if( $option["def_select"] == "1" )
			{
				if( $get == "" ) $def_chk = " selected";
				if( $option["def_select_name"] ) $def_name = $option["def_select_name"];
				else $option["def_name"] = "���򤷤Ƥ�������";
				$ret[] = "<option value=\"\"{$def_chk}>{$def_name}</option>";
			}
                        for( $i=0;$i<count($param["val"]);$i++ )
                        {
                                if( $get == $param["val"][$i] ) $chk = " selected";
                                else $chk = NULL;

				$param["name"][$i] = htmlspecialchars($param["name"][$i]);
				$param["val"][$i] = htmlspecialchars($param["val"][$i]);
                                $ret[] = "<option value=\"{$param["val"][$i]}\"{$chk}>{$param["name"][$i]}</option>";
                        }
			$ret[] = "</select>";
                        $ret = join("\n",$ret);
                        break;
                case "2":
                        for( $i=0;$i<count($param["val"]);$i++ )
                        {
                                if( $get == $param["val"][$i] )
                                {
                                        $ret[] = "{$param["name"][$i]}";
                                }
                        }
			if( is_array($ret) )
                        	$ret = join("\n",$ret);
			else
				$ret = NULL;
                        break;

        }

        return ($ret);

}

//SELECT��OPTIONS����ɽ����MULTIPLE)
function form_SelectDisp2( $objname,$param,$get,$mode,$option=array() )
{
        //$objname ���֥�������̾
        //$param �ѥ�᡼����
        //$get   ������֤ˤ�����
        //$mode  1:�饸���ܥ�����֤���2:���򤵤줿�ƥ����Ȥ��֤�
        //$option       ��˥��ץ�����ɲ��Ѥ�����
                //style������������ɲ�
                //onchange��onChange���٥�Ȥ��ɲ�

        $ret = NULL;
        switch( $mode )
        {
                default:
                        return(-1);
                        break;

                case "1":
                        $ret[]  = "<select name=\"{$objname}\"{$option["size"]} multiple>";

                        if( $option["def_select_name"] ) $def_name = $option["def_select_name"];
                        else $option["def_name"] = "���򤷤Ƥ�������";

                        $ret[] = "<option value=\"\"{$def_chk}>{$def_name}</option>";

                        for( $i=0;$i<count($param["val"]);$i++ )
                        {
                                if( array_search ( $param["val"][$i],$get ) !== FALSE ) $chk = " selected";
                                else $chk = NULL;

                                $param["name"][$i] = htmlspecialchars($param["name"][$i]);
                                $param["val"][$i] = htmlspecialchars($param["val"][$i]);
                                $ret[] = "<option value=\"{$param["val"][$i]}\"{$chk}>{$param["name"][$i]}</option>";
                        }
                        $ret[] = "</select>";
                        $ret = join("",$ret);
                        break;
                case "2":
                        for( $i=0;$i<count($param["val"]);$i++ )
                        {
                                if( $get == $param["val"][$i] )
                                {
                                        $ret[] = "{$param["name"][$i]}";
                                }
                        }
                        if( is_array($ret) )
                                $ret = join("\n",$ret);
                        else
                                $ret = NULL;
                        break;

        }

        return ($ret);

}


//�����å��ܥå����ؿ�
function form_CheckDisp( $objname,$param,$get,$mode,$option=array() )
{
        //$objname ���֥�������̾
        //$param �ѥ�᡼����
        //$get   ������֤ˤ����� ����
        //$mode  1:�����å��ܥå������֤���2:���򤵤줿�ƥ����Ȥ��֤�
        //$option       ��˥��ץ�����ɲ��Ѥ�����

        $ret = NULL;
        switch( $mode )
        {
                default:
                        return(-1);
                        break;

                case "1":
                        for( $i=0;$i<count($param["val"]);$i++ )
                        {
                                if( is_array($get) && array_search( $param["val"][$i],$get ) !== FALSE ) $chk = " checked";
                                else $chk = NULL;

				//��������ʤɤ���ä���硢�������ɽ������
				if( $param["image"][$i] ) $param["name"][$i] = "<img src=\"{$option["img_path"]}{$param["image"][$i]}\" alt=\"{$param["name"][$i]}\">";

                                $ret[] = "<input type=\"checkbox\" name=\"{$objname}[]\" value=\"{$param["val"][$i]}\"{$chk}>{$param["name"][$i]}";

                        }
                        $ret = join("\n",$ret);
                        break;
                case "2":

                        for( $i=0;$i<count($param["val"]);$i++ )
                        {

                                if( is_array($get) && array_search( $param["val"][$i],$get ) !== FALSE  )
                                {
					//��������ʤɤ���ä���硢�������ɽ������
					if( $param["image"][$i] ) {
						$param["name"][$i] = "<img src=\"".htmlspecialchars( $option["img_path"].$param["image"][$i] ) ."\" alt=\"".htmlspecialchars( $param["name"][$i]) ."\">";
					}

					//����˥�����������
					if( $option["tags"] == "li" )	  $param["name"][$i] = "<li>".$param["name"][$i]."</li>";

					//����¦�ȴ���¦���㳰ɽ��
					if ( $option["no_disp"] == "2" && $param["val"][$i] == 2 )
					{

					}
					//���ΤȤ���RET������ʤ�
					else
					{
                                        	$ret[] = "{$param["name"][$i]}";
					}
                                }
                        }
			if( is_array( $ret ) )
			{
				if( $option["tags"] == "li" ) $ret = join("\n",$ret);
				else	$ret = join("/",$ret);
			}
			else
				$ret = NULL;
                        break;

        }

        return ($ret);

}
?>
