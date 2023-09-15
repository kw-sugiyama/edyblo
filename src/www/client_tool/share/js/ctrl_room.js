/*==================================================
    検索 入力チェック
==================================================*/
function RoomSearchCheck( parts , parts2 )
{
	// 建物名
	if( ! SpaceCheck( parts.search_build_name.value ) ) {
		alert("建物名はスペースのみの検索が出来ません。");
		parts.search_build_name.focus();
		return false;
	}
	
	// 建物所在地
	if( ! SpaceCheck( parts.search_address.value ) ) {
		alert("建物所在地はスペースのみの検索が出来ません。");
		parts.search_address.focus();
		return false;
	}
	
	return true;
}
/*==================================================
    全てのチェックボックスをチェック
==================================================*/
var count;
function fnCheckAll(){
	for(ff = 0; ff < document.forms.length; ++ff){    // このページ内のすべてのフォームを処理
		formp = document.forms[ff];
		if (formp.name == 'form_chk'){
			formp.chk.checked = document.getElementById("chkbox_all").checked;	//チェックボックスをON/OFFにする
		}
	}
}

/*==================================================
    表示のソート リンクでsubmitする
==================================================*/
function fn_submit_sort(psort_no){
	// hiddenにセット
	document.forms["sortform"].sort_no.value = psort_no;
	document.forms["sortform"].submit();
	return true;
}

/*==================================================
    表示件数 onchangeでsubmitする
==================================================*/
function fn_submit_pagenum(){
	var idx;
	// selectのインデックス
	idx = document.forms["getnumform"].page_getnum_sel.selectedIndex;
	// selectのvalueをhiddenにセット
	document.forms["getnumform"].page_getnum.value = document.forms["getnumform"].page_getnum_sel.options[idx].value;
	document.forms["getnumform"].submit();
	return true;
}

/*==================================================
    一括更新 checkの付いているID,upd_date一覧をカンマ区切りで作成
==================================================*/
function fn_submit_all(){
	var strID;
	var strDate;
	var cnt;
	strID = "";
	strDate = "";
	cnt = 0;
	// このページ内のすべてのフォームを処理
	for(ff = 0; ff < document.forms.length; ++ff){    
		formp = document.forms[ff];
		if (formp.name == 'form_chk'){
			// チェックされてたら
			if (formp.chk.checked){
				// カンマ区切り
				if (strID != "") strID = strID + ",";
				if (strDate != "") strDate = strDate + ",";
				// valueを取得 ID upddate
				strID = strID + formp.cho_room_id.value;
				strDate = strDate + formp.cho_room_upd_date.value;
				cnt = cnt + 1;
			}
		}
	}
	if (cnt <= 0){
		alert("一括更新するレコードが選択されていません。");
		return false;
	}
	result = confirm('一括更新を行ってよろしいですか？');
	if (result){
		// valueをhiddenにセット
		document.forms["edit_all"].chk_arr_id.value = strID;
		document.forms["edit_all"].chk_arr_date.value = strDate;
		document.forms["edit_all"].submit();
		return true;
	} else {
		return false;
	}
}