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
    <title>�������Ƴ�ǧ | <?=$arrMetaHeader["title"]?></title>
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
            <p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">�ȥåץڡ���</a> > ����礻 > �������Ƴ�ǧ</p>
            <h3>����礻</h3>
            <h4>�������Ƴ�ǧ</h4>
            <div id="add-estate">
              <table>
                <tr>
                  <th>����礻����</th>
                  <td><?=$arrViewData["contents"]?></td>
                </tr>
                <tr>
                  <th>��̾��</th>
                  <td><?=$arrViewData["name_kj"]?></td>
                </tr>
                <tr>
                  <th>�եꥬ��</th>
                  <td><?=$arrViewData["name_kn"]?></td>
                </tr>
                <tr>
                  <th>����</th>
                  <td><?=$arrViewData["sex"]?></td>
                </tr>
                <tr>
                  <th>ǯ��</th>
                  <td><?=$arrViewData["old"]?></td>
                </tr>
                <tr>
                  <th>����</th>
                  <td><?=$arrViewData["work_kind"]?></td>
                </tr>
                <tr>
                  <th>���ä�Ϣ��</th>
                  <td><?=$arrViewData["tell"]?></td>
                </tr>
                <tr>
                  <th>FAX��Ϣ��</th>
                  <td><?=$arrViewData["fax"]?></td>
                </tr>
                <tr>
                  <th>͹����Ϣ��</th>
                  <td><?=$arrViewData["addr"]?></td>
                </tr>
                <tr>
                  <th>E�᡼���Ϣ��</th>
                  <td><?=$arrViewData["email"]?></td>
                </tr>
              </table>
              <div class="center">
                <form name="inquiry_confirm" method="POST" action="<?=_BLOG_SITE_URL_BASE?>inquiry/" target="_self">
                <input name="imageField" type="image" src="share/images/send.gif" alt="����" />
                <?=$strInputHidden?>
                <input type="hidden" name="mst" value="<?=$arrViewData["mst"]?>" />
                <input type="hidden" name="form_flg" value="CONFIRM" />
                </form>
                <form name="inquiry_confirm" method="POST" action="<?=_BLOG_SITE_URL_BASE?>inquiry/" target="_self">
                <input name="imageField2" type="image" src="share/images/back.gif" alt="���" />
                <?=$strInputHidden?>
                <input type="hidden" name="form_flg" value="" />
                </form>
              </div><!-- center -->
            </div><!-- formmail-style -->
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
