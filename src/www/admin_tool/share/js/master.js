/*==================================================
    ͹���ֹ�ޥ��� - ������ǧ
==================================================*/
function ZipChangeCheck( parts , flg )
{
	
	switch ( flg ) {
		case 1:
			// ͹���ֹ�ޥ�����Ͽ
			if ( parts.zip_master.value == "" ){
				alert("UP����ե���������򤷤Ʋ�����");
				parts.zip_master.focus();
				return false;
			}
			ret_com = confirm("͹���ֹ�ޥ�������Ͽ���ޤ���������Ǥ�����");
			if( !ret_com ){
				return false;
			}
			parts.action = "master_zip_upd.php";
			break;
		case 2:
			// ͹���ֹ�ޥ������
			ret_com = confirm("͹���ֹ�ޥ����������ޤ���������Ǥ�����");
			if( !ret_com ){
				return false;
			}
			parts.action = "master_zip_del.php";
			break;
		default:
			alert("�����ƥ२�顼��ȯ�����ޤ�����");
			return false;
	}
	
	parts.submit();
	
	return true;
	
}


/*==================================================
    �����إޥ��� - ������ǧ
==================================================*/
function LineChangeCheck( parts , flg )
{
	
	switch ( flg ) {
		case 1:
			// �����إޥ�����Ͽ
			if ( parts.line_master.value == "" ){
				alert("UP����ե���������򤷤Ʋ�����");
				parts.line_master.focus();
				return false;
			}
			ret_com = confirm("�����إޥ�������Ͽ���ޤ���������Ǥ�����");
			if( !ret_com ){
				return false;
			}
			parts.action = "master_line_upd.php";
			break;
		case 2:
			// �����إޥ������
			ret_com = confirm("�����إޥ����������ޤ���������Ǥ�����");
			if( !ret_com ){
				return false;
			}
			parts.action = "master_line_del.php";
			break;
		default:
			alert("�����ƥ२�顼��ȯ�����ޤ�����");
			return false;
	}
	
	parts.submit();
	
	return true;
	
}
