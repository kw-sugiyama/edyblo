function ChkSearchBox( parts ){
	// 県名
	//未選択ならアラート
	if ( parts.elements['ar[]'].value == "" ) {
		alert("県名を選択して下さい。");
		parts.elements['ar[]'].focus();
		return false;
	}
	return true;
}


function ChkFreeSearchBox( parts ){
	// フリーワード
	//デフォルト・空・スペースのみならアラート
	if ( parts.elements['fw'].value == "" || parts.elements['fw'].value == parts.elements['fw'].defaultValue || !SpaceCheck( parts.elements['fw'].value ) ) {
		alert("検索ワードを入力して下さい。");
		parts.elements['fw'].focus();
		return false;
	}
	return true;
}

function ChkFreeSearchBoxReset( parts ){
	// フリーワード
	//デフォルト状態なら空にする
	if ( parts.elements['fw'].value == parts.elements['fw'].defaultValue ) {
		parts.elements['fw'].value = "";
	}
}

function ChkSearchBox2( parts ){
	// フリーワード
	//県名が空 かつ フリーワードが、空・デフォルト・スペースのどれかならアラート
	if ( parts.elements['ar[]'].value == "" && ( parts.elements['fw'].value == "" || parts.elements['fw'].value == parts.elements['fw'].defaultValue || !SpaceCheck( parts.elements['fw'].value ) ) ) {
		alert("県名・キーワードのどちらかを設定して下さい。");
		parts.elements['ar[]'].focus();
		return false;
	}
	return true;
}

function ChkSearchPrefSelect( parts ){
	//県チェックボタン
	var chk_flg = 9;
	if( parts.elements['ar[]'].length > 0 ){
		for (var i = 0; i < parts.elements['ar[]'].length; i++){
			if( parts.elements['ar[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['ar[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("県を一つ以上選択して下さい。");
		return false;
	}
}

function ChkSearchCitySelect( parts ){
	//県チェックボタン
	var chk_flg = 9;
	if( parts.elements['pf[]'].length > 0 ){
		for (var i = 0; i < parts.elements['pf[]'].length; i++){
			if( parts.elements['pf[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['pf[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("市区群を一つ以上選択して下さい。");
		return false;
	}
}

function ChkSearchLineSelect1( parts ){
	//県チェックボタン
	var chk_flg = 9;
	if( parts.elements['ln[]'].length > 0 ){
		for (var i = 0; i < parts.elements['ln[]'].length; i++){
			if( parts.elements['ln[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['ln[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("沿線を一つ以上選択して下さい。");
		return false;
	}else{
		actnRplcHidden('mode','mode','ln');
		actnRplc('form1','/psearch-result/page-1.html','');
		return true;
	}
}

function ChkSearchLineSelect2( parts ){
	//県チェックボタン
	var chk_flg = 9;
	if( parts.elements['ln[]'].length > 0 ){
		for (var i = 0; i < parts.elements['ln[]'].length; i++){
			if( parts.elements['ln[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['ln[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("沿線を一つ以上選択して下さい。");
		return false;
	}else{
		actnRplcHidden('mode','','');
		actnRplc('form1','/psearch-sta/','');
		return true;
	}
}

function ChkSearchStaSelect( parts ){
	//県チェックボタン
	var chk_flg = 9;
	if( parts.elements['st[]'].length > 0 ){
		for (var i = 0; i < parts.elements['st[]'].length; i++){
			if( parts.elements['st[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['st[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("駅を一つ以上選択して下さい。");
		return false;
	}
}
