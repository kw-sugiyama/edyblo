/*==============================================================
    ������̰����ǥ����å����줿ʪ�����Ͽ
	���� : intCnt ... �ե��������ο�
		�������Ǥϡ�check_room_���פ����
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
		alert("ʪ�郎���򤵤�Ƥ���ޤ���");
		return false;
	} else {
		parts.rid.value = strChkRoomId;
		parts.submit();
		return true;
	}
}
