<?

/*========================================================================
    �᡼�������Ѵؿ�
	����   : $ml_kind ... �᡼�����
			"INQUIRY":����礻��
	         $ml_to_addr ... �᡼��������
	         $ml_title   ... �᡼�륿���ȥ�
	         $ml_body    ... �᡼������
	
	�֤��� : "1" ... ����
	         "9" ... �۾�
========================================================================*/
function fnc_send_mail( $ml_kind , $ml_to_addr , $ml_title , $ml_body ){
	
	// �᡼��ѥ�᡼���ƤӽФ�
	include( SYS_PATH."configs/param_mail.conf" );
	
	// �����ͳ�ǧ
	IF( $ml_kind == "" || $ml_to_addr == "" || $ml_title == "" || $ml_body == "" ){
		echo "�᡼���������顼1";
		return("9");
	}

		// ���� $ml_kind ��������
	IF( $ml_kind == "INQUIRY" ){
		
		// ����礻��
		$ml_from = $param_mail_inquiry["from_name"];
		$ml_sender = $param_mail_inquiry["from_addr"];
		$ml_bcc_addr = "";
		$error_addr = $param_mail_inquiry["error"];
		
	}ELSEIF( $ml_kind == "APPLICATE" ){
		
		// ������������
		$ml_from = $param_mail_applicate["from_name"];
		$ml_sender = $param_mail_applicate["from_addr"];
		$ml_bcc_addr = "";
		$error_addr = $param_mail_applicate["error"];
		
	}ELSEIF( $ml_kind == "CAMPAIGN" ){
		
		// �����ڡ����䤤��碌��
		$ml_from = $param_mail_campaign["from_name"];
		$ml_sender = $param_mail_campaign["from_addr"];
		$ml_bcc_addr = "";
		$error_addr = $param_mail_campaign["error"];
		
	}ELSEIF( $ml_kind == "COURSEINQ" ){
		
		// ����������礻��
		$ml_from = $param_mail_courseinq["from_name"];
		$ml_sender = $param_mail_courseinq["from_addr"];
		$ml_bcc_addr = "";
		$error_addr = $param_mail_courseinq["error"];
		
	}ELSEIF( $ml_kind == "COURSEREQ" ){
		
		// ����������������
		$ml_from = $param_mail_coursereq["from_name"];
		$ml_sender = $param_mail_coursereq["from_addr"];
		$ml_bcc_addr = "";
		$error_addr = $param_mail_coursereq["error"];
		
	}ELSEIF( $ml_kind == "REQUEST" ){
		
		// ����������
		$ml_from = $param_mail_request["from_name"];
		$ml_sender = $param_mail_request["from_addr"];
		$ml_bcc_addr = "";
		$error_addr = $param_mail_request["error"];
		
	}ELSEIF( $ml_kind == "PORTAL" ){
	
		// �ݡ����뤪��礻��
		$ml_from = $param_mail_portal_inq["from_name"];
		$ml_sender = $param_mail_portal_inq["from_addr"];
		$ml_bcc_addr = "";
		$error_addr = $param_mail_portal_inq["error_addr"];
		
	}ELSE{
		return("9");
	}

	

	// �᡼��إå���
	$from_name_h = mb_convert_encoding ( $ml_from,"JIS","AUTO" );
	$headers = "From: =?iso-2022-jp?B?".base64_encode($from_name_h)."?= <{$ml_sender}>\n";
	IF( $ml_bcc_addr ){
		$headers .= "BCC: {$ml_bcc_addr}\n";
	}
	$headers .= "Errors-To: {$error_addr}\n";
	$headers .= "Reply-To: {$ml_sender}\n";
	$headers .= "Mime-Version: 1.0\n";
	$headers .= "Content-Type: text/plain; charset=iso-2022-jp\n";
	$headers .= "Content-Transfer-Encoding: 7bit\n";
	$headers .= "X-Sender: {$ml_sender}\n";
	$headers .= "X-Mailer: PHP";

	// �᡼�륿���ȥ�
	$subject = mb_convert_encoding ( $ml_title,"JIS","AUTO" );
	$subject = "=?iso-2022-jp?B?".base64_encode($subject)."?=";

	$body = $ml_body;
	$body = str_replace("\r", "\n", str_replace("\r\n", "\n", $body));
	$body = mb_convert_encoding ( $body,"JIS","AUTO" );


	// �᡼������
	IF( ! mail($ml_to_addr, $subject, $body, $headers ,"-f".$error_addr) ){
		// �᡼�������Ǥ��ʤ����顼
		echo "mail error!";
		return("9");
	}
	
	return("1");
}

?>
