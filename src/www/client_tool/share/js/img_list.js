/*==================================================
    入力チェック
==================================================*/
function fn_check( parts )
{
	// タイトル
	if( parts.img_title.value == "" ){
		alert("タイトルを入力して下さい。");
		parts.img_title.focus();
		return false;
	}
	
	// 建物所在地
	if( parts.img_name.value == "" ){
		alert("ファイルを選択して下さい。");
		parts.img_name.focus();
		return false;
	}
	
	return true;
}

/*==================================================
    削除前チェック
==================================================*/
function fn_limit_alert( )
{
	alert("最大登録件数に達しています。\n新たに登録したい場合は既存のファイルを削除して下さい。");
	return false;
}

/*==================================================
    削除前チェック
==================================================*/
function fn_del_img( p_form )
{
	result = confirm('ファイルを削除します。よろしいですか？');
	if (result){
		p_form.submit();
		return true;
	} else {
		return false;
	}
	
}
