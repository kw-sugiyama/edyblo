<?
//定数処理=============================================================
$marks= "<font size=\"1\"color=\"#FF9999\">■</font>";
//分岐処理=============================================================
require_once( SYS_PATH."php/mobile/disp_inquire.php" );
require_once( SYS_PATH."php/mobile/disp_box.php" );
if($errf != 9){
require_once( SYS_PATH."templates/mobile/inquire.tpl" );
exit;
}
//エスケープ関数=======================================================
function esc ($st){
$str= $st;		  
$str = stripslashes($str);
$str = preg_replace("/,/","",$str);
return $str;
}

/*
$_POST[mailtype]         = mb_convert_encoding($_POST[mailtype]      , "EUC-JP", "auto");
$_POST[report1]          = mb_convert_encoding($_POST[report1]       , "EUC-JP", "auto");
$_POST[report2]          = mb_convert_encoding($_POST[report2]       , "EUC-JP", "auto");
$_POST[report3]          = mb_convert_encoding($_POST[report3]       , "EUC-JP", "auto");
$_POST[report4]          = mb_convert_encoding($_POST[report4]       , "EUC-JP", "auto");
$_POST[etc]              = mb_convert_encoding($_POST[etc]           , "EUC-JP", "auto");
$_POST[demand1]          = mb_convert_encoding($_POST[demand1]       , "EUC-JP", "auto");
$_POST[demand2]          = mb_convert_encoding($_POST[demand2]       , "EUC-JP", "auto");
$_POST[demand3]          = mb_convert_encoding($_POST[demand3]       , "EUC-JP", "auto");
$_POST[demand4]          = mb_convert_encoding($_POST[demand4]       , "EUC-JP", "auto");
$_POST[inquiry]          = mb_convert_encoding($_POST[inquiry]       , "EUC-JP", "auto");
$_POST[kidsname_kj_1]    = mb_convert_encoding($_POST[kidsname_kj_1] , "EUC-JP", "auto");
$_POST[kidsname_kj_2]    = mb_convert_encoding($_POST[kidsname_kj_2] , "EUC-JP", "auto");
$_POST[kidsname_kn_1]    = mb_convert_encoding($_POST[kidsname_kn_1] , "EUC-JP", "auto");
$_POST[kidsname_kn_2]    = mb_convert_encoding($_POST[kidsname_kn_2] , "EUC-JP", "auto");
$_POST[sex]              = mb_convert_encoding($_POST[sex]           , "EUC-JP", "auto");
$_POST[year]             = mb_convert_encoding($_POST[year]          , "EUC-JP", "auto");
$_POST[month]            = mb_convert_encoding($_POST[month]         , "EUC-JP", "auto");
$_POST[day]              = mb_convert_encoding($_POST[day]           , "EUC-JP", "auto");
$_POST[gakunen]          = mb_convert_encoding($_POST[gakunen]       , "EUC-JP", "auto");
$_POST[gakunen_text]     = mb_convert_encoding($_POST[gakunen_text]  , "EUC-JP", "auto");
$_POST[type]             = mb_convert_encoding($_POST[type]          , "EUC-JP", "auto");
$_POST[school]           = mb_convert_encoding($_POST[school]        , "EUC-JP", "auto");
$_POST[name_kj_1]        = mb_convert_encoding($_POST[name_kj_1]     , "EUC-JP", "auto");
$_POST[name_kj_2]        = mb_convert_encoding($_POST[name_kj_2]     , "EUC-JP", "auto");
$_POST[name_kn_1]        = mb_convert_encoding($_POST[name_kn_1]     , "EUC-JP", "auto");
$_POST[name_kn_2]        = mb_convert_encoding($_POST[name_kn_2]     , "EUC-JP", "auto");
$_POST[addr_cd_1]        = mb_convert_encoding($_POST[addr_cd_1]     , "EUC-JP", "auto");
$_POST[addr_cd_2]        = mb_convert_encoding($_POST[addr_cd_2]     , "EUC-JP", "auto");
$_POST[pref]             = mb_convert_encoding($_POST[pref]          , "EUC-JP", "auto");
$_POST[city]             = mb_convert_encoding($_POST[city]          , "EUC-JP", "auto");
$_POST[add]              = mb_convert_encoding($_POST[add]           , "EUC-JP", "auto");
$_POST[Buil]             = mb_convert_encoding($_POST[Buil]          , "EUC-JP", "auto");
$_POST[tel]              = mb_convert_encoding($_POST[tel]           , "EUC-JP", "auto");
$_POST[ctel]             = mb_convert_encoding($_POST[ctel]          , "EUC-JP", "auto");
$_POST[mail]             = mb_convert_encoding($_POST[mail]          , "EUC-JP", "auto");

print_r($_POST);

 */
//携帯用 ＰＯＳＴ引渡=================================================
$mailtype      = htmlspecialchars("$_POST[mailtype]")     ;
$report        = htmlspecialchars("$_POST[report]")       ;
$etc           = htmlspecialchars("$_POST[etc]")          ;
$demand1       = htmlspecialchars("$_POST[demand1]")      ;
$demand2       = htmlspecialchars("$_POST[demand2]")      ;
$demand3       = htmlspecialchars("$_POST[demand3]")      ;
$demand4       = htmlspecialchars("$_POST[demand4]")      ;
$inquiry       = htmlspecialchars("$_POST[inquiry]")      ;
$kidsname_kj_1 = htmlspecialchars("$_POST[kidsname_kj_1]");
$kidsname_kj_2 = htmlspecialchars("$_POST[kidsname_kj_2]");
$kidsname_kn_1 = htmlspecialchars("$_POST[kidsname_kn_1]");
$kidsname_kn_2 = htmlspecialchars("$_POST[kidsname_kn_2]");
$sex           = htmlspecialchars("$_POST[sex]")          ;
$year          = htmlspecialchars("$_POST[year]")         ;
$month         = htmlspecialchars("$_POST[month]")        ;
$day           = htmlspecialchars("$_POST[day]")          ;
$gakunen       = htmlspecialchars("$_POST[gakunen]")      ;
$gakunen_text  = htmlspecialchars("$_POST[gakunen_text]") ;
$type          = htmlspecialchars("$_POST[type]")         ;
$school        = htmlspecialchars("$_POST[school]")       ;
$name_kj_1     = htmlspecialchars("$_POST[name_kj_1]")    ;
$name_kj_2     = htmlspecialchars("$_POST[name_kj_2]")    ;
$name_kn_1     = htmlspecialchars("$_POST[name_kn_1]")    ;
$name_kn_2     = htmlspecialchars("$_POST[name_kn_2]")    ;
$addr_cd_1     = htmlspecialchars("$_POST[addr_cd_1]")    ;
$addr_cd_2     = htmlspecialchars("$_POST[addr_cd_2]")    ;
$pref          = htmlspecialchars("$_POST[pref]")         ;
$city          = htmlspecialchars("$_POST[city]")         ;
$add           = htmlspecialchars("$_POST[add]")          ;
$Buil          = htmlspecialchars("$_POST[Buil]")         ;
$tel           = htmlspecialchars("$_POST[tel]")          ;
$ctel          = htmlspecialchars("$_POST[ctel]")         ;
$mail          = htmlspecialchars("$_POST[mail]")         ;
//エスケープ処理=======================================================
$mailtype      =esc($mailtype     );
$report        =esc($report       );
$etc           =esc($etc          );
$demand1       =esc($demand1      );
$demand2       =esc($demand2      );
$demand3       =esc($demand3      );
$demand4       =esc($demand4      );
$inquiry       =esc($inquiry      );
$kidsname_kj_1 =esc($kidsname_kj_1);
$kidsname_kj_2 =esc($kidsname_kj_2);
$kidsname_kn_1 =esc($kidsname_kn_1);
$kidsname_kn_2 =esc($kidsname_kn_2);
$sex           =esc($sex          );
$year          =esc($year         );
$month         =esc($month        );
$day           =esc($day          );
$gakunen       =esc($gakunen      );
$gakunen_text  =esc($gakunen_text );
$type          =esc($type         );
$school        =esc($school       );
$name_kj_1     =esc($name_kj_1    );
$name_kj_2     =esc($name_kj_2    );
$name_kn_1     =esc($name_kn_1    );
$name_kn_2     =esc($name_kn_2    );
$addr_cd_1     =esc($addr_cd_1    );
$addr_cd_2     =esc($addr_cd_2    );
$pref          =esc($pref         );
$city          =esc($city         );
$add           =esc($add          );
$Buil          =esc($Buil         );
$tel           =esc($tel          );
$ctel          =esc($ctel         );
$mail          =esc($mail         );
//HIDDENに値を格納=====================================================
$confirm="";
$confirm1 .="
<form method=\"POST\" action=\"../inquire/\" accept-charset=\"shift-jis\">
<input type=\"hidden\" name=\"mailtype\"      value=\"$mailtype\"      />
<input type=\"hidden\" name=\"report\"        value=\"$report\"       />
<input type=\"hidden\" name=\"etc\"           value=\"$etc\"           />
<input type=\"hidden\" name=\"demand1\"       value=\"$demand1\"       />
<input type=\"hidden\" name=\"demand2\"       value=\"$demand2\"       />
<input type=\"hidden\" name=\"demand3\"       value=\"$demand2\"       />
<input type=\"hidden\" name=\"demand4\"       value=\"$demand4\"       />
<input type=\"hidden\" name=\"inquiry\"       value=\"$inquiry\"       />
<input type=\"hidden\" name=\"kidsname_kj_1\" value=\"$kidsname_kj_1\" />
<input type=\"hidden\" name=\"kidsname_kj_2\" value=\"$kidsname_kj_2\" />
<input type=\"hidden\" name=\"kidsname_kn_1\" value=\"$kidsname_kn_1\" />
<input type=\"hidden\" name=\"kidsname_kn_2\" value=\"$kidsname_kn_2\" />
<input type=\"hidden\" name=\"sex\"           value=\"$sex\"           />
<input type=\"hidden\" name=\"year\"          value=\"$year\"          />
<input type=\"hidden\" name=\"month\"         value=\"$month\"         />
<input type=\"hidden\" name=\"day\"           value=\"$day\"           />
<input type=\"hidden\" name=\"gakunen\"       value=\"$gakunen\"       />
<input type=\"hidden\" name=\"gakunen_text\"  value=\"$gakunen_text\"  />
<input type=\"hidden\" name=\"type\"          value=\"$type\"          />
<input type=\"hidden\" name=\"school\"        value=\"$school\"        />
<input type=\"hidden\" name=\"name_kj_1\"     value=\"$name_kj_1\"     />
<input type=\"hidden\" name=\"name_kj_2\"     value=\"$name_kj_2\"     />
<input type=\"hidden\" name=\"name_kn_1\"     value=\"$name_kn_1\"     />
<input type=\"hidden\" name=\"name_kn_2\"     value=\"$name_kn_2\"     />
<input type=\"hidden\" name=\"addr_cd_1\"     value=\"$addr_cd_1\"     />
<input type=\"hidden\" name=\"addr_cd_2\"     value=\"$addr_cd_2\"     />
<input type=\"hidden\" name=\"pref\"          value=\"$pref\"          />
<input type=\"hidden\" name=\"city\"          value=\"$city\"          />
<input type=\"hidden\" name=\"add\"           value=\"$add\"           />
<input type=\"hidden\" name=\"Buil\"          value=\"$Buil\"          />
<input type=\"hidden\" name=\"tel\"           value=\"$tel\"           />
<input type=\"hidden\" name=\"ctel\"          value=\"$ctel\"          />
<input type=\"hidden\" name=\"mail\"          value=\"$mail\"          />
<input type=\"submit\" value=\"戻る\"></form>
";
$confirm2 .='
<form method="post" action="'._BLOG_SITE_URL_BASE.'inq_finish/" accept-charset="shift-jis">
';
$confirm2 .="
<input type=\"hidden\" name=\"mailtype\"      value=\"$mailtype\"      />
<input type=\"hidden\" name=\"report\"        value=\"$report\"       />
<input type=\"hidden\" name=\"etc\"           value=\"$etc\"           />
<input type=\"hidden\" name=\"demand1\"       value=\"$demand1\"       />
<input type=\"hidden\" name=\"demand2\"       value=\"$demand2\"       />
<input type=\"hidden\" name=\"demand3\"       value=\"$demand2\"       />
<input type=\"hidden\" name=\"demand4\"       value=\"$demand4\"       />
<input type=\"hidden\" name=\"inquiry\"       value=\"$inquiry\"       />
<input type=\"hidden\" name=\"kidsname_kj_1\" value=\"$kidsname_kj_1\" />
<input type=\"hidden\" name=\"kidsname_kj_2\" value=\"$kidsname_kj_2\" />
<input type=\"hidden\" name=\"kidsname_kn_1\" value=\"$kidsname_kn_1\" />
<input type=\"hidden\" name=\"kidsname_kn_2\" value=\"$kidsname_kn_2\" />
<input type=\"hidden\" name=\"sex\"           value=\"$sex\"           />
<input type=\"hidden\" name=\"year\"          value=\"$year\"          />
<input type=\"hidden\" name=\"month\"         value=\"$month\"         />
<input type=\"hidden\" name=\"day\"           value=\"$day\"           />
<input type=\"hidden\" name=\"gakunen\"       value=\"$gakunen\"       />
<input type=\"hidden\" name=\"gakunen_text\"  value=\"$gakunen_text\"  />
<input type=\"hidden\" name=\"type\"          value=\"$type\"          />
<input type=\"hidden\" name=\"school\"        value=\"$school\"        />
<input type=\"hidden\" name=\"name_kj_1\"     value=\"$name_kj_1\"     />
<input type=\"hidden\" name=\"name_kj_2\"     value=\"$name_kj_2\"     />
<input type=\"hidden\" name=\"name_kn_1\"     value=\"$name_kn_1\"     />
<input type=\"hidden\" name=\"name_kn_2\"     value=\"$name_kn_2\"     />
<input type=\"hidden\" name=\"addr_cd_1\"     value=\"$addr_cd_1\"     />
<input type=\"hidden\" name=\"addr_cd_2\"     value=\"$addr_cd_2\"     />
<input type=\"hidden\" name=\"pref\"          value=\"$pref\"          />
<input type=\"hidden\" name=\"city\"          value=\"$city\"          />
<input type=\"hidden\" name=\"add\"           value=\"$add\"           />
<input type=\"hidden\" name=\"Buil\"          value=\"$Buil\"          />
<input type=\"hidden\" name=\"tel\"           value=\"$tel\"           />
<input type=\"hidden\" name=\"ctel\"          value=\"$ctel\"          />
<input type=\"hidden\" name=\"mail\"          value=\"$mail\"          />
<input type=\"submit\" value=\"送信\">
";
//生年月日の整形=======================================================
if( $year == "" && $month == "" && $day == "" ){
	$year = "----";
	$month ="--";
	$day ="--";
}
//お問い合わせ内容=====================================================
$inquiry_msg="";
$inquiry_checkbox="";
if($report) {
	$inquiry_msg.= "<p>　".$report."</p>";
}
$inquiry_checkbox='
<div><!--box start-->
			<p>
			'.$marks.'
			お問い合わせ内容</p>
				'.$inquiry_msg.'
</div><!--box end-->
';
//ご連絡方法===========================================================
$request_line="";
$request_checkbox="";
//ご質問内容===========================================================
//$inquiry=mb_eregi_replace("\r","<br />",$inquiry);
$inquiry=nl2br($inquiry);
//memo
$request_msg=$inquiry;
$inquiry_box='
<div><!--box start-->
			<p>
			'.$marks.'
ご質問内容</p>
				'.$request_msg.'
</div><!--box end-->
';
//学年=================================================================
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
<div><!--box start-->
			<br />
			'.$marks.'
			お子様の氏名											
			<br />○'.$kidsname_kj_1.' '.$kidsname_kj_2.'		
			<br />○'.$kidsname_kn_1.' '.$kidsname_kn_2.'		
			<br />
			'.$marks.'
			性　別													
			<br />○'.$sex.'												
			<br />
			'.$marks.'
			学年													
			<br />○'.$gakunen_disp.''.$gakunen_text.'			
			<br />
			'.$marks.'
			お通いの小学校										
			<br />○'.$type.''.$school.'								
			<br />
			'.$marks.'
			保護者の氏名											
			<br />○'.$name_kj_1.' '.$name_kj_2.'					
			<br />○'.$name_kn_1.' '.$name_kn_2.'					
			<br />
			'.$marks.'
			郵便番号												
			<br />○'.$addr_cd_1.'					
			<br />
			'.$marks.'
			住　所													
			<br />○'.$pref.'												
			<br />○'.$city.'												
			<br />○'.$add.'												
			<br />○'.$Buil.'												
			<br />
			'.$marks.'
			電話番号												
			<br />○'.$tel.'												
			<br />
			'.$marks.'
			メールアドレス										
			<br />○'.$mail.'												
</div><!--box end-->

';

FOREACH( $_POST as $key => $val ){
$confirm .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\" />\n";
}
//チケットをHIDDENに格納===============================================
$confirm .='<input type="hidden" name="ticket" value="'.htmlspecialchars(($_SESSION['ticket']), ENT_QUOTES).'" />';
$hidden="";
$hidden1=$confirm1;
$hidden2=$confirm2;

//=====================================================================
$button1='';

?>
