// クライアント検索画面エリア→県用
function rssBE( id , mode , base , addr_url , addr ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayHello;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    xmlHttpObject.open("GET","./rss.php?id="+id+"&mode="+mode+"&base="+base+"&addr_url="+addr_url+"&addr="+addr,true);
    xmlHttpObject.send(null);
  }
}

// 画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
function displayHello(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello").innerHTML = "<b>Wait......</b>";
  }
}

