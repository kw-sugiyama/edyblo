/*==================================================
    カテゴリー情報登録／修正入力チェック
==================================================*/
function CltpbaseInputCheck( parts , parts2 )
{
	
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
    表示順反映
==================================================*/
function dispSet(cnt){


	top_flg = document.disp_set.cltpbase_top_flg.value;
	var array2 = top_flg.split("/");
	var flg = true;

	for(i=0;i<cnt;i++){
		disp_no = document.getElementById("editForm"+i).cltpbase_disp_no.value;
		if(i != 0 && array2[i] == 1)total_disp_no = total_disp_no + "/";
		if(i == 0 && array2[i] == 1)total_disp_no = disp_no;
		if(i != 0 && array2[i] == 1)total_disp_no = total_disp_no + disp_no;
	}
	var array1 = total_disp_no.split("/");
	for (var i = 0; i < array1.length && flg; i++) {
		for (var j = 0; j < array1.length; j++) {
			if( array1[j] == "" ){
				alert("表示順を入力して下さい");
				document.getElementById("editForm"+j).cltpbase_disp_no.focus();
				return false;
			}
			txtCnt = array1[j];
			retCnt = txtCnt.match(/^[0-9]+$/);
			if ( ! retCnt ) {
				alert("表示順は半角数字のみで入力して下さい。");
				document.getElementById("editForm"+j).cltpbase_disp_no.focus();
				return false;
			}
			if (i != j && array1[i] == array1[j]) {
				flg = false;
				break;
			}
		}
	}

	if (flg) {
		ret_com = confirm("表示順を反映します。よろしいですか？");
		if( !ret_com ){
			return false;
		}
		document.disp_set.cltpbase_disp_no.value = total_disp_no;
		return true;
	} else {
		alert("表示順が重複しています。");
		return false;
	}

}


/*====================================================
  ＴＯＰ表示内容を使用可能／不可能切り替え
====================================================*/
function CateChangeUse( parts , flg )
{
	
	if ( flg == 1 ) {
		// 使用可能
		parts.cltpbase_top_name.disabled = false;
	} else if ( flg == 9 ) {
		// 使用不可
		parts.cltpbase_top_name.value = '';
		parts.cltpbase_top_name.disabled = true;
	}
	
}


/*====================================================
  テキストエリア文字数制限
====================================================*/
function restChar() {
	n = document.admin.cltpbase_discription.value.length;
	if(n > 150) alert("カテゴリー説明文は150字以内です");
}