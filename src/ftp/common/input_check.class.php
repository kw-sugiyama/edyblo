<?
/*====================================================
   ユーザー情報入力チェック処理クラス
====================================================*/

/*------------------------------------------------------------------------------------------
			:::::::::::::: 目次 :::::::::::::

	1.値存在チェック				... check_null( str )
	2.スペースのみチェック				... check_only_space( str );
	3.ひらがなチェック				... check_hiragana( str )
	4.カタカナチェック				... check_katakana( str )
	5.郵便番号チェック				... check_address_code( str )
	6.電話番号チェック("-"有無問わず・携帯不可)	... check_tell_1( str )
	7.電話番号チェック("-"必須)			... check_tell_2( str )
	8.携帯番号チェック("-"有無問わず)		... check_keitai_tell( str )
	9.携帯番号チェック("-"必須)			... check_keitai_tell( str )
	10.メールアドレスチェック			... check_email( str )
	11.携帯メールアドレスチェック			... check_keitai_mail( str )
	12.誕生日チェック				... check_birth( str )
	13.日付チェック					... check_date( str )
	14.半角数字のみチェック				... check_han_int( str )

------------------------------------------------------------------------------------------*/

class input_check
{
	
	
	/*------------------------------------------------------
	   値存在チェック
		引数   : $strData ... 入力された情報
		戻り値 : boolan型
				値あり ... true
				値なし ... false
	------------------------------------------------------*/
	function check_null( $strData )
	{
		if ( $strData == "" ) {
			return false;
		} else {
			return true;
		}
	}
	
	
	/*------------------------------------------------------
	   スペースのみチェック
		引数   : $strData ... 入力された情報
		戻り値 : boolan型
				スペースのみ         ... true
				スペースのみではない ... false
	------------------------------------------------------*/
	function check_only_space( $strData )
	{
		$ret = ereg( "^[ 　]+$" , $strData );
		if ( $ret == 1 ) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/*------------------------------------------------------
	   ひらがなチェック
		引数   : $strData ... 入力されたひらがな情報
				例 : 「くりっく」
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_hiragana( $strData )
	{
		$ret = mb_ereg( "^[ぁ-んヶヴー]+$" , $strData );
		IF( $ret == 1 ) {
			return false;
		}
		return true;
	}
	
	
	/*------------------------------------------------------
	   カタカナチェック
		引数   : $strData ... 入力されたカタカナ情報
				例 : 「クリック」
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_katakana( $strData )
	{
		$ret = mb_ereg( "^[ア-ン]+$" , $strData );
		IF( $ret == 1 ) {
			return false;
		}
		return true;
	}
	
	
	/*------------------------------------------------------
	   郵便番号チェック
		引数   : $strData ... 入力された郵便番号情報
				例 ： "370-0861"
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_address_code( $strData )
	{
		$ret = ereg( "^[0-9]{3}\-[0-9]{4}$" , $strData );
		IF( $ret == 0 ) {
			return false;
		}
		return true;
	}
	
	
	/*------------------------------------------------------
	   電話番号チェック("-"有無問わず・携帯不可)
		引数   : $strData ... 入力された電話番号情報
				例 ： "027-310-2101"
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_tell_1( $strData )
	{
		$ret = ereg( "^([0-9]{10})$|^([0-9]{2}((-[0-9]{2}([0-9]{2}|[0-9]{2}-))|([0-9]{2}-([0-9]{2}|[0-9]{2}-))|([0-9]{1}-[0-9]{1}([0-9]{2}|[0-9]{2}-))|([0-9]{3}([0-9]{1}-|-[0-9]{1}-|-[0-9]{1})))[0-9]{4})$" , $strData );
		IF( $ret == 0 ) {
			return false;
		}
		return true;
	}
	
	
	/*------------------------------------------------------
	   電話番号チェック("-"必須)
		引数   : $strData ... 入力された電話番号情報
				例 ： "027-310-2101"
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_tell_2( $strData )
	{
		if ( ereg( "^([0-9]{2}(-[0-9]{4}|[0-9]{1}-[0-9]{3}|[0-9]{2}-[0-9]{2}|[0-9]{3}-[0-9]{1})-[0-9]{4})$" , $strData ) === FALSE && ereg( "^([0-9]{3}-[0-9]{4}-[0-9]{4})$" , $strData ) === FALSE ) {
			return false;
		}
		return true;
	}
	
	
	/*------------------------------------------------------
	   携帯番号チェック("-"有無問わず)
		引数   : $strData ... 入力された携帯番号情報
				例 ： "090-1234-5678"
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_keitai_tell_1( $strData )
	{
		if ( ereg( "^[0-9]{3}(-|)[0-9]{4}(-|)[0-9]{4}$" , $strData ) === FALSE ) {
			return false;
		}
		return true;
	}
	
	
	/*------------------------------------------------------
	   携帯番号チェック("-"必須)
		引数   : $strData ... 入力された携帯番号情報
				例 ： "090-1234-5678"
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_keitai_tell_2( $strData )
	{
		if ( ereg( "^[0-9]{3}-[0-9]{4}-[0-9]{4}$" , $strData ) === FALSE ) {
			return false;
		}
		return true;
	}
	
	
	/*------------------------------------------------------
	   メールアドレスチェック
		引数   : $strData ... 入力されたメールアドレス情報
				例 ： "xxxx@ns.sp-jobnet.co.jp"
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_email( $strData )
	{
		if ( ereg( "^[_a-zA-Z0-9-]+[_a-zA-Z0-9\.-]+\@[a-zA-Z0-9-]+\.[a-zA-Z0-9\.-]+$" , $strData ) === FALSE ) {
			return false;
		}
		return true;
	}
	
	
	/*------------------------------------------------------
	   携帯メールアドレスチェック
		引数   : $strData ... 入力された携帯メールアドレス情報
				例 ： "xxxx@docomo.ne.jp"
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_keitai_mail( $strData )
	{
		
		$intChkFlg = 9;
		
		// docomo用
		if ( ereg( "^[a-z0-9].[_a-zA-Z0-9\.-]+@docomo\.ne\.jp$" , $strData ) === TRUE ) {
			$intChkFlg = 1;
		}
		// ezweb用
		if ( ereg( "^[a-z0-9].[_a-zA-Z0-9\.-]+@ezweb\.ne\.jp$" , $strData ) === TRUE ) {
			$intChkFlg = 1;
		}
		
		// vodafone(softbank)用
		if ( ereg( "^[a-z0-9].[_a-zA-Z0-9\.-]+@[a-z].vodafone\.ne\.jp$" , $strData ) === TRUE ) {
			$intChkFlg = 1;
		}
		if ( ereg( "^[a-z].[_a-zA-Z0-9\.-]+[_a-zA-Z0-9-].@softbank\.ne\.jp$" , $strData ) === TRUE ) {
			$intChkFlg = 1;
		}
		// willcom用
		if ( ereg( "^[a-z].[_a-zA-Z0-9\.-]+[_a-zA-Z0-9-].@pdx\.ne\.jp$" , $strData ) === TRUE ) {
			$intChkFlg = 1;
		}
		if ( ereg( "^[a-z].[_a-zA-Z0-9\.-]+[_a-zA-Z0-9-].@[a-z]{2}\.pdx\.ne\.jp$" , $strData ) === TRUE ) {
			$intChkFlg = 1;
		}
		
		if ( $intChkFlg == 1 ) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/*------------------------------------------------------
	   誕生日チェック
		引数   : $strData ... 入力された誕生日情報
				例 ： "1975-02-04"
		戻り値 : boolan型
				チェックOK ... true
				チェックNG ... false
	------------------------------------------------------*/
	function check_birth( $strData )
	{
		
		$arrData = explode( "-" , $strData );
		if ( checkdate( $arrData[1] , $arrData[2] , $arrData[0] ) === FALSE ) {
			return false;
		} else {
			return true;
		}
		
	}
	
	
	/*------------------------------------------------------
	   半角数字のみチェック
		引数   : $strData ... 入力された情報
				例 ： "1234"
		戻り値 : boolan型
				半角数字のみ     ... true
				半角数字以外あり ... false
	------------------------------------------------------*/
	function check_only_hanint( $strData )
	{
		$ret = ereg( "^[0-9]+$" , $strData );
		IF( $ret == 1 ){
			return true;
		}ELSE{
			return false;
		}
	}

}

?>
