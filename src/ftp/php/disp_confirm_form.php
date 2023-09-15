<?
/*
//確認画面HTMLを作成

$inquiry_checkbox　　 お問い合せ内容(お問い合せ)
$request_checkbox　　 ご連絡方法(お問い合せ・コース/キャンペーンお問い合せ)
$request_box　　　　　ご質問内容(お問い合せ・コース/キャンペーンお問い合せ)

$confirm_form1　　　　確認HTML(お問い合せ・コース/キャンペーンお問い合せ)

$hidden　　　　　　　 Hidden項目と送信ボタン

$question_box　　　　 ご質問など(資料請求用)
$request_box　　　　　お問い合せ内容(コース資料請求)
$comment_box　　　　　コメント欄

*/
session_start();//セッションにチケット発行
foreach($_SESSION as $key=>$val){
	$_SESSION[$key]="";
}
if(isset($_POST)){
	foreach($_POST as $key=>$val){
		$_SESSION[$key]=stripslashes($_POST[$key]);
	}	
$_SESSION['ticket']=md5(uniqid().mt_rand());
}
session_write_close();

if(isset($_POST)){
	foreach($_POST as $key=>$val){
		$$key=htmlspecialchars($val);
		$$key=stripslashes($$key);
	}
}

//　生年月日の整形
if( $year == "" && $month == "" && $day == "" ){
	$year = "----";
	$month ="--";
	$day ="--";
}

//お問い合わせ内容
$inquiry_msg="";
$inquiry_checkbox="";
if($report1) $inquiry_msg= "<tr><td><p class=\"marginlr1\"> ".$report1."</p></td></tr>";
if($report2) $inquiry_msg.= "<tr><td><p class=\"marginlr1\">".$report2."</p></td></tr>";
if($report3) $inquiry_msg.= "<tr><td><p class=\"marginlr1\">".$report3."</p></td></tr>";
if($report4) {
	$inquiry_msg.= "<tr><td><p class=\"marginlr1\">".$report4."</p>";
	$inquiry_msg.= "<p class=\"marginlr1\">".$etc."</p></td></tr>";
}
if(!$report1 && !$report2 && !$report3 && !$report4 && !$etc){
	$inquiry_msg= "<tr><td><p class=\"marginlr1\">　</p></td></tr>";
}
$inquiry_checkbox='
<div class="box"><!--box start-->
<table  class="bordergray">
	<tr>
		<td class="paddinglr2 bggray">
			<p><em>お問い合わせ内容</em></p>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				'.$inquiry_msg.'
			</table>
		</td>
	</tr>
</table>

</div><!--box end-->
';


//ご連絡方法
$request_line="";
$request_checkbox="";
if($demand1) $request_line="<tr><td><p class=\"marginlr1\"> ".$demand1."</p></td></tr>";
if($demand2) $request_line.= "<tr><td><p class=\"marginlr1\"> ".$demand2."</p></td></tr>";
if($demand3) $request_line.= "<tr><td><p class=\"marginlr1\"> ".$demand3."</p></td></tr>";
if($demand4) $request_line.= "<tr><td><p class=\"marginlr1\"> ".$demand4."</p></td></tr>";
if(!$demand1 && !$demand2 && !$demand3 && !$demand4 ){
	$request_line="<tr><td><p class=\"marginlr1\">　</p></td></tr>";
}
$request_checkbox='
<div class="box"><!--box start-->
<table  class="bordergray">
	<tr>
		<td class="paddinglr2 bggray">
			<p><em>ご連絡方法</em></p>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				'.$request_line.'
			</table>
		</td>
	</tr>
</table>

</div><!--box end-->
';

//ご質問内容
$inquiry=mb_eregi_replace("\r","</p><p class=\"marginlr1\">",$inquiry);
$request_msg="";
$request_box="";
if($inquiry){
	$request_msg.="<p class=\"marginlr1\"> ".$inquiry."</p>";
}else{
	$request_msg.="<p class=\"marginlr1\">　</p>";
}
$inquiry_box='
<div class="box"><!--box start-->
<table  class="bordergray">
<tr>
	<td class="paddinglr2 bggray">
		<p><em>ご質問内容</em></p>
	</td>
</tr>
<tr>
	<td>
	<table>
		<tr>
			<td>
				'.$request_msg.'
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>

</div><!--box end-->
';

//学年
foreach($param_inq_gakunen["val"] as $key => $val) {
	if ($gakunen == ""){
		$gakunen_disp .= '';
	}else if ($gakunen==$key) {
		$gakunen_disp .= $val;
	} else {
		$gakunen_disp .= '';
	}
}

//▼▼▼▼▼▼▼確認HTML(お問い合せ・コース/キャンペーンお問い合せ)▼▼▼▼▼▼▼
$confirm_form="";
$confirm_form=
'
<div class="box"><!--box start-->
<table>
	<tr>
		<td class="tdform-a">
			<p><em>お子様の氏名</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$kidsname_kj_1.' '.$kidsname_kj_2.'</p>
			<p>'.$kidsname_kn_1.' '.$kidsname_kn_2.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>性　別</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$sex.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>生年月日</em></p>
		</td>
		<td class="tdform-b">
			<p><span class="marginr1">'.$year.'年</span><span class="marginr1">'.$month.'月</span><span class="marginr1">'.$day.'日</span></p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>学年</em></p>
		</td>
		<td class="tdform-b">
			<p><span class="marginr1">'.$gakunen_disp.'</span><span class="marginr1">'.$gakunen_text.'</span></p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>お通いの学校名</em></p>
		</td>
		<td class="tdform-b">
			<p><span class="marginr1">'.$type.'</span><span class="marginr1">'.$school.'</span></p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>保護者の氏名</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$name_kj_1.' '.$name_kj_2.'</p>
			<p>'.$name_kn_1.' '.$name_kn_2.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>郵便番号</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$addr_cd_1.'-'.$addr_cd_2.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>住　所</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$pref.'</p>
			<p>'.$city.'</p>
			<p>'.$add.'</p>
			<p>'.$Buil.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>電話番号</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$tel.'</p>
			<p>'.$ctel.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>メールアドレス</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$mail.'</p>
		</td>
	</tr>
</table>
</div><!--box end-->

';

//HIDDENに値を格納
$confirm="";
$confirm='<form method="post" action="complete.php?cl='.$obj_login->clientdat[0]['cl_urlcd'].'" onsubmit="return false">';
FOREACH( $_POST as $key => $val ){
	$confirm .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\" />\n";
}
//チケットをHIDDENに格納
$confirm .='<input type="hidden" name="ticket" value="'.htmlspecialchars(($_SESSION['ticket']), ENT_QUOTES).'" />';

$hidden="";
$hidden=$confirm;

//問い合せ
$button1='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="location.href=\''._BLOG_SITE_URL_BASE.'inquire/\'" alt="" />　　
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//資料請求
$button2='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="location.href=\''._BLOG_SITE_URL_BASE.'req/\'" alt="" />　　
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//キャンペーン申し込み
$button3='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="document.campaignapplyback.submit(); return false" alt="" />　　
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//キャンペーン問い合せ
$button4='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="document.campaigninqback.submit(); return false" alt="" />　　
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//コース問い合せ
$button5='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="document.courseinqback.submit(); return false" alt="" />　　
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//コース資料請求
$button6='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="document.coursereqback.submit(); return false" alt="" />　　
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';


//ご質問など(資料請求)
$question_box="";
$question_box='
<div class="box"><!--box start-->
<table  class="bordergray">
<tr>
	<td class="paddinglr2 bggray">
		<p><em>ご質問など</em></p>
	</td>
</tr>
<tr>
	<td>
	<table>
		<tr>
			<td>
				'.$request_msg.'
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>

</div><!--box end-->
';

//お問い合せ内容(コース資料請求)
$request_box="";
$request_box='
<div class="box"><!--box start-->
<table  class="bordergray">
<tr>
	<td class="paddinglr2 bggray">
		<p><em>お問い合せ内容</em></p>
	</td>
</tr>
<tr>
	<td>
	<table>
		<tr>
			<td>
				'.$request_msg.'
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>

</div><!--box end-->
';

//コメント欄(キャンペーン申し込み)
$comment_box="";
$comment_box='
<div class="box"><!--box start-->
<table  class="bordergray">
<tr>
	<td class="paddinglr2 bggray">
		<p><em>コメント欄</em></p>
	</td>
</tr>
<tr>
	<td>
	<table>
		<tr>
			<td>
				'.$request_msg.'
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>

</div><!--box end-->
';

?>
