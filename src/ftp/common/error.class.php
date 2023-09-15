<?
/*====================================================
    ���顼ɽ�����饹
====================================================*/
class DispErrMessage {
	
	var $_PARAM = Array();
	var $_DISP = Array();
	
	/*-------------------------------------
	   ���󥹥ȥ饯�� - ɽ���ͼ���
	-------------------------------------*/
	function DispErrMessage() {
		
		require( SYS_PATH."configs/param_error.conf" );
		$this->_PARAM = $param_error["val"];
		$this->_DISP = $param_error["disp"];
	}
	
	
	/*--------------------------------------------
	    ���顼����ɽ��
		_buffParam ... ɽ������ѥ�᡼��
		_buffTemp  ... ɽ������ƥ�ץ졼��
			"ALL"  ... ��HTML������
			"MAIN" ... �ᥤ����ʬ�Τ�
		_buffGoto  ... ����ɽ������ڡ������ɥ쥹
		_arrOther  ... ����¾����
			$_arrOther["ath_comment"] ... ���顼�����Ȱʳ��Υ����Ȥ�ɽ��
			$_arrOther["next_pass"]   ... "GET" or "POST"
			��������Ϥ��褦�ˡ�
	--------------------------------------------*/
	function ViewErrMessage( $_buffParam , $_buffTemp , $_buffGoto , $_arrOther ) {
		// ɽ�������ͤμ���
		list( $_result , $buffViewString ) = $this->GetViewString( $_buffParam );
		IF( $_result == 9 ){
			$buffViewString = $this->_DISP[0];
		}
		
		// �ͥ����å�
		IF( $_arrOther["next_pass"] == "" ){
			$_arrOther["next_pass"] = "POST";
		}
		
		// �ƥ�ץ졼�ȶ����ͤΥ��å�
		$arrMetaHeader = $_arrOther["meta"];
		$arrHeaderView = $_arrOther["header"];
		
		// ���̤�ɽ��
		IF( $_buffTemp == "ALL" ){
			require_once( SITE_PATH."error.tpl" );
		}ELSEIF( $_buffTemp == "USER" ){
			require_once( SYS_PATH."templates/error.tpl" );
		}ELSEIF( $_buffTemp == "USER-ALL" ){
			require_once( SYS_PATH."templates/error_all.tpl" );
		}ELSEIF( $_buffTemp == "PORTAL-USER" ){
			require_once( SYS_PATH."templates/portal/portal_error.tpl" );
		}ELSEIF( $_buffTemp == "PORTAL-USER-ALL" ){
			require_once( SYS_PATH."templates/portal/portal_error_all.tpl" );
		}
		
	}
	
	/*--------------------------------------
	    ���ꤵ�줿�ѥ�᡼����ɽ����Ƚ��
	--------------------------------------*/
	function GetViewString( $_buffParam2 ) {
		// �ѥ�᡼�����������
		$intCntParam = count( $this->_PARAM );
		
		// �ѥ�᡼���ο��ǲ�
		FOR( $iX=0; $iX<$intCntParam; $iX++ ){
			IF( $this->_PARAM[$iX] == $_buffParam2 ){
				$buffView = $this->_DISP[$iX];
				break;
			}
		}
		IF( $buffView != "" ){
			return array( 1 , $buffView );
		}ELSE{
			return array( 9 , "" );
		}
	}
}

?>
