<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/inquiry/">����礻</a></strong><span class="paddinglr1">&gt;</span><strong>�Υ�����ˤĤ���</strong></p><!--topic path-->

<h3>����礻���Υ�����ˤĤ���</h3><!--search start-->
<form name="hp_inquiry_input" method="POST" action="<?=$param_base_blog_addr_url?>/hp_inquiry/confirm.html" target="_self">
	<div class="box7">
		<div class="box8">
			<p class="paddingb1">������礻���������� <br>
			������礻�����ƤˤĤ��Ƥϡ���ǽ�ʸ¤����Ū�˾����������ϲ�������<br>
			���������˾��������ϡ�ɬ���᡼�륢�ɥ쥹�⤢�碌�Ƥ����ϲ�������
			<br>
			���������˾���줿���ǡ�����礻�塢�����ַФäƤ��������ʤ����ϡ�<br>
			���᡼�륢�ɥ쥹������ϳ�졢�⤷�������ϥߥ��β�ǽ�����������ޤ���
			<br>
			�嵭�ξ�硢���Ѥ�����Ǥ������٤���礻�������ޤ��褦���ꤤ�פ��ޤ���</p>

			<table>
			<tr>
				<td class="tdform-a">
					<p>�᡼�륢�ɥ쥹</p>
				</td>
				<td class="tdform-b">
					<p><input type="text" name="email" value="<?=$_POST['email']?>" ><span class="marginlr2 red small">ɬ��</span></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>��̾</p>
				</td>
				<td class="tdform-b">
					<p><input type="text" name="subject" value="<?=$_POST['subject']?>" ><span class="marginlr2 red small">ɬ��</span></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>��ʸ</p>
				</td>
				<td class="tdform-b">
					<textarea name="contents" cols="35" rows="10"><?=$_POST['contents']?></textarea>
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
			 	</p></td>
			</tr>
			</table>

		</div>
	</div><!--search end-->

	<div class="submit1">
	  <label>
	 <input type="image" src="share/css/css1/images/button05.gif" alt="����" onclick="return hp_inquiry_check(this.form)"></label>
	</div>
	<INPUT type="hidden" name="form_flg" value="INDEX" >
</form>

<!--to pagetop start--> 
<?php require_once( SYS_PATH."templates/portal/portal_main_footer.tpl" ); ?>
<!--to pagetop end--> 

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