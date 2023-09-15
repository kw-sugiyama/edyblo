/*==================================================
    管理者登録／修正情報入力チェック
==================================================*/
function AdminInputCheck( parts , parts2 )
{
	
	if( parts.ad_loginid.value == "" ){
		alert("ログインIDを入力して下さい");
		parts.ad_loginid.focus();
		return false;
	}
	if( !LoginValCheck( parts.ad_loginid.value ) ){
		alert("ログインＩＤは半角英数字のみ有効です");
		parts.ad_loginid.focus();
		return false;
	}
	
	if( parts.ad_passwd.value == "" ){
		alert("ログインパスワードを入力して下さい");
		parts.ad_passwd.focus();
		return false;
	}
	if( !LoginValCheck( parts.ad_passwd.value ) ){
		alert("ログインパスワードは半角英数字のみ有効です");
		parts.ad_passwd.focus();
		return false;
	}
	
	if( parts.ad_name.value == "" ){
		alert("管理者名称を入力して下さい");
		parts.ad_name.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ad_name.value ) ) {
			alert("スペースのみの登録はできません。");
			parts.ad_name.focus();
			return false;
		}
	}
	if( parts2.ad_id.value == 1 && parts.ad_auth.checked == false ){
		alert("この管理者の管理権限は変更できません");
		parts.ad_auth.focus();
		return false;
	}
	
	ret_com = confirm("登録／修正します。よろしいですか？");
	if( !ret_com ){
		return false;
	}
	
	parts2.submit();
	return true;
	
}


/*==================================================
    管理者情報削除チェック
==================================================*/
function AdminDeleteCheck( parts , parts2 )
{
	
	if( parts2.ad_id.value == 1 ){
		alert("この管理者は削除できません");
		return false;
	}
	
	ret_com = confirm("削除します。よろしいですか？");
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
