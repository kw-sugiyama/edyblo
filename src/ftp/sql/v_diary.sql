--
-- PostgreSQL database dump
--

SET client_encoding = 'EUC_JP';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

--
-- Name: v_diary; Type: VIEW; Schema: public; Owner: slash
--

CREATE VIEW v_diary AS
    SELECT DISTINCT ON (t_area.ar_prefcd, t_diary.dr_id) t_diary.dr_id, t_diary.dr_clid, t_diary.dr_stat, t_diary.dr_cgid, t_diary.dr_title, t_diary.dr_contents, t_diary.dr_img1, t_diary.dr_imgorg1, t_diary.dr_img2, t_diary.dr_imgorg2, t_diary.dr_img3, t_diary.dr_imgorg3, t_diary.dr_img4, t_diary.dr_imgorg4, t_diary.dr_ido, t_diary.dr_keido, t_diary.dr_zoom, t_diary.dr_adminid, t_diary.dr_insdate, t_diary.dr_upddate, t_diary.dr_deldate, t_diary.dr_yobi1, t_diary.dr_yobi2, t_diary.dr_yobi3, t_diary.dr_yobi4, t_diary.dr_yobi5, t_diary.dr_tcid, t_client.cl_id, t_client.cl_loginid, t_client.cl_passwd, t_client.cl_logincd, t_client.cl_passcd, t_client.cl_urlcd, t_client.cl_stat, t_client.cl_pstat, t_client.cl_start, t_client.cl_end, t_client.cl_jname, t_client.cl_kname, t_client.cl_agent, t_client.cl_mail, t_client.cl_zip, t_client.cl_pref, t_client.cl_prefcd, t_client.cl_city, t_client.cl_citycd, t_client.cl_add, t_client.cl_estate, t_client.cl_phone, t_client.cl_fax, t_client.cl_biko, t_client.cl_yobi1, t_client.cl_yobi2, t_client.cl_yobi3, t_client.cl_yobi4, t_client.cl_yobi5, t_client.cl_makeid, t_client.cl_insdate, t_client.cl_upddate, t_client.cl_deldate, t_client.cl_dokuji_flg, t_client.cl_googlemap_key, t_client.cl_dokuji_domain, t_area.ar_id, t_area.ar_clid, t_area.ar_flg, t_area.ar_zip, t_area.ar_pref, t_area.ar_prefcd, t_area.ar_city, t_area.ar_citycd, t_area.ar_add, t_area.ar_adminid, t_area.ar_insdate, t_area.ar_upddate, t_area.ar_deldate, t_area.ar_yobi1, t_area.ar_yobi2, t_area.ar_yobi3, t_area.ar_yobi4, t_area.ar_yobi5, t_area.ar_estate FROM ((t_diary LEFT JOIN t_client ON ((t_diary.dr_clid = t_client.cl_id))) LEFT JOIN t_area ON ((t_client.cl_id = t_area.ar_clid))) WHERE ((t_area.ar_prefcd IS NOT NULL) AND (t_area.ar_deldate IS NULL)) ORDER BY t_area.ar_prefcd, t_diary.dr_id;


ALTER TABLE public.v_diary OWNER TO slash;

--
-- PostgreSQL database dump complete
--

