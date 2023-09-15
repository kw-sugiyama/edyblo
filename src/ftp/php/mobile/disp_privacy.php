<?
//=====================
//privacy_tblで使う変数
//privacy_policy
//=====================


if($obj_login->clientdat[0]['sc_privacy']){
	 $privacy_policy='
		  <font size="1">
					<hr color="#FFC000"> 
					 <div class="box">
					 <!--boxlittle start-->
					 <td class="padding1 bggray">
					 <p>
					 <font size="<?=FONT_SIZE?>">
					 <font size="1">
					 個人情報の取扱いについて
					</p>
					 <p>
					 <font size="<?=FONT_SIZE?>">
					 					 '.nl2br($arrHeaderView['sc_privacy']).'
					 </p>
					 </div><!--box end-->
					 ';
}else{
		  $privacy_policy="";
}
?>
