<?php
/*==============================================================
    ��Ū�ڡ���ɽ�����������ե�����
==============================================================*/


SWITCH( $_GET["tpl_flg"] ){
	// �����ȥޥå�
	Case "sitemap":
		//title
		$view_header_title = "";
		$view_header_title = '�����ȥޥåסóؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����,�����ȥޥå�";
		//description
		$view_header_description = "";
		$view_header_description = "�Υ�����Υ����ȥޥåפǤ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ����ϰ����Ū�ʼ����к����佤�ˡ�";
		$view_header_description .= '��Ƴ�����ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';
		break;
	// �����ȵ���
	Case "kiyaku":
		//title
		$view_header_title = "";
		$view_header_title = '�����ȵ���óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����ȵ���";
		//description
		$view_header_description = "";
		$view_header_description = "�Υ�����Υ����ȵ���Ǥ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ����ϰ����Ū�ʼ����к����佤�ˡ�";
		$view_header_description .= '��Ƴ�����ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';
		break;
	// ���Ĳ��
	Case "com":
		//title
		$view_header_title = "";
		$view_header_title = '���Ĳ�ҡóؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,���Ĳ��";
		//description
		$view_header_description = "";
		$view_header_description = "�Υ�����α��Ĳ�Ҿ���ڡ����Ǥ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ����ϰ����Ū�ʼ����к����佤�ˡ�";
		$view_header_description .= '��Ƴ�����ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';
		break;
	// �Ŀ;����ݸ�����
	Case "privacy":
		//title
		$view_header_title = "";
		$view_header_title = '�Ŀ;����ݸ����ˡóؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�Ŀ;����ݸ�����";
		//description
		$view_header_description = "";
		$view_header_description = "�Υ�����θĿ;����ݸ����ˤΥڡ����Ǥ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ����ϰ����Ū�ʼ����к����佤�ˡ�";
		$view_header_description .= '��Ƴ�����ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';
		break;
	// ���䤤��碌
	Case "inquiry":
		//title
		$view_header_title = "";
		$view_header_title = '����礻�óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����,��Ω,��Ω,����礻";
		//description
		$view_header_description = "";
		$view_header_description = "�Υ��������礻�ڡ����Ǥ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ����ϰ����Ū�ʼ����к����佤�ˡ�";
		$view_header_description .= '��Ƴ�����ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';
		break;
}


?>