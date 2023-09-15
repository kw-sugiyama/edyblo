/*================================================
	カテゴリ情報テーブル作成スクリプト
================================================*/

DROP TABLE T_AREA;

CREATE TABLE T_AREA (
	AR_ID		SERIAL	not null primary key,
	AR_CLID		INTEGER,
	AR_FLG		INTEGER,
	AR_ZIP		TEXT,
	AR_PREF		TEXT,
	AR_PREFCD	INTEGER,
	AR_CITY		TEXT,
	AR_CITYCD	INTEGER,
	AR_ADD		TEXT,
	AR_ADMINID	INTEGER,
	AR_INSDATE	TIMESTAMP,
	AR_UPDDATE	TIMESTAMP,
	AR_DELDATE	TIMESTAMP,
	AR_YOBI1	TEXT,
	AR_YOBI2	TEXT,
	AR_YOBI3	TEXT,
	AR_YOBI4	TEXT,
	AR_YOBI5	TEXT
);

REVOKE all ON T_AREA FROM public;

CREATE INDEX AR_IDX_01 ON T_AREA USING btree( AR_ID );
CREATE INDEX AR_IDX_02 ON T_AREA USING btree( AR_CLID );
CREATE INDEX AR_IDX_03 ON T_AREA USING btree( AR_FLG );
CREATE INDEX AR_IDX_04 ON T_AREA USING btree( AR_ZIP );
CREATE INDEX AR_IDX_05 ON T_AREA USING btree( AR_PREF );
CREATE INDEX AR_IDX_06 ON T_AREA USING btree( AR_PREFCD );
CREATE INDEX AR_IDX_07 ON T_AREA USING btree( AR_CITY );
CREATE INDEX AR_IDX_08 ON T_AREA USING btree( AR_CITYCD );
CREATE INDEX AR_IDX_09 ON T_AREA USING btree( AR_ADD );
CREATE INDEX AR_IDX_10 ON T_AREA USING btree( AR_ADMINID );
CREATE INDEX AR_IDX_11 ON T_AREA USING btree( AR_INSDATE );
CREATE INDEX AR_IDX_12 ON T_AREA USING btree( AR_UPDDATE );
CREATE INDEX AR_IDX_13 ON T_AREA USING btree( AR_DELDATE );
