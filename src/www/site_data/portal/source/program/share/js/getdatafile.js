

//�ե�������ɤߡ�readyState���ͤ�����ν��֤˳�ǧ���ޤ�
function get_city( parts ){
	
	//XMLHttpRequest���֥�����������
	var res = createHttpRequest()

	//open �᥽�å�
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

	//send �᥽�å�
	res.send('');
}