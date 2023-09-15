/*================================================
    base_v_client ����������ץ�
================================================*/

DROP VIEW base_v_client;

CREATE VIEW base_v_client AS
	SELECT
		base_t_client.cl_id,			--- ���饤�����ID
		base_t_client.cl_login_id,		--- ���饤����ȥ�����ID
		base_t_client.cl_login_pass,		--- ���饤����ȥѥ����
		base_t_client.cl_login_id_sec,		--- �Ź沽������ID
		base_t_client.cl_login_pass_sec,	--- �Ź沽������ѥ����
		base_t_client.cl_url_code,		--- URL�ѥ�����
		base_t_client.cl_stat,			--- ��������Ⱦ���
		base_t_client.cl_limit_date,		--- ͭ�����³�����
		base_t_client.cl_start_date,		--- ͭ�����½�λ��
		base_t_client.cl_name,			--- ���饤����Ȼ�̾
		base_t_client.cl_shiten,		--- ���饤����Ȼ�Ź̾
		base_t_client.cl_agent,			--- ���饤�����ô����̾
		base_t_client.cl_agent_mail,		--- ���饤�����ô����Ϣ����ť᡼��
		base_t_client.cl_zip,			--- ���饤����Ƚ����͹���ֹ��
		base_t_client.cl_pref,			--- ���饤����Ƚ������ƻ�ܸ���
		base_t_client.cl_pref_cd,		--- ���饤�������ƻ�ܸ�������
		base_t_client.cl_address1,		--- ���饤����Ƚ���ʻԶ�Į¼��
		base_t_client.cl_addr_cd,		--- ���饤����ȻԶ�Į¼������
		base_t_client.cl_address2,		--- ���饤����Ƚ����Į�ʲ���
		base_t_client.cl_address3,		--- ���饤����Ƚ���ʷ�ʪ��������
		base_t_client.cl_tell,			--- ���饤����������ֹ�
		base_t_client.cl_fax,			--- ���饤����ȣƣ����ֹ�
		base_t_client.cl_biko_1,		--- ������
		base_t_client.cl_biko_2,		--- �ݡ�����Ǻܥե饰
		base_t_client.cl_biko_3,		--- ����3
		base_t_client.cl_biko_4,		--- ����4
		base_t_client.cl_biko_5,		--- ����5
		base_t_client.cl_admin_id,		--- ��������������ID
		base_t_client.cl_ins_date,		--- ��������
		base_t_client.cl_upd_date,		--- �ǽ���������
		base_t_client.cl_del_date,		--- �������	

		base_t_blog.blog_id,			--- �֥�ID
		base_t_blog.blog_cl_id,			--- ���饤�����ID
		base_t_blog.blog_stat,			--- �֥����ܾ�������ե饰
		base_t_blog.blog_title,			--- �֥������ȥ�
		base_t_blog.blog_keyword,		--- �֥��������
		base_t_blog.blog_discription,		--- �֥��Ҳ�ʸ
		base_t_blog.blog_layout,		--- �֥����ܿ�
		base_t_blog.blog_update,		--- �֥�������
		base_t_blog.blog_line,			--- ����̾
		base_t_blog.blog_line_cd,		--- ����������
		base_t_blog.blog_line_cd_name,		--- ����������̾
		base_t_blog.blog_station,		--- ��̾
		base_t_blog.blog_station_cd,		--- �إ�����
		base_t_blog.blog_move,			--- �ؤ���ν��׻���
		base_t_blog.blog_move_bus,		--- �ؤ���ν��׻���(�Х�)

		base_t_blog.blog_line2,			--- ����̾2
		base_t_blog.blog_line_cd2,		--- ����������2
		base_t_blog.blog_line_cd_name2,		--- ����������̾
		base_t_blog.blog_station2,		--- ��̾2
		base_t_blog.blog_station_cd2,		--- �إ�����2
		base_t_blog.blog_move2,			--- �ؤ���ν��׻���2
		base_t_blog.blog_move_bus2,		--- �ؤ���ν��׻���(�Х�)2

		base_t_blog.blog_start_time,		--- �Ķȳ��ϻ���
		base_t_blog.blog_end_time,		--- �ĶȽ�λ����
		base_t_blog.blog_holiday,		--- �����
		base_t_blog.blog_homepage,		--- ��ҥۡ���ڡ���
		base_t_blog.blog_entry_mail,		--- ����ȥ꡼�᡼�������襢�ɥ쥹
		base_t_blog.blog_info_mail,		--- �䤤��碌�᡼�������襢�ɥ쥹
		base_t_blog.blog_request_mail,		--- �ꥯ�����ȣ£ϣإ᡼�������襢�ɥ쥹
		base_t_blog.blog_cl_logo,		--- ��ҥ�����
		base_t_blog.blog_cl_logo_org,		--- ��ҥ�����
		base_t_blog.blog_cl_photo,		--- ��ҳ��Ѳ���
		base_t_blog.blog_cl_photo_org,		--- ��ҳ��Ѳ���
		base_t_blog.blog_cl_staff_photo,	--- ��ҥ����åղ���
		base_t_blog.blog_cl_staff_photo_org,	--- ��ҥ����åղ���
		base_t_blog.blog_cl_movie	,	--- ��ҥ����åղ���
		base_t_blog.blog_cl_pr,			--- ��ңУҾ���
		base_t_blog.blog_cl_free_html,		--- �ȣԣ̼ͣ�ͳɽ������
		base_t_blog.blog_cl_map,		--- Ź���Ͽ޾���
		base_t_blog.blog_cl_build_no,		--- ����ȵ��ֹ�
		base_t_blog.blog_cl_kojin,		--- �Ŀ;����ݸ�����
		base_t_blog.blog_cl_assign_group,	--- ��°����̾
		base_t_blog.blog_cl_security_group,	--- �ݾ㶨��̾
		base_t_blog.blog_admin_id,		--- �����ԥ桼���ɣ�
		base_t_blog.blog_biko_1,		--- ����1
		base_t_blog.blog_biko_2,		--- ����2
		base_t_blog.blog_biko_3,		--- ����3
		base_t_blog.blog_biko_4,		--- ����4
		base_t_blog.blog_biko_5,		--- ����5
		base_t_blog.blog_ins_date,		--- �����Ͽ����
		base_t_blog.blog_upd_date,		--- �ǽ���������
		base_t_blog.blog_del_date		--- �������

	FROM base_t_client
	INNER JOIN base_t_blog ON base_t_client.cl_id = base_t_blog.blog_cl_id;

REVOKE all ON base_v_client FROM public;
