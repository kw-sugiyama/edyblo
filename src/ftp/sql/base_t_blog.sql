/*================================================
	ブログ基本情報テーブル作成スクリプト
================================================*/

DROP TABLE base_t_blog;
DROP SEQUENCE base_t_blog_blog_id_seq;

CREATE TABLE base_t_blog (
	blog_id			serial		not null primary key,	--- ブログID
	blog_cl_id		int4		not null,		--- クライアントID
	blog_stat		int4		not null,		--- ブログ基本情報設定フラグ
	blog_title		text,					--- ブログタイトル
	blog_layout		int4,					--- ブログ基本色
	blog_keyword		text,					--- ブログ検索キーワード
	blog_discription	text,					--- ブログ紹介文
	blog_update		date,					--- ブログ更新日
	blog_line		text,					--- 沿線名
	blog_line_cd		text,					--- 沿線コード
	blog_line_cd_name	text,					--- 沿線コードに対する名前
	blog_station		text,					--- 駅名
	blog_station_cd		int4,					--- 駅コード
	blog_move		int4,					--- 駅からの所要時間
	blog_move_bus		int4,					--- 駅からの所要時間(バス)
	blog_start_time		text,					--- 営業開始時間
	blog_end_time		text,					--- 営業終了時間
	blog_holiday		text,					--- 定休日
	blog_homepage		text,					--- 会社ホームページ
	blog_entry_mail		text,					--- エントリーメール送り先アドレス
	blog_info_mail		text,					--- 問い合わせメール送り先アドレス
	blog_request_mail	text,					--- リクエストＢＯＸメール送り先アドレス
	blog_cl_logo		text,					--- 会社ロゴ画像
	blog_cl_logo_org	text,					--- 会社ロゴ画像
	blog_cl_photo		text,					--- 会社外観画像
	blog_cl_photo_org	text,					--- 会社外観画像
	blog_cl_staff_photo	text,					--- 会社スタッフ画像
	blog_cl_staff_photo_org	text,					--- 会社スタッフ画像
	blog_cl_movie		text,					--- 会社概要動画
	blog_cl_pr		text,					--- 会社ＰＲ情報
	blog_cl_free_html	text,					--- ＨＴＭＬ自由表記内容
	blog_cl_map		text,					--- 店舗地図情報
	blog_cl_build_no	text,					--- 宅建免許番号
	blog_cl_kojin		text,					--- 個人情報保護方針
	blog_cl_assign_group	text,					--- 所属団体名
	blog_cl_security_group	text,					--- 保障協会名
	blog_admin_id		int4,					--- 更新者ユーザＩＤ
	blog_ins_date		timestamp	not null,		--- 初回登録日時
	blog_upd_date		timestamp	not null,		--- 最終更新日時
	blog_del_date		timestamp,				--- 削除日時
	blog_biko_1		text,					--- 備考１
	blog_biko_2		text,					--- 備考２
	blog_biko_3		text,					--- 備考３
	blog_biko_4		text,					--- 備考４
	blog_biko_5		text					--- 備考５
);

REVOKE all ON base_t_blog FROM public;

CREATE INDEX blog_idx_01 ON base_t_blog USING btree( blog_id );
CREATE INDEX blog_idx_02 ON base_t_blog USING btree( blog_cl_id );
CREATE INDEX blog_idx_03 ON base_t_blog USING btree( blog_stat );
CREATE INDEX blog_idx_04 ON base_t_blog USING btree( blog_layout );
CREATE INDEX blog_idx_05 ON base_t_blog USING btree( blog_update );
CREATE INDEX blog_idx_06 ON base_t_blog USING btree( blog_line_cd );
CREATE INDEX blog_idx_07 ON base_t_blog USING btree( blog_station_cd );
