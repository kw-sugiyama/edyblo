/*=====================================================================
    お問合せ - 入力フォームチェック
=====================================================================*/
//お問い合せ
function inquiry_input_check( parts )
{
		// 氏名(漢字) - 姓(こども)
	if ( parts.kidsname_kj_1.value == "" ) {
		alert("お子様の氏名(漢字)-姓を入力して下さい。");
		parts.kidsname_kj_1.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.kidsname_kj_1.value ) ) {
			alert("お子様の氏名(漢字)-姓はスペースのみの入力はできません。");
			parts.kidsname_kj_1.focus();
			return false;
		}
	}
	
	
	// 氏名(漢字) - 名(こども)
	if ( parts.kidsname_kj_2.value == "" ) {
		alert("お子様の氏名(漢字)-名を入力して下さい。");
		parts.kidsname_kj_2.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.kidsname_kj_2.value ) ) {
			alert("お子様の氏名(漢字)-名はスペースのみの入力はできません。");
			parts.kidsname_kj_2.focus();
			return false;
		}
	}
	
	
	// 氏名(フリガナ) - 姓(こども)
	if ( parts.kidsname_kn_1.value == "" ) {
		alert("お子様の氏名(フリガナ)-姓を入力して下さい。");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.kidsname_kn_1.value ) ) {
		alert("お子様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.kidsname_kn_1.value ) ) {
		alert("お子様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.kidsname_kn_1.focus();
		return false;
	}
		
	// 氏名(フリガナ) - 姓(こども)
	if ( parts.kidsname_kn_2.value == "" ) {
		alert("お子様の氏名(フリガナ)-姓を入力して下さい。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.kidsname_kn_2.value ) ) {
		alert("お子様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.kidsname_kn_2.value ) ) {
		alert("お子様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	
	// お通いの学校
		//国立・県立・市立・私立
		if ( parts.type.value == "" ) {
			alert("お通いの学校（国・県・市・私）を入力して下さい。");
			parts.type.focus();
			return false;
		} else {
			// スペースのみチェック
			if ( !SpaceCheck( parts.type.value ) ) {
				alert("お通いの学校（国・県・市・私）はスペースのみの入力はできません。");
				parts.type.focus();
				return false;
			}
		}
		//学校名
		if ( parts.school.value == "" ) {
			alert("お通いの学校（学校名）を入力して下さい。");
			parts.school.focus();
			return false;
		} else {
			// スペースのみチェック
			if ( !SpaceCheck( parts.school.value ) ) {
				alert("お通いの学校（国立・県立・市立・私立）はスペースのみの入力はできません。");
				parts.school.focus();
				return false;
			}
		}


	// 氏名(漢字) - 姓（保護者）
	if ( parts.name_kj_1.value == "" ) {
		alert("保護者様の氏名(漢字)-姓を入力して下さい。");
		parts.name_kj_1.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("保護者様の氏名(漢字)-姓はスペースのみの入力はできません。");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// 氏名(漢字) - 名
	if ( parts.name_kj_2.value == "" ) {
		alert("保護者様の氏名(漢字)-名を入力して下さい。");
		parts.name_kj_2.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.name_kj_2.value ) ) {
			alert("保護者様の氏名(漢字)-名はスペースのみの入力はできません。");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// 氏名(フリガナ) - 姓(保護者)
	if ( parts.name_kn_1.value == "" ) {
		alert("保護者様の氏名(フリガナ)-姓を入力して下さい。");
		parts.name_kn_1.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.name_kn_1.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.name_kn_1.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.name_kn_1.focus();
		return false;
	}
		
	// 氏名(フリガナ) - 姓(保護者)
	if ( parts.name_kn_2.value == "" ) {
		alert("保護者様の氏名(フリガナ)-姓を入力して下さい。");
		parts.name_kn_2.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.name_kn_2.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.name_kn_2.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.name_kn_2.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.name_kn_2.focus();
		return false;
	}

	return true;
	
}


//コース/キャンペーンお問い合せ
function inquiry_input_check( parts )
{
	
		// 氏名(漢字) - 姓(こども)
	if ( parts.kidsname_kj_1.value == "" ) {
		alert("お子様の氏名(漢字)-姓を入力して下さい。");
		parts.name_kj_1.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.kidsname_kj_1.value ) ) {
			alert("お子様の氏名(漢字)-姓はスペースのみの入力はできません。");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// 氏名(漢字) - 名(こども)
	if ( parts.kidsname_kj_2.value == "" ) {
		alert("お子様の氏名(漢字)-名を入力して下さい。");
		parts.name_kj_2.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.kidsname_kj_2.value ) ) {
			alert("お子様の氏名(漢字)-名はスペースのみの入力はできません。");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// 氏名(フリガナ) - 姓(こども)
	if ( parts.kidsname_kn_1.value == "" ) {
		alert("お子様の氏名(フリガナ)-姓を入力して下さい。");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.kidsname_kn_1.value ) ) {
		alert("お子様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.kidsname_kn_1.value ) ) {
		alert("お子様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.kidsname_kn_1.focus();
		return false;
	}
		
	// 氏名(フリガナ) - 姓(こども)
	if ( parts.kidsname_kn_2.value == "" ) {
		alert("お子様の氏名(フリガナ)-姓を入力して下さい。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.kidsname_kn_2.value ) ) {
		alert("お子様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.kidsname_kn_2.value ) ) {
		alert("お子様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	
	// お通いの学校
		//国立・県立・市立・私立
		if ( parts.type.value == "" ) {
			alert("お通いの学校（国・県・市・私）を入力して下さい。");
			parts.type.focus();
			return false;
		} else {
			// スペースのみチェック
			if ( !SpaceCheck( parts.type.value ) ) {
				alert("お通いの学校（国・県・市・私）はスペースのみの入力はできません。");
				parts.type.focus();
				return false;
			}
		}
		//学校名
		if ( parts.school.value == "" ) {
			alert("お通いの学校（学校名）を入力して下さい。");
			parts.school.focus();
			return false;
		} else {
			// スペースのみチェック
			if ( !SpaceCheck( parts.school.value ) ) {
				alert("お通いの学校（国立・県立・市立・私立）はスペースのみの入力はできません。");
				parts.school.focus();
				return false;
			}
		}


	// 氏名(漢字) - 姓（保護者）
	if ( parts.name_kj_1.value == "" ) {
		alert("保護者様の氏名(漢字)-姓を入力して下さい。");
		parts.name_kj_1.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("保護者様の氏名(漢字)-姓はスペースのみの入力はできません。");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// 氏名(漢字) - 名
	if ( parts.name_kj_2.value == "" ) {
		alert("保護者様の氏名(漢字)-名を入力して下さい。");
		parts.name_kj_2.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.name_kj_2.value ) ) {
			alert("保護者様の氏名(漢字)-名はスペースのみの入力はできません。");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// 氏名(フリガナ) - 姓(保護者)
	if ( parts.name_kn_1.value == "" ) {
		alert("保護者様の氏名(フリガナ)-姓を入力して下さい。");
		parts.name_kn_1.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.name_kn_1.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.name_kn_1.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.name_kn_1.focus();
		return false;
	}
		
	// 氏名(フリガナ) - 姓(保護者)
	if ( parts.name_kn_2.value == "" ) {
		alert("保護者様の氏名(フリガナ)-姓を入力して下さい。");
		parts.name_kn_2.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.name_kn_2.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.name_kn_2.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.name_kn_2.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.name_kn_2.focus();
		return false;
	}
	
	// 郵便番号チェック
	for ( iX=1; iX<3; iX++ ) {
		strAddrName = "addr_cd_"+iX;
		if ( parts.elements[strAddrName].value == "" ) {
			alert("郵便番号を入力して下さい。");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( !IntValCheck( parts.elements[strAddrName].value ) ) {
			alert("郵便番号は半角数字のみで入力して下さい。");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( iX == 1 ) {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 3 ) ){
				alert("郵便番号を正しく入力して下さい。");
				parts.elements[strAddrName].focus();
				return false;
			}
		} else {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 4 ) ){
				alert("郵便番号を正しく入力して下さい。");
				parts.elements[strAddrName].focus();
				return false;
			}
			
		}
	}
	
	
	// 住所チェック
	if ( parts.pref.value == "" ) {
		alert("都道府県名を選択して下さい。");
		parts.pref.focus();
		return false;
	}
	if ( parts.city.value == "" ){
		alert("住所（市区町村名）を入力して下さい");
		parts.city.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.city.value ) ) {
			alert("住所（市区町村名）はスペースのみの入力はできません。");
			parts.city.focus();
			return false;
		}
	}
	if ( parts.add.value == "" ){
		alert("住所（市区町村以降）を入力して下さい");
		parts.add.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.add.value ) ) {
			alert("住所（市区町村以降）はスペースのみの入力はできません。");
			parts.add.focus();
			return false;
		}
	}
	
	//メールアドレス
	if ( parts.mail.value == "" ) {
		alert("メールアドレスを入力して下さい。");
		parts.mail.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.mail.value ) ) {
			alert("メールアドレスを正しく入力して下さい。");
			parts.mail.focus();
			return false;
		}
	}
	
	return true;
	
}


//資料請求、コース資料請求
function inquiry_input_check( parts )
{
	
		// 氏名(漢字) - 姓(こども)
	if ( parts.kidsname_kj_1.value == "" ) {
		alert("お子様の氏名(漢字)-姓を入力して下さい。");
		parts.name_kj_1.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.kidsname_kj_1.value ) ) {
			alert("お子様の氏名(漢字)-姓はスペースのみの入力はできません。");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// 氏名(漢字) - 名(こども)
	if ( parts.kidsname_kj_2.value == "" ) {
		alert("お子様の氏名(漢字)-名を入力して下さい。");
		parts.name_kj_2.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.kidsname_kj_2.value ) ) {
			alert("お子様の氏名(漢字)-名はスペースのみの入力はできません。");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// 氏名(フリガナ) - 姓(こども)
	if ( parts.kidsname_kn_1.value == "" ) {
		alert("お子様の氏名(フリガナ)-姓を入力して下さい。");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.kidsname_kn_1.value ) ) {
		alert("お子様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.kidsname_kn_1.value ) ) {
		alert("お子様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.kidsname_kn_1.focus();
		return false;
	}
		
	// 氏名(フリガナ) - 姓(こども)
	if ( parts.kidsname_kn_2.value == "" ) {
		alert("お子様の氏名(フリガナ)-姓を入力して下さい。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.kidsname_kn_2.value ) ) {
		alert("お子様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.kidsname_kn_2.value ) ) {
		alert("お子様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	
	// お通いの学校
		//国立・県立・市立・私立
		if ( parts.type.value == "" ) {
			alert("お通いの学校（国・県・市・私）を入力して下さい。");
			parts.type.focus();
			return false;
		} else {
			// スペースのみチェック
			if ( !SpaceCheck( parts.type.value ) ) {
				alert("お通いの学校（国・県・市・私）はスペースのみの入力はできません。");
				parts.type.focus();
				return false;
			}
		}
		//学校名
		if ( parts.school.value == "" ) {
			alert("お通いの学校（学校名）を入力して下さい。");
			parts.school.focus();
			return false;
		} else {
			// スペースのみチェック
			if ( !SpaceCheck( parts.school.value ) ) {
				alert("お通いの学校（国立・県立・市立・私立）はスペースのみの入力はできません。");
				parts.school.focus();
				return false;
			}
		}


	// 氏名(漢字) - 姓（保護者）
	if ( parts.name_kj_1.value == "" ) {
		alert("保護者様の氏名(漢字)-姓を入力して下さい。");
		parts.name_kj_1.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("保護者様の氏名(漢字)-姓はスペースのみの入力はできません。");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// 氏名(漢字) - 名
	if ( parts.name_kj_2.value == "" ) {
		alert("保護者様の氏名(漢字)-名を入力して下さい。");
		parts.name_kj_2.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.name_kj_2.value ) ) {
			alert("保護者様の氏名(漢字)-名はスペースのみの入力はできません。");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// 氏名(フリガナ) - 姓(保護者)
	if ( parts.name_kn_1.value == "" ) {
		alert("保護者様の氏名(フリガナ)-姓を入力して下さい。");
		parts.name_kn_1.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.name_kn_1.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.name_kn_1.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.name_kn_1.focus();
		return false;
	}
		
	// 氏名(フリガナ) - 姓(保護者)
	if ( parts.name_kn_2.value == "" ) {
		alert("保護者様の氏名(フリガナ)-姓を入力して下さい。");
		parts.name_kn_2.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.name_kn_2.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.name_kn_2.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.name_kn_2.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.name_kn_2.focus();
		return false;
	}
	
	// 郵便番号チェック
	for ( iX=1; iX<3; iX++ ) {
		strAddrName = "addr_cd_"+iX;
		if ( parts.elements[strAddrName].value == "" ) {
			alert("郵便番号を入力して下さい。");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( !IntValCheck( parts.elements[strAddrName].value ) ) {
			alert("郵便番号は半角数字のみで入力して下さい。");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( iX == 1 ) {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 3 ) ){
				alert("郵便番号を正しく入力して下さい。");
				parts.elements[strAddrName].focus();
				return false;
			}
		} else {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 4 ) ){
				alert("郵便番号を正しく入力して下さい。");
				parts.elements[strAddrName].focus();
				return false;
			}
			
		}
	}
	
	
	// 住所チェック
	if ( parts.pref.value == "" ) {
		alert("都道府県名を選択して下さい。");
		parts.pref.focus();
		return false;
	}
	if ( parts.city.value == "" ){
		alert("住所（市区町村名）を入力して下さい");
		parts.city.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.city.value ) ) {
			alert("住所（市区町村名）はスペースのみの入力はできません。");
			parts.city.focus();
			return false;
		}
	}
	if ( parts.add.value == "" ){
		alert("住所（市区町村以降）を入力して下さい");
		parts.add.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.add.value ) ) {
			alert("住所（市区町村以降）はスペースのみの入力はできません。");
			parts.add.focus();
			return false;
		}
	}
	
	//メールアドレス
	if ( parts.mail.value == "" ) {
		alert("メールアドレスを入力して下さい。");
		parts.mail.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.mail.value ) ) {
			alert("メールアドレスを正しく入力して下さい。");
			parts.mail.focus();
			return false;
		}
	}
	
	return true;
	
}


//キャンペーン申し込み
function inquiry_input_check( parts )
{
	
		// 氏名(漢字) - 姓(こども)
	if ( parts.kidsname_kj_1.value == "" ) {
		alert("お子様の氏名(漢字)-姓を入力して下さい。");
		parts.name_kj_1.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.kidsname_kj_1.value ) ) {
			alert("お子様の氏名(漢字)-姓はスペースのみの入力はできません。");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// 氏名(漢字) - 名(こども)
	if ( parts.kidsname_kj_2.value == "" ) {
		alert("お子様の氏名(漢字)-名を入力して下さい。");
		parts.name_kj_2.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.kidsname_kj_2.value ) ) {
			alert("お子様の氏名(漢字)-名はスペースのみの入力はできません。");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// 氏名(フリガナ) - 姓(こども)
	if ( parts.kidsname_kn_1.value == "" ) {
		alert("お子様の氏名(フリガナ)-姓を入力して下さい。");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.kidsname_kn_1.value ) ) {
		alert("お子様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.kidsname_kn_1.value ) ) {
		alert("お子様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.kidsname_kn_1.focus();
		return false;
	}
		
	// 氏名(フリガナ) - 姓(こども)
	if ( parts.kidsname_kn_2.value == "" ) {
		alert("お子様の氏名(フリガナ)-姓を入力して下さい。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.kidsname_kn_2.value ) ) {
		alert("お子様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.kidsname_kn_2.value ) ) {
		alert("お子様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.kidsname_kn_2.focus();
		return false;
	}
	
	// お通いの学校
		//国立・県立・市立・私立
		if ( parts.type.value == "" ) {
			alert("お通いの学校（国・県・市・私）を入力して下さい。");
			parts.type.focus();
			return false;
		} else {
			// スペースのみチェック
			if ( !SpaceCheck( parts.type.value ) ) {
				alert("お通いの学校（国・県・市・私）はスペースのみの入力はできません。");
				parts.type.focus();
				return false;
			}
		}
		//学校名
		if ( parts.school.value == "" ) {
			alert("お通いの学校（学校名）を入力して下さい。");
			parts.school.focus();
			return false;
		} else {
			// スペースのみチェック
			if ( !SpaceCheck( parts.school.value ) ) {
				alert("お通いの学校（国立・県立・市立・私立）はスペースのみの入力はできません。");
				parts.school.focus();
				return false;
			}
		}


	// 氏名(漢字) - 姓（保護者）
	if ( parts.name_kj_1.value == "" ) {
		alert("保護者様の氏名(漢字)-姓を入力して下さい。");
		parts.name_kj_1.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("保護者様の氏名(漢字)-姓はスペースのみの入力はできません。");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// 氏名(漢字) - 名
	if ( parts.name_kj_2.value == "" ) {
		alert("保護者様の氏名(漢字)-名を入力して下さい。");
		parts.name_kj_2.focus();
		return false;
	} else {
		// スペースのみチェック
		if ( !SpaceCheck( parts.name_kj_2.value ) ) {
			alert("保護者様の氏名(漢字)-名はスペースのみの入力はできません。");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// 氏名(フリガナ) - 姓(保護者)
	if ( parts.name_kn_1.value == "" ) {
		alert("保護者様の氏名(フリガナ)-姓を入力して下さい。");
		parts.name_kn_1.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.name_kn_1.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.name_kn_1.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.name_kn_1.focus();
		return false;
	}
		
	// 氏名(フリガナ) - 姓(保護者)
	if ( parts.name_kn_2.value == "" ) {
		alert("保護者様の氏名(フリガナ)-姓を入力して下さい。");
		parts.name_kn_2.focus();
		return false;
	}
	// スペースのみチェック
	if ( !SpaceCheck( parts.name_kn_2.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓はスペースのみの入力はできません。");
		parts.name_kn_2.focus();
		return false;
	}
	// カタカナのみチェック
	if ( !StrKatakanaCheck( parts.name_kn_2.value ) ) {
		alert("保護者様の氏名(フリガナ)-姓は全角カタカナで入力して下さい。");
		parts.name_kn_2.focus();
		return false;
	}
	
	// 郵便番号チェック
	for ( iX=1; iX<3; iX++ ) {
		strAddrName = "addr_cd_"+iX;
		if ( parts.elements[strAddrName].value == "" ) {
			alert("郵便番号を入力して下さい。");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( !IntValCheck( parts.elements[strAddrName].value ) ) {
			alert("郵便番号は半角数字のみで入力して下さい。");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( iX == 1 ) {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 3 ) ){
				alert("郵便番号を正しく入力して下さい。");
				parts.elements[strAddrName].focus();
				return false;
			}
		} else {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 4 ) ){
				alert("郵便番号を正しく入力して下さい。");
				parts.elements[strAddrName].focus();
				return false;
			}
			
		}
	}
	
	
	// 住所チェック
	if ( parts.pref.value == "" ) {
		alert("都道府県名を選択して下さい。");
		parts.pref.focus();
		return false;
	}
	if ( parts.city.value == "" ){
		alert("住所（市区町村名）を入力して下さい");
		parts.city.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.city.value ) ) {
			alert("住所（市区町村名）はスペースのみの入力はできません。");
			parts.city.focus();
			return false;
		}
	}
	if ( parts.add.value == "" ){
		alert("住所（市区町村以降）を入力して下さい");
		parts.add.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.add.value ) ) {
			alert("住所（市区町村以降）はスペースのみの入力はできません。");
			parts.add.focus();
			return false;
		}
	}
	
	//メールアドレス
	if ( parts.mail.value == "" ) {
		alert("メールアドレスを入力して下さい。");
		parts.mail.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.mail.value ) ) {
			alert("メールアドレスを正しく入力して下さい。");
			parts.mail.focus();
			return false;
		}
	}
	
	return true;
	
}
