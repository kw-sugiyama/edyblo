/*================================================
    v_clientadmin 作成スクリプト
================================================*/

DROP VIEW v_clientadmin;

CREATE VIEW v_clientadmin AS
	SELECT
		* 
	FROM t_client
	INNER JOIN t_area ON t_client.cl_id = t_area.ar_clid 
	where ar_flg = 1;

REVOKE all ON v_clientadmin FROM public;
