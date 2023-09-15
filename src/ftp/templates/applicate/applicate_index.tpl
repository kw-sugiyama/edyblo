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
    <title>ʪ�浪�䤤��碌 | <?=$arrMetaHeader["title"]?></title>
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
            <p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">�ȥåץڡ���</a> > ʪ�浪�䤤��碌</p>
            <h3>ʪ�浪�䤤��碌</h3>
            <h4>���䤤��碌ʪ��</h4>
            <div id="add-estate">
              
<?=$strViewRoomList?>
              
            </div><!-- add-estate -->
            
            <h4>�嵭ʪ��ˤĤ����䤤��碌��</h4>
            <p>��ư����Ҥ�ʪ��Τ��䤤��碌���Ǥ��ޤ���</p>
            <p>���䤤��碌���Ƥ˴ؤ���Ϣ���ϡ����ʤ��Τ���˾���줿��ˡ�Ǥ�Ϣ���������ޤ���</p>
            <p>ɬ�ܹ��ܤ򤴵����ξ塢��ǧ���̤˿ʤ�Ǥ���������</p>
            <div id="formmail-style">
              <table class="basicFrame">
                <form name="applicate_input" method="POST" action="<?=_BLOG_SITE_URL_BASE?>applicate/" target="_self">
                <tr>
                  <th>���䤤��碌���� <img src="share/css/<?=_SITE_LAYOUT?>/images/require.gif" width="29" height="12" class="icon" /></th>
                  <td colspan="3">
                    <table>
                      <?=$arrViewData["question"]?>
                      <tr>
                        <td colspan="3" class="noborder">
                          <?=$arrViewData["question_sonota"]?>�ʸ��ش�˾������˾������ʤɤ��������ޤ����餴��������������
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
                  <th>��̾�� <img src="share/css/<?=_SITE_LAYOUT?>/images/require.gif" width="29" height="12" class="icon" /></th>
                  <td colspan="3"><input type="text" name="name_kj_1" size="15" value="<?=$arrInputData["name_kj_1"]?>" />&nbsp;<input type="text" name="name_kj_2" size="15" value="<?=$arrInputData["name_kj_2"]?>" /></td>
                </tr>
                <tr>
                  <th>�եꥬ��</th>
                  <td colspan="3"><input type="text" name="name_kn_1" size="15" value="<?=$arrInputData["name_kn_1"]?>" />&nbsp;<input type="text" name="name_kn_2" size="15" value="<?=$arrInputData["name_kn_2"]?>" /> <span class="smallred">�����ѥ������ʡ�</span></td>
                </tr>
                <tr>
                  <th>����</th>
                  <td colspan="3"><input type="radio" name="sex" value="1" <?=$arrViewData["sex"][1]?>/>�ˡ�<input type="radio" name="sex" value="2" <?=$arrViewData["sex"][2]?>/>��</td>
                </tr>
                <tr>
                  <th>ǯ��</th>
                  <td colspan="3"><input type="text" name="old" size="2" value="<?=$arrInputData["old"]?>" /> �� <span class="smallred">��Ⱦ�ѱѿ�ʸ����</span></td>
                </tr>
                <tr>
                  <th>����</th>
                  <td colspan="3">
                    <table>
                      <?=$arrViewData["work_kind"]?>
                    </table>
                  </td>
                </tr>
                <tr>
                  <th rowspan="5">Ϣ����ˡ <img src="share/css/<?=_SITE_LAYOUT?>/images/require.gif" width="29" height="12" class="icon" /></th>
                  <th class="other">���ä�Ϣ��</th>
                  <td><input type="checkbox" name="report_type_1" value="1" <?=$arrViewData["report_type_1"]?>/>Ϣ��OK</td>
                  <td><input type="text" name="tell_1" size="4" value="<?=$arrInputData["tell_1"]?>" /> - <input type="text" name="tell_2" size="4" value="<?=$arrInputData["tell_2"]?>" /> - <input type="text" name="tell_3" size="4" value="<?=$arrInputData["tell_3"]?>" /><span class="smallred">��Ⱦ�ѱѿ�ʸ����</span> <span class="small">���㡧03-1234-5678��</span><br />Ϣ������˾�λ�����<input type="text" name="tell_time" size="15" value="<?=$arrInputData["tell_time"]?>" /> <span class="small">���㡧������������</span></td>
                </tr>
                <tr>
                  <th class="other">FAX��Ϣ��</th>
                  <td><input type="checkbox" name="report_type_2" value="2" <?=$arrViewData["report_type_2"]?>/>Ϣ��OK</td>
                  <td><input type="text" name="fax_1" size="4" value="<?=$arrInputData["fax_1"]?>" /> - <input type="text" name="fax_2" size="4" value="<?=$arrInputData["fax_2"]?>" /> - <input type="text" name="fax_3" size="4" value="<?=$arrInputData["fax_3"]?>" /><span class="smallred">��Ⱦ�ѱѿ�ʸ����</span><br /><span class="small">���㡧03-1234-5678��</span></td>
                </tr>
                <tr>
                  <th class="other">͹����Ϣ��<br />���������</th>
                  <td><input type="checkbox" name="report_type_3" value="3" <?=$arrViewData["report_type_3"]?>/>Ϣ��OK</td>
                  <td>�� <input type="text" name="addr_cd_1" size="3" value="<?=$arrInputData["addr_cd_1"]?>" /> - <input type="text" name="addr_cd_2" size="4" value="<?=$arrInputData["addr_cd_2"]?>" /> <span class="smallred">��Ⱦ�ѱѿ�ʸ����</span><br /><input type="text" name="address_1" size="30" value="<?=$arrInputData["address_1"]?>" /> <span class="small">���㡧����ԡ��������1-1��</span> <br /><input type="text" name="address_2" size="30" value="<?=$arrInputData["address_2"]?>" /></td>
                </tr>
                <tr>
                  <th rowspan="2" class="other">E�᡼���Ϣ��</th>
                  <td><input type="checkbox" name="report_type_4" value="4" <?=$arrViewData["report_type_4"]?>/>Ϣ��OK</td>
                  <td><input type="text" name="email" size="30" value="<?=$arrInputData["email"]?>" /> <span class="smallred">��Ⱦ�ѱѿ�ʸ����</span><br /><span class="small">���㡧����@����.com��</span></td>
                </tr>
                <tr>
                  <td colspan="2" class="noborder">
                    <p class="small">�᡼��ǤΤߤ�Ϣ����ˡ����ꤵ�줿��硢�᡼��Ķ��Τʤ� ��ư����Ҥ���� ��Ϣ���Ǥ��ʤ����Ȥ⤴�����ޤ��� ���餫���ᤴλ������������<br />���Ӥ�ե꡼�᡼��Υ��ɥ쥹��������꤯ɽ���Ǥ��ʤ���礬�������ޤ��� �̾�Υ᡼�륢�ɥ쥹�����Ϥ���������</p>
                  </td>
                </tr>
                <tr>
                  <td colspan="4">
                    <p class="protect">�Ŀ;���μ�갷���ˤĤ���</p>
                    <div class="formpart">
                      <textarea name="textarea" cols="75" rows="10" class="kiyaku" readonly><?=$arrClientData["blog_cl_kojin"]?></textarea>
                    </div><!-- formpart -->
                  </td>
                </tr>
                <tr>
                  <td colspan="4" class="noborder">
                    <div class="formpart">
                      <input name="imageField" type="image" src="share/images/agree.gif" alt="�嵭��Ʊ�դ��Ƶ������Ƴ�ǧ���̤�" onClick="return applicate_input_check( this.form )" />
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