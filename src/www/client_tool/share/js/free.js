/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function freeInputCheck( parts , parts2 )
{


	// タイトル
	if( parts.fr_title.value === "" ){
		alert("タイトルを入力して下さい。");
		parts.fr_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.fr_title.value ) ) {
			alert("タイトルはスペースのみの登録が出来ません。");
			parts.fr_title.focus();
			return false;
		}
	}




	// タイトル
	if( parts.fr_html.value === "" ){
		alert("自由ＨＴＭＬを入力して下さい。");
		parts.fr_html.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.fr_html.value ) ) {
			alert("自由ＨＴＭＬはスペースのみの登録が出来ません。");
			parts.fr_html.focus();
			return false;
		}
	}


	// 登録確認
	ret_com = confirm("登録／修正します。よろしいですか？");
	if( !ret_com ){
		return false;
	}
	
	parts2.submit();
	return true;
	
}


/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function FreeDeleteCheck( parts , parts2 )
{
	
	ret_com = confirm("削除します。よろしいですか？");
	if ( !ret_com ) {
		return false;
	}
	
	parts.submit();
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
