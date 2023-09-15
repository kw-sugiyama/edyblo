/*==================================================
    カテゴリー情報登録／修正入力チェック
==================================================*/
function CategoryInputCheck( parts , parts2 )
{
	
	if( ! parts.elements["cg_stat"][0].checked && ! parts.elements["cg_stat"][1].checked ){
		alert("状態を指定して下さい。");
		parts.elements["cg_stat"][0].focus();
		return false;
	}
	
	if( parts.cg_stitle.value == "" ){
		alert("カテゴリー名を入力して下さい");
		parts.cg_stitle.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cg_stitle.value ) ) {
			alert("カテゴリー名はスペースのみの登録ができません。");
			parts.cg_stitle.focus();
			return false;
		}
                if( ! StrCountCheck( parts.cg_stitle.value,12 ) ) {
                        alert("カテゴリー名は12文字以内で入力してください。");
                        parts.cg_stitle.focus();
                        return false;
                }
	}

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


	top_flg = document.disp_set.cg_topflg.value;
	var array2 = top_flg.split("/");
	var flg = true;

	for(i=0;i<cnt;i++){
		disp_no = document.getElementById("editForm"+i).cg_dispno.value;
		if(i != 0 && array2[i] == 1)total_disp_no = total_disp_no + "/";
		if(i == 0 && array2[i] == 1)total_disp_no = disp_no;
		if(i != 0 && array2[i] == 1)total_disp_no = total_disp_no + disp_no;
	}
	var array1 = total_disp_no.split("/");
	for (var i = 0; i < array1.length && flg; i++) {
		for (var j = 0; j < array1.length; j++) {
			if( array1[j] == "" ){
				alert("表示順を入力して下さい");
				document.getElementById("editForm"+j).cg_dispno.focus();
				return false;
			}
			txtCnt = array1[j];
			retCnt = txtCnt.match(/^[0-9]+$/);
			if ( ! retCnt ) {
				alert("表示順は半角数字のみで入力して下さい。");
				document.getElementById("editForm"+j).cg_dispno.focus();
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
		document.disp_set.cg_dispno.value = total_disp_no;
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
		parts.cg_ltitle.disabled = false;
	} else if ( flg == 9 ) {
		// 使用不可
		parts.cg_ltitle.value = '';
		parts.cg_ltitle.disabled = true;
	}
	
}

