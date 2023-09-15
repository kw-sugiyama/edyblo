/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function TeacherInputCheck( parts , parts2 )
{

	// 状態
	intChk_bd = 9;
	intCnt_bd = parts.elements["tc_stat"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["tc_stat"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("状態を指定して下さい。");
		parts.elements["tc_stat"][0].focus();
		return false;
	}

	// コメント
	if( ! SpaceCheck( parts.tc_comment.value ) ) {
		alert("コメントはスペースのみの登録が出来ません。");
		parts.tc_comment.focus();
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
function TeacherDeleteCheck( parts , parts2 )
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
