<?

$school_box_title=$obj_login->clientdat[0]['cl_jname'].'@'.$obj_login->clientdat[0]['cl_kname'];
$school_box_contents=nl2br($obj_login->clientdat[0]['sc_pr']);
$school_box_img='<img src="./img_thumbnail.php?w=300&h=300&dir='.$param_cl_photo_path.'&nm='.$obj_login->clientdat[0]['sc_topimg'].'" alt="" />';

?>