<?
/*HTML�ե���������

$inquiry_checkbox�����䤤��碌�ե�����
$request_checkbox����Ϣ���ե�����
$request_msg������ ���������ƥե�����
$inquiry_form1�� ���嵭�ȥ��åȤǻȤ��ե�����

$inquiry_form2�� �����������ѥե�����

$inquiry_form3�� �����������������ѥե�����

$inquiry_form4�� �������ڡ��󿽤������ѥե�����

$privacy���Ŀ;���ˤĤ���
*/
//�ѿ��Υ��ꥢ
$report1       = "";
$report2       = "";
$report3       = "";
$report4       = "";
$etc           = "";
$demand1       = "";
$demand2       = "";
$demand3       = "";
$demand4       = "";
$year          = "";
$month         = "";
$day           = "";
$gakunen       = "";
$sex           = "";
$pref          = "";
$kidsname_kj_1 = "";
$kidsname_kj_2 = "";
$kidsname_kn_1 = "";
$kidsname_kn_2 = "";
$type          = "";
$school        = "";
$name_kj_1     = "";
$name_kj_2     = "";
$name_kn_1     = "";
$name_kn_2     = "";
$addr_cd_1     = "";
$addr_cd_2     = "";
$city          = "";
$add           = "";
$buil          = "";
$tel           = "";
$ctel          = "";
$mail          = "";

session_start();
if(isset($_POST['session_unset'])){
		unset($_SESSION);
		unset($_POST);
}
session_write_close();
if(isset($_SESSION)){
	extract($_SESSION);
}

//���䤤��碌���ƥե�����

if($report1){
	$report1_msg='<p class="marginlr1"><input type="checkbox" name="report1" value="�������ˤĤ���" checked="checked" /><span class="marginlr2">�������ˤĤ���</span></p>';
}else{
	$report1_msg='<p class="marginlr1"><input type="checkbox" name="report1" value="�������ˤĤ���"/><span class="marginlr2">�������ˤĤ���</span></p>';
}
if($report2){
	$report2_msg='<p class="marginlr1"><input type="checkbox" name="report2" value="���٥�ȤˤĤ���" checked="checked" /><span class="marginlr2">���٥�ȤˤĤ���</span></p>';
}else{
	$report2_msg='<p class="marginlr1"><input type="checkbox" name="report2" value="���٥�ȤˤĤ���"/><span class="marginlr2">���٥�ȤˤĤ���</span></p>';
}
if($report3){
	$report3_msg='<p class="marginlr1"><input type="checkbox" name="report3" value="���ΤˤĤ���"checked="checked" /><span class="marginlr2">���ΤˤĤ���</span></p>';
}else{
	$report3_msg='<p class="marginlr1"><input type="checkbox" name="report3" value="���ΤˤĤ���"/><span class="marginlr2">���ΤˤĤ���</span></p>';
}
if($report4){
	$report4_msg='<p class="marginlr1"><input type="checkbox" name="report4" value="����¾" checked="checked" /><span class="marginlr2">����¾</span><input type="text" name="etc" size="60" value="'.$etc.'"/></p>';
}else{
	$report4_msg='<p class="marginlr1"><input type="checkbox" name="report4" value="����¾"/><span class="marginlr2">����¾</span><input type="text" name="etc" size="60" /></p>';
}
$inquiry_checkbox='
<div class="box"><!--box start-->
<table  class="bordergray">
	<tr>
		<td class="paddinglr2 bggray">
			<p><em>���䤤�礻����(ʣ�������å���)</em>��<span class="red small">ɬ��</span></p>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td>
						'.$report1_msg.'
					</td>
					<td>
						'.$report2_msg.'
					</td>
					<td>
						'.$report3_msg.'
					</td>
				</tr>
				<tr>
					<td colspan="3">
					'.$report4_msg.'
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</div><!--box end-->
';


if($demand1){
	$demand1_msg='<p class="marginlr1"><input type="checkbox" name="demand1" value="���������դ����ߤ���" checked="checked" /><span class="marginlr2">���������դ����ߤ���</span></p>';
}else{
	$demand1_msg='<p class="marginlr1"><input type="checkbox" name="demand1" value="���������դ����ߤ���"/><span class="marginlr2">���������դ����ߤ���</span></p>';
}
if($demand2){
	$demand2_msg='<p class="marginlr1"><input type="checkbox" name="demand2" value="�ܺ٤��Τꤿ���Τ����ä����ߤ���" checked="checked" /><span class="marginlr2">�ܺ٤��Τꤿ���Τ����ä����ߤ���</span></p>';
}else{
	$demand2_msg='<p class="marginlr1"><input type="checkbox" name="demand2" value="�ܺ٤��Τꤿ���Τ����ä����ߤ���"/><span class="marginlr2">�ܺ٤��Τꤿ���Τ����ä����ߤ���</span></p>';
}
if($demand3){
	$demand3_msg='<p class="marginlr1"><input type="checkbox" name="demand3" value="�ܺ٤��Τꤿ���Τ�ˬ�䤷����" checked="checked" /><span class="marginlr2">�ܺ٤��Τꤿ���Τ�ˬ�䤷����</span></p>';
}else{
	$demand3_msg='<p class="marginlr1"><input type="checkbox" name="demand3" value="�ܺ٤��Τꤿ���Τ�ˬ�䤷����"/><span class="marginlr2">�ܺ٤��Τꤿ���Τ�ˬ�䤷����</span></p>';
}
if($demand4){
	$demand4_msg='<p class="marginlr1"><input type="checkbox" name="demand4" value="�������Ƥ��������ߤ���" checked="checked" /><span class="marginlr2">�������Ƥ��������ߤ���</span></p>';
}else{
	$demand4_msg='<p class="marginlr1"><input type="checkbox" name="demand4" value="�������Ƥ��������ߤ���"/><span class="marginlr2">�������Ƥ��������ߤ���</span></p>';
}

//��Ϣ����ˡ�ե�����
$request_checkbox='
<div class="box"><!--box start-->
<table  class="bordergray">
<tr>
	<td class="paddinglr2 bggray">
		<p><em>��Ϣ����ˡ</em>��<span class="red small">ɬ��</span></p>
	</td>
</tr>
<tr>
	<td>
	<table>
		<tr>
			<td>
				'.$demand1_msg.'
			</td>
		</tr>
		<tr>
			<td>
				'.$demand2_msg.'
			</td>
		</tr>
		<tr>
			<td>
				'.$demand3_msg.'
			</td>
		</tr>
		<tr>
			<td>
				'.$demand4_msg.'
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>

</div><!--box end-->
';

//����������
$request_msg='
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
				<p class="center"><textarea name="inquiry" cols="65" rows="5" style="font-family:\'MS P�����å�\';font-size:10pt;width:98%;">'.htmlspecialchars($inquiry).'</textarea></p>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table>

</div><!--box end-->
';

//���ޤ�ǯ
$max="";
$min="";
$max=date("Y")-20;//�ǹ�ǯ��
$min=date("Y");//�Ǿ�ǯ��
$yearlist = '<option value="">---</option>';
for($max;$max<=$min;$max++){
	if($year==$max){
		$yearlist.='<option value="'.$max.'" selected>'.$max.'</option>';
	}else{
		$yearlist.='<option value="'.$max.'">'.$max.'</option>';
	}
}
//���ޤ��
$monthlist = '<option value="">---</option>';
for($cnt=1;$cnt<=12;$cnt++){
	if($month==$cnt){
		$monthlist.='<option value="'.$cnt.'" selected>'.$cnt.'</option>';
	}else{
		$monthlist.='<option value="'.$cnt.'">'.$cnt.'</option>';
	}
}
//���ޤ���
$daylist = '<option value="">---</option>';
for($cnt=1;$cnt<=31;$cnt++){
	if($day==$cnt){
		$daylist.='<option value="'.$cnt.'" selected>'.$cnt.'</option>';
	}else{
		$daylist.='<option value="'.$cnt.'">'.$cnt.'</option>';
	}
}

//��ǯ
$gakunenlist = '<option value="">---</option>';
foreach($param_inq_gakunen["val"] as $key => $val) {
	if ($gakunen == ""){
		$gakunenlist .= '<option value="'.$key.'">'.$val.'</option>';
	}else if ($gakunen==$key) {
		$gakunenlist .= '<option value="'.$key.'" selected>'.$val.'</option>';
	} else {
		$gakunenlist .= '<option value="'.$key.'">'.$val.'</option>';
	}
}

$sex_list="";
if($sex=="����"){
	$sex_list='<p><input type="radio" name="sex" value="����" checked="checked" /><span class="marginlr2">����</span><input type="radio" name="sex" value="����" /><span class="marginlr2">����</span></p>';
}elseif($sex=="����"){
	$sex_list='<p><input type="radio" name="sex" value="����" /><span class="marginlr2">����</span><input type="radio" name="sex" value="����" checked="checked" /><span class="marginlr2">����</span></p>';
}else{
	$sex_list='<p><input type="radio" name="sex" value="����" checked="checked" /><span class="marginlr2">����</span><input type="radio" name="sex" value="����" /><span class="marginlr2">����</span></p>';
}


$pref_rows=array("�̳�ƻ","�Ŀ���","��긩","�ܾ븩","���ĸ�",
				"������","ʡ�縩","��븩","���ڸ�","���ϸ�",
				"��̸�","���ո�","�����","�����","���㸩",
				"�ٻ���","���","ʡ�温","������","Ĺ�",
				"���츩","�Ų���","���θ�","���Ÿ�","���츩",
				"������","�����","ʼ�˸�","���ɸ�","�²λ���",
				"Ļ�踩","�纬��","������","���縩","������",
				"���縩","���","��ɲ��","���θ�","ʡ����",
				"���츩","Ĺ�긩","���ܸ�","��ʬ��","�ܺ긩",
				"�����縩","���츩");

$pref_list="";
$pref_list='<option value="">��ƻ�ܸ�</option>';
foreach($pref_rows as $key=>$val){
	if($pref==$val){
		$pref_list.='<option value="'.$val.'" selected>'.$val.'</option>';
	}else{
		$pref_list.='<option value="'.$val.'">'.$val.'</option>';
	}	
}




//���������������������䤤��碌�ϥե����ࢧ����������������
$inquiry_form1='

<div class="box"><!--box start-->
	<p>��Ϣ�������ξ���򤴵�����������</p>
	<table>
		<tr>
			<td rowspan="2" class="tdform-a">
				<p><em>�����ͤλ�̾</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p>��<input type="text" name="kidsname_kj_1" value="'.$kidsname_kj_1.'"/> ̾<input type="text" name="kidsname_kj_2" value="'.$kidsname_kj_2.'"/><span class="marginlr2">�ʴ�����</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-b">
				<p>��<input type="text" name="kidsname_kn_1" value="'.$kidsname_kn_1.'"/> ̾<input type="text" name="kidsname_kn_2" value="'.$kidsname_kn_2.'"/><span class="marginlr2">�ʥեꥬ��)</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�� ��</em></p>
			</td>
			<td class="tdform-b" >
				'.$sex_list.'
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>��ǯ����</em></p>
			</td>
			<td class="tdform-b">
				<p><select class="select1" name="year">
				'.$yearlist.'
				</select>
				<span class="marginr1">ǯ</span>
				<select name="month">
				'.$monthlist.'
				</select>
				<span class="marginr1">��</span>
				<select name="day">
				'.$daylist.'
				</select>
				<span class="marginr1">��</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>��ǯ</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b2">
				<p>
					<select name="gakunen">
						'.$gakunenlist.'
					</select>
					������¾��­����
					<input type="text" name="gakunen_text" value="' . $gakunen_text .'">
				</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>���̤��γع�̾</em></p>
			</td>
			<td class="tdform-b">
				<p><input type="text" name="type" value="'.$type.'"/><span class="marginr1">��Ω��</span><input type="text" name="school" value="'.$school.'" size="40" />
		<span class="marginr1"></span></p>
		<p>���㡧��Ω����Ω����Ω�ˡ��ʳع�̾��</p>
		</td>
		</tr>
		<tr>
			<td rowspan="2" class="tdform-a">
				<p><em>�ݸ�Ԥλ�̾</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p>��<input type="text" name="name_kj_1" value="'.$name_kj_1.'"/> ̾<input type="text" name="name_kj_2" value="'.$name_kj_2.'"/>
				<span class="marginlr2">�ʴ�����</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-b">
				<p>��<input type="text" name="name_kn_1" value="'.$name_kn_1.'"/> ̾<input type="text" name="name_kn_2" value="'.$name_kn_2.'"/>
				<span class="marginlr2">�ʥեꥬ�ʡ�</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>͹���ֹ�</em></p>
			</td>
			<td class="tdform-b">
				<p>�� <input name="addr_cd_1" type="text" size="3" maxlength="3" value="'.$addr_cd_1.'"/><span class="marginlr1">-</span><input name="addr_cd_2" type="text" size="4" maxlength="4" value="'.$addr_cd_2.'"/>
				<span class="postcode"><input type="button" value="�������" style="width:80px" onclick="return zipSearch1()" /></span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>����</em></p>
			</td>
			<td class="tdform-b">
				<p><select class="select2" name="pref">'.$pref_list.'</select></p>
				<p><input type="text" name="city" value="'.$city.'" size="50" /></p>
				<p>�����ԡ������衦����</p>
				<p><input type="text" name="add" value="'.$add.'" size="50"/></p>
				<p>Į̾����</p><p><input type="text" name="Buil" value="'.$Buil.'" size="50"/></p>
				<p>�ޥ󥷥�󡦥��ѡ���̾�������ֹ档</p>
				<p><span class="red small">���������դ򤴴�˾�����ϡ�ɬ������������������</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�����ֹ�</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p><input type="text" name="tel" value="'.$tel.'"/></p>
				<p><span class="marginlr2">�����ֹ�����03-��������-��������</span></p>
<!--
				<p><input type="text" name="ctel" value="'.$ctel.'"/>
				<span class="marginlr2">�����ֹ�����090-��������-��������</span></p>
				<p><span class="red small">�������ֹ�ޤ��Ϸ����ֹ�Τ����줫�ҤȤĤ򤴵�����������</span></p>
-->
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�᡼�륢�ɥ쥹</em></p>
			</td>
			<td class="tdform-b">
				<p>
					<span class="marginlr2"><input type="text" name="mail" value="'.$mail.'" size="50"/></span>
				</p>
				<p><span class="red small">���᡼����ֿ��򤴴�˾�����Ϥ�������������</span></p>
			</td>
		</tr>
	</table>
</div><!--box end-->
';

//���������������������������ѥե����ࢧ����������������
$inquiry_form2='

<div class="box"><!--box start-->
	<p>��������򤴴�˾�����Ϥ����ä��������λ�������ե���������Ѳ�������</p>
	<table>
		<tr>
			<td rowspan="2" class="tdform-a">
				<p><em>�����ͤλ�̾</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p>��<input type="text" name="kidsname_kj_1" value="'.$kidsname_kj_1.'"/> ̾<input type="text" name="kidsname_kj_2" value="'.$kidsname_kj_2.'"/><span class="marginlr2">�ʴ�����</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-b">
				<p>��<input type="text" name="kidsname_kn_1" value="'.$kidsname_kn_1.'"/> ̾<input type="text" name="kidsname_kn_2" value="'.$kidsname_kn_2.'"/><span class="marginlr2">�ʥեꥬ��)</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�� ��</em></p>
			</td>
			<td class="tdform-b" >
				'.$sex_list.'
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>��ǯ����</em></p>
			</td>
			<td class="tdform-b">
				<p><select class="select1" name="year">
				'.$yearlist.'
				</select>
				<span class="marginr1">ǯ</span>
				<select name="month">
				'.$monthlist.'
				</select>
				<span class="marginr1">��</span>
				<select name="day">
				'.$daylist.'
				</select>
				<span class="marginr1">��</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>��ǯ</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b2">
				<p>
					<select name="gakunen">
						'.$gakunenlist.'
					</select>
					������¾��­����
					<input type="text" name="gakunen_text" value="' . $gakunen_text .'">
				</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>���̤��γع�̾</em></p>
			</td>
			<td class="tdform-b">
				<p><input type="text" name="type" value="'.$type.'"/><span class="marginr1">��Ω��</span><input type="text" name="school" value="'.$school.'" size="40" />
		<span class="marginr1"></span></p>
		<p>���㡧��Ω����Ω����Ω�ˡ��ʳع�̾��</p>
		</td>
		</tr>
		<tr>
			<td rowspan="2" class="tdform-a">
				<p><em>�ݸ�Ԥλ�̾</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p>��<input type="text" name="name_kj_1" value="'.$name_kj_1.'"/> ̾<input type="text" name="name_kj_2" value="'.$name_kj_2.'"/>
				<span class="marginlr2">�ʴ�����</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-b">
				<p>��<input type="text" name="name_kn_1" value="'.$name_kn_1.'"/> ̾<input type="text" name="name_kn_2" value="'.$name_kn_2.'"/>
				<span class="marginlr2">�ʥեꥬ�ʡ�</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>͹���ֹ�</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b2">
				<p>�� <input name="addr_cd_1" type="text" size="3" maxlength="3" value="'.$addr_cd_1.'"/><span class="marginlr1">-</span><input name="addr_cd_2" type="text" size="4" maxlength="4" value="'.$addr_cd_2.'"/>
				<span class="postcode"><input type="button" value="�������" style="width:80px" onclick="return zipSearch1()" /></span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>����</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p><select class="select2" name="pref">'.$pref_list.'</select></p>
				<p><input type="text" name="city" value="'.$city.'" size="50"/></p>
				<p>�����ԡ������衦����</p>
				<p><input type="text" name="add" value="'.$add.'" size="50"/></p>
				<p>Į̾����</p><p><input type="text" name="Buil" value="'.$Buil.'" size="50"/></p>
				<p>�ޥ󥷥�󡦥��ѡ���̾�������ֹ档</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�����ֹ�</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p><input type="text" name="tel" value="'.$tel.'"/></p>
				<p><span class="marginlr2">�����ֹ�����03-��������-��������</span></p>
<!--
				<p><input type="text" name="ctel" value="'.$ctel.'"/></p>
				<span class="marginlr2">�����ֹ�����090-��������-��������</span></p>
				<p><span class="red small">�������ֹ�ޤ��Ϸ����ֹ�Τ����줫�ҤȤĤ򤴵�����������</span></p>
-->
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�᡼�륢�ɥ쥹</em></p>
			</td>
			<td class="tdform-b">
				<p>
					<span class="marginlr2"><input type="text" name="mail" value="'.$mail.'" size="50"/></span>
				</p>
				<p><span class="red small">���᡼����ֿ��򤴴�˾�����Ϥ�������������</span></p>
			</td>
		</tr>
	</table>
</div><!--box end-->
	
<div class="box"><!--box start-->
	<table  class="bordergray">
		<tr>
			<td class="paddinglr2 bggray">
				<p><em>������ʤɤ������ޤ����顢�����ڤˤ�������������</em></p>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td>
							<p class="center"><textarea name="inquiry" cols="65" rows="5" style="font-family:\'MS P�����å�\';font-size:10pt;width:98%;">'.htmlspecialchars($inquiry).'</textarea></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div><!--box end-->
';



//�������������������������������ᢧ����������������
$inquiry_form3='

<div class="box"><!--box start-->
	<p>��Ϣ�������ξ���򤴵�����������</p>
	<table>
		<tr>
			<td rowspan="2" class="tdform-a">
				<p><em>�����ͤλ�̾</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p>��<input type="text" name="kidsname_kj_1" value="'.$kidsname_kj_1.'"/> ̾<input type="text" name="kidsname_kj_2" value="'.$kidsname_kj_2.'"/><span class="marginlr2">�ʴ�����</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-b">
				<p>��<input type="text" name="kidsname_kn_1" value="'.$kidsname_kn_1.'"/> ̾<input type="text" name="kidsname_kn_2" value="'.$kidsname_kn_2.'"/><span class="marginlr2">�ʥեꥬ��)</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�� ��</em></p>
			</td>
			<td class="tdform-b" >
				'.$sex_list.'
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>��ǯ����</em></p>
			</td>
			<td class="tdform-b">
				<p><select class="select1" name="year">
				'.$yearlist.'
				</select>
				<span class="marginr1">ǯ</span>
				<select name="month">
				'.$monthlist.'
				</select>
				<span class="marginr1">��</span>
				<select name="day">
				'.$daylist.'
				</select>
				<span class="marginr1">��</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>��ǯ</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b2">
				<p>
					<select name="gakunen">
						'.$gakunenlist.'
					</select>
					������¾��­����
					<input type="text" name="gakunen_text" value="' . $gakunen_text .'">
				</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>���̤��γع�̾</em></p>
			</td>
			<td class="tdform-b">
				<p><input type="text" name="type" value="'.$type.'"/><span class="marginr1">��Ω��</span><input type="text" name="school" value="'.$school.'" size="40" />
		<span class="marginr1"></span></p>
		<p>���㡧��Ω����Ω����Ω�ˡ��ʳع�̾��</p>
		</td>
		</tr>
		<tr>
			<td rowspan="2" class="tdform-a">
				<p><em>�ݸ�Ԥλ�̾</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p>��<input type="text" name="name_kj_1" value="'.$name_kj_1.'"/> ̾<input type="text" name="name_kj_2" value="'.$name_kj_2.'"/>
				<span class="marginlr2">�ʴ�����</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-b">
				<p>��<input type="text" name="name_kn_1" value="'.$name_kn_1.'"/> ̾<input type="text" name="name_kn_2" value="'.$name_kn_2.'"/>
				<span class="marginlr2">�ʥեꥬ�ʡ�</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>͹���ֹ�</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b2">
				<p>�� <input name="addr_cd_1" type="text" size="3" maxlength="3" value="'.$addr_cd_1.'"/><span class="marginlr1">-</span><input name="addr_cd_2" type="text" size="4" maxlength="4" value="'.$addr_cd_2.'"/>	
				<span class="postcode"><input type="button" value="�������" style="width:80px" onclick="return zipSearch1()" /></span></p>
			</td>
		</tr>
		<tr>
		<td class="tdform-a">
			<p><em>����</em></p>
			<p><span class="red small">ɬ��</span></p>
		</td>
			<td class="tdform-b">
				<p><select class="select2" name="pref">'.$pref_list.'</select></p>
				<p><input type="text" name="city" value="'.$city.'" size="50"/></p>
				<p>�����ԡ������衦����</p>
				<p><input type="text" name="add" value="'.$add.'" size="50"/></p>
				<p>Į̾����</p><p><input type="text" name="Buil" value="'.$Buil.'" size="50"/></p>
				<p>�ޥ󥷥�󡦥��ѡ���̾�������ֹ档</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�����ֹ�</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p><input type="text" name="tel" value="'.$tel.'"/></p>
				<p><span class="marginlr2">�����ֹ�����03-��������-��������</span></p>
<!--
				<p><input type="text" name="ctel" value="'.$ctel.'"/>
				<span class="marginlr2">�����ֹ�����090-��������-��������</span></p>
				<p><span class="red small">�������ֹ�ޤ��Ϸ����ֹ�Τ����줫�ҤȤĤ򤴵�����������</span></p>
-->
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�᡼�륢�ɥ쥹</em></p>
			</td>
			<td class="tdform-b">
				<p><span class="marginlr2"><input type="text" name="mail" value="'.$mail.'" size="50"/></span></p>
				<p><span class="red small">���᡼����ֿ��򤴴�˾�����Ϥ�������������</span></p>

			</td>
		</tr>
	</table>
</div><!--box end-->

<div class="box"><!--box start-->
	<table  class="bordergray">
		<tr>
			<td class="paddinglr2 bggray">
				<p><em>���䤤��碌�����Ƥ򤪽񤭲�������</em></p>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td>
							<p class="center"><textarea name="inquiry" cols="65" rows="5" style="font-family:\'MS P�����å�\';font-size:10pt;width:98%;">'.htmlspecialchars($inquiry).'</textarea></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div><!--box end-->

';

//�����������������������ڡ��󿽤����ߢ�����������������
$inquiry_form4='

<div class="box"><!--box start-->
	<p>��Ϣ�������ξ���򤴵�����������</p>
	<table>
		<tr>
			<td rowspan="2" class="tdform-a">
				<p><em>�����ͤλ�̾</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p>��<input type="text" name="kidsname_kj_1" value="'.$kidsname_kj_1.'"/> ̾<input type="text" name="kidsname_kj_2" value="'.$kidsname_kj_2.'"/><span class="marginlr2">�ʴ�����</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-b">
				<p>��<input type="text" name="kidsname_kn_1" value="'.$kidsname_kn_1.'"/> ̾<input type="text" name="kidsname_kn_2" value="'.$kidsname_kn_2.'"/><span class="marginlr2">�ʥեꥬ��)</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�� ��</em></p>
			</td>
			<td class="tdform-b" >
				'.$sex_list.'
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>��ǯ����</em></p>
			</td>
			<td class="tdform-b">
				<p><select class="select1" name="year">
				'.$yearlist.'
				</select>
				<span class="marginr1">ǯ</span>
				<select name="month">
				'.$monthlist.'
				</select>
				<span class="marginr1">��</span>
				<select name="day">
				'.$daylist.'
				</select>
				<span class="marginr1">��</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>��ǯ</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b2">
				<p>
					<select name="gakunen">
						'.$gakunenlist.'
					</select>
					������¾��­����
					<input type="text" name="gakunen_text" value="' . $gakunen_text .'">
				</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>���̤��γع�̾</em></p>
			</td>
			<td class="tdform-b">
				<p><input type="text" name="type" value="'.$type.'"/><span class="marginr1">��Ω��</span><input type="text" name="school" value="'.$school.'" size="40" />
		<span class="marginr1"></span></p>
		<p>���㡧��Ω����Ω����Ω�ˡ��ʳع�̾��</p>
		</td>
		</tr>
		<tr>
			<td rowspan="2" class="tdform-a">
				<p><em>�ݸ�Ԥλ�̾</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p>��<input type="text" name="name_kj_1" value="'.$name_kj_1.'"/> ̾<input type="text" name="name_kj_2" value="'.$name_kj_2.'"/>
				<span class="marginlr2">�ʴ�����</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-b">
				<p>��<input type="text" name="name_kn_1" value="'.$name_kn_1.'"/> ̾<input type="text" name="name_kn_2" value="'.$name_kn_2.'"/>
				<span class="marginlr2">�ʥեꥬ�ʡ�</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>͹���ֹ�</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b2">
				<p>�� <input name="addr_cd_1" type="text" size="3" maxlength="3" value="'.$addr_cd_1.'"/><span class="marginlr1">-</span><input name="addr_cd_2" type="text" size="4" maxlength="4" value="'.$addr_cd_2.'"/>
				<span class="postcode"><input type="button" value="�������" style="width:80px" onclick="return zipSearch1()" /></span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>����</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p><select class="select2" name="pref">'.$pref_list.'</select></p>
				<p><input type="text" name="city" value="'.$city.'" size="50"/></p>
				<p>�����ԡ������衦����</p>
				<p><input type="text" name="add" value="'.$add.'" size="50"/></p>
				<p>Į̾����</p><p><input type="text" name="Buil" value="'.$Buil.'" size="50"/></p>
				<p>�ޥ󥷥�󡦥��ѡ���̾�������ֹ档</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�����ֹ�</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b2">
				<p><input type="text" name="tel" value="'.$tel.'"/></p>
				<p><span class="marginlr2">�����ֹ�����03-��������-��������</span></p>
<!--
				<p><input type="text" name="ctel" value="'.$ctel.'"/>
				<span class="marginlr2">�����ֹ�����090-��������-��������</span></p>
				<p><span class="red small">�������ֹ�ޤ��Ϸ����ֹ�Τ����줫�ҤȤĤ򤴵�����������</span></p>
-->
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p><em>�᡼�륢�ɥ쥹</em></p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b2">
				<p>
					<span class="marginlr2"><input type="text" name="mail" value="'.$mail.'" size="50"/></span>
				</p>
			</td>
		</tr>
	</table>
</div><!--box end-->

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
							<p class="center"><textarea name="inquiry" cols="65" rows="5" style="font-family:\'MS P�����å�\';font-size:10pt;width:98%;">'.htmlspecialchars($inquiry).'</textarea></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div><!--box end-->

';

$privacy="";
if($arrHeaderView['sc_privacy']){
	$privacy='
<div class="box"><!--box start-->
	<table>
		<tr>
			<td class="paddinglr2 bggray">
				<p><em>�Ŀ;���μ谷���ˤĤ���</em></p>
			</td>
		</tr>
		<tr>
			<td class="bordergray">
				<p class="center">
					<textarea name="textarea" cols="65" rows="10" readonly="readonly" style="font-family:\'MS P�����å�\';font-size:10pt;width:98%;">'.$arrHeaderView['sc_privacy'].'</textarea>
				</p>
			</td>
		</tr>
	</table>
</div><!--box end-->

<div class="box"><!--box start-->
	<table>
		<tr>
			<td class="paddinglr2 bggray">
				<p><em>�ָĿ;���μ谷�ˤĤ��ơפ�Ʊ�դ�����������ϡ���Ʊ�դ���פ˥����å�������Ƥ�������</em></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-b">
				<p class="marginlr1">
					<input type="checkbox" name="privacy" value="1" /><span class="marginlr2">Ʊ�դ���</span>
				</p>
			</td>
		</tr>
	</table>
</div><!--box end-->
';
}

//���䤤�礻�ѥܥ���
$button1="";
$button1='
<div class="box"><!--box start-->
	<p class="center">
		<input type="image" src="share/images/bt_kakunin2'.$img_color.'.gif" alt="" onmouseover="this.src=\'share/images/bt_kakunin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_kakunin2'.$img_color.'.gif\'" onclick="return inquiry_input_check1( this.form , this.form )" />
	</p>
</div><!--box end-->
';

//�������������ڡ����䤤�礻
$button2="";
$button2='
<div class="box"><!--box start-->
	<p class="center">
		<input type="image" src="share/images/bt_kakunin2'.$img_color.'.gif" alt="" onmouseover="this.src=\'share/images/bt_kakunin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_kakunin2'.$img_color.'.gif\'" onclick="return inquiry_input_check2( this.form , this.form )" />
	</p>
</div><!--box end-->
';

//�������ᡢ��������������
$button3="";
$button3='
<div class="box"><!--box start-->
	<p class="center">
		<input type="image" src="share/images/bt_kakunin2'.$img_color.'.gif" alt="" onmouseover="this.src=\'share/images/bt_kakunin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_kakunin2'.$img_color.'.gif\'" onclick="return inquiry_input_check3( this.form , this.form )" />
	</p>
</div><!--box end-->
';

//�����ڡ��󿽤������ѥܥ���
$button4="";
$button4='
<div class="box"><!--box start-->
	<p class="center">
		<input type="image" src="share/images/bt_kakunin2'.$img_color.'.gif" alt="" onmouseover="this.src=\'share/images/bt_kakunin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_kakunin2'.$img_color.'.gif\'" onclick="return inquiry_input_check4( this.form , this.form )" />
	</p>
</div><!--box end-->
';
?>