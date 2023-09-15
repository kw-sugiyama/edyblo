/*========================================================
     タグ挿入処理
========================================================*/
function HTML_TAG( idName , tag , option ) {
	
	var obj = this.document.getElementById(idName);
	if (!obj) return false;
	
	// 拡張挿入
	var intResult = new Array;
	intResult = TAG_CHANGE( tag );
	if ( intResult == 9 ){
		return false;
	} else {
		if ( intResult[1] != "" ) {
			strStartTag = intResult[1];
		} else {
			strStartTag = tag;
		}
		if ( intResult[2] != "" ) {
			strEndTag = intResult[2];
		} else {
			strEndTag = tag;
		}
	}
	
	var bgnTag = Array('[',strStartTag,']').join('') ;
	if( option != 1){
		var endTag = Array('[/',strEndTag,']').join('');
	}
	
	if (document.selection) {
		obj.focus();
		var str = document.selection.createRange().text;
		document.selection.createRange().text = Array(bgnTag,str,endTag).join('');
	} else if ( (obj.selectionEnd - obj.selectionStart) >= 0 ) {
		var bgnPos = obj.selectionStart;
		var endPos = obj.selectionEnd;
		var bfrStr = obj.value.substring(0, bgnPos);
		var fcsStr = Array(bgnTag,obj.value.substring(bgnPos, endPos),endTag).join('');
		var difLen = fcsStr.length - (endPos - bgnPos);
		var aftStr = obj.value.substring(endPos, obj.value.length);
		obj.value = Array(bfrStr,fcsStr,aftStr).join('');
		obj.setSelectionRange(bgnPos,endPos + difLen);
	} else {
		obj.value = Array(obj.value,bgnTag,endTag).join('');
	}
	return false;
}


/*=======================================================
    タグ挿入拡張 - その１：指定タグが来たら変換
=======================================================*/
function TAG_CHANGE( strTag )
{
	
	var strStTag = "";
	var strEdTag = "";
	
	if ( strTag == 'A' ){
		var msg;
		msg = window.prompt("URLを入力して下さい。","");		
		strStTag = "A='"+msg+"'";
		strEdTag = "A";
	}
	if ( strTag == 'BR' ){
		var msg;
		strStTag = "br";
		strEdTag = "";
	}
	if ( strTag.indexOf("FONT") != -1 ){
		// fontタグに変換
		arrVal = strTag.split("-");
		switch( arrVal[1] ){
			case "RED":
				strStTag = "RED";
				strEdTag = "RED";
				break;
			case "BLUE":
				strStTag = "BLUE";
				strEdTag = "BLUE";
				break;
			case "YELLOW":
				strStTag = "YELLOW";
				strEdTag = "YELLOW";
				break;
			case "GREEN":
				strStTag = "GREEN";
				strEdTag = "GREEN";
				break;
			default:
				return 9;
				break;
		}
	}
	if ( strTag.indexOf("IMAGE") != -1 ){
		// fontタグに変換
		arrVal = strTag.split("-");
		switch( arrVal[1] ){
			case "1":
				strStTag = "IMG1";
				break;
			case "2":
				strStTag = "IMG2";
				break;
			case "3":
				strStTag = "IMG3";
				break;
			case "4":
				strStTag = "IMG4";
				break;
			default:
				return 9;
				break;
		}
		strEdTag = "";
	}
	intRet = 1;
	
	var backData = new Array;
	backData[0] = intRet;
	backData[1] = strStTag;
	backData[2] = strEdTag;
	
	return backData; 
}
