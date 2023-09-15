

//ファイルを読み、readyStateの値を処理の順番に確認します
function get_city( parts ){
	
	//XMLHttpRequestオブジェクト生成
	var res = createHttpRequest()

	//open メソッド
	res.open("POST", "./portal_city_select.php?prefcd="+parts, "true" );

	var city_list = "";

	res.onreadystatechange = function(){
		if (res.readyState==4){
			oj = document.getElementById("city");
			oj.innerHTML  = res.responseText; 
		}else{
			oj = document.getElementById("city");
			oj.innerHTML = "<font color=\"#FF0000\" size=\"2\"><b>Wait.....</b></font>";
		}
	}

	//send メソッド
	res.send('');
}