/*================================================
	クライアントテーブル作成スクリプト
================================================*/

DROP TABLE base_t_client;
DROP SEQUENCE base_t_client_cl_id_seq;

CREATE TABLE base_t_client (
	cl_id			serial		not null primary key,	--- クライアントID
	cl_login_id		text		not null,		--- クライアントログインID
	cl_login_pass		text		not null,		--- クライアントパスワード
	cl_login_id_sec		text		not null,		--- 暗号化ログインID
	cl_login_pass_sec	text		not null,		--- 暗号化ログインパスワード
	cl_url_code		text		not null,		--- URL用コード
	cl_stat			int2		not null,		--- アカウント状態
	cl_start_date		date,					--- 有効期限開始日
	cl_limit_date		date,					--- 有効期限終了日
	cl_name			text		not null,		--- クライアント氏名
	cl_shiten		text,					--- クライアント支店名
	cl_agent		text,					--- クライアント担当者名
	cl_agent_mail		text,					--- クライアント担当者連絡先Ｅメール
	cl_zip			text,					--- クライアント住所（郵便番号）
	cl_pref			text,					--- クライアント住所（都道府県）
	cl_pref_cd		int4,					--- クライアント都道府県コード
	cl_address1		text,					--- クライアント住所（市区町村）
	cl_addr_cd		int4,					--- クライアント市区町村コード
	cl_address2		text,					--- クライアント住所（町以下）
	cl_address3		text,					--- クライアント住所（建物・部屋）
	cl_tell			text,					--- クライアント電話番号
	cl_fax			text,					--- クライアントＦＡＸ番号
	cl_admin_id		int4,					--- 更新した管理者ID
	cl_ins_date		timestamp	not null,		--- 作成日時
	cl_upd_date		timestamp	not null,		--- 最終更新日時
	cl_del_date		timestamp,				--- 削除日時
	cl_biko_1		text,					--- 備考１
	cl_biko_2		text,					--- 備考２
	cl_biko_3		text,					--- 備考３
	cl_biko_4		text,					--- 備考４
	cl_biko_5		text					--- 備考５
);

REVOKE all ON base_t_client FROM public;

CREATE INDEX cl_idx_01 ON base_t_client USING btree( cl_id );
CREATE INDEX cl_idx_02 ON base_t_client USING btree( cl_login_id );
CREATE INDEX cl_idx_03 ON base_t_client USING btree( cl_login_pass );
CREATE INDEX cl_idx_04 ON base_t_client USING btree( cl_login_id_sec );
CREATE INDEX cl_idx_05 ON base_t_client USING btree( cl_login_pass_sec );
CREATE INDEX cl_idx_06 ON base_t_client USING btree( cl_url_code );
CREATE INDEX cl_idx_07 ON base_t_client USING btree( cl_stat );
CREATE INDEX cl_idx_08 ON base_t_client USING btree( cl_start_date );
CREATE INDEX cl_idx_09 ON base_t_client USING btree( cl_limit_date );
CREATE INDEX cl_idx_10 ON base_t_client USING btree( cl_name );
CREATE INDEX cl_idx_11 ON base_t_client USING btree( cl_pref_cd );
CREATE INDEX cl_idx_12 ON base_t_client USING btree( cl_addr_cd );
