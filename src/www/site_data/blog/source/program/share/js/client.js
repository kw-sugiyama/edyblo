/*==================================================
    クライアント情報登録／修正入力チェック
==================================================*/
function ClientInputCheck( parts , parts2 )
{
	// 会社名
	if( parts.cl_jname.value == "" ){
		alert("会社名を入力して下さい");
		parts.cl_jname.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cl_jname.value ) ) {
			alert("会社名はスペースのみの登録はできません。");
			parts.cl_jname.focus();
			return false;
		}
	}
	
	// 支店名
	if( parts.cl_kname.value != "" ){
		if( ! SpaceCheck( parts.cl_kname.value ) ) {
			alert("支店名はスペースのみの登録はできません。");
			parts.cl_kname.focus();
			return false;
		}
	}
	
	// 担当者名
	if( parts.cl_agent.value != "" ){
		if( ! SpaceCheck( parts.cl_agent.value ) ) {
			alert("担当者名はスペースのみの登録はできません。");
			parts.cl_agent.focus();
			return false;
		}
	}
	
	// 会社住所
	if( parts.ar_zip1.value == "" ){
		alert("郵便番号を選択して下さい。");
		parts.ar_zip1.focus();
		return falsez;
	}
	if( parts.ar_zip2.value == "" ){
		alert("郵便番号を選択して下さい。");
		parts.ar_zip2.focus();
		return false;
	}
	if( parts.ar_add.value == "" ){
		alert("番地を入力して下さい");
		parts.ar_add.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ar_add.value ) ) {
			alert("番地はスペースのみの登録はできません。");
			parts.ar_add.focus();
			return false;
		}
	}

	if( parts.ar_estate.value != "" ){
		if( ! SpaceCheck( parts.ar_estate.value ) ) {
			alert("建物名はスペースのみの登録はできません。");
			parts.ar_estate.focus();
			return false;
		}
	}
	
	// 会社電話番号
	if( parts.cl_phone.value != "" ){
		if( ! SpaceCheck( parts.cl_phone.value ) ) {
			alert("会社電話番号はスペースのみの登録はできません。");
			parts.cl_phone.focus();
			return false;
		}
		if( ! TellCheck_2( parts.cl_phone.value ) ) {
			alert("会社電話番号は'-'付き半角数字で入力して下さい。");
			parts.cl_phone.focus();
			return false;
		}
	}
	
	// 会社ＦＡＸ
	if( parts.cl_fax.value != "" ){
		if( ! SpaceCheck( parts.cl_fax.value ) ) {
			alert("会社ＦＡＸ番号はスペースのみの登録はできません。");
			parts.cl_fax.focus();
			return false;
		}
		if( ! TellCheck_2( parts.cl_fax.value ) ) {
			alert("会社ＦＡＸ番号は'-'付き半角数字で入力して下さい。");
			parts.cl_fax.focus();
			return false;
		}
	}
	
	// 担当者Ｅメール
	if( parts.cl_mail.value == "" ){
		alert("担当者Ｅメールアドレスを入力して下さい");
		parts.cl_mail.focus();
		return false;
	} else {
		if( ! EmailCheck( parts.cl_mail.value ) ) {
			alert("担当者Ｅメールアドレスを正しく入力して下さい。");
			parts.cl_mail.focus();
			return false;
		}
	}
		
	// ログインＰＡＳＳ
	if( parts.cl_passwd.value == "" ){
		alert("ログインパスワードを入力して下さい");
		parts.cl_passwd.focus();
		return false;
	}
	if( !LoginValCheck( parts.cl_passwd.value ) ){
		alert("ログインパスワードは半角英数字のみ有効です");
		parts.cl_passwd.focus();
		return false;
	}
	ret_com = confirm("登録／修正します。よろしいですか？");
	if( !ret_com ){
		return false;
	}
	
	parts2.submit();
	return true;
	
}


/*==================================================
    住所検索
==================================================*/
function zipSearch(){
	ar_zip = document.addr_cd_1.value + "-" + document.addr_cd_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd&ad1=ar_pref&adc=ar_citycd&ad2=ar_city&ad3=ar_add','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}



/*==================================================
    住所検索
==================================================*/
function zipSearch1(){
	ar_zip = document.client.addr_cd_1.value + "-" + document.client.addr_cd_2.value;
	window.open('zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd1&ad1=ar_pref1&adc=ar_citycd1&ad2=ar_city1&ad3=ar_add1','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}



/*==================================================
    住所検索
==================================================*/
function zipSearch2(){
	ar_zip = document.client.ar_zip2_1.value + "-" + document.client.ar_zip2_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd2&ad1=ar_pref2&adc=ar_citycd2&ad2=ar_city2&ad3=ar_add2','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}



/*==================================================
    住所検索
==================================================*/
function zipSearch3(){
	ar_zip = document.client.ar_zip3_1.value + "-" + document.client.ar_zip3_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd3&ad1=ar_pref3&adc=ar_citycd3&ad2=ar_city3&ad3=ar_add3','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}



/*==================================================
    フォーカス時、背景色を変える
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
    住所一致検索Ajax呼出用
==================================================*/
function sendDataAdd( form ){
  xmlHttpObject = null;  // 通信オブジェクト
  if(window.XMLHttpRequest){  // safari,Firefoxなど
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
  // xmlHttpObjectが生成できたら、状態が変わった際に実行される関数を設定
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    var nknm = "";
    if(form.address_word.value!=null){ 
      nknm="?address_word="+encodeURI(form.address_word.value);
    }
    xmlHttpObject.open("GET","../mntAdd_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
==================================================*/
function wait(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    住所選択Ajax呼出用
==================================================*/
function sendDataAdd2( form ){
  xmlHttpObject = null;  // 通信オブジェクト
  if(window.XMLHttpRequest){  // safari,Firefoxなど
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
  // xmlHttpObjectが生成できたら、状態が変わった際に実行される関数を設定
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait2;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
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
    画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
==================================================*/
function wait2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello2").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    住所一致検索Ajax呼出用
==================================================*/
function sendDataAdd1_1( form ){
  xmlHttpObject = null;  // 通信オブジェクト
  if(window.XMLHttpRequest){  // safari,Firefoxなど
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
  // xmlHttpObjectが生成できたら、状態が変わった際に実行される関数を設定
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait1_1;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    var nknm = "";
    if(form.address_word1.value!=null){ 
      nknm="?address_word="+encodeURI(form.address_word1.value);
    }
    xmlHttpObject.open("GET","../mntAdd_ajax1.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
==================================================*/
function wait1_1(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello1_1").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello1_1").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    住所選択Ajax呼出用
==================================================*/
function sendDataAdd1_2( form ){
  xmlHttpObject = null;  // 通信オブジェクト
  if(window.XMLHttpRequest){  // safari,Firefoxなど
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
  // xmlHttpObjectが生成できたら、状態が変わった際に実行される関数を設定
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait1_2;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
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
    画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
==================================================*/
function wait1_2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello1_2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello1_2").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    住所一致検索Ajax呼出用
==================================================*/
function sendDataAdd2_1( form ){
  xmlHttpObject = null;  // 通信オブジェクト
  if(window.XMLHttpRequest){  // safari,Firefoxなど
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
  // xmlHttpObjectが生成できたら、状態が変わった際に実行される関数を設定
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait2_1;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    var nknm = "";
    if(form.address_word2.value!=null){ 
      nknm="?address_word="+encodeURI(form.address_word2.value);
    }
    xmlHttpObject.open("GET","../mntAdd_ajax2.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
==================================================*/
function wait2_1(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello2_1").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello2_1").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    住所選択Ajax呼出用
==================================================*/
function sendDataAdd2_2( form ){
  xmlHttpObject = null;  // 通信オブジェクト
  if(window.XMLHttpRequest){  // safari,Firefoxなど
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
  // xmlHttpObjectが生成できたら、状態が変わった際に実行される関数を設定
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait2_2;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
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
    画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
==================================================*/
function wait2_2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello2_2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello2_2").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    住所一致検索Ajax呼出用
==================================================*/
function sendDataAdd3_1( form ){
  xmlHttpObject = null;  // 通信オブジェクト
  if(window.XMLHttpRequest){  // safari,Firefoxなど
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
  // xmlHttpObjectが生成できたら、状態が変わった際に実行される関数を設定
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait3_1;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    var nknm = "";
    if(form.address_word3.value!=null){ 
      nknm="?address_word="+encodeURI(form.address_word3.value);
    }
    xmlHttpObject.open("GET","../mntAdd_ajax3.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


/*==================================================
    画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
==================================================*/
function wait3_1(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello3_1").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello3_1").innerHTML = "<b>Wait......</b>";
  }
}


/*==================================================
    住所選択Ajax呼出用
==================================================*/
function sendDataAdd3_2( form ){
  xmlHttpObject = null;  // 通信オブジェクト
  if(window.XMLHttpRequest){  // safari,Firefoxなど
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
  // xmlHttpObjectが生成できたら、状態が変わった際に実行される関数を設定
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = wait3_2;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
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
    画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
==================================================*/
function wait3_2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello3_2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello3_2").innerHTML = "<b>Wait......</b>";
  }
}


