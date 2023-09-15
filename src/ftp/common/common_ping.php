<?

/*==========================================================================================
    更新Pingを送信する
	
	関数名 : SendUpdatePing
	
	使用方法 : list( $intResult , $arrErr ) = SendUpdatePing( $arrD , $arrU , $arrO );
	
	引数 :  $arrD ... Ping送信する情報を含めた二次元配列
			$arrD["name"][int]   ... Ping送信先名称
			$arrD["server"][int] ... Ping送信先アドレス
			$arrD["method"][int] ... Ping送信先で指定されたメソッド名
			$arrD["title"][int]  ... サイトのタイトル
			$arrD["url"][int]    ... 変更されたページのURL
			$arrD["rss"][int]    ... RSSファイルアドレス
			※二次元目の[int]は"0"から始まるようにする
		
		$arrU ... サイト情報
			$arrU["title"]  ... サイトタイトル
			$arrU["url"]    ... サイトのTOPURL
			$arrU["up_url"] ... サイトの更新されたページURL
			$arrU["rss"]    ... サイトのRSSファイル
		
		$arrO ... その他予備項目
	
	返値 :  $intResult ... 結果フラグ
			0       ... 正常終了
			(-1)    ... サーバーURLが不正 or 見つからない
			その他  ... 送信先サーバーからのエラーコード
		
		$arrErr ... エラーPing送信先名称（一次元配列）
	
==========================================================================================*/
function SendUpdatePing( $arrD , $arrU , $arrO )
{
	
	/*-----------------------------------------------------------
	 * 返り値の初期化
	-----------------------------------------------------------*/
	$intResult = 0;
	$arrErr = Array();
	
	
	/*-----------------------------------------------------------
	 * 送信先の件数取得
	-----------------------------------------------------------*/
	$intSendCount = count( $arrD["name"] );
	
	
	/*-----------------------------------------------------------
	 * 送信先件数分の処理を行う
	-----------------------------------------------------------*/
	for ( $iX=0; $iX<$intSendCount; $iX++ ) {
		
		/*-----------------------------------------------------------
		 * $server の内容をプロトコル・ホスト・それ以下に分割
		 *	例)http://imd.sp-jobnet.co.jp/click/index.html
		 *		$arrUrlInfo["scheme"] = "http"
		 *		$arrUrlInfo["host"] = "imd.sp-jobnet.co.jp"
		 *		$arrUrlInfo["path"] = "/click/index.html"
		-----------------------------------------------------------*/
		$arrUrlInfo = parse_url( $arrD["server"][$iX] );
		
		
		/*-----------------------------------------------------------
		 * 指定ホストに対しての接続処理
		 *	fsockopen( [host-name] , [port] , [error-no] , [error-message] , [session-timeout] )
		 *	$sock ... 接続ＩＤ
		-----------------------------------------------------------*/
		$sock = @fsockopen( $arrUrlInfo["host"] , 80 , $errno , $errstr , 60 );
		if ( $sock === false ) {
			$arrErr[] = $arrD["name"][$iX];
			return Array( "-1" , $arrErr );
		}
		
		
		/*-----------------------------------------------------------
		 * $arrD["method"][$iX] の値が無い場合、
		 * 基本メソッド「weblogUpdates.ping」に設定する
		-----------------------------------------------------------*/
		if ( $arrD["method"][$iX] == "" ) {
			$arrD["method"][$iX] = "weblogUpdates.ping";
		}
		
		
		/*-----------------------------------------------------------
		 * 更新Ping内容生成
		 *	$strSendData ... 送信内容
		 *          送信順序 : 
		 *              １．サイトタイトル
		 *              ２．サイトTOPURLアドレス
		 *              ３．更新されたページのURLアドレス
		 *              ４．RSSファイルアドレス
		 *          ※2007.05.13現在
		 *            Yahooに対して第３引数・第４引数は送信しない
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
		 * 更新Ping送信処理
		-----------------------------------------------------------*/
		fputs( $sock , "POST ".$arrUrlInfo["path"]." HTTP/1.0\r\n" );
		fputs( $sock , "Host: ".$arrUrlInfo["host"]."\r\n" );
		fputs( $sock , "Content-Type: text/xml\r\n" );
		fputs( $sock , "Content-length: ".strlen($strSendData)."\r\n" );
		fputs( $sock , "\r\n" );
		fputs( $sock , "{$strSendData}\r\n" );
		
		
		/*-----------------------------------------------------------
		 * 相手サーバーからの返答を受ける
		-----------------------------------------------------------*/
		$result = "";
		while( !feof($sock) ){
			$result .= fgets( $sock , 4096 );
		}
		
		
		/*-----------------------------------------------------------
		 * 指定ホストとの接続解除
		-----------------------------------------------------------*/
		fclose( $sock );
		
		
		/*-----------------------------------------------------------
		 * 返答内容からエラーコードを読み取り
		-----------------------------------------------------------*/
		$arrErr['hidden'] .= "send_name ... [".$arrD["name"][$iX]."]\r\n<br />\r\n\r\n";
		$arrErr['hidden'] .= "send_detail ... [".$strSendData."]\r\n<br />\r\n\r\n\r\n";
		$arrErr['hidden'] .= "result ... [".$result."]\r\n<br />\r\n<br />\r\n<br />\r\n\r\n";
		//flush();
	}
	
	return Array( 0 , $arrErr );
	
}

?>
