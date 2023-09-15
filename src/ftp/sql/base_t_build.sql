/*================================================
    建物情報テーブル作成スクリプト
================================================*/

DROP TABLE base_t_build;
DROP SEQUENCE base_t_build_build_id_seq;

CREATE TABLE base_t_build (
	build_id		serial		not null primary key,	--- 建物ID
	build_cl_id		int		not null,		--- クライアントID
	build_name		text,					--- 建物名称(管理用)
	build_name_disp		text,					--- 建物名称(表示用)
	build_address		text,					--- 建物所在地(管理用)
	build_zip		text,					--- 建物住所(郵便番号)
	build_pref		text,					--- 建物住所(都道府県)
	build_pref_cd		int4,					--- 都道府県コード
	build_address1		text,					--- 建物住所(市町村)
	build_addr_cd		int4,					--- 市町村コード
	build_address2		text,					--- 建物住所(町名以下)
	build_line_cd		text,					--- 最寄沿線コード
	build_line_cd_name	text,					--- 最寄沿線コードに対する名前
	build_line_name_1	text,					--- 最寄沿線名1
	build_sta_cd		text,					--- 最寄駅コード
	build_sta_name_1	text,					--- 最寄駅名1
	build_move_1		int4,					--- 駅からの移動時間1
	build_move_bus_1	int4,					--- 駅からの移動時間(バス)1
	build_line_name_2	text,					--- 最寄沿線名2
	build_sta_name_2	text,					--- 最寄駅名2
	build_move_2		int4,					--- 駅からの移動時間2
	build_move_bus_2	int4,					--- 駅からの移動時間(バス)2
	build_date		int4,					--- 築年月
	build_material		text,					--- 建物構造
	build_all_floor		int4,					--- 総階数
	build_type		int4,					--- 建物タイプ
	build_photo		text,					--- 建物外観画像
	build_photo_org		text,					--- 建物外観画像オリジナル名
	build_map		text,					--- 建物地図情報
	build_pr		text,					--- 建物ＰＲ文章
	build_disp_no		int4,					--- 表示順
	build_admin_id		int4,					--- 更新者ユーザＩＤ
	build_ins_date		timestamp	not null,		--- 初回登録日時
	build_upd_date		timestamp	not null,		--- 最終更新日時
	build_del_date		timestamp,				--- 削除日時
	build_biko_1		text,					--- フリーキーワード検索時使用欄
	build_biko_2		text,					--- 備考２
	build_biko_3		text,					--- 備考３
	build_biko_4		text,					--- 備考４
	build_biko_5		text					--- 備考５
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
