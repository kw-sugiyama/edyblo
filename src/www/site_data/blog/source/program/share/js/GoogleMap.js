/**************************************************
GoogleMap
������
	mode			����ǽͭ:11111��������ǽ̵:00000
				�头�Ȥε�ǽ�ܺ�(���ݎĎێ��َʎގ� , �Ͽގ��Ҷ��ڤ��ؤ� , ������MAP , �濴�� ,�Ďގ׎����޶ػ�,�ޡ�����¿��ɽ��,�᤭�Ф��ѥ����� )
	mapX2			DB�η���
	mapY2			DB�ΰ���
	zoomO			DB�Υ�������
	dfX			�ޡ�����̵�����Υǥե���ȷ���
	dfY			�ޡ�����̵�����Υǥե���Ȱ���
	dfZ			�ޡ�����̵�����Υǥե���ȥ�������
	mkrX			¿�����Υޡ��������١�(��)38.4515,42.5682
	mkrY			¿�����Υޡ��������١�(��)139.1245,148.4516
	mkrName			¿������ʮ�Ф���ɽ������̾���ȥ��ɥ쥹��(��)click1,click2<>http://click1,http://click2
	marker_img		�ޡ������β���URL
	marker_shadow_img	�ޡ������αƲ���URL

���Ƽ�����ID̾
	zoomN			upd�����륺������
	mapY			upd�����������
	mapX			upd�����������
**************************************************/

/*------------------------------------------
	�ᥤ��ؿ�
------------------------------------------*/
function loadMap(mode,mapX2,mapY2,zoomO,dfX,dfY,dfZ,mkrX,mkrY,mkrName,marker_img,marker_shadow_img) {
  var marker_flg = 0;
  var map_control_flag = false;
  var map_type_control_flag = false;		//�Ҷ����Ͽ�+�̿��ѥͥ�
  var over_view_map_control_flag = false;	//�����ξ������Ͽ�
  var scale_control_flag = false;	//��������
  var modeData = new Array(100);
  var zoom = 0 ;
  var ido = 0 ;
  var keido = 0 ;
  var diary_flg = 0 ;


  for(i=0;i<mode.length;i++){
    modeData[i] = mode.substr(i,1);
    modeData[i] = parseInt(modeData[i]);
  }

  if(modeData[0] == 1) {
	map_control_flag = true;
  }
  if(modeData[1] == 1) {
  	map_type_control_flag = true;
  }
  if(modeData[2] == 1) {
  	over_view_map_control_flag = true;
  }

  scale_control_flag = true;

  // Google Map�����Ѥ����������Ѥ��ѿ�
  var latlng = new google.maps.LatLng(mapX2, mapY2);
  var mapOptions = {
		zoom: parseInt(zoomO),
	    mapTypeId: google.maps.MapTypeId.ROADMAP,
	    center: latlng,
	    overviewMapControl: map_control_flag,
	    mapTypeControl: map_type_control_flag,
	    overviewMapControl: over_view_map_control_flag,
	    scaleControl: scale_control_flag
  };

  geocoder = new google.maps.Geocoder();
  map = new google.maps.Map(document.getElementById("gmap"), mapOptions);

  if( (modeData[5] == 1 && mapX2 != '' && mkrX != '' ) || modeData[7] == 1 ){
    point_lon = mkrY.split(",");
    point_lat = mkrX.split(",");
    htmlpop = mkrName.split("<>");
    ken_name = htmlpop[0].split(",");
    address_val = htmlpop[1].split(",");
    image_name = htmlpop[2].split(",");
    line_name = htmlpop[3].split(",");
    sta_name = htmlpop[4].split(",");
    madori = htmlpop[5].split(",");
    price = htmlpop[6].split(",");
    area = htmlpop[7].split(",");
    tsuika_add = htmlpop[8].split(",");
    vacant = htmlpop[9].split(",");

    if(zoomO != ""){
	var zoom = parseInt(zoomO);
    }else{
	var zoom = 12;
    }
    if(mapY2 == ""){
	var ido = 37;
    }else if(mapY2 % 1 != 0 ){
	var ido = parseFloat(mapY2);
    }else if(mapY2 % 1 == 0){
	var ido = parseInt(mapY2);
    }
    if(mapX2 == ""){
	var keido = 138;
    }else if(mapX2 % 1 != 0){
	var keido = parseFloat(mapX2);
    }else if(mapX2 % 1 == 0){
	var keido = parseInt(mapX2);
    }

    map.setCenter(new google.maps.LatLng(keido, ido))
    map.setZoom(zoom);

    // �ޡ���������
    iconD = new google.maps.MarkerImage(
  				"../share/images/icon_diary.gif",
  				new google.maps.Size(28, 28),
  				new google.maps.Size(28, 28),
  				new google.maps.Point( 14, 28 )
    );
    iconD.infoWindowAnchor = new google.maps.Point( 14, 5 );	// ���󥦥���ɥ��δ����
      //iconD = new GIcon();
      //iconD.image = "../share/images/icon_diary.gif";
      //iconD.iconSize = new GSize( 28, 28 );		// �������礭��
      //iconD.shadow = "../share/images/icon_diary_shadow.gif";
      //iconD.shadowSize = new GSize( 28, 28 );	// �Ʋ������礭��
      //iconD.iconAnchor = new GPoint( 14, 28 );		// �����Ρִ������
      //iconD.infoWindowAnchor = new GPoint( 14, 5 );	// ���󥦥���ɥ��δ����

    if(mkr_flg != 9){
      var mp = new google.maps.LatLng(keido, ido);
	  var mopts = {
		position: mp,
		icon: iconD,
		map: map
	  }
	  var mk = new google.maps.Marker(mopts);
      document.getElementById("marker_flg").value = 9;
    }
    
    diary_flg = 9;
    mkr_flg = 9;
  }else if(modeData[5] == 1 && mkrName != '<><><><><><><><><>'){

    point_lon = mkrY.split(",");
    point_lat = mkrX.split(",");
    htmlpop = mkrName.split("<>");
    ken_name = htmlpop[0].split(",");
    address_val = htmlpop[1].split(",");
    image_name = htmlpop[2].split(",");
    line_name = htmlpop[3].split(",");
    sta_name = htmlpop[4].split(",");
    madori = htmlpop[5].split(",");
    price = htmlpop[6].split(",");
    area = htmlpop[7].split(",");
    tsuika_add = htmlpop[8].split(",");
    vacant = htmlpop[9].split(",");
    for(i=0;i<point_lon.length;i++){
	if(i==0){
		if(point_lon[0] % 1 != 0){
			var maxY = parseFloat(point_lon[0]);
			var minY = parseFloat(point_lon[0]);
		}else if(point_lon[0] % 1 == 0){
			var maxY = parseInt(point_lon[0]);
			var minY = parseInt(point_lon[0]);
		}
		if(point_lat[0] % 1 != 0){
			var maxX = parseFloat(point_lat[0]);
			var minX = parseFloat(point_lat[0]);
		}else if(point_lat[0] % 1 == 0){
			var maxX = parseInt(point_lat[0]);
			var minX = parseInt(point_lat[0]);
		}
	}
	if(maxY < point_lon[i]){
		if(point_lon[i] % 1 != 0){
			maxY = parseFloat(point_lon[i]);
		}else if(point_lon[i] % 1 == 0){
			maxY = parseInt(point_lon[i]);
		}
	}
	if(maxX < point_lat[i]){
		if(point_lat[i] % 1 != 0){
			maxX = parseFloat(point_lat[i]);
		}else if(point_lat[i] % 1 == 0){
			maxX = parseInt(point_lat[i]);
		}
	}
	if(minY > point_lon[i]){
		if(point_lon[i] % 1 != 0){
			minY = parseFloat(point_lon[i]);
		}else if(point_lon[i] % 1 == 0){
			minY = parseInt(point_lon[i]);
		}
	}
	if(minX > point_lat[i]){
		if(point_lat[i] % 1 != 0){
			minX = parseFloat(point_lat[i]);
		}else if(point_lat[i] % 1 == 0){
			minX = parseInt(point_lat[i]);
		}
	}
    }
    var centerY = (maxY + minY)/2;
    var centerX = (maxX + minX)/2;
    if(centerY % 1 != 0){
	centerY = parseFloat(centerY);
    }else if(centerY % 1 == 0){
	centerY = parseInt(centerY);
    }
    if(centerX % 1 != 0){
	centerX = parseFloat(centerX);
    }else if(centerX % 1 == 0){
	centerX = parseInt(centerX);
    }

    var rectObj = new google.maps.LatLngBounds(new google.maps.LatLng(minX,minY), new google.maps.LatLng(maxX,maxY));
    var Rzm = map.getBoundsZoomLevel(rectObj);

    var zoom = parseInt(Rzm);
    document.getElementById("zoomN").value = Rzm;
    if(centerY % 1 != 0 ){
	var ido = parseFloat(centerY);
    }else if(centerY % 1 == 0){
	var ido = parseInt(centerY);
    }
    if(centerX % 1 != 0){
	var keido = parseFloat(centerX);
    }else if(centerX % 1 == 0){
	var keido = parseInt(centerX);
    }

    var mkr_flg = 9;

  }else if( mapX2 == "" && mapY2 == "" && dfY != "" && dfX != "" && dfZ != "" ){

    if(dfZ != ""){
	var zoom = parseInt(dfZ);
    }else{
	var zoom = 12;
    }
    if(dfY == ""){
	var ido = 37;
    }else if(dfY % 1 != 0 ){
	var ido = parseFloat(dfY);
    }else if(dfY % 1 == 0){
	var ido = parseInt(dfY);
    }
    if(dfX == ""){
	var keido = 138;
    }else if(dfX % 1 != 0){
	var keido = parseFloat(dfX);
    }else if(dfX % 1 == 0){
	var keido = parseInt(dfX);
    }

	var mkr_flg = 9;

  } else {
    if(zoomO != ""){
		var zoom = parseInt(zoomO);
    }else{
		var zoom = 12;
    }
    if(mapY2 == ""){
		var ido = 37;
    }else if(mapY2 % 1 != 0 ){
		var ido = parseFloat(mapY2);
    }else if(mapY2 % 1 == 0){
		var ido = parseInt(mapY2);
    }
    if(mapX2 == ""){
		var keido = 138;
    }else if(mapX2 % 1 != 0){
		var keido = parseFloat(mapX2);
    }else if(mapX2 % 1 == 0){
		var keido = parseInt(mapX2);
    }
  }

  if(diary_flg!=9) {
		map.setCenter(new google.maps.LatLng(keido, ido));
		map.setZoom(zoom)
  }

console.log(zoom);
  if(modeData[3] == 1){

    // �濴������
    var markObj = document.createElement("div");
    var mapW = parseInt(map.getDiv().style.width);
    var mapH = parseInt(map.getDiv().style.height);
    var markW = 31; // ���󥿡��ޡ����β����ʥԥ��������
    var markH = 31; // ���󥿡��ޡ����ν����ʥԥ��������
    var x = (mapW - markW) / 2; // ���󥿡��ޡ������濴���֡�X��ɸ��
    var y = (mapH - markH) / 2; // ���󥿡��ޡ������濴���֡�Y��ɸ��
    markObj.style.position = "absolute";
    markObj.style.top = y+"px";
    markObj.style.left = x+"px";
    //markObj.style.backgroundImage = "url(./share/images/centerMark.gif)";
    markObj.style.width = markW+"px";
    markObj.style.height = markH+"px";
    markObj.style.opacity = 0.5;
    map.getDiv().appendChild(markObj);
  }

  // �ޡ���������
  var iconAnchor = null;
  if(marker_img!='../share/images/icon_diary.gif'){
	iconAnchor = new google.maps.Point( 14, 14 );		// �����Ρִ������
  }
  if(marker_img=='../share/images/icon_diary.gif'){
	iconAnchor = new google.maps.Point( 14, 28 );		// �����Ρִ������
  }

  icon = new google.maps.MarkerImage(
  				marker_img,
  				new google.maps.Size(28, 28),
  				null,
  				iconAnchor
  );
  icon.infoWindowAnchor = new google.maps.Point( 14, 5 );	// ���󥦥���ɥ��δ����

  if(mkr_flg != 9){
	var mp = new google.maps.LatLng(keido, ido);
	var mopts = {
		position: mp,
		icon: icon,
		map: map
	}
	var mk = new google.maps.Marker(mopts);
	document.getElementById("marker_flg").value = 9;
  }

  google.maps.event.addListener(map, 'zoomend', function( oldZoomLevel , newZoomLevel ) {
	console.log(newZoomLevel);
	document.getElementById("zoomN").value = newZoomLevel;
  });

  if(modeData[4] == 1){
	map.disableDragging();
  }

  if(modeData[4] == 1){
    map.disableDragging();
  }

  if(modeData[5] == 1 && mkrY != "" && mkrX != "" && mkrName != "" ){

    for(i=0;i<point_lon.length;i++){
      var point = new google.maps.Point(point_lon[i],point_lat[i]);
//      var pophtml = '<div style="width: 80px;height:70px; font-size: 12px"><A HREF="'+address_val[i]+'" target="_BLANK">'+ken_name[i]+'</A></div>';
      if(modeData[6] == 0)var pophtml = '<table style="border-color: #ffffff;padding:0px" width="350px" height="120px"><tr style="border-color: #ffffff;padding:0px"><td style="border:0px;padding:0px" width="150px"><img src="'+image_name[i]+'"><br><a href="'+address_val[i]+'"><font size="2">�ܺ�</font></a>��<a href="'+tsuika_add[i]+'"><font size="2">�ɲ�</font></a></td><td align="left" style="border-color: #ffffff;padding:0px"><table width="215px" style="padding:0px"><tr style="padding:0px;border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF" width="215px"><td colspan="3" style="padding:0px;border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF"  width="215px"><A HREF="'+address_val[i]+'" target="_BLANK"><font size="2"><b>'+ken_name[i]+'</b></font></A></td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;padding:0px" width="215px"><td colspan="3" style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="215px">'+line_name[i]+'<br>'+sta_name[i]+'</td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;padding:0px" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="60px" align="left">�ּ��</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="5px" align="left">��</td><td align="left" style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="150px" align="left">'+madori[i]+'</td></tr><tr style="padding:0px" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="60px" align="left">����</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="5px" align="left">��</td><td align="left" style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="150px" align="left">'+price[i]+'��</td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;padding:0px" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="60px" align="left">��ͭ����</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="5px" align="left">��</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="150px" align="left">'+area[i]+'m<sup>2</sup></td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;padding:0px" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="60px" align="left">��������</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="5px" align="left">��</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="150px" align="left">'+vacant[i]+'</td></tr></table></td></tr></table>';
      if(modeData[6] == 1)var pophtml = '<table style="border-color: #ffffff;padding:0px" width="350px" height="120px"><tr style="border-color: #ffffff;padding:0px"><td style="border:0px;padding:0px" width="150px"><img src="'+image_name[i]+'"><br><a href="'+address_val[i]+'" target="_blank"><font size="2">�ܺ�</font></a></td><td align="left" style="border-color: #ffffff;padding:0px"><table width="215px" style="padding:0px"><tr style="padding:0px;border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF" width="215px"><td colspan="3" style="padding:0px;border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF"  width="215px"><A HREF="'+address_val[i]+'" target="_BLANK"><font size="2"><b>'+ken_name[i]+'</b></font></A></td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;padding:0px" width="215px"><td colspan="3" style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="215px">'+line_name[i]+'<br>'+sta_name[i]+'</td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;padding:0px" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="60px" align="left">�ּ��</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="5px" align="left">��</td><td align="left" style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="150px" align="left">'+madori[i]+'</td></tr><tr style="padding:0px" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="60px" align="left">����</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="5px" align="left">��</td><td align="left" style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="150px" align="left">'+price[i]+'��</td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;padding:0px" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="60px" align="left">��ͭ����</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="5px" align="left">��</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="150px" align="left">'+area[i]+'m<sup>2</sup></td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;padding:0px" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="60px" align="left">��������</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="5px" align="left">��</td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="150px" align="left">'+vacant[i]+'</td></tr></table></td></tr></table>';
//      if(modeData[6] == 1)var pophtml = '<table style="border-color: #ffffff" width="350px" height="120px"><tr style="border-color: #ffffff"><td style="border:0px" width="150px"><img src="'+image_name[i]+'"><br><a href="'+address_val[i]+'" target="_BLANK"><font size="2">�ܺ�</font></a></td><td align="left" style="border-color: #ffffff"><table width="215px"><tr style="padding:0px;border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF" width="215px"><td colspan="3" style="padding:0px;border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF"  width="215px"><A HREF="'+address_val[i]+'" target="_BLANK"><font size="2"><b>'+ken_name[i]+'</b></font></A></td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;padding:0px" width="215px"><td colspan="3" style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px;padding:0px" width="215px">'+line_name[i]+'<br>'+sta_name[i]+'</font></td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="60px" align="left">�ּ��</font></td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12pxy" width="5px" align="left">��</font></td><td align="left" style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12pxy" width="150px" align="left">'+madori[i]+'</font></td></tr><tr width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="60px" align="left">����</font></td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="5px" align="left">��</font></td><td align="left" style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="150px" align="left">'+price[i]+'��</font></td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="60px" align="left">��ͭ����</font></td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="5px" align="left">��</font></td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="150px" align="left">'+area[i]+'m<sup>2</sup></font></td></tr><tr style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF" width="215px"><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="60px" align="left">��������</font></td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="5px" align="left">��</font></td><td style="border:1px;border-style: dashed;border-bottom-color:#CCCCCC;border-top-color:#FFFFFF;font-size:12px" width="150px" align="left">'+vacant[i]+'</font></td></tr></table></td></tr></table>';
      var marker = show_marker(point,pophtml);
      map.addOverlay(marker);
    }
  }

}


/*------------------------------------------
	�ޡ����������ؿ�
------------------------------------------*/
function marker(marker_img,marker_shadow_img) {
  icon = new GIcon();
  icon.image = marker_img;
  icon.iconSize = new GSize( 28, 28 );	// �������礭��
      if(marker_img!='../share/images/icon_diary.gif'){
	icon.iconAnchor = new GPoint( 14, 14 );		// �����Ρִ������
      }
      if(marker_img=='../share/images/icon_diary.gif'){
	icon.iconAnchor = new GPoint( 14, 28 );		// �����Ρִ������
      }
  icon.infoWindowAnchor = new GPoint( 14, 5 );	// ���󥦥���ɥ��δ����

  map.clearOverlays();
  var x = (map.getCenter()).lng();
  var y = (map.getCenter()).lat();
  var mp = new GLatLng(y, x);
  var mk = new GMarker(mp,icon);
  map.addOverlay(mk);
  document.getElementById("marker_flg").value = 1;
  document.getElementById("mapX").value = x;
  document.getElementById("mapY").value = y;
}


/*------------------------------------------
	���긡������ư�ؿ�
------------------------------------------*/
function showAddress() {
  if (geocoder) {
    geocoder.getLatLng( document.getElementById("zip").value, function(point) {
      if (!point) {
        alert(document.getElementById("zip").value + " not found");
      } else {
        map.setCenter(point);
      }
    } );
  }
}


/*------------------------------------------
	�����ॢ�å״ؿ�
------------------------------------------*/
function zmup() {
	var zoomU = parseInt(document.getElementById("zoomN").value);
	zoomU++;
	map.setZoom(zoomU); 
}


/*------------------------------------------
	�����������ؿ�
------------------------------------------*/
function zmdown() {
	var zoomD = parseInt(document.getElementById("zoomN").value);
	zoomD--;
	map.setZoom(zoomD); 
}


/*------------------------------------------
	�濴���ְ�ư�ؿ�
------------------------------------------*/
function replace(mapX2,mapY2,zoomO) {

  if(zoomO != ""){
	var zoom = parseInt(zoomO);
  }else{
	var zoom = 12;
  }
  if(mapY2 == ""){
	var ido = 37;
  }else if(mapY2 % 1 != 0 ){
	var ido = parseFloat(mapY2);
  }else if(mapY2 % 1 == 0){
	var ido = parseInt(mapY2);
  }
  if(mapX2 == ""){
	var keido = 138;
  }else if(mapX2 % 1 != 0){
	var keido = parseFloat(mapX2);
  }else if(mapX2 % 1 == 0){
	var keido = parseInt(mapX2);
  }

  map.setCenter(new google.maps.LatLng(keido,ido),zoom);

/*
  if(zoomO != ""){
	var zoom = parseInt(zoomO);
  }else{
	var zoom = 12;
  }
  if(mapY2 == ""){
	var ido = 37;
  }else if(mapY2 % 1 != 0 ){
	var ido = parseFloat(mapY2);
  }else if(mapY2 % 1 == 0){
	var ido = parseInt(mapY2);
  }
  if(mapX2 == ""){
	var keido = 138;
  }else if(mapX2 % 1 != 0){
	var keido = parseFloat(mapX2);
  }else if(mapX2 % 1 == 0){
	var keido = parseInt(mapX2);
  }

  map.setCenter(new GLatLng(keido,ido),zoom);
*/
}


/*------------------------------------------
	�濴���ְ�ư�ؿ�(�������ͼ�ư����)
------------------------------------------*/
function replace_auto_zoom(mkrX,mkrY,flg) {
    point_lon = mkrY.split(",");
    point_lat = mkrX.split(",");
    for(i=0;i<point_lon.length;i++){
	if(i==0){
		if(point_lon[0] % 1 != 0){
			var maxY = parseFloat(point_lon[0]);
			var minY = parseFloat(point_lon[0]);
		}else if(point_lon[0] % 1 == 0){
			var maxY = parseInt(point_lon[0]);
			var minY = parseInt(point_lon[0]);
		}
		if(point_lat[0] % 1 != 0){
			var maxX = parseFloat(point_lat[0]);
			var minX = parseFloat(point_lat[0]);
		}else if(point_lat[0] % 1 == 0){
			var maxX = parseInt(point_lat[0]);
			var minX = parseInt(point_lat[0]);
		}
	}
	if(maxY < point_lon[i]){
		if(point_lon[i] % 1 != 0){
			maxY = parseFloat(point_lon[i]);
		}else if(point_lon[i] % 1 == 0){
			maxY = parseInt(point_lon[i]);
		}
	}
	if(maxX < point_lat[i]){
		if(point_lat[i] % 1 != 0){
			maxX = parseFloat(point_lat[i]);
		}else if(point_lat[i] % 1 == 0){
			maxX = parseInt(point_lat[i]);
		}
	}
	if(minY > point_lon[i]){
		if(point_lon[i] % 1 != 0){
			minY = parseFloat(point_lon[i]);
		}else if(point_lon[i] % 1 == 0){
			minY = parseInt(point_lon[i]);
		}
	}
	if(minX > point_lat[i]){
		if(point_lat[i] % 1 != 0){
			minX = parseFloat(point_lat[i]);
		}else if(point_lat[i] % 1 == 0){
			minX = parseInt(point_lat[i]);
		}
	}
    }
    var centerY = (maxY + minY)/2;
    var centerX = (maxX + minX)/2;
    if(centerY % 1 != 0){
	centerY = parseFloat(centerY);
    }else if(centerY % 1 == 0){
	centerY = parseInt(centerY);
    }
    if(centerX % 1 != 0){
	centerX = parseFloat(centerX);
    }else if(centerX % 1 == 0){
	centerX = parseInt(centerX);
    }

    var rectObj = new GLatLngBounds(new GLatLng(minX,minY), new GLatLng(maxX,maxY));
    var Rzm = map.getBoundsZoomLevel(rectObj);

    var zoom = parseInt(Rzm);
    document.getElementById("zoomN").value = Rzm;
    if(centerY % 1 != 0 ){
	var ido = parseFloat(centerY);
    }else if(centerY % 1 == 0){
	var ido = parseInt(centerY);
    }
    if(centerX % 1 != 0){
	var keido = parseFloat(centerX);
    }else if(centerX % 1 == 0){
	var keido = parseInt(centerX);
    }
    if(flg == '9'){
	zoom = parseInt(4);
	keido = parseFloat(36.87962060502676);
	ido = parseFloat(139.130859375);
    }

    map.setCenter(new GLatLng(keido,ido),zoom);

}

/*------------------------------------------
	�ޡ������դ��������٥�ȴؿ�
------------------------------------------*/
function show_marker(point,pophtml){

  var marker = new google.maps.Marker(point,icon);

  GEvent.addListener(marker, "click", function() {
    marker.openInfoWindowHtml(pophtml);
  });
  return marker;
}
