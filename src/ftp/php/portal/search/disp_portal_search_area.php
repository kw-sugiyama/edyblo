<?php

/*=======================================================
    ���ꥢ�����ѽ���
=======================================================*/

// ���������
IF ($_GET["page_flg"] == "arealine"){
// ��������

	//title
	$view_header_title = '';
	$view_header_title = '����α�������̾����ؽ��Τ�õ���óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
	//keywords
	$view_header_keywoeds = '';
	$view_header_keywoeds = '�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����,��Ω,��Ω,����,����';
	//description
	$view_header_description = '';
	$view_header_description = '�Υ�����α�������̾���鸡���ڡ����������ǡˤǤ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ���';
	$view_header_description .= '�ϰ����Ū�ʼ����к����佤�ˡ���Ƴ���֡ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';

//	����α��������ɤ��̤�ʬ���Ƽ���
//	v_search_line es_linecd_list�Ǥ��θ��α�������
//	ȯ���������ɽ��

	// ���������
	$link = "/psearch-line/";

	// viewdb_SearchLineClass.php
	/*=======================================================
	    ���������н���
	=======================================================*/
	$obj_sprefcnt = new viewdb_SLineClassTblAccess;
	$obj_sprefcnt->conn = $obj_conn->conn;
	$obj_sprefcnt->jyoken = array(); 
	$ret = $obj_sprefcnt->viewdb_CntSLPref( 1 , -1);
	$view_prefdat = array();
	foreach( $obj_sprefcnt->slinedat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_sprefcnt->slinedat[$key][$key2] );
			}else{
				$view_prefdat[$key][$key2] = $obj_sprefcnt->slinedat[$key][$key2];
				$view_prefdat[$key]['ar_prefcd'] = $view_prefdat[$key]['st_prefcd'];
			}
		}
	}
	unset($key, $key2, $val, $val2, $obj_sprefcnt->slinedat);

} ELSE {
// ���ꥢ����

	//title
	$view_header_title = '';
	$view_header_title = '����Υ��ꥢ����ؽ��Τ�õ���óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
	//keywords
	$view_header_keywoeds = '';
	$view_header_keywoeds = '�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�����,��Ω,��Ω,����';
	//description
	$view_header_description = '';
	$view_header_description = '�Υ�����Υ��ꥢ���鸡���ڡ����������ǡˤǤ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ����ϰ����Ū�ʼ����к����佤�ˡ�';
	$view_header_description .= '��Ƴ���֡ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';

	// ���������
	$link = "/psearch-pref/";
	
	// viewdb_SearchPrefClass.php
	/*=======================================================
	    ���������н���
	=======================================================*/
	$obj_sprefcnt = new viewdb_SPrefClassTblAccess;
	$obj_sprefcnt->conn = $obj_conn->conn;
	$obj_sprefcnt->jyoken = array(); 
	$ret = $obj_sprefcnt->viewdb_CntSPref( 1 , -1);
	$view_prefdat = array();
	foreach( $obj_sprefcnt->sprefdat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_sprefcnt->sprefdat[$key][$key2] );
			}else{
				$view_prefdat[$key][$key2] = $obj_sprefcnt->sprefdat[$key][$key2];
			}
		}
	}
	unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat);

};

$view_hokkaido = "";
$view_tohoku = "";
$view_kanto = "";
$view_hokuriku = "";
$view_tokai = "";
$view_kansai = "";
$view_shikoku = "";
$view_kyushu = "";

$tohoku_cnt = 0;
$kanto_cnt = 0;
$hokuriku_cnt = 0;
$tokai_cnt = 0;
$kansai_cnt = 0;
$shikoku_cnt = 0;
$kyushu_cnt = 0;

$select_val = '';	// �ץ���������ѿ�

foreach( $view_prefdat as $key => $val){
/*��$psel[$view_prefdat[$key]['ar_prefcd']]���ϸ�̾��*/
	switch( TRUE ){
		
		
		/*�̳�ƻ���ꥢ��ɽ������*/
		case ( $view_prefdat[$key]['ar_prefcd'] == 1) :
				$view_hokkaido .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'��'.$view_prefdat[$key]['count'].'���</a></label>'."\n";
			break;
			
			
		/*���̥��ꥢ��ɽ������*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 2 && $view_prefdat[$key]['ar_prefcd'] <= 7 ) :
			if( $tohoku_cnt != 0 && $tohoku_cnt%3 == 0 ) $view_tohoku .= "<br>\n";
				$view_tohoku .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'��'.$view_prefdat[$key]['count'].'���</a></label>'."\n";
			$tohoku_cnt ++;
			break;
		
		
		/*���쥨�ꥢ��ɽ������*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 8 && $view_prefdat[$key]['ar_prefcd'] <= 14 ) :
			if( $kanto_cnt != 0 && $kanto_cnt%3 == 0 ) $view_kanto .= "<br>\n";
				$view_kanto .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'��'.$view_prefdat[$key]['count'].'���</a></label>'."\n";
			$kanto_cnt ++;
			break;
		
		
		/*��Φ���ꥢ��ɽ������*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 15 && $view_prefdat[$key]['ar_prefcd'] <= 20 ) :
			if( $hokuriku_cnt != 0 && $hokuriku_cnt%3 == 0 ) $view_hokuriku .= "<br>\n";
				$view_hokuriku .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'��'.$view_prefdat[$key]['count'].'���</a></label>'."\n";
			$hokuriku_cnt ++;
			break;
		
		
		/*�쳤���ꥢ��ɽ������*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 21 && $view_prefdat[$key]['ar_prefcd'] <= 24 ) :
			if( $tokai_cnt != 0 && $tokai_cnt%3 == 0 ) $view_tokai .= "<br>\n";
				$view_tokai .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'��'.$view_prefdat[$key]['count'].'���</a></label>'."\n";
			$tokai_cnt ++;
			break;
		
		
		/*�������ꥢ��ɽ������*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 25 && $view_prefdat[$key]['ar_prefcd'] <= 30 ) :
			if( $kansai_cnt != 0 && $kansai_cnt%3 == 0 ) $view_kansai .= "<br>\n";
				$view_kansai .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'��'.$view_prefdat[$key]['count'].'���</a></label>'."\n";
			$kansai_cnt ++;
			break;
		
		
		/*�͹񥨥ꥢ��ɽ������*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 31 && $view_prefdat[$key]['ar_prefcd'] <= 39 ) :
			if( $shikoku_cnt != 0 && $shikoku_cnt%3 == 0 ) $view_shikoku .= "<br>\n";
				$view_shikoku .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'��'.$view_prefdat[$key]['count'].'���</a></label>'."\n";
			$shikoku_cnt ++;
			break;
		
		
		/*�彣���ꥢ��ɽ������*/
		case ( $view_prefdat[$key]['ar_prefcd'] >= 40 && $view_prefdat[$key]['ar_prefcd'] <= 47 ) :
			if( $kyushu_cnt != 0 && $kyushu_cnt%3 == 0 ) $view_kyushu .= "<br>\n";
				$view_kyushu .= '<label><input type="checkbox" name="ar[]" value="'.$view_prefdat[$key]['ar_prefcd'].'"> <a href="'.$link.'?ar[]='.$view_prefdat[$key]['ar_prefcd'].'">'.$psel[$view_prefdat[$key]['ar_prefcd']].'��'.$view_prefdat[$key]['count'].'���</a></label>'."\n";
			$kyushu_cnt ++;
			break;
	}

	// ʪ�郎¸�ߤ��븩�Τߥץ�������ɽ��
	$select_val .= '<option value="' . $view_prefdat[$key]['ar_prefcd'] . '">' . $psel[$view_prefdat[$key]['ar_prefcd']] . '</option>' . "\n";
}

if( $view_hokkaido == "" ) $view_hokkaido = "&nbsp;\n";
if( $view_tohoku == "" ) $view_tohoku = "&nbsp;\n";
if( $view_kanto == "" ) $view_kanto = "&nbsp;\n";
if( $view_hokuriku == "" ) $view_hokuriku = "&nbsp;\n";
if( $view_tokai == "" ) $view_tokai = "&nbsp;\n";
if( $view_kansai == "" ) $view_kansai = "&nbsp;\n";
if( $view_shikoku == "" ) $view_shikoku = "&nbsp;\n";
if( $view_kyushu == "" ) $view_kyushu = "&nbsp;\n";

$view_pref_list = '
<div class="box">
<table class="search1">
<tr>
<th>
<p class="area"><strong>�̳�ƻ</strong></p>
</th>
<td>
<p class="area">'.$view_hokkaido.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>����</strong></p>
</th>
<td>
<p class="area">
'.$view_tohoku.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>����</strong></p>
</th>
<td>
<p class="area">
'.$view_kanto.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>��Φ���ÿ���</strong></p>
</th>
<td>
<p class="area">
'.$view_hokuriku.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>�쳤</strong></p>
</th>
<td>
<p class="area">
'.$view_tokai.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>����</strong></p>
</th>
<td>
<p class="area">
'.$view_kansai.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>��񡦻͹�</strong></p>
</th>
<td>
<p class="area">
'.$view_shikoku.'</p>
</td>
</tr>
<tr>
<th>
<p class="area"><strong>�彣</strong></p>
</th>
<td>
<p class="area">
'.$view_kyushu.'</p>
</td>
</tr>
</table>

</div><!--search end-->
';

unset( $view_prefdat );

?>