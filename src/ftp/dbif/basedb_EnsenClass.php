<?
/*****************************************************************************
	クライアントDBクラス
******************************************************************************/

require_once( SYS_PATH."dbif/dbcom_DBcntlClass.php");

class basedb_EnsenClassTblAccess extends dbcom_DBcontroll {
	
	/*  メンバー変数定義  */
	var $conn;		// ＤＢ接続ＩＤ
	var $php_error;		// 処理エラー時のメッセージ
	var $jyoken;		// 検索条件を格納する配列
	var $sort;		// 検索表示順を指定
	var $ensendat;		// 検索結果を格納する２次元連想配列
	
	/*  コンストラクタ（メンバー変数の初期化）  */
	function basedb_EnsenClassTblAccess () {
		$this->conn = NULL;		// ＤＢ接続ＩＤ
		$this->php_error = NULL;	// 処理エラーメッセージ
		$this->jyoken = Array();	// 検索条件
		$this->sort = NULL;		// 検索表示順を指定
		$this->ensendat = Array();	// ２次元連想配列
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 検索
	-----------------------------------------------------*/
	function basedb_GetEnsen ( $stpos , $getnum ) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_GetEnsen(1):".$obj->php_error;
			return array (-1,NULL);
		}
		
		//ＳＱＬ条件作成
		$sql_where = "";
		if( $this->jyoken["es_id"] != "" )       $sql_where .= " AND es_id = '{$this->jyoken["es_id"]}' ";
		if( $this->jyoken["es_cd"] != "" )     $sql_where .= " AND es_cd = '{$this->jyoken["es_cd"]}' ";
		if( $this->jyoken["es_type"] != "" )    $sql_where .= " AND es_type = '{$this->jyoken["es_type"]}' ";

		if( $this->jyoken["es_dispno"] != "" )    $sql_where .= " AND es_dispno = '{$this->jyoken["es_dispno"]}' ";
		if( $this->jyoken["es_prefcd"] != "" )    $sql_where .= " AND es_prefcd = '{$this->jyoken["es_prefcd"]}' ";
		if( $this->jyoken["es_line"] != "" )    $sql_where .= " AND es_line = '{$this->jyoken["es_line"]}' ";
		if( $this->jyoken["es_linecd"] != "" )    $sql_where .= " AND es_linecd = '{$this->jyoken["es_linecd"]}' ";
		if( $this->jyoken["es_sta"] != "" )    $sql_where .= " AND es_sta = '{$this->jyoken["es_sta"]}' ";
		if( $this->jyoken["es_stacd"] != "" )    $es_stacd .= " AND es_type = '{$this->jyoken["es_stacd"]}' ";
		if( $this->jyoken["es_walk"] != "" )    $sql_where .= " AND es_walk = '{$this->jyoken["es_walk"]}' ";
		if( $this->jyoken["es_bus"] != "" )    $sql_where .= " AND es_bus = '{$this->jyoken["es_bus"]}' ";
		if( $this->jyoken["es_adminid"] != "" )    $sql_where .= " AND es_adminid = '{$this->jyoken["es_adminid"]}' ";
		if( $this->jyoken["es_insdate"] != "" )    $sql_where .= " AND es_insdate = '{$this->jyoken["es_insdate"]}' ";

		if( $this->jyoken["es_upddate"] != "" )   $sql_where .= " AND es_upddate = '{$this->jyoken["es_upddate"]}' ";
		if( $this->jyoken["es_deldate"] != "" ) $sql_where .= " AND es_deldate is NULL ";

		//ＳＱＬ条件作成
		if( $this->sort["es_dispno"] == 1 ){
			$sql_order = " ORDER BY es_dispno ";
		}else if( $this->sort["es_dispno"] == 2 ){
			$sql_order = " ORDER BY es_dispno desc ";

		}

		$strSQL = "";
		$strSQL = " SELECT * FROM t_ensen ";
		$stmt2 = "";
		$stmt2 .= " WHERE es_id is NOT NULL ";
		$stmt2 .= $sql_where;
		$strSQL .= $stmt2;
		$strSQL .= $sql_order;
		//LIMIT、OFFSET利用
		if( $getnum != -1 ){
			$offs = $stpos -1 ;
			$strSQL .= "LIMIT {$getnum} OFFSET {$offs} ";
		}
		
		//　ＳＱＬ実行
	//echo "GetEnsen_SQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetEnsen(2):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples( $result ) > 0 ) {
			$this->php_error = "basedb_GetEnsen(3):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$numrows = pg_numrows( $result );
		$cnt = 0;
		for ( $curpos=0; $curpos<$numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->ensendat[$curpos][$key] = $val;
			}
			$cnt++;
		}
		@pg_free_result( $result );
		
		//　全件数取得
		$strSQL = "";
		$strSQL .= " SELECT count(es_id) FROM t_ensen ";
		$strSQL .= $stmt2;
	//echo "GetEnsen_TotalSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_GetEnsen(4):".pg_errormessage ($this->conn);
			return array (-1,NULL);
		}
		if ( pg_cmdtuples ( $result ) > 0 ) {
			$this->php_error = "basedb_GetEnsen(5):Get Failed";
			$obj->dbcom_DbRollback ();
			return array (-1,NULL);
		}
		$total = @pg_result( $result , 0 , count );
		@pg_free_result( $result );
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_GetEnsen(6):Get Failed";
			return array (-1,NULL);
		}
		
		return array( $cnt , $total );
		
	}
	
	
	/*-----------------------------------------------------
	    ブログ基本情報 - 登録
	-----------------------------------------------------*/
	function basedb_InsEnsen () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_InsEnsen(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " LOCK TABLE t_ensen IN exclusive mode";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_InsEnsen(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		
		//  クライアント情報登録
		$strSQL = "";
		$strSQL .= " INSERT INTO t_ensen ";
		$strSQL .= "           ( ";
		$strSQL .= "             es_cd , ";
		$strSQL .= "             es_type , ";
		$strSQL .= "             es_dispno , ";
		$strSQL .= "             es_prefcd , ";
		$strSQL .= "             es_line , ";
		$strSQL .= "             es_linecd , ";
		$strSQL .= "             es_linecdname , ";
		$strSQL .= "             es_sta , ";
		$strSQL .= "             es_stacd , ";
		$strSQL .= "             es_walk , ";
		$strSQL .= "             es_bus , ";
		$strSQL .= "             es_biko , ";
		$strSQL .= "             es_adminid , ";
		$strSQL .= "             es_insdate , ";
		$strSQL .= "             es_upddate";
		$strSQL .= "           ) ";
		$strSQL .= "      VALUES ";
		$strSQL .= "           ( ";
		if($this->ensendat[0]["es_cd"]!=""){
			$strSQL .= "             '{$this->ensendat[0]["es_cd"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->ensendat[0]["es_type"]!=""){
			$strSQL .= "             '{$this->ensendat[0]["es_type"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->ensendat[0]["es_dispno"]!=""){
			$strSQL .= "             '{$this->ensendat[0]["es_dispno"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->ensendat[0]["es_prefcd"]!=""){
			$strSQL .= "             '{$this->ensendat[0]["es_prefcd"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             '{$this->ensendat[0]["es_line"]}' , ";
		if($this->ensendat[0]["es_linecd"]!=""){
			$strSQL .= "             '{$this->ensendat[0]["es_linecd"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             '{$this->ensendat[0]["es_linecdname"]}' , ";
		$strSQL .= "             '{$this->ensendat[0]["es_sta"]}' , ";
		if($this->ensendat[0]["es_stacd"]!=""){
			$strSQL .= "             '{$this->ensendat[0]["es_stacd"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->ensendat[0]["es_walk"]!=""){
			$strSQL .= "             '{$this->ensendat[0]["es_walk"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		if($this->ensendat[0]["es_bus"]!=""){
			$strSQL .= "             '{$this->ensendat[0]["es_bus"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             '{$this->ensendat[0]["es_biko"]}' , ";
		if($this->ensendat[0]["es_adminid"]!=""){
			$strSQL .= "             '{$this->ensendat[0]["es_adminid"]}' , ";
		}else{
			$strSQL .= "             NULL , ";
		}
		$strSQL .= "             'now' ,  ";
		$strSQL .= "             'now'";
		$strSQL .= "           ) ";
	//echo "EnsenInsSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ) {
echo("1");
			$this->php_error = "basedb_InsEnsen(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
echo("2");
			$this->php_error = "basedb_InsEnsen(6):Insert Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		//  トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
echo("3");
			$this->php_error = "basedb_InsEnsen(7):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 更新処理
	-----------------------------------------------------*/
	function basedb_UpdEnsen () {
		
		//  トランザクション開始
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
echo("#SC#0#SC#");
			$this->php_error = "basedb_UpdEnsen(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_ensen ";
		$strSQL .= "  WHERE es_id = {$this->ensendat[0]["es_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
//echo($strSQL."<br>");
		if ( !$result ) {
			$this->php_error = "basedb_UpdEnsen(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データ・第３者が先に更新したかのチェック
		$arr = @pg_fetch_array ( $result , 0 );
		if ( $this->ensendat[0]["es_id"] != $arr["es_id"] ) {
echo("#SC#1#SC#");
			$this->php_error = "basedb_UpdEnsen(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->ensendat[0]["es_clid"] != $arr["es_clid"] ) {
echo("#SC#2#SC#");
			$this->php_error = "basedb_UpdEnsen(4):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( $this->ensendat[0]["es_upddate"] != $arr["es_upddate"] ) {
echo("#SC#3#SC#");
			$this->php_error = "basedb_UpdEnsen(5):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (1);
		}
		@pg_free_result( $result );
		
		
		//  管理者情報修正
		$strSQL = "";
		$strSQL .= " UPDATE t_ensen ";
		$strSQL .= "    SET ";
		if($this->ensendat[0]["es_prefcd"] != ""){
			$strSQL .= "        es_prefcd = {$this->ensendat[0]["es_prefcd"]} , ";
		}else{
			$strSQL .= "        es_prefcd = NULL , ";
		}
		$strSQL .= "        es_line = '{$this->ensendat[0]["es_line"]}' , ";
		if($this->ensendat[0]["es_linecd"] != ""){
			$strSQL .= "        es_linecd = '{$this->ensendat[0]["es_linecd"]}' , ";
		}else{
			$strSQL .= "        es_linecd = NULL , ";
		}
		$strSQL .= "        es_linecdname = '{$this->ensendat[0]["es_linecdname"]}' , ";
		$strSQL .= "        es_sta = '{$this->ensendat[0]["es_sta"]}' , ";
		if($this->ensendat[0]["es_stacd"] != ""){
			$strSQL .= "        es_stacd = {$this->ensendat[0]["es_stacd"]} , ";
		}else{
			$strSQL .= "        es_stacd = NULL , ";
		}
		if($this->ensendat[0]["es_walk"] != ""){
			$strSQL .= "        es_walk = {$this->ensendat[0]["es_walk"]} , ";
		}else{
			$strSQL .= "        es_walk = NULL , ";
		}
		if($this->ensendat[0]["es_bus"] != ""){
			$strSQL .= "        es_bus = {$this->ensendat[0]["es_bus"]} , ";
		}else{
			$strSQL .= "        es_bus = NULL , ";
		}
		$strSQL .= "        es_biko = '{$this->ensendat[0]["es_biko"]}' , ";
		if($this->ensendat[0]["es_adminid"] != ""){
			$strSQL .= "        es_adminid = {$this->ensendat[0]["es_adminid"]} , ";
		}else{
			$strSQL .= "        es_adminid = NULL , ";
		}
		$strSQL .= "        es_upddate = 'now' , ";
		$strSQL .= "        es_yobi1 = '{$this->ensendat[0]["es_yobi1"]}' , ";
		$strSQL .= "        es_yobi2 = '{$this->ensendat[0]["es_yobi2"]}' , ";
		$strSQL .= "        es_yobi3 = '{$this->ensendat[0]["es_yobi3"]}' , ";
		$strSQL .= "        es_yobi4 = '{$this->ensendat[0]["es_yobi4"]}' , ";
		$strSQL .= "        es_yobi5 = '{$this->ensendat[0]["es_yobi5"]}'";

		$strSQL .= "  WHERE es_id = {$this->ensendat[0]["es_id"]} ";
		$strSQL .= "    AND es_cd = {$this->ensendat[0]["es_cd"]} ";
	//echo "EnsenUpdSQL ... [".$strSQL."]<BR>";
		$result = @pg_exec( $this->conn , $strSQL );
		if ( !$result ){
			$this->php_error = "basedb_UpdEnsen(6):".pg_errormessage ($this->conn);
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		if ( pg_cmdtuples( $result ) != 1 ) {
			$this->php_error = "basedb_UpdEnsen(7):Update Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_UpdEnsen(8):".$this->php_error;
			return (-1);
		}
		return (0);
		
	}


	/*-----------------------------------------------------
	    ブログ基本情報 - 削除処理
	-----------------------------------------------------*/
	function basedb_DelEnsen ($mode) {
		
		$obj = new dbcom_DBcontroll;
		$obj->conn = $this->conn;
		
		//　トランザクション開始
		$ret = $obj->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			$this->php_error = "basedb_DelEnsen(1):".$obj->php_error;
			return (-1);
		}
		
		//  レコードロック
		$strSQL = "";
		$strSQL .= " SELECT * FROM t_ensen ";
		$strSQL .= "  WHERE es_id = {$this->ensendat[0]["es_id"]} ";
		$strSQL .= "    FOR UPDATE ";
		$result = @pg_exec ( $this->conn , $strSQL );
		if ( !$result ) {
			$this->php_error = "basedb_DelEnsen(2):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (-1);
		}
		//  該当データチェック
		$arr = @pg_fetch_array( $result , 0 );
		if ( $this->ensendat[0]["es_id"] != $arr["es_id"] ) {
			$this->php_error = "basedb_DelEnsen(3):".pg_errormessage ($this->conn);
			$ret = $obj->dbcom_DbRollback ();
			return (2);
		}
		@pg_free_result( $result );
		
		switch ($mode) {
			case 0:
				//  削除年月日セット
				$strSQL = "";
				$strSQL .= " UPDATE t_ensen ";
				$strSQL .= "    SET es_upd = 'now' ";
				$strSQL .= "  WHERE es_id = '{$this->ensendat[0]["es_id"]}' ";
				$strSQL .= "    AND es_clid = '{$this->ensendat[0]["es_clid"]}' ";
			//echo "EnsenDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelEnsen(4):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
			case 1:
				//  管理者情報削除
				$strSQL = "";
				$strSQL .= " DELETE FROM t_ensen ";
				$strSQL .= "  WHERE es_id = '{$this->ensendat[0]["es_id"]}'";
				$strSQL .= "    AND es_clid = '{$this->ensendat[0]["es_clid"]}' ";
			//echo "EnsenDelSQL ... [".$strSQL."]<BR>";
				$result = @pg_exec ( $this->conn , $strSQL );
				if ( !$result ) {
					$this->php_error = "basedb_DelEnsen(5):".pg_errormessage ($this->conn);
					$ret = $obj->dbcom_DbRollback ();
					return (-1);
				}
				break;
		}
		
		if ( pg_cmdtuples ( $result ) != 1 ) {
			$this->php_error = "basedb_DelEnsen(6):Delete Failed";
			$obj->dbcom_DbRollback ();
			return (-1);
		}
		@pg_free_result( $result );
		
		// トランザクション終了
		$ret = $obj->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->php_error = "basedb_DelEnsen(7):".$this->php_error;
			return (-1);
		}
		return (0);

	}

}
?>
