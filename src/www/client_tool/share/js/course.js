/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function CourseInputCheck( parts , parts2 )
{

	// 所属カテゴリー
	if( parts.cs_cgid.value == "" ){
		alert("所属カテゴリーを選択して下さい。");
		parts.cs_cgid.focus();
		return false;
	}

	// タイトル
	if( parts.cs_title.value == "" ){
		alert("タイトルを入力して下さい。");
		parts.cs_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cs_title.value ) ) {
			alert("タイトルはスペースのみの登録が出来ません。");
			parts.cs_title.focus();
			return false;
		}
	}
	
	// 講師
	if( parts.cs_tccomment.value != "" ){
		if( ! SpaceCheck( parts.cs_tccomment.value ) ) {
			alert("講師コメントはスペースのみの登録が出来ません。");
			parts.cs_tccomment.focus();
			return false;
		}
	}
	if( parts.cs_tcid.value == "" && parts.cs_tccomment.value != "" ){
		alert("講師コメントを入力された場合は講師を選択して下さい。");
		parts.cs_tcid.focus();
		return false;
	}
	if( parts.cs_tcid.value != "" && parts.cs_tccomment.value == "" ){
		alert("講師を選択された場合は講師コメントを入力して下さい。");
		parts.cs_tccomment.focus();
		return false;
	}

	// 教科
	if( parts.cs_jtitle.value == "" ){
		alert("教科を入力して下さい。");
		parts.cs_jtitle.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cs_jtitle.value ) ) {
			alert("教科はスペースのみの登録が出来ません。");
			parts.cs_jtitle.focus();
			return false;
		}
	}
	
	//目的
	if (!document.getElementById("cs_purpose0").checked && !document.getElementById("cs_purpose1").checked && !document.getElementById("cs_purpose2").checked) { 
    	alert("目的を選択して下さい");
		document.getElementById("cs_purpose0").focus();
		return false;
	}

	// 実施曜日
	if( parts.cs_week.value != "" ){
		if( ! SpaceCheck( parts.cs_week.value ) ) {
			alert("実施曜日はスペースのみの登録が出来ません。");
			parts.cs_week.focus();
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
function CourseDeleteCheck( parts , parts2 )
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
