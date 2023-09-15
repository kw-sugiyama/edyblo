/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function RoomInputCheck( parts , parts2 )
{
	
	// 部屋番号
	if( parts.room_code.value == "" ){
		alert("部屋番号を入力して下さい。");
		parts.room_code.focus();
		return false;
	} else if( ! SpaceCheck( parts.room_code.value ) ) {
		alert("部屋番号はスペースのみの登録が出来ません。");
		parts.room_code.focus();
		return false;
	}

	//間取り
	if ( parts.room_madori.value == "" ) {
		alert("間取りを選択して下さい。");
		parts.room_madori.focus();
		return false;
	}

	//間取り詳細
	if( parts.room_madori_detail.value == "" ){
		alert("間取り詳細を入力して下さい。");
		parts.room_madori_detail.focus();
		return false;
	} else if( ! SpaceCheck( parts.room_madori_detail.value ) ) {
		alert("間取り詳細はスペースのみの登録が出来ません。");
		parts.room_madori_detail.focus();
		return false;
	}

	//賃料
	if( parts.room_price.value == "" ){
		alert("賃料を入力して下さい。");
		parts.room_price.focus();
		return false;
	}else if(!IntValCheck( parts.room_price.value ) && parts.room_price.value != "-" && parts.room_price.value != "−"){
		alert("賃料は半角数字及びハイフンで入力してください。");
		parts.room_price.focus();
		return false;
	}

	//管理料
	ret_cntrl_price = parts.room_cntrl_price.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_cntrl_price.value == "" ){
		alert("管理料を入力して下さい。");
		parts.room_cntrl_price.focus();
		return false;
	}else if( !ret_cntrl_price && !IntValCheck( parts.room_cntrl_price.value ) && parts.room_cntrl_price.value != "-" && parts.room_cntrl_price.value != "−"){
		alert("管理料は半角数字及びハイフンで入力してください。");
		parts.room_cntrl_price.focus();
		return false;
	}

	//敷金
	ret_siki = parts.room_siki.value.match(/^[0-9]+\.[0-9]+$/);
	if ( parts.room_siki.value == "" ) {
		alert("敷金を選択して下さい。");
		parts.room_siki.focus();
		return false;
	} else if ( !ret_siki && !IntValCheck( parts.room_siki.value ) && parts.room_siki.value != "-" && parts.room_siki.value != "−" ) {
		alert("敷金は半角整数・少数及びハイフンで入力してください。");
		parts.room_siki.focus();
		return false;
	}

	//礼金
	ret_rei = parts.room_rei.value.match(/^[0-9]+\.[0-9]+$/);
	if ( parts.room_rei.value == "" ) {
		alert("礼金を選択して下さい。");
		parts.room_rei.focus();
		return false;
	} else if ( !ret_rei && !IntValCheck( parts.room_rei.value ) && parts.room_rei.value != "-" && parts.room_rei.value != "−" ) {
		alert("礼金は半角整数・少数及びハイフンで入力してください。");
		parts.room_rei.focus();
		return false;
	}

	//償却
	ret_syou = parts.room_syou.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_syou.value != "" ){
		if( !ret_syou && !IntValCheck( parts.room_syou.value ) && parts.room_syou.value != "-" && parts.room_syou.value != "−"){
			alert("償却は半角数字及びハイフンで入力してください。");
			parts.room_syou.focus();
			return false;
		}
	}

	//敷引
	ret_sikibiki = parts.room_sikibiki.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_sikibiki.value != "" ){
		if( !ret_sikibiki && !IntValCheck( parts.room_sikibiki.value ) && parts.room_sikibiki.value != "-" && parts.room_sikibiki.value != "−"){
			alert("敷引は半角数字及びハイフンで入力してください。");
			parts.room_sikibiki.focus();
			return false;
		}
	}

	//保証金
	ret_sec_price = parts.room_sec_price.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_sec_price.value != "" ){
		if( !ret_sec_price && !IntValCheck( parts.room_sec_price.value ) && parts.room_sec_price.value != "-" && parts.room_sec_price.value != "−"){
			alert("保証金は半角数字及びハイフンで入力してください。");
			parts.room_sec_price.focus();
			return false;
		}
	}

	//契約年
	if( parts.room_contract.value == "" ){
		alert("契約年を入力して下さい。");
		parts.room_contract.focus();
		return false;
	}

	//更新料
	ret_upd_price = parts.room_upd_price.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_upd_price.value == "" ){
		alert("更新料を入力して下さい。");
		parts.room_upd_price.focus();
		return false;
	}else if( !ret_upd_price && !IntValCheck( parts.room_upd_price.value ) && parts.room_upd_price.value != "-" && parts.room_upd_price.value != "−"){
		alert("更新料は半角数字及びハイフンで入力してください。");
		parts.room_upd_price.focus();
		return false;
	}

	//更新年数
	if( parts.room_upd_year.value == "" ){
		alert("更新年数を入力して下さい。");
		parts.room_upd_year.focus();
		return false;
	} else if( !IntValCheck( parts.room_upd_year.value ) ) {
		alert("更新年数は半角数字で入力してください。");
		parts.room_upd_year.focus();
		return false;
	}

	//専有面積
	ret_area = parts.room_area.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_area.value == "" ){
		alert("専有面積を入力して下さい。");
		parts.room_area.focus();
		return false;
	} else if ( !ret_area && !IntValCheck( parts.room_area.value ) ) {
		alert("専有面積は半角整数、または半角少数で入力してください。");
		parts.room_area.focus();
		return false;
	}

	//所在階
	if( parts.room_floor.value == "" ){
		alert("所在階を入力して下さい。");
		parts.room_floor.focus();
		return false;
	}

	//向き
	if ( parts.room_face.value == "" ) {
		alert("向きを選択して下さい。");
		parts.room_face.focus();
		return false;
	}

	// 外観画像
	if ( parts.room_layout_lastupd.value == "" && parts.room_layout_img.value == "" && parts.error_flg.value == "" ){
		alert("外観画像を設定して下さい。");
		parts.room_layout_img.focus();
		return false;
	}

	// 設備情報(その他)
	if ( document.getElementById("other").checked && parts.room_equip_other.value == "" ){
		alert("設備情報(その他)を入力して下さい。");
		parts.room_equip_other.focus();
		return false;
	}

	
	// 物件空き状況
	intChk_bd = 9;
	intCnt_bd = parts.elements["room_vacant"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["room_vacant"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("物件空き状況を指定して下さい。");
		parts.elements["room_vacant"][0].focus();
		return false;
	}
	
	// 即入居
	intChk_bd = 9;
	intCnt_bd = parts.elements["room_now_move"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["room_now_move"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("即入居可を指定して下さい。");
		parts.elements["room_now_move"][0].focus();
		return false;
	}

	// 入居予定日
	if ( parts.elements["room_now_move"][1].checked && parts.room_move_date.value == "" ){
		alert("入居予定日を入力して下さい。");
		parts.room_move_date.focus();
		return false;
	}

	//取引形態
	if ( parts.room_trade.value == "" ) {
		alert("取引形態を選択して下さい。");
		parts.room_trade.focus();
		return false;
	}

	// 部屋PR文章
	if( parts.room_pr.value == "" ){
		alert("部屋PR文章を入力して下さい。");
		parts.room_pr.focus();
		return false;
	}else{
		if( ! SpaceCheck( parts.room_pr.value ) ) {
			alert("部屋PR文章はスペースのみの登録が出来ません。");
			parts.room_pr.focus();
			return false;
		}
		if( StrCountCheck( parts.room_pr.value , 20 ) ){
			alert("部屋PR文章は20文字以上で入力して下さい");
			parts.room_pr.focus();
			return false;
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
    削除処理確認
==================================================*/
function RoomDeleteCheck( parts , parts2 )
{
	ret_com = confirm("削除します。よろしいですか？");
	if ( !ret_com ){
		return false;
	}
	
	parts.submit();
	return true;
}


/*==================================================
    指定データコピー処理確認
==================================================*/
function RoomCopyCheck( parts )
{
	ret_com = confirm("指定された部屋情報を複製します。よろしいですか？");
	if ( !ret_com ){
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


/*==================================================
    Disabled
==================================================*/
function selectOther(){
	if(document.getElementById("other").checked){
		document.room.room_equip_other.disabled=false;
	}
	if(!document.getElementById("other").checked){
		document.room.room_equip_other.value="";
		document.room.room_equip_other.disabled=true;
	}
}


