<?php
//================================================================================================================
//	汎用 DBIF クラス
//
//	2010/02/09	作成者:クリック 高木
//================================================================================================================
//修正履歴
//<001>	2010/04/19	大塚 匡平	data_customプロパティ追加 UPDATE/INSERT時にSQL直接入力可能
//<002>	2010/04/20	大塚 匡平	db_custom_sql_selectメソッド追加(SELECT用のSQL自由) db_custom_sqlメソッドをdb_custom_sql_changeに変更
//<003>	2010/05/17	高木 浩行	$this->php_error_sql の追加
//<004>	2010/06/09	高木 浩行	$this->diff_data の追加(UPDATE/DELETE時の更新時間等のチェック用)
//<005>	2010/10/21	高木 浩行	LIMIT OFFSET 値チェック の追加
//================================================================================================================

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------
db_select:SELECT処理
	$this->conn         :必須（DB接続ハンドラ）
	$this->table        :必須（テーブル名）
	$this->column       :任意（抽出カラム:初期値 * ）
	$this->jyoken       :任意（検索条件:WHERE句 $this->jyoken[カラム名][0]:演算子,$this->jyoken[カラム名][1]:値）between,in の場合は $this->jyoken[カラム名][1] = array
	                           使用可能演算子:=, !=, <, <=, >, >=, <>, like(LIKE), ilike(ILIKE), between(BETWEEN), in(IN), not in(NOT IN), is null(IS NULL), is not null(IS NOT NULL) 左記以外は $this->jyoken_custom を利用
	$this->jyoken_custom:任意（検索条件:WHERE句 直接入力）
	$this->sort         :任意（ソート条件:ORDER BY句 $this->sort[カラム名] = 'desc' または 'DESC' で降順 それ以外は昇順）
	$this->sort_custom  :任意（ソート条件:ORDER BY句 直接入力 設定時 $this->sort は無効 ）
	$this->distinct     :任意（DISTINCT設定:$this->distinct[]='カラム名' 【DISTINCT ON (column1,column2...) * ....】設定時 $this->sort は無効）
	$this->debug        :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug  :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->data         :自動（$this->data['カラム名']='データ'）
	$this->php_error    :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql:自動（エラーSQL:エラーとなったSQL）
	$this->transaction  :任意（トランザクション:初期値 自動）

db_insert:INSERT処理
	$this->conn         :必須（DB接続ハンドラ
	$this->table        :必須（テーブル名
	$this->serial       :任意（シリアルキー:INSERT実行後に $this->data['カラム名']にシリアルを格納
	$this->unique       :任意（ユニークキー:INSERT前にユニークカラムのデータチェックを行う,エラー時return(-2)）
	$this->debug        :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug  :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->data         :必須（INSERTデータ:$this->data['カラム名']='データ' NULL は $this->data['カラム名']=NULL とする）
	$this->data_custom  :任意（INSERTデータ:$this->data_custom['カラム名']=自由データ 関数や計算式等）	//<001>
	$this->php_error    :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql:自動（エラーSQL:エラーとなったSQL）
	$this->transaction  :任意（トランザクション:初期値 自動）

db_update:UPDATE処理
	$this->conn          :必須（DB接続ハンドラ）
	$this->table         :必須（テーブル名）
	$this->unique        :任意（ユニークキー:UPDATE前にユニークカラムのデータチェックを行う,エラー時return(-2),設定時 $this->tbl_key は必須 allは無効）
	$this->diff_data     :任意（更新前差分:$this->diff_data[カラム名]='データ' UPDATE前に現在データとの比較チェックを行う（更新時間など）,エラー時return(-3) $this->tbl_rows が1の場合のみ有効）
	$this->tbl_key       :必須（UPDATE条件:WHERE句 $this->tbl_key［'カラム名']='データ' 設定しない場合は $this->tbl_key['all'] = 'all' を指定）
	$this->tbl_key_custom:任意（UPDATE条件:WHERE句 直接入力）
	$this->tbl_rows      :必須（変更予定レコード数:変更数チェックを行わない場合 $this->tbl_rows = 'all' を指定)
	$this->debug         :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug   :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->data          :必須（UPDATEデータ:$this->data['カラム名']='データ' NULL は $this->data['カラム名']=NULL とする）
	$this->data_custom   :任意（UPDATEデータ:$this->data_custom['カラム名']=自由データ 関数や計算式等）	//<001>
	$this->php_error     :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql :自動（エラーSQL:エラーとなったSQL）
	$this->transaction   :任意（トランザクション:初期値 自動）

db_diff_import:差分（INSERT/UPDATE）処理
	$this->conn          :必須（DB接続ハンドラ）
	$this->table         :必須（テーブル名）
	$this->unique        :任意（ユニークキー:INSERT/UPDATE前にユニークカラムのデータチェックを行う,エラー時return(-2),設定時 $this->tbl_key は必須 allは無効）
	$this->tbl_key       :必須（差分条件:WHERE句 $this->tbl_key［'カラム名']='データ' ）
	$this->debug         :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug   :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->data          :必須（INSERT/UPDATEデータ:$this->data['カラム名']='データ' NULL は $this->data['カラム名']=NULL とする）
	$this->php_error     :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql :自動（エラーSQL:エラーとなったSQL）
	$this->transaction   :任意（トランザクション:初期値 自動）

db_batch_diff_import:一括差分（INSERT/UPDATE）処理
	$this->conn          :必須（DB接続ハンドラ）
	$this->table         :必須（テーブル名）
	$this->tbl_key       :必須（差分条件:WHERE句 $this->tbl_key［'カラム名']='データ' ）
	$this->debug         :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug   :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->data          :必須（INSERT/UPDATEデータ:$this->data[]['カラム名']='データ' NULL は $this->data[]['カラム名']=NULL とする）
	$this->php_error     :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql :自動（エラーSQL:エラーとなったSQL）
	$this->transaction   :設定不可（トランザクション:自動のみ）

db_delete:削除処理（物理削除のみ）
	$this->conn          :必須（DB接続ハンドラ）
	$this->table         :必須（テーブル名）
	$this->diff_data     :任意（削除前差分:$this->diff_data[カラム名]='データ' DELETE前に現在データとの比較チェックを行う（更新時間など）,エラー時return(-3) $this->tbl_rows が1の場合のみ有効）
	$this->tbl_key       :必須（DELETE条件:WHERE句 $this->tbl_key［'カラム名']='データ'全件削除時は $this->tbl_key['all'] = 'all' を指定））
	$this->tbl_rows      :必須（変更予定レコード数:変更数チェックを行わない場合 $this->tbl_rows = 'all' を指定)
	$this->debug         :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug   :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->php_error     :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql :自動（エラーSQL:エラーとなったSQL）
	$this->transaction   :任意（トランザクション:初期値 自動 ）

db_vacuum:バキューム処理
	$this->conn          :必須（DB接続ハンドラ）
	$this->table         :必須（テーブル名）
	$this->debug         :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug   :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->php_error     :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql :自動（エラーSQL:エラーとなったSQL）
	$this->transaction   :設定不可

db_cluster:クラスタ処理
	$this->conn          :必須（DB接続ハンドラ）
	$this->table         :必須（テーブル名）
	$this->index         :必須（CLUSTER条件:INDEX名 $this->index='インデックス名' ）
	$this->debug         :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug   :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->php_error     :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql :自動（エラーSQL:エラーとなったSQL）
	$this->transaction   :設定不可

db_custom_sql_change:自由SQL実行(行変更を伴う)
	$this->conn          :必須（DB接続ハンドラ）
	$this->tbl_rows      :必須（変更予定レコード数:変更数チェックを行わない場合 $this->tbl_rows = 'all' を指定)
	$this->sql           :必須（実行SQL）
	$this->debug         :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug   :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->php_error     :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql :自動（エラーSQL:エラーとなったSQL）
	$this->transaction   :設定不可（トランザクション:手動のみ）

//<002>
db_custom_sql_select:自由SQL実行(SELECT)
	$this->conn          :必須（DB接続ハンドラ）
	$this->sql           :必須（実行SQL）
	$this->debug         :任意（デバッグフラグ:TRUE時 実行SQL,エラーメッセージを出力）
	$this->error_debug   :任意（デバッグフラグ:TRUE時 エラー発生時に 実行SQL,エラーメッセージを出力）
	$this->data          :自動（$this->data['カラム名']='データ'）
	$this->php_error     :自動（処理エラーメッセージ:SQLエラー,値定義エラー等）
	$this->php_error_sql :自動（エラーSQL:エラーとなったSQL）
	$this->transaction   :設定不可（トランザクション:手動のみ）


※トランザクション手動時は、以下メソッドでトランザクションをコントロール
dbcom_DbBeginTran:BEGIN
dbcom_DbCommit    :COMMIT
dbcom_DbRollback  :ROLLBACK
-----------------------------------------------------------------------------------------------------------------------------------------------------------------*/

require_once( SYS_PATH . '/dbif/dbcom_DBcntlClass.php' );

class basedb_sql_class extends dbcom_DBcontroll {

	//================================================================================================================
	//	メンバー変数定義
	//================================================================================================================
	var $conn;
	var $table;
	var $index;
	var $serial;
	var $unique;
	var $tbl_key;
	var $tbl_key_custom;
	var $tbl_rows;
	var $column;
	var $jyoken;
	var $jyoken_custom;
	var $sort;
	var $sort_custom;
	var $distinct;
	var $sql;
	var $debug;
	var $error_debug;
	var $php_error;
	var $php_error_sql;	//<003>
	var $data;
	var $data_custom;	//<001>
	
	var $transaction;

	//================================================================================================================
	//	コンストラクタ（オブジェクト生成時に呼ばれる初期化処理）
	//================================================================================================================
	function __construct(){
	//function basedb_sql_class() {  // ←php4の場合、こう書かなければダメ
		if( defined('DB_CONN') ){
			$this->conn       = DB_CONN; // DB接続ID
		}else{
			$this->conn       = NULL;    // DB接続ID
		}
		$this->table          = NULL;    // テーブル名
		$this->index          = NULL;    // インデックス
		$this->serial         = NULL;    // シリアル
		$this->unique         = array(); // ユニークキー
		$this->tbl_key        = array(); // キー
		$this->tbl_key_custom = NULL;    // キー
		$this->tbl_rows       = NULL;    // 変更予定レコード数
		$this->column         = '*';     // 抽出カラム
		$this->jyoken         = array(); // 検索条件
		$this->jyoken_custom  = NULL;    // 検索条件(直接入力)
		$this->sort           = array(); // ソート条件
		$this->sort_custom    = NULL;    // ソート条件（直接入力）
		$this->distinct       = array(); // DISTINCT設定
		$this->sql            = NULL;    // SQL（直接入力）
		$this->debug          = NULL;    // デバッグフラグ
		$this->error_debug    = NULL;    // デバッグフラグ（エラー発生時のみ出力）
		$this->php_error      = NULL;    // 処理エラーメッセージ
		$this->php_error_sql  = NULL;    // エラーSQL	//<003>
		$this->data           = array(); // 検索結果,INSERT/UPDATE値
		$this->data_custom    = array(); // INSERT/UPDATE値(直接入力)	//<001>
		
		$this->transaction    = NULL;    // トランザクション SELF:手動
	}


	//================================================================================================================
	//	デストラクタ（オブジェクトが破棄時に呼ばれる処理）
	//================================================================================================================
	function __destruct(){  // ←php5のみ
	}


	//================================================================================================================
	//    Set Value Method
	//================================================================================================================
	function set_conn( $value ){
		$this->conn = $value;
	}
	function set_table( $value ){
		$this->table = $value;
	}
	function set_sql( $value ){
		$this->sql = $value;
	}
	function set_index( $value ){
		$this->index = $value;
	}
	function set_serial( $value ){
		$this->serial = $value;
	}
	function set_unique( $value ){
		$this->unique = $value;
	}
	//<004>
	function set_diff_data( $value ){
		$this->diff_data = $value;
	}
	function set_tbl_key( $value ){
		$this->tbl_key = $value;
	}
	function set_tbl_key_custom( $value ){
		$this->tbl_key_custom = $value;
	}
	function set_tbl_rows( $value ){
		$this->tbl_rows = $value;
	}
	function set_column( $value ){
		$this->column = $value;
	}
	function set_jyoken( $value ){
		$this->jyoken = $value;
	}
	function set_jyoken_custom( $value ){
		$this->jyoken_custom = $value;
	}
	function set_sort( $value ){
		$this->sort = $value;
	}
	function set_sort_custom( $value ){
		$this->sort_custom = $value;
	}
	function set_distinct( $value ){
		$this->distinct = $value;
	}
	function set_debug( $value ){
		$this->debug = $value;
	}
	function set_error_debug( $value ){
		$this->error_debug = $value;
	}
	function set_data( $value ){
		$this->data = $value;
	}
	//<001>
	function set_data_custom( $value ){
		$this->data_custom = $value;
	}
	function set_transaction( $value ){
		$this->transaction = $value;
	}


	//================================================================================================================
	//    Initialize Value Method
	//================================================================================================================
	function init(){
		$this->table          = NULL;    // テーブル名
		$this->sql            = NULL;    // SQL
		$this->index          = NULL;    // インデックス
		$this->serial         = NULL;    // シリアル
		$this->unique         = array(); // ユニークキー
		$this->tbl_key        = array(); // キー
		$this->tbl_key_custom = NULL;    // キー
		$this->tbl_rows       = NULL;    // 変更予定レコード数
		$this->column         = '*';     // 抽出カラム
		$this->jyoken         = array(); // 検索条件
		$this->jyoken_custom  = NULL;    // 検索条件(直接入力)
		$this->sort           = array(); // ソート条件
		$this->sort_custom    = NULL;    // ソート条件(直接入力)
		$this->distinct       = array(); // DISTINCT設定
		$this->php_error      = NULL;    // 処理エラーメッセージ
		$this->php_error_sql  = NULL;    // エラーSQL	//<003>
		$this->data           = array(); // 検索結果,INSERT/UPDATE値
		$this->data_custom    = array(); // INSERT/UPDATE値(直接入力)	//<001>
	}

	//================================================================================================================
	//    Select Method
	//================================================================================================================
	function db_select( $limit='', $offset='' ) {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return array(x,y)
	//         x >= 0:正常  x = -1:DBエラー
	//         y:全件数
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//DB接続ID確認
		if( $this->conn == '' ){
			$this->php_error = 'db_select(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return array(-1,NULL);
		}
		
		//テーブル設定確認
		if( $this->table == '' ){
			$this->php_error = 'db_select(1):Table Name is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return array(-1,NULL);
		}
		
		// トランザクション開始
		if( $this->transaction != 'SELF' ){
			$ret = $this->dbcom_DbBeginTran();
			if ( $ret == -1 ) {
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE  ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return array (-1,NULL);
			}
		}
		
		//ベースSQL生成
		$sql = '';
		$sql .= ' SELECT ' . "\n";
		
		//DISTINCT設定
		if ( is_array( $this->distinct ) && count( $this->distinct ) != 0 ){
			$sql_tmp = '';
			$sql .= '        DISTINCT ON ( ';
			foreach( $this->distinct as $key => $column ){
				if( $sql_tmp != '' ){
					$sql_tmp .= ' , ';
				}
				$sql_tmp .= $column;
			}
			$sql .= $sql_tmp;
			$sql .= ' ) ' . $this->column . " \n";
		}else{
			$sql .= '        ' . $this->column . " \n";
		}
		
		$sql .= '   FROM ' . "\n";
		$sql .= '        ' . $this->table . " \n";
		
		
		// WHERE句設定
		$sql_where = '';
		if( is_array( $this->jyoken ) && count( $this->jyoken ) > 0  ){
			foreach( $this->jyoken as $column => $val ){
				if( $sql_where != '' ){
						$sql_where .= '    AND ';
				}else{
						$sql_where .= '  WHERE ' . "\n";
						$sql_where .= '        ';
				}
				switch( $this->jyoken[$column][0] ){
					case '='  :
					case '!=' :
					case '<'  :
					case '>'  :
					case '<=' :
					case '>=' :
					case '<>' :
						$sql_where .= $column . ' ' . $this->jyoken[$column][0] . " '" . $this->jyoken[$column][1] . "' \n";
						break;
					case 'like' :
					case 'LIKE' :
						$sql_where .= $column . " LIKE '%" . $this->jyoken[$column][1] . "%' \n";
						break;
					case 'ilike' :
					case 'ILIKE' :
						$sql_where .= $column . " ILIKE '%" . $this->jyoken[$column][1] . "%' \n";
						break;
					case 'is null' :
					case 'IS NULL' :
						$sql_where .= $column . ' IS NULL ' . "\n";
						break;
					case 'is not null' :
					case 'IS NOT NULL' :
						$sql_where .= $column . ' IS NOT NULL ' . "\n";
						break;
					case 'between' :
					case 'BETWEEN' :
						$sql_where .= $column . " BETWEEN '" . $this->jyoken[$column][1][0] . "' AND '" . $this->jyoken[$column][1][1] . "' \n";
						break;
					case 'in' :
					case 'IN' :
						$sql_where .= $column . ' IN ( ';
						if( is_array( $this->jyoken[$column][1] ) && count( $this->jyoken[$column][1] ) > 0 ){
							foreach( $this->jyoken[$column][1] as $cnt => $val ){
								$buf_value[] = "'" . $val . "'" ;
							}
						}
						$sql_where .= implode( ', ', $buf_value );
						$sql_where .= ' ) ' . "\n";
						
						break;
					case 'not in' :
					case 'NOT IN' :
						$sql_where .= $column . 'NOT IN ( ';
						if( is_array( $this->jyoken[$column][1] ) && count( $this->jyoken[$column][1] ) > 0 ){
							foreach( $this->jyoken[$column][1] as $cnt => $val ){
								$buf_value[] = "'" . $val . "'" ;
							}
						}
						$sql_where .= implode( ', ', $buf_value );
						$sql_where .= ' ) ' . "\n";
						
						break;
					default :
						$this->php_error = 'db_select(2):jyoken Error Operator is not correct';
						$this->php_error_sql = $sql;	//<003>
						//DEBUG時エラー出力
						if( $this->debug == TRUE || $this->error_debug == TRUE  ){
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						return array (-1,NULL);
						break;
				}
			}
		}
		
		// WHERE句設定（直接入力）
		if( isset( $this->jyoken_custom ) && $this->jyoken_custom != '' ){
			if( $sql_where != '' ){
					$sql_where .= '    AND ';
			}else{
					$sql_where .= '  WHERE ' . "\n";
					$sql_where .= '        ';
			}
			$sql_where .= $this->jyoken_custom . " \n";
		}
		
		// ORDER BY句設定
		$sql_order = '';
		if( is_array( $this->sort ) && count( $this->sort ) ){
			$sql_order .= ' ORDER BY  ' . "\n";
			$cnt = 1;
			foreach( $this->sort as $column => $sort ){
				//最初以外は、カンマを頭に付ける
				if( $cnt == 1 ){
					if( $sort == 'DESC' || $sort == 'desc' ){
						$sql_order .= '        ' . $column . ' DESC ' . "\n";
					}else{
						$sql_order .= '        ' . $column . ' ASC ' . "\n";
					}
				}else{
					if( $sort == 'DESC' || $sort == 'desc' ){
						$sql_order .= '       ,' . $column . ' DESC ' . "\n";
					}else{
						$sql_order .= '       ,' . $column . ' ASC ' . "\n";
					}
				}
				$cnt++;
			}
		}
		
		// ORDER BY句設定（DISTINCT設定時）
		if ( is_array( $this->distinct ) && count( $this->distinct ) != 0 ){
			//初期化する
			$sql_order = '';
			$sql_order .= ' ORDER BY ' . "\n";
			$cnt = 1;
			foreach( $this->distinct as $key => $column ){
				//最初以外は、カンマを頭に付ける
				if( $cnt == 1 ){
					$sql_order .= '        ' . $column . " \n";
				}else{
					$sql_order .= '       ,' . $column . " \n";
				}
				$cnt++;
			}
		}
		
		// ORDER BY句設定（直接入力）通常と同時に設定されていた場合 直接入力が優先される
		if( isset( $this->sort_custom ) && $this->sort_custom != '' ){
			//初期化する
			$sql_order = '';
			$sql_order .= ' ORDER BY ' . "\n";
			$sql_order .= '        ' . $this->sort_custom . " \n";
		}

		//WHERE句追加
		$sql .= $sql_where;
		
		//ORDER BY句追加
		$sql .= $sql_order;
		
		//LIMIT、OFFSET利用
		if( $limit != '' ){
			if( !is_numeric( $limit ) ){	//<005>
				$this->php_error = 'db_select(3):LIMIT is not an integer value';
				$this->php_error_sql = $sql;	//<003>
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE  ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return array (-1,NULL);
			}
			$sql .= " LIMIT '" . intval( $limit ) . "' ";
		}
		if( $offset != '' ){
			if( !is_numeric( $offset ) ){	//<005>
				$this->php_error = 'db_select(3):OFFSET is not an numeric value';
				$this->php_error_sql = $sql;	//<003>
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE  ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return array (-1,NULL);
			}
			if( $offset > 0 ){
				$offset = intval( $offset ) -1;
			}else{
				$offset = 0;
			}
			$sql .= " OFFSET '" . $offset . "' \n";
		}
		
		//DEBUG時SQL出力
		if( $this->debug == TRUE ){
			echo '<pre>' . $this->table . ' SELECT SQL ... [<br>' . $sql . ']</pre><br>';
		}
		
		//SQL実行
		$result = @pg_query( $this->conn , $sql );
		if ( !$result ) {
			$this->php_error = 'db_select(4):' . pg_last_error( $this->conn );
			$this->php_error_sql = $sql;	//<003>
			if( $this->transaction != 'SELF' ){
				$this->dbcom_DbRollback ();
			}
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' SELECT SQL ... [<br>' . $sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return array (-1,NULL);
		}
		
		//変更レコード数の取得
		if ( pg_affected_rows( $result ) > 0 ) {
			$this->php_error = 'db_select(5):pg_affected_rows ERROR!!!';
			$this->php_error_sql = $sql;	//<003>
			if( $this->transaction != 'SELF' ){
				$this->dbcom_DbRollback ();
			}
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' SELECT SQL ... [<br>' . $sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return array (-1,NULL);
		}
		
		//レコード数取得
		$numrows = pg_num_rows( $result );
		$cnt = 0;
		
		//レコード行を配列として取得する（カラム名での連想配列）
		for ( $curpos=0; $curpos < $numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos, PGSQL_ASSOC );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->data[$curpos][$key] = $val;
			}
			$cnt++;
		}
		
		//リソースの解放
		pg_free_result( $result );
		
		//LIMIT が設定されている場合は全件数取得
		if( $limit != '' ){
			// 全件数取得
			$sql = '';
			$sql .= ' SELECT ' . "\n";
			$sql .= '        count( * ) ' . "\n";
			$sql .= '   FROM ' . $this->table . " \n";
			$sql .= $sql_where;
			
			//DEBUG時SQL出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->table . ' SELECT TOTAL SQL ... [<br>' . $sql . ']</pre><br>';
			}
			
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_select(6):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' SELECT TOTAL SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return array (-1,NULL);
			}
			
			//変更レコード数の取得
			if ( pg_affected_rows ( $result ) > 0 ) {
				$this->php_error = 'db_select(7):pg_affected_rows ERROR!!!';
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' SELECT TOTAL SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return array (-1,NULL);
			}
			
			//件数取得
			$total = pg_fetch_result( $result , 0 , 'count' );
			
			//リソースの解放
			pg_free_result( $result );
		}else{
			$total = $cnt;
		}
		
		//トランザクションコミット
		if( $this->transaction != 'SELF' ){
			$ret = $this->dbcom_DbCommit ();
			IF( $ret == -1 ){
				$this->dbcom_DbRollback ();
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return array (-1,NULL);
			}
		}
		
		return array( $cnt , $total );
		
	}
	
	
	//================================================================================================================
	//    Insert Method
	//================================================================================================================
	function db_insert() {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return x
	//         x = 0:正常  x = -1:DBエラー  x = -2:ユニークエラー
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//DB接続ID確認
		if( $this->conn == '' ){
			$this->php_error = 'db_insert(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//テーブル設定確認
		if( $this->table == '' ){
			$this->php_error = 'db_insert(1):Table Name is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//トランザクション開始
		if( $this->transaction != 'SELF' ){
			$ret = $this->dbcom_DbBeginTran ();
			if ( $ret == -1 ) {
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
		}
		
		//テーブルロック
		$sql = '';
		$sql .= " LOCK TABLE \n";
		$sql .= '            ' . $this->table . " \n";
		$sql .= " IN exclusive mode \n";
		//DEBUG時SQL出力
		if( $this->debug == TRUE ){
			echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
		}
		//SQL実行
		$result = @pg_query( $this->conn , $sql );
		if ( !$result ) {
			$this->php_error = 'db_insert(3):' . pg_last_error( $this->conn );
			$this->php_error_sql = $sql;	//<003>
			if( $this->transaction != 'SELF' ){
				$this->dbcom_DbRollback ();
			}
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		//リソース解放
		pg_free_result( $result );
		
		//ユニークキーチェック
		if( is_array( $this->unique ) && count( $this->unique ) ){
			//ベースSQL生成
			$sql = '';
			$sql .= ' SELECT ' . "\n";
			$sql .= '        count(*) ' . "\n";
			$sql .= '   FROM ' . "\n";
			$sql .= '        ' . $this->table . " \n";
			//WHERE句設定
			$sql_where = '';
			//ユニークキーを条件に設定
			foreach( $this->unique as $column => $val ){
				//WHERE ～ ANDの挿入
				if( $sql_where != '' ){
						$sql_where .= '    AND ';
				}else{
						$sql_where .= '  WHERE ' . "\n";
						$sql_where .= '        ';
				}
				$sql_where .= $column . " = '" . $val . "' \n";
			}
			$sql .= $sql_where;
			//DEBUG時SQL出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
			}
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_insert(4):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
			
			//変更レコード数の取得
			if ( pg_affected_rows ( $result ) > 0 ) {
				$this->php_error = 'db_insert(5):pg_affected_rows ERROR!!!';
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
		
			//件数取得
			$count = pg_fetch_result( $result , 0 , 'count' );
			
			if( $count > 0 ){
				$this->php_error = 'db_insert(6):Unique ERROR!!!';
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-2);
			}
			
			//リソースの解放
			pg_free_result( $result );
		}


		///////////////////////////////////////////////////////////
		// INSERT SQL発行
		///////////////////////////////////////////////////////////
		
			//INSERT文作成
			$sql = '';
			$sql .= ' INSERT INTO ' . $this->table . "\n";
			$sql .= '           ( ' . "\n";
			
			//INSERT カラム設定
			$cnt = 1;
			foreach( $this->data as $column => $val){
				//最初以外は、カンマを頭に付ける
				if( $cnt == 1  ){
					$sql .= '             ' . $column ." \n";
				}else{
					$sql .= '            ,' . $column ." \n";
				}
				$cnt++;
			}
			foreach( $this->data_custom as $column => $val){	//<001>
				//最初以外は、カンマを頭に付ける
				if( $cnt == 1  ){
					$sql .= '             ' . $column ." \n";
				}else{
					$sql .= '            ,' . $column ." \n";
				}
				$cnt++;
			}
			
			$sql .= '           ) ' . "\n";
			$sql .= '      VALUES ' . "\n";
			$sql .= '           ( ' . "\n";
			
			//INSERT データ設定
			$cnt = 1;
			foreach( $this->data as $column => $val){
				//最初以外は、カンマを頭に付ける
				if( $cnt == 1  ){
					if( is_null( $val ) ){
						$sql .= '              NULL ' . "\n";
					}else{
						$sql .= "              '" . $val ."' \n";
					}
				}else{
					if( is_null( $val ) ){
						$sql .= '              ,NULL ' . "\n";
					}else{
						$sql .= "              ,'" . $val ."' \n";
					}
				}
				$cnt++;
			}
			foreach( $this->data_custom as $column => $val){	//<001>
				//最初以外は、カンマを頭に付ける
				if( $cnt == 1  ){
					if( is_null( $val ) ){
						$sql .= '              NULL ' . "\n";
					}else{
						$sql .= "              " . $val ." \n";
					}
				}else{
					if( is_null( $val ) ){
						$sql .= '             ,NULL ' . "\n";
					}else{
						$sql .= "             ," . $val ." \n";
					}
				}
				$cnt++;
			}
			
			$sql .= '           ) ' . "\n";
			
			
			//DEBUG時SQL出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->table . ' INSERT SQL ... [<br>' . $sql . ']</pre><br>';
			}
			
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_insert(7):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' INSERT SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
			
			//変更レコード数の取得
			if ( pg_affected_rows( $result ) != 1 ) {
				$this->php_error = 'db_insert(8):pg_affected_rows ERROR!!!';
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' INSERT SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
			
			// シリアルの取得
			if( $this->serial != '' ){
				$sql = " SELECT currval('" . $this->table . '_' . $this->serial . '_' .  "seq')";
				//DEBUG時SQL出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->table . ' SELECT SQUENCE SQL ... [<br>' . $sql . ']</pre><br>';
				}
				//SQL実行
				$result = @pg_query( $this->conn , $sql );
				if ( !$result ) {
					$this->php_error = 'db_insert(9):' . pg_last_error( $this->conn );
					$this->php_error_sql = $sql;	//<003>
					if( $this->transaction != 'SELF' ){
						$this->dbcom_DbRollback ();
					}
					//DEBUG時エラー出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					//ERROR_DEBUG時 SQL,エラー出力
					if( $this->error_debug == TRUE ){
						echo '<pre>' . $this->table . ' SELECT SQUENCE SQL ... [<br>' . $sql . ']</pre><br>';
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
				$this->data[$this->serial] = pg_fetch_result( $result , 0 , 'currval' );
				@pg_free_result( $result );
			}
			
			//トランザクションコミット
			if( $this->transaction != 'SELF' ){
				$ret = $this->dbcom_DbCommit ();
				IF( $ret == -1 ){
					$this->dbcom_DbRollback ();
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
			}
			
		return 0;
		
	}

	//================================================================================================================
	//    Update Method
	//================================================================================================================
	function db_update() {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return x
	//         x = 0:正常  x = -1:DBエラー  x = -2:ユニークエラー x = -3:更新差分エラー
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		//DB接続ID確認
		if( $this->conn == '' ){
			$this->php_error = 'db_update(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//テーブル設定確認
		if( $this->table == '' ){
			$this->php_error = 'db_update(1):Table Name is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//キー設定確認
		if( is_array( $this->tbl_key ) && count( $this->tbl_key ) > 0 ){
			foreach( $this->tbl_key as $key => $column ){
				if( $column == '' ){
					$this->php_error = 'db_update(2):tbl_key Column Name is NULL';
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
			}
		}else{
			$this->php_error = 'db_update(2):tbl_key Setting is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}

		//変更予定数確認
		if( $this->tbl_rows == '' ){
			$this->php_error = 'db_update(3):tbl_rows Setting is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}

		//トランザクション開始
		if( $this->transaction != 'SELF' ){
			$ret = $this->dbcom_DbBeginTran ();
			if ( $ret == -1 ) {
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
		}
		
		//  レコードロック
		$sql = '';
		$sql .= ' SELECT ' . "\n";
		$sql .= '        * ' . "\n";
		$sql .= '   FROM ' . "\n";
		$sql .= '        ' . $this->table . " \n";
		//UPDATE WHERE句設定
		$sql_where = '';
		//キーを条件に設定（ $this->tbl_key['all'] == all の場合はWHERE句を発行しない）
		if( $this->tbl_key['all'] != 'all' ){
			foreach( $this->tbl_key as $column => $val ){
				//WHERE ～ ANDの挿入
				if( $sql_where != '' ){
						$sql_where .= '    AND ';
				}else{
						$sql_where .= '  WHERE ' . "\n";
						$sql_where .= '        ';
				}
				$sql_where .= $column . " = '" . $val . "' \n";
			}
		}
		//UPDATE WHERE句設定（直接入力）
		if( isset( $this->tbl_key_custom ) && $this->tbl_key_custom != '' ){
			if( $sql_where != '' ){
					$sql_where .= '    AND ';
			}else{
					$sql_where .= '  WHERE ' . "\n";
					$sql_where .= '        ';
			}
			$sql_where .= $this->tbl_key_custom ." \n";
		}
		$sql .= $sql_where;

		$sql .= ' FOR UPDATE ' . "\n";
		
		//DEBUG時SQL出力
		if( $this->debug == TRUE ){
			echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
		}
		//SQL実行
		$result = @pg_query( $this->conn , $sql );
		if ( !$result ) {
			$this->php_error = 'db_update(4):' . pg_last_error( $this->conn );
			$this->php_error_sql = $sql;	//<003>
			if( $this->transaction != 'SELF' ){
				$this->dbcom_DbRollback ();
			}
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//更新前のデータと現在データの比較（変更レコード数が1の場合のみ）	//<004>
		if( $this->tbl_rows == 1 && is_array( $this->diff_data ) && count( $this->diff_data ) ){
			foreach( $this->diff_data as $column => $value ){
				//現在データ
				$now_data = pg_fetch_result( $result , 0 , $column );
				//一致しない場合エラー
				if( $now_data != $value ){
					$this->php_error = 'db_update(5):DIFF CHECK ERROR!!! before_data(' . $column . ') = ' . $value . ' now_data = ' . $now_data;
					$this->php_error_sql = $sql;	//<003>
					if( $this->transaction != 'SELF' ){
						$this->dbcom_DbRollback ();
					}
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-3);
				}
			}
		}
		//リソース解放
		pg_free_result( $result );
		
		
		//ユニークキーチェック
		if( is_array( $this->unique ) && count( $this->unique ) ){
			//ベースSQL生成
			$sql = '';
			$sql .= ' SELECT ' . "\n";
			$sql .= '        count(*) ' . "\n";
			$sql .= '   FROM ' . "\n";
			$sql .= '        ' . $this->table . " \n";
			//WHERE句設定
			$sql_where = '';
			//ユニークキーを条件に設定
			foreach( $this->unique as $column => $val ){
				//WHERE ～ ANDの挿入
				if( $sql_where != '' ){
						$sql_where .= '    AND ';
				}else{
						$sql_where .= '  WHERE ' . "\n";
						$sql_where .= '        ';
				}
				$sql_where .= $column . " = '" . $val . "' \n";
			}
			//キーから対象データを検索対象外に設定
			if( $this->tbl_key['all'] != 'all' && count( $this->tbl_key ) > 0 ){
				foreach( $this->tbl_key as $column => $val ){
					//WHERE ～ ANDの挿入
					if( $sql_where != '' ){
							$sql_where .= '    AND ';
					}else{
							$sql_where .= '  WHERE ' . "\n";
							$sql_where .= '        ';
					}
					$sql_where .= $column . " <> '" . $val . "' \n";
				}
			}
			$sql .= $sql_where;
			
			//DEBUG時SQL出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
			}
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_update(6):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
			
			//変更レコード数の取得
			if ( pg_affected_rows ( $result ) > 0 ) {
				$this->php_error = 'db_update(7):pg_affected_rows ERROR!!!';
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
		
			//件数取得
			$count = pg_fetch_result( $result , 0 , 'count' );
			
			if( $count > 0 ){
				$this->php_error = 'db_update(8):UNIQUE ERROR!!!';
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-2);
			}
			
			//リソースの解放
			pg_free_result( $result );
		}
		
		///////////////////////////////////////////////////////////
		// UPDATE SQL発行
		///////////////////////////////////////////////////////////
		
			//UPDATE文作成
			$sql = '';
			$sql .= ' UPDATE ' . $this->table . "\n";
			$sql .= '    SET ' . "\n";
			
			//UPDATE カラム設定
			$cnt = 1;
			foreach( $this->data as $column => $val){
				//最初以外は、カンマを頭に付ける
				if( $cnt == 1  ){
					if( is_null( $val ) ){
						$sql .= '        ' . $column . ' = NULL ' . "\n";
					}else{
						$sql .= '        ' . $column . " = '" . $val . "' \n";
					}
				}else{
					if( is_null( $val ) ){
						$sql .= '       ,' . $column . ' = NULL ' . "\n";
					}else{
						$sql .= '       ,' . $column . " = '" . $val . "' \n";
					}
				}
				$cnt++;
			}
			foreach( $this->data_custom as $column => $val){	//<001>
				//最初以外は、カンマを頭に付ける
				if( $cnt == 1  ){
					if( is_null( $val ) ){
						$sql .= '        ' . $column . ' = NULL ' . "\n";
					}else{
						$sql .= '        ' . $column . " = " . $val . " \n";
					}
				}else{
					if( is_null( $val ) ){
						$sql .= '       ,' . $column . ' = NULL ' . "\n";
					}else{
						$sql .= '       ,' . $column . " = " . $val . " \n";
					}
				}
				$cnt++;
			}
			
			//UPDATE WHERE句設定
			$sql_where = '';
			//キーを条件に設定（ $this->tbl_key['all'] == all の場合はWHERE句を発行しない）
			if( $this->tbl_key['all'] != 'all' ){
				foreach( $this->tbl_key as $column => $val ){
					//WHERE ～ ANDの挿入
					if( $sql_where != '' ){
							$sql_where .= '    AND ';
					}else{
							$sql_where .= '  WHERE ' . "\n";
							$sql_where .= '        ';
					}
					$sql_where .= $column . " = '" . $val  . "' \n";
				}
			}
			//UPDATE WHERE句設定（直接入力）
			if( isset( $this->tbl_key_custom ) && $this->tbl_key_custom != '' ){
				if( $sql_where != '' ){
						$sql_where .= '    AND ';
				}else{
						$sql_where .= '  WHERE ' . "\n";
						$sql_where .= '        ';
				}
				$sql_where .= $this->tbl_key_custom . " \n";
			}
			$sql .= $sql_where;
			
			//DEBUG時SQL出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->table . ' UPDATE SQL ... [<br>' . $sql . ']</pre><br>';
			}
			
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_update(9):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' UPDATE SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
			
			//変更レコード数の取得
			if( $this->tbl_rows != 'all' ){
				if ( pg_affected_rows( $result ) != $this->tbl_rows ) {
					$this->php_error = 'db_update(10):pg_affected_rows ERROR!!! tbl_rows = ' . $this->tbl_rows . '/ affected_rows = ' . pg_affected_rows( $result );
					$this->php_error_sql = $sql;	//<003>
					if( $this->transaction != 'SELF' ){
						$this->dbcom_DbRollback ();
					}
				//DEBUG時エラー出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' UPDATE SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
					return (-1);
				}
			}
			
			//トランザクションコミット
			if( $this->transaction != 'SELF' ){
				$ret = $this->dbcom_DbCommit ();
				IF( $ret == -1 ){
					$this->dbcom_DbRollback ();
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
			}
			
			//リソースの解放
			pg_free_result( $result );
			
 		return 0;
		
	}
	

	//================================================================================================================
	//    差分 Import Method
	//================================================================================================================
	function db_diff_import() {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return x
	//         x = 0:正常  x = -1:DBエラー  x = -2:ユニークエラー
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//DB接続ID確認
		if( $this->conn == '' ){
			$this->php_error = 'db_diff_import(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//テーブル設定確認
		if( $this->table == '' ){
			$this->php_error = 'db_diff_import(1):Table Name is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//キー設定確認
		if( is_array( $this->tbl_key ) && count( $this->tbl_key ) > 0 ){
			foreach( $this->tbl_key as $key => $column ){
				if( $column == '' ){
					$this->php_error = 'db_diff_import(2):tbl_key Column Name is NULL';
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
			}
		}else{
			$this->php_error = 'db_diff_import(2):tbl_key Setting is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}

		//トランザクション開始
		if( $this->transaction != 'SELF' ){
			$ret = $this->dbcom_DbBeginTran ();
			if ( $ret == -1 ) {
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
		}
		
		//////////////////////////
		// 差分インポート処理
		//////////////////////////
		
			// 既存レコードチェック
			$sql = '';
			$sql .= ' SELECT ' . "\n";
			$sql .= '        count( * ) ' . "\n";
			$sql .= '   FROM ' . $this->table . "\n";
			//WHERE句設定
			$sql_where = '';
			//キーを条件に設定
			foreach( $this->tbl_key as $column => $val ){
				//WHERE ～ ANDの挿入
				if( $sql_where != '' ){
						$sql_where .= '    AND ';
				}else{
						$sql_where .= '  WHERE ' . "\n";
						$sql_where .= '        ';
				}
				$sql_where .= $column . " = '" . $val  . "' \n";
			}
			$sql .= $sql_where;
			
			//DEBUG時SQL出力
			if( $this->debug == true ){
				echo '<hr><pre>' . $this->table . ' CHECK SQL ... [<br>' . $sql . ']</pre><br>';
			}
			
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_diff_import(3):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' CHECK SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return  (-1);
			}
			
			//件数取得
			$recode_cnt = pg_fetch_result( $result , 0 , 'count' );
			
			//リソース解放
			@pg_free_result( $result );
			
			///////////////////////////////////////////////////////////
			// INSERT / UPDATE SQL発行
			///////////////////////////////////////////////////////////
				
			//既存レコードがなければ INSERT あれば UPDATE
			if( $recode_cnt == 0 ){
				
			////////////////
			// INSERT
			////////////////
				//テーブルロック
				$sql = '';
				$sql .= ' LOCK TABLE ' . "\n";
				$sql .= '            ' . $this->table . " \n";
				$sql .= ' IN exclusive mode ' . "\n";
				//DEBUG時SQL出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
				}
				//SQL実行
				$result = @pg_query( $this->conn , $sql );
				if ( !$result ) {
					$this->php_error = 'db_diff_import(4):' . pg_last_error( $this->conn );
					$this->php_error_sql = $sql;	//<003>
					if( $this->transaction != 'SELF' ){
						$this->dbcom_DbRollback ();
					}
					//DEBUG時エラー出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					//ERROR_DEBUG時 SQL,エラー出力
					if( $this->error_debug == TRUE ){
						echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
				//リソース解放
				pg_free_result( $result );
					
				//ユニークキーチェック
				if( is_array( $this->unique ) && count( $this->unique ) ){
					//ベースSQL生成
					$sql = '';
					$sql .= ' SELECT ' . "\n";
					$sql .= '        count(*) ' . "\n";
					$sql .= '   FROM ' . "\n";
					$sql .= '        ' . $this->table . " \n";
					//WHERE句設定
					$sql_where = '';
					//ユニークキーを条件に設定
					foreach( $this->unique as $column => $val ){
						//WHERE ～ ANDの挿入
						if( $sql_where != '' ){
								$sql_where .= '    AND ';
						}else{
								$sql_where .= '  WHERE ' . "\n";
								$sql_where .= '        ';
						}
						$sql_where .= $column . " = '" . $val . "' \n";
					}
					$sql .= $sql_where;
					
					//DEBUG時SQL出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
					}
					//SQL実行
					$result = @pg_query( $this->conn , $sql );
					if ( !$result ) {
						$this->php_error = 'db_diff_import(5):' . pg_last_error( $this->conn );
						$this->php_error_sql = $sql;	//<003>
						if( $this->transaction != 'SELF' ){
							$this->dbcom_DbRollback ();
						}
						//DEBUG時エラー出力
						if( $this->debug == TRUE ){
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						//ERROR_DEBUG時 SQL,エラー出力
						if( $this->error_debug == TRUE ){
							echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						return (-1);
					}
					
					//変更レコード数の取得
					if ( pg_affected_rows ( $result ) > 0 ) {
						$this->php_error = 'db_diff_import(6):pg_affected_rows ERROR!!!';
						$this->php_error_sql = $sql;	//<003>
						if( $this->transaction != 'SELF' ){
							$this->dbcom_DbRollback ();
						}
						//DEBUG時エラー出力
						if( $this->debug == TRUE ){
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						return (-1);
					}
				
					//件数取得
					$count = pg_fetch_result( $result , 0 , 'count' );
					
					if( $count > 0 ){
						$this->php_error = 'db_diff_import(7):Unique ERROR!!!';
						$this->php_error_sql = $sql;	//<003>
						if( $this->transaction != 'SELF' ){
							$this->dbcom_DbRollback ();
						}
						//DEBUG時エラー出力
						if( $this->debug == TRUE || $this->error_debug == TRUE ){
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						return (-2);
					}
					
					//リソースの解放
					pg_free_result( $result );
				}
				
				
				//INSERT文作成
				$sql = '';
				$sql .= ' INSERT INTO ' . $this->table . "\n";
				$sql .= '           ( ' . "\n";
				
				//INSERT カラム設定
				$cnt = 1;
				foreach( $this->data as $column => $val){
					//最初以外は、カンマを頭に付ける
					if( $cnt == 1 ){
						$sql .= "             " . $column ." \n";
					}else{
						$sql .= "            ," . $column ." \n";
					}
					$cnt++;
				}
				
				$sql .= '           ) ' . "\n";
				$sql .= '      VALUES ' . "\n";
				$sql .= '           ( ' . "\n";
				
				//INSERT データ設定
				$cnt = 1;
				foreach( $this->data as $column => $val){
					//最初以外は、カンマを頭に付ける
					if( $cnt == 1 ){
						if( is_null( $val ) ){
							$sql .= '              NULL ' . "\n";
						}else{
							$sql .= "              '" . $val ."' \n";
						}
					}else{
						if( is_null( $val ) ){
							$sql .= '             ,NULL ' . "\n";
						}else{
							$sql .= "             ,'" . $val ."' \n";
						}
					}
					$cnt++;
				}
				
				$sql .= "           ) \n";
				
				//DEBUG時SQL出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->table . ' INSERT SQL ... [<br>' . $sql . ']</pre><br>';
				}
				
			}else{
			
			////////////////
			// UPDATE
			////////////////
				//  レコードロック
				$sql = '';
				$sql .= ' SELECT ' . "\n";
				$sql .= '        * ' . "\n";
				$sql .= '   FROM ' . "\n";
				$sql .= '        ' . $this->table . " \n";
				//UPDATE WHERE句設定
				$sql_where = '';
				//キーを条件に設定
				foreach( $this->tbl_key as $column => $val ){
					//WHERE ～ ANDの挿入
					if( $sql_where != '' ){
							$sql_where .= '    AND ';
					}else{
							$sql_where .= '  WHERE ' . "\n";
							$sql_where .= '        ';
					}
					$sql_where .= $column . " = '" . $val  . "' \n";
				}
				$sql .= $sql_where;
				$sql .= ' FOR UPDATE ' . "\n";
				
				//DEBUG時SQL出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
				}
				//SQL実行
				$result = @pg_query( $this->conn , $sql );
				if ( !$result ) {
					$this->php_error = 'db_diff_import(8):' . pg_last_error( $this->conn );
					$this->php_error_sql = $sql;	//<003>
					if( $this->transaction != 'SELF' ){
						$this->dbcom_DbRollback ();
					}
					//DEBUG時エラー出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					//ERROR_DEBUG時 SQL,エラー出力
					if( $this->error_debug == TRUE ){
						echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
				//リソース解放
				pg_free_result( $result );
				
				
				//ユニークキーチェック
				if( is_array( $this->unique ) && count( $this->unique ) ){
					//ベースSQL生成
					$sql = '';
					$sql .= ' SELECT ' . "\n";
					$sql .= '        count(*) ' . "\n";
					$sql .= '   FROM ' . "\n";
					$sql .= '        ' . $this->table . " \n";
					//WHERE句設定
					$sql_where = '';
					//ユニークキーを条件に設定
					foreach( $this->unique as $column => $val ){
						//WHERE ～ ANDの挿入
						if( $sql_where != '' ){
								$sql_where .= '    AND ';
						}else{
								$sql_where .= '  WHERE ' . "\n";
								$sql_where .= '        ';
						}
						$sql_where .= $column . " = '" . $val . "' \n";
					}
					//キーから対象データを検索対象外に設定
					foreach( $this->tbl_key as $column => $val ){
						//WHERE ～ ANDの挿入
						if( $sql_where != '' ){
								$sql_where .= '    AND ';
						}else{
								$sql_where .= '  WHERE ' . "\n";
								$sql_where .= '        ';
						}
						$sql_where .= $column . " <> '" . $val . "' \n";
					}
					$sql .= $sql_where;
					
					//DEBUG時SQL出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
					}
					//SQL実行
					$result = @pg_query( $this->conn , $sql );
					if ( !$result ) {
						$this->php_error = 'db_diff_import(9):' . pg_last_error( $this->conn );
						$this->php_error_sql = $sql;	//<003>
						if( $this->transaction != 'SELF' ){
							$this->dbcom_DbRollback ();
						}
						//DEBUG時エラー出力
						if( $this->debug == TRUE ){
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						//ERROR_DEBUG時 SQL,エラー出力
						if( $this->error_debug == TRUE ){
							echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						return (-1);
					}
					
					//変更レコード数の取得
					if ( pg_affected_rows ( $result ) > 0 ) {
						$this->php_error = 'db_diff_import(10):pg_affected_rows ERROR!!!';
						$this->php_error_sql = $sql;	//<003>
						if( $this->transaction != 'SELF' ){
							$this->dbcom_DbRollback ();
						}
						//DEBUG時エラー出力
						if( $this->debug == TRUE ){
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						//ERROR_DEBUG時 SQL,エラー出力
						if( $this->error_debug == TRUE ){
							echo '<pre>' . $this->table . ' UNIQUE CHECK SQL ... [<br>' . $sql . ']</pre><br>';
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						return (-1);
					}
				
					//件数取得
					$count = pg_fetch_result( $result , 0 , 'count' );
					
					if( $count > 0 ){
						$this->php_error = 'db_diff_import(11):UNIQUE ERROR!!!';
						$this->php_error_sql = $sql;	//<003>
						if( $this->transaction != 'SELF' ){
							$this->dbcom_DbRollback ();
						}
						//DEBUG時エラー出力
						if( $this->debug == TRUE || $this->error_debug == TRUE ){
							echo '<pre>' . $this->php_error . '<br /></pre>';
						}
						return (-2);
					}
					
					//リソースの解放
					pg_free_result( $result );
				}
				
				
				//UPDATE文作成
				$sql = '';
				$sql .= ' UPDATE ' . $this->table . "\n";
				$sql .= '    SET ' . "\n";
				
				//UPDATE カラム設定
				$cnt = 1;
				foreach( $this->data as $column => $val){
					
					//最初以外は、カンマを頭に付ける
					if( $cnt == 1 ){
						if( is_null( $val ) ){
							$sql .= '        ' . $column . ' = NULL ' . "\n";
						}else{
							$sql .= '        ' . $column . " = '" . $val . "' \n";
						}
					}else{
						if( is_null( $val ) ){
							$sql .= '       ,' . $column . ' = NULL ' . "\n";
						}else{
							$sql .= '       ,' . $column . " = '" . $val . "' \n";
						}
					}
					$cnt++;
				}
				
				//UPDATE WHERE句設定
				$sql_where = '';
				//キーを条件に設定
				foreach( $this->tbl_key as $column => $val ){
					//WHERE ～ ANDの挿入
					if( $sql_where != '' ){
							$sql_where .= '    AND ';
					}else{
							$sql_where .= '  WHERE ' . "\n";
							$sql_where .= '        ';
					}
					$sql_where .= $column . " = '" . $val  . "' \n";
				}
				$sql .= $sql_where;
				
				//DEBUG時SQL出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->table . ' UPDATE SQL ... [<br>' . $sql . ']</pre><br>';
				}
			}
			
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_diff_import(12):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' UPDATE SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
		 		return (-1);
			}
			
			//変更レコード数の取得
			if ( pg_affected_rows( $result ) != 1 ) {
				$this->php_error = 'db_diff_import(13):pg_affected_rows ERROR!!!';
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' UPDATE SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
		 		return (-1);
			}
			
			//トランザクションコミット
			if( $this->transaction != 'SELF' ){
				$ret = $this->dbcom_DbCommit ();
				IF( $ret == -1 ){
					$this->dbcom_DbRollback ();
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
			 		return (-1);
				}
			}
			
			//リソースの解放
			pg_free_result( $result );
				
 		return (0);
		
	}
	

	//================================================================================================================
	//    一括差分 Import Method
	//================================================================================================================
	function db_batch_diff_import() {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return array(x,y)
	//         x = 0:正常  x = -1:DBエラー
	//         y:件数
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//DB接続ID確認
		if( $this->conn == '' ){
			$this->php_error = 'db_batch_diff_import(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return array(-1,NULL);
		}
		
		//テーブル設定確認
		if( $this->table == '' ){
			$this->php_error = 'db_batch_diff_import(1):Table Name is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return array(-1,NULL);
		}
		
		//キー設定確認
		if( is_array( $this->tbl_key ) && count( $this->tbl_key ) > 0 ){
			foreach( $this->tbl_key as $key => $column ){
				if( $column == '' ){
					$this->php_error = 'db_batch_diff_import(2):tbl_key Column Name is NULL';
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return array(-1,NULL);
				}
			}
		}else{
			$this->php_error = 'db_batch_diff_import(2):tbl_key Setting is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return array(-1,NULL);
		}
		
		//トランザクション開始
		$ret = $this->dbcom_DbBeginTran ();
		if ( $ret == -1 ) {
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return array(-1,NULL);
		}
		
		//////////////////////////
		// テーブルロック
		//////////////////////////
			$sql = '';
			$sql .= ' LOCK TABLE ' . "\n";
			$sql .= '            ' . $this->table . " \n";
			$sql .= ' IN exclusive mode ' . "\n";
			//DEBUG時SQL出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
			}
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_batch_diff_import(5)(' .$row. '):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				$this->dbcom_DbRollback ();
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return array(-1,NULL);
			}
			//リソース解放
			pg_free_result( $result );
			
			
		//////////////////////////
		// 一括差分インポート処理
		//////////////////////////
		
			//データレコードループ
			foreach( $this->data as $row => $val ){
			
			//////////////////////////
			// 既存レコードチェック
			//////////////////////////
				$sql = '';
				$sql .= ' SELECT ' . "\n";
				$sql .= '        count( * ) ' . "\n";
				$sql .= '   FROM ' . $this->table . "\n";
				//WHERE句設定
				$sql_where = '';
				//キーを条件に設定
				foreach( $this->tbl_key as $column => $val ){
					//WHERE ～ ANDの挿入
					if( $sql_where != '' ){
							$sql_where .= '    AND ';
					}else{
							$sql_where .= '  WHERE ' . "\n";
							$sql_where .= '        ';
					}
					$sql_where .= $column . " = '" . $val  . "' \n";
				}
				$sql .= $sql_where;
				
				//DEBUG時SQL出力
				if( $this->debug == true ){
					echo '<hr><pre>' . $this->table . ' CHECK SQL ... [<br>' . $sql . ']</pre><br>';
				}
				
				//SQL実行
				$result = @pg_query( $this->conn , $sql );
				if ( !$result ) {
					$this->php_error = 'db_batch_diff_import(4):' . pg_last_error( $this->conn );
					$this->php_error_sql = $sql;	//<003>
					$this->dbcom_DbRollback ();
					//DEBUG時エラー出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					//ERROR_DEBUG時 SQL,エラー出力
					if( $this->error_debug == TRUE ){
						echo '<pre>' . $this->table . ' CHECK SQL ... [<br>' . $sql . ']</pre><br>';
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return array (-1,NULL);
				}
				
				//件数取得
				$recode_cnt = pg_fetch_result( $result , 0 , 'count' );
				
				//リソース解放
				@pg_free_result( $result );
				
				///////////////////////////////////////////////////////////
				// INSERT / UPDATE SQL発行
				///////////////////////////////////////////////////////////
					
				//既存レコードがなければ INSERT あれば UPDATE
				if( $recode_cnt == 0 ){
					
				////////////////
				// INSERT
				////////////////
					//INSERT文作成
					$sql = '';
					$sql .= ' INSERT INTO ' . $this->table . "\n";
					$sql .= '           ( ' . "\n";
					
					//INSERT カラム設定
					$cnt = 1;
					foreach( $this->data[$row] as $column => $val){
						//最初以外は、カンマを頭に付ける
						if( $cnt == 1 ){
							$sql .= '             ' . $column ." \n";
						}else{
							$sql .= '            ,' . $column ." \n";
						}
						$cnt++;
					}
					
					$sql .= '           ) ' . "\n";
					$sql .= '      VALUES ' . "\n";
					$sql .= '           ( ' . "\n";
					
					//INSERT データ設定
					$cnt = 1;
					foreach( $this->data[$row] as $column => $val){
						//最初以外は、カンマを頭に付ける
						if( $cnt == count( $this->data[$row] )  ){
							if( is_null( $val ) ){
								$sql .= '              NULL ' . "\n";
							}else{
								$sql .= "              '" . $val ."' \n";
							}
						}else{
							if( is_null( $val ) ){
								$sql .= '             ,NULL ' . "\n";
							}else{
								$sql .= "             ,'" . $val ."' \n";
							}
						}
						$cnt++;
					}
					
					$sql .= "           ) \n";
					
					//DEBUG時SQL出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->table . ' INSERT SQL ... [<br>' . $sql . ']</pre><br>';
					}
					
				}else{
				
				////////////////
				// UPDATE
				////////////////
					//UPDATE文作成
					$sql = '';
					$sql .= ' UPDATE ' . $this->table . "\n";
					$sql .= '    SET ' . "\n";
					
					//UPDATE カラム設定
					$cnt = 1;
					foreach( $this->data[$row] as $column => $val){
						
						//最初以外は、カンマを頭に付ける
						if( $cnt == 1 ){
							if( is_null( $val ) ){
								$sql .= '        ' . $column . ' = NULL ' . "\n";
							}else{
								$sql .= '        ' . $column . " = '" . $val . "' \n";
							}
						}else{
							if( is_null( $val ) ){
								$sql .= '       ,' . $column . ' = NULL ' . "\n";
							}else{
								$sql .= '       ,' . $column . " = '" . $val . "' \n";
							}
						}
						$cnt++;
					}
					
					//UPDATE WHERE句設定
					$sql_where = '';
					//キーを条件に設定
					foreach( $this->tbl_key as $column => $val ){
						//WHERE ～ ANDの挿入
						if( $sql_where != '' ){
								$sql_where .= '    AND ';
						}else{
								$sql_where .= '  WHERE ' . "\n";
								$sql_where .= '        ';
						}
						$sql_where .= $column . " = '" . $val  . "' \n";
					}
					$sql .= $sql_where;
					
					//DEBUG時SQL出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->table . ' UPDATE SQL ... [<br>' . $sql . ']</pre><br>';
					}
				}
				
				//SQL実行
				$result = @pg_query( $this->conn , $sql );
				if ( !$result ) {
					$this->php_error = 'db_batch_diff_import(7)(' . $row . '):' . pg_last_error( $this->conn );
					$this->php_error_sql = $sql;	//<003>
					$this->dbcom_DbRollback ();
					//DEBUG時エラー出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					//ERROR_DEBUG時 SQL,エラー出力
					if( $this->error_debug == TRUE ){
						echo '<pre>' . $this->table . ' UPDATE SQL ... [<br>' . $sql . ']</pre><br>';
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return array(-1,NULL);
				}
				
				//変更レコード数の取得
				if ( pg_affected_rows( $result ) != 1 ) {
					$this->php_error = 'db_batch_diff_import(8)(' . $row . '):pg_affected_rows ERROR!!!';
					$this->php_error_sql = $sql;	//<003>
					$this->dbcom_DbRollback ();
					//DEBUG時エラー出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					//ERROR_DEBUG時 SQL,エラー出力
					if( $this->error_debug == TRUE ){
						echo '<pre>' . $this->table . ' UPDATE SQL ... [<br>' . $sql . ']</pre><br>';
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return array(-1,NULL);
				}
				
				//リソースの解放
				pg_free_result( $result );
				
			}
			
		//トランザクションコミット
		$ret = $this->dbcom_DbCommit ();
		IF( $ret == -1 ){
			$this->dbcom_DbRollback ();
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return array(-1,NULL);
		}
		
 		return array( 0, $row );
		
	}
	

	//================================================================================================================
	//    Delete Method
	//================================================================================================================
	function db_delete() {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return x
	//         x = 0:正常  x = -1:DBエラー x = -3:更新差分エラー
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//DB接続ID確認
		if( $this->conn == '' ){
			$this->php_error = 'db_delete(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//テーブル設定確認
		if( $this->table == '' ){
			$this->php_error = 'db_delete(1):Table Name is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//キー設定確認
		if( is_array( $this->tbl_key ) && count( $this->tbl_key ) > 0 ){
			foreach( $this->tbl_key as $key => $column ){
				if( $column == '' ){
					$this->php_error = 'db_delete(2):tbl_key Column Name is NULL';
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
			}
		}else{
			$this->php_error = 'db_delete(2):tbl_key Setting is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//変更予定数確認
		if( $this->tbl_rows == '' ){
			$this->php_error = 'db_deletete(3):tbl_rows Setting is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//トランザクション開始
		if( $this->transaction != 'SELF' ){
			$ret = $this->dbcom_DbBeginTran ();
			if ( $ret == -1 ) {
				//DEBUG時エラー出力
				if( $this->debug == TRUE || $this->error_debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
		}
		
		//テーブルロック
		$sql = '';
		$sql .= ' LOCK TABLE ' . "\n";
		$sql .= '            ' . $this->table . " \n";
		$sql .= ' IN exclusive mode ' . "\n";
		//DEBUG時SQL出力
		if( $this->debug == TRUE ){
			echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
		}
		//SQL実行
		$result = @pg_query( $this->conn , $sql );
		if ( !$result ) {
			$this->php_error = 'db_delete(4):' . pg_last_error( $this->conn );
			$this->php_error_sql = $sql;	//<003>
			if( $this->transaction != 'SELF' ){
				$this->dbcom_DbRollback ();
			}
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' LOCK SQL ... [<br>' . $sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		//リソース解放
		pg_free_result( $result );
		
		//更新前のデータと現在データの比較（変更レコード数が1の場合のみ）	//<004>
		if( $this->tbl_rows == 1 && is_array( $this->diff_data ) && count( $this->diff_data ) ){
			$column = '';
			foreach( $this->diff_data as $column => $value ){
				//最初以外は , を付ける
				if( $check_column != '' ){
					$check_column .= '       ,' . $column . ' ' . "\n";
				}else{
					$check_column .= '        ' . $column . ' ' . "\n";
				}
			}
			//ベースSQL生成
			$sql = '';
			$sql .= ' SELECT ' . "\n";
			$sql .= $check_column;
			$sql .= '   FROM ' . "\n";
			$sql .= '        ' . $this->table . " \n";
			//DELETE WHERE句設定
			$sql_where = '';
			//キーを条件に設定（ $this->tbl_key['all'] == all の場合はWHERE句を発行しない）
			if( $this->tbl_key['all'] != 'all' ){
				foreach( $this->tbl_key as $column => $val ){
					//WHERE ～ ANDの挿入
					if( $sql_where != '' ){
							$sql_where .= '    AND ';
					}else{
							$sql_where .= '  WHERE ' . "\n";
							$sql_where .= '        ';
					}
					$sql_where .= $column . " = '" . $val  . "' \n";
				}
			}
			// WHERE句設定（直接入力）
			if( isset( $this->tbl_key_custom ) && $this->tbl_key_custom != '' ){
				if( $sql_where != '' ){
						$sql_where .= '    AND ';
				}else{
						$sql_where .= '  WHERE ' . "\n";
						$sql_where .= '        ';
				}
				$sql_where .= $this->tbl_key_custom . " \n";
			}
			$sql .= $sql_where;
			
			//DEBUG時SQL出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->table . ' DIFF DATA CHECK SQL ... [<br>' . $sql . ']</pre><br>';
			}
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_delete(5):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' DIFF DATA CHECK SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
			
			//変更レコード数の取得
			if ( pg_affected_rows ( $result ) > 0 ) {
				$this->php_error = 'db_delete(6):pg_affected_rows ERROR!!!';
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' DIFF DATA CHECK SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
			
			//データ比較
			foreach( $this->diff_data as $column => $value ){
				//現在データ
				$now_data = pg_fetch_result( $result , 0 , $column );
				//一致しない場合エラー
				if( $now_data != $value ){
					$this->php_error = 'db_delete(7):DIFF CHECK ERROR!!! before_data(' . $column . ') = ' . $value . ' now_data = ' . $now_data;
					$this->php_error_sql = $sql;	//<003>
					if( $this->transaction != 'SELF' ){
						$this->dbcom_DbRollback ();
					}
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-3);
				}
			}
			//リソースの解放
			pg_free_result( $result );
		}
		
		///////////////////////////////////////////////////////////
		// DELETE SQL発行
		///////////////////////////////////////////////////////////
		
			//DELETE文作成
			$sql = '';
			$sql .= ' DELETE ' . "\n";
			$sql .= '   FROM ' . "\n";
			$sql .= '        ' . $this->table . " \n";
			
			//DELETE WHERE句設定
			$sql_where = '';
			//キーを条件に設定（ $this->tbl_key['all'] == all の場合はWHERE句を発行しない）
			if( $this->tbl_key['all'] != 'all' ){
				foreach( $this->tbl_key as $column => $val ){
					//WHERE ～ ANDの挿入
					if( $sql_where != '' ){
							$sql_where .= '    AND ';
					}else{
							$sql_where .= '  WHERE ' . "\n";
							$sql_where .= '        ';
					}
					$sql_where .= $column . " = '" . $val  . "' \n";
				}
			}
			// WHERE句設定（直接入力）
			if( isset( $this->tbl_key_custom ) && $this->tbl_key_custom != '' ){
				if( $sql_where != '' ){
						$sql_where .= '    AND ';
				}else{
						$sql_where .= '  WHERE ' . "\n";
						$sql_where .= '        ';
				}
				$sql_where .= $this->tbl_key_custom . " \n";
			}
			$sql .= $sql_where;
			
			//DEBUG時SQL出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->table . ' DELETE SQL ... [<br>' . $sql . ']</pre><br>';
			}
			
			//SQL実行
			$result = @pg_query( $this->conn , $sql );
			if ( !$result ) {
				$this->php_error = 'db_delete(8):' . pg_last_error( $this->conn );
				$this->php_error_sql = $sql;	//<003>
				if( $this->transaction != 'SELF' ){
					$this->dbcom_DbRollback ();
				}
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' DELETE SQL ... [<br>' . $sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
			
			//変更レコード数の取得
			if( $this->tbl_rows != 'all' ){
				if ( pg_affected_rows( $result ) != $this->tbl_rows ) {
					$this->php_error = 'db_delete(9):pg_affected_rows ERROR!!! tbl_rows = ' . $this->tbl_rows . '/ affected_rows = ' . pg_affected_rows( $result );
					$this->php_error_sql = $sql;	//<003>
					if( $this->transaction != 'SELF' ){
						$this->dbcom_DbRollback ();
					}
					//DEBUG時エラー出力
					if( $this->debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					//ERROR_DEBUG時 SQL,エラー出力
					if( $this->error_debug == TRUE ){
						echo '<pre>' . $this->table . ' DELETE SQL ... [<br>' . $sql . ']</pre><br>';
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
			}
			
			//トランザクションコミット
			if( $this->transaction != 'SELF' ){
				$ret = $this->dbcom_DbCommit ();
				IF( $ret == -1 ){
					$this->dbcom_DbRollback ();
					//DEBUG時エラー出力
					if( $this->debug == TRUE || $this->error_debug == TRUE ){
						echo '<pre>' . $this->php_error . '<br /></pre>';
					}
					return (-1);
				}
			}
			
			//リソースの解放
			pg_free_result( $result );
			
 		return 0;
	}
	

	//================================================================================================================
	//    Vacuum Method
	//================================================================================================================
	function db_vacuum() {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return x
	//         x = 0:正常  x = -1:DBエラー
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//DB接続ID
		if( $this->conn == '' ){
			$this->php_error = 'db_vacuum(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//テーブル設定確認
		if( $this->table == '' ){
			$this->php_error = 'db_vacuum(1):Table Name is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//////////////////////////
		// バキューム実行
		//////////////////////////
		$sql = '';
		$sql .= ' VACUUM FULL ANALYZE ' . "\n";
		$sql .= '                     ' . $this->table . " \n";
		
		//DEBUG時SQL出力
		if( $this->debug == true ){
			echo '<pre>' . $this->table . ' VACUUM SQL ... [<br>' . $sql . ']</pre><br>';
		}
		
		//SQL実行
		$result = @pg_query( $this->conn , $sql );
		if ( !$result ) {
			$this->php_error = 'db_vacuum(2):' . pg_last_error( $this->conn );
			$this->php_error_sql = $sql;	//<003>
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' VACUUM SQL ... [<br>' . $sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		//リソース解放
		pg_free_result( $result );
		
		return (0);
	}
	

	//================================================================================================================
	//    Cluster Method
	//================================================================================================================
	function db_cluster() {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return x
	//         x = 0:正常  x = -1:DBエラー
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
		//DB接続ID
		if( $this->conn == '' ){
			$this->php_error = 'db_cluster(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//テーブル設定確認
		if( $this->table == '' ){
			$this->php_error = 'db_cluster(1):Table Name is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}

		//////////////////////////
		// クラスタ実行
		//////////////////////////
		$sql = '';
		$sql .= ' CLUSTER ' . "\n";
		$sql .= '         ' . $this->index . " \n";
		$sql .= '      ON  ' . "\n";
		$sql .= '         ' . $this->table . " \n";
		
		//DEBUG時SQL出力
		if( $this->debug == true ){
			echo '<pre>' . $this->table . ' CLUSTER SQL ... [<br>' . $sql . ']</pre><br>';
		}
		
		//SQL実行
		$result = @pg_query( $this->conn , $sql );
		if ( !$result ) {
			$this->php_error = 'db_cluster(2):' . pg_last_error( $this->conn );
			$this->php_error_sql = $sql;	//<003>
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' CLUSTER SQL ... [<br>' . $sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		//リソース解放
		pg_free_result( $result );
		
		return (0);
	}


	//================================================================================================================
	//    Custom SQL Method(データ変更用)
	//================================================================================================================
	//<002>
	function db_custom_sql_change() {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return x
	//         x = 0:正常  x = -1:DBエラー
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
		//DB接続ID
		if( $this->conn == '' ){
			$this->php_error = 'db_custom_sql_change(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//変更予定数確認
		if( $this->tbl_rows == '' ){
			$this->php_error = 'db_custom_sql_change(1):tbl_rows Setting is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//////////////////////////
		// SQL実行
		//////////////////////////
		
		//DEBUG時SQL出力
		if( $this->debug == true ){
			echo '<pre>' . $this->table . ' CUSTOM_CHANGE SQL ... [<br>' . $this->sql . ']</pre><br>';
		}
		
		//SQL実行
		$result = @pg_query( $this->conn , $this->sql );
		if ( !$result ) {
			$this->php_error = 'db_custom_sql_change(2):' . pg_last_error( $this->conn );
			$this->php_error_sql = $this->sql;	//<003>
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' CUSTOM_CHANGE SQL ... [<br>' . $this->sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//変更レコード数の取得
		if( $this->tbl_rows != 'all' ){
			if ( pg_affected_rows( $result ) != $this->tbl_rows ) {
				$this->php_error = 'db_custom_sql_change(3):pg_affected_rows ERROR!!! tbl_rows = ' . $this->tbl_rows . '/ affected_rows = ' . pg_affected_rows( $result );
				$this->php_error_sql = $this->sql;	//<003>
				//DEBUG時エラー出力
				if( $this->debug == TRUE ){
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				//ERROR_DEBUG時 SQL,エラー出力
				if( $this->error_debug == TRUE ){
					echo '<pre>' . $this->table . ' CUSTOM_CHANGE SQL ... [<br>' . $this->sql . ']</pre><br>';
					echo '<pre>' . $this->php_error . '<br /></pre>';
				}
				return (-1);
			}
		}
		
		//リソース解放
		pg_free_result( $result );
		
		return (0);
	}
	
	//================================================================================================================
	//    Custom SQL Method(SELECT用)
	//================================================================================================================
	//<002>
	function db_custom_sql_select() {
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  return x
	//         x = 0:正常  x = -1:DBエラー
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
		//DB接続ID
		if( $this->conn == '' ){
			$this->php_error = 'db_custom_sql_select(0):Connect Resource is NULL';
			//DEBUG時エラー出力
			if( $this->debug == TRUE || $this->error_debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//////////////////////////
		// SQL実行
		//////////////////////////
		
		//DEBUG時SQL出力
		if( $this->debug == true ){
			echo '<pre>' . $this->table . ' CUSTOM_SELECT SQL ... [<br>' . $this->sql . ']</pre><br>';
		}
		
		//SQL実行
		$result = @pg_query( $this->conn , $this->sql );
		if ( !$result ) {
			$this->php_error = 'db_custom_sql_select(1):' . pg_last_error( $this->conn );
			$this->php_error_sql = $this->sql;	//<003>
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' CUSTOM_SELECT SQL ... [<br>' . $this->sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//変更レコード数の取得
		if ( pg_affected_rows( $result ) > 0 ) {
			$this->php_error = 'db_custom_sql_select(2):pg_affected_rows ERROR!!!';
			$this->php_error_sql = $this->sql;	//<003>
			//DEBUG時エラー出力
			if( $this->debug == TRUE ){
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			//ERROR_DEBUG時 SQL,エラー出力
			if( $this->error_debug == TRUE ){
				echo '<pre>' . $this->table . ' CUSTOM_SELECT SQL ... [<br>' . $this->sql . ']</pre><br>';
				echo '<pre>' . $this->php_error . '<br /></pre>';
			}
			return (-1);
		}
		
		//レコード数取得
		$numrows = pg_num_rows( $result );
		$cnt = 0;
		
		//レコード行を配列として取得する（カラム名での連想配列）
		for ( $curpos=0; $curpos < $numrows; $curpos++ ) {
			$arr = @pg_fetch_array( $result , $curpos, PGSQL_ASSOC );
			reset($arr);
			while( list( $key,$val ) = each( $arr ) ){
				$this->data[$curpos][$key] = $val;
			}
			$cnt++;
		}

		
		//リソース解放
		pg_free_result( $result );
		
		return ($cnt);
	}
}
?>