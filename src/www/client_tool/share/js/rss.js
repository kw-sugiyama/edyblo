// ���饤����ȸ������̥��ꥢ������
function rssBE( id , mode , base , addr_url , addr ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayHello;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    xmlHttpObject.open("GET","./rss.php?id="+id+"&mode="+mode+"&base="+base+"&addr_url="+addr_url+"&addr="+addr,true);
    xmlHttpObject.send(null);
  }
}

// ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
function displayHello(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello").innerHTML = "<b>Wait......</b>";
  }
}

