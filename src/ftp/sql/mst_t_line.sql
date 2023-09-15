/*================================================
	͹���ֹ�ޥ����ơ��֥����������ץ�
================================================*/

DROP TABLE mst_t_line;

CREATE TABLE mst_t_line (
	line_area_no	int2	not null,	--- ���ꥢ������
	line_area_name	text,			--- ���ꥢ̾��
	line_pref_cd	int2	not null,	--- �ؽ����ƻ�ܸ�������
	line_pref_name	text,			--- �ؽ����ƻ�ܸ�̾
	line_cd		int4	not null,	--- ����������
	line_name	text,			--- ����̾
	line_kana	text,			--- ����̾����
	line_sta_cd	int4	not null,	--- �إ�����
	line_sta_name	text,			--- ��̾
	line_sta_kana	text,			--- ��̾����
	line_biko_1	text,			--- ���ͣ�
	line_biko_2	text,			--- ���ͣ�
	line_biko_3	text			--- ���ͣ�
);

REVOKE all ON mst_t_line FROM public;

CREATE UNIQUE INDEX line_uni_idx ON mst_t_line USING BTREE( line_cd , line_sta_cd );
CREATE INDEX line_idx_1 ON mst_t_line USING BTREE( line_area_no );
CREATE INDEX line_idx_2 ON mst_t_line USING BTREE( line_pref_cd );
CREATE INDEX line_idx_3 ON mst_t_line USING BTREE( line_cd );
CREATE INDEX line_idx_4 ON mst_t_line USING BTREE( line_sta_cd );
