/*================================================
    部屋情報テーブル作成スクリプト
================================================*/

DROP TABLE base_t_room;
DROP SEQUENCE base_t_room_room_id_seq;

CREATE TABLE base_t_room (
	room_id			serial		not null primary key,	--- 部屋ID
	room_build_id		int4		not null,		--- 建物ID
	room_cate_id		text,					--- 所属カテゴリID
	room_code		text		not null,		--- 物件コード(部屋号室名)
	room_madori		int4,					--- 間取り
	room_madori_detail	text,					--- 間取り詳細
	room_price		int4,					--- 賃料
	room_cntrl_price	int4,					--- 管理料
	room_siki		int4,					--- 敷金
	room_rei		int4,					--- 礼金
	room_syou		int4,					--- 償却
	room_sikibiki		int4,					--- 敷引
	room_sec_price		int4,					--- 保証金
	room_contract		int4,					--- 契約金
	room_upd_price		int4,					--- 更新料
	room_upd_year		int4,					--- 更新年数
	room_area		double precision,			--- 専有面積
	room_floor		int4,					--- 所在階
	room_face		int4,					--- 向き
	room_layout_img		text,					--- 間取り画像
	room_layout_img_org	text,					--- 間取り画像オリジナル名
	room_other_img_1	text,					--- その他画像1
	room_other_img_org_1	text,					--- その他画像オリジナル名1
	room_other_img_2	text,					--- その他画像2
	room_other_img_org_2	text,					--- その他画像オリジナル名2
	room_other_img_3	text,					--- その他画像3
	room_other_img_org_3	text,					--- その他画像オリジナル名3
	room_other_img_4	text,					--- その他画像4
	room_other_img_org_4	text,					--- その他画像オリジナル名4
	room_equip		text,					--- 設備情報
	room_equip_other	text,					--- 設備情報(その他)
	room_move_date		text,					--- 入居予定
	room_now_move		int4,					--- 即入居可
	room_trade		int4,					--- 取引形態
	room_pr			text,					--- 部屋PR文章
	room_vacant		int4,					--- 物件空き状況
	room_disp_no		int4		not null,		--- 並び順
	room_admin_id		int4,					--- 更新ユーザID
	room_ins_date		timestamp,				--- 初回登録日時
	room_upd_date		timestamp	not null,		--- 最終更新日時
	room_del_date		timestamp,				--- 削除日時
	room_biko_1		text,					--- フリーキーワード検索時使用欄
	room_biko_2		text,					--- 備考２
	room_biko_3		text,					--- 備考３
	room_biko_4		text,					--- 備考４
	room_biko_5		text					--- 備考５
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
