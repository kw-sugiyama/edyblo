<?
//�������=============================================================
$marks= "<font color=\"#FF9999\">��</font>";
//ʬ������=============================================================
require_once( SYS_PATH."php/mobile/disp_box.php" );
require_once( SYS_PATH."php/mobile/disp_req.php" );
if($errf != 9){
		  require_once( SYS_PATH."templates/mobile/req.tpl" );
		  exit;
}
//��ǯ=================================================================
foreach($param_inq_gakunen["val"] as $key => $val) {
		  if ($gakunen == ""){
					 $gakunen_disp .= '';
		  }else if ($gakunen==$key) {
					 $gakunen_disp .= $val;
		  } else {
					 $gakunen_disp .= '';
		  }
}




//HIDDEN���ͤ��Ǽ=====================================================
$confirm="";
//$confirm='<form method="post" action="req_finish?cl='.$obj_login->clientdat[0]['cl_urlcd'].'" onsubmit="return false">';
//������ �Уϣӣԥ��å�================================================
$confirm1 ="
		  <form method=\"POST\" action=\"../req/\" accept-charset=\"Shift_JIS\">
		  <input type=\"hidden\" name=\"mailtype\"      value=\"$mailtype\"      />
		  <input type=\"hidden\" name=\"report1\"       value=\"$report1\"       />
		  <input type=\"hidden\" name=\"report2\"       value=\"$report2\"       />
		  <input type=\"hidden\" name=\"report3\"       value=\"$report3\"       />
		  <input type=\"hidden\" name=\"report4\"       value=\"$report4\"       />
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
		  <input type=\"submit\" value=\"���\"></form>
		  ";
$confirm2 .=
		  '
		  <form method="post" action="'._BLOG_SITE_URL_BASE.'req_finish/" accept-charset="Shift_JIS">
		  ';
$confirm2 .="
		  <input type=\"hidden\" name=\"mailtype\"      value=\"$mailtype\"      />
		  <input type=\"hidden\" name=\"report1\"       value=\"$report1\"       />
		  <input type=\"hidden\" name=\"report2\"       value=\"$report2\"       />
		  <input type=\"hidden\" name=\"report3\"       value=\"$report3\"       />
		  <input type=\"hidden\" name=\"report4\"       value=\"$report4\"       />
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
		  ";
$confirm2 .=
		  '
		  <input type="submit" value="����">
		  ';

//���������״ؿ�=======================================================
function esc ($st){
$str= $st;		  
$str = stripslashes($str);
$str = preg_replace("/,/","",$str);
return $str;
}
//���������׽���=======================================================
$mailtype      = htmlspecialchars("$_POST[mailtype]")     ;
$report1       = htmlspecialchars("$_POST[report1]")      ;
$report2       = htmlspecialchars("$_POST[report2]")      ;
$report3       = htmlspecialchars("$_POST[report3]")      ;
$report4       = htmlspecialchars("$_POST[report4]")      ;
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
//���������׽���=======================================================
$mailtype      =esc($mailtype     );
$report1       =esc($report1      );
$report2       =esc($report2      );
$report3       =esc($report3      );
$report4       =esc($report4      );
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
//�����åȤ�HIDDEN�˳�Ǽ===============================================
/*
$confirm .='<input type="hidden" name="ticket" value="'.htmlspecialchars(($_SESSION['ticket']), ENT_QUOTES).'" />';
 */

$hidden1="";
$hidden1=$confirm1;
$hidden2="";
$hidden2=$confirm2;
//����������������ǧHTML(��������ե�����)��������������
$confirm_form="";
$confirm_form=
		  '
		 <div><!--box start-->
		 <br /> 
'.$marks.'
�����ͤλ�̾
		 <br /> ��'.$kidsname_kj_1.' '.$kidsname_kj_2.'
		 <br /> ��'.$kidsname_kn_1.' '.$kidsname_kn_2.'
		 <br /> 
'.$marks.'
		 ������
		 <br /> ��'.$sex.'
		 <br /> 
'.$marks.'
		 ��ǯ
		 <br /> <span>��'.$gakunen_disp.'</span><span>'.$gakunen_text.'</span>
		 <br /> 
'.$marks.'
		 ���̤��ξ��ع�															
		 <br /> <span>��'.$type.'</span><span>'.$school.'</span>					
		 <br /> 
'.$marks.'
		 �ݸ�Ԥλ�̾																
		 <br /> ��'.$name_kj_1.' '.$name_kj_2.'										
		 <br /> ��'.$name_kn_1.' '.$name_kn_2.'										
		 <br /> 
'.$marks.'
		 ͹���ֹ�																	
		 <br /> ��'.$addr_cd_1.'										
		 <br /> 
'.$marks.'
		 ������																		
		 <br /> ��'.$pref.'																	
		 <br /> ��'.$city.'																	
		 <br /> ��'.$add.'																	
		 <br /> ��'.$Buil.'																	
		 <br /> 
'.$marks.'
		 �����ֹ�																	
		 <br /> ��'.$tel.'																	
		 <br /> 
'.$marks.'
		 �᡼�륢�ɥ쥹															
		 <br /> ��'.$mail.'																	
		 </div><!--box end-->
		  ';

$request_msg = $inquiry;
$request_msg = nl2br($request_msg);
//������ʤ�(��������)=================================================
$question_box="";
//���Ԥ������Ѵ�
//$request_msg=nl2br($request_msg);

$question_box='
		  <div><!--box start-->
		  ������ʤ�<br /><br />
		  '.$request_msg.'
		  </div><!--box end-->
		  ';
//��������=============================================================
$button2='
		  <div><!--box start-->
		  <p>
		  <!--<input type="image" src="share/images/bt_modoru'.$img_color.'_off.gif" onmouseover="this.src=\'share/images/bt_modoru'.$img_color.'_on.gif\'" onmouseout="this.src=\'share/images/bt_modoru'.$img_color.'_off.gif\'" onclick="location.href=\''._BLOG_SITE_URL_BASE.'req/\'" alt="" />����
		  </form>

		  <input type="submit" value="���">
		  </form>
		  <input type="image" src="share/images/bt_soushin2'.$img_color.'.gif" onmouseover="this.src=\'share/images/bt_soushin2b'.$img_color.'.gif\'" onmouseout="this.src=\'share/images/bt_soushin2'.$img_color.'.gif\'" onclick="submit();" alt="" /></p>

		  <br />

		  <input type="submit" value="����">
		  -->
		  </div><!--box end-->
		  ';

?>
