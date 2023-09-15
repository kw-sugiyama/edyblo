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
-- Name: v_campain; Type: VIEW; Schema: public; Owner: slash
--

CREATE VIEW v_campain AS
    SELECT DISTINCT ON (t_area.ar_prefcd, t_campain.cp_id) t_campain.cp_id, t_campain.cp_clid, t_campain.cp_stat, t_campain.cp_flg, t_campain.cp_start, t_campain.cp_end, t_campain.cp_camstart, t_campain.cp_camend, t_campain.cp_cgid, t_campain.cp_title, t_campain.cp_subtitle, t_campain.cp_linktext, t_campain.cp_btntext, t_campain.cp_contents, t_campain.cp_age, t_campain.cp_bkgdimg, t_campain.cp_bkgdimgorg, t_campain.cp_img1, t_campain.cp_imgorg1, t_campain.cp_img2, t_campain.cp_imgorg2, t_campain.cp_img3, t_campain.cp_imgorg3, t_campain.cp_img4, t_campain.cp_imgorg4, t_campain.cp_ido, t_campain.cp_keido, t_campain.cp_zoom, t_campain.cp_adminid, t_campain.cp_insdate, t_campain.cp_upddate, t_campain.cp_deldate, t_campain.cp_yobi1, t_campain.cp_yobi2, t_campain.cp_yobi3, t_campain.cp_yobi4, t_campain.cp_yobi5, t_campain.cp_tcid, t_campain.cp_topflg, t_campain.cp_tccomment, t_client.cl_id, t_client.cl_loginid, t_client.cl_passwd, t_client.cl_logincd, t_client.cl_passcd, t_client.cl_urlcd, t_client.cl_stat, t_client.cl_pstat, t_client.cl_start, t_client.cl_end, t_client.cl_jname, t_client.cl_kname, t_client.cl_agent, t_client.cl_mail, t_client.cl_zip, t_client.cl_pref, t_client.cl_prefcd, t_client.cl_city, t_client.cl_citycd, t_client.cl_add, t_client.cl_estate, t_client.cl_phone, t_client.cl_fax, t_client.cl_biko, t_client.cl_yobi1, t_client.cl_yobi2, t_client.cl_yobi3, t_client.cl_yobi4, t_client.cl_yobi5, t_client.cl_makeid, t_client.cl_insdate, t_client.cl_upddate, t_client.cl_deldate, t_client.cl_dokuji_flg, t_client.cl_googlemap_key, t_client.cl_dokuji_domain, t_area.ar_id, t_area.ar_clid, t_area.ar_flg, t_area.ar_zip, t_area.ar_pref, t_area.ar_prefcd, t_area.ar_city, t_area.ar_citycd, t_area.ar_add, t_area.ar_adminid, t_area.ar_insdate, t_area.ar_upddate, t_area.ar_deldate, t_area.ar_yobi1, t_area.ar_yobi2, t_area.ar_yobi3, t_area.ar_yobi4, t_area.ar_yobi5, t_area.ar_estate FROM ((t_campain LEFT JOIN t_client ON ((t_campain.cp_clid = t_client.cl_id))) LEFT JOIN t_area ON ((t_client.cl_id = t_area.ar_clid))) WHERE ((t_area.ar_prefcd IS NOT NULL) AND (t_area.ar_deldate IS NULL)) ORDER BY t_area.ar_prefcd, t_campain.cp_id;


ALTER TABLE public.v_campain OWNER TO slash;

--
-- PostgreSQL database dump complete
--

