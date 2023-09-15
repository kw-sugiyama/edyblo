/*=============================================================================
    入力チェック用JavaScript
	
	1.  NullCheck( val )			... 値の有無チェック
	2.  SpaceCheck( val )			... スペースのみチェック
	3.  AddCodeCheck( val )			... 郵便番号チェック
	4.  TellCheck_1( val )			... 電話番号チェック("-"の有無問わず・携帯不可)
	5.  TellCheck_2( val )			... 電話番号チェック("-"必須・携帯不可)
	6.  PhsCheck_1( val )			... 携帯番号チェック("-"の有無問わず)
	7.  PhsCheck_2( val )			... 携帯番号チェック("-"必須)
	8.  EmailCheck( val )			... メールアドレスチェック
	9.  PhsEmailCheck( val )		... 携帯メールアドレスチェック
	10. DateCheck_1( val )			... 日付チェック
	11. DateCheck_2( val1 , val2 )		... 日付比較チェック
	12. URLCheck( val )			... URLアドレスチェック
	13. LoginValCheck( val )		... ログインID・PASS用チェック
	14. IntValCheck( val )			... 半角数値のみチェック
	15. DataHankakuCheck( val )		... 半角小文字英数字のみチェック
	16. StrCountCheck( val , int )		... 文字数チェック
	17. ReturnCntCheck( val , int )		... 改行数チェック
	18. StrCountCheck_Equal( val , int )	... 文字数チェック(指定文字数と同じ)
	19. StrKatakanaCheck( val )		... 全角カタカナのみチェック
	20. FormSelectCheck( val , int )	... 指定個数のチェックがされているかチェック


	a-1. ReturnDetection( val )      ... 改行コード統一処理
	a-2. ReturnDelete( val )         ... 改行コード削除処理

=============================================================================*/


/*---------------------------------------------------------
    値の有無チェック
	引数　：val   ... 入力されたデータ
				(例："")
	返り値：true  ... 値あり
		false ... 値なし
---------------------------------------------------------*/
function NullCheck( val )
{
	
	if ( val == "" ) {
		return false;
	} else {
		return true;
	}
}


/*---------------------------------------------------------
    スペースのみチェック
	引数　：val   ... 入力されたデータ
				(例："あいうえお")
	返り値：true  ... スペースのみではない
		false ... スペースのみ
---------------------------------------------------------*/
function SpaceCheck( val )
{
	
	ret_val = val.match(/^[ 　]+$/);
	if ( ret_val ) {
		return false;
	} else {
		return true;
	}
}


/*---------------------------------------------------------
    郵便番号チェック
	引数　：val   ... 入力されたデータ
				(例："370-0861")
	返り値：true  ... 郵便番号である
		false ... 郵便番号でない
---------------------------------------------------------*/
function AddCodeCheck( val )
{
	
	ret_val = val.match(/^[0-9]{3}\-[0-9]{4}$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
}


/*---------------------------------------------------------
    電話番号チェック("-"の有無問わず・携帯不可)
	引数　：val   ... 入力されたデータ
				(例："0273102101")
	返り値：true  ... 電話番号として認識できる
		false ... 電話番号として認識できない
---------------------------------------------------------*/
function TellCheck_1( val )
{
	
	ret_val = val.match(/^[0-9]{10}$|^([0-9]{2}((\-[0-9]{2}([0-9]{2}|[0-9]{2}\-))|([0-9]{2}\-([0-9]{2}|[0-9]{2}\-))|([0-9]{1}\-[0-9]{1}([0-9]{2}|[0-9]{2}\-))|([0-9]{3}([0-9]{1}\-|\-[0-9]{1}\-|\-[0-9]{1})))[0-9]{4})$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
}


/*---------------------------------------------------------
    電話番号チェック("-"必須・携帯不可)
	引数　：val   ... 入力されたデータ
				(例："027-310-2101")
	返り値：true  ... 電話番号として認識できる
		false ... 電話番号として認識できない
---------------------------------------------------------*/
function TellCheck_2( val )
{
	
	ret_val = val.match(/^([0-9]{2}(\-[0-9]{4}|[0-9]{1}\-[0-9]{3}|[0-9]{2}\-[0-9]{2}|[0-9]{3}\-[0-9]{1})\-[0-9]{4})$/);
	if ( ret_val ) {
		return true;
	} else {
		ret_val2 = val.match(/^((050)(\-[0-9]{4}|[0-9]{4})(\-[0-9]{4}|[0-9]{4}))$/);
		if ( ret_val2 ) {
			return true;
		} else {
			return false;
		}
	}
}


/*---------------------------------------------------------
    携帯番号チェック("-"の有無問わず)
	引数　：val   ... 入力されたデータ
				(例："09012345678")
	返り値：true  ... 携帯番号である
		false ... 携帯番号でない
---------------------------------------------------------*/
function PhsCheck_1( val )
{
	
	ret_val = val.match(/^((090|080|070)[0-9]{8})$|^((090|080|070)(\-[0-9]{4}|[0-9]{4})(\-[0-9]{4}|[0-9]{4}))$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
}


/*---------------------------------------------------------
    携帯番号チェック("-"必須)
	引数　：val   ... 入力されたデータ
				(例："090-1234-5678")
	返り値：true  ... 携帯番号である
		false ... 携帯番号でない
---------------------------------------------------------*/
function PhsCheck_2( val )
{
	
	ret_val = val.match(/^((090|080|070)\-[0-9]{4}\-[0-9]{4})$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
}


/*---------------------------------------------------------
    メールアドレスチェック
	引数　：val   ... 入力されたデータ
				(例："oosawa@ns.sp-jobnet.co.jp")
	返り値：true  ... メールアドレスである
		false ... メールアドレスでない
---------------------------------------------------------*/
function EmailCheck( val )
{
	
	ret_val = val.match(/^[_a-zA-Z0-9\-]+[_a-zA-Z0-9\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\.\-]+$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
}


/*---------------------------------------------------------
    携帯メールアドレスチェック
	引数　：val   ... 入力されたデータ
				(例："oosawa@ezweb.ne.jp")
	返り値：true  ... 携帯メールアドレスである
		false ... 携帯メールアドレスでない
---------------------------------------------------------*/
function PhsEmailCheck( val )
{
	
	// docomo用
	ret_val_1 = val.match(/^[a-z0-9\-].[_a-zA-Z0-9\.\-]+@docomo\.ne\.jp$/);
	// ezweb用
	ret_val_2 = val.match(/^[a-z0-9\-].[_a-zA-Z0-9\.\-]+@ezweb\.ne\.jp$/);
	// vodafone用
	ret_val_3 = val.match(/^[a-z0-9].[_a-zA-Z0-9\.\-]+@[a-z].vodafone\.ne\.jp$/);
	ret_val_4 = val.match(/^[a-z].[_a-zA-Z0-9\.\-]+[_a-zA-Z0-9\-].@softbank\.ne\.jp$/);
	// willcom用
	ret_val_5 = val.match(/^[a-z].[_a-zA-Z0-9\.\-]+[_a-zA-Z0-9\-].@pdx\.ne\.jp$/);
	ret_val_6 = val.match(/^[a-z].[_a-zA-Z0-9\.\-]+[_a-zA-Z0-9\-].@[a-z]{2}\.pdx\.ne\.jp$/);
	if ( ret_val_1 || ret_val_2 || ret_val_3 || ret_val_4 || ret_val_5 || ret_val_6 ) {
		return true;
	} else {
		return false;
	}
}


/*---------------------------------------------------------
    日付チェック
	引数　：val   ... 入力されたデータ
				(例："1980-02-04")
	返り値：true  ... 正しい日付である
		false ... 正しい日付でない
---------------------------------------------------------*/
function DateCheck_1( val )
{
	
	var arrDate = new Array();
	
	// "-"で区切られているかチェック
	ret_val = val.match(/^[0-9]+\-[0-9]+\-[0-9]+$/);
	if ( ! ret_val ) {
		return false;
	}
	
	// val の値を"-"で分割
	//	arrDate[0] : 年
	//	arrDate[1] : 月
	//	arrDate[2] : 日
	arrDate = val.split("-");
	
	// 通常チェック
	if ( ( arrDate[1]==4 || arrDate[1]==6 || arrDate[1]==9 || arrDate[1]==11 ) && arrDate[2]>30 ){
		return false;
	}
	
	// 閏年チェック
	if ( arrDate[1] == 2 ) {
		if ( arrDate[0]%400==0 || ( arrDate[0]%100!=0 && arrDate[0]%4==0 ) ) {
			if ( arrDate[2] > 29 ) return false;
		} else {
			if ( arrDate[2] > 28 ) return false;
		}
	}
	
	return true;
}


/*---------------------------------------------------------
    日付比較チェック
	引数　：val1   ... 入力されたデータ(例:"1980-11-24")
		val2   ... 比較基準データ(例:"1980-12-23")
			※val2に値がない場合は既定値で現在の日付
	返り値："1"   ... "val1"は"val2"より後の日付
		"2"   ... "val1"は"val2"と同じ日付
		"3"   ... "val1"は"val2"より前の日付
		false ... エラー
---------------------------------------------------------*/
function DateCheck_2( val1 , val2 )
{
	
	var arrDate1 = new Array();
	var arrDate2 = new Array();
	
	// 引数値チェック
	if ( ! DateCheck_1( val1 ) || ! DateCheck_1( val2 ) ) {
		return false;
	}
	
	// 値を分解
	arrDate1 = val1.split("-");
	arrDate2 = val2.split("-");
	
	// 日付比較
	if ( arrDate1[0] == arrDate2[0] ){
		if ( arrDate1[1] == arrDate2[1] ) {
			if ( arrDate1[2] == arrDate2[2] ) {
				return 2;
			} else {
				if( arrDate1[2] < arrDate2[2] ) {
					return 3;
				} else {
					return 1;
				}
			}
		} else {
			if( arrDate1[1] < arrDate2[1] ) {
				return 3;
			} else {
				return 1;
			}
		}
	} else {
		if( arrDate1[0] < arrDate2[0] ) {
			return 3;
		} else {
			return 1;
		}
	}
	
}


/*---------------------------------------------------------
    URLアドレスチェック
	引数　：val   ... 入力されたデータ(例:http://www.sp-jobnet.co.jp/click)
	返り値：true  ... 正しいURLアドレスである
		false ... 正しいURLアドレスでない
---------------------------------------------------------*/
function URLCheck( val )
{
	
	ret_val = val.match(/^(http|https|ftp)(:\/\/)([-_\.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
	
}


/*---------------------------------------------------------
    ログインID・PASS用チェック
	引数　：val   ... 入力されたデータ(例:administrator)
	返り値：true  ... ログインＩＤ・ＰＡＳＳとして使用できる
		false ... ログインＩＤ・ＰＡＳＳとして使用できない
---------------------------------------------------------*/
function LoginValCheck( val )
{
	
	ret_val = val.match(/^[a-zA-Z0-9]+$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
	
}


/*---------------------------------------------------------
    半角数値のみチェック
	引数　：val   ... 入力されたデータ(例:10)
	返り値：true  ... 半角数字のみ
		false ... 半角数字のみではない
---------------------------------------------------------*/
function IntValCheck( val )
{
	
	ret_val = val.match(/^[0-9]+$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
	
}


/*---------------------------------------------------------
    半角小文字英数字のみチェック
	引数　：val   ... 入力されたデータ(例:aiueo)
	返り値：true  ... 半角小文字英数字のみ
		false ... 半角小文字英数字のみでない
---------------------------------------------------------*/
function DataHankakuCheck( val )
{
	ret_val = val.match(/^[a-z0-9]+$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
	
}


/*---------------------------------------------------------
    文字数チェック
	引数　：val   ... 入力されたデータ(例:aiueo)
		int   ... 文字数指定(例:5)
	返り値：true  ... 指定文字数内
		false ... 指定文字数内でない
---------------------------------------------------------*/
function StrCountCheck( val , int )
{
	var buffCnt = 0;
	var buffStr = "";
	
	// 改行コード統一
	buffStr = ReturnDetection( val );
	// 改行コード削除
	buffStr = ReturnDelete( buffStr );
	buffCnt = buffStr.length;
	if ( buffCnt > int ) {
		return false;
	}
	
	return true;
}


/*---------------------------------------------------------
    改行数チェック
	引数　：val   ... 入力されたデータ(例:aiueo)
		int   ... 改行数指定(例:5)
	返り値：true  ... 指定改行数内
		false ... 指定改行数内でない
---------------------------------------------------------*/
function ReturnCntCheck( val , int )
{
	var buffCnt = 0;
	var buffStr = "";
	var arrString = new Array;
	var intStrCnt = 0;
	
	buffStr = ReturnDetection( val );
	arrString = buffStr.split("\n");
	intStrCnt = arrString.length;
	
	if ( intStrCnt > int ) {
		return false;
	} else {
		return true;
	}
}


/*---------------------------------------------------------
    文字数チェック(指定文字数と同じ)
	引数　：val   ... 入力されたデータ(例:aiueo)
		int   ... 文字数指定(例:5)
	返り値：true  ... 指定文字内
		false ... 指定文字内でない
---------------------------------------------------------*/
function StrCountCheck_Equal( val , int )
{
	var buffCnt = 0;
	var buffStr = "";
	
	// 改行コード統一
	buffStr = ReturnDetection( val );
	// 改行コード削除
	buffStr = ReturnDelete( buffStr );
	buffCnt = buffStr.length;
	if ( buffCnt == int ) {
		return true;
	} else {
		return false;
	}
}


/*---------------------------------------------------------
    全角カタカナのみチェック
	引数　：val   ... 入力された文字列(例:aiueo)
	返り値：true  ... カタカナのみである
		false ... カタカナ以外に入っている
---------------------------------------------------------*/
function StrKatakanaCheck( val )
{
	
	ret_val = val.match(/^[ァ-ヶ]+$/);
	if ( ret_val ) {
		return true;
	} else {
		return false;
	}
	
}


/*---------------------------------------------------------
    指定個数のチェックがされているかチェック
	引数　：val   ... チェックされた要素(配列)
		int   ... チェックされている個数の指定(例:3)
		int2  ... 判定方法
				1: int =  チェックがあった個数
				2: int >  チェックがあった個数
				3: int >= チェックがあった個数
				4: int <  チェックがあった個数
				5: int <= チェックがあった個数
	返り値：true  ... 指定個数のチェックがされている
		false ... 指定個数のチェックがされていない
---------------------------------------------------------*/
function FormSelectCheck( val , int , int2 )
{
	var intBuffChk = 0;	/* チェックがあった個数 */
	var intBuffCnt = 0;	/* 渡された要素の個数 */
	
	intBuffCnt = val.length;
	for ( iX=0; iX<intBuffCnt; iX++ ) {
		if ( val[iX].checked === true ) {
			intBuffChk++;
		}
	}
	
	switch ( int2 ) {
		// イコール
		case 1:
			if ( intBuffChk == int ) {
				return true;
			} else {
				return false;
			}
			break;
		// 指定個数を含まない上
		case 2:
			if ( intBuffChk > int ) {
				return true;
			} else {
				return false;
			}
			break;
		// 指定個数を含む上
		case 3:
			if ( intBuffChk >= int ) {
				return true;
			} else {
				return false;
			}
			break;
		// 指定個数を含まない下
		case 4:
			if ( intBuffChk < int ) {
				return true;
			} else {
				return false;
			}
			break;
		// 指定個数を含む下
		case 5:
			if ( intBuffChk <= int ) {
				return true;
			} else {
				return false;
			}
			break;
		// エラー
		default:
			return false;
	}
}





/* ------ ここからチェック以外の処理 ------ */


/*---------------------------------------------------------
    改行コード統一処理
	引数　：val   ... 入力された文字列(例:aiueo)
	返り値：str   ... 統一された文字列
---------------------------------------------------------*/
function ReturnDetection( val )
{
	var buffStr = "";
	
	buffStr = val.replace( /\r/i , "\n" );
	buffStr = buffStr.replace( /\n\n/i , "\n" );
	
	return buffStr;
}


/*---------------------------------------------------------
    改行コード削除処理
	引数　：val   ... 入力された文字列(例:aiueo)
	返り値：str   ... 改行コードを削除された文字列
---------------------------------------------------------*/
function ReturnDelete( val )
{
	var buffStr = "";
	
	buffStr = val.replace( /\n/i , "" );
	
	return buffStr;
}

