/*==================================================
    ���饤����Ⱦ�����Ͽ���������ϥ����å�
==================================================*/
function ClientInputCheck( parts , parts2 )
{
	// ���̾
	if( parts.cl_jname.value == "" ){
		alert("���̾�����Ϥ��Ʋ�����");
		parts.cl_jname.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cl_jname.value ) ) {
			alert("���̾�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_jname.focus();
			return false;
		}
	}
	
	// ��Ź̾
	if( parts.cl_kname.value != "" ){
		if( ! SpaceCheck( parts.cl_kname.value ) ) {
			alert("��Ź̾�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_kname.focus();
			return false;
		}
	}
	
	// ô����̾
	if( parts.cl_agent.value != "" ){
		if( ! SpaceCheck( parts.cl_agent.value ) ) {
			alert("ô����̾�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_agent.focus();
			return false;
		}
	}
	
	// ��ҽ���
	if( parts.ar_zip1.value == "" ){
		alert("͹���ֹ�����򤷤Ʋ�������");
		parts.ar_zip1.focus();
		return falsez;
	}
	if( parts.ar_zip2.value == "" ){
		alert("͹���ֹ�����򤷤Ʋ�������");
		parts.ar_zip2.focus();
		return false;
	}
	if( parts.ar_add.value == "" ){
		alert("���Ϥ����Ϥ��Ʋ�����");
		parts.ar_add.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ar_add.value ) ) {
			alert("���Ϥϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.ar_add.focus();
			return false;
		}
	}

	if( parts.ar_estate.value != "" ){
		if( ! SpaceCheck( parts.ar_estate.value ) ) {
			alert("��ʪ̾�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.ar_estate.focus();
			return false;
		}
	}
	
	// ��������ֹ�
	if( parts.cl_phone.value != "" ){
		if( ! SpaceCheck( parts.cl_phone.value ) ) {
			alert("��������ֹ�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_phone.focus();
			return false;
		}
		if( ! TellCheck_2( parts.cl_phone.value ) ) {
			alert("��������ֹ��'-'�դ�Ⱦ�ѿ��������Ϥ��Ʋ�������");
			parts.cl_phone.focus();
			return false;
		}
	}
	
	// ��ңƣ���
	if( parts.cl_fax.value != "" ){
		if( ! SpaceCheck( parts.cl_fax.value ) ) {
			alert("��ңƣ����ֹ�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_fax.focus();
			return false;
		}
		if( ! TellCheck_2( parts.cl_fax.value ) ) {
			alert("��ңƣ����ֹ��'-'�դ�Ⱦ�ѿ��������Ϥ��Ʋ�������");
			parts.cl_fax.focus();
			return false;
		}
	}
	
	// ô���ԣť᡼��
	if( parts.cl_mail.value == "" ){
		alert("ô���ԣť᡼�륢�ɥ쥹�����Ϥ��Ʋ�����");
		parts.cl_mail.focus();
		return false;
	} else {
		if( ! EmailCheck( parts.cl_mail.value ) ) {
			alert("ô���ԣť᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������");
			parts.cl_mail.focus();
			return false;
		}
	}
		
	// ������У��ӣ�
	if( parts.cl_passwd.value == "" ){
		alert("������ѥ���ɤ����Ϥ��Ʋ�����");
		parts.cl_passwd.focus();
		return false;
	}
	if( !LoginValCheck( parts.cl_passwd.value ) ){
		alert("������ѥ���ɤ�Ⱦ�ѱѿ����Τ�ͭ���Ǥ�");
		parts.cl_passwd.focus();
		return false;
	}
	ret_com = confirm("��Ͽ���������ޤ���������Ǥ�����");
	if( !ret_com ){
		return false;
	}
	
	parts2.submit();
	return true;
	
}


/*==================================================
    ���긡��
==================================================*/
function zipSearch(){
	ar_zip = document.addr_cd_1.value + "-" + document.addr_cd_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd&ad1=ar_pref&adc=ar_citycd&ad2=ar_city&ad3=ar_add','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}



/*==================================================
    ���긡��
==================================================*/
function zipSearch1(){
	ar_zip = document.client.addr_cd_1.value + "-" + document.client.addr_cd_2.value;
	window.open('zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd1&ad1=ar_pref1&adc=ar_citycd1&ad2=ar_city1&ad3=ar_add1','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}



/*==================================================
    ���긡��
==================================================*/
function zipSearch2(){
	ar_zip = document.client.ar_zip2_1.value + "-" + document.client.ar_zip2_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd2&ad1=ar_pref2&adc=ar_citycd2&ad2=ar_city2&ad3=ar_add2','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}



/*==================================================
    ���긡��
==================================================*/
function zipSearch3(){
	ar_zip = document.client.ar_zip3_1.value + "-" + document.client.ar_zip3_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd3&ad1=ar_pref3&adc=ar_citycd3&ad2=ar_city3&ad3=ar_add3','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
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
    ������׸���Ajax�ƽ���
==================================================*/
function sendDataAdd( form ){
  xmlHttpObject = null;  // �̿����֥�������
  if(window.XMLHttpRequest){  // safari,Firefox�ʤ�
    xmlHttpObject = new XMLHttpRequest();
  }else if(window.ActiveXObject) {  // IE
    try{
      xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP"); // IE6
    }catch(e){
      try{
        xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP"); // IE5
      }catch(e){
        return null;
      }
    }
  }
  // xmlHttpObject�������Ǥ����顢���֤��Ѥ�ä��ݤ˼¹Ԥ����ؿ�������
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    if(form.address_word.value!=null){ 
      nknm="?address_word="+encodeURI(form.address_word.value);
    }
    xmlHttpObject.open("GET","../mntAdd_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
==================================================*/
function wait(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    ��������Ajax�ƽ���
==================================================*/
function sendDataAdd2( form ){
  xmlHttpObject = null;  // �̿����֥�������
  if(window.XMLHttpRequest){  // safari,Firefox�ʤ�
    xmlHttpObject = new XMLHttpRequest();
  }else if(window.ActiveXObject) {  // IE
    try{
      xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP"); // IE6
    }catch(e){
      try{
        xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP"); // IE5
      }catch(e){
        return null;
      }
    }
  }
  // xmlHttpObject�������Ǥ����顢���֤��Ѥ�ä��ݤ˼¹Ԥ����ؿ�������
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait2;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var addListCnt = document.getElementById("address_list").options.length;
    for(i=0;i<addListCnt;i++){
      if(document.getElementById("address_list").options[i].selected){
        nknm="?address_select="+encodeURI(document.getElementById("address_list").options[i].value);
      }
    }
    xmlHttpObject.open("GET","../mntAddSelectCL_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
==================================================*/
function wait2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello2").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    ������׸���Ajax�ƽ���
==================================================*/
function sendDataAdd1_1( form ){
  xmlHttpObject = null;  // �̿����֥�������
  if(window.XMLHttpRequest){  // safari,Firefox�ʤ�
    xmlHttpObject = new XMLHttpRequest();
  }else if(window.ActiveXObject) {  // IE
    try{
      xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP"); // IE6
    }catch(e){
      try{
        xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP"); // IE5
      }catch(e){
        return null;
      }
    }
  }
  // xmlHttpObject�������Ǥ����顢���֤��Ѥ�ä��ݤ˼¹Ԥ����ؿ�������
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait1_1;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    if(form.address_word1.value!=null){ 
      nknm="?address_word="+encodeURI(form.address_word1.value);
    }
    xmlHttpObject.open("GET","../mntAdd_ajax1.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
==================================================*/
function wait1_1(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello1_1").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello1_1").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    ��������Ajax�ƽ���
==================================================*/
function sendDataAdd1_2( form ){
  xmlHttpObject = null;  // �̿����֥�������
  if(window.XMLHttpRequest){  // safari,Firefox�ʤ�
    xmlHttpObject = new XMLHttpRequest();
  }else if(window.ActiveXObject) {  // IE
    try{
      xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP"); // IE6
    }catch(e){
      try{
        xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP"); // IE5
      }catch(e){
        return null;
      }
    }
  }
  // xmlHttpObject�������Ǥ����顢���֤��Ѥ�ä��ݤ˼¹Ԥ����ؿ�������
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait1_2;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var addListCnt = document.getElementById("address_list1").options.length;
    for(i=0;i<addListCnt;i++){
      if(document.getElementById("address_list1").options[i].selected){
        nknm="?address_select="+encodeURI(document.getElementById("address_list1").options[i].value);
      }
    }
    xmlHttpObject.open("GET","../mntAddSelectCL_ajax1.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
==================================================*/
function wait1_2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello1_2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello1_2").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    ������׸���Ajax�ƽ���
==================================================*/
function sendDataAdd2_1( form ){
  xmlHttpObject = null;  // �̿����֥�������
  if(window.XMLHttpRequest){  // safari,Firefox�ʤ�
    xmlHttpObject = new XMLHttpRequest();
  }else if(window.ActiveXObject) {  // IE
    try{
      xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP"); // IE6
    }catch(e){
      try{
        xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP"); // IE5
      }catch(e){
        return null;
      }
    }
  }
  // xmlHttpObject�������Ǥ����顢���֤��Ѥ�ä��ݤ˼¹Ԥ����ؿ�������
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait2_1;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    if(form.address_word2.value!=null){ 
      nknm="?address_word="+encodeURI(form.address_word2.value);
    }
    xmlHttpObject.open("GET","../mntAdd_ajax2.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
==================================================*/
function wait2_1(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello2_1").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello2_1").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    ��������Ajax�ƽ���
==================================================*/
function sendDataAdd2_2( form ){
  xmlHttpObject = null;  // �̿����֥�������
  if(window.XMLHttpRequest){  // safari,Firefox�ʤ�
    xmlHttpObject = new XMLHttpRequest();
  }else if(window.ActiveXObject) {  // IE
    try{
      xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP"); // IE6
    }catch(e){
      try{
        xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP"); // IE5
      }catch(e){
        return null;
      }
    }
  }
  // xmlHttpObject�������Ǥ����顢���֤��Ѥ�ä��ݤ˼¹Ԥ����ؿ�������
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait2_2;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var addListCnt = document.getElementById("address_list2").options.length;
    for(i=0;i<addListCnt;i++){
      if(document.getElementById("address_list2").options[i].selected){
        nknm="?address_select="+encodeURI(document.getElementById("address_list2").options[i].value);
      }
    }
    xmlHttpObject.open("GET","../mntAddSelectCL_ajax2.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
==================================================*/
function wait2_2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello2_2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello2_2").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    ������׸���Ajax�ƽ���
==================================================*/
function sendDataAdd3_1( form ){
  xmlHttpObject = null;  // �̿����֥�������
  if(window.XMLHttpRequest){  // safari,Firefox�ʤ�
    xmlHttpObject = new XMLHttpRequest();
  }else if(window.ActiveXObject) {  // IE
    try{
      xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP"); // IE6
    }catch(e){
      try{
        xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP"); // IE5
      }catch(e){
        return null;
      }
    }
  }
  // xmlHttpObject�������Ǥ����顢���֤��Ѥ�ä��ݤ˼¹Ԥ����ؿ�������
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait3_1;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    if(form.address_word3.value!=null){ 
      nknm="?address_word="+encodeURI(form.address_word3.value);
    }
    xmlHttpObject.open("GET","../mntAdd_ajax3.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
==================================================*/
function wait3_1(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello3_1").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello3_1").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    ��������Ajax�ƽ���
==================================================*/
function sendDataAdd3_2( form ){
  xmlHttpObject = null;  // �̿����֥�������
  if(window.XMLHttpRequest){  // safari,Firefox�ʤ�
    xmlHttpObject = new XMLHttpRequest();
  }else if(window.ActiveXObject) {  // IE
    try{
      xmlHttpObject = new ActiveXObject("Msxml2.XMLHTTP"); // IE6
    }catch(e){
      try{
        xmlHttpObject = new ActiveXObject("Microsoft.XMLHTTP"); // IE5
      }catch(e){
        return null;
      }
    }
  }
  // xmlHttpObject�������Ǥ����顢���֤��Ѥ�ä��ݤ˼¹Ԥ����ؿ�������
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait3_2;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var addListCnt = document.getElementById("address_list3").options.length;
    for(i=0;i<addListCnt;i++){
      if(document.getElementById("address_list3").options[i].selected){
        nknm="?address_select="+encodeURI(document.getElementById("address_list3").options[i].value);
      }
    }
    xmlHttpObject.open("GET","../mntAddSelectCL_ajax3.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
==================================================*/
function wait3_2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello3_2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello3_2").innerHTML = "<b>Wait......</b>";
  }
}


