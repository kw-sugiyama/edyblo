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
    <title><?=$arrMetaHeader["title"]?> | <?=$arrMetaHeader["title_corp"]?></title>
    <link href="./share/css/<?=_SITE_LAYOUT?>/common.css" rel="stylesheet" type="text/css" />
    <link href="./share/css/<?=_SITE_LAYOUT?>/home.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" type="text/javascript" src="./share/js/iepngfix.js"></script>
<?=$param_meta_robots?>
  </head>
  <body>
    <div id="container">

<?php require_once( SYS_PATH."templates/header.tpl" ); ?>

      <div id="wrapper">
        <div id="tc_box">
          <div id="tc_right">
            <p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">トップページ</a> > 物件お問い合わせ > 送信内容確認</p>
            <h3>物件お問い合わせ</h3>
            <h4>送信内容確認</h4>
            <div id="add-estate">

<?=$strViewRoomList?>

            </div><!-- add-estate -->
            <div id="add-estate">
              <table>
                <tr>
                  <th>お問い合わせ内容</th>
                  <td><?=$arrViewData["question"]?><br /><?=$arrViewData["question_other"]?></td>
                </tr>
                <tr>
                  <th>氏名</th>
                  <td><?=$arrViewData["name_kj"]?></td>
                </tr>
                <tr>
                  <th>フリガナ</th>
                  <td><?=$arrViewData["name_kn"]?></td>
                </tr>
                <tr>
                  <th>性別</th>
                  <td><?=$arrViewData["sex"]?></td>
                </tr>
                <tr>
                  <th>年齢</th>
                  <td><?=$arrViewData["old"]?></td>
                </tr>
                <tr>
                  <th>職業</th>
                  <td><?=$arrViewData["work_kind"]?></td>
                </tr>
                <tr>
                  <th>電話で連絡</th>
                  <td><?=$arrViewData["tell"]?></td>
                </tr>
                <tr>
                  <th>FAXで連絡</th>
                  <td><?=$arrViewData["fax"]?></td>
                </tr>
                <tr>
                  <th>郵送で連絡</th>
                  <td><?=$arrViewData["addr"]?></td>
                </tr>
                <tr>
                  <th>Eメールで連絡</th>
                  <td><?=$arrViewData["email"]?></td>
                </tr>
              </table>
              <div class="center">
                <form name="applicate_confirm" method="POST" action="<?=_BLOG_SITE_URL_BASE?>applicate/" target="_self">
                <input name="imageField" type="image" src="share/images/send.gif" alt="送信" />
                <?=$strInputHidden?>
                <input type="hidden" name="mst" value="<?=$arrViewData["mst"]?>">
                <input type="hidden" name="form_flg" value="CONFIRM" />
                </form>
                <form name="inquiry_confirm" method="POST" action="<?=_BLOG_SITE_URL_BASE?>applicate/" target="_self">
                <input name="imageField2" type="image" src="share/images/back.gif" alt="戻る" />
                <?=$strInputHidden?>
                <input type="hidden" name="form_flg" value="" />
              </div><!-- center -->
            </div><!-- add-estate -->
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
