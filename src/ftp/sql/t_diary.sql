/*================================================
	��������ơ��֥����������ץ�
================================================*/

DROP TABLE T_DIARY;

CREATE TABLE T_DIARY (
	DR_ID		SERIAL	not null primary key,
	DR_CLID		INTEGER,
	DR_STAT		INTEGER,
	DR_CGID		INTEGER,
	DR_TITLE	TEXT,
	DR_CONTENTS	TEXT,
	DR_IMG1		TEXT,
	DR_IMGORG1	TEXT,
	DR_IMG2		TEXT,
	DR_IMGORG2	TEXT,
	DR_IMG3		TEXT,
	DR_IMGORG3	TEXT,
	DR_IMG4		TEXT,
	DR_IMGORG4	TEXT,
	DR_IDO		DOUBLE PRECISION,
	DR_KEIDO	DOUBLE PRECISION,
	DR_ZOOM		INTEGER,
	DR_ADMINID	INTEGER,
	DR_INSDATE	TIMESTAMP,
	DR_UPDDATE	TIMESTAMP,
	DR_DELDATE	TIMESTAMP,
	DR_YOBI1	TEXT,
	DR_YOBI2	TEXT,
	DR_YOBI3	TEXT,
	DR_YOBI4	TEXT,
	DR_YOBI5	TEXT
);

REVOKE all ON T_DIARY FROM public;

CREATE INDEX DR_IDX_01 ON T_DIARY USING btree( DR_ID );
CREATE INDEX DR_IDX_02 ON T_DIARY USING btree( DR_CLID );
CREATE INDEX DR_IDX_03 ON T_DIARY USING btree( DR_STAT );
CREATE INDEX DR_IDX_04 ON T_DIARY USING btree( DR_CGID );
CREATE INDEX DR_IDX_05 ON T_DIARY USING btree( DR_IDO );
CREATE INDEX DR_IDX_06 ON T_DIARY USING btree( DR_KEIDO );
CREATE INDEX DR_IDX_07 ON T_DIARY USING btree( DR_ZOOM );
CREATE INDEX DR_IDX_08 ON T_DIARY USING btree( DR_ADMINID );
CREATE INDEX DR_IDX_09 ON T_DIARY USING btree( DR_INSDATE );
CREATE INDEX DR_IDX_10 ON T_DIARY USING btree( DR_UPDDATE );
CREATE INDEX DR_IDX_11 ON T_DIARY USING btree( DR_DELDATE );