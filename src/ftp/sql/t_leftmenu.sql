/*================================================
	左メニュ−大カテゴリ情報テーブル作成スクリプト
================================================*/

DROP TABLE T_LEFTMENU;

CREATE TABLE T_LEFTMENU (
	LM_ID		SERIAL	not null primary key,
	LM_CLID		INTEGER,
	LM_STAT		INTEGER,
	LM_TYPE		INTEGER,
	LM_TITLE	TEXT,
	LM_DISPNO	INTEGER,
	LM_ADMINID	INTEGER,
	LM_INSDATE	TIMESTAMP,
	LM_UPDDATE	TIMESTAMP,
	LM_DELDATE	TIMESTAMP,
	LM_YOBI1	TEXT,
	LM_YOBI2	TEXT,
	LM_YOBI3	TEXT,
	LM_YOBI4	TEXT,
	LM_YOBI5	TEXT
);

REVOKE all ON T_LEFTMENU FROM public;

CREATE INDEX LM_IDX_01 ON T_LEFTMENU USING btree( LM_ID );
CREATE INDEX LM_IDX_02 ON T_LEFTMENU USING btree( LM_CLID );
CREATE INDEX LM_IDX_03 ON T_LEFTMENU USING btree( LM_STAT );
CREATE INDEX LM_IDX_04 ON T_LEFTMENU USING btree( LM_TYPE );
CREATE INDEX LM_IDX_06 ON T_LEFTMENU USING btree( LM_DISPNO );
CREATE INDEX LM_IDX_07 ON T_LEFTMENU USING btree( LM_ADMINID );
CREATE INDEX LM_IDX_08 ON T_LEFTMENU USING btree( LM_INSDATE );
CREATE INDEX LM_IDX_09 ON T_LEFTMENU USING btree( LM_UPDDATE );
CREATE INDEX LM_IDX_10 ON T_LEFTMENU USING btree( LM_DELDATE );
