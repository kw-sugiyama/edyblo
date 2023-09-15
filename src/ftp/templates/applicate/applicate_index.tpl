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
    <title>物件お問い合わせ | <?=$arrMetaHeader["title"]?></title>
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
        <div id="tc_box">
          <div id="tc_right">
            <p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">トップページ</a> > 物件お問い合わせ</p>
            <h3>物件お問い合わせ</h3>
            <h4>お問い合わせ物件</h4>
            <div id="add-estate">
              
<?=$strViewRoomList?>
              
            </div><!-- add-estate -->
            
            <h4>上記物件について問い合わせる</h4>
            <p>不動産会社に物件のお問い合わせができます。</p>
            <p>お問い合わせ内容に関する連絡は、あなたのご希望された方法でご連絡いたします。</p>
            <p>必須項目をご記入の上、確認画面に進んでください。</p>
            <div id="formmail-style">
              <table class="basicFrame">
                <form name="applicate_input" method="POST" action="<?=_BLOG_SITE_URL_BASE?>applicate/" target="_self">
                <tr>
                  <th>お問い合わせ内容 <img src="share/css/<?=_SITE_LAYOUT?>/images/require.gif" width="29" height="12" class="icon" /></th>
                  <td colspan="3">
                    <table>
                      <?=$arrViewData["question"]?>
                      <tr>
                        <td colspan="3" class="noborder">
                          <?=$arrViewData["question_sonota"]?>（見学希望日、希望条件、質問などがございましたらご記入ください）
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3" class="noborder">
                          <textarea name="question_other" cols="45" rows="5"><?=$arrInputData["question_other"]?></textarea>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <th>お名前 <img src="share/css/<?=_SITE_LAYOUT?>/images/require.gif" width="29" height="12" class="icon" /></th>
                  <td colspan="3"><input type="text" name="name_kj_1" size="15" value="<?=$arrInputData["name_kj_1"]?>" />&nbsp;<input type="text" name="name_kj_2" size="15" value="<?=$arrInputData["name_kj_2"]?>" /></td>
                </tr>
                <tr>
                  <th>フリガナ</th>
                  <td colspan="3"><input type="text" name="name_kn_1" size="15" value="<?=$arrInputData["name_kn_1"]?>" />&nbsp;<input type="text" name="name_kn_2" size="15" value="<?=$arrInputData["name_kn_2"]?>" /> <span class="smallred">（全角カタカナ）</span></td>
                </tr>
                <tr>
                  <th>性別</th>
                  <td colspan="3"><input type="radio" name="sex" value="1" <?=$arrViewData["sex"][1]?>/>男　<input type="radio" name="sex" value="2" <?=$arrViewData["sex"][2]?>/>女</td>
                </tr>
                <tr>
                  <th>年齢</th>
                  <td colspan="3"><input type="text" name="old" size="2" value="<?=$arrInputData["old"]?>" /> 歳 <span class="smallred">（半角英数文字）</span></td>
                </tr>
                <tr>
                  <th>職業</th>
                  <td colspan="3">
                    <table>
                      <?=$arrViewData["work_kind"]?>
                    </table>
                  </td>
                </tr>
                <tr>
                  <th rowspan="5">連絡方法 <img src="share/css/<?=_SITE_LAYOUT?>/images/require.gif" width="29" height="12" class="icon" /></th>
                  <th class="other">電話で連絡</th>
                  <td><input type="checkbox" name="report_type_1" value="1" <?=$arrViewData["report_type_1"]?>/>連絡OK</td>
                  <td><input type="text" name="tell_1" size="4" value="<?=$arrInputData["tell_1"]?>" /> - <input type="text" name="tell_2" size="4" value="<?=$arrInputData["tell_2"]?>" /> - <input type="text" name="tell_3" size="4" value="<?=$arrInputData["tell_3"]?>" /><span class="smallred">（半角英数文字）</span> <span class="small">（例：03-1234-5678）</span><br />連絡ご希望の時間帯<input type="text" name="tell_time" size="15" value="<?=$arrInputData["tell_time"]?>" /> <span class="small">（例：○時〜○時）</span></td>
                </tr>
                <tr>
                  <th class="other">FAXで連絡</th>
                  <td><input type="checkbox" name="report_type_2" value="2" <?=$arrViewData["report_type_2"]?>/>連絡OK</td>
                  <td><input type="text" name="fax_1" size="4" value="<?=$arrInputData["fax_1"]?>" /> - <input type="text" name="fax_2" size="4" value="<?=$arrInputData["fax_2"]?>" /> - <input type="text" name="fax_3" size="4" value="<?=$arrInputData["fax_3"]?>" /><span class="smallred">（半角英数文字）</span><br /><span class="small">（例：03-1234-5678）</span></td>
                </tr>
                <tr>
                  <th class="other">郵送で連絡<br />（送付先）</th>
                  <td><input type="checkbox" name="report_type_3" value="3" <?=$arrViewData["report_type_3"]?>/>連絡OK</td>
                  <td>〒 <input type="text" name="addr_cd_1" size="3" value="<?=$arrInputData["addr_cd_1"]?>" /> - <input type="text" name="addr_cd_2" size="4" value="<?=$arrInputData["addr_cd_2"]?>" /> <span class="smallred">（半角英数文字）</span><br /><input type="text" name="address_1" size="30" value="<?=$arrInputData["address_1"]?>" /> <span class="small">（例：東京都○○区○○1-1）</span> <br /><input type="text" name="address_2" size="30" value="<?=$arrInputData["address_2"]?>" /></td>
                </tr>
                <tr>
                  <th rowspan="2" class="other">Eメールで連絡</th>
                  <td><input type="checkbox" name="report_type_4" value="4" <?=$arrViewData["report_type_4"]?>/>連絡OK</td>
                  <td><input type="text" name="email" size="30" value="<?=$arrInputData["email"]?>" /> <span class="smallred">（半角英数文字）</span><br /><span class="small">（例：○○@○○.com）</span></td>
                </tr>
                <tr>
                  <td colspan="2" class="noborder">
                    <p class="small">メールでのみの連絡方法を指定された場合、メール環境のない 不動産会社からは ご連絡できないこともございます。 あらかじめご了承ください。<br />携帯やフリーメールのアドレス画像が上手く表示できない場合がございます。 通常のメールアドレスをご入力ください。</p>
                  </td>
                </tr>
                <tr>
                  <td colspan="4">
                    <p class="protect">個人情報の取り扱いについて</p>
                    <div class="formpart">
                      <textarea name="textarea" cols="75" rows="10" class="kiyaku" readonly><?=$arrClientData["blog_cl_kojin"]?></textarea>
                    </div><!-- formpart -->
                  </td>
                </tr>
                <tr>
                  <td colspan="4" class="noborder">
                    <div class="formpart">
                      <input name="imageField" type="image" src="share/images/agree.gif" alt="上記に同意して記入内容確認画面へ" onClick="return applicate_input_check( this.form )" />
                    </div>
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
        </div><!-- tc_box -->
      </div><!-- wrapper -->

<?php require_once( SYS_PATH."php/disp_footer.php" ); ?>

    </div><!-- container -->
<?php require_once( SYS_PATH."templates/analytics.tpl" ); ?>
  </body>
</html>
