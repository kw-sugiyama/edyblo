
//====================================================================
// js�饤�֥��
// ���٥�ȴ�Ϣ jslb_event.js 
// 
//
// 2005/04/16 ( Use Free �������Ѥ⼫ͳ�Ǥ� )
//--------------------------------------------------------------------
//--XMLHttpRequest���֥������������ؿ� 
// �� createHttpRequest()
// ��   httpoj = createHttpRequest()
// ���� XMLHttpRequest���֥������Ȥޤ���null
// http://allabout.co.jp/career/javascript/closeup/CU20030920/index.htm
//--------------------------------------------------------------------
// Toshirou Takahashi/���ݡ��� http://jsgt.org/mt/01/
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