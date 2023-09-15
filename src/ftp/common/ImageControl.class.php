<?

CLASS ImageControl{
	
	/*===================================================
	    ���С��ѿ����
	===================================================*/
	var $errmsg;		// �������顼���Υ�å�����
	var $max_w;		// ���粣��
	var $max_h;		// �������
	var $standard;		// �ꥵ�������δ��  1:�Ĵ�� 2:�����
	var $origin_dir;	// �ե����
	var $origin_img;	// �������Υѥ�
	var $gd_ver;		// GD�С������1��2.0�ʹ� 0��2.0����
	var $imageResource;	// �ꥵ�������줿��¸����������
	
	
	/*===================================================
	  ���󥹥ȥ饯���ʥ��С��ѿ��ν������
	===================================================*/
	function ImageControl()
	{
		$this->errmsg = NULL;		// �������顼��å�����
		$this->max_w = NULL;		// ���粣��
		$this->max_h = NULL;		// �������
		$this->origin_dir = NULL;	// �������Υѥ�
		$this->origin_img = NULL;	// �����ե�����̾
		$this->gd_ver = 1;		// GD�С������1��2.0�ʹ� 0��2.0����
		$this->imageResource;		// �ꥵ�������줿��¸����������
	}
	
	
	/*===================================================
	  ��������Υꥵ��������
		�֤��� : 
	===================================================*/
	function ImageResize()
	{
		
		/*------------------------------------------------------
		    ������������å�
		------------------------------------------------------*/
		IF( $this->CheckImage() === FALSE ) {
			$this->errmsg = "ImageResize(1) : �����λ��꤬�����Ǥ���";
			return (-1);
			exit;
		}
		
		/*------------------------------------------------------
		    ���ߤβ����������μ���
			origins[0] : �������β���
			origins[1] : �������ν���
			origins[2] : �������Υ�����
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
				(�������ͤ�PHP4.3�ʹߤ���������IMAGETYPE������б����ޤ���)
			origins[3] : ��������IMG������ľ�����ѤǤ���ʸ���� "height=xxx width=xxx"
		------------------------------------------------------*/
		$origins = getimagesize( $this->origin_dir.$this->origin_img );
		
		/*------------------------------------------------------
		    �ꥵ������Υ�����
			nexts[0] ... �ѹ���β���
			nexts[1] ... �ѹ���ν���
		------------------------------------------------------*/
		$nexts = $origins;
		
		IF( $nexts[0] >= $nexts[1] ){
			// ���� > ���� �ξ��ϲ������ǽ���
			$this->standard = 2;
		}ELSE{
			// ���� > ���� �ξ��Ͻ������ǽ���
			$this->standard = 1;
		}
		
		/*------------------------------------------------------
		    ������� or ������� �ǽ����ѹ�
		------------------------------------------------------*/
		SWITCH( $this->standard ) {
			// ����������
			Case 1:
				$tmp_h = $origins[1] / $this->max_h;
				if( $this->max_w != "" ){
					$tmp_w = $origins[0] / $this->max_w;
				}
				if($tmp_w > 1 || $tmp_h > 1){
					// UP���줿������MAX����������礭��
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
				
			// ����������
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
				
			// ����̵�����顼
			default:
				$this->errmsg = "ImageResize(2) : �ꥵ�������δ�ब���ꤵ��Ƥ��ޤ���";
				return (-1);
				exit;
		}
		
		/*------------------------------------------------------
		    ���������ǽ����ѹ�
		------------------------------------------------------*/
		SWITCH( $origins[2] ){
			// GIF����
			Case "1":
				//GD�С������Ƚ��
				if($this->gd_ver == "0"){
					$this->errmsg = "ImageResize(3) : GD�饤�֥�꤬1.x�Ǥ�GIF�Υꥵ�������б��Ǥ��ޤ���";
					return (-1);
					exit;
				} else {
					// ��¸������GIF�ե�����Ȥ��ƥ��ԡ�
					$img_def = imagecreatefromgif( $this->origin_dir.$this->origin_img );
					// $img_def ��Ʃ����ID�����
					$transparent = imagecolortransparent( $img_def );
					// $img_def �Υѥ�åȿ��������
					$colorstotal = imagecolorstotal( $img_def );
					
					// �̾����TrueColor�����򿷵�����
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					// $img_def ��Ʊ�����顼�μ���
					//$tc = imagecolorsforindex( $img_def , $transparent );
					// Ʃ����ID�ζ������Ʃ�����Ȥ����ɤ�Ĥ֤�
					imagefill( $img_new , 0 , 0 , imagecolorallocate( $img_new , $tc["red"] , $tc["green"] , $tc["blue"] ) );
					// �ѥ�åȤ� $img_def ��Ʊ���ˤ���
					imagetruecolortopalette( $img_new , false , $colorstotal );
					// $img_new ��Ʃ���������
					imagecolortransparent( $img_new , imagecolorclosest( $img_new , $tc["red"] , $tc["green"] , $tc["blue"] ) );
					// $img_def �� $img_new �˥ꥵ�������ƾ��
					imagecopyresized( $img_new , $img_def , 0 , 0 , 0 , 0 , $nexts[0] , $nexts[1] , $origins[0] , $origins[1] );
					
				}
				header("content-Type: image/gif");
				imagegif($img_new);
				break;
				
			// JPG����
			Case "2":
				//GD�С������Ƚ��
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
				
			// PNG����
			Case "3":
				//GD�С������Ƚ��
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
				
			// �б����顼
			default:
				$this->errmsg = "ImageResize(4) : �����������б����Ƥ��ޤ���";
				return (-1);
				exit;
		}
		
		// �������줿�����κ��
		imagedestroy($img_def);
		imagedestroy($img_new);
		
	}
	
	
	/*===================================================
	  ���������¸�ߥ����å�
		�֤��� : true  ... ���������¸�ߤ���
			 false ... ���������¸�ߤ��ʤ�
	===================================================*/
	function CheckImage()
	{
		/*------------------------------------------------------
		    �ѥ������å�
		------------------------------------------------------*/
		IF( $this->origin_dir == "" ) {
			$this->errmsg = "�ѥ������ꤵ��Ƥ��ޤ���";
			return false;
		}
		
		/*------------------------------------------------------
		    �����������å�
		------------------------------------------------------*/
		IF( $this->origin_img == "" ) {
			$this->errmsg = "���������ꤵ��Ƥ��ޤ���";
			return false;
		}
		IF( !file_exists( $this->origin_dir.$this->origin_img ) ) {
			$this->errmsg = "���������Ĥ���ޤ���";
			return false;
		}
		
		return true;
		
	}
	
	
	/*===================================================
	  ��������Υꥵ��������
		�֤��� : 
	===================================================*/
	function ImageResizeSave()
	{
		
		/*------------------------------------------------------
		    ������������å�
		------------------------------------------------------*/
		IF( $this->CheckImage() === FALSE ) {
			$this->errmsg = "ImageResize(1) : �����λ��꤬�����Ǥ���";
			return (-1);
			exit;
		}
		
		/*------------------------------------------------------
		    ���ߤβ����������μ���
			origins[0] : �������β���
			origins[1] : �������ν���
			origins[2] : �������Υ�����
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
				(�������ͤ�PHP4.3�ʹߤ���������IMAGETYPE������б����ޤ���)
			origins[3] : ��������IMG������ľ�����ѤǤ���ʸ���� "height=xxx width=xxx"
		------------------------------------------------------*/
		$origins = getimagesize( $this->origin_dir.$this->origin_img );
		
		/*------------------------------------------------------
		    �ꥵ������Υ�����
			nexts[0] ... �ѹ���β���
			nexts[1] ... �ѹ���ν���
		------------------------------------------------------*/
		$nexts = $origins;
		
		IF( $nexts[0] > $nexts[1] ){
			// ���� > ���� �ξ��ϲ������ǽ���
			$this->standard = 2;
		}ELSE{
			// ���� > ���� �ξ��Ͻ������ǽ���
			$this->standard = 1;
		}
		
		/*------------------------------------------------------
		    ������� or ������� �ǽ����ѹ�
		------------------------------------------------------*/
		SWITCH( $this->standard ) {
			// ����������
			Case 1:
				$tmp_h = $origins[1] / $this->max_h;
				if( $this->max_w != "" ){
					$tmp_w = $origins[0] / $this->max_w;
				}
				if($tmp_w > 1 || $tmp_h > 1){
					// UP���줿������MAX����������礭��
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
				
			// ����������
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
				
			// ����̵�����顼
			default:
				$this->errmsg = "ImageResize(2) : �ꥵ�������δ�ब���ꤵ��Ƥ��ޤ���";
				return (-1);
				exit;
		}
		
		/*------------------------------------------------------
		    ���������ǽ����ѹ�
		------------------------------------------------------*/
		SWITCH( $origins[2] ){
			// GIF����
			Case "1":
				//GD�С������Ƚ��
				if($this->gd_ver == "0"){
					$this->errmsg = "ImageResize(3) : GD�饤�֥�꤬1.x�Ǥ�GIF�Υꥵ�������б��Ǥ��ޤ���";
					return (-1);
					exit;
				} else {
					// ��¸������GIF�ե�����Ȥ��ƥ��ԡ�
					$img_def = imagecreatefromgif( $this->origin_dir.$this->origin_img );
					// $img_def ��Ʃ����ID�����
					$transparent = imagecolortransparent( $img_def );
					// $img_def �Υѥ�åȿ��������
					$colorstotal = imagecolorstotal( $img_def );
					
					// �̾����TrueColor�����򿷵�����
					$img_new = imagecreatetruecolor( $nexts[0] , $nexts[1] );
					// $img_def ��Ʊ�����顼�μ���
					//$tc = imagecolorsforindex( $img_def , $transparent );
					// Ʃ����ID�ζ������Ʃ�����Ȥ����ɤ�Ĥ֤�
					imagefill( $img_new , 0 , 0 , imagecolorallocate( $img_new , $tc["red"] , $tc["green"] , $tc["blue"] ) );
					// �ѥ�åȤ� $img_def ��Ʊ���ˤ���
					imagetruecolortopalette( $img_new , false , $colorstotal );
					// $img_new ��Ʃ���������
					imagecolortransparent( $img_new , imagecolorclosest( $img_new , $tc["red"] , $tc["green"] , $tc["blue"] ) );
					// $img_def �� $img_new �˥ꥵ�������ƾ��
					imagecopyresized( $img_new , $img_def , 0 , 0 , 0 , 0 , $nexts[0] , $nexts[1] , $origins[0] , $origins[1] );
					
				}
				break;
				
			// JPG����
			Case "2":
				//GD�С������Ƚ��
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
				
			// PNG����
			Case "3":
				//GD�С������Ƚ��
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
				
			// �б����顼
			default:
				$this->errmsg = "ImageResize(4) : �����������б����Ƥ��ޤ���";
				return (-1);
				exit;
		}
		
		// �������줿�����κ��
		imagedestroy($img_def);
		return array($img_new,$origins[2]);
		
	}
	
	
	/*===================================================
	  ��������Υꥵ��������
		�֤��� : 
	===================================================*/
	function ImageSave($type)
	{				
		/*------------------------------------------------------
		    ���������ǽ����ѹ�
		------------------------------------------------------*/
		SWITCH( $type ){
			// GIF����
			Case "1":
				// �ꥵ������������¸���ƥѡ��ߥå���������
				imagegif($this->imageResource,$this->origin_dir.$this->origin_img);
				chmod( $this->origin_dir.$this->origin_img , 0755 );
				break;
				
			// JPG����
			Case "2":
				// �ꥵ������������¸���ƥѡ��ߥå���������
				imagejpeg($this->imageResource,$this->origin_dir.$this->origin_img);
				chmod( $this->origin_dir.$this->origin_img , 0755 );
				break;				
				
			// PNG����
			Case "3":
				// �ꥵ������������¸���ƥѡ��ߥå���������
				imagepng($this->imageResource,$this->origin_dir.$this->origin_img);
				chmod( $this->origin_dir.$this->origin_img , 0755 );
				break;
								
			// �б����顼
			default:
				$this->errmsg = "ImageResize(4) : �����������б����Ƥ��ޤ���";
				return (-1);
				exit;
		}
		return(1);		
	}
	
}
?>
