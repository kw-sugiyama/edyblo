<?
/*
//��ǧ����HTML�����

$inquiry_checkbox���� ���䤤�礻����(���䤤�礻)
$request_checkbox���� ��Ϣ����ˡ(���䤤�礻��������/�����ڡ����䤤�礻)
$request_box��������������������(���䤤�礻��������/�����ڡ����䤤�礻)

$confirm_form1����������ǧHTML(���䤤�礻��������/�����ڡ����䤤�礻)

$hidden�������������� Hidden���ܤ������ܥ���

$question_box�������� ������ʤ�(����������)
$request_box�������������䤤�礻����(��������������)
$comment_box������������������

*/
session_start();//���å����˥����å�ȯ��
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

//����ǯ����������
if( $year == "" && $month == "" && $day == "" ){
	$year = "----";
	$month ="--";
	$day ="--";
}

//���䤤��碌����
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
	$inquiry_msg= "<tr><td><p class=\"marginlr1\">��</p></td></tr>";
}
$inquiry_checkbox='
<div class="box"><!--box start-->
<table  class="bordergray">
	<tr>
		<td class="paddinglr2 bggray">
			<p><em>���䤤��碌����</em></p>
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


//��Ϣ����ˡ
$request_line="";
$request_checkbox="";
if($demand1) $request_line="<tr><td><p class=\"marginlr1\"> ".$demand1."</p></td></tr>";
if($demand2) $request_line.= "<tr><td><p class=\"marginlr1\"> ".$demand2."</p></td></tr>";
if($demand3) $request_line.= "<tr><td><p class=\"marginlr1\"> ".$demand3."</p></td></tr>";
if($demand4) $request_line.= "<tr><td><p class=\"marginlr1\"> ".$demand4."</p></td></tr>";
if(!$demand1 && !$demand2 && !$demand3 && !$demand4 ){
	$request_line="<tr><td><p class=\"marginlr1\">��</p></td></tr>";
}
$request_checkbox='
<div class="box"><!--box start-->
<table  class="bordergray">
	<tr>
		<td class="paddinglr2 bggray">
			<p><em>��Ϣ����ˡ</em></p>
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

//����������
$inquiry=mb_eregi_replace("\r","</p><p class=\"marginlr1\">",$inquiry);
$request_msg="";
$request_box="";
if($inquiry){
	$request_msg.="<p class=\"marginlr1\"> ".$inquiry."</p>";
}else{
	$request_msg.="<p class=\"marginlr1\">��</p>";
}
$inquiry_box='
<div class="box"><!--box start-->
<table  class="bordergray">
<tr>
	<td class="paddinglr2 bggray">
		<p><em>����������</em></p>
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

//��ǯ
foreach($param_inq_gakunen["val"] as $key => $val) {
	if ($gakunen == ""){
		$gakunen_disp .= '';
	}else if ($gakunen==$key) {
		$gakunen_disp .= $val;
	} else {
		$gakunen_disp .= '';
	}
}

//����������������ǧHTML(���䤤�礻��������/�����ڡ����䤤�礻)��������������
$confirm_form="";
$confirm_form=
'
<div class="box"><!--box start-->
<table>
	<tr>
		<td class="tdform-a">
			<p><em>�����ͤλ�̾</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$kidsname_kj_1.' '.$kidsname_kj_2.'</p>
			<p>'.$kidsname_kn_1.' '.$kidsname_kn_2.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>������</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$sex.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>��ǯ����</em></p>
		</td>
		<td class="tdform-b">
			<p><span class="marginr1">'.$year.'ǯ</span><span class="marginr1">'.$month.'��</span><span class="marginr1">'.$day.'��</span></p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>��ǯ</em></p>
		</td>
		<td class="tdform-b">
			<p><span class="marginr1">'.$gakunen_disp.'</span><span class="marginr1">'.$gakunen_text.'</span></p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>���̤��γع�̾</em></p>
		</td>
		<td class="tdform-b">
			<p><span class="marginr1">'.$type.'</span><span class="marginr1">'.$school.'</span></p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>�ݸ�Ԥλ�̾</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$name_kj_1.' '.$name_kj_2.'</p>
			<p>'.$name_kn_1.' '.$name_kn_2.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>͹���ֹ�</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$addr_cd_1.'-'.$addr_cd_2.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>������</em></p>
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
			<p><em>�����ֹ�</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$tel.'</p>
			<p>'.$ctel.'</p>
		</td>
	</tr>
	<tr>
		<td class="tdform-a">
			<p><em>�᡼�륢�ɥ쥹</em></p>
		</td>
		<td class="tdform-b">
			<p>'.$mail.'</p>
		</td>
	</tr>
</table>
</div><!--box end-->

';

//HIDDEN���ͤ��Ǽ
$confirm="";
$confirm='<form method="post" action="complete.php?cl='.$obj_login->clientdat[0]['cl_urlcd'].'" onsubmit="return false">';
FOREACH( $_POST as $key => $val ){
	$confirm .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\" />\n";
}
//�����åȤ�HIDDEN�˳�Ǽ
$confirm .='<input type="hidden" name="ticket" value="'.htmlspecialchars(($_SESSION['ticket']), ENT_QUOTES).'" />';

$hidden="";
$hidden=$confirm;

//�䤤�礻
$button1='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="location.href=\''._BLOG_SITE_URL_BASE.'inquire/\'" alt="" />����
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//��������
$button2='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="location.href=\''._BLOG_SITE_URL_BASE.'req/\'" alt="" />����
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//�����ڡ��󿽤�����
$button3='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="document.campaignapplyback.submit(); return false" alt="" />����
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//�����ڡ����䤤�礻
$button4='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="document.campaigninqback.submit(); return false" alt="" />����
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//�������䤤�礻
$button5='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="document.courseinqback.submit(); return false" alt="" />����
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';
//��������������
$button6='
<div class="box"><!--box start-->
<p class="center"><input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="document.coursereqback.submit(); return false" alt="" />����
<input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>
</div><!--box end-->
';


//������ʤ�(��������)
$question_box="";
$question_box='
<div class="box"><!--box start-->
<table  class="bordergray">
<tr>
	<td class="paddinglr2 bggray">
		<p><em>������ʤ�</em></p>
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

//���䤤�礻����(��������������)
$request_box="";
$request_box='
<div class="box"><!--box start-->
<table  class="bordergray">
<tr>
	<td class="paddinglr2 bggray">
		<p><em>���䤤�礻����</em></p>
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

//��������(�����ڡ��󿽤�����)
$comment_box="";
$comment_box='
<div class="box"><!--box start-->
<table  class="bordergray">
<tr>
	<td class="paddinglr2 bggray">
		<p><em>��������</em></p>
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
