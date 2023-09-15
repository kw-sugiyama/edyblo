/*==================================================
    ブログ基本情報登録／修正入力チェック
==================================================*/
function BuildInputCheck( parts , parts2 )
{
	
	// 建物名称(管理用)
	if( parts.build_name.value == "" ){
		alert("建物名を入力して下さい。");
		parts.build_name.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.build_name.value ) ) {
			alert("建物名はスペースのみの登録が出来ません。");
			parts.build_name.focus();
			return false;
		}
	}
	
	// 建物名称(表示用)
	if( parts.build_name_disp.value == "" ){
		alert("建物名称を入力して下さい。");
		parts.build_name_disp.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.build_name_disp.value ) ) {
			alert("建物名称はスペースのみの登録が出来ません。");
			parts.build_name_disp.focus();
			return false;
		}
	}

	// 物件住所(表示用)
	if( parts.build_zip1.value == "" || parts.build_zip2.value == "" || parts.build_pref.value == "" || parts.build_address1.value == ""){
		alert("物件住所を入力して下さい。");
		parts.build_zip1.focus();
		return false;
	}
	if( ! IntValCheck( parts.build_zip1.value ) ) {
		alert("郵便番号は半角数字のみで入力して下さい。");
		parts.build_zip1.focus();
		return false;
	}
	if( ! IntValCheck( parts.build_zip2.value ) ) {
		alert("郵便番号は半角数字のみで入力して下さい。");
		parts.build_zip2.focus();
		return false;
	}
	if( parts.build_address2.value == "" ){
		alert("番地を入力して下さい。");
		parts.build_address2.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.build_address2.value ) ) {
			alert("番地はスペースのみの登録が出来ません。");
			parts.build_address2.focus();
			return false;
		}
	}

	// 最寄駅1
	if( parts.build_line_name_1.value == "" || parts.build_sta_name_1.value == "" ){
		alert("沿線・駅を設定して下さい。");
		parts.line_setting1.focus();
		return false;
	}
	if( parts.build_move_1.value == "" ){
		alert("移動時間を入力して下さい。");
		parts.build_move_1.focus();
		return false;
	}else if( ! IntValCheck( parts.build_move_1.value ) ) {
		alert("移動時間は半角数字のみで入力して下さい。");
		parts.build_move_1.focus();
		return false;
	}
	if( parts.build_move_bus_1.value != "" ) {
		if ( ! IntValCheck( parts.build_move_bus_1.value ) ) {
			alert("バスでの移動時間は半角数字のみで入力して下さい。");
			parts.build_move_bus_1.focus();
			return false;
		}
	}
	
	// 最寄駅2
	if( parts.build_line_name_2.value != "" && parts.build_sta_name_2.value != "" ){
		if( parts.build_move_2.value == "" ){
			alert("移動時間を入力して下さい。");
			parts.build_move_2.focus();
			return false;
		}
		if( ! IntValCheck( parts.build_move_2.value ) ){
			alert("移動時間は半角数字のみで入力して下さい。");
			parts.build_move_2.focus();
			return false;
		}
		if( parts.build_move_bus_2.value != "" ) {
			if ( ! IntValCheck( parts.build_move_bus_2.value ) ) {
				alert("バスでの移動時間は半角数字のみで入力して下さい。");
				parts.build_move_bus_2.focus();
				return false;
			}
		}
	}
	
	// 築年月
	if( parts.build_date_year.value == "" ){
		alert("築年月を入力して下さい。");
		parts.build_date_year.focus();
		return false;
	}else{
		if( ! IntValCheck( parts.build_date_year.value ) ) {
			alert("築年月は半角数字のみで入力して下さい。");
			parts.build_date_year.focus();
			return false;
		}
		if( ! StrCountCheck_Equal( parts.build_date_year.value , 4 ) ){
			alert("築年月(年)は西暦で入力して下さい。");
			parts.build_date_year.focus();
			return false;
		}
	}
	if( parts.build_date_month.value == "" ){
		alert("築年月を入力して下さい。");
		parts.build_date_month.focus();
		return false;
	}else if( ! IntValCheck( parts.build_date_month.value ) ) {
		alert("築年月は半角数字のみで入力して下さい。");
		parts.build_date_month.focus();
		return false;
	}
	
	// 建築構造
	if( parts.build_material.value == "" ){
		alert("建築構造を入力して下さい。");
		parts.build_material.focus();
		return false;
	}
	
	// 総階数
	if( parts.build_all_floor.value == "" ){
		alert("総階数を入力して下さい。");
		parts.build_all_floor.focus();
		return false;
	}else if( ! IntValCheck( parts.build_all_floor.value ) ) {
		alert("総階数は半角数字のみで入力して下さい。");
		parts.build_all_floor.focus();
		return false;
	}
	
	// 建物タイプ
	if( parts.build_type.value == "" ){
		alert("建物タイプを指定して下さい。");
		parts.build_type.focus();
		return false;
	}
	
	// 外観画像
	if ( parts.build_photo_lastupd.value == "" && parts.build_photo.value == "" ){
		alert("外観画像を設定して下さい。");
		parts.build_photo.focus();
		return false;
	}
	
	// 地図情報
	if ( parts.mkr_flg.value == ""){
		alert("地図情報を設定して下さい。");
		parts.onMarker.focus();
		return false;
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
    建物情報削除確認
==================================================*/
function BuildDeleteCheck( parts , parts2 )
{
	ret_com = confirm("削除します。よろしいですか？");
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
    住所検索
==================================================*/
function zipSearch(){
	build_zip = document.build.build_zip1.value + "-" + document.build.build_zip2.value;
	window.open('../zip_search.php?fn=build&zip='+build_zip+'&pc=build_pref_cd&ad1=build_pref&adc=build_addr_cd&ad2=build_address1&ad3=build_address2','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    駅設定画面を開く
==================================================*/
function OpenPageSta( line , station , ln_cd , st_cd , st_cd_name )
{
	window.open( '../station_select.php?fn=build&fg=0&line='+line+'&station='+station+'&ln_cd='+ln_cd+'&st_cd='+st_cd+'&ln_cd_name='+st_cd_name , 'station' , 'directories=no,location=no,menubar=no,toolbar=no,scrollbars=yes,width=340,height=500,left=0,top=0' );
}


/*==================================================
    沿線設定画面を開く
==================================================*/
function OpenPageLine( line , station , ln_cd , st_cd , st_cd_name )
{
	window.open( '../line_select.php?fn=build&fg=0&line='+line+'&station='+station+'&ln_cd='+ln_cd+'&st_cd='+st_cd+'&ln_cd_name='+st_cd_name , 'station' , 'directories=no,location=no,menubar=no,toolbar=no,scrollbars=yes,width=340,height=500,left=0,top=0' );
}


/*==================================================
    市区町村設定画面を開く
==================================================*/
function OpenPageArea( line , station , ln_cd , st_cd , st_cd_name )
{
	window.open( '../area_select.php?fn=build&fg=0&line='+line+'&station='+station+'&ln_cd='+ln_cd+'&st_cd='+st_cd+'&ln_cd_name='+st_cd_name , 'station' , 'directories=no,location=no,menubar=no,toolbar=no,scrollbars=yes,width=340,height=500,left=0,top=0' );
}


/*==================================================
    リストリセット
==================================================*/
function ListReset( cd , txtAr )
{
	document.getElementById(cd).value = "";
	document.getElementById(txtAr).value = "";

}
