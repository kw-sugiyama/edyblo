
//====================================================================
// jsライブラリ
// イベント関連 jslb_event.js 
// 
//
// 2005/04/16 ( Use Free 商用利用も自由です )
//--------------------------------------------------------------------
//--XMLHttpRequestオブジェクト生成関数 
// 書式 createHttpRequest()
// 例   httpoj = createHttpRequest()
// 戻値 XMLHttpRequestオブジェクトまたはnull
// http://allabout.co.jp/career/javascript/closeup/CU20030920/index.htm
//--------------------------------------------------------------------
// Toshirou Takahashi/サポート http://jsgt.org/mt/01/
//--------------------------------------------------------------------



function createHttpRequest(){

	if(window.ActiveXObject){
		try {
			return new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				return new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e2) {
				return null;
	 		}
	 	}
	} else if(window.XMLHttpRequest){
		return new XMLHttpRequest();
	} else {
		return null;
	}
}