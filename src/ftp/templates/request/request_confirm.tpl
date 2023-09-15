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
        <div id="tc_right">
          <p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">�ȥåץڡ���</a> > ʪ��ꥯ������ > �������Ƴ�ǧ</p>
          <h3>ʪ��ꥯ������</h3>
          <h4>�������Ƴ�ǧ</h4>
          <div id="add-estate">
            <table>
              <tr>
                <th>��̾��</th>
                <td><?=$arrRequestValue["name_kj_1"]?> <?=$arrRequestValue["name_kj_2"]?></td>
              </tr>
              <tr>
                <th>�եꥬ��</th>
                <td><?=$arrRequestValue["name_kn_1"]?> <?=$arrRequestValue["name_kn_2"]?></td>
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
                <td><?=$request_work_value?></td>
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
                <td><?=$arrViewData["address"]?></td>
              </tr>
              <tr>
                <th>�ť᡼���Ϣ��</th>
                <td><?=$arrViewData["email"]?></td>
              </tr>
              <tr>
                <th>��̳�莥�̳����<br />�Ǵ��</th>
                <td><?=$arrRequestValue["station"]?></td>
              </tr>
              <tr>
                <th>��̳�莥�̳���ޤǤ�<br />��˾���׻���</th>
                <td><?=$request_move_time_value?></td>
              </tr>
              <tr>
                <th>��˾�α�������</th>
                <td><?=$arrRequestValue["line"]?></td>
              </tr>
              <tr>
                <th>��˾���ꥢ</th>
                <td><?=$arrRequestValue["area"]?></td>
              </tr>
              <tr>
                <th>��˾�β���</th>
                <td><?=$request_price1_value?> �� <?=$request_price2_value?></td>
              </tr>
              <tr>
                <th>��˾�δּ��</th>
                <td><?=$room_floor_value?></td>
              </tr>
              <tr>
                <th>1���ܤΤ���˾</th>
                <td><?=$arrRequestValue["equip1"]?></td>
              </tr>
              <tr>
                <th>2���ܤΤ���˾</th>
                <td><?=$arrRequestValue["equip2"]?></td>
              </tr>
              <tr>
                <th>3���ܤΤ���˾</th>
                <td><?=$arrRequestValue["equip3"]?></td>
              </tr>
              <tr>
                <th>4���ܤΤ���˾</th>
                <td><?=$arrRequestValue["equip4"]?></td>
              </tr>
              <tr>
                <th>5���ܤΤ���˾</th>
                <td><?=$arrRequestValue["equip5"]?></td>
              </tr>
              <tr>
                <th>����¾�Τ������</th>
                <td><?=$arrRequestValue["otherEquip"]?></td>
              </tr>
              <tr>
                <th>����ͽ�����</th>
                <td><?=$request_move_jiki_value?></td>
              </tr>
              <tr>
                <th>����ͽ��Ϳ�</th>
                <td><?=$request_menber_value?></td>
              </tr>
              <tr>
                <th>���ߤβ���</th>
                <td><?=$request_now_price_value?></td>
              </tr>
            </table>
            <div class="center">
	      <form name="request_input" method="POST" action="request_commit.php" target="_self">
              <input name="imageField" type="image" src="share/images/send.gif" alt="����" />
              <input type="hidden" name="mst" value="<?=$arrViewData["mst"]?>">
              <input type="hidden" name="form_flg" value="INDEX" />
              <?=$arrRequestValue['hidden']?>
              </form>
              <form name="request_input2" method="POST" action="request.php" target="_self">
	      <input name="imageField2" type="image" src="share/images/back.gif" alt="���" />
              <?=$arrRequestValue['hidden']?>
              <input type="hidden" name="form_flg" value="INDEX" />
              </form>
            </div><!-- center -->
          </div><!-- add-estate -->
        </div><!-- tc_right -->
        <div id="tc_left">

          <?php require_once( SYS_PATH."templates/left.tpl" ); ?>

        </div><!-- tc_left -->
      </div><!-- wrapper -->

<?php require_once( SYS_PATH."php/disp_footer.php" ); ?>

    </div><!-- container -->
<?php require_once( SYS_PATH."templates/analytics.tpl" ); ?>
  </body>
</html>
