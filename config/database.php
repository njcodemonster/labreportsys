<?php
	class Database extends db_connection{
		
		private static $_dbManagerInstance;
		private        $_dbConnectionInstance;
		public         $_func                = "nameParams";
		private        $_statement_number    = 0;
		private        $_debug			     = true;
		private        $_last_query		     = "";
		
		protected      $_production_mode     = false;
	    private        $_error_message       = "We are currently experiencing technical difficulties.";
	    private        $_errors_email        = 'majid.7ctech@gmail.com';
	
	    private        $_dbtype              = "mysql";
	    protected      $_port                = 3306; // default port for MySQL
		
		/* PDO constants options: http://php.net/manual/en/pdo.constants.php */
  		protected      $_db_params           = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true);
		// increase performance by creating a persistent connection
		
		
		//Make class object if not
		public static function getManager(){
			if(null === self::$_dbManagerInstance)
				self::$_dbManagerInstance = new database();
			return self::$_dbManagerInstance;
		}
		
		public function __construct(){

			if(!$this->_dbConnectionInstance) {
	
				try	{
				
					$this->_dbConnectionInstance =  new PDO($this->_dbtype.':host='.$this->_host.';port='.$this->_port.';dbname='.$this->_db_name, $this->_db_user, $this->_db_password, $this->_db_params);
					
					if ($this->_production_mode === true) {
						$this->_dbConnectionInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
					} else {
					   $this->_dbConnectionInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				   }
				
					//$this->_dbConnectionInstance->beginTransaction();
	
				 } catch (PDOException $e) {
				
					//$this->_dbConnectionInstance->rollback();
					$this->_dbConnectionInstance = null;
				
				
				/* error message output */           
					if ($this->_production_mode === true) {
					   //file_put_contents('database_errors.log', $e->getMessage(), FILE_APPEND); // log the errors     
					   //$this->email_errors($e->getMessage()); // email errors to me
					   die($this->_error_message);
					} else {			
					   die($e->getMessage());
				   		//return $e->getMessage();
					}
				
				} // end try
				
			} // end if(!$this->_dbConnectionInstance)
			
			return $this->_dbConnectionInstance;
			
		}
	
		public function __destruct(){
		   $this->_dbConnectionInstance = null;
		}
		
		/*********************************** // END Connection Methods ***********************************/
		 
		/*********************************** Custom Query ***********************************/
		public function custom_query($sql){
			
			
			return $stmt = $this->query($sql);
   			//$stmt->fetchAll(PDO::FETCH_ASSOC); 
		}
		
		public function query($sql, $values = NULL, $rowsAffected = true, $fetchResults = true, $lastID = false){

			//echo $sql;
			$stmt = $this->queryExecute($sql, $values);
			$data = array();	
			
			$data['num_rows'] = $stmt->rowCount();
			
                        if($lastID) { $data['last_id'] = $this->_dbConnectionInstance->lastInsertId();}
			
                        if($fetchResults){$data['rows'] = $stmt->fetchAll(PDO::FETCH_OBJ);}

			return $data;
		}
		
		/*********************************** Query Methods ***********************************/
		
		public function select($table, $columns, $where_equals = false, $order_by = false, $limit = false) {
			
			if(is_array($columns) && !empty($columns))
				$sql = "SELECT ".implode(", ", array_values($columns))." FROM $table";
			elseif($columns == '*')
				$sql = "SELECT * FROM $table";
			else
				die('Invalid Columns');
			
			if(is_array($where_equals) && !empty($where_equals))
		  		$sql_where = $this->whereEquals($sql, $where_equals);
			else
				$sql_where = $sql;
				
			if(is_array($order_by) && !empty($order_by))
				$sql_order = $this->orderBy($order_by);
			else
				$sql_order = "";
			
			if($limit)
				$limit = "LIMIT " . $limit;
			else
				$limit = "";
			
			if(is_array($where_equals) && !empty($where_equals))
				return $this->query($sql_where[0]." $sql_order $limit", $sql_where[1]);
			else
				return $this->query($sql_where." $sql_order $limit");
		}
		
		public function insert($table, $values, $lastID = false){

			$data_array = array();
			foreach ($values as $k => $v) {
				if ($v != null) { $data_array[$k] = $v; }
			}
	
			$cols = $this->namedColumns($data_array);
			$vals = $this->namedValues($data_array);
			
			$sql = " INSERT INTO $table ( $cols ) values ( $vals ) ";
	
			return $this->query($sql, $data_array, true, false, $lastID);
		}
		
		public function update($table, $new_values, $where_equals) {

			$sql = "UPDATE $table SET";
			$where = array();
			foreach ($new_values as $f => $v) {
				$sql .= " $f=?,";
				$where[] = $v;
			}
			$sql = rtrim($sql, ",");
			
			$sql_where = $this->whereEquals($sql, $where_equals);
			foreach ($sql_where[1] as $value) {
				 $where[] = $value;
			}
		  
		 	return $this->query($sql_where[0], $where, true, false);
		}
		
		public function delete($table, $where_equals) {

			$sql_where = $this->whereEquals("DELETE FROM $table", $where_equals);
			return $this->query($sql_where[0], $sql_where[1], true, false);
		}
		
		/******************************* END Query Methods ****************************/
		
		
		/************* helper functions used in query methods ****************/
		
		private function whereEquals($sql, $where_condition) {

			$p = 0;
			$count = count($where_condition);
			$values = array();
			
			foreach ($where_condition as $k => $v) {
				$p++;
				$sql .= ($p == 1) ? " WHERE " : "";
				$sql .= "$k = ?";
				$sql .= ($p >= 1) && ($p < $count) ? " AND " : "";
				$values[] = $v; // append where id value to values array
			}
			
			$sql_where = array($sql, $values);
			return $sql_where;
	   
	   }
	   
	   private function orderBy($order_by){

		 foreach ($order_by as $k => $v){
		 	$sql = "ORDER BY $k $v";	
		 }
		  
		 return $sql;
	   }
		
		private function namedColumns($data_array) {
			return $insert_columns = implode(", ", array_keys($data_array));
		}
	
		function nameParams($n){ 
			return ":".$n; 
		}
	
		private function namedValues($data_array) {
			return $insert_values = implode( ", ", array_map( array($this, $this->_func), array_keys($data_array)) );
		}
		
		private function queryExecute($prepare, $execute){
		   	$statement_name = 'statement'.$this->_statement_number;
         	$this->_statement_number++;
		 	
			try {
				$this->_last_query = $prepare;
				
				${$statement_name} = $this->_dbConnectionInstance->prepare($prepare);
			   
				if ($this->_statement_number != 1) 
					${$statement_name}->closeCursor();
			   
				${$statement_name}->execute($execute);
				
				return ${$statement_name};
		   		${$statement_name} = null;
				
			}catch(PDOException $ex) {
				$output = $ex->getMessage();
				if ($this->_debug)
					$output .= "<br><br>Last Query: " . $this->_last_query;
	
				die($output);
       		}
		}
		
		public function email_errors($errors) {
			$to            = $this->_errors_email;
			$subject       = "You screwed up again!";
			$message_body  = $errors;
			$headers       = "From: contact@tariqalidev.com";
			//"CC: somebodyelse@example.com";
	
			mail($to,$subject,$message_body,$headers);
		}
		
		/************* // END helper functions used in query methods ****************/
	
	} //End Database Class
	
	
	/******************************* Call Functions ***************************
	
	/**
     * Database Query Function
     *
     * @access  public
     * @param   string  Any Database Query or Stored Procedure
     * @param   array   An array of query parameters
     * @param   boolean Set to FALSE to stop result_set
     * @return  array   If $rowsAffected TRUE, returns num_rows and If $fetchResults TRUE, returns result_set, otherwise return empty array
     **/
	 
	 /**
     * Database Custom Query
     *
     * $result  = database::getManager()->query("SELECT * FROM tableName");
     * $result  = database::getManager()->query("SELECT * FROM tableName WHERE id = ?", array(3));
     * $result  = database::getManager()->query("SELECT * FROM tableName WHERE id = ?", array(3));
     * $result  = database::getManager()->query("INSERT INTO tableName(title, name) VALUES (:title, :name)", array('title' => 'tariq', 'name' => 'ali'), false); False for stop fetch_results
     * $result  = database::getManager()->query("UPDATE tableName SET title = ?, name = ? WHERE id = ?", array('tariq','ali',2), false); False for stop fetch_results
	 * $result  = database::getManager()->query("DELETE FROM tableName WHERE id = ?", array(2), false);
	 * $result  = database::getManager()->query("CALL sp_Patterns(:id)", array(":id" => 1), false); //Stored Procedure
     **/
	 
	 /**
     * Database Methods Query 
     *
     * $result = database::getManager()->select("tableName", '*', array('name' => 'ali'), array('id' => 'ASC')); (Table, columns, where, order)
	 * $result = database::getManager()->select("tableName", '*', false, array('id' => 'ASC')); (Table, columns, where, order)
	 * $result = database::getManager()->select("tableName", array('name', 'title'), false, array('id' => 'ASC')); (Table, columns, where, order)
     * $result = database::getManager()->insert("tableName", array('title' => 'tariq', 'name' => 'ali')); (Table, values)
	 * $result = database::getManager()->insert("tableName", array('title' => 'tariq', 'name' => 'ali'), true); (Table, values, last_id)
     * $result = database::getManager()->update("tableName", array('title' => 'Tariq'), array('id' => 3)); (Table, new_values, where)
     * $result = database::getManager()->delete("tableName", array('id' => 3)); (Table, where)
     **/

?>