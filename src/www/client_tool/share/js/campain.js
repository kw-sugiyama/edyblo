/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function CampainInputCheck( parts , parts2 )
{

	// 状態
	intChk_bd = 9;
	intCnt_bd = parts.elements["cp_stat"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["cp_stat"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("状態を指定して下さい。");
		parts.elements["cp_stat"][0].focus();
		return false;
	}

	// 講師
	if( parts.cp_tccomment.value != "" ){
		if( ! SpaceCheck( parts.cp_tccomment.value ) ) {
			alert("講師コメントはスペースのみの登録が出来ません。");
			parts.cp_tccomment.focus();
			return false;
		}
	}
	if( parts.cp_tcid.value == "" && parts.cp_tccomment.value != "" ){
		alert("講師コメントを入力された場合は講師を選択して下さい。");
		parts.cp_tcid.focus();
		return false;
	}
	if( parts.cp_tcid.value != "" && parts.cp_tccomment.value == "" ){
		alert("講師を選択された場合は講師コメントを入力して下さい。");
		parts.cp_tccomment.focus();
		return false;
	}

	// 所属カテゴリー
	if( parts.cp_cgid.value == "" ){
		alert("所属カテゴリーを選択して下さい。");
		parts.cp_cgid.focus();
		return false;
	}

	// タイトル
	if( parts.cp_title.value == "" ){
		alert("タイトルを入力して下さい。");
		parts.cp_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cp_title.value ) ) {
			alert("タイトルはスペースのみの登録が出来ません。");
			parts.cp_title.focus();
			return false;
		}
	}
	
	// サブタイトル
	if( parts.cp_subtitle.value == "" ){
		alert("サブタイトルを入力して下さい。");
		parts.cp_subtitle.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cp_subtitle.value ) ) {
			alert("タイトルはスペースのみの登録が出来ません。");
			parts.cp_subtitle.focus();
			return false;
		}
	}
	
	if (parts.cp_btntext.value.length > 20) {
		alert("ボタンテキストは20文字以内で入力してください。");
		return false;
	}

	// 内容
	if( parts.cp_contents.value == "" ){
		alert("内容を入力して下さい。");
		parts.cp_contents.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cp_contents.value ) ) {
			alert("内容はスペースのみの登録が出来ません。");
			parts.cp_contents.focus();
			return false;
		}
	}

	// キャンペーンバナーレイアウト
	intChk_bd = 9;
	intCnt_bd = parts.elements["cp_bkgdimg"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["cp_bkgdimg"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("キャンペーンバナーレイアウトを指定して下さい。");
		parts.elements["cp_bkgdimg"][0].focus();
		return false;
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
function CampainDeleteCheck( parts , parts2 )
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
