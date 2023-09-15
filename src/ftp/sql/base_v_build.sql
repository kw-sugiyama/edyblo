/*================================================
    base_v_build ����������ץ�
================================================*/

DROP VIEW base_v_build;

CREATE VIEW base_v_build AS
	SELECT
		base_t_room.room_id,			--- ����ID
		base_t_room.room_build_id,		--- ��ʪID
		base_t_room.room_cate_id,		--- ��°���ƥ���ID
		base_t_room.room_code,			--- ʪ�拾����(�����漼̾)
		base_t_room.room_madori,		--- �ּ��
		base_t_room.room_madori_detail,		--- �ּ��ܺ�
		base_t_room.room_price,			--- ����
		base_t_room.room_cntrl_price,		--- ������
		base_t_room.room_siki,			--- �߶�
		base_t_room.room_rei,			--- ���
		base_t_room.room_syou,			--- ����
		base_t_room.room_sikibiki,		--- �߰�
		base_t_room.room_sec_price,		--- �ݾڶ�
		base_t_room.room_contract,		--- �����
		base_t_room.room_upd_price,		--- ������
		base_t_room.room_upd_year,		--- ����ǯ��
		base_t_room.room_area,			--- ��ͭ����
		base_t_room.room_floor,			--- ��߳�
		base_t_room.room_face,			--- ����
		base_t_room.room_layout_img,		--- �ּ�����
		base_t_room.room_layout_img_org,	--- �ּ��������ꥸ�ʥ�̾
		base_t_room.room_other_img_1,		--- ����¾����1
		base_t_room.room_other_img_org_1,	--- ����¾�������ꥸ�ʥ�̾1
		base_t_room.room_other_img_2,		--- ����¾����2
		base_t_room.room_other_img_org_2,	--- ����¾�������ꥸ�ʥ�̾2
		base_t_room.room_other_img_3,		--- ����¾����3
		base_t_room.room_other_img_org_3,	--- ����¾�������ꥸ�ʥ�̾3
		base_t_room.room_other_img_4,		--- ����¾����4
		base_t_room.room_other_img_org_4,	--- ����¾�������ꥸ�ʥ�̾4
		base_t_room.room_equip,			--- ��������
		base_t_room.room_equip_other,		--- ��������(����¾)	
		base_t_room.room_move_date,		--- ����ͽ��
		base_t_room.room_now_move,		--- ¨�����
		base_t_room.room_trade,			--- �������
		base_t_room.room_pr,			--- ����PRʸ��
		base_t_room.room_vacant,		--- ʪ���������
		base_t_room.room_disp_no,		--- �¤ӽ�
		base_t_room.room_siki_unit,		--- �߶�ñ��
		base_t_room.room_rei_unit,		--- ���ñ��
		base_t_room.room_syou_unit,		--- ����ñ��
		base_t_room.room_sikibiki_unit,		--- �߰�ñ��
		base_t_room.room_sec_price_unit,	--- �ݾڶ�ñ��
		base_t_room.room_upd_price_unit,	--- ������ñ��
		base_t_room.room_cntrl_price_unit,	--- ������ñ��
		base_t_room.room_other_price,		--- ���⡧����¾
		base_t_room.room_biko_1,		--- ����1
		base_t_room.room_biko_2,		--- ����2
		base_t_room.room_biko_3,		--- ����3
		base_t_room.room_biko_4,		--- ����4
		base_t_room.room_biko_5,		--- ����5
		base_t_room.room_admin_id,		--- �����桼��ID
		base_t_room.room_ins_date,		--- �����Ͽ����
		base_t_room.room_upd_date,		--- �ǽ���������
		base_t_room.room_del_date,		--- �������

		base_t_build.build_id,			--- ��ʪID
		base_t_build.build_cl_id,		--- ���饤�����ID
		base_t_build.build_name,		--- ��ʪ̾��(������)
		base_t_build.build_name_disp,		--- ��ʪ̾��(ɽ����)
		base_t_build.build_address,		--- ��ʪ�����(������)
		base_t_build.build_zip,			--- ��ʪ����(͹���ֹ�)
		base_t_build.build_pref,		--- ��ʪ����(��ƻ�ܸ�)
		base_t_build.build_pref_cd,		--- ��ƻ�ܸ�������
		base_t_build.build_address1,		--- ��ʪ����(��Į¼)
		base_t_build.build_addr_cd,		--- ��Į¼������
		base_t_build.build_address2,		--- ��ʪ����(Į̾�ʲ�)
		base_t_build.build_line_cd,		--- �Ǵ����������
		base_t_build.build_line_cd_name,	--- �Ǵ���������ɤ��Ф���̾��
		base_t_build.build_line_name_1,		--- �Ǵ����̾1
		base_t_build.build_sta_cd,		--- �Ǵ�إ�����
		base_t_build.build_sta_name_1,		--- �Ǵ��̾1
		base_t_build.build_move_1,		--- �ؤ���ΰ�ư����1
		base_t_build.build_move_bus_1,		--- �ؤ���ΰ�ư����(�Х�)1
		base_t_build.build_line_name_2,		--- �Ǵ����̾2
		base_t_build.build_sta_name_2,		--- �Ǵ��̾2
		base_t_build.build_move_2,		--- �ؤ���ΰ�ư����2
		base_t_build.build_move_bus_2,		--- �ؤ���ΰ�ư����(�Х�)2
		base_t_build.build_date,		--- ��ǯ��
		base_t_build.build_material,		--- ��ʪ��¤
		base_t_build.build_all_floor,		--- ����
		base_t_build.build_type,		--- ��ʪ������
		base_t_build.build_photo,		--- ��ʪ���Ѳ���
		base_t_build.build_photo_org,		--- ��ʪ���Ѳ������ꥸ�ʥ�̾
		base_t_build.build_map,			--- ��ʪ�Ͽ޾���
		base_t_build.build_pr,			--- ��ʪPRʸ��
		base_t_build.build_disp_no,		--- ɽ����
		base_t_build.build_admin_id,		--- �����ԥ桼���ɣ�
		base_t_build.build_ins_date,		--- �����Ͽ����
		base_t_build.build_upd_date,		--- �ǽ���������
		base_t_build.build_del_date,		--- �������
		base_t_build.build_biko_1,		--- ����1

		base_t_client.cl_id,			--- ���饤�����ID
		base_t_client.cl_url_code,		--- URL�ѥ�����
		base_t_client.cl_name,			--- URL�ѥ�����
		base_t_client.cl_shiten,		--- URL�ѥ�����
		base_t_client.cl_pref,			--- URL�ѥ�����
		base_t_client.cl_address1		--- URL�ѥ�����


	FROM (base_t_room
	LEFT JOIN base_t_build ON base_t_room.room_build_id = base_t_build.build_id) 
	LEFT JOIN base_t_client ON base_t_build.build_cl_id = base_t_client.cl_id;

REVOKE all ON base_v_build FROM public;
