//<![CDATA[

window.onload = function() {
	geocoder = new GClientGeocoder();
	map = new GMap2(document.getElementById("gmap"));
	map.setCenter(new GLatLng(37, 138), 12);
	ctrlObj = new GLargeMapControl();
	map.addControl(ctrlObj);
	map.addControl(new GMapTypeControl());		//航空、地図+写真パネル
	map.addControl(new GOverviewMapControl());	//右下の小さい地図

	var markObj = document.createElement("div");
	var mapW = parseInt(map.getContainer().style.width);
	var mapH = parseInt(map.getContainer().style.height);
	var markW = 31; // センターマークの横幅（ピクセル数）
	var markH = 31; // センターマークの縦幅（ピクセル数）
	var x = (mapW - markW) / 2; // センターマークの中心位置（X座標）
	var y = (mapH - markH) / 2; // センターマークの中心位置（Y座標）
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
