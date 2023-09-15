/*==================================================
    沿線駅設定時リロード設定
==================================================*/
function PageReload( parts , pat_flg )
{
	
	strFName = parts.fname.value;
	strLnName = parts.line.value;
	strStName = parts.station.value;
	strLnCd = parts.ln_cd.value;
	strLnCdName = parts.ln_cd_name.value;
	strStCd = parts.st_cd.value;
	
	switch ( pat_flg ) {
		case 1:
			// エリア設定 ==> 都道府県設定
			strLineArea = parts.line_area.value;
			parts.action = "station_select.php?fn="+strFName+"&line="+strLnName+"&station="+strStName+"&ln_cd="+strLnCd+"&st_cd="+strStCd+"&ln_cd_name="+strLnCdName+"&fg=1&la="+strLineArea;
			parts.target = "_self";
			break;
			
		case 2:
			// 都道府県設定 ==> 沿線設定
			strLineArea = parts.line_area.value;
			strPrefCd = parts.line_pref.value;
			parts.action = "station_select.php?fn="+strFName+"&line="+strLnName+"&station="+strStName+"&ln_cd="+strLnCd+"&st_cd="+strStCd+"&ln_cd_name="+strLnCdName+"&fg=2&la="+strLineArea+"&lp="+strPrefCd;
			parts.target = "_self";
			break;
			
		case 3:
			// 沿線設定 ==> 駅設定
			strLineArea = parts.line_area.value;
			strPrefCd = parts.line_pref.value;
			strLineCd = parts.line_name.value;
			parts.action = "station_select.php?fn="+strFName+"&line="+strLnName+"&station="+strStName+"&ln_cd="+strLnCd+"&st_cd="+strStCd+"&ln_cd_name="+strLnCdName+"&fg=3&la="+strLineArea+"&lp="+strPrefCd+"&lc="+strLineCd;
			parts.target = "_self";
			break;
		case 4:
			// 駅設定 ==> 該当沿線表示
			strLineArea = parts.line_area.value;
			strPrefCd = parts.line_pref.value;
			strLineCd = parts.line_name.value;
			strStaCd = parts.station_name.value;
			parts.action = "station_select.php?fn="+strFName+"&line="+strLnName+"&station="+strStName+"&ln_cd="+strLnCd+"&st_cd="+strStCd+"&ln_cd_name="+strLnCdName+"&fg=4&la="+strLineArea+"&lp="+strPrefCd+"&lc="+strLineCd+"&lsc="+strStaCd;
			parts.target = "_self";
			break;
		default:
			alert("エラーが発生しました。");
			return false;
	}
	
	parts.submit();
	
	return true;
	
}


