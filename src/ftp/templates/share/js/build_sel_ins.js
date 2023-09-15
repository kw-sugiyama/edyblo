/*==============================================================
    検索結果一覧でチェックされた物件を登録
	引数 : intCnt ... フォーム全体数
		※ここでは「check_room_○」を使用
==============================================================*/
function build_select_insert( parts , intCnt )
{
	
	var strChkRoomId = "";
	var ix = 0;
	
	for ( ix=0; ix<intCnt; ix++ ) {
		
		var strChkRoom = "";
		strChkRoomName = "chk_room_"+ix
		if ( document.getElementById(strChkRoomName).checked ) {
			if ( strChkRoomId == "" ) strChkRoomId = "/";
			strChkRoomId = strChkRoomId+document.getElementById(strChkRoomName).value+"/";
		}
		
	}
	
	if ( strChkRoomId == "" ) {
		alert("物件が選択されておりません。");
		return false;
	} else {
		parts.rid.value = strChkRoomId;
		parts.submit();
		return true;
	}
}
