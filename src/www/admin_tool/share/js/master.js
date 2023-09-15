/*==================================================
    郵便番号マスタ - 処理確認
==================================================*/
function ZipChangeCheck( parts , flg )
{
	
	switch ( flg ) {
		case 1:
			// 郵便番号マスタ登録
			if ( parts.zip_master.value == "" ){
				alert("UPするファイルを選択して下さい");
				parts.zip_master.focus();
				return false;
			}
			ret_com = confirm("郵便番号マスタを登録します。よろしいですか？");
			if( !ret_com ){
				return false;
			}
			parts.action = "master_zip_upd.php";
			break;
		case 2:
			// 郵便番号マスタ削除
			ret_com = confirm("郵便番号マスタを削除します。よろしいですか？");
			if( !ret_com ){
				return false;
			}
			parts.action = "master_zip_del.php";
			break;
		default:
			alert("システムエラーが発生しました。");
			return false;
	}
	
	parts.submit();
	
	return true;
	
}


/*==================================================
    沿線駅マスタ - 処理確認
==================================================*/
function LineChangeCheck( parts , flg )
{
	
	switch ( flg ) {
		case 1:
			// 沿線駅マスタ登録
			if ( parts.line_master.value == "" ){
				alert("UPするファイルを選択して下さい");
				parts.line_master.focus();
				return false;
			}
			ret_com = confirm("沿線駅マスタを登録します。よろしいですか？");
			if( !ret_com ){
				return false;
			}
			parts.action = "master_line_upd.php";
			break;
		case 2:
			// 沿線駅マスタ削除
			ret_com = confirm("沿線駅マスタを削除します。よろしいですか？");
			if( !ret_com ){
				return false;
			}
			parts.action = "master_line_del.php";
			break;
		default:
			alert("システムエラーが発生しました。");
			return false;
	}
	
	parts.submit();
	
	return true;
	
}
