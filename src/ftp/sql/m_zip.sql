/*================================================
	住所マスタテーブル作成スクリプト
================================================*/

DROP TABLE M_ZIP;

CREATE TABLE M_ZIP (
	ZP_ZIP		text,
	ZP_PREFCD	integer,
	ZP_PREF		text,
	ZP_CITYCD	integer,
	ZP_CITY		text,
	ZP_ADD		text,
	ZP_YOBI1	text,
	ZP_YOBI2	text,
	ZP_YOBI3	text,
	ZP_YOBI4	text,
	ZP_YOBI5	text
);

REVOKE all ON M_ZIP FROM public;

CREATE INDEX ZP_IDX_01 ON M_ZIP USING btree( ZP_ZIP );
CREATE INDEX ZP_IDX_02 ON M_ZIP USING btree( ZP_PREFCD );
CREATE INDEX ZP_IDX_03 ON M_ZIP USING btree( ZP_PREF );
CREATE INDEX ZP_IDX_04 ON M_ZIP USING btree( ZP_CITYCD );
CREATE INDEX ZP_IDX_05 ON M_ZIP USING btree( ZP_CITY );
CREATE INDEX ZP_IDX_06 ON M_ZIP USING btree( ZP_ADD );
