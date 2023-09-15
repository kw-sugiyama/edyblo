/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function DiaryInputCheck( parts , parts2 )
{

	// タイトル
	if( parts.dr_title.value == "" ){
		alert("タイトルを入力して下さい。");
		parts.dr_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.dr_title.value ) ) {
			alert("タイトルはスペースのみの登録が出来ません。");
			parts.dr_title.focus();
			return false;
		}
	}
	
	// 所属カテゴリー
	if( parts.dr_cgid.value == "" ){
		alert("所属カテゴリーを選択して下さい。");
		parts.dr_cgid.focus();
		return false;
	}



	// 一覧用本文
	if( parts.dr_contents.value == "" ){
		alert("一覧用本文を入力して下さい。");
		parts.dr_contents.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.dr_contents.value ) ) {
			alert("一覧用本文はスペースのみの登録が出来ません。");
			parts.dr_contents.focus();
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
function DiaryDeleteCheck( parts , parts2 )
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
