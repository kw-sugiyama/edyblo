<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/inquiry/">����礻</a></strong><span class="paddinglr1">&gt;</span><strong>�ۡ���ڡ�������������ǺܤˤĤ���</strong></p><!--topic path-->

<h3>����礻���ۡ���ڡ�������������ǺܤˤĤ���</h3><!--search start-->
<FORM name="juku_inquiry_confirm" method="POST" action="<?=$param_base_blog_addr_url?>/juku_inquiry/confirm.html" target="_self">
<div class="box7">
	<div class="box8">
		<table>
		<tr>
			<td class="tdform-a">
				<p>����礻���Ƥ�<br>
				���򤷤Ʋ�������</p>
			</td>
			<td class="tdform-b">
				<p><input type="checkbox" name="title[0]" value="1" <?=$arrViewData["title"][0]?> >&nbsp;�Υ�����ηǺܤˤĤ���</p>
				<p><input type="checkbox" name="title[1]" value="1" <?=$arrViewData["title"][1]?> >&nbsp;�Хʡ����������ηǺܤˤĤ���</p>
				<p><input type="checkbox" name="title[2]" value="1" <?=$arrViewData["title"][2]?> >&nbsp;�ۡ���ڡ��������ˤĤ���
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="title[3]" value="1" <?=$arrViewData["title"][3]?> >&nbsp;����¾</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>����˾���Ƥ�<br>
				���򤷤Ʋ�������</p>
			</td>
			<td class="tdform-b">
				<p><input type="checkbox" name="device[0]" value="1" <?=$arrViewData["device"][0]?> >&nbsp;���������դ����ߤ���</p>
				<p><input type="checkbox" name="device[1]" value="1" <?=$arrViewData["device"][1]?> >&nbsp;�ܺ٤��Τꤿ���Τ����ä����ߤ���</p>
				<p><input type="checkbox" name="device[2]" value="1" <?=$arrViewData["device"][2]?> >&nbsp;�ܺ٤��Τꤿ���Τ���Ҥ����ߤ���</p>
				<p><input type="checkbox" name="device[3]" value="1" <?=$arrViewData["device"][3]?> >&nbsp;�������Ƥ��������ߤ���</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>����礻����</p>
			</td>
			<td class="tdform-b">
				<textarea name="contents" cols="35" rows="10"><?=$_POST['contents']?></textarea>
			</td>
		</tr>
		</table>

		<p class="margint5 red">ˡ�ͤξ��ϲ��̾��������̾�������ꡢ��Ϣ���������ֹ�򤴵�����������</p>
		<table>
		<tr>
			<td class="tdform-a">
				<p>��̾��</p>
				<p><span class="red small">ɬ��</span></p>
			</td>
			<td class="tdform-b">
				<p><input name="name_kj_1" type="text" value="<?=$_POST['name_kj_1']?>" ></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>�եꥬ��</p>
			</td>
			<td class="tdform-b">
				<p><input name="name_kn_1" type="text" value="<?=$_POST['name_kn_1']?>" >&nbsp;<span class="red">�����ѥ�������)</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>�᡼�륢�ɥ쥹</p>
				<p class="red small">ɬ��</p>
			</td>
			<td class="tdform-b">
				<p><input type="text" name="email" value="<?=$_POST['email']?>" >
				&nbsp;<span class="red">��Ⱦ�ѱѿ���)</span></p>
				<p>���㡧����@����com��</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>ˡ��̾</p></td>
				 <td class="tdform-b">
				<p><input name="corporation" type="text" value="<?=$_POST['corporation']?>" ></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>����̾</p>
			</td>
			<td class="tdform-b">
				<p><input name="post" type="text" value="<?=$_POST['post']?>" ></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>��̾</p>
			</td>
			<td class="tdform-b">
				<p><input name="position" type="text" value="<?=$_POST['position']?>" ></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>����</p>
			</td>
			<td class="tdform-b">
				<p>��&nbsp; <input name="addr_cd_1" type="text" size="5" maxlength="3" value="<?=$_POST['addr_cd_1']?>">&nbsp;-&nbsp;<input name="addr_cd_2" type="text" size="5" maxlength="4" value="<?=$_POST['addr_cd_2']?>">&nbsp;<span class="red">��Ⱦ�ѱѿ���)</span></p>
				<br>
				<p><select class="select2" name="pref">
					<option value="0">��ƻ�ܸ�</option>
					<option value="1"  <?=$arrPrefSel[1]?>  ><?=$psel[1]?></option>
					<option value="2"  <?=$arrPrefSel[2]?>  ><?=$psel[2]?></option>
					<option value="3"  <?=$arrPrefSel[3]?>  ><?=$psel[3]?></option>
					<option value="4"  <?=$arrPrefSel[4]?>  ><?=$psel[4]?></option>
					<option value="5"  <?=$arrPrefSel[5]?>  ><?=$psel[5]?></option>
					<option value="6"  <?=$arrPrefSel[6]?>  ><?=$psel[6]?></option>
					<option value="7"  <?=$arrPrefSel[7]?>  ><?=$psel[7]?></option>
					<option value="8"  <?=$arrPrefSel[8]?>  ><?=$psel[8]?></option>
					<option value="9"  <?=$arrPrefSel[9]?>  ><?=$psel[9]?></option>
					<option value="10" <?=$arrPrefSel[10]?> ><?=$psel[10]?></option>
					<option value="11" <?=$arrPrefSel[11]?> ><?=$psel[11]?></option>
					<option value="12" <?=$arrPrefSel[12]?> ><?=$psel[12]?></option>
					<option value="13" <?=$arrPrefSel[13]?> ><?=$psel[13]?></option>
					<option value="14" <?=$arrPrefSel[14]?> ><?=$psel[14]?></option>
					<option value="15" <?=$arrPrefSel[15]?> ><?=$psel[15]?></option>
					<option value="16" <?=$arrPrefSel[16]?> ><?=$psel[16]?></option>
					<option value="17" <?=$arrPrefSel[17]?> ><?=$psel[17]?></option>
					<option value="18" <?=$arrPrefSel[18]?> ><?=$psel[18]?></option>
					<option value="19" <?=$arrPrefSel[19]?> ><?=$psel[19]?></option>
					<option value="20" <?=$arrPrefSel[20]?> ><?=$psel[20]?></option>
					<option value="21" <?=$arrPrefSel[21]?> ><?=$psel[21]?></option>
					<option value="22" <?=$arrPrefSel[22]?> ><?=$psel[22]?></option>
					<option value="23" <?=$arrPrefSel[23]?> ><?=$psel[23]?></option>
					<option value="24" <?=$arrPrefSel[24]?> ><?=$psel[24]?></option>
					<option value="25" <?=$arrPrefSel[25]?> ><?=$psel[25]?></option>
					<option value="26" <?=$arrPrefSel[26]?> ><?=$psel[26]?></option>
					<option value="27" <?=$arrPrefSel[27]?> ><?=$psel[27]?></option>
					<option value="28" <?=$arrPrefSel[28]?> ><?=$psel[28]?></option>
					<option value="29" <?=$arrPrefSel[29]?> ><?=$psel[29]?></option>
					<option value="30" <?=$arrPrefSel[30]?> ><?=$psel[30]?></option>
					<option value="31" <?=$arrPrefSel[31]?> ><?=$psel[31]?></option>
					<option value="32" <?=$arrPrefSel[32]?> ><?=$psel[32]?></option>
					<option value="33" <?=$arrPrefSel[33]?> ><?=$psel[33]?></option>
					<option value="34" <?=$arrPrefSel[34]?> ><?=$psel[34]?></option>
					<option value="35" <?=$arrPrefSel[35]?> ><?=$psel[35]?></option>
					<option value="36" <?=$arrPrefSel[36]?> ><?=$psel[36]?></option>
					<option value="37" <?=$arrPrefSel[37]?> ><?=$psel[37]?></option>
					<option value="38" <?=$arrPrefSel[38]?> ><?=$psel[38]?></option>
					<option value="39" <?=$arrPrefSel[39]?> ><?=$psel[39]?></option>
					<option value="40" <?=$arrPrefSel[40]?> ><?=$psel[40]?></option>
					<option value="41" <?=$arrPrefSel[41]?> ><?=$psel[41]?></option>
					<option value="42" <?=$arrPrefSel[42]?> ><?=$psel[42]?></option>
					<option value="43" <?=$arrPrefSel[43]?> ><?=$psel[43]?></option>
					<option value="44" <?=$arrPrefSel[44]?> ><?=$psel[44]?></option>
					<option value="45" <?=$arrPrefSel[45]?> ><?=$psel[45]?></option>
					<option value="46" <?=$arrPrefSel[46]?> ><?=$psel[46]?></option>
					<option value="47" <?=$arrPrefSel[47]?> ><?=$psel[47]?></option>
				</select></p>
				<br>
				<p><input type="text" name="address_1" value="<?=$_POST['address_1']?>">&nbsp;���㡧����ԡ��������1-4��</p>
				<br>
				<p><input type="text" name="address_2" value="<?=$_POST['address_2']?>"></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>�����ֹ�</p>
			</td>
			<td class="tdform-b">
				<p><input name="tell_1" type="text" value="<?=$_POST['tell_1']?>" >
				&nbsp;<span class="red">��Ⱦ�ѱѿ���)</span>&nbsp;&nbsp;����:03-1234-5678)</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>��������</p>
			</td>
			<td class="tdform-b">
				<p><input name="mobile_1" type="text" value="<?=$_POST['mobile_1']?>" >
				&nbsp;<span class="red">��Ⱦ�ѱѿ���)</span></p>
			</td>
		</tr>
		</table>

		<table class="margint5">
		<tr>
			<td class="paddinglr2 bggray">
				<p><em>�Ŀ;���μ谷���ˤĤ���</em></p>
			</td>
		</tr>
		<tr>
			<td class="bordergray">
				<p class="center">
				<textarea name="textarea" cols="50" rows="10" style="font-size:small">
1. �Ŀ;���μ���
���Ҥϡ��Ŀ;����Ŭ���ʼ��ʤˤ������������ޤ������Ҥϡ����Υ����֥����ȤΥ���ƥ�Ĥ����Ѥ�������ѼԤ��顢�������Ѥκݤˡ��Ŀ;����������뤳�Ȥ�����ޤ���

2. �Ŀ;����������Ū
���Ҥϡ��Ŀ;����ʲ�����Ū�����Ѥ��ޤ���
�Ŀ;����ݸ�ˡ����¾�δ�Ϣ����ˡ��ˤ��ǧ������ͳ�����������������ܿͤ�Ʊ�դ��ʤ��¤ꡢ����������Ū��Ķ���ƸĿ;�������Ѥ��뤳�ȤϤ���ޤ���
�����ࡢ��ݡ��Ȥ���¾�����һ��ȴ�Ϣ�ޤ������Ӥ��륵���ӥ��ξ���ǯ������ΰ������Τ�����
�����䤤�礻�ؤ��б�
������¾���嵭��������Ū���տ魯����Ū

3. �Ŀ;�����軰�Ԥؤ��� 
���Ҥϡ��Ŀ;�����軰�Ԥؤ��󶡤ˤĤ��Ƥϡ��Ŀ;����ݸ�ˡ����¾�δ�Ϣ����ˡ����餤�����ޤ��� 

4. �Ŀ;���ΰ�������
���Ҥϡ��Ŀ;����Ŭ�ڤ˴��������Ŀ;����ϳ�̡��Ǽ�����»�����Ф���ͽ�����֤�֤��ޤ���

5. �Ŀ;����������Ū�����Ρ�����������������������ε��
���Ҥϡ��Ŀ;���ˤĤ��ơ��������������ɲá������������ߡ��õ�軰�Ԥؤ��󶡤���ߤޤ���������Ū�����Τˡ����Τ��ܿͤ���Τ����Ф����ä����ˤϡ������Ф򤤤��������������ܿͤǤ��뤳�Ȥ��ǧ�Τ������Ŀ;����ݸ�ˡ�����˽��������¤���®�䤫���б����ޤ���

�ʤ��������Ф��Ŀ;����ݸ�ˡ�������׷��ߤ����ʤ���硢�ޤ��ϡ��Ŀ;����ݸ�ˡ����¾��ˡ��ˤ�ꡢ����������䤹�뤳�Ȥ�ǧ������ͳ��������ˤϡ������Ф��Ǥꤹ�뤳�Ȥ��������ޤ��Τǡ����餫���ᤴλ������������

6. ���䤤�礻���
�������Τ����С����ո��������䡢��𡢤���¾�θĿ;���μ谷���˴ؤ��뤪�䤤�礻�ϡ�������Ϣ����ˤƼ����դ��פ��ޤ���

����: ��160-0023 ����Կ��ɶ�������7-11-3 ʿ�ĥӥ�2F
�Żҥ᡼�롧info@jukutown.com
(���ջ��֡�ʿ��12��00��20��00) 

7. ��³Ū����
���Ҥϡ��Ŀ;���μ谷���˴ؤ��뱿�Ѿ�����Ŭ����ľ������³Ū�ʲ������ؤᡢɬ�פ˱����ơ��ץ饤�Х����ݥꥷ�����ѹ����뤳�Ȥ�����ޤ���


�����ջ���� 
���ҤϾ����󶡲�Ҥˤ�����Ŀ;�������Ѥ˴ؤ�����Ǥ�����ʤ���ΤȤ��ޤ���</textarea>
		 		</p>
		 	</td>
		</tr>
		</table>

	</div>
</div><!--search end-->
<input type="hidden" name="form_flg" value="INDEX">
<div class="submit1">
	<label>
	<input type="image" src="share/css/css1/images/button05.gif" alt="����" onclick="return juku_inquiry_check(this.form)"></label>
</div>

<!--to pagetop start--> 
<?php require_once( SYS_PATH."templates/portal/portal_main_footer.tpl" ); ?>
<!--to pagetop end--> 

</form>

</div><!--mainleft end-->

<div id="mainright"><!--mainright start-->
<?php require_once( SYS_PATH."templates/portal/portal_right_menu.tpl" ); ?>
</div><!--mainright end-->    
        
</div><!--main end-->    

<div id="footerwrapper"><!--footerwrapper start-->

</div><!--footerwrapper end-->
<?php require_once( SYS_PATH."edy/portal_footer.tpl" ); ?>
</div><!--container end-->

<?php require_once( SYS_PATH."templates/portal/portal_analytics.tpl" ); ?>

</body>
</html>