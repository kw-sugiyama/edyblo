/*================================================
    ��ʪ����ơ��֥����������ץ�
================================================*/

DROP TABLE base_t_build;
DROP SEQUENCE base_t_build_build_id_seq;

CREATE TABLE base_t_build (
	build_id		serial		not null primary key,	--- ��ʪID
	build_cl_id		int		not null,		--- ���饤�����ID
	build_name		text,					--- ��ʪ̾��(������)
	build_name_disp		text,					--- ��ʪ̾��(ɽ����)
	build_address		text,					--- ��ʪ�����(������)
	build_zip		text,					--- ��ʪ����(͹���ֹ�)
	build_pref		text,					--- ��ʪ����(��ƻ�ܸ�)
	build_pref_cd		int4,					--- ��ƻ�ܸ�������
	build_address1		text,					--- ��ʪ����(��Į¼)
	build_addr_cd		int4,					--- ��Į¼������
	build_address2		text,					--- ��ʪ����(Į̾�ʲ�)
	build_line_cd		text,					--- �Ǵ����������
	build_line_cd_name	text,					--- �Ǵ���������ɤ��Ф���̾��
	build_line_name_1	text,					--- �Ǵ����̾1
	build_sta_cd		text,					--- �Ǵ�إ�����
	build_sta_name_1	text,					--- �Ǵ��̾1
	build_move_1		int4,					--- �ؤ���ΰ�ư����1
	build_move_bus_1	int4,					--- �ؤ���ΰ�ư����(�Х�)1
	build_line_name_2	text,					--- �Ǵ����̾2
	build_sta_name_2	text,					--- �Ǵ��̾2
	build_move_2		int4,					--- �ؤ���ΰ�ư����2
	build_move_bus_2	int4,					--- �ؤ���ΰ�ư����(�Х�)2
	build_date		int4,					--- ��ǯ��
	build_material		text,					--- ��ʪ��¤
	build_all_floor		int4,					--- ����
	build_type		int4,					--- ��ʪ������
	build_photo		text,					--- ��ʪ���Ѳ���
	build_photo_org		text,					--- ��ʪ���Ѳ������ꥸ�ʥ�̾
	build_map		text,					--- ��ʪ�Ͽ޾���
	build_pr		text,					--- ��ʪ�У�ʸ��
	build_disp_no		int4,					--- ɽ����
	build_admin_id		int4,					--- �����ԥ桼���ɣ�
	build_ins_date		timestamp	not null,		--- �����Ͽ����
	build_upd_date		timestamp	not null,		--- �ǽ���������
	build_del_date		timestamp,				--- �������
	build_biko_1		text,					--- �ե꡼������ɸ�����������
	build_biko_2		text,					--- ���ͣ�
	build_biko_3		text,					--- ���ͣ�
	build_biko_4		text,					--- ���ͣ�
	build_biko_5		text					--- ���ͣ�
);

REVOKE all ON base_t_build FROM public;

CREATE INDEX build_idx_01 ON base_t_build USING btree( build_id );
CREATE INDEX build_idx_02 ON base_t_build USING btree( build_cl_id );
CREATE INDEX build_idx_03 ON base_t_build USING btree( build_pref_cd );
CREATE INDEX build_idx_04 ON base_t_build USING btree( build_addr_cd );
CREATE INDEX build_idx_05 ON base_t_build USING btree( build_line_cd );
CREATE INDEX build_idx_06 ON base_t_build USING btree( build_sta_cd );
CREATE INDEX build_idx_08 ON base_t_build USING btree( build_move_1 );
CREATE INDEX build_idx_09 ON base_t_build USING btree( build_move_bus_1 );
CREATE INDEX build_idx_10 ON base_t_build USING btree( build_move_2 );
CREATE INDEX build_idx_11 ON base_t_build USING btree( build_move_bus_2 );
CREATE INDEX build_idx_12 ON base_t_build USING btree( build_date );
CREATE INDEX build_idx_13 ON base_t_build USING btree( build_material );
CREATE INDEX build_idx_14 ON base_t_build USING btree( build_type );
CREATE INDEX build_idx_15 ON base_t_build USING btree( build_disp_no );
CREATE INDEX build_idx_16 ON base_t_build USING btree( build_upd_date );
CREATE INDEX build_idx_17 ON base_t_build USING btree( build_biko_1 );
CREATE INDEX build_idx_18 ON base_t_build USING btree( build_del_date );
CREATE INDEX build_idx_19 ON base_t_build USING btree( build_pref );
CREATE INDEX build_idx_20 ON base_t_build USING btree( build_address1 );
