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
    <title>送信内容確認 | <?=$arrMetaHeader["title"]?></title>
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
          <p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">トップページ</a> > 物件リクエスト > 送信内容確認</p>
          <h3>物件リクエスト</h3>
          <h4>送信内容確認</h4>
          <div id="add-estate">
            <table>
              <tr>
                <th>お名前</th>
                <td><?=$arrRequestValue["name_kj_1"]?> <?=$arrRequestValue["name_kj_2"]?></td>
              </tr>
              <tr>
                <th>フリガナ</th>
                <td><?=$arrRequestValue["name_kn_1"]?> <?=$arrRequestValue["name_kn_2"]?></td>
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
                <td><?=$request_work_value?></td>
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
                <td><?=$arrViewData["address"]?></td>
              </tr>
              <tr>
                <th>Ｅメールで連絡</th>
                <td><?=$arrViewData["email"]?></td>
              </tr>
              <tr>
                <th>勤務先･通学先の<br />最寄駅</th>
                <td><?=$arrRequestValue["station"]?></td>
              </tr>
              <tr>
                <th>勤務先･通学先までの<br />希望所要時間</th>
                <td><?=$request_move_time_value?></td>
              </tr>
              <tr>
                <th>希望の沿線・駅</th>
                <td><?=$arrRequestValue["line"]?></td>
              </tr>
              <tr>
                <th>希望エリア</th>
                <td><?=$arrRequestValue["area"]?></td>
              </tr>
              <tr>
                <th>希望の家賃</th>
                <td><?=$request_price1_value?> 〜 <?=$request_price2_value?></td>
              </tr>
              <tr>
                <th>希望の間取り</th>
                <td><?=$room_floor_value?></td>
              </tr>
              <tr>
                <th>1番目のご希望</th>
                <td><?=$arrRequestValue["equip1"]?></td>
              </tr>
              <tr>
                <th>2番目のご希望</th>
                <td><?=$arrRequestValue["equip2"]?></td>
              </tr>
              <tr>
                <th>3番目のご希望</th>
                <td><?=$arrRequestValue["equip3"]?></td>
              </tr>
              <tr>
                <th>4番目のご希望</th>
                <td><?=$arrRequestValue["equip4"]?></td>
              </tr>
              <tr>
                <th>5番目のご希望</th>
                <td><?=$arrRequestValue["equip5"]?></td>
              </tr>
              <tr>
                <th>その他のこだわり</th>
                <td><?=$arrRequestValue["otherEquip"]?></td>
              </tr>
              <tr>
                <th>入居予定時期</th>
                <td><?=$request_move_jiki_value?></td>
              </tr>
              <tr>
                <th>入居予定人数</th>
                <td><?=$request_menber_value?></td>
              </tr>
              <tr>
                <th>現在の家賃</th>
                <td><?=$request_now_price_value?></td>
              </tr>
            </table>
            <div class="center">
	      <form name="request_input" method="POST" action="request_commit.php" target="_self">
              <input name="imageField" type="image" src="share/images/send.gif" alt="送信" />
              <input type="hidden" name="mst" value="<?=$arrViewData["mst"]?>">
              <input type="hidden" name="form_flg" value="INDEX" />
              <?=$arrRequestValue['hidden']?>
              </form>
              <form name="request_input2" method="POST" action="request.php" target="_self">
	      <input name="imageField2" type="image" src="share/images/back.gif" alt="戻る" />
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
