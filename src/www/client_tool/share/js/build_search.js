/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function BuildSearchCheck( parts , parts2 )
{
	// 建物名
	if( ! SpaceCheck( parts.search_build_name.value ) ) {
		alert("建物名はスペースのみの検索が出来ません。");
		parts.search_build_name.focus();
		return false;
	}
	
	// 建物所在地
	if( ! SpaceCheck( parts.search_address.value ) ) {
		alert("建物所在地はスペースのみの検索が出来ません。");
		parts.search_address.focus();
		return false;
	}
	
	return true;
}

/*==================================================
    フォーカス時、背景色を変える
==================================================*/
function Text( id , flag ){
	if(document.all){
		object = document.all(id).style;
	}else if(document.getElementById){
		object = document.getElementById(id).style;
	}else{
		return;
	}
	if(flag == 1){
		object.background = "#FFFFCC";
		object.color = "black";
	}else if(flag == 2){
		object.background = "white";
		object.color = "black";
	}
}



