/*================================================
	管理ユーザーテーブル作成スクリプト
================================================*/

DROP TABLE base_t_admin;
DROP SEQUENCE base_t_admin_kanri_id_seq;

CREATE TABLE base_t_admin (
	kanri_id		serial		not null primary key,	--- 管理者ID
	kanri_name		text		not null,		--- 管理者氏名
	kanri_login_id		text		not null,		--- 管理者ログインID
	kanri_login_pass	text		not null,		--- 管理者パスワード
	kanri_login_id_sec	text		not null,		--- 暗号化ログインID
	kanri_login_pass_sec	text		not null,		--- 暗号化ログインパスワード
	kanri_kengen_1		int2		not null,		--- 管理者発行権限
	kanri_admin_id		int4		not null,		--- 更新した管理者ID
	kanri_ins_date		timestamp	not null,		--- 作成日時
	kanri_upd_date		timestamp	not null,		--- 最終更新日時
	kanri_del_date		timestamp,				--- 削除日時
	kanri_biko_1		text,					--- 備考１
	kanri_biko_2		text,					--- 備考２
	kanri_biko_3		text					--- 備考３
);

REVOKE all ON base_t_admin FROM public;

CREATE INDEX kanri_idx_01 ON base_t_admin USING btree( kanri_id );
CREATE INDEX kanri_idx_02 ON base_t_admin USING btree( kanri_login_id );
CREATE INDEX kanri_idx_03 ON base_t_admin USING btree( kanri_login_pass );
CREATE INDEX kanri_idx_04 ON base_t_admin USING btree( kanri_login_id_sec );
CREATE INDEX kanri_idx_05 ON base_t_admin USING btree( kanri_login_pass_sec );
CREATE INDEX kanri_idx_06 ON base_t_admin USING btree( kanri_kengen_1 );

INSERT INTO base_t_admin ( kanri_name , kanri_login_id , kanri_login_pass , kanri_login_id_sec , kanri_login_pass_sec , kanri_kengen_1 , kanri_admin_id , kanri_ins_date , kanri_upd_date ) 
		  VALUES ( '管理者' , 'admin' , 'administrator' , 'd033e22ae348aeb5660fc2140aec35850c4da997' , 'b3aca92c793ee0e9b1a9b0a5f5fc044e05140df3' , 0 , 0 , 'now' , 'now' );


