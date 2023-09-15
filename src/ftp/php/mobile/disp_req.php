<?
//定数処理
$marks= "<font color=\"#FF9999\">■</font>";
/*HTMLフォームを作成
$inquiry_form2     資料請求用フォーム        
$privacy　         個人情報について
 */
//$_POST = mb_convert_encoding($_POST[], "EUC-JP", "shift-jis");
$_POST[mailtype]         = mb_convert_encoding($_POST[mailtype]      , "EUC-JP", "shift-jis");
$_POST[report1]          = mb_convert_encoding($_POST[report1]       , "EUC-JP", "shift-jis");
$_POST[report2]          = mb_convert_encoding($_POST[report2]       , "EUC-JP", "shift-jis");
$_POST[report3]          = mb_convert_encoding($_POST[report3]       , "EUC-JP", "shift-jis");
$_POST[report4]          = mb_convert_encoding($_POST[report4]       , "EUC-JP", "shift-jis");
$_POST[etc]              = mb_convert_encoding($_POST[etc]           , "EUC-JP", "shift-jis");
$_POST[demand1]          = mb_convert_encoding($_POST[demand1]       , "EUC-JP", "shift-jis");
$_POST[demand2]          = mb_convert_encoding($_POST[demand2]       , "EUC-JP", "shift-jis");
$_POST[demand3]          = mb_convert_encoding($_POST[demand3]       , "EUC-JP", "shift-jis");
$_POST[demand4]          = mb_convert_encoding($_POST[demand4]       , "EUC-JP", "shift-jis");
$_POST[inquiry]          = mb_convert_encoding($_POST[inquiry]       , "EUC-JP", "shift-jis");
$_POST[kidsname_kj_1]    = mb_convert_encoding($_POST[kidsname_kj_1] , "EUC-JP", "shift-jis");
$_POST[kidsname_kj_2]    = mb_convert_encoding($_POST[kidsname_kj_2] , "EUC-JP", "shift-jis");
$_POST[kidsname_kn_1]    = mb_convert_encoding($_POST[kidsname_kn_1] , "EUC-JP", "shift-jis");
$_POST[kidsname_kn_2]    = mb_convert_encoding($_POST[kidsname_kn_2] , "EUC-JP", "shift-jis");
$_POST[sex]              = mb_convert_encoding($_POST[sex]           , "EUC-JP", "shift-jis");
$_POST[year]             = mb_convert_encoding($_POST[year]          , "EUC-JP", "shift-jis");
$_POST[month]            = mb_convert_encoding($_POST[month]         , "EUC-JP", "shift-jis");
$_POST[day]              = mb_convert_encoding($_POST[day]           , "EUC-JP", "shift-jis");
$_POST[gakunen]          = mb_convert_encoding($_POST[gakunen]       , "EUC-JP", "shift-jis");
$_POST[gakunen_text]     = mb_convert_encoding($_POST[gakunen_text]  , "EUC-JP", "shift-jis");
$_POST[type]             = mb_convert_encoding($_POST[type]          , "EUC-JP", "shift-jis");
$_POST[school]           = mb_convert_encoding($_POST[school]        , "EUC-JP", "shift-jis");
$_POST[name_kj_1]        = mb_convert_encoding($_POST[name_kj_1]     , "EUC-JP", "shift-jis");
$_POST[name_kj_2]        = mb_convert_encoding($_POST[name_kj_2]     , "EUC-JP", "shift-jis");
$_POST[name_kn_1]        = mb_convert_encoding($_POST[name_kn_1]     , "EUC-JP", "shift-jis");
$_POST[name_kn_2]        = mb_convert_encoding($_POST[name_kn_2]     , "EUC-JP", "shift-jis");
$_POST[addr_cd_1]        = mb_convert_encoding($_POST[addr_cd_1]     , "EUC-JP", "shift-jis");
$_POST[addr_cd_2]        = mb_convert_encoding($_POST[addr_cd_2]     , "EUC-JP", "shift-jis");
$_POST[pref]             = mb_convert_encoding($_POST[pref]          , "EUC-JP", "shift-jis");
$_POST[city]             = mb_convert_encoding($_POST[city]          , "EUC-JP", "shift-jis");
$_POST[add]              = mb_convert_encoding($_POST[add]           , "EUC-JP", "shift-jis");
$_POST[Buil]             = mb_convert_encoding($_POST[Buil]          , "EUC-JP", "shift-jis");
$_POST[tel]              = mb_convert_encoding($_POST[tel]           , "EUC-JP", "shift-jis");
$_POST[ctel]             = mb_convert_encoding($_POST[ctel]          , "EUC-JP", "shift-jis");
$_POST[mail]             = mb_convert_encoding($_POST[mail]          , "EUC-JP", "shift-jis");

//print_r($_POST);

$eflg=$_POST[err];
//エラーチェックフラグ
$errf=9;
if($eflg==err ){
		  //お子様氏名チェック
		  $err1 = $_POST[kidsname_kj_1];
		  $err2 = $_POST[kidsname_kj_2];
		  $err3 .= $err1;
		  $err3 .= $err2;
		  if(!$err1 or !$err2){
					 $errmsg="　お子様の氏名を確認してください。";
					 $errf=1;
		  }else{
					 if (mb_ereg("[　\sｧ-ｯｱ-ﾝﾞﾟ!-~]+", $err3)) {
								$errmsg.="　お子様の氏名を全角で入力してください。";
								$err = 1;
					 }else {
					 } 
		  }

		  $err1 = $_POST[kidsname_kn_1];
		  $err2 = $_POST[kidsname_kn_2];
		  $err3="";
		  $err3.= $err1;
		  $err3.= $err2;
		  if(!$err1 or !$err2){
					 $errmsg.="<br />　お子様の氏名(カナ)を確認してください。";
					 $errf=1;
		  }else{
					 if (mb_ereg("[ｱ-ﾝﾞﾟ]+$",$err3)) {
					 }else {
								$errmsg.="<br />　お子様の氏名を半角カナで入力してください。";
								$errf = 1;
					 }
		  }

		  $err1       = $_POST[gakunen];
		  if($err1===""){
					 $errmsg.="<br />　学年を確認してください。";
					 $errf=1;
		  }

		  //保護者氏名チェック
		  $err1 = $_POST[name_kj_1];
		  $err2 = $_POST[name_kj_2];
		  $err3="";
		  $err3.= $err1;
		  $err3.= $err2;
		  if(!$err1 or !$err2){
					 $errmsg.="<br />　保護者の氏名を確認してください。";
					 $errf=1;
		  }else{
					 if (mb_ereg("[　\sｧ-ｯｱ-ﾝﾞﾟ!-~]+", $err3)) {
								$errmsg.="<br />　保護者の氏名を全角で入力してください。";
								$err = 1;
					 }else {
					 }
		  }
		  $err1 = $_POST[name_kn_1];
		  $err2 = $_POST[name_kn_2];
		  $err3="";
		  $err3.= $err1;
		  $err3.= $err2;
		  if(!$err1 or !$err2){
					 $errmsg.="<br />　保護者の氏名を確認してください。";
					 $errf=1;
		  }else{
					 if (mb_ereg("[ｱ-ﾝﾞﾟ]+$",$err3)) {
					 }else {
								$errmsg.="<br />　保護者の氏名を半角カナで入力してください。";
								$errf = 1;
					 }
		  }

		  
		  //郵便番号チェック
		  $err1  ="";
		  $err1  = $_POST[addr_cd_1];
		  $err3  ="";
		  $err3  .=$err1;
		  if(!$err1){
					 $errmsg.="<br />　郵便番号を確認してください。";
					 $errf=1;
		  }else{
					 if(ereg("[0-9]+$", $err3)){
					 }else{
								$errmsg.="<br />　郵便番号を半角数字で入力してください。";
					 }
		  }
		  //住所チェック
		  $err1  = $_POST[pref];
		  $err2  = $_POST[city];
		  $err3  = $_POST[add] ;
		  $err5 .= $err1;
		  $err5 .= $err2;
		  $err5 .= $err3;
		  if(!$err1 or !$err2 or !$err3){
					 $errmsg.="<br />　住所を確認してください。";
					 $errf=1;
		  }else{
					 if (mb_ereg("[　\sｧ-ｯｱ-ﾝﾞﾟ!-~]+", $err5)) {
								$errmsg.="<br />　住所を全角で入力してください。";
								$err = 1;
					 }else {
					 } 
		  }
}

//携帯用　ＰＯＳＴセット
$mailtype      = $_POST[mailtype]         ;
$report1       = $_POST[report1]          ;
$report2       = $_POST[report2]          ;
$report3       = $_POST[report3]          ;
$report4       = $_POST[report4]          ;
$etc           = $_POST[etc]              ;
$demand1       = $_POST[demand1]          ;
$demand2       = $_POST[demand2]          ;
$demand3       = $_POST[demand3]          ;
$demand4       = $_POST[demand4]          ;
$inquiry       = $_POST[inquiry]          ;
$kidsname_kj_1 = $_POST[kidsname_kj_1]    ;
$kidsname_kj_2 = $_POST[kidsname_kj_2]    ;
$kidsname_kn_1 = $_POST[kidsname_kn_1]    ;
$kidsname_kn_2 = $_POST[kidsname_kn_2]    ;
$sex           = $_POST[sex]              ;
$year          = $_POST[year]             ;
$month         = $_POST[month]            ;
$day           = $_POST[day]              ;
$gakunen       = $_POST[gakunen]          ;
$gakunen_text  = $_POST[gakunen_text]     ;
$type          = $_POST[type]             ;
$school        = $_POST[school]           ;
$name_kj_1     = $_POST[name_kj_1]        ;
$name_kj_2     = $_POST[name_kj_2]        ;
$name_kn_1     = $_POST[name_kn_1]        ;
$name_kn_2     = $_POST[name_kn_2]        ;
$addr_cd_1     = $_POST[addr_cd_1]        ;
$addr_cd_2     = $_POST[addr_cd_2]        ;
$pref          = $_POST[pref]             ;
$city          = $_POST[city]             ;
$add           = $_POST[add]              ;
$Buil          = $_POST[Buil]             ;
$tel           = $_POST[tel]              ;
$ctel          = $_POST[ctel]             ;
$mail          = $_POST[mail]             ;
//エスケープ対策
$mailtype      = htmlspecialchars($mailtype       );
$report1       = htmlspecialchars($report1        );
$report2       = htmlspecialchars($report2        );
$report3       = htmlspecialchars($report3        );
$report4       = htmlspecialchars($report4        );
$etc           = htmlspecialchars($etc            );
$demand1       = htmlspecialchars($demand1        );
$demand2       = htmlspecialchars($demand2        );
$demand3       = htmlspecialchars($demand3        );
$demand4       = htmlspecialchars($demand4        );
$inquiry       = htmlspecialchars($inquiry        );
$kidsname_kj_1 = htmlspecialchars($kidsname_kj_1  );
$kidsname_kj_2 = htmlspecialchars($kidsname_kj_2  );
$kidsname_kn_1 = htmlspecialchars($kidsname_kn_1  );
$kidsname_kn_2 = htmlspecialchars($kidsname_kn_2  );
$sex           = htmlspecialchars($sex            );
$year          = htmlspecialchars($year           );
$month         = htmlspecialchars($month          );
$day           = htmlspecialchars($day            );
$gakunen       = htmlspecialchars($gakunen        );
$gakunen_text  = htmlspecialchars($gakunen_text   );
$type          = htmlspecialchars($type           );
$school        = htmlspecialchars($school         );
$name_kj_1     = htmlspecialchars($name_kj_1      );
$name_kj_2     = htmlspecialchars($name_kj_2      );
$name_kn_1     = htmlspecialchars($name_kn_1      );
$name_kn_2     = htmlspecialchars($name_kn_2      );
$addr_cd_1     = htmlspecialchars($addr_cd_1      );
$addr_cd_2     = htmlspecialchars($addr_cd_2      );
$pref          = htmlspecialchars($pref           );
$city          = htmlspecialchars($city           );
$add           = htmlspecialchars($add            );
$Buil          = htmlspecialchars($Buil           );
$tel           = htmlspecialchars($tel            );
$ctel          = htmlspecialchars($ctel           );
$mail          = htmlspecialchars($mail           );
//エスケープ対策
$mailtype      = stripslashes($mailtype      );
$report1       = stripslashes($report1       );
$report2       = stripslashes($report2       );
$report3       = stripslashes($report3       );
$report4       = stripslashes($report4       );
$etc           = stripslashes($etc           );
$demand1       = stripslashes($demand1       );
$demand2       = stripslashes($demand2       );
$demand3       = stripslashes($demand3       );
$demand4       = stripslashes($demand4       );
$inquiry       = stripslashes($inquiry       );
$kidsname_kj_1 = stripslashes($kidsname_kj_1 );
$kidsname_kj_2 = stripslashes($kidsname_kj_2 );
$kidsname_kn_1 = stripslashes($kidsname_kn_1 );
$kidsname_kn_2 = stripslashes($kidsname_kn_2 );
$sex           = stripslashes($sex           );
$year          = stripslashes($year          );
$month         = stripslashes($month         );
$day           = stripslashes($day           );
$gakunen       = stripslashes($gakunen       );
$gakunen_text  = stripslashes($gakunen_text  );
$type          = stripslashes($type          );
$school        = stripslashes($school        );
$name_kj_1     = stripslashes($name_kj_1     );
$name_kj_2     = stripslashes($name_kj_2     );
$name_kn_1     = stripslashes($name_kn_1     );
$name_kn_2     = stripslashes($name_kn_2     );
$addr_cd_1     = stripslashes($addr_cd_1     );
$addr_cd_2     = stripslashes($addr_cd_2     );
$pref          = stripslashes($pref          );
$city          = stripslashes($city          );
$add           = stripslashes($add           );
$Buil          = stripslashes($Buil          );
$tel           = stripslashes($tel           );
$ctel          = stripslashes($ctel          );
$mail          = stripslashes($mail          );

//生まれ年
$max="";
$min="";
$max=date("Y")-20;//最高年齢
$min=date("Y")-3 ;//最少年齢
$yearlist = '<option value="">---</option>';
for($max;$max<=$min;$max++){
		  if($year==$max){
					 $yearlist.='<option value="'.$max.'" selected>'.$max.'</option>';
		  }else{
					 $yearlist.='<option value="'.$max.'">'.$max.'</option>';
		  }
}
//生まれ月
$monthlist = '<option value="">---</option>';
for($cnt=1;$cnt<=12;$cnt++){
		  if($month==$cnt){
					 $monthlist.='<option value="'.$cnt.'" selected>'.$cnt.'</option>';
		  }else{
					 $monthlist.='<option value="'.$cnt.'">'.$cnt.'</option>';
		  }
}
//生まれ日
$daylist = '<option value="">---</option>';
for($cnt=1;$cnt<=31;$cnt++){
		  if($day==$cnt){
					 $daylist.='<option value="'.$cnt.'" selected>'.$cnt.'</option>';
		  }else{
					 $daylist.='<option value="'.$cnt.'">'.$cnt.'</option>';
		  }
}
//学年
$gakunenlist = '<option value="">▼選択する</option>';
foreach($param_inq_gakunen["val"] as $key => $val) {
		  if ($gakunen == ""){
					 $gakunenlist .= '<option value="'.$key.'">'.$val.'</option>';
		  }else if ($gakunen==$key) {
					 $gakunenlist .= '<option value="'.$key.'" selected>'.$val.'</option>';
		  } else {
					 $gakunenlist .= '<option value="'.$key.'">'.$val.'</option>';
		  }
}

$pref_rows=array("北海道","青森県","岩手県","宮城県","秋田県","山形県","福島県","茨城県","栃木県","群馬県","埼玉県","千葉県","東京都","神奈川県","新潟県","富山県","石川県","福井県","山梨県","長野県","岐阜県","静岡県","愛知県","三重県","滋賀県","京都府","大阪府","兵庫県","奈良県","和歌山県","鳥取県","島根県","岡山県","広島県","山口県","徳島県","香川県","愛媛県","高知県","福岡県","佐賀県","長崎県","熊本県","大分県","宮崎県","鹿児島県","沖縄県");

$pref_list='<option value="">▼選択する　　　</option>';
foreach($pref_rows as $key=>$val){
		  if($pref==$val){
					 $pref_list.='<option value="'.$val.'" selected>'.$val.'</option>';
		  }else{
					 $pref_list.='<option value="'.$val.'">'.$val.'</option>';
		  }	
}

//ご質問内容
$request_msg='
		  <!--box start-->
		  <br /><br /><font size="1">
'.$marks.'
ご質問など<br />
		  　<textarea name="inquiry" cols="15" rows="2" istyle="1" mode="hiragana" >'.($inquiry).'</textarea></p>
		  <!--box end-->
		  ';

if($sex=="女"){
		  $sex_list='<select name=sex>
					 <option value="選択する">▼選択する　　　　</option>
					 <option value="男">男</option>
					 <option value="女" selected >女</option>
					 </select>
					 ';
}elseif($sex=="男")
{
		  $sex_list='<select name=sex>
					 <option value="選択する">▼選択する　　　　</option>
					 <option value="男" selected >男</option>
					 <option value="女">女</option>
					 </select>
					 ';
}else{
		  $sex_list='<select name=sex>
					 <option value="選択する" selected >▼選択する　　　　</option>
					 <option value="男">男</option>
					 <option value="女">女</option>
					 </select>';
}

//▼▼▼▼▼▼▼▼▼資料請求用フォーム▼▼▼▼▼▼▼▼▼
$inquiry_form2='
		  <!--box start-->
		  
'.$marks.'
		  お子様の氏名
		  <input type="hidden"  name="err" value="err">
		  <font color="red">※</font><br />
		  <font color="blue">名字と名前を分けてご入力下さい。</font>
		  <br />
		  (漢字)　　<input type="text" size="5" name="kidsname_kj_1" value="'.$kidsname_kj_1.'" istyle="1" mode="hiragana" /> <font size="1">　<input type="text" size="5" name="kidsname_kj_2" value="'.$kidsname_kj_2.'" istyle="1" mode="hiragana" /><font size="1">
		  <br /><br /> 
		  <font color="blue">名字と名前を分けてご入力下さい。</font>
		  <br />
		  (半角カナ)<input type="text" size="5" name="kidsname_kn_1" value="'.$kidsname_kn_1.'" istyle="2" mode="hankakukana" /> <font size="1">　<input type="text" size="5" name="kidsname_kn_2" value="'.$kidsname_kn_2.'" istyle="2" mode="hankakukana" /><font size="1">
		  <br /><br />
'.$marks.'
		  お子様の性別
		  <br />　'.$sex_list.'
		  <br /><br />
'.$marks.'
		  学年
		  <font color="red">※</font>
		  <br />　<select name="gakunen">
		  '.$gakunenlist.'
		  </select><br />
		  <br />
'.$marks.'
		  お通いの学校名<br />
		  　<input type="text" name="school" value="'.$school.'" size="17"  istyle="1" mode="hiragana" />
		  <br /><br />
'.$marks.'
		  保護者の氏名 <font color="red">※</font><br />
		  <font color="blue">名字と名前を分けてご入力下さい。</font>
		  <br />
		  (漢字)　　<input type="text" size="5" name="name_kj_1" value="'.$name_kj_1.'" istyle="1" mode="hiragana" /> 　<input type="text" size="5" name="name_kj_2" value="'.$name_kj_2.'" istyle="1" mode="hiragana" />
		  <br /><br />
		  <font color="blue">名字と名前を分けてご入力下さい。
		  </font>
		  <br />
		  (半角カナ)<input type="text" size="5" name="name_kn_1" value="'.$name_kn_1.'" istyle="2" mode="hankakukana" /> 　<input type="text" size="5" name="name_kn_2" value="'.$name_kn_2.'" istyle="2" mode="hankakukana" />
		  <br /><br />
'.$marks.'
		  郵便番号(半角数字)
		  <font color="red">※</font><font color="blue">　ハイフンなし</font>
		  <br />
		  　<input name="addr_cd_1" type="text" size="11" maxlength="8" value="'.$addr_cd_1.'" istyle="4" mode="numeric" />
		  <!--<input type="button" value="住所取得"  />-->
		  <br /><br />
'.$marks.'
		  都道府県
		  <font color="red">※</font>
		  <br />　<select name="pref">'.$pref_list.'</select>
		  <br /><br />
'.$marks.'
		  住所(市区町村)
		  <font color="red">※</font>
		  　<br /><font color="blue">　例）○○市○○</font>
		  <br />　<input type="text" name="city" value="'.$city.'" size="13"  istyle="1" mode="hiragana" /><br />
		  <br />住所（番地）
		  <font color="red">※</font><br />
		  　<font color="blue">例）2-21-2</font><br />
		  　<input type="text" name="add" value="'.$add.'" size="13" istyle="4" mode="numeric" /><br />
		  <br />住所（マンション・アパート名以下）
		  <br /><font color="blue">　例）△△マンション 301</font>
		  <br />　<input type="text" name="Buil" value="'.$Buil.'" size="13" istyle="1" mode="hiragana" />
		  <br /><br />
'.$marks.'
		  電話番号
		  <font color="red"></font><font color="blue"> ハイフンなし</font>
		  <br />
		  　<input type="text" size="13" name="tel" value="'.$tel.'" istyle="4" mode="numeric" />
		  <!--電話番号（例）03-○○○○-△△△△-->
		  <br /><br />
'.$marks.'
		  メールアドレス<br />
		  
		  　<input type="text" name="mail" value="'.$mail.'" size="13" istyle="3" mode="alphabet" />
		  
		  <!--box end-->
		  ';
//個人情報
$privacy="";
$privacy='<br /><a href="'._BLOG_SITE_URL_BASE.'kojin/">
<font color="#666666">
ﾌﾟﾗｲﾊﾞｼｰﾎﾟﾘｼｰ
</font>
</a>';
//echo $arrHeaderView['sc_privacy'];
/*
if($arrHeaderView['sc_privacy']){
		  $privacy=' <!-- <p><font size="1">個人情報の取扱いについて</p><font size="1"> <textarea name="textarea" cols="10" rows="10" readonly="readonly">'.$arrHeaderView['sc_privacy'].'</textarea> <p><font size="1">個人情報の取扱について」に同意いただける場合は、「同意する」にチェックを入れてください</p> <input type="checkbox" name="privacy" value="1" /><span>同意する</span>--> <p><font size="1">プライバシーポリシー</font></p> ';
}*/

//資料請求、コース資料請求
$button3="";
$button3='
		  <br /><input type=submit value="同意の上確認画面へ">
		  ';

?>
