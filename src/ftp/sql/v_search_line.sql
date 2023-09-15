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
-- Name: v_search_line; Type: VIEW; Schema: public; Owner: slash
--

CREATE VIEW v_search_line AS
    SELECT t_school.sc_id, t_school.sc_clid, t_school.sc_stat, t_school.sc_title, t_school.sc_keywd, t_school.sc_introduce, t_school.sc_clr, t_school.sc_upd, t_school.sc_master, t_school.sc_position, t_school.sc_classform, t_school.sc_results, t_school.sc_students, t_school.sc_start, t_school.sc_end, t_school.sc_holiday, t_school.sc_hp, t_school.sc_entrymail, t_school.sc_infomail, t_school.sc_movie, t_school.sc_logo, t_school.sc_logoorg, t_school.sc_topimg, t_school.sc_topimgorg, t_school.sc_img1, t_school.sc_imgorg1, t_school.sc_img2, t_school.sc_imgorg2, t_school.sc_img3, t_school.sc_imgorg3, t_school.sc_img4, t_school.sc_imgorg4, t_school.sc_mapimg, t_school.sc_mapimgorg, t_school.sc_pr, t_school.sc_rhtml, t_school.sc_lhtml, t_school.sc_ido, t_school.sc_keido, t_school.sc_zoom, t_school.sc_privacy, t_school.sc_adminid, t_school.sc_insdate, t_school.sc_upddate, t_school.sc_deldate, t_school.sc_yobi1, t_school.sc_yobi2, t_school.sc_yobi3, t_school.sc_yobi4, t_school.sc_yobi5, t_school.sc_age, t_school.sc_infomnflg, t_school.sc_infomntitle, t_school.sc_infomndispno, t_school.sc_schoolmnflg, t_school.sc_schoolmntitle, t_school.sc_schoolmndispno, t_school.sc_qamnflg, t_school.sc_qamntitle, t_school.sc_qamndispno, t_school.sc_admissionmnflg, t_school.sc_admissionmntitle, t_school.sc_admissionmndispno, t_school.sc_layout1, t_school.sc_layout2, t_school.sc_layout3, t_school.sc_layout4, t_school.sc_layout5, t_school.sc_layout6, t_school.sc_layout7, t_school.sc_layout8, t_school.sc_layout9, t_school.sc_layoutname1, t_school.sc_layoutname2, t_school.sc_layoutname3, t_school.sc_layoutname4, t_school.sc_layoutname5, t_school.sc_layoutname6, t_school.sc_layoutname7, t_school.sc_layoutname8, t_school.sc_layoutname9, t_school.sc_headertitle, t_school.sc_toptitle, t_school.sc_topsubtitle, t_school.sc_campaintitle, t_school.sc_coursetitle, t_school.sc_diarytitle, t_school.sc_topwindowtitle, t_school.sc_company, t_school.sc_addmission, t_client.cl_id, t_client.cl_loginid, t_client.cl_passwd, t_client.cl_logincd, t_client.cl_passcd, t_client.cl_urlcd, t_client.cl_stat, t_client.cl_pstat, t_client.cl_start, t_client.cl_end, t_client.cl_jname, t_client.cl_kname, t_client.cl_agent, t_client.cl_mail, t_client.cl_zip, t_client.cl_pref, t_client.cl_prefcd, t_client.cl_city, t_client.cl_citycd, t_client.cl_add, t_client.cl_estate, t_client.cl_phone, t_client.cl_fax, t_client.cl_biko, t_client.cl_yobi1, t_client.cl_yobi2, t_client.cl_yobi3, t_client.cl_yobi4, t_client.cl_yobi5, t_client.cl_makeid, t_client.cl_insdate, t_client.cl_upddate, t_client.cl_deldate, t_client.cl_dokuji_flg, t_client.cl_googlemap_key, t_client.cl_dokuji_domain, t_ensen.es_id, t_ensen.es_cd, t_ensen.es_type, t_ensen.es_dispno, t_ensen.es_prefcd, t_ensen.es_line, t_ensen.es_linecd, t_ensen.es_sta, t_ensen.es_stacd, t_ensen.es_walk, t_ensen.es_bus, t_ensen.es_biko, t_ensen.es_adminid, t_ensen.es_insdate, t_ensen.es_upddate, t_ensen.es_deldate, t_ensen.es_yobi1, t_ensen.es_yobi2, t_ensen.es_yobi3, t_ensen.es_yobi4, t_ensen.es_yobi5, t_ensen.es_linecdname, m_station.st_areacd, m_station.st_area, m_station.st_prefcd, m_station.st_pref, m_station.st_linecd, m_station.st_line, m_station.st_linekana, m_station.st_stacd, m_station.st_sta, m_station.st_stakana, m_station.st_yobi1, m_station.st_yobi2, m_station.st_yobi3, m_station.st_yobi4, m_station.st_yobi5 FROM (((t_school LEFT JOIN t_client ON ((t_school.sc_clid = t_client.cl_id))) LEFT JOIN t_ensen ON ((t_client.cl_id = t_ensen.es_cd))) LEFT JOIN m_station ON (((t_ensen.es_line = m_station.st_line) AND (t_ensen.es_stacd = m_station.st_stacd)))) WHERE (t_ensen.es_dispno = 1);


ALTER TABLE public.v_search_line OWNER TO slash;

--
-- PostgreSQL database dump complete
--

