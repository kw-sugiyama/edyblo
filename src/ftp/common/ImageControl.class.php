<?

CLASS ImageControl{
	
	/*===================================================
	    メンバー変数定義
	===================================================*/
	var $errmsg;		// 処理エラー時のメッセージ
	var $max_w;		// 最大横幅
	var $max_h;		// 最大縦幅
	var $standard;		// リサイズ時の基準  1:縦基準 2:横基準
	var $origin_dir;	// フォルダ
	var $origin_img;	// 元画像のパス
	var $gd_ver;		// GDバージョン　1：2.0以降 0：2.0以前
	var $imageResource;	// リサイズされた保存したい画像
	
	
	/*===================================================
	  コンストラクタ（メンバー変数の初期化）
	===================================================*/
	function ImageControl()
	{
		$this->errmsg = NULL;		// 処理エラーメッセージ
		$this->max_w = NULL;		// 最大横幅
		$this->max_h = NULL;		// 最大縦幅
		$this->origin_dir = NULL;	// 元画像のパス
		$this->origin_img = NULL;	// 画像ファイル名
		$this->gd_ver = 1;		// GDバージョン　1：2.0以降 0：2.0以前
		$this->imageResource;		// リサイズされた保存したい画像
	}
	
	
	/*===================================================
	  指定画像のリサイズ処理
		返り値 : 
	===================================================*/
	function ImageResize()
	{
		
		/*------------------------------------------------------
		    指定画像チェック
		------------------------------------------------------*/
		IF( $this->CheckImage() === FALSE ) {
			$this->errmsg = "ImageResize(1) : 画像の指定が不正です。";
			return (-1);
			exit;
		}
		
		/*------------------------------------------------------
		    現在の画像サイズの取得
			origins[0] : 元画像の横幅
			origins[1] : 元画像の縦幅
			origins[2] : 元画像のタイプ
				1 = GIF
				2 = JPG
				3 = PNG
				4 = SWF
				5 = PSD
				6 = BMP
				7 = TIFF(intel byte order)
				8 = TIFF(motorola byte order)
				9 = JPC
				10 = JP2
				11 = JPX
				12 = JB2
				13 = SWC
				14 = IFF
				15 = WBMP
				16 = XBM
				(これらの値はPHP4.3以降で定義されるIMAGETYPE定数に対応します。)
			origins[3] : 元画像のIMGタグで直接利用できる文字列 "height=xxx width=xxx"
		------------------------------------------------------*/
		$origins = getimagesize( $this->origin_dir.$this->origin_img );
		
		/*------------------------------------------------------
		    リサイズ後のサイズ
			nexts[0] ... 変更後の横幅
			nexts[1] ... 変更後の縦幅
		------------------------------------------------------*/
		$nexts = $origins;
		
		IF( $nexts[0] >= $nexts[1] ){
			// 横幅 > 縦幅 の場合は横幅基準で処理
			$this->standard = 2;
		}ELSE{
			// 縦幅 > 横幅 の場合は縦幅基準で処理
			$this->standard = 1;
		}
		
		/*------------------------------------------------------
		    縦幅基準 or 横幅基準 で処理変更
		------------------------------------------------------*/
		SWITCH( $this->standard ) {
			// 縦幅基準処理
			Case 1:
				$tmp_h = $origins[1] / $this->max_h;
				if( $this->max_w != "" ){
					$tmp_w = $origins[0] / $this->max_w;
				}
				if($tmp_w > 1 || $tmp_h > 1){
					// UPされた画像がMAXサイズより大きい
					if($this->max_w == ""){
						if($tmp_h > 1){
							$nexts[0] = $origins[0] * ( $this->max_h / $origins[1] );
							$nexts[1] = $this->max_h;
						}
					} else {
						if($tmp_h > $tmp_w){
							$nexts[0] = $origins[0] * ( $this->max_h / $origins[1] );
							$nexts[1] = $this->max_h;
						} else {
							$nexts[0] = $this->max_w;
							$nexts[1] = $origins[1] * ( $this->max_w / $origins[0] );
						}
					}
				}
				break;
				
			// 横幅基準処理
			Case 2:
				$tmp_w = $origins[0] / $this->max_w;
				if( $this->max_h != "" ){
					$tmp_h = $origins[1] / $this->max_h;
				}
				if($tmp_w > 1 || $tmp_h > 1){
					if($this->max_h == ""){
						if($tmp_w > 1){
							$nexts[0] = $this->max_w;
							$nexts[1] = $origins[1] * $this->max_w / $origins[0]; 
						}
					} else {
						if($tmp_w > $tmp_h){
							$nexts[0] = $this->max_w;
							$nexts[1] = $origins[1] * $this->max_w / $origins[0];
						} else {
							$nexts[1] = $this->max_h;
							$nexts[0] = $origins[0] * $this->max_h / $origins[1];
						}
					}
				}
				break;
				
			// 指定無しエラー
			default:
				$this->errmsg = "ImageResize(2) : リサイズ時の基準が設定されていません。";
				return (-1);
				exit;
		}
		
		/*------------------------------------------------------
		    画像形式で処理変更
		------------------------------------------------------*/
		SWITCH( $origins[2] ){
			// GIF形式
			Case "1":
				//GDバージョン判定
				if($this->gd_ver == "0"){
					$this->errmsg = "ImageResize(3) : GDライブラリが1.xではGIFのリサイズは対応できません。";
					return (-1);
					exit;
				} else {
					// 既存画像をGIFファイルとしてコピー
					$img_def = imagecreatefromgif( $this->origin_dir.$this->origin_img );
					// $img_def の透明色IDを取得
					$transparent = imagecolortransparent( $img_def );
					// $img_def のパレット色数を取得
					$colorstotal = imagecolorstotal( $img_def );
					
					// 縮小後のTrueColor画像を新規作成
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					// $img_def と同じカラーの取得
					//$tc = imagecolorsforindex( $img_def , $transparent );
					// 透明色IDの近似色を透明色として塗りつぶし
					imagefill( $img_new , 0 , 0 , imagecolorallocate( $img_new , $tc["red"] , $tc["green"] , $tc["blue"] ) );
					// パレットを $img_def と同じにする
					imagetruecolortopalette( $img_new , false , $colorstotal );
					// $img_new の透明色を指定
					imagecolortransparent( $img_new , imagecolorclosest( $img_new , $tc["red"] , $tc["green"] , $tc["blue"] ) );
					// $img_def を $img_new にリサイズして上書き
					imagecopyresized( $img_new , $img_def , 0 , 0 , 0 , 0 , $nexts[0] , $nexts[1] , $origins[0] , $origins[1] );
					
				}
				header("content-Type: image/gif");
				imagegif($img_new);
				break;
				
			// JPG形式
			Case "2":
				//GDバージョン判定
				if($this->gd_ver == "0"){
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					$img_def = imagecreatefromJpeg( $this->origin_dir.$this->origin_img );
					imagecopyresampled( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
				} else {
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					$img_def = imagecreatefromJpeg( $this->origin_dir.$this->origin_img );
					//imagecopyresized( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
					imagecopyresampled( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
				}
				header("content-Type: image/jpeg");
				imagejpeg($img_new);
				break;
				
			// PNG形式
			Case "3":
				//GDバージョン判定
				if($this->gd_ver == "0"){
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					$img_def = imagecreatefromPng( $this->origin_dir.$this->origin_img );
					imagecopyresampled( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
				} else {
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					$img_def = imagecreatefromPng( $this->origin_dir.$this->origin_img );
					imagecopyresized( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
				}
				header("content-Type: image/png");
				imagepng($img_new);
				break;
				
			// 対応エラー
			default:
				$this->errmsg = "ImageResize(4) : 画像形式が対応していません";
				return (-1);
				exit;
		}
		
		// 生成された画像の削除
		imagedestroy($img_def);
		imagedestroy($img_new);
		
	}
	
	
	/*===================================================
	  指定画像の存在チェック
		返り値 : true  ... 指定画像が存在する
			 false ... 指定画像が存在しない
	===================================================*/
	function CheckImage()
	{
		/*------------------------------------------------------
		    パスチェック
		------------------------------------------------------*/
		IF( $this->origin_dir == "" ) {
			$this->errmsg = "パスが指定されていません";
			return false;
		}
		
		/*------------------------------------------------------
		    元画像チェック
		------------------------------------------------------*/
		IF( $this->origin_img == "" ) {
			$this->errmsg = "画像が指定されていません";
			return false;
		}
		IF( !file_exists( $this->origin_dir.$this->origin_img ) ) {
			$this->errmsg = "画像が見つかりません";
			return false;
		}
		
		return true;
		
	}
	
	
	/*===================================================
	  指定画像のリサイズ処理
		返り値 : 
	===================================================*/
	function ImageResizeSave()
	{
		
		/*------------------------------------------------------
		    指定画像チェック
		------------------------------------------------------*/
		IF( $this->CheckImage() === FALSE ) {
			$this->errmsg = "ImageResize(1) : 画像の指定が不正です。";
			return (-1);
			exit;
		}
		
		/*------------------------------------------------------
		    現在の画像サイズの取得
			origins[0] : 元画像の横幅
			origins[1] : 元画像の縦幅
			origins[2] : 元画像のタイプ
				1 = GIF
				2 = JPG
				3 = PNG
				4 = SWF
				5 = PSD
				6 = BMP
				7 = TIFF(intel byte order)
				8 = TIFF(motorola byte order)
				9 = JPC
				10 = JP2
				11 = JPX
				12 = JB2
				13 = SWC
				14 = IFF
				15 = WBMP
				16 = XBM
				(これらの値はPHP4.3以降で定義されるIMAGETYPE定数に対応します。)
			origins[3] : 元画像のIMGタグで直接利用できる文字列 "height=xxx width=xxx"
		------------------------------------------------------*/
		$origins = getimagesize( $this->origin_dir.$this->origin_img );
		
		/*------------------------------------------------------
		    リサイズ後のサイズ
			nexts[0] ... 変更後の横幅
			nexts[1] ... 変更後の縦幅
		------------------------------------------------------*/
		$nexts = $origins;
		
		IF( $nexts[0] > $nexts[1] ){
			// 横幅 > 縦幅 の場合は横幅基準で処理
			$this->standard = 2;
		}ELSE{
			// 縦幅 > 横幅 の場合は縦幅基準で処理
			$this->standard = 1;
		}
		
		/*------------------------------------------------------
		    縦幅基準 or 横幅基準 で処理変更
		------------------------------------------------------*/
		SWITCH( $this->standard ) {
			// 縦幅基準処理
			Case 1:
				$tmp_h = $origins[1] / $this->max_h;
				if( $this->max_w != "" ){
					$tmp_w = $origins[0] / $this->max_w;
				}
				if($tmp_w > 1 || $tmp_h > 1){
					// UPされた画像がMAXサイズより大きい
					if($this->max_w == ""){
						if($tmp_h > 1){
							$nexts[0] = $origins[0] * ( $this->max_h / $origins[1] );
							$nexts[1] = $this->max_h;
						}
					} else {
						if($tmp_h > $tmp_w){
							$nexts[0] = $origins[0] * ( $this->max_h / $origins[1] );
							$nexts[1] = $this->max_h;
						} else {
							$nexts[0] = $this->max_w;
							$nexts[1] = $origins[1] * ( $this->max_w / $origins[0] );
						}
					}
				}
				break;
				
			// 横幅基準処理
			Case 2:
				$tmp_w = $origins[0] / $this->max_w;
				if( $this->max_h != "" ){
					$tmp_h = $origins[1] / $this->max_h;
				}
				if($tmp_w > 1 || $tmp_h > 1){
					if($this->max_h == ""){
						if($tmp_w > 1){
							$nexts[0] = $this->max_w;
							$nexts[1] = $origins[1] * $this->max_w / $origins[0]; 
						}
					} else {
						if($tmp_w > $tmp_h){
							$nexts[0] = $this->max_w;
							$nexts[1] = $origins[1] * $this->max_w / $origins[0];
						} else {
							$nexts[1] = $this->max_h;
							$nexts[0] = $origins[0] * $this->max_h / $origins[1];
						}
					}
				}
				break;
				
			// 指定無しエラー
			default:
				$this->errmsg = "ImageResize(2) : リサイズ時の基準が設定されていません。";
				return (-1);
				exit;
		}
		
		/*------------------------------------------------------
		    画像形式で処理変更
		------------------------------------------------------*/
		SWITCH( $origins[2] ){
			// GIF形式
			Case "1":
				//GDバージョン判定
				if($this->gd_ver == "0"){
					$this->errmsg = "ImageResize(3) : GDライブラリが1.xではGIFのリサイズは対応できません。";
					return (-1);
					exit;
				} else {
					// 既存画像をGIFファイルとしてコピー
					$img_def = imagecreatefromgif( $this->origin_dir.$this->origin_img );
					// $img_def の透明色IDを取得
					$transparent = imagecolortransparent( $img_def );
					// $img_def のパレット色数を取得
					$colorstotal = imagecolorstotal( $img_def );
					
					// 縮小後のTrueColor画像を新規作成
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					// $img_def と同じカラーの取得
					//$tc = imagecolorsforindex( $img_def , $transparent );
					// 透明色IDの近似色を透明色として塗りつぶし
					imagefill( $img_new , 0 , 0 , imagecolorallocate( $img_new , $tc["red"] , $tc["green"] , $tc["blue"] ) );
					// パレットを $img_def と同じにする
					imagetruecolortopalette( $img_new , false , $colorstotal );
					// $img_new の透明色を指定
					imagecolortransparent( $img_new , imagecolorclosest( $img_new , $tc["red"] , $tc["green"] , $tc["blue"] ) );
					// $img_def を $img_new にリサイズして上書き
					imagecopyresized( $img_new , $img_def , 0 , 0 , 0 , 0 , $nexts[0] , $nexts[1] , $origins[0] , $origins[1] );
					
				}
				break;
				
			// JPG形式
			Case "2":
				//GDバージョン判定
				if($this->gd_ver == "0"){
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					$img_def = imagecreatefromJpeg( $this->origin_dir.$this->origin_img );
					imagecopyresampled( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
				} else {
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					$img_def = imagecreatefromJpeg( $this->origin_dir.$this->origin_img );
					//imagecopyresized( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
					imagecopyresampled( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
				}
				break;
				
			// PNG形式
			Case "3":
				//GDバージョン判定
				if($this->gd_ver == "0"){
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					$img_def = imagecreatefromPng( $this->origin_dir.$this->origin_img );
					imagecopyresampled( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
				} else {
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					$img_def = imagecreatefromPng( $this->origin_dir.$this->origin_img );
					imagecopyresized( $img_new,  $img_def,  0,  0,  0,  0, $nexts[0],  $nexts[1], $origins[0],  $origins[1]);
				}
				break;
				
			// 対応エラー
			default:
				$this->errmsg = "ImageResize(4) : 画像形式が対応していません";
				return (-1);
				exit;
		}
		
		// 生成された画像の削除
		imagedestroy($img_def);
		return array($img_new,$origins[2]);
		
	}
	
	
	/*===================================================
	  指定画像のリサイズ処理
		返り値 : 
	===================================================*/
	function ImageSave($type)
	{				
		/*------------------------------------------------------
		    画像形式で処理変更
		------------------------------------------------------*/
		SWITCH( $type ){
			// GIF形式
			Case "1":
				// リサイズ画像を保存してパーミッションを設定
				imagegif($this->imageResource,$this->origin_dir.$this->origin_img);
				chmod( $this->origin_dir.$this->origin_img , 0755 );
				break;
				
			// JPG形式
			Case "2":
				// リサイズ画像を保存してパーミッションを設定
				imagejpeg($this->imageResource,$this->origin_dir.$this->origin_img);
				chmod( $this->origin_dir.$this->origin_img , 0755 );
				break;				
				
			// PNG形式
			Case "3":
				// リサイズ画像を保存してパーミッションを設定
				imagepng($this->imageResource,$this->origin_dir.$this->origin_img);
				chmod( $this->origin_dir.$this->origin_img , 0755 );
				break;
								
			// 対応エラー
			default:
				$this->errmsg = "ImageResize(4) : 画像形式が対応していません";
				return (-1);
				exit;
		}
		return(1);		
	}
	
}
?>
