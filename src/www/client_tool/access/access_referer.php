<?
/******************************************************************************
<< ��ư���֥�����Ver.1.O.0 >>
        Name: access_log.php
        Version: 1.0.0
        Function: ������������ - ��ϩ������ɽ��
        Author: Click inc
        Date of creation: 2007/02
        History of modification:

        Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_log.conf" );


/*----------------------------------------------------------
  ���å������Ͽ����
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  ���顼���饹 - ���󥹥���
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  ���������������å�
----------------------------------------------------------*/
require_once("../login_chk.php");


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  ������ʬ
----------------------------------------------------------*/
IF( $_POST["sea_date_y"] != "" ){
	
	// ���ջ��ꤢ��
	$intBuffYear = $_POST["sea_date_y"];
	$intBuffMonth = $_POST["sea_date_m"];
	$intBuffDay = $_POST["sea_date_d"];
	
	// ������ʬ�򸫤��뤫�ɤ���
	$flgViewCheck = "inline";
	
	// �ե�����̾����
	$buffNameDate = $intBuffYear.$intBuffMonth.$intBuffDay;
	$buffLogFileName = $buffNameDate."_".$_SESSION["_cl_id"]."_log.txt";
	$buffLogFileAll = $param_log_dir.$_SESSION["_cl_id"]."/".$buffLogFileName;
	
	// �ե�����¸�ߥ����å�
	IF( file_exists( $buffLogFileAll ) === TRUE ){
		
		// �ե������ɤ߹���
		$fp_log = fopen( $buffLogFileAll , "r" );
		IF( !$fp_log ){
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "access_log.php" , $arrOther );
			exit;
		}
		
		// �ե��������Ʋ���
		$arrViewAddr = Array();
		$arrViewCount = Array();
		FOR( $iX=1; !feof($fp_log); $iX++ ){
			// �ѿ������
			$strLine = "";
			$arrLine = Array();
			// �ѿ���������
			$strLine = fgets( $fp_log );
			$arrLine = explode( "\t" , $strLine );
			//
			// arrLine[0] ... ��
			// arrLine[1] ... ʬ
			// arrLine[2] ... IP���ɥ쥹
			// arrLine[3] ... ɽ���ڡ���
			// arrLine[4] ... �֥饦������
			// arrLine[5] ... ��ϩ�����ɥ쥹
			// arrLine[6] ... �����������
			//
			IF( $arrLine[3] == $_POST["referer"] ){
				IF( array_search( $arrLine[5] , $arrViewAddr ) === FALSE ){
					// �ޤ�̵���Τ�����������
					$arrViewAddr[] = $arrLine[5];
					$arrViewCount[] = 1;
				}ELSE{
					// ���Ǥ�����ˤ���ΤǴ�¸�ǡ����η�������䤹
					$buffMatch = array_search( $arrLine[5] , $arrViewAddr );
					$arrViewCount[$buffMatch]++;
				}
			}
		}
		
		// ɽ����������
		$strViewData = "";
		$intCntData = count( $arrViewCount );
		arsort( $arrViewCount );
		$intBuffMaxCnt = 0;
		FOREACH( $arrViewCount as $key => $val ){
			
			// ������������
			$buffImgWidth = 0;
			IF( $intBuffMaxCnt == 0 ){
				$buffImgWidth = 100;
				$intBuffMaxCnt = $val;
			}ELSE{
				$buffImgWidth = intval( ( $val / $intBuffMaxCnt ) * 100 );
			}
			
			// ɽ����������
			$strViewData .= "<TR>\n";
                        $strViewData .= "  <TD>{$arrViewAddr[$key]}</TD>\n";
                        $strViewData .= "  <TD><IMG src=\"../share/images/access_log_bar.gif\" border=\"0\" width=\"{$buffImgWidth}\" height=\"15\" />&nbsp;({$arrViewCount[$key]})</TD>\n";
                        $strViewData .= "</TR>\n";
		}
		
	}ELSE{
		$strViewData = "";
		$strViewData .= "<TR>\n";
		$strViewData .= "  <TD colspan=\"3\">���Υ��ɥ쥹�η�ϩ������Ϥ���ޤ���</TD>\n";
		$strViewData .= "</TR>\n";
	}
	
}ELSE{
	$flgViewCheck = "none";
}


// ��������(ǯ)
$intStartYear = 2007;
$intEndYear = date("Y");
$viewSeaDate_y = "";
FOR( $iX=$intStartYear; $iX<=$intEndYear; $iX++ ){
	$strSel = "";
	IF( $intBuffYear == $iX ) $strSel = " selected";
	$viewSeaDate_y .= "<OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// ��������(��)
$viewSeaDate_m = "";
FOR( $iX=1; $iX<=12; $iX++ ){
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $intBuffMonth == $buffInt ) $strSel = " selected";
	$viewSeaDate_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$iX}</OPTION>\n";
}

// ��������(��)
$viewSeaDate_d = "";
FOR( $iX=1; $iX<=31; $iX++ ){
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $intBuffDay == $buffInt ) $strSel = " selected";
	$viewSeaDate_d .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$iX}</OPTION>\n";
}




/*----------------------------------------------------------
  �ȣԣͣ�����
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>��ư���֥��� - ���饤����ȥġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/access_log.css" />
    <SCRIPT type="text/javascript" src="../share/js/access_log.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/access_title.gif" alt="������������" />
    <HR color="#96BC69" />
    <TABLE id="access_log">
      <TR>
        <FORM name="sea_date" method="POST" action="access_log.php" target="_self">
        <TD colspan="2">
          <INPUT type="submit" value="<?=$intBuffYear?>ǯ<?=$intBuffMonth?>��<?=$intBuffDay?>���Υ����������Ϥ����" class="btn_nosize" />
        </TD>
        <INPUT type="hidden" name="sea_date_y" value="<?=$intBuffYear?>" />
        <INPUT type="hidden" name="sea_date_m" value="<?=$intBuffMonth?>" />
        <INPUT type="hidden" name="sea_date_d" value="<?=$intBuffDay?>" />
        </FORM>
      </TR>
      <TR>
        <TH>���ջ���</TH><TD><?=$intBuffYear?>ǯ<?=$intBuffMonth?>��<?=$intBuffDay?>��</TD>
      </TR>
      <TR>
        <TH>�ڡ�������</TH><TD><?=$_POST["referer"]?></TD>
      </TR>
    </TABLE>
    <BR />
    <DIV id="check_log">
    <TABLE>
      <TR>
        <TH width="650">��ϩ�����ɥ쥹</TH>
        <TH width="150">���(���)</TH>
      </TR>
<?=$strViewData?>
    </TABLE>
    </DIV>
  </BODY>
</HTML>