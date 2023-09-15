/*================================================
    base_v_client 作成スクリプト
================================================*/

DROP VIEW base_v_client;

CREATE VIEW base_v_client AS
	SELECT
		base_t_client.cl_id,			--- クライアントID
		base_t_client.cl_login_id,		--- クライアントログインID
		base_t_client.cl_login_pass,		--- クライアントパスワード
		base_t_client.cl_login_id_sec,		--- 暗号化ログインID
		base_t_client.cl_login_pass_sec,	--- 暗号化ログインパスワード
		base_t_client.cl_url_code,		--- URL用コード
		base_t_client.cl_stat,			--- アカウント状態
		base_t_client.cl_limit_date,		--- 有効期限開始日
		base_t_client.cl_start_date,		--- 有効期限終了日
		base_t_client.cl_name,			--- クライアント氏名
		base_t_client.cl_shiten,		--- クライアント支店名
		base_t_client.cl_agent,			--- クライアント担当者名
		base_t_client.cl_agent_mail,		--- クライアント担当者連絡先Ｅメール
		base_t_client.cl_zip,			--- クライアント住所（郵便番号）
		base_t_client.cl_pref,			--- クライアント住所（都道府県）
		base_t_client.cl_pref_cd,		--- クライアント都道府県コード
		base_t_client.cl_address1,		--- クライアント住所（市区町村）
		base_t_client.cl_addr_cd,		--- クライアント市区町村コード
		base_t_client.cl_address2,		--- クライアント住所（町以下）
		base_t_client.cl_address3,		--- クライアント住所（建物・部屋）
		base_t_client.cl_tell,			--- クライアント電話番号
		base_t_client.cl_fax,			--- クライアントＦＡＸ番号
		base_t_client.cl_biko_1,		--- 備考欄
		base_t_client.cl_biko_2,		--- ポータル掲載フラグ
		base_t_client.cl_biko_3,		--- 備考3
		base_t_client.cl_biko_4,		--- 備考4
		base_t_client.cl_biko_5,		--- 備考5
		base_t_client.cl_admin_id,		--- 更新した管理者ID
		base_t_client.cl_ins_date,		--- 作成日時
		base_t_client.cl_upd_date,		--- 最終更新日時
		base_t_client.cl_del_date,		--- 削除日時	

		base_t_blog.blog_id,			--- ブログID
		base_t_blog.blog_cl_id,			--- クライアントID
		base_t_blog.blog_stat,			--- ブログ基本情報設定フラグ
		base_t_blog.blog_title,			--- ブログタイトル
		base_t_blog.blog_keyword,		--- ブログキーワード
		base_t_blog.blog_discription,		--- ブログ紹介文
		base_t_blog.blog_layout,		--- ブログ基本色
		base_t_blog.blog_update,		--- ブログ更新日
		base_t_blog.blog_line,			--- 沿線名
		base_t_blog.blog_line_cd,		--- 沿線コード
		base_t_blog.blog_line_cd_name,		--- 沿線コード名
		base_t_blog.blog_station,		--- 駅名
		base_t_blog.blog_station_cd,		--- 駅コード
		base_t_blog.blog_move,			--- 駅からの所要時間
		base_t_blog.blog_move_bus,		--- 駅からの所要時間(バス)

		base_t_blog.blog_line2,			--- 沿線名2
		base_t_blog.blog_line_cd2,		--- 沿線コード2
		base_t_blog.blog_line_cd_name2,		--- 沿線コード名
		base_t_blog.blog_station2,		--- 駅名2
		base_t_blog.blog_station_cd2,		--- 駅コード2
		base_t_blog.blog_move2,			--- 駅からの所要時間2
		base_t_blog.blog_move_bus2,		--- 駅からの所要時間(バス)2

		base_t_blog.blog_start_time,		--- 営業開始時間
		base_t_blog.blog_end_time,		--- 営業終了時間
		base_t_blog.blog_holiday,		--- 定休日
		base_t_blog.blog_homepage,		--- 会社ホームページ
		base_t_blog.blog_entry_mail,		--- エントリーメール送り先アドレス
		base_t_blog.blog_info_mail,		--- 問い合わせメール送り先アドレス
		base_t_blog.blog_request_mail,		--- リクエストＢＯＸメール送り先アドレス
		base_t_blog.blog_cl_logo,		--- 会社ロゴ画像
		base_t_blog.blog_cl_logo_org,		--- 会社ロゴ画像
		base_t_blog.blog_cl_photo,		--- 会社外観画像
		base_t_blog.blog_cl_photo_org,		--- 会社外観画像
		base_t_blog.blog_cl_staff_photo,	--- 会社スタッフ画像
		base_t_blog.blog_cl_staff_photo_org,	--- 会社スタッフ画像
		base_t_blog.blog_cl_movie	,	--- 会社スタッフ画像
		base_t_blog.blog_cl_pr,			--- 会社ＰＲ情報
		base_t_blog.blog_cl_free_html,		--- ＨＴＭＬ自由表記内容
		base_t_blog.blog_cl_map,		--- 店舗地図情報
		base_t_blog.blog_cl_build_no,		--- 宅建免許番号
		base_t_blog.blog_cl_kojin,		--- 個人情報保護方針
		base_t_blog.blog_cl_assign_group,	--- 所属団体名
		base_t_blog.blog_cl_security_group,	--- 保障協会名
		base_t_blog.blog_admin_id,		--- 更新者ユーザＩＤ
		base_t_blog.blog_biko_1,		--- 備考1
		base_t_blog.blog_biko_2,		--- 備考2
		base_t_blog.blog_biko_3,		--- 備考3
		base_t_blog.blog_biko_4,		--- 備考4
		base_t_blog.blog_biko_5,		--- 備考5
		base_t_blog.blog_ins_date,		--- 初回登録日時
		base_t_blog.blog_upd_date,		--- 最終更新日時
		base_t_blog.blog_del_date		--- 削除日時

	FROM base_t_client
	INNER JOIN base_t_blog ON base_t_client.cl_id = base_t_blog.blog_cl_id;

REVOKE all ON base_v_client FROM public;
