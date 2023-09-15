/*================================================
	郵便番号マスタテーブル作成スクリプト
================================================*/

DROP TABLE mst_t_line;

CREATE TABLE mst_t_line (
	line_area_no	int2	not null,	--- エリアコード
	line_area_name	text,			--- エリア名称
	line_pref_cd	int2	not null,	--- 駅所在都道府県コード
	line_pref_name	text,			--- 駅所在都道府県名
	line_cd		int4	not null,	--- 沿線コード
	line_name	text,			--- 沿線名
	line_kana	text,			--- 沿線名かな
	line_sta_cd	int4	not null,	--- 駅コード
	line_sta_name	text,			--- 駅名
	line_sta_kana	text,			--- 駅名かな
	line_biko_1	text,			--- 備考１
	line_biko_2	text,			--- 備考２
	line_biko_3	text			--- 備考３
);

REVOKE all ON mst_t_line FROM public;

CREATE UNIQUE INDEX line_uni_idx ON mst_t_line USING BTREE( line_cd , line_sta_cd );
CREATE INDEX line_idx_1 ON mst_t_line USING BTREE( line_area_no );
CREATE INDEX line_idx_2 ON mst_t_line USING BTREE( line_pref_cd );
CREATE INDEX line_idx_3 ON mst_t_line USING BTREE( line_cd );
CREATE INDEX line_idx_4 ON mst_t_line USING BTREE( line_sta_cd );
