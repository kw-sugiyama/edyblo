/*==================================================
    ���ƥ��꡼������Ͽ���������ϥ����å�
==================================================*/
function CategoryInputCheck( parts , parts2 )
{
	
	if( ! parts.elements["cg_stat"][0].checked && ! parts.elements["cg_stat"][1].checked ){
		alert("���֤���ꤷ�Ʋ�������");
		parts.elements["cg_stat"][0].focus();
		return false;
	}
	
	if( parts.cg_stitle.value == "" ){
		alert("���ƥ��꡼̾�����Ϥ��Ʋ�����");
		parts.cg_stitle.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cg_stitle.value ) ) {
			alert("���ƥ��꡼̾�ϥ��ڡ����Τߤ���Ͽ���Ǥ��ޤ���");
			parts.cg_stitle.focus();
			return false;
		}
                if( ! StrCountCheck( parts.cg_stitle.value,12 ) ) {
                        alert("���ƥ��꡼̾��12ʸ����������Ϥ��Ƥ���������");
                        parts.cg_stitle.focus();
                        return false;
                }
	}

	ret_com = confirm("��Ͽ���������ޤ���������Ǥ�����");
	if( !ret_com ){
		return false;
	}
	
	parts2.submit();
	return true;
	
}


/*==================================================
    �ե������������طʿ����Ѥ���
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
    ɽ����ȿ��
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
				alert("ɽ��������Ϥ��Ʋ�����");
				document.getElementById("editForm"+j).cg_dispno.focus();
				return false;
			}
			txtCnt = array1[j];
			retCnt = txtCnt.match(/^[0-9]+$/);
			if ( ! retCnt ) {
				alert("ɽ�����Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
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
		ret_com = confirm("ɽ�����ȿ�Ǥ��ޤ���������Ǥ�����");
		if( !ret_com ){
			return false;
		}
		document.disp_set.cg_dispno.value = total_disp_no;
		return true;
	} else {
		alert("ɽ���礬��ʣ���Ƥ��ޤ���");
		return false;
	}

}


/*====================================================
  �ԣϣ�ɽ�����Ƥ���Ѳ�ǽ���Բ�ǽ�ڤ��ؤ�
====================================================*/
function CateChangeUse( parts , flg )
{
	
	if ( flg == 1 ) {
		// ���Ѳ�ǽ
		parts.cg_ltitle.disabled = false;
	} else if ( flg == 9 ) {
		// �����Բ�
		parts.cg_ltitle.value = '';
		parts.cg_ltitle.disabled = true;
	}
	
}

