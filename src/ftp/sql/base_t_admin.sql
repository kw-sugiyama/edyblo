/*================================================
	�����桼�����ơ��֥����������ץ�
================================================*/

DROP TABLE base_t_admin;
DROP SEQUENCE base_t_admin_kanri_id_seq;

CREATE TABLE base_t_admin (
	kanri_id		serial		not null primary key,	--- ������ID
	kanri_name		text		not null,		--- �����Ի�̾
	kanri_login_id		text		not null,		--- �����ԥ�����ID
	kanri_login_pass	text		not null,		--- �����ԥѥ����
	kanri_login_id_sec	text		not null,		--- �Ź沽������ID
	kanri_login_pass_sec	text		not null,		--- �Ź沽������ѥ����
	kanri_kengen_1		int2		not null,		--- ������ȯ�Ը���
	kanri_admin_id		int4		not null,		--- ��������������ID
	kanri_ins_date		timestamp	not null,		--- ��������
	kanri_upd_date		timestamp	not null,		--- �ǽ���������
	kanri_del_date		timestamp,				--- �������
	kanri_biko_1		text,					--- ���ͣ�
	kanri_biko_2		text,					--- ���ͣ�
	kanri_biko_3		text					--- ���ͣ�
);

REVOKE all ON base_t_admin FROM public;

CREATE INDEX kanri_idx_01 ON base_t_admin USING btree( kanri_id );
CREATE INDEX kanri_idx_02 ON base_t_admin USING btree( kanri_login_id );
CREATE INDEX kanri_idx_03 ON base_t_admin USING btree( kanri_login_pass );
CREATE INDEX kanri_idx_04 ON base_t_admin USING btree( kanri_login_id_sec );
CREATE INDEX kanri_idx_05 ON base_t_admin USING btree( kanri_login_pass_sec );
CREATE INDEX kanri_idx_06 ON base_t_admin USING btree( kanri_kengen_1 );

INSERT INTO base_t_admin ( kanri_name , kanri_login_id , kanri_login_pass , kanri_login_id_sec , kanri_login_pass_sec , kanri_kengen_1 , kanri_admin_id , kanri_ins_date , kanri_upd_date ) 
		  VALUES ( '������' , 'admin' , 'administrator' , 'd033e22ae348aeb5660fc2140aec35850c4da997' , 'b3aca92c793ee0e9b1a9b0a5f5fc044e05140df3' , 0 , 0 , 'now' , 'now' );


