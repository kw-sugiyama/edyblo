<?php
/*----------------------------------------------------------
    �ξ��󸡺�����
	
	//----------- �ڡ���Ƚ���� -------------//
	$_GET['mode'] ... �ɤθ������̤����褿��(�Ƹ���)
		"ar" : ���ꥢ������� 
		"ln" : �����������
		"st" : �ػ������
		"sf" : �����ե�����
		"fw" : �ե꡼��ɥե�����
	$_GET["p"]      ... ���ߤΥڡ����ֹ�(�����Τ�)
	
	//----------- �̾︡���Ѿ�� -------------//
	$_GET["pf"][] ... ���ꥳ���ɻ���
	$_GET["ar"][] ... �������ɻ���
	$_GET["ln"][] ... ���������ɻ���
	$_GET["st"][] ... �إ����ɻ���
	$_GET["fkwd"] ... �ե꡼��ɻ���
	$_GET["cl"][] ... ��Ƴ����
	$_GET["ag"]   ... �о�ǯ��
	
	//-------------- �¤ӽ��� --------------//
	$_GET["srt"]  ... �����Ⱦ��
		"1" ... 
		"2" ... 
	
//--------------------------------------------------------------------
//  HIDDEN������
//    $hidden_value      ... ���Ƥ�GET�ͤ�HIDDEN�����줿���
//    $strHiddenSearch   ... ���ꥢ�����ʤɤ����ꤵ�줿�ͤΤߤ�HIDDEN��
//    $strGetSearch      ... ��������A��󥯤����Ф��ݤ���
//--------------------------------------------------------------------
*/

/*=======================================================
    �����Ѵ���ʸ����
=======================================================*/
// ����ʸ������
$linefeed = array("\r\n", "\n", "\r");
// �֤��������<br>����
$html_br  = array("<br>", "<br>", "<br>");


/*=======================================================
    �Ƹ�������ͤ������ʺƸ����뤫��θ������Τ��Ͱݻ���
=======================================================*/

//�Ͱݻ��Ѥ��ѿ��˥��å�
$ar_select_value = 0;
$pf_select_value = 0;
$ag_select_value = 0;
$cl_check_value = "";
$fw_text_value = "";


/*=======================================================
    �ڡ�������������
=======================================================*/
	// 1�ڡ����������ɽ�����
	define( 'DATACOUNT',10);
	
	if( isset( $_GET['fw'] ) ){
		$free_word = $_GET['fw'];
		$_GET['fw'] = urlencode( $_GET['fw'] );
	}
	
	//�ڡ����ʳ���GET�������Ƥ򥯥�����Ѵ�
	$query_all = "";
	if( is_array( $_GET ) ){
		foreach( $_GET as $get_key => $get_val ){
			if( is_array( $get_val ) ){
				foreach( $get_val as $get_key2 => $get_val2 ){
					if( $query_all == "" ){
						$query_all = "?".$get_key.'[]='.$get_val2;
					}else{
						$query_all .= "&".$get_key.'[]='.$get_val2;
					}
				}
			}elseif( $get_key != "p" && $get_key != "x" && $get_key != "y"){
				if( $query_all == "" ){
					$query_all = "?".$get_key.'='.$get_val;
				}else{
					$query_all .= "&".$get_key.'='.$get_val;
				}
			}
		}
	}


/*=======================================================
    ���顼�����å�
=======================================================*/
	switch( $_GET['mode'] ){
		//�����뤫��������̤�
		case "sf":
			//�ͤ���������å��ʸ������ɡ����ꥳ���ɡ�
			if( !isset( $_GET['ar'] ) || $_GET['ar'][0] == "" && !isset( $_GET['fw'] ) ){
				$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
		
		//�ե꡼��ɤ���������̤�
		case "fw":
			//�ͤ���������å��ʸ������ɡ����ꥳ���ɡ�
			if( !isset( $_GET['fw'] ) || $_GET['fw'] == "" ){
				$obj_error->ViewErrMessage( "NO_WORD_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
		
		//���ꥢ��������������̤�
		case "ar":
			//�ͤ���������å��ʸ������ɡ����ꥳ���ɡ�
			if( !isset( $_GET['ar'],$_GET['pf'] ) || $_GET['ar'][0] == "" ||  $_GET['pf'][0] == "" ){
				$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
	
		//��������̾��������������̤�
		case "ln":
			//�ͤ���������å��ʸ������ɡ����������ɡ�
			if( !isset( $_GET['ar'],$_GET['ln'] ) || $_GET['ar'][0] == "" ||  $_GET['ln'][0] == "" ){
				$obj_error->ViewErrMessage( "NO_LINE_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
		
		//�ظ�������������̤�
		case "st":
			//�ͤ���������å��ʸ������ɡ����������ɡ��إ����ɡ�
			if( !isset( $_GET['ar'],$_GET['ln'],$_GET['st'] ) || $_GET['ar'][0] == "" ||  $_GET['ln'][0] == "" || $_GET['st'][0] == ""){
				$obj_error->ViewErrMessage( "NO_LINE_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;
		
		//�����뤫��������̤�
		case "ms":
			//�ͤ���������å��ʸ������ɡ����ꥳ���ɡ�
			if( !isset( $_GET['ar'] ) || $_GET['ar'][0] == "" && !isset( $_GET['fw'] ) ){
				$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , "/" , $arrErr );
				exit;
			}
			break;

		default:
			$obj_error->ViewErrMessage( "GET_PARAM" , "PORTAL-USER" , "/" , $arrErr );
			exit;
	}


/*=======================================================
    �ǡ�����������
=======================================================*/
switch( $_GET['mode'] ){

	/*=======================================================
	    �����뤫��������̤�
	=======================================================*/
	case "sf":
		
		//�ѥ󥯥�������
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>�������</strong></p>';

		//��Ƴ���֤�������
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		$freeword = "";
		$arr_freeword = array();
		$freeword_list = array();
		if( $free_word !="" ){
			//���ѥ��ڡ�����Ⱦ�ѥ��ڡ������Ѵ�
			$freeword = mb_convert_kana( $free_word, "s", "EUC-JP" ); 
			//Ⱦ�ѥ��ڡ�����ʬ��
			$arr_freeword = explode( " ", $freeword ); 
			//�ȥ�ࡡ�����ڡ����Τߤκ��
			foreach( $arr_freeword as $fwkey => $fwval ){
				$fwval = trim( $fwval );
				if( $fwval != "" ){
					$freeword_list[] = $fwval;
				}
			}
		}

		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    �ԡ����ꥢ��������
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		if( $_GET['ar'][0] != "" && $_GET['pf'][0] == "" ){
			$obj_scity->jyoken["ar_prefcd_list"] = $_GET['ar'];   // ��������
		}elseif( $_GET['ar'][0] != "" && $_GET['pf'][0] != "" ){
			$obj_scity->jyoken["ar_citycd_list"] = $_GET['pf'];   // ���ꥳ����
		}
		if( is_array( $freeword_list ) && count( $freeword_list ) > 0 ){
			$obj_scity->jyoken["cl_yobi1_list"] = $freeword_list; // �ե꡼���
		}
		$obj_scity->jyoken["sc_age"] = $_GET['ag'];               // �о�ǯ��
		$obj_scity->jyoken["sc_classform_list"] = $_GET['cl'];    // ��Ƴ����
		$obj_scity->jyoken["sc_stat"] = 1;                        // �֥����ܾ������꤬��λ���Ƥ��뤫�ɤ���
		$obj_scity->jyoken["cl_stat"] = 1;                        // �֥��Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_pstat"] = 1;                       // �ݡ�����Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_start"] = 1;                       // �֥��Ǻܳ��������������������ɤ���
		$obj_scity->jyoken["cl_end"] = 1;                         // �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
		$obj_scity->jyoken["cl_deldate"] = 1;                     // ���饤����Ⱦ��󤬺������Ƥ��ʤ�
		$obj_scity->sort["city"] = 1;                             // �¤ӽ� - �ԥ����ɽ�
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;


	/*=======================================================
	    �ե꡼��ɤ���������̤�
	=======================================================*/
	case "fw":
		
		//�ѥ󥯥�������
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>�������</strong></p>';

		//��Ƴ���֤�������
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		$freeword = "";
		$arr_freeword = array();
		$freeword_list = array();
		if( $free_word !="" ){
			$freeword = mb_convert_kana( $free_word, "s", "EUC-JP" ); //���ѥ��ʤ�Ⱦ�ѥ��ʤ��Ѵ�
			$arr_freeword = explode( " ", $freeword );
			foreach( $arr_freeword as $fwkey => $fwval ){
				$fwval = trim( $fwval );
				if( $fwval != "" ){
					$freeword_list[] = $fwval;
				}
			}
		}
		
		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    �ԡ����ꥢ��������
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		$obj_scity->jyoken["cl_yobi1_list"] = $freeword_list;    // �ե꡼���
		$obj_scity->jyoken["sc_stat"] = 1;                       // �֥����ܾ������꤬��λ���Ƥ��뤫�ɤ���
		$obj_scity->jyoken["cl_stat"] = 1;                       // �֥��Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_pstat"] = 1;                      // �ݡ�����Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_start"] = 1;                      // �֥��Ǻܳ��������������������ɤ���
		$obj_scity->jyoken["cl_end"] = 1;                        // �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
		$obj_scity->jyoken["cl_deldate"] = 1;                    // ���饤����Ⱦ��󤬺������Ƥ��ʤ�
		$obj_scity->sort["city"] = 1;                            // �¤ӽ� - �ԥ����ɽ�
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;


	/*=======================================================
	    ���ꥢ��������������̤�
	=======================================================*/
	case "ar":
		
		$query_str = "";
		foreach( $_GET['ar'] as $key => $val ){
			if( $key == 0 ){
				$query_str .= "?ar[]=".$val;
			}else{
				$query_str .= "&ar[]=".$val;
			}
		}
		
		//�ѥ󥯥�������
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-area/">���ꥢ����</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-pref/'.$query_str.'">���̰���</a></strong><span class="paddinglr1">&gt;</span><strong>�������</strong></p>';

		//��Ƴ���֤�������
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    �ԡ����ꥢ��������
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		$obj_scity->jyoken["ar_citycd_list"] = $_GET['pf'];   // ���ꥳ����
		$obj_scity->jyoken["sc_stat"] = 1;                    // �֥����ܾ������꤬��λ���Ƥ��뤫�ɤ���
		$obj_scity->jyoken["cl_stat"] = 1;                    // �֥��Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_pstat"] = 1;                   // �ݡ�����Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_start"] = 1;                   // �֥��Ǻܳ��������������������ɤ���
		$obj_scity->jyoken["cl_end"] = 1;                     // �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
		$obj_scity->jyoken["cl_deldate"] = 1;                 // ���饤����Ⱦ��󤬺������Ƥ��ʤ�
		$obj_scity->sort["city"] = 1;                         // �¤ӽ� - �ԥ����ɽ�
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;

	/*=======================================================
	    ��������̾��������������̤�
	=======================================================*/
	case "ln":
		
		$query_str = "";
		foreach( $_GET['ar'] as $key => $val ){
			if( $key == 0 ){
				$query_str .= "?ar[]=".$val;
			}else{
				$query_str .= "&ar[]=".$val;
			}
		}
		
		$ln_data = array();
		$ln_pref = array();
		$ln_cd = array();
		foreach( $_GET['ln'] as $ln_key => $ln_val ){
			$ln_data = explode( "/", $ln_val );
			$ln_pref[] = pg_escape_string($ln_data[0]);
			$ln_cd[]= pg_escape_string($ln_data[1]);
		}
		
		//�ѥ󥯥�������
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-arealine/">��������̾����</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-line/'.$query_str.'">���̱�������</a></strong><span class="paddinglr1">&gt;</span><strong>�������</strong></p>';

		//��Ƴ���֤�������
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    �ԡ����ꥢ��������
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		$obj_scity->jyoken["es_linecd_list"] = $ln_cd;     // ����������
		$obj_scity->jyoken["st_prefcd_list"] = $ln_pref;   // ��������
		$obj_scity->jyoken["sc_stat"] = 1;                                      // �֥����ܾ������꤬��λ���Ƥ��뤫�ɤ���
		$obj_scity->jyoken["cl_stat"] = 1;                                      // �֥��Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_pstat"] = 1;                                     // �ݡ�����Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_start"] = 1;                                     // �֥��Ǻܳ��������������������ɤ���
		$obj_scity->jyoken["cl_end"] = 1;                                       // �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
		$obj_scity->jyoken["cl_deldate"] = 1;                                   // ���饤����Ⱦ��󤬺������Ƥ��ʤ�
		$obj_scity->sort["sta"] = 1;                                            // �¤ӽ� - �إ����ɽ�
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;

	/*=======================================================
	    �ظ�������������̤�
	=======================================================*/
	case "st":
		

		$query_str = "";
		foreach( $_GET['ar'] as $key => $val ){
			if( $key == 0 ){
				$query_str .= "?ar[]=".$val;
			}else{
				$query_str .= "&ar[]=".$val;
			}
		}
		
		$query_str2 = "";
		foreach( $_GET['ln'] as $key => $val ){
				$query_str2 .= "&ln[]=".$val;
		}
		
		//�ѥ󥯥�������
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-arealine/">��������̾����</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-line/'.$query_str.'">���̱�������</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-sta/'.$query_str.$query_str2.'">�ذ���</a></strong><span class="paddinglr1">&gt;</span><strong>�������</strong></p>';

		//��Ƴ���֤�������
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    �ԡ����ꥢ��������
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		$obj_scity->jyoken["es_stacd_list"] = $_GET['st'];   // ����������
		$obj_scity->jyoken["sc_stat"] = 1;                    // �֥����ܾ������꤬��λ���Ƥ��뤫�ɤ���
		$obj_scity->jyoken["cl_stat"] = 1;                    // �֥��Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_pstat"] = 1;                   // �ݡ�����Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_start"] = 1;                   // �֥��Ǻܳ��������������������ɤ���
		$obj_scity->jyoken["cl_end"] = 1;                     // �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
		$obj_scity->jyoken["cl_deldate"] = 1;                 // ���饤����Ⱦ��󤬺������Ƥ��ʤ�
		$obj_scity->sort["sta"] = 1;                         // �¤ӽ� - �إ����ɽ�
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;


	/*=======================================================
	    �Ƹ����뤫��������̤�
	=======================================================*/
	case "ms":
		
		//�ѥ󥯥�������
		$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>�������</strong></p>';

		//��Ƴ���֤�������
		$sc_classform = "";
		if( isset( $_GET['cl'] ) && is_array( $_GET['cl'] ) ){
			foreach( $_GET['cl'] as $cl_key => $cl_val ){
				$sc_classform += $cl_val;
			}
		}

		$freeword = "";
		$arr_freeword = array();
		$freeword_list = array();
		if( $free_word !="" ){
			//���ѥ��ڡ�����Ⱦ�ѥ��ڡ������Ѵ�
			$freeword = mb_convert_kana( $free_word, "s", "EUC-JP" ); 
			//Ⱦ�ѥ��ڡ�����ʬ��
			$arr_freeword = explode( " ", $freeword ); 
			//�ȥ�ࡡ�����ڡ����Τߤκ��
			foreach( $arr_freeword as $fwkey => $fwval ){
				$fwval = trim( $fwval );
				if( $fwval != "" ){
					$freeword_list[] = $fwval;
				}
			}
		}

		//�Ͱݻ��Ѥ��ѿ��˥��å�
		if( $_GET['ar'][0] != "" ){
			$ar_select_value = $_GET['ar'][0];
		}
		if( $_GET['pf'][0] != "" ){
			$pf_select_value = $_GET['pf'][0];
		}
		if( $_GET['ag'] != "" ){
			$ag_select_value = $_GET['ag'];
		}
		if( $_GET['cl'] != "" ){
			$cl_check_value = $_GET['cl'];
		}
		if( $_GET['fw'] != "" ){
			$fw_text_value = htmlspecialchars( $_GET['fw'] );
		}


		// viewdb_SearchCtiyClass.php
		/*=======================================================
		    �ԡ����ꥢ��������
		=======================================================*/
		$obj_scity = new viewdb_SCityClassTblAccess;
		$obj_scity->conn = $obj_conn->conn;
		$obj_scity->jyoken = array();
		if( $_GET['ar'][0] != "" && $_GET['pf'][0] == "" ){
			$obj_scity->jyoken["ar_prefcd_list"] = $_GET['ar'];   // ��������
		}elseif( $_GET['ar'][0] != "" && $_GET['pf'][0] != "" ){
			$obj_scity->jyoken["ar_citycd_list"] = $_GET['pf'];   // ���ꥳ����
		}
		if( is_array( $freeword_list ) && count( $freeword_list ) > 0 ){
			$obj_scity->jyoken["cl_yobi1_list"] = $freeword_list; // �ե꡼���
		}
		$obj_scity->jyoken["sc_age"] = $_GET['ag'];               // �о�ǯ��
		$obj_scity->jyoken["sc_classform_list"] = $_GET['cl'];    // ��Ƴ����
		$obj_scity->jyoken["sc_stat"] = 1;                        // �֥����ܾ������꤬��λ���Ƥ��뤫�ɤ���
		$obj_scity->jyoken["cl_stat"] = 1;                        // �֥��Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_pstat"] = 1;                       // �ݡ�����Ǻܥե饰��ͭ�����ɤ���
		$obj_scity->jyoken["cl_start"] = 1;                       // �֥��Ǻܳ��������������������ɤ���
		$obj_scity->jyoken["cl_end"] = 1;                         // �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
		$obj_scity->jyoken["cl_deldate"] = 1;                     // ���饤����Ⱦ��󤬺������Ƥ��ʤ�
		$obj_scity->sort["city"] = 1;                             // �¤ӽ� - �ԥ����ɽ�
		list( $intCnt_juku , $intTotal_juku ) = $obj_scity->viewdb_GetSCity( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
		
		if( $intCnt_juku > 0 ){
			foreach( $obj_scity->scitydat as $key => $val ){
				foreach( $val as $key2 => $val2 ){
					if( is_numeric( $key2 ) ){
						 unset( $obj_scity->scitydat[$key][$key2] );
					}else{
						$view_search_result[$key][$key2] = htmlspecialchars( $obj_scity->scitydat[$key][$key2] );
					}
				}
			}
			unset($key,$key2,$val,$val2);
		}
		break;



}



/*=======================================================
    ɽ����������
=======================================================*/

//title
$view_header_title = "";
$view_header_title = '������̰����óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
//keywords
$view_header_keywoeds = "";
$view_header_keywoeds = "�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����,��Ω,��Ω,�������";
//description
$view_header_description = "";
$view_header_description = "������̰����ڡ����Ǥ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ����ϰ����Ū�ʼ����к����佤�ˡ�";
$view_header_description .= '��Ƴ�����ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';

/*---------------------------------------------------------
    �ڡ����������ʺ���
	$strViewPageNowCount    ... ����ɽ�����Ƥ�����������
	$strViewPageMove        ... �ڡ������ܥ��
	$strViewPageMove_before ... �����ء�
	$strViewPageMove_after  ... �ָ�ء�
	$_GET["p"]              ... ���ߤΥڡ���
	DATACOUNT               ... ɽ�����(���)
					(��ˤƻ���Ѥ�)
	$intTotal_juku     ... �����о����ο�
---------------------------------------------------------*/
	IF( $intCnt_juku > 0 ){
		$strBuffStartCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + 1;
		$strBuffEndCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + $intCnt_juku;
	
		$intBuffMove = $intTotal_juku / DATACOUNT;
		IF( is_int($intBuffMove) === FALSE ){
			$intBuffMove = ceil($intBuffMove);
		}
	
	
		$link_URL1 = '<a href="/psearch-result/page-';
		$link_URL2 = '.html'.$query_all.'">';
	
	
		if( $intBuffMove > 1 ){
			// ���ڡ���
			$strViewPageMove_before = "";
			IF( $_GET["p"] != 1 && $intBuffMove != 1 ){
				$intBuffCnt_be = $_GET["p"] - 1;
				$strViewPageMove_before .= $link_URL1 . $intBuffCnt_be . $link_URL2 . "����" . DATACOUNT . "��</A>\n";
			}
		
			// ���ڡ���
			$strViewPageMove_after = "";
			IF( $intBuffMove > $_GET["p"] ){
				// �Ĥ�����ɽ��
				// DATACOUNT��ʾ夢�ä��� ����DATACOUNT��
				$next_cnt = $intTotal_juku - $strBuffEndCnt;
				IF($next_cnt >= DATACOUNT){
					$next_cnt = DATACOUNT;
				}
				$intBuffCnt_af = $_GET["p"] + 1;
				$strViewPageMove_after .= $link_URL1 . $intBuffCnt_af . $link_URL2 . "����{$next_cnt}��</A>\n";
			}
		
			// �ڡ����ؤ�ľ�ܥ����ץ�󥯺���
			$strViewPageMove_Cnt = "";
			$strViewPageMove_Cnt_more_before = "";
			$strViewPageMove_Cnt_more_after = "";
			$intCnt = 5;
			FOR( $iX=1; $iX<=$intBuffMove; $iX++ ){
				// ���ߤ���ڡ���������XX�鷺�Ĥ�ɽ��
				IF ($iX < $_GET["p"] - $intCnt) {
					// �Ϥ߽Ф�������...�Ǿ�ά
					$strViewPageMove_Cnt_more_before = "...";
				} ELSE IF ($iX > $_GET["p"] + $intCnt) {
					// �Ϥ߽Ф�������...�Ǿ�ά
					$strViewPageMove_Cnt_more_after = "...";
				} ELSE IF ($iX == $_GET["p"]) {
					// ���ߤ���ڡ����ϥ��̵��
					$strViewPageMove_Cnt .= "<b>" .$iX . "</b>\n";
				} ELSE {
					$strViewPageMove_Cnt .= $link_URL1 . $iX . $link_URL2 . $iX . "</A>\n";
				}
			}
			// ...3 4 5 6 7 8 9 10 11 12 13... �ߤ����ʴ���
			//$strViewPageMove_Cnt = $strViewPageMove_Cnt_more_before . $strViewPageMove_Cnt . $strViewPageMove_Cnt_more_after;
			// 3 4 5 6 7 8 9 10 11 12 13 �ߤ����ʴ���
			$strViewPageMove_Cnt = $strViewPageMove_Cnt;
		}

/*		//�ե꡼��ɸ����ʤ鸡����ɤ�ɽ��
		if( $_GET['mode'] == "fw" ){
			$view_page_list='<div class="pagenavi">
	<p class="pagenavileft">'.$free_word.' �˰��פ���ΰ���</p><br>
	<p class="pagenavileft">��'.$intTotal_juku.'��&nbsp;&nbsp;'.$strBuffStartCnt.'-'.$strBuffEndCnt.'���ɽ����</p>
	<p class="pagenaviright">'.$strViewPageMove_before.$strViewPageMove_Cnt.$strViewPageMove_after.'</p><br class="clear">
	</div>
	';
		}else{
		$view_page_list='<div class="pagenavi">
	<p class="pagenavileft">��'.$intTotal_juku.'��&nbsp;&nbsp;'.$strBuffStartCnt.'-'.$strBuffEndCnt.'���ɽ����</p>
	<p class="pagenaviright">'.$strViewPageMove_before.$strViewPageMove_Cnt.$strViewPageMove_after.'</p><br class="clear">
	</div>
	';
		}
*/
		$view_page_list='<div class="pagenavi">
	<p class="pagenavileft">��'.$intTotal_juku.'��&nbsp;&nbsp;'.$strBuffStartCnt.'-'.$strBuffEndCnt.'���ɽ����</p>
	<p class="pagenaviright">'.$strViewPageMove_before.$strViewPageMove_Cnt.$strViewPageMove_after.'</p><br class="clear">
	</div>
	';
	}

$view_school_list = "";
$view_school_list .= $view_page_list;
if( isset( $view_search_result ) && is_array( $view_search_result ) ){
	foreach( $view_search_result as $key => $val ){
	
		
		//��̾������̾
			$view_school_name = "";
			if( $view_search_result[$key]['cl_kname'] != "" ){
				$view_school_name = $view_search_result[$key]['cl_jname'].' '.$view_search_result[$key]['cl_kname'];
			}else{
				$view_school_name = $view_search_result[$key]['cl_jname'];
			}
		
		//�֥�URL������
			//�ȼ��ɥᥤ��ξ��
			if( $view_search_result[$key]['cl_dokuji_flg']  == 1 ){
				$school_url = $view_search_result[$key]['cl_dokuji_domain'];
			//�ȼ��ɥᥤ��Ǥʤ����
			}else{
				$school_url = _BLOG_SITE_URL_BASE.'/'.$view_search_result[$key]['cl_urlcd'].'/';
			}
		
		//����ɽ����������
			//�ֻղ���
			if( $view_search_result[$key]['sc_topimg'] ){
				//��
				$ts_image = '<img src="./img_thumbnail.php?w=78&h=59&dir='.$param_cl_staff_path.'&nm='.$view_search_result[$key]['sc_mapimg'].'" alt="teacher_image">';
				//��
				$tb_image = '<div class="imagebox">';
				$tb_image .= '<img src="./img_thumbnail.php?w=206&h=147&dir='.$param_cl_photo_path.'&nm='.$view_search_result[$key]['sc_topimg'].'" alt="school_image" class="school_image1">';
				$tb_image .= '<img src="share/css/css1/images/transparent.gif" width="1" height="147" class="school_image2" alt="">';
				$tb_image .= '</div>';
			}else{
				$ts_image = "";//"&nbsp;";
				$tb_image = "";//"&nbsp;";
			}
	
			//��������
			if( $view_search_result[$key]['sc_topimg'] ){
				$s_image = '<img src="./img_thumbnail.php?w=206&h=147&dir='.$param_cl_photo_path.'&nm='.$view_search_result[$key]['sc_topimg'].'" alt="school_image" style="vertical-align:middle">';
			}else{
				$s_image = "&nbsp;";
			}
	
		//�������������
			$icon = "";
			//�о�ǯ��
			$age_of = $view_search_result[$key]['sc_age'];
			$age_icon = array();
			$age_icon_list = "";
			if( ( $age_of & 64 ) == 64 ){
				$age_icon[7] = '<img src="share/icons/bg_syakaijin.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 64;
			}
			if( ( $age_of & 32 ) == 32 ){
				$age_icon[6] = '<img src="share/icons/bg_daigakusei.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 32;
			}
			if( ( $age_of & 16 ) == 16 ){
				$age_icon[5] = '<img src="share/icons/bg_roninsei.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 16;
			}
			if( ( $age_of & 8 ) ==8 ){
				$age_icon[4] = '<img src="share/icons/bg_koukou.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 8;
			}
			if( ( $age_of & 4 ) ==4 ){
				$age_icon[3] = '<img src="share/icons/bg_chugaku.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 4;
			}
			if( ( $age_of & 2) == 2 ){
				$age_icon[2] = '<img src="share/icons/bg_shogaku.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 2;
			}
			if( ( $age_of & 1 ) == 1 ){
				$age_icon[1] = '<img src="share/icons/bg_youji.gif" width="63" height="24" class="paddingr2" alt="">';
				$age_of -= 1;
			}
			
			$cnt = 1;
			if( count( $age_icon ) ){
				ksort( $age_icon );
				
				foreach( $age_icon as $age_key => $age_val ){
					if( $cnt % 8 == 0 ){ $icon .= "\n&nbsp;&nbsp;"; }
					$icon .= $age_val;
					$cnt++;
				}
			}
	
			//��Ƴ����		
			$cls_of = $view_search_result[$key]['sc_classform'];
			$cls_icon = array();
			$cls_icon_list = "";
			if( ( $cls_of & 4 ) == 4 ){
				$cls_icon[3] = '<img src="share/icons/bg_kobetsu.gif" width="62" height="20" class="paddingr2" alt="">';
				$cls_of -= 4;
			}
			if( ( $cls_of & 2 ) == 2 ){
				$cls_icon[2] = '<img src="share/icons/bg_shounin.gif" width="62" height="20" class="paddingr2" alt="">';
				$cls_of -= 2;
			}
			if( ( $cls_of & 1 ) == 1 ){
				$cls_icon[1] = '<img src="share/icons/bg_shudan.gif" width="62" height="20" class="paddingr2" alt="">';
				$cls_of -= 1;
			}
			if( count( $cls_icon ) ){
				ksort( $cls_icon );
				foreach( $cls_icon as $cls_key => $cls_val ){
					if( $cnt % 8 == 0 ){ $icon .= "\n&nbsp;&nbsp;"; }
					$icon .= $cls_val;
					$cnt++;
				}
			}
			
		//��������������ar_area disp_no1�ν������äƤ����
			$obj_area = new basedb_AreaClassTblAccess;
			$obj_area->conn = $obj_conn->conn;
			$obj_area->jyoken = array();
			$obj_area->jyoken["ar_clid"] = $view_search_result[$key]['sc_clid'];
			$obj_area->sort['ar_flg'] = 2;
			$obj_area->areadat = array();
			list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );
			$area = array();
			$area_address = "";
			$area['zip'] = "��".$obj_area->areadat[0]['ar_zip'];
			$area['pref'] = $obj_area->areadat[0]['ar_pref'];
			$area['city'] = $obj_area->areadat[0]['ar_city'];
			$area['add'] = $obj_area->areadat[0]['ar_add'];
			$area['ar_estate'] =" ".$obj_area->areadat[0]['ar_estate'];
			$area_address = $area['zip']." ".$area['pref'].$area['city'].$area['add'].$area['ar_estate'];
		
		//�����ֹ������
			if( $view_search_result[$key]['cl_phone'] !="" ){
				$tel_no = $view_search_result[$key]['cl_phone'];
			}else{
				$tel_no = " -";
			}
		
		//�������������
			$ensen =array();
			if( $view_search_result[$key]['es_bus'] ) $ensen['bus'] = " �Х�".$view_search_result[$key]['es_bus']."ʬ";
			if( $view_search_result[$key]['es_walk'] ) $ensen['walk'] = " ����".$view_search_result[$key]['es_walk']."ʬ";
			if( $view_search_result[$key]['es_biko'] ) $ensen['biko'] = " ".$view_search_result[$key]['es_biko'];
			$ensen_name = $view_search_result[$key]['es_line'].$view_search_result[$key]['es_sta'].'��'.$ensen['bus'].$ensen['walk'].$ensen['biko'];
		

		$view_school_list .= '

<div class="schoolinfo">
<div class="kekka"></div>
<div class="schoolheader">'.$view_search_result[$key]['sc_topsubtitle'].'</div>
<div class="schoolname"><a href="'.$school_url.'" target="_blank">'.$view_school_name.'</a></div>
<div class="kekkaul"></div>
<div class="schoolicon">'.$icon.'</div>
<div class="kekkaul"></div>
<div class="schoolinfo2">
'.$tb_image.'
<div class="schoolchara">
<p><img src="share/css/css1/images/bg_tokucho2.gif" alt="�Τ���ħ" width="290" height="25"></p>
<p>'.str_replace( $linefeed, $html_br , $view_search_result[$key]['sc_pr'] ).'
</p>
</div><table class="schooldetail">
<tr>
<td>
<p class="schoolchara"><br>�����ꡧ'.$area_address.'<br>
�ԣţ̡�'.$tel_no.'<br>
�Ǵ�ء�'.$ensen_name.'
</td>
<td class="todetail paddingt1"><a href="'.$school_url.'" target="_blank"></a></td>
</tr>
</table>
</div>
<div class="kekkaul"></div>
</div>
';
	}
}else{

	if( $_GET['mode'] == "fw" || ( $_GET['mode'] == "ms" && $_GET['ar'][0] == "" && $_GET['pf'][0] == "" ) ){
		$view_school_list .= '
<div class="box3"><!--box start-->
<table class="search3">
<tr>
<th>
<p class="center"><strong>'.$free_word.'���˰��פ���Τϸ��Ĥ���ޤ���Ǥ�����</strong></p>
</th>
</tr>
</table>
</div><!--box end-->
';
	}else{
		$view_school_list .= '
<div class="box3"><!--box start-->
<table class="search3">
<tr>
<th>
<p class="center"><strong>�������˰��פ���Τϸ��Ĥ���ޤ���Ǥ�����</strong></p>
</th>
</tr>
</table>
</div><!--box end-->
';
	}
}

$view_school_list .= $view_page_list;

?>