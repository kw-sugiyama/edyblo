/*==================================================
    その他情報登録／修正入力チェック
==================================================*/
function AnotherInputCheck( parts , parts2 )
{
	
	if( parts.another_news_title.value == "" ){
		alert("タイトルを入力して下さい");
		parts.another_news_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.another_news_title.value ) ) {
			alert("タイトルはスペースのみの登録ができません。");
			parts.another_news_title.focus();
			return false;
		}
	}
	
	if( parts.another_news_comment.value == "" ){
		alert("タイトルを入力して下さい");
		parts.another_news_comment.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.another_news_comment.value ) ) {
			alert("本文はスペースのみの登録ができません。");
			parts.another_news_comment.focus();
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
