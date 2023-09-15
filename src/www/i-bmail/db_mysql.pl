#!/usr/local/bin/php-cgi-4.3.6
<?
    $conn = mysql_connect($db_server_name, $db_user_name, $db_password)
	or die ("Ú‘±‚Å‚«‚Ü‚¹‚ñ‚Å‚µ‚½");
    mysql_select_db($db_name, $conn)
	or die ("Ú‘±‚Å‚«‚Ü‚¹‚ñ‚Å‚µ‚½");
    
    function db_close() {
	mysql_close();
    }

    function getSign() {
        global $conn, $username;

	$query = "select sig from imp_pref where user = '$username'";
	$result = mysql_query( $query, $conn );

	return mysql_result ( $result, 0, "sig" );
    }

    function addSign( $sign, $new_flg ){
        global $conn, $username;
	if ( $new_flg == 1 ) {
	    $query = "insert into imp_pref (user, sig) values ( '$username', '$sign' )";
	} else {
	    $query = "update imp_pref set sig = '$sign' where user = '$username'";
	}
	$result = mysql_query( $query, $conn );
    }

    function getAddressList() {
        global $conn, $username;

	$query = "select address, fullname from imp_addr where user = '$username'";
	## $result = mysql_query( $query, $conn );
	$result = mysql_query( $query, $conn )
	    or die ("‚c‚aŒŸõ‚ÉŽ¸”s‚µ‚Ü‚µ‚½" . mysql_error() );
	$rows = mysql_num_rows( $result );

	$list = array();
	for ( $i = 0; $i < $rows; $i++ ) {
	    $mail_add = mysql_result ( $result, $i, "address" ); 
	    $name = mysql_result ( $result, $i, "fullname" );
	    $list[$i] = array( $mail_add, $name );
	}

	return $list;
    }

    function addAddressBook( $mail_add, $name, $select_mail, $new_flg ){
        global $conn, $username;
	if ( $new_flg == 1 ) {
	    $query = "insert into imp_addr ( user, address, fullname ) values ( '$username', '$mail_add', '$name' ) ";
	} else {
	    $query = "update imp_addr set address = '$mail_add', fullname = '$name' where user = '$username' and address = '$select_mail'";
	}
	$result = mysql_query( $query, $conn );
    }

    function delAddressBook( $select_mail ){
        global $conn, $username;

	$query = "delete from imp_addr where user ='$username' and address = '$select_mail'";
	$result = mysql_query( $query, $conn );
    }

    function getFullnameFromAB( $select_mail ){
        global $conn, $username;

	$query = "select address, fullname from imp_addr where user = '$username' and address = '$select_mail'";
	$result = mysql_query( $query, $conn );

	return mysql_result( $result, 0, "fullname" );
    }
?>
