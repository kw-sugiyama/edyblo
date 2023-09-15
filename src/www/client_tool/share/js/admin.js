// クライアント検索画面エリア→県用
function sendData( form , selection ){
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


// 画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
function displayHello(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello").innerHTML = "<b>Wait......</b>";
  }
}


// 画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
function displaySta2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("station2").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("station2").innerHTML = "<b>Wait......</b>";
  }
}


// クライアントメンテ画面県・頭文字→駅用
function sendDataMntSta( form ){
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


// クライアントメンテ画面県・頭文字→駅用2
function sendDataMntStation2( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displaySta2;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
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


// クライアントメンテ画面県・頭文字→学校用
function sendDataMntSta2( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt2;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
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


// 画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
function displayMnt2(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello2C").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello2C").innerHTML = "<b>Wait......</b>";
  }
}


// クライアントメンテ画面学校一覧→学校追加用(普通用)
function sendDataMntCam( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt3;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
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
      alert("選択できる学校は50件までです。");
      return;
    }
    if(nknm==""){
      alert("学校を選択してください");
      return;
    }
    document.getElementById("mnt_campuses").selectedIndex = maxCnt;
    nknm=nknm+"&maxcnt="+maxCnt;
    xmlHttpObject.open("GET","../mntCamSelect_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// 画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
function displayMnt3(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello3C").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello3C").innerHTML = "<b>Wait......</b>";
  }
}


// クライアントメンテ画面学校一覧→学校削除用(普通用)
function sendDataMntCam2( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt3;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
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
      alert("学校を選択してください");
      return;
    }
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","../mntCamSelect_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// クライアントメンテ画面学校一覧→学校追加用(上位用)
function sendDataMntCam3( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    if( (!document.getElementById("rb_priority1").checked) && (!document.getElementById("rb_priority2").checked)){ 
      alert("表示順サービスがスーパー上位表示、または上位表示になっていません。");
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
      alert("選択できる上位表示用学校は20件までです。");
      return;
    }
    if(totalCnt > 50){
      alert("選択できる学校は50件までです。");
      return;
    }
    if(nknm==""){
      alert("学校を選択してください");
      return;
    }
    document.getElementById("mnt_campuses").selectedIndex = maxCnt;
    nknm=nknm+"&maxcnt="+maxCnt;
    xmlHttpObject.open("GET","../mntCamSelectSJ_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// 画面に挨拶文字列を表示(HTTP通信の状態が変化したら呼び出される関数)
function displayMnt4(){
  if((xmlHttpObject.readyState == 4) && (xmlHttpObject.status == 200)){
    document.getElementById("hello4").innerHTML = xmlHttpObject.responseText;
  }else{
    document.getElementById("hello4").innerHTML = "<b>Wait......</b>";
  }
}


// クライアントメンテ画面学校一覧→学校削除用(上位用)
function sendDataMntCam4( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    if( (!document.getElementById("rb_priority1").checked) && (!document.getElementById("rb_priority2").checked)){ 
      alert("表示順サービスがスーパー上位表示、または上位表示になっていません。");
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
      alert("学校を選択してください");
      return;
    }
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","./mntCamSelectSJ_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// クライアントメンテ画面選択学校上方移動(上位表示)
function sendDataMntCam5( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    if( (!document.getElementById("rb_priority1").checked) && (!document.getElementById("rb_priority2").checked)){ 
      alert("表示順サービスがスーパー上位表示、または上位表示になっていません。");
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
            alert("学校は１校のみ選択してください");
            return;
          }
          flg=9;
          maxCntSel = i;
          nknm="?mnt_campuses_sort[]="+encodeURI(document.getElementById("mnt_campuses_sel_sj").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("学校を選択してください");
      return;
    }
    var mntIndex = maxCntSel-1;
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","./mntCamSortSJ_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// クライアントメンテ画面選択学校下方移動(上位表示)
function sendDataMntCam6( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    if( (!document.getElementById("rb_priority1").checked) && (!document.getElementById("rb_priority2").checked)){ 
      alert("表示順サービスがスーパー上位表示、または上位表示になっていません。");
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
            alert("学校は１校のみ選択してください");
            return;
          }
          flg=9;
          maxCntSel = i;
          nknm="?mnt_campuses_sortD[]="+encodeURI(document.getElementById("mnt_campuses_sel_sj").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("学校を選択してください");
      return;
    }
    var mntIndex = maxCntSel+1;
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","./mntCamSortSJ_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// クライアントメンテ画面選択学校上方移動(普通表示)
function sendDataMntCam7( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt3;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    var nknm = "";
    var flg = 0;
    var maxCntSel = 0;
    var cnt = document.getElementById("mnt_campuses_sel").options.length;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses_sel").options[i]!=null){ 
        if(document.getElementById("mnt_campuses_sel").options[i].selected){
          if(flg==9){
            alert("学校は１校のみ選択してください");
            return;
          }
          flg=9;
          maxCntSel = i;
          nknm="?mnt_campuses_sort[]="+encodeURI(document.getElementById("mnt_campuses_sel").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("学校を選択してください");
      return;
    }
    var mntIndex = maxCntSel-1;
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","../mntCamSort_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


// クライアントメンテ画面選択学校下方移動(普通表示)
function sendDataMntCam8( form ){
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt3;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
    var nknm = "";
    var flg = 0;
    var maxCntSel = 0;
    var cnt = document.getElementById("mnt_campuses_sel").options.length;
    for(i=0;i<cnt;i++){
      if(document.getElementById("mnt_campuses_sel").options[i]!=null){ 
        if(document.getElementById("mnt_campuses_sel").options[i].selected){
          if(flg==9){
            alert("学校は１校のみ選択してください");
            return;
          }
          flg=9;
          maxCntSel = i;
          nknm="?mnt_campuses_sortD[]="+encodeURI(document.getElementById("mnt_campuses_sel").options[i].value);
        }
      }
    }
    if(nknm==""){
      alert("学校を選択してください");
      return;
    }
    var mntIndex = maxCntSel+1;
    nknm=nknm+"&maxcntsel="+maxCntSel;
    xmlHttpObject.open("GET","../mntCamSort_ajax.php"+nknm,true);
    xmlHttpObject.send(null);
  }
}


function parent_ins_check() {
	// 親会社名
	if ( document.getElementById("parent_name_ins").value == '' ) {
		alert("親会社名を入力して下さい。");
		document.getElementById("parent_name_ins").focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( document.getElementById("parent_name_ins").value ) ) {
			alert("親会社名はスペースのみの入力はできません。");
			document.getElementById("parent_name_ins").focus();
			return false;
		}
	}

	// 登録確認
	ret_com = confirm("登録します。よろしいですか？");
	if( !ret_com ){
		return false;
	}
	
	document.getElementById("parent_ins_form").submit();
	return true;
	
}


function parent_upd_check() {
	// 親会社名
	if ( document.getElementById("parent_name_upd").value == '' ) {
		alert("親会社名を入力して下さい。");
		document.getElementById("parent_name_upd").focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( document.getElementById("parent_name_upd").value ) ) {
			alert("親会社名はスペースのみの入力はできません。");
			document.getElementById("parent_name_upd").focus();
			return false;
		}
	}

	// 修正確認
	ret_com = confirm("修正します。よろしいですか？");
	if( !ret_com ){
		return false;
	}
	
	document.getElementById("parent_edit_form").submit();
	return true;
	
}


function parent_del_check() {
	// 削除確認
	ret_com = confirm("削除します。よろしいですか？");
	if( !ret_com ){
		return false;
	}
	
	document.getElementById("parent_del_form").submit();
	return true;
	
}

/*=====================================================================
    カタログ種別 - 処理時選択処理
=====================================================================*/
function catalog_kind_check( parts , strFlg ) {
	
	if ( strFlg == "INS" ) {
		intChk = parts.catalog_kind_disp_no.value.match("^[0-9]+$");
		if ( !intChk ) {
			alert("表示順は半角数字のみで入力してください。");
			parts.catalog_kind_disp_no.focus();
			return false;
		}
		ret = confirm("修正します。よろしいですか？");
		if( !ret ){
			return false;
		}
	} else if ( strFlg == "UPD" ) {
		intChk = parts.catalog_kind_disp_no.value.match("^[0-9]+$");
		if ( !intChk ) {
			alert("表示順は半角数字のみで入力してください。");
			parts.catalog_kind_disp_no.focus();
			return false;
		}
		ret = confirm("修正します。よろしいですか？");
		if( !ret ){
			return false;
		}
		parts.SetFlg.value = "UPD";
	} else if ( strFlg == "DEL" ) {
		ret = confirm("削除します。よろしいですか？");
		if( !ret ){
			return false;
		}
		parts.SetFlg.value = "DEL";
	}
	parts.submit();
	return true;
}


/*=====================================================================
    カタログ情報 - 次ページ選択処理
=====================================================================*/
function catalog_next_page( parts , strFlg ) {
	if ( strFlg == "UPD" ) {
		parts.SetFlg.value = "UPD";
		parts.action = "catalog_mnt.php";
	} else if ( strFlg == "DEL" ) {
		if ( !confirm("削除します。よろしいですか？") ) {
			return false;
		}
		parts.SetFlg.value = "DEL";
		parts.action = "catalog_upd.php";
	}
	parts.submit();
	return true;
}


/*=====================================================================
    カタログ情報 - 入力内容確認
=====================================================================*/
function catalog_input_check( parts ) {
	
	// 表示／非表示
	if ( !parts.catalog_flg[0].checked && !parts.catalog_flg[1].checked ) {
		alert("表示／非表示を選択してください。");
		parts.catalog_flg[0].focus();
		return false;
	}
	
	// 所属グループ
	intChkFlg = 9;
	intCnt = parts.elements["catalog_kind[]"].length;
	for ( iX=0; iX<intCnt; iX++ ) {
		if ( parts.elements["catalog_kind[]"][iX].checked ) {
			intChkFlg = 1;
		}
	}
	if ( intChkFlg == 9 ) {
		alert("所属グループを選択してください。");
		parts.elements["catalog_kind[]"][0].focus();
		return false;
	}
	
	// カタログ名称
	if ( parts.catalog_name.value == "" ) {
		alert("カタログ名称を入力してください。");
		parts.catalog_name.focus();
		return false;
	}
	
	// カタログ請求メール送信先
	if ( parts.catalog_mail.value == "" ) {
		alert("カタログ請求メール送信先を入力してください。");
		parts.catalog_mail.focus();
		return false;
	} else {
		if ( EmailCheck( parts.catalog_mail.value ) === false ) {
			alert("カタログ請求メール送信先を確認してください。");
			parts.catalog_mail.focus();
			return false;
		}
	}
	
	// 確認処理
	if ( parts.SetFlg.value == "NEW" ) {
		if ( !confirm("登録します。よろしいですか？") ) {
			return false;
		}
	} else if ( parts.SetFlg.value == "UPD" ) {
		if ( !confirm("修正します。よろしいですか？") ) {
			return false;
		}
	}
	parts.submit();
	return true;
}

/*=====================================================================
    カタログ情報 - 入力内容確認
=====================================================================*/
function campus_bgcolor() {
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
  if(xmlHttpObject)xmlHttpObject.onreadystatechange = displayMnt4;

  if(xmlHttpObject){  // GETパラメータ付きでリクエスト送信
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
