/*================================================
    v_client 作成スクリプト
================================================*/

DROP VIEW v_client;

CREATE VIEW v_client AS
	SELECT
		*
	FROM t_client
	INNER JOIN t_school ON t_client.cl_id = t_school.sc_clid;

REVOKE all ON v_client FROM public;
