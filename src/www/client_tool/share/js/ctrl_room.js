/*==================================================
    ���� ���ϥ����å�
==================================================*/
function RoomSearchCheck( parts , parts2 )
{
	// ��ʪ̾
	if( ! SpaceCheck( parts.search_build_name.value ) ) {
		alert("��ʪ̾�ϥ��ڡ����Τߤθ���������ޤ���");
		parts.search_build_name.focus();
		return false;
	}
	
	// ��ʪ�����
	if( ! SpaceCheck( parts.search_address.value ) ) {
		alert("��ʪ����Ϥϥ��ڡ����Τߤθ���������ޤ���");
		parts.search_address.focus();
		return false;
	}
	
	return true;
}
/*==================================================
    ���ƤΥ����å��ܥå���������å�
==================================================*/
var count;
function fnCheckAll(){
	for(ff = 0; ff < document.forms.length; ++ff){    // ���Υڡ�����Τ��٤ƤΥե���������
		formp = document.forms[ff];
		if (formp.name == 'form_chk'){
			formp.chk.checked = document.getElementById("chkbox_all").checked;	//�����å��ܥå�����ON/OFF�ˤ���
		}
	}
}

/*==================================================
    ɽ���Υ����� ��󥯤�submit����
==================================================*/
function fn_submit_sort(psort_no){
	// hidden�˥��å�
	document.forms["sortform"].sort_no.value = psort_no;
	document.forms["sortform"].submit();
	return true;
}

/*==================================================
    ɽ����� onchange��submit����
==================================================*/
function fn_submit_pagenum(){
	var idx;
	// select�Υ���ǥå���
	idx = document.forms["getnumform"].page_getnum_sel.selectedIndex;
	// select��value��hidden�˥��å�
	document.forms["getnumform"].page_getnum.value = document.forms["getnumform"].page_getnum_sel.options[idx].value;
	document.forms["getnumform"].submit();
	return true;
}

/*==================================================
    ��繹�� check���դ��Ƥ���ID,upd_date�����򥫥�޶��ڤ�Ǻ���
==================================================*/
function fn_submit_all(){
	var strID;
	var strDate;
	var cnt;
	strID = "";
	strDate = "";
	cnt = 0;
	// ���Υڡ�����Τ��٤ƤΥե���������
	for(ff = 0; ff < document.forms.length; ++ff){    
		formp = document.forms[ff];
		if (formp.name == 'form_chk'){
			// �����å�����Ƥ���
			if (formp.chk.checked){
				// ����޶��ڤ�
				if (strID != "") strID = strID + ",";
				if (strDate != "") strDate = strDate + ",";
				// value����� ID upddate
				strID = strID + formp.cho_room_id.value;
				strDate = strDate + formp.cho_room_upd_date.value;
				cnt = cnt + 1;
			}
		}
	}
	if (cnt <= 0){
		alert("��繹������쥳���ɤ����򤵤�Ƥ��ޤ���");
		return false;
	}
	result = confirm('��繹����ԤäƤ�����Ǥ�����');
	if (result){
		// value��hidden�˥��å�
		document.forms["edit_all"].chk_arr_id.value = strID;
		document.forms["edit_all"].chk_arr_date.value = strDate;
		document.forms["edit_all"].submit();
		return true;
	} else {
		return false;
	}
}