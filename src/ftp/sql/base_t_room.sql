/*================================================
    ��������ơ��֥����������ץ�
================================================*/

DROP TABLE base_t_room;
DROP SEQUENCE base_t_room_room_id_seq;

CREATE TABLE base_t_room (
	room_id			serial		not null primary key,	--- ����ID
	room_build_id		int4		not null,		--- ��ʪID
	room_cate_id		text,					--- ��°���ƥ���ID
	room_code		text		not null,		--- ʪ�拾����(�����漼̾)
	room_madori		int4,					--- �ּ��
	room_madori_detail	text,					--- �ּ��ܺ�
	room_price		int4,					--- ����
	room_cntrl_price	int4,					--- ������
	room_siki		int4,					--- �߶�
	room_rei		int4,					--- ���
	room_syou		int4,					--- ����
	room_sikibiki		int4,					--- �߰�
	room_sec_price		int4,					--- �ݾڶ�
	room_contract		int4,					--- �����
	room_upd_price		int4,					--- ������
	room_upd_year		int4,					--- ����ǯ��
	room_area		double precision,			--- ��ͭ����
	room_floor		int4,					--- ��߳�
	room_face		int4,					--- ����
	room_layout_img		text,					--- �ּ�����
	room_layout_img_org	text,					--- �ּ��������ꥸ�ʥ�̾
	room_other_img_1	text,					--- ����¾����1
	room_other_img_org_1	text,					--- ����¾�������ꥸ�ʥ�̾1
	room_other_img_2	text,					--- ����¾����2
	room_other_img_org_2	text,					--- ����¾�������ꥸ�ʥ�̾2
	room_other_img_3	text,					--- ����¾����3
	room_other_img_org_3	text,					--- ����¾�������ꥸ�ʥ�̾3
	room_other_img_4	text,					--- ����¾����4
	room_other_img_org_4	text,					--- ����¾�������ꥸ�ʥ�̾4
	room_equip		text,					--- ��������
	room_equip_other	text,					--- ��������(����¾)
	room_move_date		text,					--- ����ͽ��
	room_now_move		int4,					--- ¨�����
	room_trade		int4,					--- �������
	room_pr			text,					--- ����PRʸ��
	room_vacant		int4,					--- ʪ���������
	room_disp_no		int4		not null,		--- �¤ӽ�
	room_admin_id		int4,					--- �����桼��ID
	room_ins_date		timestamp,				--- �����Ͽ����
	room_upd_date		timestamp	not null,		--- �ǽ���������
	room_del_date		timestamp,				--- �������
	room_biko_1		text,					--- �ե꡼������ɸ�����������
	room_biko_2		text,					--- ���ͣ�
	room_biko_3		text,					--- ���ͣ�
	room_biko_4		text,					--- ���ͣ�
	room_biko_5		text					--- ���ͣ�
);

REVOKE all ON base_t_room FROM public;

CREATE INDEX room_idx_01 ON base_t_room USING btree( room_id );
CREATE INDEX room_idx_02 ON base_t_room USING btree( room_build_id );
CREATE INDEX room_idx_03 ON base_t_room USING btree( room_cate_id );
CREATE INDEX room_idx_04 ON base_t_room USING btree( room_madori );
CREATE INDEX room_idx_05 ON base_t_room USING btree( room_price );
CREATE INDEX room_idx_06 ON base_t_room USING btree( room_cntrl_price );
CREATE INDEX room_idx_07 ON base_t_room USING btree( room_siki );
CREATE INDEX room_idx_08 ON base_t_room USING btree( room_rei );
CREATE INDEX room_idx_09 ON base_t_room USING btree( room_syou );
CREATE INDEX room_idx_10 ON base_t_room USING btree( room_sikibiki );
CREATE INDEX room_idx_11 ON base_t_room USING btree( room_sec_price );
CREATE INDEX room_idx_12 ON base_t_room USING btree( room_contract );
CREATE INDEX room_idx_13 ON base_t_room USING btree( room_upd_price );
CREATE INDEX room_idx_14 ON base_t_room USING btree( room_upd_year );
CREATE INDEX room_idx_15 ON base_t_room USING btree( room_area );
CREATE INDEX room_idx_16 ON base_t_room USING btree( room_floor );
CREATE INDEX room_idx_17 ON base_t_room USING btree( room_face );
CREATE INDEX room_idx_18 ON base_t_room USING btree( room_equip );
CREATE INDEX room_idx_19 ON base_t_room USING btree( room_now_move );
CREATE INDEX room_idx_20 ON base_t_room USING btree( room_trade );
CREATE INDEX room_idx_21 ON base_t_room USING btree( room_vacant );
CREATE INDEX room_idx_22 ON base_t_room USING btree( room_disp_no );
CREATE INDEX room_idx_23 ON base_t_room USING btree( room_upd_date );
CREATE INDEX room_idx_24 ON base_t_room USING btree( room_biko_1 );
CREATE INDEX room_idx_25 ON base_t_room USING btree( room_del_date );
CREATE INDEX room_idx_26 ON base_t_room USING btree( room_biko_2 );
