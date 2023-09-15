/*================================================
	管理者情報テーブル作成スクリプト
================================================*/

DROP TABLE T_ADMIN;

CREATE TABLE T_ADMIN (
	AD_ID		serial	not null primary key,
	AD_NAME		text,
	AD_LOGINID	text,
	AD_PASSWD	text,
	AD_LOGINCD	text,
	AD_PASSCD	text,
	AD_AUTH		text,
	AD_MAKEID	integer,
	AD_BIKO		text,
	AD_YOBI1	text,
	AD_YOBI2	text,
	AD_YOBI3	text,
	AD_YOBI4	text,
	AD_YOBI5	text,
	AD_INSDATE	timestamp,
	AD_UPDDATE	timestamp,
	AD_DELDATE	timestamp
);

REVOKE all ON T_ADMIN FROM public;

CREATE INDEX AD_IDX_01 ON T_ADMIN USING btree( AD_ID );
CREATE INDEX AD_IDX_02 ON T_ADMIN USING btree( AD_LOGINID );
CREATE INDEX AD_IDX_03 ON T_ADMIN USING btree( AD_PASSWD );
CREATE INDEX AD_IDX_04 ON T_ADMIN USING btree( AD_LOGINCD );
CREATE INDEX AD_IDX_05 ON T_ADMIN USING btree( AD_PASSCD );
CREATE INDEX AD_IDX_06 ON T_ADMIN USING btree( AD_AUTH );
CREATE INDEX AD_IDX_07 ON T_ADMIN USING btree( AD_MAKEID );
CREATE INDEX AD_IDX_08 ON T_ADMIN USING btree( AD_INSDATE );
CREATE INDEX AD_IDX_09 ON T_ADMIN USING btree( AD_UPDDATE );
CREATE INDEX AD_IDX_10 ON T_ADMIN USING btree( AD_DELDATE );

INSERT INTO T_ADMIN ( AD_NAME , AD_LOGINID , AD_PASSWD , AD_LOGINCD , AD_PASSCD , AD_AUTH , AD_MAKEID , AD_INSDATE , AD_UPDDATE ) 
		  VALUES ( '管理者' , 'admin' , 'administrator' , 'd033e22ae348aeb5660fc2140aec35850c4da997' , 'b3aca92c793ee0e9b1a9b0a5f5fc044e05140df3' , 0 , 0 , 'now' , 'now' );


