// ���饤����ȸ������̥��ꥢ������
function sendData( form , selection ){
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
    var nknm = "";
    var cnt = selection.options.length;
    for(i=0;i<cnt;i++){
      if(selection.options[i]!=null){ 
        if(selection.options[i].selected){
          if(nknm != "")nknm=nknm+"&nickname[]="+encodeURI(selection.options[i].value);
          if(nknm == "")nknm="?nickname[]="+encodeURI(selection.options[i].value);
        }
      }
    }
    xmlHttpObject.open("GET","./prefsArea_ajax.php"+nknm,true);
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


// ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
function displaySta2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("station2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("station2").innerHTML = "<b>Wait......</b>";
  }
}


// ���饤����ȥ��Ʋ��̸���Ƭʸ��������
function sendDataMntSta( form ){
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
    var nknm = "";
    var cnt = form.mnt_prefecture.options.length;
    for(i=0;i<cnt;i++){
      if(form.mnt_prefecture.options[i]!=null){ 
        if(form.mnt_prefecture.options[i].selected){
          nknm="?mnt_prefecture="+encodeURI(form.mnt_prefecture.options[i].value);
        }
      }
    }
    var cnt2 = form.mnt_initial.options.length;
    for(i=0;i<cnt2;i++){
      if(form.mnt_initial.options[i]!=null){ 
        if(form.mnt_initial.options[i].selected){
          if(nknm != "")nknm=nknm+"&mnt_initial="+encodeURI(form.mnt_initial.options[i].value);
          if(nknm == "")nknm="?mnt_initial="+encodeURI(form.mnt_initial.options[i].value);
        }
      }
    }
    xmlHttpObject.open("GET","./mntStation_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���饤����ȥ��Ʋ��̸���Ƭʸ��������2
function sendDataMntStation2( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displaySta2;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var cnt = form.mnt_prefecture2.options.length;
    for(i=0;i<cnt;i++){
      if(form.mnt_prefecture2.options[i]!=null){ 
        if(form.mnt_prefecture2.options[i].selected){
          nknm="?mnt_prefecture="+encodeURI(form.mnt_prefecture2.options[i].value);
        }
      }
    }
    var cnt2 = form.mnt_initial2.options.length;
    for(i=0;i<cnt2;i++){
      if(form.mnt_initial2.options[i]!=null){ 
        if(form.mnt_initial2.options[i].selected){
          if(nknm != "")nknm=nknm+"&mnt_initial="+encodeURI(form.mnt_initial2.options[i].value);
          if(nknm == "")nknm="?mnt_initial="+encodeURI(form.mnt_initial2.options[i].value);
        }
      }
    }
    xmlHttpObject.open("GET","./mntStation_ajax2.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���饤����ȥ��Ʋ��̸���Ƭʸ�����ع���
function sendDataMntSta2( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt2;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var cnt = form.mnt_cam_prefecture.options.length;
    for(i=0;i<cnt;i++){
      if(form.mnt_cam_prefecture.options[i]!=null){ 
        if(form.mnt_cam_prefecture.options[i].selected){
          nknm="?mnt_cam_prefecture="+encodeURI(form.mnt_cam_prefecture.options[i].value);
        }
      }
    }
    var cnt2 = form.mnt_cam_initial.options.length;
    for(i=0;i<cnt2;i++){
      if(form.mnt_cam_initial.options[i]!=null){ 
        if(form.mnt_cam_initial.options[i].selected){
          if(nknm != "")nknm=nknm+"&mnt_cam_initial="+encodeURI(form.mnt_cam_initial.options[i].value);
          if(nknm == "")nknm="?mnt_cam_initial="+encodeURI(form.mnt_cam_initial.options[i].value);
        }
      }
    }
    xmlHttpObject.open("GET","../mntCampus_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
function displayMnt2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello2C").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello2C").innerHTML = "<b>Wait......</b>";
  }
}


// ���饤����ȥ��Ʋ��̳ع��������ع��ɲ���(������)
function sendDataMntCam( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt3;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var maxCnt = 0;
    var cnt = document.getElementById("mnt_campuses").options.length;
    var cntSel = document.getElementById("mnt_campuses_sel").options.length;
    var cntSelect = 0;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses").options[i]!=null){ 
        if(document.getElementById("mnt_campuses").options[i].selected){
          if(nknm != "")nknm=nknm+"&mnt_campuses[]="+encodeURI(document.getElementById("mnt_campuses").options[i].value)+"&mnt_campuses_text[]="+encodeURI(document.getElementById("mnt_campuses").options[i].text);
          if(nknm == "")nknm="?mnt_campuses[]="+encodeURI(document.getElementById("mnt_campuses").options[i].value)+"&mnt_campuses_text[]="+encodeURI(document.getElementById("mnt_campuses").options[i].text);
          cntSelect++;
          maxCnt = i;
        }
      }
    }
    
    if((cnt-1) < (maxCnt+1)){
      maxCnt = cnt-1;
    }else{
      maxCnt++;
    }
    var totalCnt = cntSelect + cntSel;
    if(totalCnt > 50){
      alert("����Ǥ���ع���50��ޤǤǤ���");
      return;
    }
    if(nknm==""){
      alert("�ع������򤷤Ƥ�������");
      return;
    }
    document.getElementById("mnt_campuses").selectedIndex = maxCnt;
    nknm=nknm+"&maxcnt="+maxCnt;
    xmlHttpObject.open("GET","../mntCamSelect_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
function displayMnt3(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello3C").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello3C").innerHTML = "<b>Wait......</b>";
  }
}


// ���饤����ȥ��Ʋ��̳ع��������ع������(������)
function sendDataMntCam2( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt3;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var maxCntSel = 0;
    var cnt = document.getElementById("mnt_campuses_sel").options.length;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses_sel").options[i]!=null){ 
        if(document.getElementById("mnt_campuses_sel").options[i].selected){
          if(nknm == "")maxCntSel = i;
          if(nknm != "")nknm=nknm+"&mnt_campuses_del[]="+encodeURI(document.getElementById("mnt_campuses_sel").options[i].value);
          if(nknm == "")nknm="?mnt_campuses_del[]="+encodeURI(document.getElementById("mnt_campuses_sel").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("�ع������򤷤Ƥ�������");
      return;
    }
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","../mntCamSelect_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���饤����ȥ��Ʋ��̳ع��������ع��ɲ���(�����)
function sendDataMntCam3( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    if( (!document.getElementById("rb_priority1").checked) && (!document.getElementById("rb_priority2").checked)){ 
      alert("ɽ���祵���ӥ��������ѡ����ɽ�����ޤ��Ͼ��ɽ���ˤʤäƤ��ޤ���");
      return;
    }
   var nknm = "";
    var maxCnt = 0;
    var cnt = document.getElementById("mnt_campuses").options.length;
    var cntSel = document.getElementById("mnt_campuses_sel").options.length;
    var cntSelSj = document.getElementById("mnt_campuses_sel_sj").options.length;
    var cntSelect = 0;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses").options[i]!=null){ 
        if(document.getElementById("mnt_campuses").options[i].selected){
          if(nknm != "")nknm=nknm+"&mnt_campuses[]="+encodeURI(document.getElementById("mnt_campuses").options[i].value)+"&mnt_campuses_text[]="+encodeURI(document.getElementById("mnt_campuses").options[i].text);
          if(nknm == "")nknm="?mnt_campuses[]="+encodeURI(document.getElementById("mnt_campuses").options[i].value)+"&mnt_campuses_text[]="+encodeURI(document.getElementById("mnt_campuses").options[i].text);
          maxCnt = i;
          cntSelect++;
        }
      }
    }
    
    if((cnt-1) < (maxCnt+1)){
      maxCnt = cnt-1;
    }else{
      maxCnt++;
    }
    var totalCnt = cntSelect + cntSel + cntSelSj;
    var totalCntSj = cntSelect + cntSelSj;
    if(totalCntSj > 20){
      alert("����Ǥ�����ɽ���ѳع���20��ޤǤǤ���");
      return;
    }
    if(totalCnt > 50){
      alert("����Ǥ���ع���50��ޤǤǤ���");
      return;
    }
    if(nknm==""){
      alert("�ع������򤷤Ƥ�������");
      return;
    }
    document.getElementById("mnt_campuses").selectedIndex = maxCnt;
    nknm=nknm+"&maxcnt="+maxCnt;
    xmlHttpObject.open("GET","../mntCamSelectSJ_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���̤˰���ʸ�����ɽ��(HTTP�̿��ξ��֤��Ѳ�������ƤӽФ����ؿ�)
function displayMnt4(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello4").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello4").innerHTML = "<b>Wait......</b>";
  }
}


// ���饤����ȥ��Ʋ��̳ع��������ع������(�����)
function sendDataMntCam4( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    if( (!document.getElementById("rb_priority1").checked) && (!document.getElementById("rb_priority2").checked)){ 
      alert("ɽ���祵���ӥ��������ѡ����ɽ�����ޤ��Ͼ��ɽ���ˤʤäƤ��ޤ���");
      return;
    }
    var nknm = "";
    var maxCntSel = 0;
    var cnt = document.getElementById("mnt_campuses_sel_sj").options.length;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses_sel_sj").options[i]!=null){ 
        if(document.getElementById("mnt_campuses_sel_sj").options[i].selected){
          if(nknm == "")maxCntSel = i;
          if(nknm != "")nknm=nknm+"&mnt_campuses_del[]="+encodeURI(document.getElementById("mnt_campuses_sel_sj").options[i].value);
          if(nknm == "")nknm="?mnt_campuses_del[]="+encodeURI(document.getElementById("mnt_campuses_sel_sj").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("�ع������򤷤Ƥ�������");
      return;
    }
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","./mntCamSelectSJ_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���饤����ȥ��Ʋ�������ع�������ư(���ɽ��)
function sendDataMntCam5( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    if( (!document.getElementById("rb_priority1").checked) && (!document.getElementById("rb_priority2").checked)){ 
      alert("ɽ���祵���ӥ��������ѡ����ɽ�����ޤ��Ͼ��ɽ���ˤʤäƤ��ޤ���");
      return;
    }
    var nknm = "";
    var flg = 0;
    var maxCntSel = 0;
    var cnt = document.getElementById("mnt_campuses_sel_sj").options.length;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses_sel_sj").options[i]!=null){ 
        if(document.getElementById("mnt_campuses_sel_sj").options[i].selected){
          if(flg==9){
            alert("�ع��ϣ����Τ����򤷤Ƥ�������");
            return;
          }
          flg=9;
          maxCntSel = i;
          nknm="?mnt_campuses_sort[]="+encodeURI(document.getElementById("mnt_campuses_sel_sj").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("�ع������򤷤Ƥ�������");
      return;
    }
    var mntIndex = maxCntSel-1;
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","./mntCamSortSJ_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���饤����ȥ��Ʋ�������ع�������ư(���ɽ��)
function sendDataMntCam6( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    if( (!document.getElementById("rb_priority1").checked) && (!document.getElementById("rb_priority2").checked)){ 
      alert("ɽ���祵���ӥ��������ѡ����ɽ�����ޤ��Ͼ��ɽ���ˤʤäƤ��ޤ���");
      return;
    }
    var nknm = "";
    var flg = 0;
    var maxCntSel = 0;
    var cnt = document.getElementById("mnt_campuses_sel_sj").options.length;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses_sel_sj").options[i]!=null){ 
        if(document.getElementById("mnt_campuses_sel_sj").options[i].selected){
          if(flg==9){
            alert("�ع��ϣ����Τ����򤷤Ƥ�������");
            return;
          }
          flg=9;
          maxCntSel = i;
          nknm="?mnt_campuses_sortD[]="+encodeURI(document.getElementById("mnt_campuses_sel_sj").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("�ع������򤷤Ƥ�������");
      return;
    }
    var mntIndex = maxCntSel+1;
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","./mntCamSortSJ_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���饤����ȥ��Ʋ�������ع�������ư(����ɽ��)
function sendDataMntCam7( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt3;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var flg = 0;
    var maxCntSel = 0;
    var cnt = document.getElementById("mnt_campuses_sel").options.length;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses_sel").options[i]!=null){ 
        if(document.getElementById("mnt_campuses_sel").options[i].selected){
          if(flg==9){
            alert("�ع��ϣ����Τ����򤷤Ƥ�������");
            return;
          }
          flg=9;
          maxCntSel = i;
          nknm="?mnt_campuses_sort[]="+encodeURI(document.getElementById("mnt_campuses_sel").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("�ع������򤷤Ƥ�������");
      return;
    }
    var mntIndex = maxCntSel-1;
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","../mntCamSort_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// ���饤����ȥ��Ʋ�������ع�������ư(����ɽ��)
function sendDataMntCam8( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt3;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var nknm = "";
    var flg = 0;
    var maxCntSel = 0;
    var cnt = document.getElementById("mnt_campuses_sel").options.length;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses_sel").options[i]!=null){ 
        if(document.getElementById("mnt_campuses_sel").options[i].selected){
          if(flg==9){
            alert("�ع��ϣ����Τ����򤷤Ƥ�������");
            return;
          }
          flg=9;
          maxCntSel = i;
          nknm="?mnt_campuses_sortD[]="+encodeURI(document.getElementById("mnt_campuses_sel").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("�ع������򤷤Ƥ�������");
      return;
    }
    var mntIndex = maxCntSel+1;
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","../mntCamSort_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


function parent_ins_check() {
	// �Ʋ��̾
	if ( document.getElementById("parent_name_ins").value == '' ) {
		alert("�Ʋ��̾�����Ϥ��Ʋ�������");
		document.getElementById("parent_name_ins").focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( document.getElementById("parent_name_ins").value ) ) {
			alert("�Ʋ��̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			document.getElementById("parent_name_ins").focus();
			return false;
		}
	}

	// ��Ͽ��ǧ
	ret_com = confirm("��Ͽ���ޤ���������Ǥ�����");
	if( !ret_com ){
		return false;
	}
	
	document.getElementById("parent_ins_form").submit();
	return true;
	
}


function parent_upd_check() {
	// �Ʋ��̾
	if ( document.getElementById("parent_name_upd").value == '' ) {
		alert("�Ʋ��̾�����Ϥ��Ʋ�������");
		document.getElementById("parent_name_upd").focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( document.getElementById("parent_name_upd").value ) ) {
			alert("�Ʋ��̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			document.getElementById("parent_name_upd").focus();
			return false;
		}
	}

	// ������ǧ
	ret_com = confirm("�������ޤ���������Ǥ�����");
	if( !ret_com ){
		return false;
	}
	
	document.getElementById("parent_edit_form").submit();
	return true;
	
}


function parent_del_check() {
	// �����ǧ
	ret_com = confirm("������ޤ���������Ǥ�����");
	if( !ret_com ){
		return false;
	}
	
	document.getElementById("parent_del_form").submit();
	return true;
	
}

/*=====================================================================
    ���������� - �������������
=====================================================================*/
function catalog_kind_check( parts , strFlg ) {
	
	if ( strFlg == "INS" ) {
		intChk = parts.catalog_kind_disp_no.value.match("^[0-9]+$");
		if ( !intChk ) {
			alert("ɽ�����Ⱦ�ѿ����Τߤ����Ϥ��Ƥ���������");
			parts.catalog_kind_disp_no.focus();
			return false;
		}
		ret = confirm("�������ޤ���������Ǥ�����");
		if( !ret ){
			return false;
		}
	} else if ( strFlg == "UPD" ) {
		intChk = parts.catalog_kind_disp_no.value.match("^[0-9]+$");
		if ( !intChk ) {
			alert("ɽ�����Ⱦ�ѿ����Τߤ����Ϥ��Ƥ���������");
			parts.catalog_kind_disp_no.focus();
			return false;
		}
		ret = confirm("�������ޤ���������Ǥ�����");
		if( !ret ){
			return false;
		}
		parts.SetFlg.value = "UPD";
	} else if ( strFlg == "DEL" ) {
		ret = confirm("������ޤ���������Ǥ�����");
		if( !ret ){
			return false;
		}
		parts.SetFlg.value = "DEL";
	}
	parts.submit();
	return true;
}


/*=====================================================================
    ���������� - ���ڡ����������
=====================================================================*/
function catalog_next_page( parts , strFlg ) {
	if ( strFlg == "UPD" ) {
		parts.SetFlg.value = "UPD";
		parts.action = "catalog_mnt.php";
	} else if ( strFlg == "DEL" ) {
		if ( !confirm("������ޤ���������Ǥ�����") ) {
			return false;
		}
		parts.SetFlg.value = "DEL";
		parts.action = "catalog_upd.php";
	}
	parts.submit();
	return true;
}


/*=====================================================================
    ���������� - �������Ƴ�ǧ
=====================================================================*/
function catalog_input_check( parts ) {
	
	// ɽ������ɽ��
	if ( !parts.catalog_flg[0].checked && !parts.catalog_flg[1].checked ) {
		alert("ɽ������ɽ�������򤷤Ƥ���������");
		parts.catalog_flg[0].focus();
		return false;
	}
	
	// ��°���롼��
	intChkFlg = 9;
	intCnt = parts.elements["catalog_kind[]"].length;
	for ( iX=0; iX<intCnt; iX++ ) {
		if ( parts.elements["catalog_kind[]"][iX].checked ) {
			intChkFlg = 1;
		}
	}
	if ( intChkFlg == 9 ) {
		alert("��°���롼�פ����򤷤Ƥ���������");
		parts.elements["catalog_kind[]"][0].focus();
		return false;
	}
	
	// ������̾��
	if ( parts.catalog_name.value == "" ) {
		alert("������̾�Τ����Ϥ��Ƥ���������");
		parts.catalog_name.focus();
		return false;
	}
	
	// ����������᡼��������
	if ( parts.catalog_mail.value == "" ) {
		alert("����������᡼������������Ϥ��Ƥ���������");
		parts.catalog_mail.focus();
		return false;
	} else {
		if ( EmailCheck( parts.catalog_mail.value ) === false ) {
			alert("����������᡼����������ǧ���Ƥ���������");
			parts.catalog_mail.focus();
			return false;
		}
	}
	
	// ��ǧ����
	if ( parts.SetFlg.value == "NEW" ) {
		if ( !confirm("��Ͽ���ޤ���������Ǥ�����") ) {
			return false;
		}
	} else if ( parts.SetFlg.value == "UPD" ) {
		if ( !confirm("�������ޤ���������Ǥ�����") ) {
			return false;
		}
	}
	parts.submit();
	return true;
}

/*=====================================================================
    ���������� - �������Ƴ�ǧ
=====================================================================*/
function campus_bgcolor() {
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GET�ѥ�᡼���դ��ǥꥯ����������
    var flg = 0;
    if(document.getElementById("rb_priority1").checked || document.getElementById("rb_priority2").checked){
      flg = 1;
    } else {
      flg = 9;
    }
    var nknm = "?flg="+flg;
    xmlHttpObject.open("GET","./mntSelectSJ_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}
