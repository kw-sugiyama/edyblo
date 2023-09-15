/*================================================
	���ƥ�������ơ��֥����������ץ�
================================================*/

DROP TABLE base_t_category;
DROP SEQUENCE base_t_category_cate_id_seq;

CREATE TABLE base_t_category (
	cate_id			serial		not null primary key,	--- ���ƥ���ID
	cate_cl_id		int4		not null,		--- ���饤�����ID
	cate_kind		int4		not null,		--- ���ƥ��꡼����
	cate_flg		int4		not null,		--- ���ƥ���ɽ������ɽ��
	cate_name		text		not null,		--- ���ƥ���̾��
	cate_disp_no		int4		not null,		--- ɽ����
	cate_top_flg		int4		not null,		--- �ԣϣ���� ɽ��/��ɽ��
	cate_top_name		text,					--- �ԣϣ���� ɽ��̾
	cate_admin_id		int4,					--- �����ԥ桼���ɣ�
	cate_ins_date		timestamp	not null,		--- �����Ͽ����
	cate_upd_date		timestamp	not null,		--- �ǽ���������
	cate_del_date		timestamp,				--- �������
	cate_biko_1		text,					--- ���ͣ�
	cate_biko_2		text,					--- ���ͣ�
	cate_biko_3		text					--- ���ͣ�
);

REVOKE all ON base_t_category FROM public;

CREATE INDEX cate_idx_01 ON base_t_category USING btree( cate_id );
CREATE INDEX cate_idx_02 ON base_t_category USING btree( cate_cl_id );
CREATE INDEX cate_idx_03 ON base_t_category USING btree( cate_kind );
CREATE INDEX cate_idx_04 ON base_t_category USING btree( cate_flg );
CREATE INDEX cate_idx_05 ON base_t_category USING btree( cate_disp_no );
CREATE INDEX cate_idx_06 ON base_t_category USING btree( cate_top_flg );
