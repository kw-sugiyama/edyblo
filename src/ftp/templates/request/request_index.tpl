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
    <title>物件リクエスト | <?=$arrMetaHeader["title"]?></title>
    <link href="./share/css/<?=_SITE_LAYOUT?>/common.css" rel="stylesheet" type="text/css" />
    <link href="./share/css/<?=_SITE_LAYOUT?>/home.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" type="text/javascript" src="./share/js/highslide.js"></script>
    <script language="JavaScript" type="text/javascript" src="./share/js/highslide_config.js"></script>
    <script language="JavaScript" type="text/javascript" src="./share/js/form_check.js"></script>
    <script language="JavaScript" type="text/javascript" src="./share/js/input_check.js"></script>
<?=$param_meta_robots?>
  </head>
  <body>
    <div id="highslide-container"></div>
    <div id="container">

<?php require_once( SYS_PATH."templates/header.tpl" ); ?>

      <div id="wrapper">
        <div id="tc_right">
          <p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">トップページ</a> > 物件リクエスト</p>
          <h3>物件リクエスト</h3>
          <p>不動産会社に物件のお問合せができます。</p>
          <p>お問い合わせ内容に関する連絡は、あなたのご希望された方法でご連絡いたします。</p>
          <p>必須項目をご記入の上、確認画面に進んでください。</p>
          <div id="formmail-style">
            <table class="basicFrame">
              <form name="request_input" method="POST" action="request_confirm.php" target="_self">
              <tr>
                <th>お名前 <img src="share/css/<?=_SITE_LAYOUT?>/images/require.gif" width="29" height="12" class="icon" /></th>
                <td colspan="3"><input type="text" name="name_kj_1" size="15" value="<?=$arrRequestValue["name_kj_1"]?>" />&nbsp;<input type="text" name="name_kj_2" size="15" value="<?=$arrRequestValue["name_kj_2"]?>" /></td>
              </tr>
              <tr>
                <th>フリガナ</th>
                <td colspan="3"><input type="text" name="name_kn_1" size="15" value="<?=$arrRequestValue["name_kn_1"]?>" />&nbsp;<input type="text" name="name_kn_2" size="15" value="<?=$arrRequestValue["name_kn_2"]?>" /></td>
              </tr>
              <tr>
                <th>性別</th>
                <td colspan="3">
                  <input type="radio" name="sex" value="1" <?=$arrViewData["sex"][1]?>/>男
                  &nbsp;
                  <input type="radio" name="sex" value="2" <?=$arrViewData["sex"][2]?>/>女
                </td>
              </tr>
              <tr>
                <th>年齢</th>
                <td colspan="3"><input type="text" name="old" size="2" value="<?=$arrRequestValue["old"]?>" />歳 <span class="smallred">（半角英数文字）</span></td>
              </tr>
              <tr>
                <th>職業</th>
                <td colspan="3">
                  <table>
                    <?=$request_work_value?>
                  </table>
                </td>
              </tr>
              <tr>
                <th rowspan="5">連絡方法 <img src="share/css/<?=_SITE_LAYOUT?>/images/require.gif" width="29" height="12" class="icon" /></th>
                <th class="other">電話で連絡</th>
                <td><input type="checkbox" name="report_type_1" value="1" <?=$arrViewData["report_type_1"]?>/>連絡OK</td>
                <td><input type="text" name="tell_1" size="4" value="<?=$arrRequestValue["tell_1"]?>" /> - <input type="text" name="tell_2" size="4" value="<?=$arrRequestValue["tell_2"]?>" /> - <input type="text" name="tell_3" size="4" value="<?=$arrRequestValue["tell_3"]?>" /> <span class="smallred">（半角英数文字）</span> <span class="small">（例：03-1234-5678）</span><br />連絡ご希望の時間帯<input type="text" name="tell_time" size="15" value="<?=$arrRequestValue["tell_time"]?>" /> <span class="small">（例：○時〜○時）</span></td>
              </tr>
              <tr>
                <th class="other">FAXで連絡</th>
                <td><input type="checkbox" name="report_type_2" value="2" <?=$arrViewData["report_type_2"]?>/>連絡OK</td>
                <td><input type="text" name="fax_1" size="4" value="<?=$arrRequestValue["fax_1"]?>" /> - <input type="text" name="fax_2" size="4" value="<?=$arrRequestValue["fax_2"]?>" /> - <input type="text" name="fax_3" size="4" value="<?=$arrRequestValue["fax_3"]?>" /> <span class="smallred">（半角英数文字）</span><br /><span class="small">（例：03-1234-5678）</span></td>
              </tr>
              <tr>
                <th class="other">郵送で連絡<br />（送付先）</th>
                <td><input type="checkbox" name="report_type_3" value="3" <?=$arrViewData["report_type_3"]?>/>連絡OK</td>
                <td>〒 <input type="text" name="addr_cd_1" size="3" value="<?=$arrRequestValue["addr_cd_1"]?>" /> - <input type="text" name="addr_cd_2" size="4" value="<?=$arrRequestValue["addr_cd_2"]?>" /> <span class="smallred">（半角数字）</span><br /><input type="text" name="address_1" size="30" value="<?=$arrRequestValue["address_1"]?>" /> <span class="small">（例：東京都○○区○○1-1）</span> <br /><input type="text" name="address_2" size="30" value="<?=$arrRequestValue["address_2"]?>" /></td>
              </tr>
              <tr>
                <th rowspan="2" class="other">Eメールで連絡</th>
                <td><input type="checkbox" name="report_type_4" value="4" <?=$arrViewData["report_type_4"]?>/>連絡OK</td>
                <td><input type="text" name="email" size="30" value="<?=$arrRequestValue["email"]?>" /> <span class="smallred">（半角英数文字）</span><br /><span class="small">（例：○○@○○.com）</span></td>
              </tr>
              <tr>
                <td colspan="2" class="noborder"><p class="small">メールでのみの連絡方法を指定された場合、メール環境のない 不動産会社からは ご連絡できないこともございます。 あらかじめご了承ください。<br />携帯やフリーメールのアドレス画像が上手く表示できない場合がございます。 通常のメールアドレスをご入力ください。</p></td>
              </tr>
              <tr>
                <th>勤務先・通学先の<br />最寄り駅<br /><span class="small">（例：新宿駅）</span></th>
                <td colspan="3"><input type="text" name="station" size="30" value="<?=$arrRequestValue["station"]?>" /></td>
              </tr>
              <tr>
                <th>勤務先・通学先までの<br />希望所要時間<br /><span class="small">（例：45分）</span></th>
                <td colspan="3">
                  <select name="move">
                    <?=$request_move_time_value?>
                  </select>
                </td>
              </tr>
              <tr>
                <th>希望の沿線・駅<br /><span class="small">（例：小田急線下北沢駅）</span></th>
                <td colspan="3"><input type="text" name="line" size="30" value="<?=$arrRequestValue["line"]?>" /></td>
              </tr>
              <tr>
                <th>希望エリア<br /><span class="small">（例：東京都渋谷区）</span></th>
                <td colspan="3"><input type="text" name="area" size="30" value="<?=$arrRequestValue["area"]?>" /></td>
              </tr>
              <tr>
                <th>希望の家賃</th>
                <td colspan="3">
                  <select name="price1">
                    <?=$request_price1_value?>
                  </select>
                   〜 
                  <select name="price2">
                    <?=$request_price2_value?>
                  </select>
                </td>
              </tr>
              <tr>
                <th>希望の間取り<br /><span class="small">（複数選択可）</span></th>
                <td colspan="3">
                  <table>
                    <?=$room_floor_value?>
                  </table>
                </td>
              </tr>
              <tr>
                <th rowspan="5">重視している事<br /><span class="small">（例：家賃、広さ、駅、駅近、ペット相談可能等）</span></th>
                <th class="other">1番目のご希望</th>
                <td colspan="2"><input type="text" name="equip1" size="30" value="<?=$arrRequestValue["equip1"]?>" /></td>
              </tr>
              <tr>
                <th class="other">2番目のご希望</th>
                <td colspan="2"><input type="text" name="equip2" size="30" value="<?=$arrRequestValue["equip2"]?>" /></td>
              </tr>
              <tr>
                <th class="other">3番目のご希望</th>
                <td colspan="2"><input type="text" name="equip3" size="30" value="<?=$arrRequestValue["equip3"]?>" /></td>
              </tr>
              <tr>
                <th class="other">4番目のご希望</th>
                <td colspan="2"><input type="text" name="equip4" size="30" value="<?=$arrRequestValue["equip4"]?>" /></td>
              </tr>
              <tr>
                <th class="other">5番目のご希望</th>
                <td colspan="2"><input type="text" name="equip5" size="30" value="<?=$arrRequestValue["equip5"]?>" /></td>
              </tr>
              <tr>
                <th>その他こだわり<br /><span class="small">（例：室内洗濯機置き場、フローリング、バストイレ別）</span></th>
                <td colspan="3"><textarea name="otherEquip" cols="45" rows="5"><?=$arrRequestValue["otherEquip"]?></textarea></td>
              </tr>
              <tr>
                <th>入居予定時期</th>
                <td colspan="3">
                  <select name="moveTime">
                    <?=$request_move_jiki_value?>
                  </select>
                </td>
              </tr>
              <tr>
                <th>入居予定人数</th>
                <td colspan="3">
                  <table>
                    <tr>
                      <?=$request_menber_value?>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <th>現在の家賃<br /><span class="small">（賃貸在住の方）</span></th>
                <td colspan="3">
                  <select name="nowPrice">
                    <?=$request_now_price_value?>
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <p class="protect">個人情報の取り扱いについて</p>
                  <div class="formpart">
                    <textarea name="textarea" cols="75" rows="10" class="kiyaku" readonly><?=$blog_cl_kojin?></textarea>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="4" class="noborder">
                  <div class="formpart">
                    <input name="imageField" type="image" src="share/images/agree.gif" alt="上記に同意して記入内容確認画面へ" onClick="return request_input_check( this.form )" />
                  </div><!-- formpart -->
                </td>
                <input type="hidden" name="form_flg" value="INDEX" />
                </form>
              </tr>
            </table>
          </div><!-- formmail-style -->
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
