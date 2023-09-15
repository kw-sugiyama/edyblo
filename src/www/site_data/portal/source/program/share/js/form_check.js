/*=====================================================================
    お問合せ - 入力フォームチェック
=====================================================================*/


//HPお問い合せ
function hp_inquiry_check( parts )
{
	//お問い合せ内容チェックボタン
	
	//メールアドレス
	if ( parts.email.value == "" ) {
		alert("メールアドレスを入力して下さい。");
		parts.email.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.email.value ) ) {
			alert("メールアドレスを正しく入力して下さい。");
			parts.email.focus();
			return false;
		}
	}

	// 件名
	if ( parts.subject.value == "" ) {
		alert("件名を入力して下さい。");
		parts.subject.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.subject.value ) ) {
			alert("件名はスペースのみの入力はできません。");
			parts.subject.focus();
			return false;
		}
	}
	
	return true;
	
}

//塾問い合わせ
function juku_inquiry_check( parts )
{

	//お問い合せ内容チェックボタン
	if( !parts.elements['title[0]'].checked && !parts.elements['title[1]'].checked && !parts.elements['title[2]'].checked && !parts.elements['title[3]'].checked){
    	alert("お問い合せ内容をお選び下さい。");
		parts.elements['title[0]'].focus();
		return false;
	}

	//お問い合せ内容チェックボタン
	if( !parts.elements['device[0]'].checked && !parts.elements['device[1]'].checked && !parts.elements['device[2]'].checked && !parts.elements['device[3]'].checked){
    	alert("ご希望内容をお選び下さい。");
		parts.elements['device[0]'].focus();
		return false;
	}
	
	// お名前
	if ( parts.name_kj_1.value == "" ) {
		alert("お名前を入力して下さい。");
		parts.name_kj_1.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("お名前はスペースのみの入力はできません。");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	//フリガナ−カタカナチェック
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) && parts.name_kn_1.value !="" ) {
		alert("フリガナは全角カタカナで入力して下さい。");
		parts.name_kn_1.focus();
		return false;
	}
		
	//メールアドレス
	if ( parts.email.value == "" ) {
		alert("メールアドレスを入力して下さい。");
		parts.email.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.email.value ) ) {
			alert("メールアドレスを正しく入力して下さい。");
			parts.email.focus();
			return false;
		}
	}

	//電話番号チェック　（ハイフン必須）
	if ( !TellCheck_2( parts.tell_1.value ) && parts.tell_1.value !="") {
		alert("電話番号をハイフン入りで正しく入力して下さい。");
		parts.tell_1.focus();
		return false;
	}

	//携帯番号チェック　（ハイフン必須）
	if ( !PhsCheck_2( parts.mobile_1.value ) && parts.mobile_1.value !="") {
		alert("携帯電話番号をハイフン入りで正しく入力して下さい。");
		parts.mobile_1.focus();
		return false;
	}

	return true;
	
}
