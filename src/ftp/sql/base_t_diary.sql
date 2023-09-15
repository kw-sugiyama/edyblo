/*================================================
    日記情報テーブル作成スクリプト
================================================*/

DROP TABLE base_t_diary;
DROP SEQUENCE base_t_diary_diary_id_seq;

CREATE TABLE base_t_diary (
	diary_id		serial		not null primary key,	--- 日記ID
	diary_cl_id		int4		not null,		--- クライアントID
	diary_cate_id		int4,					--- 所属カテゴリID
	diary_title		text		not null,		--- 日記タイトル
	diary_contents		text,					--- 日記内容
	diary_img_1		text,					--- 日記掲載画像１
	diary_img_org_1		text,					--- 日記掲載画像オリジナル名１
	diary_img_2		text,					--- 日記掲載画像２
	diary_img_org_2		text,					--- 日記掲載画像オリジナル名２
	diary_img_3		text,					--- 日記掲載画像３
	diary_img_org_3		text,					--- 日記掲載画像オリジナル名３
	diary_img_4		text,					--- 日記掲載画像４
	diary_img_org_4		text,					--- 日記掲載画像オリジナル名４
	diary_admin_id		int4,					--- 更新者ユーザＩＤ
	diary_ins_date		timestamp,				--- 初回登録日時
	diary_upd_date		timestamp	not null,		--- 最終更新日時
	diary_del_date		timestamp,				--- 削除日時
	diary_biko_1		text,					--- 備考１
	diary_biko_2		text,					--- 備考２
	diary_biko_3		text,					--- 備考３
	diary_biko_4		text,					--- 備考４
	diary_biko_5		text					--- 備考５
);

REVOKE all ON base_t_diary FROM public;

CREATE INDEX diary_idx_01 ON base_t_diary USING btree( diary_id );
CREATE INDEX diary_idx_02 ON base_t_diary USING btree( diary_cl_id );
CREATE INDEX diary_idx_03 ON base_t_diary USING btree( diary_cate_id );
CREATE INDEX diary_idx_04 ON base_t_diary USING btree( diary_upd_date );
