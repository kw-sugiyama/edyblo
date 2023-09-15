/*================================================
    base_v_build 作成スクリプト
================================================*/

DROP VIEW base_v_build;

CREATE VIEW base_v_build AS
	SELECT
		base_t_room.room_id,			--- 部屋ID
		base_t_room.room_build_id,		--- 建物ID
		base_t_room.room_cate_id,		--- 所属カテゴリID
		base_t_room.room_code,			--- 物件コード(部屋号室名)
		base_t_room.room_madori,		--- 間取り
		base_t_room.room_madori_detail,		--- 間取り詳細
		base_t_room.room_price,			--- 賃料
		base_t_room.room_cntrl_price,		--- 管理料
		base_t_room.room_siki,			--- 敷金
		base_t_room.room_rei,			--- 礼金
		base_t_room.room_syou,			--- 償却
		base_t_room.room_sikibiki,		--- 敷引
		base_t_room.room_sec_price,		--- 保証金
		base_t_room.room_contract,		--- 契約金
		base_t_room.room_upd_price,		--- 更新料
		base_t_room.room_upd_year,		--- 更新年数
		base_t_room.room_area,			--- 専有面積
		base_t_room.room_floor,			--- 所在階
		base_t_room.room_face,			--- 向き
		base_t_room.room_layout_img,		--- 間取り画像
		base_t_room.room_layout_img_org,	--- 間取り画像オリジナル名
		base_t_room.room_other_img_1,		--- その他画像1
		base_t_room.room_other_img_org_1,	--- その他画像オリジナル名1
		base_t_room.room_other_img_2,		--- その他画像2
		base_t_room.room_other_img_org_2,	--- その他画像オリジナル名2
		base_t_room.room_other_img_3,		--- その他画像3
		base_t_room.room_other_img_org_3,	--- その他画像オリジナル名3
		base_t_room.room_other_img_4,		--- その他画像4
		base_t_room.room_other_img_org_4,	--- その他画像オリジナル名4
		base_t_room.room_equip,			--- 設備情報
		base_t_room.room_equip_other,		--- 設備情報(その他)	
		base_t_room.room_move_date,		--- 入居予定
		base_t_room.room_now_move,		--- 即入居可
		base_t_room.room_trade,			--- 取引形態
		base_t_room.room_pr,			--- 部屋PR文章
		base_t_room.room_vacant,		--- 物件空き状況
		base_t_room.room_disp_no,		--- 並び順
		base_t_room.room_siki_unit,		--- 敷金単位
		base_t_room.room_rei_unit,		--- 礼金単位
		base_t_room.room_syou_unit,		--- 償却単位
		base_t_room.room_sikibiki_unit,		--- 敷引単位
		base_t_room.room_sec_price_unit,	--- 保証金単位
		base_t_room.room_upd_price_unit,	--- 更新費単位
		base_t_room.room_cntrl_price_unit,	--- 管理料単位
		base_t_room.room_other_price,		--- 料金：その他
		base_t_room.room_biko_1,		--- 備考1
		base_t_room.room_biko_2,		--- 備考2
		base_t_room.room_biko_3,		--- 備考3
		base_t_room.room_biko_4,		--- 備考4
		base_t_room.room_biko_5,		--- 備考5
		base_t_room.room_admin_id,		--- 更新ユーザID
		base_t_room.room_ins_date,		--- 初回登録日時
		base_t_room.room_upd_date,		--- 最終更新日時
		base_t_room.room_del_date,		--- 削除日時

		base_t_build.build_id,			--- 建物ID
		base_t_build.build_cl_id,		--- クライアントID
		base_t_build.build_name,		--- 建物名称(管理用)
		base_t_build.build_name_disp,		--- 建物名称(表示用)
		base_t_build.build_address,		--- 建物所在地(管理用)
		base_t_build.build_zip,			--- 建物住所(郵便番号)
		base_t_build.build_pref,		--- 建物住所(都道府県)
		base_t_build.build_pref_cd,		--- 都道府県コード
		base_t_build.build_address1,		--- 建物住所(市町村)
		base_t_build.build_addr_cd,		--- 市町村コード
		base_t_build.build_address2,		--- 建物住所(町名以下)
		base_t_build.build_line_cd,		--- 最寄沿線コード
		base_t_build.build_line_cd_name,	--- 最寄沿線コードに対する名前
		base_t_build.build_line_name_1,		--- 最寄沿線名1
		base_t_build.build_sta_cd,		--- 最寄駅コード
		base_t_build.build_sta_name_1,		--- 最寄駅名1
		base_t_build.build_move_1,		--- 駅からの移動時間1
		base_t_build.build_move_bus_1,		--- 駅からの移動時間(バス)1
		base_t_build.build_line_name_2,		--- 最寄沿線名2
		base_t_build.build_sta_name_2,		--- 最寄駅名2
		base_t_build.build_move_2,		--- 駅からの移動時間2
		base_t_build.build_move_bus_2,		--- 駅からの移動時間(バス)2
		base_t_build.build_date,		--- 築年月
		base_t_build.build_material,		--- 建物構造
		base_t_build.build_all_floor,		--- 総階数
		base_t_build.build_type,		--- 建物タイプ
		base_t_build.build_photo,		--- 建物外観画像
		base_t_build.build_photo_org,		--- 建物外観画像オリジナル名
		base_t_build.build_map,			--- 建物地図情報
		base_t_build.build_pr,			--- 建物PR文章
		base_t_build.build_disp_no,		--- 表示順
		base_t_build.build_admin_id,		--- 更新者ユーザＩＤ
		base_t_build.build_ins_date,		--- 初回登録日時
		base_t_build.build_upd_date,		--- 最終更新日時
		base_t_build.build_del_date,		--- 削除日時
		base_t_build.build_biko_1,		--- 備考1

		base_t_client.cl_id,			--- クライアントID
		base_t_client.cl_url_code,		--- URL用コード
		base_t_client.cl_name,			--- URL用コード
		base_t_client.cl_shiten,		--- URL用コード
		base_t_client.cl_pref,			--- URL用コード
		base_t_client.cl_address1		--- URL用コード


	FROM (base_t_room
	LEFT JOIN base_t_build ON base_t_room.room_build_id = base_t_build.build_id) 
	LEFT JOIN base_t_client ON base_t_build.build_cl_id = base_t_client.cl_id;

REVOKE all ON base_v_build FROM public;
