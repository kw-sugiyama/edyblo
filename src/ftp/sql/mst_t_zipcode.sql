/*================================================
	͹���ֹ�ޥ����ơ��֥����������ץ�
================================================*/

DROP TABLE mst_t_zipcode;

CREATE TABLE mst_t_zipcode (
	zip		text,		--- ͹���ֹ�
	pref_cd		text,		--- ��ƻ�ܸ�������
	address1	text,		--- ��ƻ�ܸ�̾
	addr_cd		text,		--- ���ꥳ����
	address2	text,		--- �Զ跴̾
	address3	text		--- Į̾
);

REVOKE all ON mst_t_zipcode FROM public;

CREATE INDEX zip_idx1 ON mst_t_zipcode USING btree( zip );
CREATE INDEX zip_idx2 ON mst_t_zipcode USING btree( pref_cd );
CREATE INDEX zip_idx3 ON mst_t_zipcode USING btree( addr_cd );
