/*================================================
    v_course 作成スクリプト
================================================*/

DROP VIEW v_course;

CREATE VIEW v_course AS	SELECT * FROM (t_course
	INNER JOIN t_client ON t_course.cs_clid = t_client.cl_id) 
	INNER JOIN t_school ON t_client.cl_id = t_school.sc_clid;;

REVOKE all ON v_course FROM public;
