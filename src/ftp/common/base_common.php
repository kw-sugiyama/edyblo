<?

/******************************************************************************

	���̴ؿ�

******************************************************************************/

/* �桼�������顼 */
function _user_error( $message,$err_html ){
	//$err_html = USER_PATH."/templates/error_user.tpl";
	$bodyhtml = join ( '', file ($err_html));
	//$message = mb_convert_encoding( $message,'SJIS','AUTO' );
	$bodyhtml = ereg_replace ("--ERROR_MESSAGE--",$message, $bodyhtml);
	return ( $bodyhtml );
}

/* �桼�������顼 2*/
function _user_error2( $message,$err_html ){
	//$err_html = USER_PATH."/templates/error.tpl";
	$bodyhtml = join ( '', file ($err_html));
	//$message = mb_convert_encoding( $message,'SJIS','AUTO' );
	$bodyhtml = ereg_replace ("--ERROR_MESSAGE--",$message, $bodyhtml);
	return ( $bodyhtml );
}



/*----------------------------------------------------------

	������̡ʥ��顼��ɽ���塢�����ڤ��ؤ�

----------------------------------------------------------*/

function basecom_ErrmsgJmp($gamenno,$outmessage,$php_errormsg) {

print <<<EOF

<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=EUC-JP">
<title> ���顼</title>
</head>
<body>
<div align="center">
<input type="hidden" name="stpos" value="1">
<table width="400" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td><br><br>
	<div align="center"><br>
	<br>
	<br>
	<font size="3" color="#FF6600">$outmessage<br></font><br>
	<br>
	<br>
	</div>
	</td>
</tr>
</table>
<form name="form1" action="" target="_top"> 
<input type=button value=" �� �� " onClick="history.back();"> 
</form>
</div>
</body>
</html>
EOF;

}

//�Ĥ���С������
function basecom_ErrmsgJmp_pre($gamenno,$outmessage,$php_errormsg) {

print <<<EOF

<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=EUC-JP">
<title> ���顼</title>
</head>
<body>
<div align="center">
<input type="hidden" name="stpos" value="1">
<table width="400" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td><br><br>
	<div align="center"><br>
	<br>
	<br>
	<font size="3" color="#FF6600">$outmessage<br></font><br>
	<br>
	<br>
	</div>
	</td>
</tr>
</table>
<form name="form1" action="" target="_top"> 
<input type=button value="�Ĥ���" onClick="window.close();"> 
</form>
</div>
</body>
</html>
EOF;

}
function basecom_ErrmsgJmp_User() {
	if( defined('COMMON_CONF'))
	{
		include ( COMMON_CONF );
		header("Location:{$param_common_url}error.html");
		
	}
	exit;
}

function basecom_ErrmsgJmp_User_2($gamenno,$outmessage,$php_errormsg) {
	define( 'HTMLTITLE','');

	header("Content-type: text/html;charset=EUC_JP");
//����å����б�
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: private");
	header("Pragma: private");
	include( INDEX_HEADER );
	include( HTML_LOGIN );
	include( HTMLHEADER );

print <<<EOF
<div align="center">
<table width="400" border="0" cellspacing="0" cellpadding="0">
<tr>
        <td><br><br>
        <div align="center"><br>
        <br>
        <br>
        <font size="3" color="#FF6600">$outmessage<br></font><br>
        <br>
        <br>
        </div>
        </td>
</tr>
</table>
</div>
EOF;
	include( HTMLFOOTER );
}


function basecom_ErrmsgJmp_User_3($gamenno,$outmessage,$php_errormsg) {
	define( 'HTMLTITLE','');

        header("Content-type: text/html;charset=EUC_JP");
//����å����б�
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: private");
        header("Pragma: private");
        include( INDEX_HEADER );
        include( HTML_LOGIN );
        include( HTMLHEADER );

print <<<EOF
<div align="center">
<table width="400" border="0" cellspacing="0" cellpadding="0">
<tr>
        <td><br><br>
        <div align="center"><br>
        <br>
        <br>
        <font size="3" color="#FF6600">$outmessage<br></font><br>
        <br>
        <br>
        </div>
        </td>
</tr>
</table>
</div>
EOF;
        include( HTMLFOOTER );
}


/*----------------------------------------------------------
    ������̡ʥ��顼��ɽ���塢�����ڤ��ؤ���
----------------------------------------------------------*/
function basecom_ErrmsgJmp2($gamenno,$outmessage,$php_errormsg) {

print <<<EOF
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
</head>
<body bgcolor="#FFFFFF" text="#000000">
  <div align="center">
    <input type="hidden" name="stpos" value="1">
    <table width="400" border="0" cellspacing="0" cellpadding="0">
      <tr>
	<td>
          <br><br>
          <div align="center">
            <font color=#FF6666></font>
            <br><br>
            <font size="3" color="#FF6600">$outmessage<br></font><br>
            <br><br>

EOF;
if ( $gamenno != "" ){
	print ("<form name=\"form1\" action=\"$gamenno\" target=\"_self\">\n"); 
	print ("<input type=submit value=\" �� �� \">\n"); 
	print ("</form>\n"); 
}
print <<<EOF

          </div>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
EOF;

}


/*----------------------------------------------------------
    ������̡ʥ��顼��ɽ���塢�����ڤ��ؤ���
----------------------------------------------------------*/
function basecom_ErrmsgJmp3( $gamenno , $outmessage , $php_errormsg , $strHidden ){

	IF( $gamenno != "" ){
		$strFormCode = "";
		$strFormCode .= "<form name=\"form1\" method=\"POST\" action=\"{$gamenno}\" target=\"_self\">\n";
		$strFormCode .= "  <input type=\"submit\" value=\" �� �� \">\n";
		$strFormCode .= $strHidden;
		$strFormCode .= "</form>\n";
	}

print <<<EOF
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
</head>
<body bgcolor="#FFFFFF" text="#000000">
  <div align="center">
    <input type="hidden" name="stpos" value="1">
    <table width="400" border="0" cellspacing="0" cellpadding="0">
      <tr>
	<td>
          <br><br>
          <div align="center">
            <font color=#FF6666></font>
            <br><br>
            <font size="3" color="#FF6600">$outmessage<br></font><br>
            <br><br>
            {$strFormCode}
          </div>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
EOF;

}


/*----------------------------------------------------------
    ������̡ʥ��顼��ɽ���塢�����ڤ��ؤ���
----------------------------------------------------------*/
function basecom_ErrmsgJmp4( $gamenno , $outmessage , $php_errormsg ) {

print <<<EOF
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
</head>
<body bgcolor="#FFFFFF" text="#000000">
  <div align="center">
    <input type="hidden" name="stpos" value="1">
    <table width="400" border="0" cellspacing="0" cellpadding="0">
      <tr>
	<td>
          <br><br>
          <div align="center">
            <font color=#FF6666></font>
            <br><br>
            <font size="3" color="#FF6600">$outmessage<br></font><br>
            <br><br>

EOF;
if ( $gamenno != "" ){
	print ("<form name=\"form1\" action=\"$gamenno\" target=\"_top\">\n"); 
	print ("<input type=submit value=\" �� �� \">\n"); 
	print ("</form>\n"); 
}
print <<<EOF

          </div>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
EOF;

}


/*----------------------------------------------------------

	���ռ����ؿ���

	�ʸ��ߤ����դλ�����ʬ��������դ������

----------------------------------------------------------*/

function basecom_GetDate1 ( $date, $sabun ) {

	$buf = split ( "-",$date );

	$newdate = date ( "Y-m-d", mktime(0,0,0,$buf[1],$buf[2]+$sabun,$buf[0]) );

	return ( $newdate );

}



/*----------------------------------------------------------

	���ռ����ؿ���

	�ʸ��ߤ����դ��ޤޤ�뽵�������ڤ�ǯ�����������

----------------------------------------------------------*/

function basecom_GetDate2 ( $date ) {

	$buf = split ( "-",$date );

	$youbi = date ( "w", mktime(0,0,0,$buf[1],$buf[2],$buf[0]) );

	$cnt = 0;

	while ( $cnt <= $youbi ) {

		$sabun = $youbi - $cnt;

		$outdat[$cnt] = date ( "Y-m-d", mktime(0,0,0,$buf[1],$buf[2]-$sabun,$buf[0]) );

		$cnt++;

	}

	while ( $cnt < 7 ) {

		$sabun = $cnt - $youbi;

		$outdat[$cnt] = date ( "Y-m-d", mktime(0,0,0,$buf[1],$buf[2]+$sabun,$buf[0]) );

		$cnt++;

	}

	return ( $outdat );

}



/*----------------------------------------------------------

	���ռ����ؿ���

	�ʸ��ߤ����դ�������ʿ�����������̡����η�������������

----------------------------------------------------------*/

function basecom_GetDate3 ( $date ) {

	$youbi = array ( "��","��","��","��","��","��","��" );

	$kyuDays["01-01"] = "��ö";	

	$kyuDays["02-11"] = "����ǰ��";	

	$kyuDays["04-29"] = "�ߤɤ����";	

	$kyuDays["05-03"] = "��ˡ��ǰ��";	

	$kyuDays["05-04"] = "��̱�ε���";	

	$kyuDays["05-05"] = "���ɤ����";	

	$kyuDays["11-03"] = "ʸ������";	

	$kyuDays["11-23"] = "��ϫ���դ���";	

	$kyuDays["12-23"] = "ŷ��������";	

	$datebuf = split ( "-",$date );

	$buf = "03-".floor(20.8431 + 0.242194 * ($datebuf[0] - 1980) - floor(($datebuf[0] - 1980)/4));  // ��ʬ���������

	$kyuDays["$buf"] = "��ʬ����";

	$buf = "09-".floor(23.2488 + 0.242194 * ($datebuf[0] - 1980) - floor(($datebuf[0] - 1980)/4));  // ��ʬ���������

	$kyuDays["$buf"] = "��ʬ����";



	// 2000ǯ�ʹߤ����ͤ���/�ΰ����(�裲������)�η׻�

	if ($datebuf[0] >= 2000 && ( $datebuf[1] == "01" || $datebuf[1] == "10")) {

		$startDay = date ( "w", mktime(0,0,0,$datebuf[1],1,$datebuf[0]) );

		if ($startDay <= 1) $happyMon = 7 + (2 - $startDay);

		else $happyMon = 14 - ($startDay - 2);

		if ($happyMon < 10) $happyMon = "0"."$happyMon";

   	$buf = "01-" . $happyMon;

		$kyuDays["$buf"] = "���ͤ���";

   	$buf = "10-" . $happyMon;

		$kyuDays["$buf"] = "�ΰ����";

	} else {

		$kyuDays["01-15"] = "���ͤ���";

		$kyuDays["10-10"] = "�ΰ����";

	}



        // 2003ǯ�ʹߤγ�����/��Ϸ����(�裳������)�η׻�

        if ($datebuf[0] >= 2003 && ( $datebuf[1] == "07" || $datebuf[1] == "09")) {

                $startDay = date ( "w", mktime(0,0,0,$datebuf[1],1,$datebuf[0]) );

                if ($startDay <= 1) $happyMon = 14 + (2 - $startDay);

                else $happyMon = 21 - ($startDay - 2);

        $buf = "07-" . $happyMon;

                $kyuDays["$buf"] = "������";

        $buf = "09-" . $happyMon;

                $kyuDays["$buf"] = "��Ϸ����";

        } else {

                $kyuDays["07-20"] = "������";

                $kyuDays["09-15"] = "��Ϸ����";

        }



	$buf2 = split ( "-",$date );

	$youbicd = date ( "w", mktime(0,0,0,$buf2[1],$buf2[2],$buf2[0]) );

	$nisuu = date ( "t", mktime(0,0,0,$buf2[1],$buf2[2],$buf2[0]) );

	$nowday = date ( "m-d", mktime(0,0,0,$buf2[1],$buf2[2],$buf2[0]) );

	$yesterday = date ( "m-d", mktime(0,0,0,$buf2[1],$buf2[2]-1,$buf2[0]) );

	$yesterday_yobi = date ( "w", mktime(0,0,0,$buf2[1],$buf2[2]-1,$buf2[0]) );

	if ( $youbicd == 0 || $kyuDays["$nowday"] != "" || ($kyuDays["$yesterday"] != "" && $yesterday_yobi == 0) )

		$holflg = 1;

	else

		$holflg = 0;



	return array ( $youbicd, $youbi[$youbicd],$holflg,$nisuu,$kyuDays );

}



/*----------------------------------------------------------

	���ռ����ؿ���

	�ʻ��ꤷ��������λ���������ǯ�����������

----------------------------------------------------------*/

function basecom_GetDate4 ( $sdate, $edate, $youbicd ) {



	$flg = 0;

	$cnt = 0;

	$cnt2 = 0;

	$sdatebuf = split ( "-", $sdate );

	$edatebuf = split ( "-", $edate );

	$edate = date ( "Y-m-d", mktime(0,0,0,$edatebuf[1],$edatebuf[2]+$cnt2,$edatebuf[0]) );

	while ( $flg==0 ) {

		$datebuf = date ( "Y-m-d", mktime(0,0,0,$sdatebuf[1],$sdatebuf[2]+$cnt2,$sdatebuf[0]) );

		$youbicdbuf = date ( "w", mktime(0,0,0,$sdatebuf[1],$sdatebuf[2]+$cnt2,$sdatebuf[0]) );

		if ( $youbicd == $youbicdbuf ) {

			$date[$cnt] = $datebuf;

			$cnt++;

		}

		$cnt2++;

		if ( $datebuf == $edate ) $flg = 1;

	}

	return array ( $cnt, $date );

}



/*----------------------------------------------------------

	���ռ����ؿ���

	�ʻ��ꤷ��������λ�������ǯ�����������

----------------------------------------------------------*/

function basecom_GetDate5 ( $sdate, $edate, $date ) {



	$flg = 0;

	$cnt = 0;

	$cnt2 = 0;

	$sdatebuf = split ( "-", $sdate );

	$edatebuf = split ( "-", $edate );

	$edate = date ( "Y-m", mktime(0,0,0,$edatebuf[1]+$cnt,1,$edatebuf[0]) );

	while ( $flg==0 ) {

		$datebuf = date ( "Y-m", mktime(0,0,0,$sdatebuf[1]+$cnt2,1,$sdatebuf[0]) );

		$datebuf2 = split ( "-", $datebuf );

		if ( checkdate($datebuf2[1],$date,$datebuf2[0]) ) {

			$newdate[$cnt] = $datebuf."-".$date;

			$cnt++;

		}

		$cnt2++;

		if ( $datebuf == $edate ) $flg = 1;

	}

	return array ( $cnt, $newdate );

}



/*----------------------------------------------------------

	���ռ����ؿ���

	�ʻ���ǯ������ǯ�٤������

----------------------------------------------------------*/

function basecom_GetDate6 ( $date,$stmonth ) {



	$datebuf = split ( "-", $date );

	$edmonth = $stmonth + 11;

	$year = $datebuf[0];

	if ( $edmonth > 12 ) {

		if ( 1 <= (int)$datebuf[1] && (int)$datebuf[1] <= $edmonth-12 )

			$year = $datebuf[0] - 1;

	}



	return ($year);

}



/*----------------------------------------------------------

	��������Σȣԣ̤ͣ�ɽ������

----------------------------------------------------------*/

function basecom_DspDateSelList ( $sufix, $mode, $curdate, $s_year,$e_year ) {



	$datebuf = split ( "-", $curdate );

	$yeartxt = $sufix."_year";

	$monthtxt = $sufix."_month";

	$daytxt = $sufix."_day";

	if ( $mode == 1 || $mode == 3 )

		$onchtext = "onchange=\"refNum($yeartxt,$monthtxt,$daytxt)\"";

	else

		$onchtext = "";



	print ( "<SELECT NAME=\"$yeartxt\" $onchtext>\n" );

	if ( $mode != 3 ) print ( "<OPTION value=\"\">̤��\n" );

	for ( $i=$s_year; $i<=$e_year; $i++ ) {

              	if ( $datebuf[0] == $i ) {

			print ( "<OPTION value=$i selected>$i\n" );

		} else {

			print ( "<OPTION value=$i>$i\n" );

		}

	}



	print ( "</SELECT>ǯ<SELECT NAME=\"$monthtxt\" $onchtext>\n" );

	if ( $mode != 3 ) print ( "<OPTION value=\"\">̤��\n" );

	for ( $i=1; $i<=12; $i++ ) {

	     if($i<10){

             	if ( $datebuf[1] == $i ) {

			print ( "<OPTION value=0$i selected>$i\n" );

		} else {

			print ( "<OPTION value=0$i>$i\n" );

		}

             }

	     else{

             	if ( $datebuf[1] == $i ) {

			print ( "<OPTION value=$i selected>$i\n" );

		} else {

			print ( "<OPTION value=$i>$i\n" );

		}

             }

	}



	print ( "</SELECT>��\n" );



	if ( $mode == 1 || $mode == 3 ) {

		print ( "<SELECT NAME=\"$daytxt\" $onchtext>\n" );

		if ( $mode != 3 ) print ( "<OPTION value=\"\">̤��\n" );

		for ( $i=1; $i<=31; $i++ ) {

		    if($i<10){

                	if ( $datebuf[2] == $i ) {

				print ( "<OPTION value=0$i selected>$i\n" );

			} else {

				print ( "<OPTION value=0$i>$i\n" );

			}

                      }

		    else{

                	if ( $datebuf[2] == $i ) {

				print ( "<OPTION value=$i selected>$i\n" );

			} else {

				print ( "<OPTION value=$i>$i\n" );

			}

                      }

		}

		print ( "</SELECT>��\n" );

	}



	return;

}





/*---------------------------------------------------

        ��������Σȣԣ̤ͣ�ɽ������(̤��ʤ�)

----------------------------------------------------*/

function basecom_DspDateSelList2 ( $sufix, $mode, $curdate, $s_year,$e_year ) {



        $datebuf = split ( "-", $curdate );

        $yeartxt = $sufix."_year";

        $monthtxt = $sufix."_month";

        $daytxt = $sufix."_day";

        if ( $mode == 1 || $mode == 3 )

                $onchtext = "onchange=\"refNum($yeartxt,$monthtxt,$daytxt)\"";

        else

                $onchtext = "";



        print ( "<SELECT NAME=\"$yeartxt\" $onchtext>\n" );

        for ( $i=$s_year; $i<=$e_year; $i++ ) {

                if ( $datebuf[0] == $i ) {

                        print ( "<OPTION value=$i selected>$i\n" );

                } else {

                        print ( "<OPTION value=$i>$i\n" );

                }

        }



        print ( "</SELECT> ǯ <SELECT NAME=\"$monthtxt\" $onchtext>\n" );

        for ( $i=1; $i<=12; $i++ ) {

                if ( $i<10 ) {

                        if ( $datebuf[1] == $i ) {

                                print ( "<OPTION value=0$i selected>$i\n" );

                        } else {

                                print ( "<OPTION value=0$i>$i\n" );

                        }

                } else {

                        if ( $datebuf[1] == $i ) {

                                print ( "<OPTION value=$i selected>$i\n" );

                        } else {

                                print ( "<OPTION value=$i>$i\n" );

                        }

                }

        }



        print ( "</SELECT> �� \n" );

        if ( $mode == 1 || $mode == 3 ) {

                print ( "<SELECT NAME=\"$daytxt\" $onchtext>\n" );

                for ( $i=1; $i<=31; $i++ ) {

                        if ( $i<10 ) {

                                if ( $datebuf[2] == $i ) {

                                        print ( "<OPTION value=0$i selected>$i\n" );

                                } else {

                                        print ( "<OPTION value=0$i>$i\n" );

                                }

                        } else {

                                if ( $datebuf[2] == $i ) {

                                        print ( "<OPTION value=$i selected>$i\n" );

                                } else {

                                        print ( "<OPTION value=$i>$i\n" );

                                }

                        }

                }

                print ( "</SELECT> �� \n" );

        }

        return;

}





/*----------------------------------------------------------

	��������Σȣԣ̤ͣ�ɽ������

----------------------------------------------------------*/

function basecom_DspTimeSelList ( $time,$id,$mode,$kizami ) {

	print ( "<select name=\"{$id}_hour\">\n" );

	if ( $time == "" ) $seltxtdef = "selected";

	else {

		$seltxtdef = "";

		$stbuf=explode(":",$time);

		$cur_min = 0;

		while ( $cur_min < 60 ) {

		if ( $cur_min < 10 ) $cur_min_txt = "0".$cur_min;

		else $cur_min_txt = $cur_min; 

			$seltxt_m["$cur_min_txt"] == "";

			$cur_min += $kizami;

			if ( $stbuf[1] == $cur_min_txt ) $seltxt_m["$cur_min_txt"] = "selected";

		}

	}

	if ( $mode == 1 ) print ( "<option value=\"\" $seltxtdef>̤��</option>\n" );

	for ( $i=0;$i<=23;$i++ ) {

		if ( $i<10 ) $val = "0".$i;

		else $val = $i;

		if ( $val == $stbuf[0] ) $seltxt_h = "selected";

		else $seltxt_h = "";

		print ( "<option value=\"$val\" $seltxt_h>$val</option>\n" );

	}

	print ( "</select>��\n" );

	print ( "<select name=\"{$id}_mini\">\n" );

	if ( $mode == 1 ) print ( "<option value=\"\" $seltxtdef>̤��</option>\n" );

	$cur_min = 0;

	while ( $cur_min < 60 ) {

		if ( $cur_min < 10 ) $cur_min_txt = "0".$cur_min;

		else $cur_min_txt = $cur_min; 

print <<<EOF

	<option value="$cur_min_txt" {$seltxt_m["$cur_min_txt"]}>$cur_min_txt</option>



EOF;

		$cur_min += $kizami;

	}

	print ( "</select>ʬ\n" );



}



/*----------------------------------------------------------

	��������Σȣԣ̤ͣ�ɽ������

----------------------------------------------------------*/

function basecom_DspTimeSelList_i ( $time,$id,$mode,$kizami ) {

 

    $mitei = mb_convert_encoding ( "̤��","SJIS","AUTO" );

    $ji = mb_convert_encoding ( "��","SJIS","AUTO" );

    $hun = mb_convert_encoding ( "ʬ","SJIS","EUC" );

    

       print ( "<select name=\"{$id}_hour\">\n" );

        if ( $time == "" ) $seltxtdef = "selected";

        else {

                $seltxtdef = "";

                $stbuf=explode(":",$time);

                $cur_min = 0;

                while ( $cur_min < 60 ) {

                if ( $cur_min < 10 ) $cur_min_txt = "0".$cur_min;

                else $cur_min_txt = $cur_min;

                        $seltxt_m["$cur_min_txt"] == "";

                        $cur_min += $kizami;

                        if ( $stbuf[1] == $cur_min_txt ) $seltxt_m["$cur_min_txt"] = "selected";

                }

        }

        if ( $mode == 1 ) print ( "<option value=\"\" $seltxtdef>$mitei</option>\n" );

        for ( $i=0;$i<=23;$i++ ) {

                if ( $i<10 ) $val = "0".$i;

                else $val = $i;

                if ( $val == $stbuf[0] ) $seltxt_h = "selected";

                else $seltxt_h = "";

                print ( "<option value=\"$val\" $seltxt_h>$val</option>\n" );

        }

        print ( "</select>$ji\n" );

        print ( "<select name=\"{$id}_mini\">\n" );

        if ( $mode == 1 ) print ( "<option value=\"\" $seltxtdef>$mitei</option>\n" );

        $cur_min = 0;

        while ( $cur_min < 60 ) {

                if ( $cur_min < 10 ) $cur_min_txt = "0".$cur_min;

                else $cur_min_txt = $cur_min;

print <<<EOF

        <option value="$cur_min_txt" {$seltxt_m["$cur_min_txt"]}>$cur_min_txt</option>



EOF;

                $cur_min += $kizami;

        }

        print ( "</select>$hun\n" );



}



/*----------------------------------------------------------

	����ɽ�ڡ�����������

----------------------------------------------------------*/



/*----------------------------------------------------------
        ����ɽ�ڡ�����������
	@$cur_num	--- ������̷��
	@$total		--- ������
	@$getnum	--- ������������
	@$stpos		--- �ɤ����Ф���
	@$edpos		--- ɽ�������
	@$page_num	--- �ڡ����ʥ�С�
	@$form_name	--- �ե������̾��
	@$stpos_name    --- hidden��̾��
----------------------------------------------------------*/
function basecom_page_change ( $cur_num,$total,$getnum,$stpos,$edpos,$page_num,$form_name,$stpos_name ) {



print <<<EOF
  <table border=0 cellspacing=0 cellpadding=2 width=700 class="px12">
    <tr>
EOF;

if ( $cur_num > 0 ) {
	print ( "<td width=\"150\">{$total} ���桡{$stpos} - {$edpos} ��</td>\n" );
} else {
	print ( "<td width=\"150\"><div align=\"right\">�����������Ϥ���ޤ���</div></td>\n" );
}

if ( $total <= $getnum ) {

  print ( "<td width=550><br>\n" );

} else {

  $endpos = $stpos + $cur_num -1;

  print ( "<td width=550>\n" );



  if ( $getnum < $stpos ) {

  $stpos_new = $stpos - $getnum;

print <<<EOF

  <input type="submit" value="����" onClick="return SetStartNo(this.form,$stpos_new);">��



EOF;

  }

  $page_no = (int)($stpos / $getnum) + 1;

  $start_page = $page_no - 4;

  if ( $start_page < 1 ) $start_page = 1;

  $end_page = $start_page + 9;

  if ( $end_page > $page_num ) $end_page = $page_num;

  print ( "Page: " );

  for ( $i=$start_page;$i<=$end_page;$i++ ) {

    $stpos_new = ($i-1) * $getnum + 1;

    if ( $stpos_new == $stpos )

      print ( "<span class=\"px14\"><b>$i</b></span> \n" );

    else

      print ( "<a href=\"javascript:SetStartNo2($stpos_new);\">$i</a> \n" );

  }



  if ( $endpos < $total ) {

  $stpos_new = $stpos + $cur_num;

print <<<EOF

  ��<input type="submit" value="����" onClick="return SetStartNo(this.form,$stpos_new);">

EOF;

  }

}

print <<<EOF

                        </td>

                </tr>

                </table>

<script language="JavaScript">

<!--

function SetStartNo(parts,no) {

  parts.{$stpos_name}.value = no;

  return true;

}



function SetStartNo2(no) {

  document.{$form_name}.{$stpos_name}.value = no;

  document.{$form_name}.submit();

}

//-->

</script>



EOF;



}



/*----------------------------------------------------------

	����ɽ�ڡ�����������
	ver3
----------------------------------------------------------*/



/*----------------------------------------------------------
        ����ɽ�ڡ�����������
	@$cur_num	--- ������̷��
	@$total		--- ������
	@$getnum	--- ������������
	@$stpos		--- �ɤ����Ф���
	@$edpos		--- ɽ�������
	@$page_num	--- �ڡ����ʥ�С�
	@$form_name	--- �ե������̾��
	@$stpos_name    --- hidden��̾��
----------------------------------------------------------*/
function basecom_page_change3 ( $cur_num , $total , $getnum , $stpos , $edpos , $page_num , $form_name , $stpos_name ) {
	
	
	$page .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"700\" class=\"px12\">\n";
 	$page .= "  <tr>\n";
	
	if ( $cur_num > 0 ) {
		$page .= "    <td width=\"150\">{$total} ���桡{$stpos} - {$edpos} ��</td>\n";
	}
	
	
	if ( $total <= $getnum ) {
		$page .= "    <td width=\"550\"><br>\n";
	} else {
		$endpos = $stpos + $cur_num -1;
		$page .= "    <td width=550>\n";
		if ( $getnum < $stpos ) {
			$stpos_new = $stpos - $getnum;
			$page .= "      <a href=\"javascript:SetStartNo({$stpos_new})\">���Υڡ���</a>\n";
		}
	}
	
	$page_no = (int)($stpos / $getnum) + 1;
	$start_page = $page_no - 4;
	if ( $start_page < 1 ) $start_page = 1;
	$end_page = $start_page + 9;
	if ( $end_page > $page_num ) $end_page = $page_num;
	$page .= "      Page: \n";
	
	for ( $i=$start_page;$i<=$end_page;$i++ ) {
		$stpos_new = ($i-1) * $getnum + 1;
		if ( $stpos_new == $stpos ){
			$page .= "      <span class=\"px14\"><b>$i</b></span> \n";
		}else{
			$page .= "      <a href=\"javascript:SetStartNo2($stpos_new);\">{$i}</a> \n";
		}
		
		if ( $endpos < $total ) {
			$stpos_new = $stpos + $cur_num;
			$page .= "      <a href=\"javascript:SetStartNo($stpos_new);\">���Υڡ���</a> \n";
		}

	}
	
	$page .= "    </td>\n";
	$page .= "  </tr>\n";
	$page .= "</table>\n";
	
	return $page;

}


/*----------------------------------------------------------

        ����ɽ�ڡ�����������

----------------------------------------------------------*/

function basecom_page_change_JS ( $cur_num,$total,$getnum,$stpos,$edpos,$page_num,$pos_name,$form_name ) {



print <<<EOF

                <table border=0 cellspacing=0 cellpadding=2 width=700 class="px14">

                <tr>



EOF;

if ( $cur_num > 0 )  print ( "<td width=\"180\">{$total} ���桡{$stpos} - {$edpos} ��</td>\n" );

else print ( "<td width=\"180\"><div align=\"right\">�����������Ϥ���ޤ���</div></td>\n" );



if ( $total <= $getnum ) {

  print ( "<td width=550><br>\n" );

} else {

  $endpos = $stpos + $cur_num -1;

  print ( "<td width=550>\n" );



  if ( $getnum < $stpos ) {

  $stpos_new = $stpos - $getnum;

print <<<EOF

  <input type="button" value="����" onClick="return SetStartNo_JS(document.{$form_name},$stpos_new);">��



EOF;

  }

  $page_no = (int)($stpos / $getnum) + 1;

  $start_page = $page_no - 4;

  if ( $start_page < 1 ) $start_page = 1;

  $end_page = $start_page + 9;

  if ( $end_page > $page_num ) $end_page = $page_num;

  print ( "Page: " );

  for ( $i=$start_page;$i<=$end_page;$i++ ) {

    $stpos_new = ($i-1) * $getnum + 1;

    if ( $stpos_new == $stpos )

      print ( "<span class=\"px14\"><b>$i</b></span>�� \n" );

    else

      print ( "<a href=\"javascript:SetStartNo2_JS($stpos_new);\">$i</a>�� \n" );

  }



  if ( $endpos < $total ) {

  $stpos_new = $stpos + $cur_num;

print <<<EOF

  ��<input type="button" value="����" onClick="return SetStartNo_JS(document.{$form_name},$stpos_new);">

EOF;

  }

}



print <<<EOF

                        </td>

                </tr>

                </table>

<script language="JavaScript">

<!--

function SetStartNo_JS(parts,no) {

  parts.{$pos_name}.value = no;

  parts.submit();

}



function SetStartNo2_JS(no) {

  document.{$form_name}.{$pos_name}.value = no;

  document.{$form_name}.submit();

}

//-->

</script>



EOF;



}



/*----------------------------------------------------------

        ����ɽ�ڡ�����������

----------------------------------------------------------*/

function basecom_page_change2 ( $cur_num,$total,$getnum,$stpos,$edpos,$page_num,$form_name ) {



print <<<EOF

                <table border=0 cellspacing=0 cellpadding=2 width=700 class="text">

                <tr>



EOF;

if ( $cur_num > 0 )  print ( "<td width=\"180\" class=\"txt14\">����{$total} ���{$stpos} - {$edpos} ���</td>\n" );

else print ( "<td width=\"150\" class=\"txt\"><div align=\"right\">�����������Ϥ���ޤ���</div></td>\n" );



if ( $total <= $getnum ) {

  print ( "<td width=520 class=\"txt\"><br>\n" );

} else {

  $endpos = $stpos + $cur_num -1;

  print ( "<td width=520 class=\"txt\">\n" );



  if ( $getnum < $stpos ) {

  $stpos_new = $stpos - $getnum;



print <<<EOF

  <input type="submit" value="����" onClick="return SetStartNo(this.form,$stpos_new);">��



EOF;

  }

  $page_no = (int)($stpos / $getnum) + 1;

  $start_page = $page_no - 4;

  if ( $start_page < 1 ) $start_page = 1;

  $end_page = $start_page + 9;

  if ( $end_page > $page_num ) $end_page = $page_num;

  print ( "Page: " );

  for ( $i=$start_page;$i<=$end_page;$i++ ) {

    $stpos_new = ($i-1) * $getnum + 1;

    if ( $stpos_new == $stpos )

      print ( "<span class=\"txt14\"><b>$i</b> </span>��\n\n" );

    else

      print ( "<a href=\"javascript:SetStartNo2($stpos_new);\"><span class=\"txt14\">$i</span></a>��\n\n" );

  }

 if ( $endpos < $total ) {

  $stpos_new = $stpos + $cur_num;

print <<<EOF

  ��<input type="submit" value="����" onClick="return SetStartNo(this.form,$stpos_new);">

EOF;

  }

}



print <<<EOF

                        </td>

                </tr>

                </table>

<script language="JavaScript">

<!--

function SetStartNo(parts,no) {

  parts.stpos.value = no;

  return true;

}



function SetStartNo2(no) {

  document.{$form_name}.stpos.value = no;

  document.{$form_name}.submit();

}

//-->

</script>



EOF;



}





/*----------------------------------------------------------

        ����ɽ�ڡ�����������20041021��α�ذ�����

----------------------------------------------------------*/

function basecom_page_change_For ( $cur_num,$total,$getnum,$stpos,$edpos,$page_num,$form_name,$now_no ) {



print <<<EOF

                <table border=0 cellspacing=0 cellpadding=2 width=700 class="text">

                <tr>



EOF;

if ( $cur_num > 0 )  print ( "<td width=\"180\" class=\"txt14\">����{$total} ���{$stpos} - {$edpos} ���</td>\n" );

else print ( "<td width=\"150\" class=\"txt\"><div align=\"right\">�����������Ϥ���ޤ���</div></td>\n" );



if ( $total <= $getnum ) {

  print ( "<td width=520 class=\"txt\"><br>\n" );

} else {

  $endpos = $stpos + $cur_num -1;

  print ( "<td width=520 class=\"txt\">\n" );



  if ( $getnum < $stpos ) {

  $stpos_new = $stpos - $getnum;

print <<<EOF

  <input type="submit" value="����" onClick="return SetStartNo(this.form,$stpos_new);">��



EOF;

  }

  $page_no = (int)($stpos / $getnum) + 1;

  $start_page = $page_no - 4;

  if ( $start_page < 1 ) $start_page = 1;

  $end_page = $start_page + 9;

  if ( $end_page > $page_num ) $end_page = $page_num;

  print ( "Page: " );

  for ( $i=$start_page;$i<=$end_page;$i++ ) {

    $stpos_new = ($i-1) * $getnum + 1;

    if ( $stpos_new == $stpos )

      print ( "<span class=\"txt14\"><b>$i</b> </span>��\n\n" );

    else

      print ( "<a href=\"javascript:SetStartNo2($stpos_new);\"><span class=\"txt14\">$i</span></a>��\n\n" );

  }

 if ( $endpos < $total ) {

  $stpos_new = $stpos + $cur_num;

print <<<EOF

  ��<input type="submit" value="����" onClick="return SetStartNo(this.form,$stpos_new);">

EOF;

  }

}



print <<<EOF

                        </td>

                </tr>

                </table>

<script language="JavaScript">

<!--

function SetStartNo(parts,no) {

  parts.stpos.value = no;

  return true;

}



function SetStartNo2(no) {

  document.{$form_name}.stpos.value = no;

  setPr( {$now_no} );

  document.{$form_name}.submit();

}

//-->

</script>



EOF;



}



/*----------------------------------------------------------

        ����ɽ�ڡ�����������(�Ŀ;�����)

----------------------------------------------------------*/

function basecom_page_change_u ( $cur_num,$total,$getnum,$stpos,$edpos,$page_num,$form_name ) {



print <<<EOF

                <table border=0 cellspacing=0 cellpadding=2 width=700 class="text">

                <tr>



EOF;

if ( $cur_num > 0 )  print ( "<td width=\"180\" class=\"txt14\">����{$total} ���{$stpos} - {$edpos} ���</td>\n" );

else print ( "<td width=\"150\" class=\"txt\"><div align=\"right\">�����������Ϥ���ޤ���</div></td>\n" );



if ( $total <= $getnum ) {

  print ( "<td width=520 class=\"txt\"><br>\n" );

} else {

  $endpos = $stpos + $cur_num -1;

  print ( "<td width=520 class=\"txt\">\n" );



  if ( $getnum < $stpos ) {

  $stpos_new = $stpos - $getnum;

print <<<EOF

  <input type="submit" value="����" onClick="return SetStartNo(this.form,$stpos_new);">��



EOF;

  }

  $page_no = (int)($stpos / $getnum) + 1;

  $start_page = $page_no - 4;

  if ( $start_page < 1 ) $start_page = 1;

  $end_page = $start_page + 9;

  if ( $end_page > $page_num ) $end_page = $page_num;

  print ( "Page: " );

  for ( $i=$start_page;$i<=$end_page;$i++ ) {

    $stpos_new = ($i-1) * $getnum + 1;

    if ( $stpos_new == $stpos )

      print ( "<span class=\"txt14\"><b>$i</b> </span>��\n\n" );

    else

      print ( "<a href=\"javascript:SetStartNo2($stpos_new);\"><span class=\"txt14\">$i</span></a>��\n\n" );

  }

 if ( $endpos < $total ) {

  $stpos_new = $stpos + $cur_num;

print <<<EOF

  ��<input type="submit" value="����" onClick="return SetStartNo(this.form,$stpos_new);">

EOF;

  }

}



print <<<EOF

                        </td>

                </tr>

                </table>

<script language="JavaScript">

<!--

function SetStartNo(parts,no) {

  parts.stpos_u.value = no;

  return true;

}



function SetStartNo2(no) {

  document.{$form_name}.stpos_u.value = no;

  document.{$form_name}.submit();

}

//-->

</script>



EOF;



}


/*----------------------------------------------------------
        ����ɽ�ڡ�����������
----------------------------------------------------------*/
function basecom_page_change_VAL( $cur_num , $total , $getnum , $stpos , $edpos , $page_num , $form_name , $stpos_name,$class ){
	
	$strViewData = "";
	$strViewData .= "  <table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"700\" class=\"px12\">\n";
	$strViewData .= "    <tr>\n";

	IF( $cur_num > 0 ){
		$strViewData .= "      <td width=\"150\">{$total} ���桡{$stpos} - {$edpos} ��</td>\n";
	}ELSE{
		$strViewData .= "      <td width=\"150\"><div align=\"right\" style=\"font-size:12px\">�����������Ϥ���ޤ���</div></td>\n";
	}

	IF( $total <= $getnum ){
		$strViewData .= "      <td width=\"550\"><br>\n";
	}ELSE{
		$endpos = $stpos + $cur_num -1;
		$strViewData .= "      <td width=\"550\">\n";
		
		IF( $getnum < $stpos ){
			$stpos_new = $stpos - $getnum;
			$strViewData .= "<input type=\"submit\" value=\"<<\" onClick=\"return SetStartNo(this.form,$stpos_new);\" class=\"{$class}\">��\n";
		}

		$page_no = (int)($stpos / $getnum) + 1;
		$start_page = $page_no - 4;
		if ( $start_page < 1 ) $start_page = 1;
		$end_page = $start_page + 9;
		if ( $end_page > $page_num ) $end_page = $page_num;
		
		$strViewData .= "Page: ";
		FOR( $i=$start_page; $i<=$end_page; $i++ ){
			$stpos_new = ($i-1) * $getnum + 1;
			IF( $stpos_new == $stpos ){
				$strViewData .= "<span class=\"px14\"><b>$i</b></span> \n";
			}ELSE{
				$strViewData .= "<a href=\"javascript:SetStartNo2($stpos_new);\">$i</a> \n";
			}
		}
		
		IF( $endpos < $total ){
			$stpos_new = $stpos + $cur_num;
			$strViewData .= "<input type=\"submit\" value=\">>\" onClick=\"return SetStartNo( this.form , $stpos_new );\" class=\"{$class}\">\n";
		}
		
	}

	$strViewData .= "      </td>\n";
	$strViewData .= "    </tr>\n";
	$strViewData .= "  </table>\n";
	$strViewData .= "  <script language=\"JavaScript\">\n";
	$strViewData .= "  <!--\n";
	$strViewData .= "  function SetStartNo(parts,no) {\n";
	$strViewData .= "  	parts.{$stpos_name}.value = no;\n";
	$strViewData .= "  	return true;\n";
	$strViewData .= "  }\n";
	$strViewData .= "  function SetStartNo2(no) {\n";
	$strViewData .= "  	document.{$form_name}.{$stpos_name}.value = no;\n";
	$strViewData .= "  	document.{$form_name}.submit();\n";
	$strViewData .= "  }\n";
	$strViewData .= "  //-->\n";
	$strViewData .= "  </script>\n";
	
	return $strViewData;
	
}




function _form_ArrConv( $arr,$flg ){
        /*------------------
        $arr 2�����ޤǤ�����
        $flg
        -------------------*/
       $new_arr = array();
       if(is_array( $arr) )
	{
       		reset( $arr );
	        while( list( $key,$val ) = each( $arr ) ){
                        $hidden_name = htmlspecialchars( stripslashes( $key ) );

                        if( is_array( $arr["{$key}"] ) ){

                                while( list( $arr_key,$arr_val ) = each( $arr["{$key}"] ) ){
                                        $$txt_name = $arr_val;
                                        list( $ret,$retval ) =  StringManage( $$txt_name,$flg);
                                        if( $ret === FALSE ){
                                                return( -1 );
                                        }
                                        $new_arr["{$hidden_name}"][] = $retval;
                                }

                        }else{

                                        $$txt_name = $val ;
                                        list( $ret,$retval ) =  StringManage( $$txt_name,$flg);
                                        if( $ret === FALSE  ){
                                                return( -1 );
                                        }
                                        $new_arr["{$hidden_name}"] = $retval;
                        }

	        }
	}
        return $new_arr;
}


function _form_Make_Hidden( $arr,$flg,$tmp_arr ){
	/*------------------
	$arr 2�����ޤǤ�����
	$flg
	-------------------*/
       $new_arr = array();
       reset( $arr );
        while( list( $key,$val ) = each( $arr ) ){
                        $hidden_name = htmlspecialchars( stripslashes( $key ) );

		if( array_search( $key,$tmp_arr ) === FALSE ){
			//2�������ä����
                        if( is_array( $arr["{$key}"] ) ){

                                while( list( $arr_key,$arr_val ) = each( $arr["{$key}"] ) ){
                                        $$txt_name = $arr_val;
                                        list( $ret,$retval ) =  StringManage( $$txt_name,$flg);
					if( $ret === FALSE ){
						return( -1 );
					}
                                        $new_arr[] = '<input type="hidden" name="'.$hidden_name.'[]" value="'.$retval.'" />';
                                }

			//1�����ξ��
                        }else{

                                        $$txt_name = $val ;
                                        list( $ret,$retval ) =  StringManage( $$txt_name,$flg);
					if( $ret === FALSE  ){
						return( -1 );
					}
                                        $new_arr[] = '<input type="hidden" name="'.$hidden_name.'" value="'.$retval.'" />';
                        }
		}

        }
        return $new_arr;
}

function StringManage( $strData , $strFLG ){
        //
        //$strFLG �γ�ǧ
        IF( $strFLG == "" || substr( $strFLG,0,1 ) != "/" || substr( $strFLG,strlen($strFLG)-1,1 ) != "/" ){
            $bolFLG = FALSE;
            $strAfterData = "";
            return array( $bolFLG , $strAfterData);
        }
        //
        $arrJyoken = explode( "/" , $strFLG );
        //�����Υ������
        $cntJyoken = count( $arrJyoken );
        //����ͥ����å�
        IF(  $arrJyoken[1] == "" ){
            $bolFLG = FALSE;
            $strAfterData = "";
            return array( $bolFLG , $strAfterData );
        }
        //
        //���ˤ��������Ƴ���
        $bufStrData = $strData;
        FOR( $iX=1;$iX<$cntJyoken-1;$iX++ ){
             SWITCH( $arrJyoken[$iX] ){
                     case "strip":
                          $bufStrData = stripslashes( $bufStrData );
                          break;
                     case "html":
                          $bufStrData = htmlspecialchars( $bufStrData );
                          break;
                     case "add":
                          $bufStrData = addslashes( $bufStrData );
                          break;
                     case "esc":
                          $bufStrData = pg_escape_string( $bufStrData );
                          break;
                     case "sjis":
                          $bufStrData = mb_convert_encoding( $bufStrData,'SJIS','ASCII,JIS,UTF-8,EUC-JP,SJIS' );
                          break;
                     case "euc":
                          $bufStrData = mb_convert_encoding( $bufStrData,'EUC_JP','ASCII,JIS,UTF-8,EUC-JP,SJIS' );
                          break;
                     case "utf":
                          $bufStrData = mb_convert_encoding( $bufStrData,'UTF-8','ASCII,JIS,UTF-8,EUC-JP,SJIS' );
                          break;
                     case "jis":
                          $bufStrData = mb_convert_encoding( $bufStrData,'JIS','ASCII,JIS,UTF-8,EUC-JP,SJIS' );
                          break;
                     default:
                          $bolFLG = FALSE;
                          $strAfterData = "";
                          return array( $bolFLG , $strAfterData );
                          break;
             }
        }
        //
        //�������ʸ������֤�
        $strAfterData = $bufStrData;
        $bolFLG = TRUE;
        return array( $bolFLG , $strAfterData);
}

	//��ƻ�ܸ�ɽ��
        function _PrefView( $param,$flg,$code ){
		//$param �ѥ�᡼���ǡ��� array['name'][]
		//$flg	1�����쥯�ȥꥹ�ȡ�2��̾��
		//$code	���פ����륳����

		$pbuf = '';
		$pname = '';
		switch($flg){
			case(1):
                		for( $p=0;$p<count($param['name']);$p++ ){
                         		if( $code == $p ) $psel = ' selected';
                          		else $psel = '';
                          		$pbuf .= '<option value="'.$p.'"'.$psel.'>'.$param['name'][$p].'</option>'."\n";
               			}
			break;
			case(2):
                		for( $p=0;$p<count($param['name']);$p++ ){
                                         if( $code == $p ){
                                               $pname = $param['name'][$p];
                                               $pbuf = $code;
						break;
                                         }
               			}
			break;
		}
                return array( $pbuf,$pname);
        }

	//���쥯�ȥꥹ��ɽ��
        function _SelectView( $param,$flg,$code ){
		//$param �ѥ�᡼���ǡ��� array['name'][]
		//$flg	1�����쥯�ȥꥹ�ȡ�2��̾��
		//$code	���פ����륳����
		$pbuf = '';
		$pname = '';
		switch($flg){
			case(1):
                		for( $p=0;$p<count($param['name']);$p++ ){
                         		if( $code == $param['val'][$p] ) $psel = ' selected';
                          		else $psel = '';
                          		$pbuf .= '<option value="'.$param['val'][$p].'"'.$psel.'>'.$param['name'][$p].'</option>'."\n";
               			}
			break;
			case(2):
                		for( $p=0;$p<count($param['name']);$p++ ){
                                         if( $code == $param['val'][$p] && $code != '' ){
                                               $pname = $param['name'][$p];
                                               $pbuf = $param['val'][$p];
						break;
                                         }
               			}
			break;
		}
                return array( $pbuf,$pname);
        }

        //�ã����£��ɽ��
        function _CheckView( $param,$flg,$code,$formname,$size ){
		//$param �ѥ�᡼���ǡ��� array['name'][]
		//$flg	1�����쥯�ȥꥹ�ȡ�2������å�����ڤ�ǡ���
		//$code	���פ����륳����
		//$formname	CheckBox̾��
		//$size		���֤��Ȥ�<BR>����
		

                $pbuf = '';
                $pname = '';
                switch($flg){
                        case(1):
                                for( $p=0;$p<count($param['name']);$p++ ){
					$psel = '';
					if( is_array( $code )  ){
                                        	if( array_search( $param['val'][$p],$code ) !== FALSE ) $psel = ' checked';
					}
                                        $pbuf .= '<input type="checkbox" name="'.$formname.'" value="'.$param['val'][$p].'"'.$psel.'>'.$param['name'][$p]."\n";

					if( ereg( '/',$size ) != ''  )
					{
						if( ereg( '/'.($p+1).'/',$size ) != ''  )
						{
							$pbuf .= '<br>';
						}
					}
					else
					{
						if( ($p+1)%$size == 0  ){
							$pbuf .= '<br>';
						}
					}
                                }
                        break;
                        case(2):
                                for( $p=0;$p<count($param['name']);$p++ ){
                                         if( array_search( $param['val'][$p],$code ) !== FALSE ){
                                               $pname .= $param['name'][$p].'/';
                                               $pbuf .= $param['val'][$p].'/';
                                                break;
                                         }
                                }
                        break;
                }
                return array( $pbuf,$pname);
        }

        //RADIO BUTTONɽ��
        function _RadioView( $param,$flg,$code,$formname,$size ){
                //$param �ѥ�᡼���ǡ��� array['name'][]
                //$flg  1�����쥯�ȥꥹ�ȡ�2������å�����ڤ�ǡ���
                //$code ���פ����륳����
                //$formname     CheckBox̾��
                //$size         ���֤��Ȥ�<BR>����
                $pbuf = '';
                $pname = '';
                switch($flg){
                        case(1):
                                for( $p=0;$p<count($param['name']);$p++ ){
                                        $psel = '';
                                        if( $param['val'][$p] == $code ) $psel = ' checked';
                                        $pbuf .= '<input type="radio" name="'.$formname.'" value="'.$param['val'][$p].'"'.$psel.'> '.$param['name'][$p]."\n";
                                        if( ($p+1)%(int)$size == 0  ){
                                                $pbuf .= '<br>';
                                        }
                                }
                        break;
                        case(2):
                                for( $p=0;$p<count($param['name']);$p++ ){
                                         if( $param['val'][$p] == $code  ){
                                               $pname .= $param['name'][$p];
                                               $pbuf .= $param['val'][$p];
                                                break;
                                         }
                                }
                        break;
                }
                return array( $pbuf,$pname);
        }


        //�������ɽ��
        function _JobView( $param,$flg,$code ){

                $pbuf = '';
                $pname = '';


                switch($flg){
                        case(1):
                                $pbuf .= '<table width="100%"  border="0" cellspacing="3" cellpadding="0" class="j12">';
                                for( $p=0;$p<count($param['name']);$p++ ){
                                        if( $p % 3 == 0 ) $pbuf .= '<tr>';

                                        if( $code == $param['code'][$p] ) $psel = ' checked';
                                        else $psel = '';

                                        $pbuf .= '<td><input type= "radio" name="job" value="'.$param['code'][$p].'"'.$psel.'>'.$param['name'][$p].$param['check'][$p].'</td>'."\n";

                                        if( ($p + 1) % 3 == 0 ) $pbuf .= '</tr>';
                                }

                                if( $p % 3 != 0 ){
                                        if( $p < 3 ){
                                                $loop = 3 - $p;
                                        }else{
                                                $amari = $p % 3;
                                                $loop = 3 - $amari;
                                        }
                                        for( $m=0;$m<$loop;$m++ ){
                                                $pbuf .= "<td> </td>\n";

                                        }
                                        $pbuf .= "</tr>";
                                }
                                $pbuf .= '</table>';
                        break;
                        case(2):
                                for( $p=0;$p<count($param['name']);$p++ ){
                                         if( $code == $param['code'][$p] ){
                                               $pname = $param['name'][$p];
                                               $pbuf = $param['code'][$p];
                                                break;
                                         }
                                }
                        break;
                }

                return array( $pbuf,$pname);
        }

/*----------------------------------------------------------
        ��������Σȣԣ̤ͣ�ɽ������	�桼����¦
----------------------------------------------------------*/
function basecom_DspDateUser ( $sufix, $mode, $curdate, $s_year,$e_year ) {

	$ret = '';
        $datebuf = split ( "-", $curdate );
        $yeartxt = $sufix."_year";
        $monthtxt = $sufix."_month";
        $daytxt = $sufix."_day";
        if ( $mode == 1 || $mode == 3 )
                $onchtext = "onchange=\"refNum($yeartxt,$monthtxt,$daytxt,1)\"";
        else
                $onchtext = "";

        $ret .= "<select name=\"$yeartxt\" $onchtext>\n";
        if ( $mode != 3 ) $ret .= "<option value=\"\">--</option>\n";
        for ( $i=$s_year; $i<=$e_year; $i++ ) {
                if ( $datebuf[0] == $i ) {
                        $ret .= "<option value=$i selected>$i</option>\n";
                } else {
                        $ret .= "<option value=$i>$i</option>\n";
                }
        }
        $ret .=  "</select>ǯ<select name=\"$monthtxt\" $onchtext>\n";
        if ( $mode != 3 ) $ret .= "<option value=\"\">--</option>\n";
        for ( $i=1; $i<=12; $i++ ) {
             if($i<10){
                if ( $datebuf[1] == $i ) {
                        $ret .=  "<option value=0$i selected>$i</option>\n";
                } else {
                        $ret .= "<option value=0$i>$i</option>\n";
                }
             }
             else{
                if ( $datebuf[1] == $i ) {
                        $ret .= "<option value=$i selected>$i</option>\n";
                } else {
                        $ret .= "<option value=$i>$i\n</option>";
                }
             }
        }

        $ret .= "</select>��\n";
        if ( $mode == 1 || $mode == 3 ) {
                $ret .= "<select name=\"$daytxt\" $onchtext>\n";
                if ( $mode != 3 ) $ret .= "<option value=\"\">--</option>\n";
                for ( $i=1; $i<=31; $i++ ) {
                    if($i<10){
                        if ( $datebuf[2] == $i ) {
                                $ret .= "<option value=0$i selected>$i</option>\n";
                        } else {
                                $ret .= "<option value=0$i>$i</option>\n";
                        }
                      }
                    else{
                        if ( $datebuf[2] == $i ) {
                                $ret .= "<option value=$i selected>$i</option>\n";
                        } else {
                                $ret .= "<option value=$i>$i</option>\n";
                        }
                      }
                }
                $ret .= "</select>��\n";
        }

        return $ret;
}


	function base_FormDisp( $confname,$postdata,$flg,$datatype,$dbrows,$config ){

		/*----------------------------------
			$confname :config��param_**�ޤǤ�ʸ�����Ϥ�
			$postdata : POST �ޤ��ϡ�DB������ͤ������������
			$flg	: DISPFORM���ե�����ɽ����DISPVIEW����������ǧ���̤ʤ�	COMMIT����Ͽ����
			$datatype : FORM �ե�����ǡ��� DB��DB����������ǡ���
                        $dbrows   : DB�����פΤ�Τˡ������ֹ��Ĥ����֤��Τ�ɬ��
			$config   : config�ե�����̾

		-----------------------------------*/
		
		require( COMMON_CONF );
		require( $config );
		$paramname = $confname.'_form';

                $formcnt =0;		//1�쥳����ʬ�Υ������
		$retarr = array();	//�����
                while( ${$paramname}['formname'][$formcnt] ){

                        $base_name = ${$paramname}['formname'][$formcnt];
                        $column_name = ${$paramname}['dbcolumn'][$formcnt];

                        $disp_name = 'disp_'.$base_name;
                        if( ${$paramname}['formsize'][$formcnt] == "" )  $size = 50;
                        else  $size = ${$paramname}['formsize'][$formcnt];
			switch( $datatype ){

				case( 'FORM' ):			//�ե����फ��Υǡ����ξ���stripslahses,htmlspecicalchars
					$base_data = $postdata["{$base_name}"];
					$str_flg = '/strip/html/';

				break;

				case( 'DB' ):			//DB����Υǡ����ξ���htmlspecialchars
                                	$base_data= $postdata["{$column_name}"];
					$str_flg = '/html/';
				break;
			}

			//ʸ�����󥳡��ɤ�Ĥ����ɤ�ؿ�

			switch( $flg ){

				case( 'DISPFORM' ):
                        		list($ret,$val ) = StringManage( $base_data,$str_flg);

					switch( ${$paramname}['formtype'][$formcnt] ){
						case('hidden'):
 		                      			$retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val.'">';
							if( ${$paramname}['option'][$formcnt] == 'VIEW' ){
 		                      				$retarr["{$disp_name}_VIEW"] .= $val.$retarr["{$disp_name}"];
							}
							if( ${$paramname}['option'][$formcnt] == 'VIEW_PARAM' ){
								$listname = $confname.'_'.${$paramname}['formname'][$formcnt];
								list( $sellist,$selval ) =  _SelectView( $$listname,2,$base_data );
 		                      				$retarr["{$disp_name}_VIEW"] .= $selval;
							}
						break;
						case('select'):
							$listname = $confname.'_'.${$paramname}['formname'][$formcnt];
							list( $sellist,$selval ) =  _SelectView( $$listname,1,$base_data );
							if( ereg( 'MULTIPLE' ,${$paramname}['option'][$formcnt] ) ){
								$listname = ${$paramname}['formname'][$formcnt].'[]';
								$multi = " multiple size={${$paramname}['formsize'][$formcnt]}";
							}else{
								$listname = ${$paramname}['formname'][$formcnt];
								$multi = "";
							}
 			                      		$retarr["{$disp_name}"] = '<select name="'.$listname.'"'.$multi.'>'.$sellist.'</select>';
						break;

                                                case('checkbox'):

							if( ereg( 'commitSLASH',${$paramname}['option'][$formcnt] ) ){

                                				//���쥮��顼���������ꥢ����
                                				$area_buf = explode( '/',$base_data );
                                				$base_data = $area_buf;
							}
                                                        $listname = $confname.'_'.${$paramname}['formname'][$formcnt];
                                                        list( $sellist,$selval ) =  _CheckView( $$listname,1,$base_data,$base_name.'[]',${$paramname}['formsize'][$formcnt] );
                                                        $retarr["{$disp_name}"] = $sellist.' ';
                                                break;

                                                case('radio'):

                                                        $listname = $confname.'_'.${$paramname}['formname'][$formcnt];
                                                        list( $sellist,$selval ) =  _RadioView( $$listname,1,$base_data,$base_name,${$paramname}['formsize'][$formcnt] );
                                                        $retarr["{$disp_name}"] = $sellist.' ';
                                                break;

						case('textarea'):
                                                        $retarr["{$disp_name}"] = '<textarea name="'.$base_name.'" '.$size.'>'.$val.'</textarea>';

						break;

		                                case('date'):
							if( $size ) $sizebuf = explode( '/',$size );
		                                        $now_year = date(Y);
							$start_year = $now_year+$sizebuf[0];
							$end_year = $now_year+$sizebuf[1];

							if( $datatype == 'DB' ){
								$daybuf =explode( '-',$base_data );
								if( $daybuf[0] != "" && $daybuf[1] != "" && $daybuf[2] != "" ){
									$enter_date1 = $daybuf[0].'-'.$daybuf[1].'-'.$daybuf[2];

									if( $daybuf[0] < $start_year ) $start_year = $daybuf[0]+$sizebuf[0];
									if( $daybuf[0] > $end_year ) $end_year = $daybuf[0]+$sizebuf[1];

								}else{
									$enter_date1 = '';
									
								}
							}elseif( $datatype == 'FORM' ){

                		                        	if( $postdata["{$base_name}_year"] != "" || $postdata["{$base_name}_month"] != "" || $postdata["{$base_name}_day"] != "")
                                		        	$enter_date1 =  $postdata["{$base_name}_year"]."-".$postdata["{$base_name}_month"]."-".$postdata["{$base_name}_day"];
		                                        	else $enter_date1 = "";

							}
							$enter_date1 = htmlspecialchars( $enter_date1 );
		                                        $retarr["{$disp_name}"] = basecom_DspDateUser ( $base_name,1,$enter_date1,$start_year,$end_year );

						break;

						//ǯ��ޤǤΥꥹ��
                                                case('datemonth'):
                                                        if( $size ) $sizebuf = explode( '/',$size );
                                                        $now_year = date(Y);
                                                        $start_year = $now_year+$sizebuf[0];
                                                        $end_year = $now_year+$sizebuf[1];

                                                        if( $datatype == 'DB' ){
                                                                $daybuf =explode( '-',$base_data );
                                                                if( $daybuf[0] != "" && $daybuf[1] != "" && $daybuf[2] != "" ){
                                                                        $enter_date1 = $daybuf[0].'-'.$daybuf[1].'-'.$daybuf[2];

                                                                        if( $daybuf[0] < $start_year ) $start_year = $daybuf[0]+$sizebuf[0];
                                                                        if( $daybuf[0] > $end_year ) $end_year = $daybuf[0]+$sizebuf[1];

                                                                }else{
                                                                        $enter_date1 = '';

                                                                }
                                                        }elseif( $datatype == 'FORM' ){

                                                                //if( $_POST["{$base_name}_year"] != "" || $_POST["{$base_name}_month"] != "" || $_POST["{$base_name}_day"] != "")
                                                                if( $postdata["{$base_name}_year"] != "" || $postdata["{$base_name}_month"] != "" || $postdata["{$base_name}_day"] != "")
                                                                $enter_date1 =  $postdata["{$base_name}_year"]."-".$postdata["{$base_name}_month"]."-".$postdata["{$base_name}_day"];
                                                                else $enter_date1 = "";

                                                        }
                                                        $enter_date1 = htmlspecialchars( $enter_date1 );
                                                        $retarr["{$disp_name}"] = basecom_DspDateUser ( $base_name,2,$enter_date1,$start_year,$end_year );

                                                break;

                                                case('zip'):
                                                        if( $size ) $sizebuf = explode( '/',$size );

                                                        $zipbuf =explode( '-',$base_data );
		                      			$retarr["{$disp_name}"] = '<input type="text" name="'.$base_name.'1" value="'.$zipbuf[0].'" size="'.$sizebuf[0].'"  maxlength="'.$sizebuf[2].'"> - ';
		                      			$retarr["{$disp_name}"] .= '<input type="text" name="'.$base_name.'2" value="'.$zipbuf[1].'" size="'.$sizebuf[1].'"  maxlength="'.$sizebuf[3].'">';
							$zipbuf=NULL;
							$sizebuf=NULL;

                                                break;

                                                case('tel'):
                                                        if( $size ) $sizebuf = explode( '/',$size );

                                                        $zipbuf =explode( '-',$base_data );
		                      			$retarr["{$disp_name}"] = '<input type="text" name="'.$base_name.'1" value="'.$zipbuf[0].'" size="'.$sizebuf[0].'">';
		                      			$retarr["{$disp_name}"] .= ' - <input type="text" name="'.$base_name.'2" value="'.$zipbuf[1].'" size="'.$sizebuf[1].'">';
		                      			$retarr["{$disp_name}"] .= ' - <input type="text" name="'.$base_name.'3" value="'.$zipbuf[2].'" size="'.$sizebuf[2].'">';
							$zipbuf=NULL;
							$sizebuf=NULL;

                                                break;

						case('file'):
 		                      			$retarr["{$disp_name}"] = '<input type="file" name="'.$base_name.'">';
		                      			$retarr["{$disp_name}"] .= '<input type="hidden" name="last_'.$base_name.'" value="'.$val.'">';
						break;

						case('textmax'):
                                			$text_buf = explode( '/',$size );
							
		                      			$retarr["{$disp_name}"] = '<input type="text" name="'.$base_name.'" value="'.$val.'" size="'.$text_buf[0].'" maxlength="'.$text_buf[1].'">';
						break;
					
						default:
		                      			$retarr["{$disp_name}"] = '<input type="text" name="'.$base_name.'" value="'.$val.'" size="'.$size.'">';
						break;
					}



				break;
				case( 'DISPVIEW' ):
                        		list($ret,$val ) = StringManage( $base_data,$str_flg);
					switch( ${$paramname}['formtype'][$formcnt] ){
                    				case( 'hidden' ):
 		                      			$retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val.'">';
							if( ${$paramname}['option'][$formcnt] == 'VIEW' ){
 		                      				$retarr["{$disp_name}_VIEW"] .= $val;
							}
						break;
                    				case( 'select' ):
							$listname = $confname.'_'.${$paramname}['formname'][$formcnt];
							list( $sellist,$selval ) =  _SelectView( $$listname,2,$base_data );
 			                      		$retarr["{$disp_name}"] = $selval;
						break;

		                		default:
		                      			$retarr["{$disp_name}"] = $val;
						break;
		                	}


				break;

				//����¦��DISPVIEW	--����ʤ���д���¦��缡�ڤ��ؤ�
                                case( 'DISPVIEW_USER' ):
                                        list($ret,$val ) = StringManage( $base_data,$str_flg);
                                        switch( ${$paramname}['formtype'][$formcnt] ){

                                                default:
                                                        $retarr["{$disp_name}"] = $val;
                                                break;

                                                case( 'select' ):
                                                        $listname = $confname.'_'.${$paramname}['formname'][$formcnt];
                                                        list( $sellist,$selval ) =  _SelectView( $$listname,2,$base_data );
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val.'">';
                                                        $retarr["{$disp_name}"] = $selval;
                                                break;

                                                case( 'radio' ):
                                                        $listname = $confname.'_'.${$paramname}['formname'][$formcnt];
                                                        list( $sellist,$selval ) =  _RadioView( $$listname,2,$base_data,$base_name,${$paramname}['formsize'][$formcnt] );
                                                        $retarr["{$disp_name}"] = $selval;
                                                break;

                                                case('date'):
                                                        $val1 = null;
                                                        $val2 = null;
                                                        $val3 = null;
                                                        $val1 = htmlspecialchars( stripslashes( $postdata["{$base_name}_year"] ) );
                                                        $val2 = htmlspecialchars( stripslashes( $postdata["{$base_name}_month"] ) );
                                                        $val3 = htmlspecialchars( stripslashes( $postdata["{$base_name}_day"] ) );
                                                        $retarr["{$disp_name}"] = $val1.'ǯ'.$val2.'��'.$val3.'��';

                                                break;

                                                case('datemonth'):
                                                        $val1 = null;
                                                        $val2 = null;
                                                        $val1 = htmlspecialchars( stripslashes( $postdata["{$base_name}_year"] ) );
                                                        $val2 = htmlspecialchars( stripslashes( $postdata["{$base_name}_month"] ) );
                                                        $retarr["{$disp_name}"] = $val1.'ǯ'.$val2.'��';
                                                break;

                                                case('textarea'):
                                                        $retarr["{$disp_name}"] = nl2br( $val );
                                                break;

                                        }


                                break;


                                case( 'DISPCONFIRM' ):
                                        list($ret,$val ) = StringManage( $base_data,$str_flg);
                                        switch( ${$paramname}['formtype'][$formcnt] ){
                                                case( 'hidden' ):
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val.'">';
                                                        if( ${$paramname}['option'][$formcnt] == 'VIEW' ){
                                                                $retarr["{$disp_name}_VIEW"] .= $val;
                                                        }
                                                break;
                                                case( 'select' ):
                                                        $listname = $confname.'_'.${$paramname}['formname'][$formcnt];
                                                        list( $sellist,$selval ) =  _SelectView( $$listname,2,$base_data );
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val.'">';
                                                        $retarr["{$disp_name}"] .= $selval;
                                                break;

                                                case( 'radio' ):
                                                        $listname = $confname.'_'.${$paramname}['formname'][$formcnt];
                                                        list( $sellist,$selval ) =  _RadioView( $$listname,2,$base_data,$base_name,${$paramname}['formsize'][$formcnt] );
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val.'">';
                                                        $retarr["{$disp_name}"] .= $selval;
                                                break;

                                                case('date'):
							$val1 = null;
							$val2 = null;
							$val3 = null;
							$val1 = htmlspecialchars( stripslashes( $postdata["{$base_name}_year"] ) );
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'_year" value="'.$val1.'">';
							$val2 = htmlspecialchars( stripslashes( $postdata["{$base_name}_month"] ) );
                                                        $retarr["{$disp_name}"] .= '<input type="hidden" name="'.$base_name.'_month" value="'.$val2.'">';
							$val3 = htmlspecialchars( stripslashes( $postdata["{$base_name}_day"] ) );
                                                        $retarr["{$disp_name}"] .= '<input type="hidden" name="'.$base_name.'_day" value="'.$val3.'">';

							$retarr["{$disp_name}"] .= $val1.'ǯ'.$val2.'��'.$val3.'��';

                                                break;
                                                case('zip'):
                                                        $val_up = null;
                                                        $val1 = null;
                                                        $val2 = null;
                                                        $val1 = htmlspecialchars( stripslashes( $postdata["{$base_name}1"] ) );
                                                        $val2 = htmlspecialchars( stripslashes( $postdata["{$base_name}2"] ) );
							if( $val1 != '' || $val2 != '' )
							{
								$val_up = $val1.'-'.$val2;
							}
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val_up.'">';

                                                        $retarr["{$disp_name}"] .= $val_up;

                                                break;

                                                case('tel'):
                                                        $val_up = null;
                                                        $val1 = null;
                                                        $val2 = null;
                                                        $val3 = null;
                                                        $val1 = htmlspecialchars( stripslashes( $postdata["{$base_name}1"] ) );
                                                        $val2 = htmlspecialchars( stripslashes( $postdata["{$base_name}2"] ) );
                                                        $val3 = htmlspecialchars( stripslashes( $postdata["{$base_name}3"] ) );
                                                        if( $val1 != '' || $val2 != '' || $val3 != '' )
                                                        {
                                                                $val_up = $val1.'-'.$val2.'-'.$val3;
                                                        }
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val_up.'">';

                                                        $retarr["{$disp_name}"] .= $val_up;

                                                break;

                                                case('datemonth'):
                                                        $val1 = null;
                                                        $val2 = null;
                                                        $val1 = htmlspecialchars( stripslashes( $postdata["{$base_name}_year"] ) );
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'_year" value="'.$val1.'">';
                                                        $val2 = htmlspecialchars( stripslashes( $postdata["{$base_name}_month"] ) );
                                                        $retarr["{$disp_name}"] .= '<input type="hidden" name="'.$base_name.'_month" value="'.$val2.'">';

                                                        $retarr["{$disp_name}"] .= $val1.'ǯ'.$val2.'��';
                                                break;

                                                case('textarea'):
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val.'">';
                                                        $retarr["{$disp_name}"] .= nl2br( $val );
                                                break;


                                                default:
                                                        $retarr["{$disp_name}"] = '<input type="hidden" name="'.$base_name.'" value="'.$val.'">';
                                                        $retarr["{$disp_name}"] .= $val;
                                                break;
                                        }


                                break;

				case( 'COMMIT' ):
						//COMMIT���ˤϥǡ����Υ��������פʤɤϹԤ�ʤ���magic_quote_gpc ON���� )
                        			$val =  $base_data;

						switch( ${$paramname}['formtype'][$formcnt] ){

							case('date'):
								if( $postdata["{$base_name}_year"] != "" && $postdata["{$base_name}_month"] != "" && $postdata["{$base_name}_day"] != ""  ){
									$val =  $postdata["{$base_name}_year"].'-'.$postdata["{$base_name}_month"].'-'.$postdata["{$base_name}_day"];
								}else{
									$val = '';
								}
							break;
							case('datemonth'):
								if( $postdata["{$base_name}_year"] != "" && $postdata["{$base_name}_month"] != ""   ){
									$val =  $postdata["{$base_name}_year"].'-'.$postdata["{$base_name}_month"];
								}else{
									$val = '';
								}
							break;
							case('checkbox'):
								if(  ereg( 'commitSLASH',${$paramname}['option'][$formcnt] ) && is_array( $postdata["{$base_name}"])  ){
									if( count( $postdata["{$base_name}"] ) > 0  ){
										$val = join('/',$postdata["{$base_name}"] );
										$val = '/'.$val.'/';
									}
								}
							break;

                                                	case( 'select' ):
                                                        	$listname = $confname.'_'.${$paramname}['formname'][$formcnt];
                                                        	list( $sellist,$selval ) =  _SelectView( $$listname,2,$base_data );
								$retarr["{$column_name}_text"][$dbrows] = addslashes( $selval );
                                                	break;

	                                                case('radio'):

        	                                                $listname = $confname.'_'.${$paramname}['formname'][$formcnt];
                	                                        list( $sellist,$selval ) =  _RadioView( $$listname,2,$base_data,$base_name,${$paramname}['formsize'][$formcnt] );
								$retarr["{$column_name}_text"][$dbrows] = addslashes( $selval );
                                	                break;

						}
					$retarr["{$column_name}"][$dbrows] = $val;
				break;
			}

                        $formcnt++;
                }

		return $retarr;

	}

/*--------------------------------------
DB����������[�ֹ�][ź����]�������ؤ���
-------------------------------------*/

	function base_DBarrChange( $outdat ){
		$dbarr = array();
                $dbcnt = 0;
                while( list( $key,$val ) = each( $outdat ) ){
                        while( list( $key2,$val2 ) = each( $outdat["{$key}"] ) ){
                                $dbarr[$key2]["{$key}"] = $val2;
                        }
                        $dbcnt++;
                }
		return $dbarr;
	}

/*--------------------------------------
	���ϥ����å�JS����
-------------------------------------*/

	function base_MakeChkJS( $confname,$config ){
		/*---------------------------------------------------
			$confname ���� �ѥ�᡼���ѿ� param_**
			$config	������ �ãϣΣƣɣǥե�����
		-----------------------------------------------------*/

		require( $config );
                $paramname = $confname.'_form';
		$jstxt = null;
                $formcnt =0;
                $retarr = array();
                while( ${$paramname}['formname'][$formcnt] ){
                        $base_name = ${$paramname}['formname'][$formcnt];
                        $alert_name = ${$paramname}['name'][$formcnt];
			$chkbuf = array();
			$chkbuf = explode('/',${$paramname}['check'][$formcnt]);

			$cnt=0;
			while($chkbuf[$cnt]){

				switch($chkbuf[$cnt]){
					//�̾�ƥ����ȤΣΣգ̣̥����å�
					case('null'):
						$jstxt .=       '	if ( parts.'.$base_name.'.value == "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��̤���ϤǤ�" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//���쥯�ȥꥹ�ȤΣΣգ̣̥����å�
					case('sellnull'):
						$jstxt .=       '	n = parts.'.$base_name.'.selectedIndex;'."\n";
						$jstxt .=       '	if ( parts.'.$base_name.'.options[n].value == "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��̤����Ǥ�" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//���ե��쥯�ȥꥹ�ȤΣΣգ̣̥����å�
					case('datenull'):
						$jstxt .=       '	n = parts.'.$base_name.'_year.selectedIndex;'."\n";
						$jstxt .=       '	nval = parts.'.$base_name.'_year.options[n].value;'."\n";
						$jstxt .=       '	if ( nval == "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��̤����Ǥ�" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'_year.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";
						$jstxt .=       '	n = parts.'.$base_name.'_month.selectedIndex;'."\n";
						$jstxt .=       '	nval = parts.'.$base_name.'_month.options[n].value;'."\n";
						$jstxt .=       '	if ( nval == "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��̤����Ǥ�" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'_month.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";
						$jstxt .=       '	n = parts.'.$base_name.'_day.selectedIndex;'."\n";
						$jstxt .=       '	nval = parts.'.$base_name.'_day.options[n].value;'."\n";
						$jstxt .=       '	if ( nval == "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��̤����Ǥ�" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'_day.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

                                        //ǯ��쥯�ȥꥹ�ȤΣΣգ̣̥����å�
                                        case('datemonthnull'):
                                                $jstxt .=       '       n = parts.'.$base_name.'_year.selectedIndex;'."\n";
                                                $jstxt .=       '       nval = parts.'.$base_name.'_year.options[n].value;'."\n";
                                                $jstxt .=       '       if ( nval == "" ) {'."\n";
                                                $jstxt .=       '               alert ( "'.$alert_name.'��̤����Ǥ�" );'."\n";
                                                $jstxt .=       '               parts.'.$base_name.'_year.focus();'."\n";
                                                $jstxt .=       '               return false;'."\n";
                                                $jstxt .=       '       }'."\n";
                                                $jstxt .=       '       n = parts.'.$base_name.'_month.selectedIndex;'."\n";
                                                $jstxt .=       '       nval = parts.'.$base_name.'_month.options[n].value;'."\n";
                                                $jstxt .=       '       if ( nval == "" ) {'."\n";
                                                $jstxt .=       '               alert ( "'.$alert_name.'��̤����Ǥ�" );'."\n";
                                                $jstxt .=       '               parts.'.$base_name.'_month.focus();'."\n";
                                                $jstxt .=       '               return false;'."\n";
                                                $jstxt .=       '       }'."\n";

                                        break;


                                        //��Ͽ�������ե����å�
                                        case('date'):
						$jstxt .=       '	nyval = parts.'.$base_name.'_year;'."\n";
						$jstxt .=       '	nmval = parts.'.$base_name.'_month;'."\n";
						$jstxt .=       '	ndval = parts.'.$base_name.'_day;'."\n";
                                                $jstxt .=       '       if ( refNum( nyval,nmval,ndval,2 ) == "-1" ) {'."\n";
                                                $jstxt .=       '               alert ( "'.$alert_name.'������������ޤ���" );'."\n";
                                                $jstxt .=       '               parts.'.$base_name.'_day.focus();'."\n";
                                                $jstxt .=       '               return false;'."\n";
                                                $jstxt .=       '       }'."\n";

					break;

					//�����å��ܥå����ΣΣգ̣̥����å�
					case('checknull'):
						$jstxt .=       '	chkcnt =0'."\n";
						$jstxt .=       '	for( m=0;m<parts.elements["'.$base_name.'[]"].length;m++){'."\n";
						$jstxt .=	'		if( parts.elements["'.$base_name.'[]"][m].checked ){'."\n";
						$jstxt .=       '			chkcnt++'."\n";
        					$jstxt .=	'		}'."\n";
        					$jstxt .=	'	}'."\n";
						$jstxt .=       '	if ( chkcnt == 0 ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��̤����Ǥ�" );'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//�饸���ܥ���ΣΣգ̣̥����å�
					case('radionull'):
						$jstxt .=       '	chkcnt =0'."\n";
						$jstxt .=       '	for( m=0;m<parts.elements["'.$base_name.'"].length;m++){'."\n";
						$jstxt .=	'		if( parts.elements["'.$base_name.'"][m].checked ){'."\n";
						$jstxt .=       '			chkcnt++'."\n";
        					$jstxt .=	'		}'."\n";
        					$jstxt .=	'	}'."\n";
						$jstxt .=       '	if ( chkcnt == 0 ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��̤����Ǥ�" );'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//�����ͤ��ɤ����Υ����å�
					case('int'):
						$jstxt .=       '	var str = parts.'.$base_name.'.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[0-9]+$/) && parts.'.$base_name.'.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��Ⱦ�ѿ��������Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//͹���ֹ��ѡ���-��ʬ��������ͤ��ɤ����Υ����å�
					case('zip'):
						$jstxt .=       '	var str = parts.'.$base_name.'1.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[0-9]+$/) && parts.'.$base_name.'1.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��Ⱦ�ѿ��������Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'1.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";
						$jstxt .=       '	var str = parts.'.$base_name.'2.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[0-9]+$/) && parts.'.$base_name.'2.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��Ⱦ�ѿ��������Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'2.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//�����ѡ���-��ʬ��������ͤ��ɤ����Υ����å�
					case('tel'):
						$jstxt .=       '	var str = parts.'.$base_name.'1.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[0-9]+$/) && parts.'.$base_name.'1.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��Ⱦ�ѿ��������Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'1.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";
						$jstxt .=       '	var str = parts.'.$base_name.'2.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[0-9]+$/) && parts.'.$base_name.'2.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��Ⱦ�ѿ��������Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'2.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";
						$jstxt .=       '	var str = parts.'.$base_name.'3.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[0-9]+$/) && parts.'.$base_name.'3.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��Ⱦ�ѿ��������Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'3.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//Ⱦ�ѱѿ������ɤ����Υ����å�
					case('alpha'):
						$jstxt .=       '	var str = parts.'.$base_name.'.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[a-zA-Z0-9]+$/) && parts.'.$base_name.'.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'��Ⱦ�ѱѿ��������Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//�������Ϣ�Υ����å����Ȥ��뵭�����ϥ����ƥ�ˤ�ä��ѹ�����
					case('login'):
						$jstxt .=       '	var str = parts.'.$base_name.'.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[a-zA-Z0-9%*#@]+$/)  && parts.'.$base_name.'.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'�˻��ѤǤ��ʤ�ʸ�����ޤޤ�Ƥ��ޤ���" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//�ѥ���ɤΥ����å����Ȥ��뵭�����ϥ����ƥ�ˤ�ä��ѹ�����
					case('passwd'):
						$jstxt .=       '	var str = parts.'.$base_name.'.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[a-zA-Z0-9%*#@]+$/)  && parts.'.$base_name.'.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'�˻��ѤǤ��ʤ�ʸ�����ޤޤ�Ƥ��ޤ���" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";
					break;


					//�������ʤ��ɤ����Υ����å�
					case('katakana'):
						$jstxt .=       '	var str = parts.'.$base_name.'.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^[��-����]+$/)  && parts.'.$base_name.'.value != "") {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'�ϥ������ʤ����Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

                                        //�Ҥ餬�ʤ��ɤ����Υ����å�
                                        case('hiragaana'):
                                                $jstxt .=       '       var str = parts.'.$base_name.'.value;'."\n";
                                                $jstxt .=       '       if (  !str.match( /^[��-��]+$/)  && parts.'.$base_name.'.value != "") {'."\n";
                                                $jstxt .=       '               alert ( "'.$alert_name.'�ϤҤ餬�ʤ����Ϥ��Ƥ���������" );'."\n";
                                                $jstxt .=       '               parts.'.$base_name.'.focus();'."\n";
                                                $jstxt .=       '               return false;'."\n";
                                                $jstxt .=       '       }'."\n";

                                        break;

					//�᡼�륢�ɥ쥹�Υ����å�
					case('mail'):
						$jstxt .=       '	var str = parts.'.$base_name.'.value;'."\n";
						$jstxt .=       '	if (  !str.match( /^\S+@\S+\.\S+$/)  && parts.'.$base_name.'.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'�����������Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;

					//�գң̤Υ����å�
					case('url'):
						$jstxt .=       '	var str = parts.'.$base_name.'.value;'."\n";
						$jstxt .=       '	if (  !str.match( /(http|https|ftp):\/\/[!#-9A-~]+\.+[a-z0-9]/i )  && parts.'.$base_name.'.value != "" ) {'."\n";
	               				$jstxt .=	'		alert ( "'.$alert_name.'�����������Ϥ��Ƥ���������" );'."\n";
	                			$jstxt .=	'		parts.'.$base_name.'.focus();'."\n";
                				$jstxt .=	'		return false;'."\n";
        					$jstxt .=	'	}'."\n";

					break;
					
					case('file'):
						$jstxt .=       '        if ( parts.img_flg.value == "1" ){'."\n";
						$jstxt .=       '                var str = parts.'.$base_name.'.value;'."\n";
						$jstxt .=       '                if(!str.match(/\.(jpe?g?|png|gif)$/i)){'."\n";
						$jstxt .=       '                        alert("�����ե�����γ�ĥ�Ҥ��ǧ���Ƥ���������");'."\n";
						$jstxt .=       '                        return false;'."\n";
						$jstxt .=       '                }'."\n";
						$jstxt .=       '        }'."\n";

					break;

					case('file_custom'):
						$jstxt .=       '        if ( parts.'.$base_name.'_img_flg.value == "1" ){'."\n";
						$jstxt .=       '                var str = parts.'.$base_name.'.value;'."\n";
						$jstxt .=       '                if(!str.match(/\.(jpe?g?|png|gif)$/i)){'."\n";
						$jstxt .=       '                        alert("�����ե�����γ�ĥ�Ҥ��ǧ���Ƥ���������");'."\n";
						$jstxt .=       '                        return false;'."\n";
						$jstxt .=       '                }'."\n";
						$jstxt .=       '        }'."\n";

					break;

					case('conf'):
									$base_name_forconf = ereg_replace( '_conf$','', $base_name );
						$jstxt .=       '        if ( parts.'.$base_name.'.value !=  parts.'.$base_name_forconf.'.value ){'."\n";
						$jstxt .=       '                        alert("'.$alert_name.'���ۤʤäƤ��ޤ���");'."\n";
						$jstxt .=       '                        return false;'."\n";
						$jstxt .=       '        }'."\n";

					break;

					//���쥮��顼���������äȷ���
					case('each_tel'):
						$jstxt .=       '        tel_flg = 0;'."\n";
						$jstxt .=       '        mobile_flg = 0;'."\n";
						$jstxt .=       '        if ( parts.tel_no1.value == "" || parts.tel_no2.value == "" || parts.tel_no3.value == "" ){'."\n";
						$jstxt .=       '                        tel_flg = -1;'."\n";
						$jstxt .=       '        }'."\n";
						$jstxt .=       '        if ( parts.mobile_no1.value == "" || parts.mobile_no2.value == "" || parts.mobile_no3.value == "" ){'."\n";
						$jstxt .=       '                        mobile_flg = -1;'."\n";
						$jstxt .=       '        }'."\n";
						$jstxt .=       '        if ( tel_flg == -1 && mobile_flg == -1 ){'."\n";
						$jstxt .=       '                        alert("���������ֹ�ʤ����Ϸ����ֹ�ɤ��餫�򤴵���������");'."\n";
						$jstxt .=       '                        return false;'."\n";
						$jstxt .=       '        }'."\n";

					break;


				}
			$cnt++;
			}



		$formcnt++;
		}
		return  $jstxt;

	}

//�ڡ�������HTML
function base_PageChange( $total,$nownum,$stpos,$getnum,$action){
        /*-------------------------------------
                $total : ���
                $nownum : ���ڡ�����ɽ����
                $stpos : ���ڡ����Υ��������ֹ�
                $getnum : ���ڡ����κ����
                $action : �����URL
        --------------------------------------*/

        /* �ڡ����ؤ��׻� */
        $edpos = $stpos +  $i;
        $page_num = (int)($total / $getnum);
        if ( $total%$getnum != 0 ) $page_num++;

        if( $page_num == 1 ){
                return( '' );

        }

        $now_page = (int)( $stpos/$getnum ) + 1;                //���ߤΥڡ���
	if( $page_num < 10 ){
       		$start_page = 1;
	}else{
       		$start_page = $now_page - 4;
	}
        if( $start_page < 1 ) $start_page = 1;
        $end_page = $start_page + 9;
        if( $end_page > $page_num ) $end_page = $page_num;      //�ڡ����ؤ���λ�ڡ���

        $now2_html = "";
        for( $m=$start_page;$m<=$end_page;$m++ ){
                $stpos_new = ( $m - 1 ) * $getnum + 1;
                if( $stpos_new == $stpos ){
                        $job_number .= "{$m}\n";
                }else{
                        $job_number .= "��<a href=\"{$action}?stpos=".$stpos_new."\"><u>".$m."</u></a>��\n";
                }
        }
        return ($job_number);
}

function base_PageChange_User( $total,$nownum,$stpos,$getnum,$action,$stpos_name,$uri,$form_name){
        /*-------------------------------------
                $total : ���
                $nownum : ���ڡ�����ɽ����
                $stpos : ���ڡ����Υ��������ֹ�
                $getnum : ���ڡ����κ����
                $action : �����URL
        --------------------------------------*/
	$job_number = array();

        /* �ڡ����ؤ��׻� */
        $edpos = $stpos +  $getnum;
        $page_num = (int)($total / $getnum);
        if ( $total%$getnum != 0 ) $page_num++;

        if( $page_num == 1 ){
                return array( NULL,NULL );
        }
	$job_number_bef = '';
	if ( $getnum < $stpos ) {
		$stpos_bef = $stpos - $getnum;
		//$job_number_bef = "<a href=\"{$action}?{$stpos_name}=".$stpos_bef.$uri."\">&lt;&lt;����{$getnum}��</a>����";
		$job_number_bef = "<a href=\"javascript:PageSubmit($stpos_bef);\">&lt;&lt;����{$getnum}��</a>����";
	}
        $job_number_next = '';
        if ( $edpos <= $total ) {
                $stpos_next = $stpos + $getnum;
		$disp_next = $total - $stpos_next;
		if( $total > $stpos_next+$getnum-1 ) $disp_next = $getnum;
		else $disp_next++;
                //$job_number_next = "����<a href=\"{$action}?{$stpos_name}=".$stpos_next.$uri."\">����{$disp_next}�� &gt;&gt;</a>";
                $job_number_next = "����<a href=\"javascript:PageSubmit($stpos_next);\">����{$disp_next}�� &gt;&gt;</a>";
        }


        $now_page = (int)( $stpos/$getnum ) + 1;                //���ߤΥڡ���
        if( $page_num < 10 ){
                $start_page = 1;
        }else{
                $start_page = $now_page - 4;
        }
        if( $start_page < 1 ) $start_page = 1;
        $end_page = $start_page + 9;
        if( $end_page > $page_num ) $end_page = $page_num;      //�ڡ����ؤ���λ�ڡ���

        $now2_html = "";
        for( $m=$start_page;$m<=$end_page;$m++ ){
                $stpos_new = ( $m - 1 ) * $getnum + 1;
                if( $stpos_new == $stpos ){
                        $job_number[] = "{$m}\n";
                }else{
                        //$job_number[] = " <a href=\"{$action}?{$stpos_name}=".$stpos_new.$uri."\">".$m."</a>\n";
                        $job_number[] = " <a href=\"javascript:PageSubmit($stpos_new);\">".$m."</a>\n";
                }
        }
	$job_number_ret	=  join( "��",$job_number );

	$js = "
	<script language=\"JavaScript\">
	<!--
		function PageSubmit(no) {
			document.{$form_name}.{$stpos_name}.value = no;
  			document.{$form_name}.submit();
		}

	//-->
	</script>
	";

        return array( $js,$job_number_bef.$job_number_ret.$job_number_next);
}


function base_PageChange_User_Seminar( $total,$nownum,$stpos,$getnum,$action,$stpos_name,$uri,$form_name){
        /*-------------------------------------
                $total : ���
                $nownum : ���ڡ�����ɽ����
                $stpos : ���ڡ����Υ��������ֹ�
                $getnum : ���ڡ����κ����
                $action : �����URL
        --------------------------------------*/
        $job_number = array();

        /* �ڡ����ؤ��׻� */
        $edpos = $stpos +  $getnum;
        $page_num = (int)($total / $getnum);
        if ( $total%$getnum != 0 ) $page_num++;

        if( $page_num == 1 ){
                return array( NULL,NULL );
        }
        $job_number_bef = '';
        if ( $getnum < $stpos ) {
                $stpos_bef = $stpos - $getnum;
                //$job_number_bef = "<a href=\"{$action}?{$stpos_name}=".$stpos_bef.$uri."\">&lt;&lt;����{$getnum}��</a>����";
                $job_number_bef = "<a href=\"javascript:PageSubmit_seminar($stpos_bef);\">&lt;&lt;����{$getnum}��</a>����";
        }
        $job_number_next = '';
        if ( $edpos <= $total ) {
                $stpos_next = $stpos + $getnum;
                $disp_next = $total - $stpos_next;
                if( $total > $stpos_next+$getnum-1 ) $disp_next = $getnum;
                else $disp_next++;
                //$job_number_next = "����<a href=\"{$action}?{$stpos_name}=".$stpos_next.$uri."\">����{$disp_next}�� &gt;&gt;</a>";
                $job_number_next = "����<a href=\"javascript:PageSubmit_seminar($stpos_next);\">����{$disp_next}�� &gt;&gt;</a>";
        }


        $now_page = (int)( $stpos/$getnum ) + 1;                //���ߤΥڡ���
        if( $page_num < 10 ){
                $start_page = 1;
        }else{
                $start_page = $now_page - 4;
        }
        if( $start_page < 1 ) $start_page = 1;
        $end_page = $start_page + 9;
        if( $end_page > $page_num ) $end_page = $page_num;      //�ڡ����ؤ���λ�ڡ���

        $now2_html = "";
        for( $m=$start_page;$m<=$end_page;$m++ ){
                $stpos_new = ( $m - 1 ) * $getnum + 1;
                if( $stpos_new == $stpos ){
                        $job_number[] = "{$m}\n";
                }else{
                        //$job_number[] = " <a href=\"{$action}?{$stpos_name}=".$stpos_new.$uri."\">".$m."</a>\n";
                        $job_number[] = " <a href=\"javascript:PageSubmit_seminar($stpos_new);\">".$m."</a>\n";
                }
        }
        $job_number_ret =  join( "��",$job_number );

        $js = "
        <script language=\"JavaScript\">
        <!--
                function PageSubmit_seminar(no) {
                        document.{$form_name}.{$stpos_name}.value = no;
                        document.{$form_name}.submit();
                }

        //-->
        </script>
        ";

        return array( $js,$job_number_bef.$job_number_ret.$job_number_next);

}

//�ڡ�������HTML
function base_PageChangeManage( $total,$nownum,$stpos,$getnum,$formname){
        /*-------------------------------------
                $total : ���
                $nownum : ���ڡ�����ɽ����
                $stpos : ���ڡ����Υ��������ֹ�
                $getnum : ���ڡ����κ����
                $formname : �����URL
        --------------------------------------*/

        /* �ڡ����ؤ��׻� */
        $edpos = $stpos +  $i;
        $page_num = (int)($total / $getnum);
        if ( $total%$getnum != 0 ) $page_num++;

        if( $page_num == 1 ){
                return( '' );

        }

        $now_page = (int)( $stpos/$getnum ) + 1;                //���ߤΥڡ���
        if( $page_num < 10 ){
                $start_page = 1;
        }else{
                $start_page = $now_page - 4;
        }
        if( $start_page < 1 ) $start_page = 1;
        $end_page = $start_page + 9;
        if( $end_page > $page_num ) $end_page = $page_num;      //�ڡ����ؤ���λ�ڡ���

        $now2_html = "";
        for( $m=$start_page;$m<=$end_page;$m++ ){
                $stpos_new = ( $m - 1 ) * $getnum + 1;
                if( $stpos_new == $stpos ){
                        $job_number .= "{$m}\n";
                }else{
                        $job_number .= "��<a href=\"javascript:SetStartNo2($stpos_new);\"><u>".$m."</u></a>��\n";
                }
        }

$job_number .= "
<script language=\"JavaScript\">
<!--
function SetStartNo(parts,no) {
  parts.stpos.value = no;
  return true;
}

function SetStartNo2(no) {
  document.{$formname}.stpos.value = no;
  document.{$formname}.submit();
}
//-->
</script>
";
        return ($job_number);
}

//�ڡ�������HTML
function base_PageChangeManage2( $total,$nownum,$stpos,$getnum,$stpos_name,$formname){
        /*-------------------------------------
                $total : ���
                $nownum : ���ڡ�����ɽ����
                $stpos : ���ڡ����Υ��������ֹ�
                $getnum : ���ڡ����κ����
                $formname : �����URL
        --------------------------------------*/

        /* �ڡ����ؤ��׻� */
        $edpos = $stpos +  $i;
        $page_num = (int)($total / $getnum);
        if ( $total%$getnum != 0 ) $page_num++;

        if( $page_num == 1 ){
                return( '' );

        }

        $now_page = (int)( $stpos/$getnum ) + 1;                //���ߤΥڡ���
        if( $page_num < 10 ){
                $start_page = 1;
        }else{
                $start_page = $now_page - 4;
        }
        if( $start_page < 1 ) $start_page = 1;
        $end_page = $start_page + 9;
        if( $end_page > $page_num ) $end_page = $page_num;      //�ڡ����ؤ���λ�ڡ���

        $now2_html = "";
        for( $m=$start_page;$m<=$end_page;$m++ ){
                $stpos_new = ( $m - 1 ) * $getnum + 1;
                if( $stpos_new == $stpos ){
                        $job_number .= "{$m}\n";
                }else{
                        $job_number .= "��<a href=\"javascript:SetStartNo2($stpos_new);\"><u>".$m."</u></a>��\n";
                }
        }


$job_number .= "
<script language=\"JavaScript\">
<!--
function SetStartNo(parts,no) {
  parts.{$stpos_name}.value = no;
  return true;
}

function SetStartNo2(no) {
  document.{$formname}.{$stpos_name}.value = no;
  document.{$formname}.submit();
}
//-->
</script>
";
        return ($job_number);
}

function calc_age($birth,$target)
{
    list($target_buf) = explode( ' ',$target);
    list($ty, $tm, $td) = explode('-', $target_buf);
    list($by, $bm, $bd) = explode('-', $birth);
    $age = $ty - $by;
    if($tm * 100 + $td < $bm * 100 + $bd) $age--;

    //���뤦ǯ���Ѳ�
    if( ( $bm == "2" || $bm == "02" ) && $bd == "29" )
    {
        //if ( date("L",$target) == 0 && (  ( $tm == "2" || $tm== "02" ) && $td == "28" ) )
        if ( date("L",mktime( 0,0,0,$tm,$td,$ty ) ) == 0 && (  ( $tm == "2" || $tm == "02" ) && $td == "28" ) )
        {
                $age++;
        }
    }
    return $age;
}


//�ڡ�������HTML������¦���������
function base_PageChangeOpenSite( $total,$nownum,$stpos,$getnum,$stpos_name,$formname,$pagenum){
        /*-------------------------------------
                $total : ���
                $nownum : ���ڡ�����ɽ����
                $stpos : ���ڡ����Υ��������ֹ�
                $getnum : ���ڡ����κ����
                $formname : �����URL
        --------------------------------------*/

        /* �ڡ����ؤ��׻� */
        $edpos = $stpos +  $i;
        $page_num = (int)($total / $getnum);
        if ( $total%$getnum != 0 ) $page_num++;

        if( $page_num == 1 ){
                return( '' );

        }

        $now_page = ceil( $stpos/$getnum );                //���ߤΥڡ���
        if( $page_num < $pagenum ){
                $start_page = 1;
        }elseif( $page_num == $now_page && $now_page - $pagenum > 0  ){

                $start_page = $now_page - $pagenum + 1;

	}else{
                $start_page = $now_page - floor( $pagenum/2 );
        }
        if( $start_page < 1 ) $start_page = 1;
        $end_page = $start_page + $pagenum -1;
        if( $end_page > $page_num ) $end_page = $page_num;      //�ڡ����ؤ���λ�ڡ���

        $now2_html = "";
	$next_url = "";
	$back_url = "";
	$job_number = "";
	$formname = htmlspecialchars( $formname );
        for( $m=$start_page;$m<=$end_page;$m++ ){
                $stpos_new = ( $m - 1 ) * $getnum + 1;
                //if( $stpos_new == $stpos ){
                if( $now_page == $m ){
                        $job_number .= "��{$m}\n";
			if( $m < $page_num)
			{
                		$stpos_next = $m * $getnum + 1;
				$next_url = "<a href=\"{$formname}&{$stpos_name}={$stpos_next}\">".���Υڡ���."</a>";
			}
			if( $m > 1 )
			{
                		$stpos_back = ( $m - 2 ) * $getnum + 1;
				$back_url = "<a href=\"{$formname}&{$stpos_name}={$stpos_back}\">".���Υڡ���."</a>";
			}
                }else{
                        $job_number .= "��<a href=\"{$formname}&{$stpos_name}={$stpos_new}\">".$m."</a>";
                }
        }
	if( $job_number ) $job_number .= "��";
        return ( $back_url.$job_number.$next_url );
}


/*----------------------------------------------------------
        ����ɽ�ڡ�����������
----------------------------------------------------------*/
function basecom_page_change_VAL_blank( $cur_num , $total , $getnum , $stpos , $edpos , $page_num , $form_name , $stpos_name,$class ){
	
	$strViewData = "";
	$strViewData .= "  <table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" width=\"600\" class=\"px12\">\n";
	$strViewData .= "    <tr align=\"right\">\n";

	IF( $cur_num > 0 ){
		$strViewData .= "      <td width=\"600\">{$total} ���桡{$stpos} - {$edpos} �\n";
	}ELSE{
		$strViewData .= "      <td width=\"600\"><div align=\"right\" style=\"font-size:12px\"></div>��\n";
//		$strViewData .= "      <td width=\"600\"><div align=\"right\" style=\"font-size:12px\">�����������Ϥ���ޤ���</div>��\n";
	}

	IF( $total <= $getnum ){
		$strViewData .= "      <br>\n";
	}ELSE{
		$endpos = $stpos + $cur_num -1;
		$strViewData .= "      \n";
		
		IF( $getnum < $stpos ){
			$stpos_new = $stpos - $getnum;
			$strViewData .= "<input type=\"submit\" value=\"<<\" onClick=\"return SetStartNo(this.form,$stpos_new);\" class=\"{$class}\">��\n";
		}

		$page_no = (int)($stpos / $getnum) + 1;
		$start_page = $page_no - 4;
		if ( $start_page < 1 ) $start_page = 1;
		$end_page = $start_page + 9;
		if ( $end_page > $page_num ) $end_page = $page_num;
		
		$strViewData .= "Page: ";
		FOR( $i=$start_page; $i<=$end_page; $i++ ){
			$stpos_new = ($i-1) * $getnum + 1;
			IF( $stpos_new == $stpos ){
				$strViewData .= "<span class=\"px14\"><b>$i</b></span> \n";
			}ELSE{
				$strViewData .= "<a href=\"javascript:SetStartNo2($stpos_new);\">$i</a> \n";
			}
		}
		
		IF( $endpos < $total ){
			$stpos_new = $stpos + $cur_num;
			$strViewData .= "<input type=\"submit\" value=\">>\" onClick=\"return SetStartNo( this.form , $stpos_new );\" class=\"{$class}\">\n";
		}
		
	}

	$strViewData .= "      </td>\n";
	$strViewData .= "    </tr>\n";
	$strViewData .= "  </table>\n";
	$strViewData .= "  <script language=\"JavaScript\">\n";
	$strViewData .= "  <!--\n";
	$strViewData .= "  function SetStartNo(parts,no) {\n";
	$strViewData .= "  	parts.{$stpos_name}.value = no;\n";
	$strViewData .= "  	return true;\n";
	$strViewData .= "  }\n";
	$strViewData .= "  function SetStartNo2(no) {\n";
	$strViewData .= "  	document.{$form_name}.{$stpos_name}.value = no;\n";
	$strViewData .= "  	document.{$form_name}.submit();\n";
	$strViewData .= "  }\n";
	$strViewData .= "  //-->\n";
	$strViewData .= "  </script>\n";
	
	return $strViewData;
	
}






?>
