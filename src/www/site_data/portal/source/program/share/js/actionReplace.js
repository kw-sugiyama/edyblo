/*------------------------------------------
	フォームのアクション書換関数
------------------------------------------*/
function actnRplc(fname,link,parts){
	document.forms[fname].action = link;
	document.forms[fname].submit(parts);
}

/*------------------------------------------
	フォームのvalue書換関数
------------------------------------------*/
function actnRplcHidden(idname,nm,val){
	document.getElementById(idname).name = nm;
	document.getElementById(idname).value = val;
}