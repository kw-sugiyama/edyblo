/*================================================
	カテゴリ設定テーブル作成スクリプト
================================================*/

DROP TABLE base_t_category;
DROP SEQUENCE base_t_category_cate_id_seq;

CREATE TABLE base_t_category (
	cate_id			serial		not null primary key,	--- カテゴリID
	cate_cl_id		int4		not null,		--- クライアントID
	cate_kind		int4		not null,		--- カテゴリー種別
	cate_flg		int4		not null,		--- カテゴリ表示／非表示
	cate_name		text		not null,		--- カテゴリ名称
	cate_disp_no		int4		not null,		--- 表示順
	cate_top_flg		int4		not null,		--- ＴＯＰ中央 表示/非表示
	cate_top_name		text,					--- ＴＯＰ中央 表示名
	cate_admin_id		int4,					--- 更新者ユーザＩＤ
	cate_ins_date		timestamp	not null,		--- 初回登録日時
	cate_upd_date		timestamp	not null,		--- 最終更新日時
	cate_del_date		timestamp,				--- 削除日時
	cate_biko_1		text,					--- 備考１
	cate_biko_2		text,					--- 備考２
	cate_biko_3		text					--- 備考３
);

REVOKE all ON base_t_category FROM public;

CREATE INDEX cate_idx_01 ON base_t_category USING btree( cate_id );
CREATE INDEX cate_idx_02 ON base_t_category USING btree( cate_cl_id );
CREATE INDEX cate_idx_03 ON base_t_category USING btree( cate_kind );
CREATE INDEX cate_idx_04 ON base_t_category USING btree( cate_flg );
CREATE INDEX cate_idx_05 ON base_t_category USING btree( cate_disp_no );
CREATE INDEX cate_idx_06 ON base_t_category USING btree( cate_top_flg );
