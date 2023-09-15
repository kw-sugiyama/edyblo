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
    <title>駅検索 | <?=$arrMetaHeader["title"]?></title>
    <link href="./share/css/<?=_SITE_LAYOUT?>/common.css" rel="stylesheet" type="text/css" />
    <link href="./share/css/<?=_SITE_LAYOUT?>/home.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" type="text/javascript" src="./share/js/iepngfix.js"></script>
<?=$param_meta_robots?>
  </head>
  <body>
    <div id="highslide-container"></div>
      <div id="container">

<?php require_once( SYS_PATH."templates/header.tpl" ); ?>

        <div id="wrapper">
          <div id="tc_box">
            <div id="tc_right">
              <p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">トップページ</a> > <a href="<?=_BLOG_SITE_URL_BASE?>search-staline/">沿線検索</a> > 駅名検索</p>
              <h3>駅名検索</h3>
              <div id="formmail-style">
                <h4>物件該当エリア</h4>
                <table class="wide">
                  <tr>
                    <td>

<?=$arrViewData["index"]?>

                    </td>
                  </tr>
                </table>
                <br clear="all" />
                <h4>沿線を選択する</h4>
                <table class="basicFrame">
                  <form name="search_pref" method="GET" action="<?=_BLOG_SITE_URL_BASE?>search-result/page-1.html" target="_self">

<?=$arrViewData["list"]?>

                  <tr>
                    <td class="noborder">
                      <div class="center">
                        <input type="hidden" name="s_mode" value="st" />
                        <input type="hidden" name="mode" value="search" />
                        <input name="Input3" type="submit" value="検索する" />
                      </div>
                    </td>
                  </tr>
                  </form>
                </table>
              </div><!-- formmail-style -->
              <br clear="all" />
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
