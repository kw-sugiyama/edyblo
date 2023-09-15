/*================================================
    ��������ơ��֥����������ץ�
================================================*/

DROP TABLE base_t_diary;
DROP SEQUENCE base_t_diary_diary_id_seq;

CREATE TABLE base_t_diary (
	diary_id		serial		not null primary key,	--- ����ID
	diary_cl_id		int4		not null,		--- ���饤�����ID
	diary_cate_id		int4,					--- ��°���ƥ���ID
	diary_title		text		not null,		--- ���������ȥ�
	diary_contents		text,					--- ��������
	diary_img_1		text,					--- �����Ǻܲ�����
	diary_img_org_1		text,					--- �����Ǻܲ������ꥸ�ʥ�̾��
	diary_img_2		text,					--- �����Ǻܲ�����
	diary_img_org_2		text,					--- �����Ǻܲ������ꥸ�ʥ�̾��
	diary_img_3		text,					--- �����Ǻܲ�����
	diary_img_org_3		text,					--- �����Ǻܲ������ꥸ�ʥ�̾��
	diary_img_4		text,					--- �����Ǻܲ�����
	diary_img_org_4		text,					--- �����Ǻܲ������ꥸ�ʥ�̾��
	diary_admin_id		int4,					--- �����ԥ桼���ɣ�
	diary_ins_date		timestamp,				--- �����Ͽ����
	diary_upd_date		timestamp	not null,		--- �ǽ���������
	diary_del_date		timestamp,				--- �������
	diary_biko_1		text,					--- ���ͣ�
	diary_biko_2		text,					--- ���ͣ�
	diary_biko_3		text,					--- ���ͣ�
	diary_biko_4		text,					--- ���ͣ�
	diary_biko_5		text					--- ���ͣ�
);

REVOKE all ON base_t_diary FROM public;

CREATE INDEX diary_idx_01 ON base_t_diary USING btree( diary_id );
CREATE INDEX diary_idx_02 ON base_t_diary USING btree( diary_cl_id );
CREATE INDEX diary_idx_03 ON base_t_diary USING btree( diary_cate_id );
CREATE INDEX diary_idx_04 ON base_t_diary USING btree( diary_upd_date );
