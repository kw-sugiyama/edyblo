<?php 
//携帯でGoogleMapの画像をプリントするクラス 
class GoogleMobileMapView{ 
//取得URLとクエリを保持する変数 
	var $geturl = 'http://maps.google.com/staticmap?'; 
	var $query  = ""; 
	//画像を取得するためのURLをセットするメソッド 
	function setUrl($latitude,$longitude,$settings,$points,$api_key) { 
		//中心の位置がない場合はfalseを返す 
		if( $latitude == "" || $longitude == "" || $api_key== ""){ 
			return false; 
		} 
		$this->query = $this->geturl . "center=$latitude,$longitude"; 
		//画像を取得するためのパラメータをセットしていく 
		
		if(!isset($settings["w"])) $settings["w"] = 200; 
		if(!isset($settings["h"])) $settings["h"] = 200; 
		if(!isset($settings["z"])) $settings["z"] = 12; 
		$this->query  .= "&size={$settings["w"]}x{$settings["h"]}"; 
		$this->query  .= "&zoom={$settings["z"]}"; 
		
		//出力形式をセット（デフォルトはGIF 
		$this->query  .= "&maptype=roadmap"; 
		
		//複数のポイントを表示するのにも対応させる 
		/*
		if(!is_array($points)) return true; 
		$cnt=0;
		
		
		foreach( $points as $key=>$point ){ 
			if(!isset($point["latitude"]) || !isset($point["longitude"])) continue; 
			if(!isset($point["iconid"]) ) $point["iconid"] = red; 
			if($cnt==0){
				$this->query .= "&markers={$point["latitude"]},{$point["longitude"]},{$point["iconid"]}";
			}else{
				$this->query .= "l{$point["latitude"]},{$point["longitude"]},{$point["iconid"]}";
			}
		}*/
//追加行　ここから
		$this->query .= "&markers=$latitude,$longitude"; 
		$this->query .= ",blue";
//追加行　ここまで
		$this->query .= "&key=".$api_key;
		return $this->query;
	}
}
?>
