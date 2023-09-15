<?
/*====================================================
    エラー表示クラス
====================================================*/
class DispErrMessage {
	
	var $_PARAM = Array();
	var $_DISP = Array();
	
	/*-------------------------------------
	   コンストラクタ - 表示値取得
	-------------------------------------*/
	function DispErrMessage() {
		
		require( SYS_PATH."configs/param_error.conf" );
		$this->_PARAM = $param_error["val"];
		$this->_DISP = $param_error["disp"];
	}
	
	
	/*--------------------------------------------
	    エラー画面表示
		_buffParam ... 表示するパラメータ
		_buffTemp  ... 表示するテンプレート
			"ALL"  ... 全HTMLソース
			"MAIN" ... メイン部分のみ
		_buffGoto  ... 次に表示するページアドレス
		_arrOther  ... その他情報
			$_arrOther["ath_comment"] ... エラーコメント以外のコメントを表示
			$_arrOther["next_pass"]   ... "GET" or "POST"
			※配列で渡すように。
	--------------------------------------------*/
	function ViewErrMessage( $_buffParam , $_buffTemp , $_buffGoto , $_arrOther ) {
		// 表示する値の取得
		list( $_result , $buffViewString ) = $this->GetViewString( $_buffParam );
		IF( $_result == 9 ){
			$buffViewString = $this->_DISP[0];
		}
		
		// 値チェック
		IF( $_arrOther["next_pass"] == "" ){
			$_arrOther["next_pass"] = "POST";
		}
		
		// テンプレート共通値のセット
		$arrMetaHeader = $_arrOther["meta"];
		$arrHeaderView = $_arrOther["header"];
		
		// 画面の表示
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
	    指定されたパラメータの表示値判別
	--------------------------------------*/
	function GetViewString( $_buffParam2 ) {
		// パラメータ数カウント
		$intCntParam = count( $this->_PARAM );
		
		// パラメータの数で回す
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
