/*================================================
	�֥����ܾ���ơ��֥����������ץ�
================================================*/

DROP TABLE base_t_blog;
DROP SEQUENCE base_t_blog_blog_id_seq;

CREATE TABLE base_t_blog (
	blog_id			serial		not null primary key,	--- �֥�ID
	blog_cl_id		int4		not null,		--- ���饤�����ID
	blog_stat		int4		not null,		--- �֥����ܾ�������ե饰
	blog_title		text,					--- �֥������ȥ�
	blog_layout		int4,					--- �֥����ܿ�
	blog_keyword		text,					--- �֥������������
	blog_discription	text,					--- �֥��Ҳ�ʸ
	blog_update		date,					--- �֥�������
	blog_line		text,					--- ����̾
	blog_line_cd		text,					--- ����������
	blog_line_cd_name	text,					--- ���������ɤ��Ф���̾��
	blog_station		text,					--- ��̾
	blog_station_cd		int4,					--- �إ�����
	blog_move		int4,					--- �ؤ���ν��׻���
	blog_move_bus		int4,					--- �ؤ���ν��׻���(�Х�)
	blog_start_time		text,					--- �Ķȳ��ϻ���
	blog_end_time		text,					--- �ĶȽ�λ����
	blog_holiday		text,					--- �����
	blog_homepage		text,					--- ��ҥۡ���ڡ���
	blog_entry_mail		text,					--- ����ȥ꡼�᡼�������襢�ɥ쥹
	blog_info_mail		text,					--- �䤤��碌�᡼�������襢�ɥ쥹
	blog_request_mail	text,					--- �ꥯ�����ȣ£ϣإ᡼�������襢�ɥ쥹
	blog_cl_logo		text,					--- ��ҥ�����
	blog_cl_logo_org	text,					--- ��ҥ�����
	blog_cl_photo		text,					--- ��ҳ��Ѳ���
	blog_cl_photo_org	text,					--- ��ҳ��Ѳ���
	blog_cl_staff_photo	text,					--- ��ҥ����åղ���
	blog_cl_staff_photo_org	text,					--- ��ҥ����åղ���
	blog_cl_movie		text,					--- ��ҳ���ư��
	blog_cl_pr		text,					--- ��ңУҾ���
	blog_cl_free_html	text,					--- �ȣԣ̼ͣ�ͳɽ������
	blog_cl_map		text,					--- Ź���Ͽ޾���
	blog_cl_build_no	text,					--- ����ȵ��ֹ�
	blog_cl_kojin		text,					--- �Ŀ;����ݸ�����
	blog_cl_assign_group	text,					--- ��°����̾
	blog_cl_security_group	text,					--- �ݾ㶨��̾
	blog_admin_id		int4,					--- �����ԥ桼���ɣ�
	blog_ins_date		timestamp	not null,		--- �����Ͽ����
	blog_upd_date		timestamp	not null,		--- �ǽ���������
	blog_del_date		timestamp,				--- �������
	blog_biko_1		text,					--- ���ͣ�
	blog_biko_2		text,					--- ���ͣ�
	blog_biko_3		text,					--- ���ͣ�
	blog_biko_4		text,					--- ���ͣ�
	blog_biko_5		text					--- ���ͣ�
);

REVOKE all ON base_t_blog FROM public;

CREATE INDEX blog_idx_01 ON base_t_blog USING btree( blog_id );
CREATE INDEX blog_idx_02 ON base_t_blog USING btree( blog_cl_id );
CREATE INDEX blog_idx_03 ON base_t_blog USING btree( blog_stat );
CREATE INDEX blog_idx_04 ON base_t_blog USING btree( blog_layout );
CREATE INDEX blog_idx_05 ON base_t_blog USING btree( blog_update );
CREATE INDEX blog_idx_06 ON base_t_blog USING btree( blog_line_cd );
CREATE INDEX blog_idx_07 ON base_t_blog USING btree( blog_station_cd );
