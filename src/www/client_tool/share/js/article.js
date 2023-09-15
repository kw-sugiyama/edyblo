/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function ArticleInputCheck( parts , parts2 )
{

	// 状態
	intChk_bd = 9;
	intCnt_bd = parts.elements["ac_stat"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["ac_stat"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("状態を指定して下さい。");
		parts.elements["ac_stat"][0].focus();
		return false;
	}

	// カテゴリ
	if ( parts.ac_cateid.value == "" ) {
		alert("カテゴリを選択して下さい。");
		parts.ac_cateid.focus();
		return false;
	}

	// タイトル
	if( parts.ac_title.value == "" ){
		alert("タイトルを入力して下さい。");
		parts.ac_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ac_title.value ) ) {
			alert("タイトルはスペースのみの登録が出来ません。");
			parts.ac_title.focus();
			return false;
		}
	}

	// 表示順
	if( parts.ac_dispno.value == "" ){
		alert("表示順を入力して下さい。");
		parts.ac_dispno.focus();
		return false;
	} else if( !IntValCheck( parts.ac_dispno.value ) ) {
		alert("表示順は半角数字で入力してください。");
		parts.ac_dispno.focus();
		return false;
	}
	
	// 内容
	if( parts.ac_contents.value == "" ){
		alert("内容を入力して下さい。");
		parts.ac_contents.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ac_contents.value ) ) {
			alert("内容はスペースのみの登録が出来ません。");
			parts.ac_contents.focus();
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
