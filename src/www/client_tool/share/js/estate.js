/*==================================================
    案件情報次ページセット
==================================================*/
function EstateSelect( parts , flg )
{
	
	switch( flg ){
		case 1:
			parts.action = "estate_news_mnt.html";
			break;
		case 2:
			parts.action = "room_main.html";
			break;
		default:
			alert("値が正常ではありません。");
			return false;
	}
	
	parts.submit();
	return true;
	
}


/*==================================================
    案件情報登録／修正入力チェック
==================================================*/
function EstateInputCheck( parts , parts2 )
{
	
	if( ! parts.elements["stat"][0].checked && ! parts.elements["stat"][1].checked ){
		alert("状態を指定して下さい。");
		parts.elements["stat"][0].focus();
		return false;
	}
	
	if( parts.category_name.value == "" ){
		alert("カテゴリー名を入力して下さい");
		parts.category_name.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.category_name.value ) ) {
			alert("カテゴリー名はスペースのみの登録ができません。");
			parts.category_name.focus();
			return false;
		}
	}
	
	if( parts.disp_no.value == "" ){
		alert("表示順を入力して下さい");
		parts.disp_no.focus();
		return false;
	} else {
		if( ! IntValCheck( parts.disp_no.value ) ) {
			alert("表示順は半角数字のみで入力して下さい。");
			parts.disp_no.focus();
			return false;
		}
	}
	
	ret_com = confirm("登録／修正します。よろしいですか？");
	if( !ret_com ){
		return false;
	}
	
	parts2.submit();
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


