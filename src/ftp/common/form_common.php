<?php
/*-------------------------------------------------------
	FORM関連表示関数群
--------------------------------------------------------*/

//ラジオボタン・値表示
function form_RadioDisp( $objname,$param,$get,$mode,$option=array() )
{
        //$objname オブジェクト名
        //$param パラメーター
        //$get   選択状態にする値
        //$mode  1:ラジオボタンで返す　2:選択されたテキストを返す
        //$option       後にオプション追加用の配列

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

//画像参照ボタン
function form_ImgDisp( $objname,$dir,$get,$mode,$option=array() )
{
        //$objname オブジェクト名
        //$dir 	  画像格納ディレクトリ
        //$get   既存の画像ファイル
        //$mode  1:参照ボタンで返す　2:選択されたテキストを返す
        //$option       後にオプション追加用の配列
		//$option["org"] = 画像のアップ元名称
		//$option["chk_in"] = 画像削除チェックボックスの表示・非表示
		//                      "1":表示する  "9":表示しない
		//$option["class"] = 画像のクラスを指定する
		//$option["width"] = 画像の横サイズを指定する
		//$option["height"] = 画像の横サイズを指定する
        $ret = NULL;
        switch( $mode )
        {
                default:
                        return(-1);
                        break;

                case "1":
				//ブラウザのキャッシュ抑制のため、ファイル名後ろにつける
				$time = time();

                                $ret[] = "<input type=\"file\" name=\"{$objname}\" value=\"\">";
				//$get = 既存が有る場合は、削除選択チェック、画像名HIDDEN
				if( $get )
				{
					$get = htmlspecialchars( $get );
					if( $option["chk_in"] == 1 ){
	                                	$ret[] = "<input type=\"checkbox\" name=\"{$objname}_del_chk\" value=\"1\">更新時に画像を削除する<br>";
					}
                                	$ret[] = "<input type=\"hidden\" name=\"{$objname}_lastupd\" value=\"{$get}\">";
					if( $option["org"]  )
						$ret[] = "<hr>\n【元画像ファイル名：".htmlspecialchars( $option["org"]  )."】<br>";
					$ret[] = "【アップ後の画像ファイル名：".$get."】<br>";
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
				//画像圧縮パターン
                                if( $option["gd"] == "./imgview.php" )
				{
					$ret = "<img src=\"./imgview.php?i=".htmlspecialchars( $get )."\" />";
				}
				else
				{
					$ret = "<img src=\"".htmlspecialchars( $dir.$get )."\" {$attr} />";
				}
				//クラス指定パターン
				if( $option["class"] == "1" ){
					if($width <= 270 ){
						$ret = "<img src=\"".htmlspecialchars( $dir.$get )."\" class=\"floatImg\" {$attr} />";
					}else{
						$ret = "<img src=\"".htmlspecialchars( $dir.$get )."\" {$attr} />";
					}
				}
				//画像横サイズ指定パターン
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
				//ブラウザのキャッシュ抑制のため、ファイル名後ろにつける
				$time = time();

                                $ret[] = "<input type=\"file\" name=\"{$objname}\" value=\"\">";
				//$get = 既存が有る場合は、削除選択チェック、画像名HIDDEN
				if( $get )
				{
					$get = htmlspecialchars( $get );
					if( $option["chk_in"] == 1 ){
	                                	$ret[] = "<input type=\"checkbox\" name=\"{$objname}_del_chk\" value=\"1\">更新時に画像を削除する<br>";
					}
                                	$ret[] = "<input type=\"hidden\" name=\"{$objname}_lastupd\" value=\"{$get}\">";
					if( $option["org"]  )
						$ret[] = "<hr>\n【元画像ファイル名：".htmlspecialchars( $option["org"]  )."】<br>";
					$ret[] = "【アップ後の画像ファイル名：".$get."】<br>";
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

//ラジオボタン・値表示
function form_SelectDisp( $objname,$param,$get,$mode,$option=array() )
{
        //$objname オブジェクト名
        //$param パラメーター
        //$get   選択状態にする値
        //$mode  1:ラジオボタンで返す　2:選択されたテキストを返す
        //$option       後にオプション追加用の配列
		//style：スタイルの追加
		//onchange：onChangeイベントの追加

        $ret = NULL;
        switch( $mode )
        {
                default:
                        return(-1);
                        break;

                case "1":
                        $ret[]  = "<select name=\"{$objname}\"{$option["style"]}{$option["onchange"]}>";
			//選択してください、有りバージョン
			if( $option["def_select"] == "1" )
			{
				if( $get == "" ) $def_chk = " selected";
				if( $option["def_select_name"] ) $def_name = $option["def_select_name"];
				else $option["def_name"] = "選択してください";
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

//SELECTのOPTIONS・値表示（MULTIPLE)
function form_SelectDisp2( $objname,$param,$get,$mode,$option=array() )
{
        //$objname オブジェクト名
        //$param パラメーター
        //$get   選択状態にする値
        //$mode  1:ラジオボタンで返す　2:選択されたテキストを返す
        //$option       後にオプション追加用の配列
                //style：スタイルの追加
                //onchange：onChangeイベントの追加

        $ret = NULL;
        switch( $mode )
        {
                default:
                        return(-1);
                        break;

                case "1":
                        $ret[]  = "<select name=\"{$objname}\"{$option["size"]} multiple>";

                        if( $option["def_select_name"] ) $def_name = $option["def_select_name"];
                        else $option["def_name"] = "選択してください";

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


//チェックボックス関数
function form_CheckDisp( $objname,$param,$get,$mode,$option=array() )
{
        //$objname オブジェクト名
        //$param パラメーター
        //$get   選択状態にする値 配列
        //$mode  1:チェックボックスで返す　2:選択されたテキストを返す
        //$option       後にオプション追加用の配列

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

				//アイコンなどが合った場合、そちらを表示する
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
					//アイコンなどが合った場合、そちらを表示する
					if( $param["image"][$i] ) {
						$param["name"][$i] = "<img src=\"".htmlspecialchars( $option["img_path"].$param["image"][$i] ) ."\" alt=\"".htmlspecialchars( $param["name"][$i]) ."\">";
					}

					//前後にタグがある場合
					if( $option["tags"] == "li" )	  $param["name"][$i] = "<li>".$param["name"][$i]."</li>";

					//公開側と管理側で例外表示
					if ( $option["no_disp"] == "2" && $param["val"][$i] == 2 )
					{

					}
					//２のときはRETに入れない
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
