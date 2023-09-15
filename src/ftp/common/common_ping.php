<?

/*==========================================================================================
    ����Ping����������
	
	�ؿ�̾ : SendUpdatePing
	
	������ˡ : list( $intResult , $arrErr ) = SendUpdatePing( $arrD , $arrU , $arrO );
	
	���� :  $arrD ... Ping������������ޤ᤿�󼡸�����
			$arrD["name"][int]   ... Ping������̾��
			$arrD["server"][int] ... Ping�����襢�ɥ쥹
			$arrD["method"][int] ... Ping������ǻ��ꤵ�줿�᥽�å�̾
			$arrD["title"][int]  ... �����ȤΥ����ȥ�
			$arrD["url"][int]    ... �ѹ����줿�ڡ�����URL
			$arrD["rss"][int]    ... RSS�ե����륢�ɥ쥹
			���󼡸��ܤ�[int]��"0"����Ϥޤ�褦�ˤ���
		
		$arrU ... �����Ⱦ���
			$arrU["title"]  ... �����ȥ����ȥ�
			$arrU["url"]    ... �����Ȥ�TOPURL
			$arrU["up_url"] ... �����Ȥι������줿�ڡ���URL
			$arrU["rss"]    ... �����Ȥ�RSS�ե�����
		
		$arrO ... ����¾ͽ������
	
	���� :  $intResult ... ��̥ե饰
			0       ... ���ｪλ
			(-1)    ... �����С�URL������ or ���Ĥ���ʤ�
			����¾  ... �����襵���С�����Υ��顼������
		
		$arrErr ... ���顼Ping������̾�Ρʰ켡�������
	
==========================================================================================*/
function SendUpdatePing( $arrD , $arrU , $arrO )
{
	
	/*-----------------------------------------------------------
	 * �֤��ͤν����
	-----------------------------------------------------------*/
	$intResult = 0;
	$arrErr = Array();
	
	
	/*-----------------------------------------------------------
	 * ������η������
	-----------------------------------------------------------*/
	$intSendCount = count( $arrD["name"] );
	
	
	/*-----------------------------------------------------------
	 * ��������ʬ�ν�����Ԥ�
	-----------------------------------------------------------*/
	for ( $iX=0; $iX<$intSendCount; $iX++ ) {
		
		/*-----------------------------------------------------------
		 * $server �����Ƥ�ץ�ȥ��롦�ۥ��ȡ�����ʲ���ʬ��
		 *	��)http://imd.sp-jobnet.co.jp/click/index.html
		 *		$arrUrlInfo["scheme"] = "http"
		 *		$arrUrlInfo["host"] = "imd.sp-jobnet.co.jp"
		 *		$arrUrlInfo["path"] = "/click/index.html"
		-----------------------------------------------------------*/
		$arrUrlInfo = parse_url( $arrD["server"][$iX] );
		
		
		/*-----------------------------------------------------------
		 * ����ۥ��Ȥ��Ф��Ƥ���³����
		 *	fsockopen( [host-name] , [port] , [error-no] , [error-message] , [session-timeout] )
		 *	$sock ... ��³�ɣ�
		-----------------------------------------------------------*/
		$sock = @fsockopen( $arrUrlInfo["host"] , 80 , $errno , $errstr , 60 );
		if ( $sock === false ) {
			$arrErr[] = $arrD["name"][$iX];
			return Array( "-1" , $arrErr );
		}
		
		
		/*-----------------------------------------------------------
		 * $arrD["method"][$iX] ���ͤ�̵����硢
		 * ���ܥ᥽�åɡ�weblogUpdates.ping�פ����ꤹ��
		-----------------------------------------------------------*/
		if ( $arrD["method"][$iX] == "" ) {
			$arrD["method"][$iX] = "weblogUpdates.ping";
		}
		
		
		/*-----------------------------------------------------------
		 * ����Ping��������
		 *	$strSendData ... ��������
		 *          ������� : 
		 *              ���������ȥ����ȥ�
		 *              ����������TOPURL���ɥ쥹
		 *              �����������줿�ڡ�����URL���ɥ쥹
		 *              ����RSS�ե����륢�ɥ쥹
		 *          ��2007.05.13����
		 *            Yahoo���Ф����裳�������裴�������������ʤ�
		-----------------------------------------------------------*/
		$strSendData = "";
		$strSendData .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
		$strSendData .= "<methodCall>\r\n";
		$strSendData .= "  <methodName>{$arrD["method"][$iX]}</methodName>\r\n";
		$strSendData .= "  <params>\r\n";
		$strSendData .= "    <param>\r\n";
		$strSendData .= "      <value>{$arrU["title"]}</value>\r\n";
		$strSendData .= "    </param>\r\n";
		$strSendData .= "    <param>\r\n";
		$strSendData .= "      <value>{$arrU["url"]}</value>\r\n";
		$strSendData .= "    </param>\r\n";
		if ( ereg( "yahoo" , $arrUrlInfo["host"] ) != 1 ) {
			$strSendData .= "    <param>\r\n";
			$strSendData .= "      <value>{$arrU["up_url"]}</value>\r\n";
			$strSendData .= "    </param>\r\n";
			$strSendData .= "    <param>\r\n";
			$strSendData .= "      <value>{$arrU["rss"]}</value>\r\n";
			$strSendData .= "    </param>\r\n";
		}
		$strSendData .= "  </params>\r\n";
		$strSendData .= "</methodCall>\r\n";
		$strSendData = mb_convert_encoding( $strSendData , "UTF-8" , "EUC-JP" );
		
		
		/*-----------------------------------------------------------
		 * ����Ping��������
		-----------------------------------------------------------*/
		fputs( $sock , "POST ".$arrUrlInfo["path"]." HTTP/1.0\r\n" );
		fputs( $sock , "Host: ".$arrUrlInfo["host"]."\r\n" );
		fputs( $sock , "Content-Type: text/xml\r\n" );
		fputs( $sock , "Content-length: ".strlen($strSendData)."\r\n" );
		fputs( $sock , "\r\n" );
		fputs( $sock , "{$strSendData}\r\n" );
		
		
		/*-----------------------------------------------------------
		 * ��ꥵ���С�����������������
		-----------------------------------------------------------*/
		$result = "";
		while( !feof($sock) ){
			$result .= fgets( $sock , 4096 );
		}
		
		
		/*-----------------------------------------------------------
		 * ����ۥ��ȤȤ���³���
		-----------------------------------------------------------*/
		fclose( $sock );
		
		
		/*-----------------------------------------------------------
		 * �������Ƥ��饨�顼�����ɤ��ɤ߼��
		-----------------------------------------------------------*/
		$arrErr['hidden'] .= "send_name ... [".$arrD["name"][$iX]."]\r\n<br />\r\n\r\n";
		$arrErr['hidden'] .= "send_detail ... [".$strSendData."]\r\n<br />\r\n\r\n\r\n";
		$arrErr['hidden'] .= "result ... [".$result."]\r\n<br />\r\n<br />\r\n<br />\r\n\r\n";
		//flush();
	}
	
	return Array( 0 , $arrErr );
	
}

?>
