/*------------------------------------------
	�t�H�[���̃A�N�V���������֐�
------------------------------------------*/
function actnRplc(fname,link,parts){
	document.forms[fname].action = link;
	document.forms[fname].submit(parts);
}

/*------------------------------------------
	�t�H�[����value�����֐�
------------------------------------------*/
function actnRplcHidden(idname,nm,val){
	document.getElementById(idname).name = nm;
	document.getElementById(idname).value = val;
}