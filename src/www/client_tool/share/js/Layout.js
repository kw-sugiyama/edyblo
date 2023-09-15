/*==================================================
    カテゴリー情報登録／修正入力チェック
==================================================*/
function LayoutInputCheck( parts , parts2 )
{
	
	var index1 = parts.sc_layout1.selectedIndex;
	var str1 = parts.sc_layout1.options[index1].value;
	var index2 = parts.sc_layout2.selectedIndex;
	var str2 = parts.sc_layout2.options[index2].value;
	var index3 = parts.sc_layout3.selectedIndex;
	var str3 = parts.sc_layout3.options[index3].value;
	var index4 = parts.sc_layout4.selectedIndex;
	var str4 = parts.sc_layout4.options[index4].value;

	var index5 = parts.sc_layout5.selectedIndex;
	var str5 = parts.sc_layout5.options[index5].value;
	var index6 = parts.sc_layout6.selectedIndex;
	var str6 = parts.sc_layout6.options[index6].value;
	var index7 = parts.sc_layout7.selectedIndex;
	var str7 = parts.sc_layout7.options[index7].value;
	var index8 = parts.sc_layout8.selectedIndex;
	var str8 = parts.sc_layout8.options[index8].value;

	if(str1 == str2){
		alert("左メニューが重複しています。");
		return false;
	}else if(str1 == str3){
		alert("左メニューが重複しています。");
		return false;
	}else if(str1 == str4){
		alert("左メニューが重複しています。");
		return false;
	}else if(str2 == str3){
		alert("左メニューが重複しています。");
		return false;
	}else if(str2 == str4){
		alert("左メニューが重複しています。");
		return false;
	}else if(str3 == str4){
		alert("左メニューが重複しています。");
		return false;
	}

	if(str5 == str6){
		alert("メインコンテンツが重複しています。");
		return false;
	}else if(str5 == str7){
		alert("メインコンテンツが重複しています。");
		return false;
	}else if(str5 == str8){
		alert("メインコンテンツが重複しています。");
		return false;
	}else if(str6 == str7){
		alert("メインコンテンツが重複しています。");
		return false;
	}else if(str6 == str8){
		alert("メインコンテンツが重複しています。");
		return false;
	}else if(str7 == str8){
		alert("メインコンテンツが重複しています。");
		return false;
	}

	ret_com = confirm("登録／修正します。よろしいですか？");
	if( !ret_com ){
		return false;
	}
	
	parts2.submit();
	return true;
	
}
