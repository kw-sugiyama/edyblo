<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/inquiry/">お問合せ</a></strong><span class="paddinglr1">&gt;</span><strong>ホームページ作成・広告掲載について</strong></p><!--topic path-->

<h3>お問合せ　ホームページ作成・広告掲載について</h3><!--search start-->
<FORM name="juku_inquiry_confirm" method="POST" action="<?=$param_base_blog_addr_url?>/juku_inquiry/confirm.html" target="_self">
<div class="box7">
	<div class="box8">
		<table>
		<tr>
			<td class="tdform-a">
				<p>お問合せ内容を<br>
				選択して下さい。</p>
			</td>
			<td class="tdform-b">
				<p><input type="checkbox" name="title[0]" value="1" <?=$arrViewData["title"][0]?> >&nbsp;塾タウンの掲載について</p>
				<p><input type="checkbox" name="title[1]" value="1" <?=$arrViewData["title"][1]?> >&nbsp;バナー・広告等の掲載について</p>
				<p><input type="checkbox" name="title[2]" value="1" <?=$arrViewData["title"][2]?> >&nbsp;ホームページ作成について
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="title[3]" value="1" <?=$arrViewData["title"][3]?> >&nbsp;その他</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>ご希望内容を<br>
				選択して下さい。</p>
			</td>
			<td class="tdform-b">
				<p><input type="checkbox" name="device[0]" value="1" <?=$arrViewData["device"][0]?> >&nbsp;資料を送付して欲しい</p>
				<p><input type="checkbox" name="device[1]" value="1" <?=$arrViewData["device"][1]?> >&nbsp;詳細を知りたいので電話して欲しい</p>
				<p><input type="checkbox" name="device[2]" value="1" <?=$arrViewData["device"][2]?> >&nbsp;詳細を知りたいので来社して欲しい</p>
				<p><input type="checkbox" name="device[3]" value="1" <?=$arrViewData["device"][3]?> >&nbsp;質問内容に答えて欲しい</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>お問合せ内容</p>
			</td>
			<td class="tdform-b">
				<textarea name="contents" cols="35" rows="10"><?=$_POST['contents']?></textarea>
			</td>
		</tr>
		</table>

		<p class="margint5 red">法人の場合は会社名、部署、役職名、ご住所、ご連絡先電話番号をご記入下さい。</p>
		<table>
		<tr>
			<td class="tdform-a">
				<p>お名前</p>
				<p><span class="red small">必須</span></p>
			</td>
			<td class="tdform-b">
				<p><input name="name_kj_1" type="text" value="<?=$_POST['name_kj_1']?>" ></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>フリガナ</p>
			</td>
			<td class="tdform-b">
				<p><input name="name_kn_1" type="text" value="<?=$_POST['name_kn_1']?>" >&nbsp;<span class="red">（全角カタカナ)</span></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>メールアドレス</p>
				<p class="red small">必須</p>
			</td>
			<td class="tdform-b">
				<p><input type="text" name="email" value="<?=$_POST['email']?>" >
				&nbsp;<span class="red">（半角英数字)</span></p>
				<p>（例：○○@○○com）</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>法人名</p></td>
				 <td class="tdform-b">
				<p><input name="corporation" type="text" value="<?=$_POST['corporation']?>" ></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>部署名</p>
			</td>
			<td class="tdform-b">
				<p><input name="post" type="text" value="<?=$_POST['post']?>" ></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>役職名</p>
			</td>
			<td class="tdform-b">
				<p><input name="position" type="text" value="<?=$_POST['position']?>" ></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>住所</p>
			</td>
			<td class="tdform-b">
				<p>〒&nbsp; <input name="addr_cd_1" type="text" size="5" maxlength="3" value="<?=$_POST['addr_cd_1']?>">&nbsp;-&nbsp;<input name="addr_cd_2" type="text" size="5" maxlength="4" value="<?=$_POST['addr_cd_2']?>">&nbsp;<span class="red">（半角英数字)</span></p>
				<br>
				<p><select class="select2" name="pref">
					<option value="0">都道府県</option>
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
				<p><input type="text" name="address_1" value="<?=$_POST['address_1']?>">&nbsp;（例：東京都○○区○○1-4）</p>
				<br>
				<p><input type="text" name="address_2" value="<?=$_POST['address_2']?>"></p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>電話番号</p>
			</td>
			<td class="tdform-b">
				<p><input name="tell_1" type="text" value="<?=$_POST['tell_1']?>" >
				&nbsp;<span class="red">（半角英数字)</span>&nbsp;&nbsp;（例:03-1234-5678)</p>
			</td>
		</tr>
		<tr>
			<td class="tdform-a">
				<p>携帯電話</p>
			</td>
			<td class="tdform-b">
				<p><input name="mobile_1" type="text" value="<?=$_POST['mobile_1']?>" >
				&nbsp;<span class="red">（半角英数字)</span></p>
			</td>
		</tr>
		</table>

		<table class="margint5">
		<tr>
			<td class="paddinglr2 bggray">
				<p><em>個人情報の取扱いについて</em></p>
			</td>
		</tr>
		<tr>
			<td class="bordergray">
				<p class="center">
				<textarea name="textarea" cols="50" rows="10" style="font-size:small">
1. 個人情報の取得
当社は、個人情報を適正な手段により取得いたします。当社は、このウェブサイトのコンテンツをご利用される利用者から、その利用の際に、個人情報を取得することがあります。

2. 個人情報の利用目的
当社は、個人情報を以下の目的で利用します。
個人情報保護法その他の関連する法令により認められる事由がある場合を除き、ご本人の同意がない限り、この利用目的を超えて個人情報を利用することはありません。
・商材、レポートその他の当社事業関連または付帯するサービスの情報、年賀状等の挨拶状のご案内
・お問い合せへの対応
・その他、上記の利用目的に付随する目的

3. 個人情報の第三者への提供 
当社は、個人情報の第三者への提供については、個人情報保護法その他の関連する法令を遵守いたします。 

4. 個人情報の安全管理
当社は、個人情報を適切に管理し、個人情報の漏洩、滅失、毀損等に対する予防措置を講じます。

5. 個人情報の利用目的の通知、開示、訂正、利用停止等の求め
当社は、個人情報について、開示、訂正・追加・削除、利用停止・消去、第三者への提供の停止または利用目的の通知に、そのご本人からのお申出があった場合には、お申出をいただいた方がご本人であることを確認のうえ、個人情報保護法の定めに従い、誠実かつ速やかに対応します。

なお、お申出が個人情報保護法の定める要件をみたさない場合、または、個人情報保護法その他の法令により、開示等を拒絶することが認められる事由がある場合には、お申出をお断りすることがございますので、あらかじめご了承ください。

6. お問い合せ窓口
開示等のお申出、ご意見、ご質問、苦情、その他の個人情報の取扱いに関するお問い合せは、下記ご連絡先にて受け付け致します。

住所: 〒160-0023 東京都新宿区西新宿7-11-3 平田ビル2F
電子メール：info@jukutown.com
(受付時間：平日12：00〜20：00) 

7. 継続的改善
当社は、個人情報の取扱いに関する運用状況を適宜見直し、継続的な改善に努め、必要に応じて、プライバシーポリシーを変更することがあります。


【免責事項】 
当社は情報提供会社における個人情報の利用に関して責任を負わないものとします。</textarea>
		 		</p>
		 	</td>
		</tr>
		</table>

	</div>
</div><!--search end-->
<input type="hidden" name="form_flg" value="INDEX">
<div class="submit1">
	<label>
	<input type="image" src="share/css/css1/images/button05.gif" alt="送信" onclick="return juku_inquiry_check(this.form)"></label>
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
