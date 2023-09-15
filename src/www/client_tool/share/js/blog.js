/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function BlogInputCheck( parts , parts2 )
{
	
	// ＴＯＰウィンドウタイトル
	if( parts.sc_topwindowtitle.value == "" ){
		alert("ＴＯＰウィンドウタイトルを入力して下さい");
		parts.sc_topwindowtitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_topwindowtitle.value ) ) {
			alert("ＴＯＰウィンドウタイトルはスペースのみの登録が出来ません。");
			parts.sc_topwindowtitle.focus();
			return false;
	}

	
	// ヘッダー用タイトル
	if( parts.sc_headertitle.value == "" ){
		alert("ヘッダー用タイトルを入力して下さい");
		parts.sc_headertitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_headertitle.value ) ) {
			alert("ヘッダー用タイトルはスペースのみの登録が出来ません。");
			parts.sc_headertitle.focus();
			return false;
	}

	
	// ＴＯＰ教室情報タイトル
	if( parts.sc_toptitle.value == "" ){
		alert("ＴＯＰ教室情報タイトルを入力して下さい");
		parts.sc_toptitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_toptitle.value ) ) {
			alert("ＴＯＰ教室情報タイトルはスペースのみの登録が出来ません。");
			parts.sc_toptitle.focus();
			return false;
	}

	
	// ＴＯＰ教室情報サブタイトル
	if( parts.sc_topsubtitle.value == "" ){
		alert("ＴＯＰ教室情報サブタイトルを入力して下さい");
		parts.sc_topsubtitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_topsubtitle.value ) ) {
			alert("ＴＯＰ教室情報サブタイトルはスペースのみの登録が出来ません。");
			parts.sc_topsubtitle.focus();
			return false;
	}

	
	// ＴＯＰキャンペーン・イベント情報タイトル
	if( parts.sc_campaintitle.value == "" ){
		alert("ＴＯＰキャンペーン・イベント情報タイトルを入力して下さい");
		parts.sc_campaintitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_campaintitle.value ) ) {
			alert("ＴＯＰキャンペーン・イベント情報タイトルはスペースのみの登録が出来ません。");
			parts.sc_campaintitle.focus();
			return false;
	}

	
	// ＴＯＰコース情報タイトル
	if( parts.sc_coursetitle.value == "" ){
		alert("ＴＯＰコース情報タイトルを入力して下さい");
		parts.sc_coursetitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_coursetitle.value ) ) {
			alert("ＴＯＰコース情報タイトルはスペースのみの登録が出来ません。");
			parts.sc_coursetitle.focus();
			return false;
	}

	
	// ＴＯＰ日記情報タイトル
	if( parts.sc_diarytitle.value == "" ){
		alert("ＴＯＰ日記情報タイトルを入力して下さい");
		parts.sc_diarytitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_diarytitle.value ) ) {
			alert("ＴＯＰ日記情報タイトルはスペースのみの登録が出来ません。");
			parts.sc_diarytitle.focus();
			return false;
	}

	
	// 入塾説明文
	if( parts.sc_addmission.value == "" ){
		alert("入塾説明文を入力して下さい");
		parts.sc_addmission.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_addmission.value ) ) {
			alert("入塾説明文はスペースのみの登録が出来ません。");
			parts.sc_addmission.focus();
			return false;
	}

	
	// ブログ紹介文
	ret_disc = ReturnCntCheck( parts.sc_introduce.value , 3 );
	if( !ret_disc ){
		alert("ブログ紹介文は３行以内で入力して下さい。");
		parts.sc_introduce.focus();
		return false;
	} else {
		arrDisc = parts.sc_introduce.value.split("\n");
		cntDisc = arrDisc.length;
		cntDisc2 = arrDisc.length;
		var intBuffCnt = 0;
		for ( i=0; i<cntDisc; i++ ) {
			arrDisc[i] = ReturnDetection( arrDisc[i] );
			arrDisc[i] = ReturnDelete( arrDisc[i] );
			ibc = arrDisc[i].length;
			if ( ibc > 27 ) cntDisc2 = cntDisc2 + 1;
			intBuffCnt = intBuffCnt + ibc;
		}
		if ( intBuffCnt > 80 ) {
			alert("ブログ紹介文は８０文字以内で入力して下さい。");
			parts.sc_introduce.focus();
			return false;
		} else {
			if ( cntDisc2 > 3 ) {
				alert("ブログ紹介文は２７文字×３行の間で入力して下さい。");
				parts.sc_introduce.focus();
				return false;
			}
		}
	}

	// ブログ基本色
	intChk_bd = 9;
	intCnt_bd = parts.elements["sc_clr"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["sc_clr"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("ブログ基本色を指定して下さい。");
		parts.elements["sc_clr"][0].focus();
		return false;
	}
	
	// エントリーメール送信先
	if ( parts.sc_entrymail.value == "" ){
		alert("「お申し込み」受信先メールアドレスを設定して下さい。");
		parts.sc_entrymail.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.sc_entrymail.value ) ){
			alert("「お申し込み」受信先メールアドレスを正しく入力して下さい。");
			parts.sc_entrymail.focus();
			return false;
		}
	}
	
	// 問合せメール送信先
	if ( parts.sc_infomail.value == "" ){
		alert("「資料請求」お問い合わせ」受信先メールアドレスを設定して下さい。");
		parts.sc_infomail.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.sc_infomail.value ) ){
			alert("「資料請求」お問い合わせ」受信先メールアドレスを正しく入力して下さい。");
			parts.sc_infomail.focus();
			return false;
		}
	}
	
	// 営業時間
	if ( parts.sc_start_h.value == "" ) {
		alert("営業開始時間（時）を選択して下さい。");
		parts.sc_start_h.focus();
		return false;
	}
	if ( parts.sc_start_m.value == "" ) {
		alert("営業開始時間（分）を選択して下さい。");
		parts.sc_start_m.focus();
		return false;
	}
	if ( parts.sc_end_h.value == "" ) {
		alert("営業終了時間（時）を選択して下さい。");
		parts.sc_end_h.focus();
		return false;
	}
	if ( parts.sc_end_m.value == "" ) {
		alert("営業終了時間（分）を選択して下さい。");
		parts.sc_end_m.focus();
		return false;
	}
	
	// 定休日
	if ( parts.sc_holiday.value == "" ){
		alert("定休日を入力して下さい。");
		parts.sc_holiday.focus();
		return false;
	}
	
	// 会社ホームページ
//	if ( parts.sc_hp.value != "" ) {
//		if ( ! URLCheck( parts.sc_hp.value ) ) {
//			alert("会社ホームページアドレスを正しく入力して下さい。");
//			parts.sc_hp.focus();
//			return false;
//		}
//	}
	
	// 最寄沿線・駅
	if ( parts.es_line1.value == "" || parts.es_sta1.value == "" ){
		alert("最寄駅を設定して下さい。");
		parts.line_setting.focus();
		return false;
	}
	if ( parts.es_walk1.value == "" ){
		alert("最寄駅からの所要時間を設定して下さい。");
		parts.es_walk1.focus();
		return false;
	} else {
		if ( !IntValCheck( parts.es_walk1.value ) ) {
			alert("所要時間は半角数字のみ入力して下さい。");
			parts.es_walk1.focus();
			return false();
		}
	}
	
	// 会社ＰＲ
	ret_sc_pr = ReturnCntCheck( parts.sc_pr.value , 5 );
	if( !ret_sc_pr ){
		alert("会社ＰＲは５行以内で入力して下さい。");
		parts.sc_pr.focus();
		return false;
	} else {
		arrPr = parts.sc_pr.value.split("\n");
		cntPr = arrPr.length;
		cntPr2 = arrPr.length;
		var intBuffCnt2 = 0;
		for ( i=0; i<cntPr; i++ ) {
			arrPr[i] = ReturnDetection( arrPr[i] );
			arrPr[i] = ReturnDelete( arrPr[i] );
			ipr = arrPr[i].length;
			if ( ipr > 25 ) cntPr2 = cntPr2 + 1;
			intBuffCnt2 = intBuffCnt2 + ipr;
		}
		if ( intBuffCnt2 > 125 ) {
			alert("会社ＰＲ文は１２５文字以内で入力して下さい。");
			parts.sc_pr.focus();
			return false;
		} else {
			if ( cntPr2 > 5 ) {
				alert("会社ＰＲ文は２５文字×５行の間で入力して下さい。");
				parts.sc_pr.focus();
				return false;
			}
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
    沿線駅設定画面を開く
==================================================*/
function OpenPageSta( line , station , ln_cd , st_cd , ln_cd_name )
{
	window.open( '../station_select.php?fn=go_upd&fg=0&line='+line+'&station='+station+'&ln_cd='+ln_cd+'&st_cd='+st_cd+'&ln_cd_name='+ln_cd_name , 'station' , 'directories=no,location=no,menubar=no,toolbar=no,scrollbars=yes,width=340,height=500,left=0,top=0' );
}
