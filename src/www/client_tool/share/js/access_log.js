/*==================================================
    アクセス解析 - 日付指定チェック
==================================================*/
function AccessSelCheck( parts )
{
	
	// 日付指定(年)
	if( parts.sea_date_y.value == "" ){
		alert("アクセス解析を行う日付(年)を指定して下さい");
		parts.sea_date_y.focus();
		return false;
	}
	
	// 日付指定(月)
	if( parts.sea_date_m.value == "" ){
		alert("アクセス解析を行う日付(月)を指定して下さい");
		parts.sea_date_m.focus();
		return false;
	}
	
	// 日付指定(日)
	if( parts.sea_date_d.value == "" ){
		alert("アクセス解析を行う日付(日)を指定して下さい");
		parts.sea_date_d.focus();
		return false;
	}
	
	// 日付整合性チェック
	var strDate = parts.sea_date_y.value+'-'+parts.sea_date_m.value+'-'+parts.sea_date_d.value;
	if ( ! DateCheck_1( strDate ) ) {
		alert("指定された日付は有効ではありません。");
		parts.sea_date_y.focus();
		return false;
	}
	
	parts.submit();
	
	return true;
	
}


