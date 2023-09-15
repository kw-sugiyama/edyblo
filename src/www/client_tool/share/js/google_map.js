//<![CDATA[

window.onload = function() {
	geocoder = new GClientGeocoder();
	map = new GMap2(document.getElementById("gmap"));
	map.setCenter(new GLatLng(37, 138), 12);
	ctrlObj = new GLargeMapControl();
	map.addControl(ctrlObj);
	map.addControl(new GMapTypeControl());		//�Ҷ����Ͽ�+�̿��ѥͥ�
	map.addControl(new GOverviewMapControl());	//�����ξ������Ͽ�

	var markObj = document.createElement("div");
	var mapW = parseInt(map.getContainer().style.width);
	var mapH = parseInt(map.getContainer().style.height);
	var markW = 31; // ���󥿡��ޡ����β����ʥԥ��������
	var markH = 31; // ���󥿡��ޡ����ν����ʥԥ��������
	var x = (mapW - markW) / 2; // ���󥿡��ޡ������濴���֡�X��ɸ��
	var y = (mapH - markH) / 2; // ���󥿡��ޡ������濴���֡�Y��ɸ��
	markObj.style.position = "absolute";
	markObj.style.top = y+"px";
	markObj.style.left = x+"px";
	markObj.style.backgroundImage = "url(centerMark.gif)";
	markObj.style.width = markW+"px";
	markObj.style.height = markH+"px";
	markObj.style.opacity = 0.5;
	map.getContainer().appendChild(markObj);

	GEvent.addListener(map, "move", function(){
		var x = (map.getCenter()).lng();
		var y = (map.getCenter()).lat();
		document.getElementById("gmap_x").value = x;
		document.getElementById("gmap_y").value = y;
	} );
	GEvent.addListener(map, 'zoomend', function( newZoomLevel ) {
		document.getElementById("zm").value = newZoomLevel;
	});
	GEvent.addListener(map, "click",
		function(arg1, arg2){
		var marker = new GMarker(arg2);
		map.addOverlay(marker);
	} );

}


function showAddress( id_name ) {
	if (geocoder) {
		geocoder.getLatLng( document.getElementById(id_name).value, function(point) {
			if (!point) {
				alert(document.getElementById(id_name).value + " not found");
			} else {
				map.setCenter(point);
				var marker = new GMarker(point);
				map.addOverlay(marker);
			}
		} );
	}
}

//]]>
