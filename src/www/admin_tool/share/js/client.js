/*==================================================
    クライアント一覧検索条件チェック
==================================================*/
function ClientSearchCheck( parts , parts2 )
{
	// 会社名検索
	if ( parts.sea_cl_name_like.value != "" ){
		if( ! SpaceCheck( parts.sea_cl_name_like.value ) ) {
			alert("会社名指定ではスペースのみの検索はできません。");
			parts.sea_cl_name_like.focus();
			return false;
		}
	}
	
	// 使用期限検索(開始)
	if ( parts.sea_cl_limit_date_s_y.value != "" || parts.sea_cl_limit_date_s_m.value != "" || parts.sea_cl_limit_date_s_d.value != "" ){
		if ( parts.sea_cl_limit_date_s_y.value == "" || parts.sea_cl_limit_date_s_m.value == "" || parts.sea_cl_limit_date_s_d.value == "" ){
			alert("使用期限（開始）を正しく指定して下さい。");
			parts.sea_cl_limit_date_s_y.focus();
			return false;
		}
		ldsy_txt = parts.sea_cl_limit_date_s_y.value+"-"+parts.sea_cl_limit_date_s_m.value+"-"+parts.sea_cl_limit_date_s_d.value
		if ( !DateCheck_1( ldsy_txt ) ) {
			alert("使用期限（開始）を正しく選択して下さい。");
			parts.sea_cl_limit_date_s_y.focus();
			return false;
		}
	}
	
	// 使用期限検索(終了)
	if ( parts.sea_cl_limit_date_e_y.value != "" || parts.sea_cl_limit_date_e_m.value != "" || parts.sea_cl_limit_date_e_d.value != "" ){
		if ( parts.sea_cl_limit_date_e_y.value == "" || parts.sea_cl_limit_date_e_m.value == "" || parts.sea_cl_limit_date_e_d.value == "" ){
			alert("使用期限（終了）を正しく指定して下さい。");
			parts.sea_cl_limit_date_e_y.focus();
			return false;
		}
		ldsy_txt = parts.sea_cl_limit_date_e_y.value+"-"+parts.sea_cl_limit_date_e_m.value+"-"+parts.sea_cl_limit_date_e_d.value
		if ( !DateCheck_1( ldsy_txt ) ) {
			alert("使用期限（終了）を正しく選択して下さい。");
			parts.sea_cl_limit_date_e_y.focus();
			return false;
		}
	}
	
	return true;
}


/*==================================================
    クライアント登録／修正情報入力チェック
==================================================*/
function ClientInputCheck( parts , parts2 )
{
	
	// 状態
	if( !parts.elements["cl_stat"][0].checked && !parts.elements["cl_stat"][1].checked ) {
		alert("状態を指定して下さい");
		parts.elements["cl_stat"][0].focus();
		return false;
	}
	
	// 会社名
	if( parts.cl_jname.value == "" ){
		alert("会社名を入力して下さい");
		parts.cl_jname.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cl_jname.value ) ) {
			alert("会社名はスペースのみの登録はできません。");
			parts.cl_jname.focus();
			return false;
		}
	}
	
	// 支店名
	if( parts.cl_kname.value != "" ){
		if( ! SpaceCheck( parts.cl_kname.value ) ) {
			alert("支店名はスペースのみの登録はできません。");
			parts.cl_kname.focus();
			return false;
		}
	}
	
	// 担当者名
	if( parts.cl_agent.value != "" ){
		if( ! SpaceCheck( parts.cl_agent.value ) ) {
			alert("担当者名はスペースのみの登録はできません。");
			parts.cl_agent.focus();
			return false;
		}
	}
	
	// 会社住所
	if( parts.ar_zip1.value == "" ){
		alert("郵便番号を選択して下さい。");
		parts.ar_zip1.focus();
		return false;
	}
	if( parts.ar_zip2.value == "" ){
		alert("郵便番号を選択して下さい。");
		parts.ar_zip2.focus();
		return false;
	}
	if( parts.ar_add.value == "" ){
		alert("番地を入力して下さい");
		parts.ar_add.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ar_add.value ) ) {
			alert("番地はスペースのみの登録はできません。");
			parts.ar_add.focus();
			return false;
		}
	}

	if( parts.ar_estate.value != "" ){
		if( ! SpaceCheck( parts.ar_estate.value ) ) {
			alert("建物名はスペースのみの登録はできません。");
			parts.ar_estate.focus();
			return false;
		}
	}
	
	// 会社電話番号
/* 20100218 クライアント電話番号チェックをコメントアウト
	if( parts.cl_phone.value != "" ){
		if( ! SpaceCheck( parts.cl_phone.value ) ) {
			alert("会社電話番号はスペースのみの登録はできません。");
			parts.cl_phone.focus();
			return false;
		}
		if( ! TellCheck_2( parts.cl_phone.value ) ) {
			alert("会社電話番号は'-'付き半角数字で入力して下さい。");
			parts.cl_phone.focus();
			return false;
		}
	}
*/	
	// 会社ＦＡＸ
	if( parts.cl_fax.value != "" ){
		if( ! SpaceCheck( parts.cl_fax.value ) ) {
			alert("会社ＦＡＸ番号はスペースのみの登録はできません。");
			parts.cl_fax.focus();
			return false;
		}
		if( ! TellCheck_2( parts.cl_fax.value ) ) {
			alert("会社ＦＡＸ番号は'-'付き半角数字で入力して下さい。");
			parts.cl_fax.focus();
			return false;
		}
	}
	
	// 担当者Ｅメール
	if( parts.cl_mail.value == "" ){
		alert("担当者Ｅメールアドレスを入力して下さい");
		parts.cl_mail.focus();
		return false;
	} else {
		if( ! EmailCheck( parts.cl_mail.value ) ) {
			alert("担当者Ｅメールアドレスを正しく入力して下さい。");
			parts.cl_mail.focus();
			return false;
		}
	}
	
	// ログインＩＤ
	if( parts.cl_loginid.value == "" ){
		alert("ログインIDを入力して下さい");
		parts.cl_loginid.focus();
		return false;
	}
	if( !LoginValCheck( parts.cl_loginid.value ) ){
		alert("ログインＩＤは半角英数字のみ有効です");
		parts.cl_loginid.focus();
		return false;
	}
	
	// ログインＰＡＳＳ
	if( parts.cl_passwd.value == "" ){
		alert("ログインパスワードを入力して下さい");
		parts.cl_passwd.focus();
		return false;
	}
	if( !LoginValCheck( parts.cl_passwd.value ) ){
		alert("ログインパスワードは半角英数字のみ有効です");
		parts.cl_passwd.focus();
		return false;
	}
	
	// アドレス用ＩＤ
	if( parts.cl_dokuji_flg.value != 1){
		if( parts.cl_urlcd.value == "" ){
			alert("ＵＲＬ用コードを入力して下さい");
			parts.cl_urlcd.focus();
			return false;
		}
		if( !TargetValCheck( parts.cl_urlcd.value , "^[a-z0-9\-]+$" ) ){
			alert("ＵＲＬ用コードは半角小文字英数字と「 -（ハイフン）」のみ有効です。");
			parts.cl_urlcd.focus();
			return false;
		}
	}
	
	// 独自ドメイン可/不可
	if( !parts.elements["cl_dokuji_flg"][0].checked && !parts.elements["cl_dokuji_flg"][1].checked ) {
		alert("独自ドメイン可/不可を指定して下さい");
		parts.elements["cl_dokuji_flg"][0].focus();
		return false;
	}
	
	// 独自用GoogleMap API Key
	if( parts.cl_dokuji_flg[0].checked == true && parts.cl_googlemap_key.value == "" ){
		alert("独自ドメイン可の場合は独自用GoogleMap API Keyを入力して下さい。");
		parts.cl_googlemap_key.focus();
		return false;
	}
	
	// 独自ドメイン
	if( parts.cl_dokuji_flg[0].checked == true && parts.cl_dokuji_domain.value == "" ){
		alert("独自ドメイン可の場合は独自ドメインを入力して下さい。");
		parts.cl_dokuji_domain.focus();
		return false;
	}
	
	// 有効期限
	if ( parts.cl_end_y.value != "" || parts.cl_end_m.value != "" || parts.cl_end_d.value != "" ) {
		if ( parts.cl_end_y.value == "" || parts.cl_end_m.value == "" || parts.cl_end_d.value == "" ) {
			alert("日付を正しく選択して下さい。");
			parts.cl_end_y.focus();
			return false;
		} else {
			txt_limit_date = parts.cl_end_y.value+"-"+parts.cl_end_m.value+"-"+parts.cl_end_d.value;
			if ( !DateCheck_1( txt_limit_date ) ) {
				alert("日付を正しく選択して下さい。");
				parts.cl_end_y.focus();
				return false;
			}
		}
	}
	// 広告掲載
	if( !parts.elements["cl_advertisement_flg"][0].checked && !parts.elements["cl_advertisement_flg"][1].checked ) {
		alert("広告掲載可/不可を指定して下さい");
		parts.elements["cl_advertisement_flg"][0].focus();
		return false;
	}
	// 広告タグ
	if( parts.cl_advertisement_flg[0].checked == true && parts.cl_advertisement_tag.value == "" ){
		alert("広告掲載可の場合は広告タグを入力して下さい。");
		parts.cl_advertisement_tag.focus();
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
    クライアント情報削除チェック
==================================================*/
function ClientDeleteCheck( parts , parts2 )
{
	
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


/*==================================================
    住所検索
==================================================*/
function zipSearch(){
	ar_zip = document.client.ar_zip1.value + "-" + document.client.ar_zip2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd&ad1=ar_pref&adc=ar_citycd&ad2=ar_city&ad3=ar_add','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    エリア１
==================================================*/
function zipSearch1(){
	ar_zip1 = document.client.ar_zip1_1.value + "-" + document.client.ar_zip1_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip1+'&pc=ar_prefcd1&ad1=ar_pref1&adc=ar_citycd1&ad2=ar_city1&ad3=ar_add1','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    エリア２
==================================================*/
function zipSearch2(){
	ar_zip2 = document.client.ar_zip2_1.value + "-" + document.client.ar_zip2_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip2+'&pc=ar_prefcd2&ad1=ar_pref2&adc=ar_citycd2&ad2=ar_city2&ad3=ar_add2','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    エリア３
==================================================*/
function zipSearch3(){
	ar_zip3 = document.client.ar_zip3_1.value + "-" + document.client.ar_zip3_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip3+'&pc=ar_prefcd3&ad1=ar_pref3&adc=ar_citycd3&ad2=ar_city3&ad3=ar_add3','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    URL用コード重複チェック
==================================================*/
function url_code_chk( parts ){
	cl_cd = document.client.cl_urlcd.value;
	cl_id = document.client.cl_id.value;
	window.open( '../account_search.php?ac='+cl_cd+'&ci='+cl_id , '' , 'directories=no,location=no,menubar=no,toolbar=no,width=300,height=50' , '');
}
