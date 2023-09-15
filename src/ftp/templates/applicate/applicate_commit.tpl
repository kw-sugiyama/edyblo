<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta name="Keywords" content="<?=$arrMetaHeader["keyword"]?>" />
    <meta name="Description" content="<?=$arrMetaHeader["description"]?>" />
    <meta name="author" content="<?=$arrMetaHeader["title_corp"]?>" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>送信完了 | <?=$arrMetaHeader["title"]?></title>
    <link href="./share/css/<?=_SITE_LAYOUT?>/common.css" rel="stylesheet" type="text/css" />
    <link href="./share/css/<?=_SITE_LAYOUT?>/home.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" type="text/javascript" src="./share/js/highslide.js"></script>
    <script language="JavaScript" type="text/javascript" src="./share/js/highslide_config.js"></script>
<?=$param_meta_robots?>
  </head>
  <body>
    <div id="highslide-container"></div>
    <div id="container">

<?php require_once( SYS_PATH."templates/header.tpl" ); ?>

      <div id="wrapper">
        <div id="tc_box">
          <div id="tc_right">
            <p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">トップページ</a> > 物件お問合せ > 送信内容確認 > 送信完了</p>
            <h3>物件お問合せ</h3>
            <div id="formmail-general">
              <strong>物件お問い合わせの受付を完了いたしました。</strong>
              <p>この度は、お問い合わせ頂きありがとうございました。</p>
              <p>追って弊社の担当よりご連絡させて頂きます。</p>
              <p>&nbsp;</p>
              <p><a href="<?=_BLOG_SITE_URL_BASE?>">TOPページへ</a></p>
              <div class="companyprf">
                <p><strong class="msg"><?=$arrViewData["company_name"]?></strong></p>
                <p><?=$arrViewData["company_address"]?></p>
                <p>TEL：<?=$arrViewData["company_tell"]?></p>
                <p>FAX：<?=$arrViewData["company_fax"]?></p>
                <p>営業時間：<?=$arrViewData["company_time"]?></p>
                <p>定休日：<?=$arrViewData["company_holiday"]?></p>
                <p>宅建免許番号：<?=$arrViewData["company_build_no"]?></p>
              </div><!-- companyprf -->
            </div><!-- formmail-general -->
          </div><!-- tc_right -->
          <div id="tc_left">

            <?php require_once( SYS_PATH."templates/left.tpl" ); ?>

          </div><!-- tc_left -->
        </div><!-- tc_box -->
      </div><!-- wrapper -->

<?php require_once( SYS_PATH."php/disp_footer.php" ); ?>

    </div><!-- container -->
<?php require_once( SYS_PATH."templates/analytics.tpl" ); ?>
  </body>
</html>
