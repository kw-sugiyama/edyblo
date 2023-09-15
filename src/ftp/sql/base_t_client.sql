/*================================================
	���饤����ȥơ��֥����������ץ�
================================================*/

DROP TABLE base_t_client;
DROP SEQUENCE base_t_client_cl_id_seq;

CREATE TABLE base_t_client (
	cl_id			serial		not null primary key,	--- ���饤�����ID
	cl_login_id		text		not null,		--- ���饤����ȥ�����ID
	cl_login_pass		text		not null,		--- ���饤����ȥѥ����
	cl_login_id_sec		text		not null,		--- �Ź沽������ID
	cl_login_pass_sec	text		not null,		--- �Ź沽������ѥ����
	cl_url_code		text		not null,		--- URL�ѥ�����
	cl_stat			int2		not null,		--- ��������Ⱦ���
	cl_start_date		date,					--- ͭ�����³�����
	cl_limit_date		date,					--- ͭ�����½�λ��
	cl_name			text		not null,		--- ���饤����Ȼ�̾
	cl_shiten		text,					--- ���饤����Ȼ�Ź̾
	cl_agent		text,					--- ���饤�����ô����̾
	cl_agent_mail		text,					--- ���饤�����ô����Ϣ����ť᡼��
	cl_zip			text,					--- ���饤����Ƚ����͹���ֹ��
	cl_pref			text,					--- ���饤����Ƚ������ƻ�ܸ���
	cl_pref_cd		int4,					--- ���饤�������ƻ�ܸ�������
	cl_address1		text,					--- ���饤����Ƚ���ʻԶ�Į¼��
	cl_addr_cd		int4,					--- ���饤����ȻԶ�Į¼������
	cl_address2		text,					--- ���饤����Ƚ����Į�ʲ���
	cl_address3		text,					--- ���饤����Ƚ���ʷ�ʪ��������
	cl_tell			text,					--- ���饤����������ֹ�
	cl_fax			text,					--- ���饤����ȣƣ����ֹ�
	cl_admin_id		int4,					--- ��������������ID
	cl_ins_date		timestamp	not null,		--- ��������
	cl_upd_date		timestamp	not null,		--- �ǽ���������
	cl_del_date		timestamp,				--- �������
	cl_biko_1		text,					--- ���ͣ�
	cl_biko_2		text,					--- ���ͣ�
	cl_biko_3		text,					--- ���ͣ�
	cl_biko_4		text,					--- ���ͣ�
	cl_biko_5		text					--- ���ͣ�
);

REVOKE all ON base_t_client FROM public;

CREATE INDEX cl_idx_01 ON base_t_client USING btree( cl_id );
CREATE INDEX cl_idx_02 ON base_t_client USING btree( cl_login_id );
CREATE INDEX cl_idx_03 ON base_t_client USING btree( cl_login_pass );
CREATE INDEX cl_idx_04 ON base_t_client USING btree( cl_login_id_sec );
CREATE INDEX cl_idx_05 ON base_t_client USING btree( cl_login_pass_sec );
CREATE INDEX cl_idx_06 ON base_t_client USING btree( cl_url_code );
CREATE INDEX cl_idx_07 ON base_t_client USING btree( cl_stat );
CREATE INDEX cl_idx_08 ON base_t_client USING btree( cl_start_date );
CREATE INDEX cl_idx_09 ON base_t_client USING btree( cl_limit_date );
CREATE INDEX cl_idx_10 ON base_t_client USING btree( cl_name );
CREATE INDEX cl_idx_11 ON base_t_client USING btree( cl_pref_cd );
CREATE INDEX cl_idx_12 ON base_t_client USING btree( cl_addr_cd );
