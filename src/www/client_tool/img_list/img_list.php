<?
/******************************************************************************
	<< ��ư���֥� Ver.1.0.0 >>
	Name: img_list.php
	Version: 1.0.0
	Function: ���᡼��BOX
	Author: Click inc
	Date of creation: 2010/05
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

// ������Ͽ��ǽ�������������������������������������������������������������������������������������������������������������������������������������
define(_LIMIT , 500);

$syserr_msg = "img_list.php�ǥ����ƥ२�顼��ȯ�����ޤ����������Ԥ�Ϣ���Ʋ�������";
$syserr_msg1 = "��������󤬤���ޤ���";
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_sql_class.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_image_extension.conf" );

/*----------------------------------------------------------
  ���å������Ͽ����
----------------------------------------------------------*/
session_start();
/*----------------------------------------------------------
        ���顼���饹 - ���󥹥���
----------------------------------------------------------*/
$obj_error = new DispErrMessage();
/*----------------------------------------------------------
  DB��³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );
/*----------------------------------------------------------
  �������������å�
----------------------------------------------------------*/
require_once("../login_chk.php");
/*--------------------------------------------------------
	������ʬ
--------------------------------------------------------*/
// �����ǥ��쥯�ȥ����
define(_IMG_DIR, $param_img_list_path . $_SESSION["_cl_id"] . "/");
define(_IMG_DIR_ADMIN, $param_img_list_path_admin . $_SESSION["_cl_id"] . "/");
if ( !is_dir(_IMG_DIR_ADMIN)  ) {
	mkdir(_IMG_DIR_ADMIN);
	chmod(_IMG_DIR_ADMIN, 0777);
}


/*--------------------------------------------------------
	POST�ͤ��Ǽ����hidden�����
--------------------------------------------------------*/
$athComment = "";
FOREACH( $_POST as $key => $val ){
	$val = stripslashes(htmlspecialchars($val));
	$athComment .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
	
	if (
		$key == "search_title"
		or $key == "search_sort"
	) {
		$search_hidden .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
	}
}

// ¿������ɻ�
$ttoken = $_POST['tt'];
$sesToken = $_SESSION['tt'];

if( $_POST["mode"] == "ins" ){
	// �����ɲâ���������������������������������������������������������������������������������������������������������������������������������
	
	// ���������פ����鹹����
	if($ttoken === $sesToken){
		unset( $_SESSION['tt'] );

		$strErrorComment = "�ե����뤬�����Ǥ���<br />UP�����ե�������ǧ���Ʋ�������";
		IF( is_uploaded_file( $_FILES['img_name']['tmp_name'] ) ){
		
			// �ե����륵���� 2M�ޤ�
			if( filesize($_FILES['img_name']['tmp_name']) > (1024*1024*2) ) {
				// ����������
				$arrOther["ath_comment"] .= $athComment;
				$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "img_list.php" , $arrOther );
				exit;
			}
			
			$image_ret = @getimagesize( $_FILES['img_name']['tmp_name'] );
			// gif or jpg �ϲ�����Ƚ��
			if ( $image_ret[2] == IMAGETYPE_GIF or $image_ret[2] == IMAGETYPE_JPEG ) {
				// ��ĥ��
				$ext = $param_image_extension[ $image_ret[2] ];
			} else {
				//����ʳ��ϸ��ե�����̾�����ĥ�Ҥ����
				$ext = end(explode('.', $_FILES['img_name']['name']));
			}
			
			// insert
			$obj_ins = new basedb_sql_class;
			$obj_ins->set_conn ( $obj_conn->conn );
			$obj_ins->set_table ( "base_t_img_list" );
			$obj_ins->set_serial ( "img_id" );
			$arr_data = array();
			$arr_data["img_cl_id"]		= $_SESSION["_cl_id"];
			$arr_data["img_title"]		= $_POST["img_title"];
			$arr_data["img_url"]		= $_POST["img_url"];
			$arr_data["img_link_type"]	= $_POST["img_link_type"];
//			$arr_data["img_org_name"]	= basename( $_FILES['img_name']['name']); // basename php5�Ǥϥޥ���Х��Ȥ��褿���˥Х������� php6�ǲ��ͽ�� 2013/05/01 Wed ���� 2013/05/09 �ܿ� ����
			$arr_data["img_org_name"]	= end(split('/', $_FILES['img_name']['name']));

			$arr_data["img_ins_date"]	= "now";
			$arr_data["img_upd_date"]	= "now";
			$obj_ins->set_data ($arr_data);
//			$obj_ins->set_debug ( true );
			$ret = $obj_ins->db_insert();
			
			// insert�����Ԥ�id
			$ins_id = $obj_ins->data[$obj_ins->serial];
			
			// id����äƤ����update
			$obj_upd = new basedb_sql_class;
			$obj_upd->set_conn ( $obj_conn->conn );
			$obj_upd->set_table ( "base_t_img_list" );
			$obj_upd->set_tbl_rows ( 1 );
			$arr_data = array();
			$arr_data["img_id"] = $ins_id;
			$obj_upd->set_tbl_key ( $arr_data );

			// �ե�����̾
			$files_name = $ins_id.'.'.$ext;
			// �������ե�����̾
			//$files_name_org =  $_FILES['img_name']["name"];
			
			$arr_data = array();
//			$arr_data["img_name"]		= pg_escape_string( $files_name );
			$arr_data["img_name"]		= $files_name;
			$arr_data["img_ext"]		= $ext;
			$arr_data["img_upd_date"]	= "now";
			$obj_upd->set_data ( $arr_data );
//			$obj_upd->set_debug ( true );
			$ret = $obj_upd->db_update();

			if( $ret == "0" )
			{
				//����³��
				if (is_uploaded_file($_FILES['img_name']['tmp_name']) && $files_name )
				{
					// �����ե��������¸
					move_uploaded_file($_FILES['img_name']['tmp_name'], _IMG_DIR . $files_name);
					chmod(_IMG_DIR . $files_name, 0777);
				}
			}
		}else{
			//��������
		}

		IF( $ret != 0 ){
			// ��Ͽ������˥��顼
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "img_list.php" , $arrOther );
			exit;
		}

	}
}else if ( $_POST["mode"] == "del" ){
	
	// �����������������������������������������������������������������������������������������������������������������������������������������
	// ���������פ����鹹����
	if($ttoken === $sesToken){
		unset( $_SESSION['tt'] );

		$obj_del = new basedb_sql_class;
		$obj_del->set_conn ( $obj_conn->conn );
		$obj_del->set_table ( "base_t_img_list" );
		$obj_del->set_tbl_rows ( 1 );
		$arr_data = array();
//		$arr_data["img_id"] = pg_escape_string($_POST["del_img_id"]);
		$arr_data["img_id"] = $_POST["del_img_id"];
		$obj_del->set_tbl_key ( $arr_data );
//		$obj_del->set_debug ( true );
		$ret = $obj_del->db_delete();

		if( $ret != "0" )
		{
			// ���������˥��顼
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "img_list.php" , $arrOther );
			exit;
		}

		// �����ե��������
		if ( file_exists(_IMG_DIR . $_POST["del_img_name"]) ) {
			unlink(_IMG_DIR . $_POST["del_img_name"]);
		}
	}
}

// ¿������ɻ� �������ٰ�դ�ʸ�������������
$_SESSION['tt'] = uniqid('transactiontoken');

// ���᡼��BOX����
$obj_img = new basedb_sql_class;
$obj_img->set_conn ( $obj_conn->conn );
$obj_img->set_table ( "base_t_img_list" );
$arr_data = array();
$arr_data["img_cl_id"][0] = "=";
$arr_data["img_cl_id"][1] = $_SESSION["_cl_id"];

if ( isset($_POST["search_title"]) and $_POST["search_title"] != "" ) {
	$arr_data["img_title"][0] = "like";
//	$arr_data["img_title"][1] = pg_escape_string($_POST["search_title"]);
	$arr_data["img_title"][1] = $_POST["search_title"];
	$search_title = htmlspecialchars($_POST["search_title"]);
}

$obj_img->set_jyoken ($arr_data);

$arr_data = array();
if ( isset($_POST["search_sort"]) and $_POST["search_sort"] == 9 ) {
	// search_sort:9 ̾����
	$arr_data["img_title"] = "asc";
	$search_sort_checked_9 = "checked";
} else {
	// search_sort:1 ��Ͽ��
	$arr_data["img_upd_date"] = "desc";
	$search_sort_checked_1 = "checked";
}

$obj_img->set_sort ($arr_data);
//$obj_img->set_debug ( true );

list( $imglistcnt , $imglistTotal ) = $obj_img->db_select( _LIMIT, 0 );

$disp_data = "";
for( $ix = 0; $ix < $imglistcnt; $ix++ ) {
	$img_id			= htmlspecialchars($obj_img->data[$ix]["img_id"]);
	$img_title		= htmlspecialchars($obj_img->data[$ix]["img_title"]);
	$img_url		= htmlspecialchars($obj_img->data[$ix]["img_url"]);
	$img_link_type	= htmlspecialchars($obj_img->data[$ix]["img_link_type"]);
	$img_name		= htmlspecialchars($obj_img->data[$ix]["img_name"]);
	$img_org_name	= htmlspecialchars($obj_img->data[$ix]["img_org_name"]);
	$ext			= htmlspecialchars($obj_img->data[$ix]["img_ext"]);
	
	// http�ѥ�����
	if($login_val["cl_googlemap_key"]!="" && $login_val["cl_dokuji_flg"]=="1" && $login_val["cl_dokuji_domain"]!=""){
		$http_path = $login_val["cl_dokuji_domain"] . $param_img_list_path_http;
	}else{
		$http_path = $param_base_blog_addr_url . $param_base_blog_addr . $login_val["cl_url_code"] . "/" . $param_img_list_path_http;
	}
	
	//�����ξ��ν���
	if($ext == 'gif' || $ext == 'jpg' || false){
		// ��������������
		$img_arr = @getimagesize( _IMG_DIR . $obj_img->data[$ix]["img_name"] );
		// Ž���դ��ѥ���������
		$img_tag		= '<img src="' . $http_path . $_SESSION["_cl_id"] . "/" . $obj_img->data[$ix]["img_name"]
					. '" alt="' . $obj_img->data[$ix]["img_title"]
					. '" title="' . $obj_img->data[$ix]["img_title"]
					. '" width="' . $img_arr[0]
					. '" height="' . $img_arr[1]
					. '"/>';
		
		// �����URL�����Ϥ���Ƥ�����硢a�����ǰϤ�
		if ( $img_url != "" ) {
			if ( $img_link_type == 1 ) {
				// ��󥯥����� 1:self
				$target = '_self';
			} else {
				// ��󥯥����� 9:blank
				$target = '_blank';
			}
			$input_val = '<a href="' . $obj_img->data[$ix]["img_url"] . '" target="' . $target . '">' . $img_tag . '</a>';
		} else {
			$input_val = $img_tag;
		}
		$input_val = htmlspecialchars($input_val);
		
		$disp_data .= "        <li class=\"li_img\">\n";
		$disp_data .= "          <a href=\"" . _IMG_DIR . "{$img_name}\" class=\"highslide\" onclick=\"return hs.expand(this)\" onkeypress=\"return hs.expand(this)\" >\n";
		$disp_data .= "            <img src=\"./img_thumbnail.php?w=150&h=150&dir=" . _IMG_DIR . "&nm={$img_name}\" alt=\"{$img_title}\" title=\"{$img_title}\" />\n";
		$disp_data .= "          </a>\n";
		
		// �ݥåץ��å�����
		$disp_data .= "          <div class=\"highslide-caption\">\n";
		$disp_data .= "            <form name=\"img_form_{$ix}\" action=\"img_list.php\" method=\"POST\" >\n";
		$disp_data .= "              {$img_title}<br />\n";
		$disp_data .= "              <input type=\"text\" name=\"tag\" value=\"{$input_val}\" onFocus=\"this.select();\" style=\"width:100%;\" />\n";
		$disp_data .= "              <input type=\"button\" name=\"img_del\" value=\"���\" onClick=\"fn_del_img(this.form);\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"mode\" value=\"del\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"del_img_id\" value=\"{$img_id}\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"del_img_name\" value=\"{$img_name}\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"tt\" value=\"{$_SESSION['tt']}\" />\n";
		$disp_data .= $search_hidden;
		$disp_data .= "            </form>\n";
		
		$disp_data .= "          </div>\n";
		
		$disp_data .= "        </li>\n";
		
	//����ʳ��ξ��ν���
	}else{
		
		// Ž���դ��ѥ���������
		// a�����ǰϤ�
		if ( $img_link_type == 1 ) {
			// ��󥯥����� 1:self
			$target = '_self';
		} else {
			// ��󥯥����� 9:blank
			$target = '_blank';
		}
		$input_val = '<a href="' . $http_path . $_SESSION["_cl_id"] . '/' . $img_name . '" target="' . $target . '">' . $img_title . '</a>';
		$input_val = htmlspecialchars($input_val);
		
		$disp_data .= "        <li class=\"li_img\">\n";
		$disp_data .= "          <a href=\"./file_img.gif\" class=\"highslide\" onclick=\"return hs.expand(this)\" onkeypress=\"return hs.expand(this)\" >\n";
		$disp_data .= "            <img src=\"./img_thumbnail.php?w=150&h=150&dir=./&nm=file_img.gif\" alt=\"{$img_title}\" title=\"{$img_title}\" />\n";
		$disp_data .= "          </a>\n";
		
		// �ݥåץ��å�����
		$disp_data .= "          <div class=\"highslide-caption\">\n";
		$disp_data .= "            <form name=\"img_form_{$ix}\" action=\"img_list.php\" method=\"POST\" >\n";
		$disp_data .= "              {$img_title}<br />\n";
		$disp_data .= "              <input type=\"text\" name=\"tag\" value=\"{$input_val}\" onFocus=\"this.select();\" style=\"width:100%;\" />\n";
		$disp_data .= "              <input type=\"button\" name=\"img_del\" value=\"���\" onClick=\"fn_del_img(this.form);\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"mode\" value=\"del\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"del_img_id\" value=\"{$img_id}\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"del_img_name\" value=\"{$img_name}\" />\n";
		$disp_data .= "              <input type=\"hidden\" name=\"tt\" value=\"{$_SESSION['tt']}\" />\n";
		$disp_data .= $search_hidden;
		$disp_data .= "            </form>\n";
		
		$disp_data .= "          </div>\n";
		
		$disp_data .= "        </li>\n";
		
	}
}
if ( $imglistcnt <= 0 ) {
	$disp_data .= "        <li>�ե��������Ͽ������ޤ���</li>\n";
}

// ������¤ΰ٤ˤ⤦������
$obj_total_img = new basedb_sql_class;
$obj_total_img->set_conn ( $obj_conn->conn );
$obj_total_img->set_table ( "base_t_img_list" );
$arr_data = array();
$arr_data["img_cl_id"][0] = "=";
$arr_data["img_cl_id"][1] = $_SESSION["_cl_id"];
$obj_total_img->set_jyoken ($arr_data);

//$obj_total_img->set_debug ( true );

list( $allcnt , $allcnt_total ) = $obj_total_img->db_select( _LIMIT, 0 );

if ( $allcnt >= _LIMIT ) {
	// ��������ã���Ƥ��ٹ�
	$js_str = "return fn_limit_alert();";
} else {
	// ��Ͽ�����å�
	$js_str = "return fn_check(this.form);";
}


/*----------------------------------------------------------
  DB����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );
/*--------------------------------------------------------
	HTML����
--------------------------------------------------------*/
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <title>��ư���֥� - ���饤����ȴ����ġ���</title>
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <link rel="stylesheet" type="text/css" href="../share/css/img_list.css" />
    <script type="text/javascript" src="../share/js/input_check.js"></script>
    <script type="text/javascript" src="../share/js/img_list.js"></script>
    <link rel="stylesheet" type="text/css" href="../share/highslide/highslide.css" />
    <script type="text/javascript" src="../share/highslide/highslide.js"></script>
    <script type="text/javascript" src="../share/highslide/highslide_config.js"></script>
    <noscript><meta http-equiv="Refresh" content="1;URL=../jserror.html"></noscript>
 </head>
  <body>
<div style="text-align:right">
<?=$Msg?>
</div>
    <span class="title">�ե�����BOX</span>
    <p>�ե�����򥢥åץ��ɤ���ȡ�������gif �ޤ��� jpg�ˤξ��&lt;img&gt;����������ʳ��ξ��ϡ�&lt;a&gt;������ȯ�Ԥ���ޤ���</p>
    <p>ȯ�Ԥ��줿������html��ͳɽ����ʬ���˻��Ѥ��뤳�Ȥ�����ޤ���</p>
    <p>�����ξ�硢�����URL�����Ϥ���ȡ�&lt;a&gt;�����դ���ȯ�Ԥ���ޤ���</p>
    <hr color="#96BC69" />
    <span class="sub_title">��Ͽ</span> <span class="alert"><?=$allcnt?> / <?php print _LIMIT; ?> ��</span>
    <table id="table_ins">
      <form name="ins_form" action="img_list.php" method="POST" enctype="multipart/form-data">
      <tr>
        <td class="td_title">�ե����륿���ȥ�</td>
        <td class="td_val01"><input type="text" name="img_title" value="" maxlength="50" style="width:200px;" /></td>
        <td class="td_title">�ե�����</td>
        <td class="td_val02"><input type="file" name="img_name"></td>
        <td class="td_val03" align="center" rowspan="2">
          <input type="submit" value="��Ͽ" onclick="<?=$js_str?>" class="btn" />
        </td>
      </tr>
      <tr>
        <td class="td_title">�����URL<br /><span style="font-size:smaller">�ʲ����Τ�ͭ����</span></td>
        <td class="td_val01"><input type="text" name="img_url" value="" maxlength="500" style="width:200px;" /></td>
        <td class="td_title">��󥯥�����</td>
        <td class="td_val02">
          <input type="radio" name="img_link_type" id="img_link_type_1" value="1" checked /><label for="img_link_type_1">Ʊ��������ɥ��ǳ���</label>
          <br /><input type="radio" name="img_link_type" id="img_link_type_9" value="9" /><label for="img_link_type_9">�̤Υ�����ɥ��ǳ���</label>
        </td>
      </tr>
      <input type="hidden" name="mode" value="ins" />
      <input type="hidden" name="tt" value="<?=$_SESSION['tt']?>" />
<?=$search_hidden?>
      </form>
    </table>
    
    <hr color="#96BC69" />

    <span class="sub_title">����</span>
    <table id="table_search">
      <tr>
        <form name="serach_form" action="img_list.php" method="POST" enctype="multipart/form-data">
          <td class="td_title">�����ȥ�</td>
          <td class="td_search01">
            <input type="text" name="search_title" maxlength="50" style="width:200px;" value="<?=$search_title?>" />
          </td>
          <td class="td_title">ɽ����</td>
          <td class="td_search02">
            <input type="radio" name="search_sort" value="1" id="search_sort_1" <?=$search_sort_checked_1?> /><label for="search_sort_1">����Ͽ��</label>
            <br /><input type="radio" name="search_sort" value="9" id="search_sort_9" <?=$search_sort_checked_9?> /><label for="search_sort_9">��̾����</label>
          </td>
          <td class="td_search03" align="center" >
            <input type="submit" value="����" class="btn" id="search_btn" style="display:inline;" />
            <br /><input type="button" value="���" onclick="location.href='img_list.php'" class="btn" id="search_btn" />
          </td>
        </form>
      </tr>
    </table>
    <hr color="#96BC69" />

    <ul>
<?=$disp_data?>
    </ul>


    <hr color="#96BC69" />
<br />
  </body>
</html>



