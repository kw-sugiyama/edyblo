/*================================================
	クライアント情報テーブル作成スクリプト
================================================*/

DROP TABLE T_CLIENT;

CREATE TABLE T_CLIENT (
	CL_ID		serial	not null primary key,
	CL_LOGINID	text,
	CL_PASSWD	text,
	CL_LOGINCD	text,
	CL_PASSCD	text,
	CL_URLCD	text,
	CL_STAT		integer,
	CL_PSTAT	integer,
	CL_START	timestamp,
	CL_END		timestamp,
	CL_JNAME	text,
	CL_KNAME	text,
	CL_AGENT	text,
	CL_MAIL		text,
	CL_ZIP		text,
	CL_PREF		text,
	CL_PREFCD	integer,
	CL_CITY		text,
	CL_CITYCD	integer,
	CL_ADD		text,
	CL_ESTATE	text,
	CL_PHONE	text,
	CL_FAX		text,
	CL_BIKO		text,
	CL_MAKEID	integer,
	CL_INSDATE	timestamp,
	CL_UPDDATE	timestamp,
	CL_DELDATE	timestamp,
	CL_YOBI1	text,
	CL_YOBI2	text,
	CL_YOBI3	text,
	CL_YOBI4	text,
	CL_YOBI5	text
);

REVOKE all ON T_CLIENT FROM public;

CREATE INDEX CL_IDX_01 ON T_CLIENT USING btree( CL_ID );
CREATE INDEX CL_IDX_02 ON T_CLIENT USING btree( CL_LOGINID );
CREATE INDEX CL_IDX_03 ON T_CLIENT USING btree( CL_PASSWD );
CREATE INDEX CL_IDX_04 ON T_CLIENT USING btree( CL_LOGINCD );
CREATE INDEX CL_IDX_05 ON T_CLIENT USING btree( CL_PASSCD );
CREATE INDEX CL_IDX_06 ON T_CLIENT USING btree( CL_URLCD );
CREATE INDEX CL_IDX_07 ON T_CLIENT USING btree( CL_STAT );
CREATE INDEX CL_IDX_08 ON T_CLIENT USING btree( CL_PSTAT );
CREATE INDEX CL_IDX_09 ON T_CLIENT USING btree( CL_START );
CREATE INDEX CL_IDX_10 ON T_CLIENT USING btree( CL_END );
CREATE INDEX CL_IDX_11 ON T_CLIENT USING btree( CL_ZIP );
CREATE INDEX CL_IDX_12 ON T_CLIENT USING btree( CL_PREF );
CREATE INDEX CL_IDX_13 ON T_CLIENT USING btree( CL_PREFCD );
CREATE INDEX CL_IDX_14 ON T_CLIENT USING btree( CL_CITY );
CREATE INDEX CL_IDX_15 ON T_CLIENT USING btree( CL_CITYCD );
CREATE INDEX CL_IDX_16 ON T_CLIENT USING btree( CL_ADD );
CREATE INDEX CL_IDX_17 ON T_CLIENT USING btree( CL_ESTATE );
CREATE INDEX CL_IDX_18 ON T_CLIENT USING btree( CL_MAKEID );
CREATE INDEX CL_IDX_19 ON T_CLIENT USING btree( CL_INSDATE );
CREATE INDEX CL_IDX_20 ON T_CLIENT USING btree( CL_UPDDATE );
CREATE INDEX CL_IDX_21 ON T_CLIENT USING btree( CL_DELDATE );
