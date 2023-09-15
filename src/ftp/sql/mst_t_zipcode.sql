/*================================================
	郵便番号マスタテーブル作成スクリプト
================================================*/

DROP TABLE mst_t_zipcode;

CREATE TABLE mst_t_zipcode (
	zip		text,		--- 郵便番号
	pref_cd		text,		--- 都道府県コード
	address1	text,		--- 都道府県名
	addr_cd		text,		--- 住所コード
	address2	text,		--- 市区郡名
	address3	text		--- 町名
);

REVOKE all ON mst_t_zipcode FROM public;

CREATE INDEX zip_idx1 ON mst_t_zipcode USING btree( zip );
CREATE INDEX zip_idx2 ON mst_t_zipcode USING btree( pref_cd );
CREATE INDEX zip_idx3 ON mst_t_zipcode USING btree( addr_cd );
