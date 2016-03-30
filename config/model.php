<?php
class Model {
	protected static $db;
	protected static $pdo;
	protected static $sql;
	protected static $table;
	protected static $data = array();
	protected static $method;

	protected static $column = [];
	protected static $join = [];
	protected static $where = [];
	protected static $group = [];
	protected static $having = [];
	protected static $order = [];
	protected static $param = [];
	protected static $limit;
	protected static $lock;

	function __construct($dbhost, $dbuser, $dbpass, $dbname, $param) {
		$dsn = 'mysql:dbname='.$dbname.';host='.$dbhost;
		try {
			$this->pdo = new PDO($dsn, $dbuser, $dbpass, $param);
			$this->pdo->exec("SET NAMES utf8;");
			$this->db = $dbname;
		} catch (PDOException $e) {
			echo 'Connection failed: '.$e->getMessage();
	    }
	}

	function __destruct() { 
		if (!empty(self::$where)) self::$where = '';
		if (!empty(self::$column)) self::$column = '';
		if (!empty(self::$join)) self::$join = '';
		if (!empty(self::$group)) self::$group = '';
		if (!empty(self::$having)) self::$having = '';
		if (!empty(self::$order)) self::$order = '';
		if (!empty(self::$param)) self::$param = '';
		if (!empty(self::$limit)) self::$limit = '';
		if (!empty(self::$lock)) self::$lock = '';
	}

	function add(array $param) {
		if (empty($param)) throw new Exception('Parameters error');
		
		$this->pdo->exec($this->add_logic($param));
		$id = (int)$this->pdo->lastInsertId();//沒有 AUTO_INCREMENT 的話，會得到 0
		return $id? $id : true;
	}
	
	function add_logic(array $param, $replace=false) {
		$a_column = [];
		$s_value = null;
		switch (array_depth($param)) {
			case 1:
				$a_column = array_keys($param);
				$s_value = '('.implode(',', array_map( [$this,'quote'] ,$param) ).')';
				break;
	
			case 2:
				$a_column = array_keys(reset($param));
				$a_value = [];
				foreach ($param as $v0) {
					$a_value[] = '('.implode(',', array_map([$this, 'quote'], $v0)).')';
				}
				$s_value = implode(',', $a_value);
				break;
	
			default:
				throw new Exception('Unknown case');
				break;
		}
		$sql = 'Insert into '.$this->db.'.'.$this->table.' ('.implode(',', array_map([$this, 'quote_column'], $a_column)).') values '.$s_value;
		if ($replace) {
			$tmp0 = [];
			foreach ($a_column as $v0) {
				$tmp0[] = $v0.'=values('.$v0.')';
			}
			$sql .= ' on duplicate key update '.implode(',', $tmp0);
		}
		
		return $sql;
	}

	function column(array $column=null) {
		if ($column) {
			$column = array_filter($column, function($v0) {return $v0 !== null;});
			self::$column = array_merge(self::$column, $column);
		}
		return $this;
	}
	
	function delete() {
		$sql = 'Delete from '.$this->db.'.'.$this->table;
		if (!empty(self::$where)) $sql .= ' where '.implode(' and ', self::$where);
		$this->pdo->exec($sql);

		return true;
	}

	function edit(array $param) {
		if (empty($param)) throw new Exception('Parameters error');
		
		$tmp0 = [];
		foreach ($param as $k0 => $v0) {
			$tmp0[] = '`'.$k0.'`'.'='.$this->pdo->quote($v0);
		}
		$this->sql = 'Update '.$this->db.'.'.$this->table.' set '.implode(',', $tmp0);
		
		if (!empty(self::$where)) $this->sql .= ' where '.implode(' and ', self::$where);
// echo $this->sql;
		$result = $this->pdo->exec($this->sql);
		return $result;
	}

	function table($table = null) {
		//被function.php呼叫,故不可棄用
		if($table) {
			$this->table = $table;
		}
		return $this;
	}

	function fetchAll($method = 'assoc') {
		return $this->fetch_logic(__FUNCTION__, $method);
	}

	function fetch($method = 'assoc') {
		return $this->fetch_logic(__FUNCTION__, $method);
	}

	function fetch_logic($fetch_case, $method) {
		$this->sql = 'Select';
		$this->sql .= (self::$column)? ' '.implode(',', array_map('trim', self::$column)) : ' '.$this->table.'.*';
		$this->sql .= ' From '.$this->db.'.'.$this->table;
		if (!empty(self::$join)) $this->sql .= ' '.implode(' ', self::$join);
		if (!empty(self::$where)) $this->sql .= ' where '.implode(' and ', self::$where);
		if (!empty(self::$group)) $this->sql .= ' group by '.implode(',', array_map('trim', self::$group));
		if (!empty(self::$order)) $this->sql .= ' order by '.implode(',', self::$order);
		if (!empty(self::$limit)) $this->sql .= ' limit '.self::$limit;
		if (!empty(self::$lock)) $this->sql .= ' '.self::$lock;
		
		if($method=='debug') {
			//display sql code for debug
			$method = 'assoc';
			echo '['.$this->sql.']<br>';
	    }

	    $result = $this->pdo->prepare($this->sql);
	    $result->execute(self::$param);	    
	    $this->data = null;
	    
	    /**
	     *  0325 加上fetchAll,並把case移出處理
	     *  0324 這邊可能會再加強,不過目前以此fetch方式為主
	     */
	    while($row = $result->$fetch_case($this->fetch_method($method))){
	    	$this->data = $row;
	    }
		return $this->data;
		
	}

	private function fetch_method($method = null) {
		/**
		  * PDO::FETCH_ASSOC
		  * PDO::FETCH_NUM
		  * PDO::FETCH_BOTH
	 	  * PDO::FETCH_OBJ
		  */
		if($method) {
			switch ($method) {
				case 'both':
					$this->method = PDO::FETCH_BOTH;
					break;
				case 'num':
					$this->method = PDO::FETCH_NUM;
					break;
				case 'obj':
					$this->method = PDO::FETCH_OBJ;
					break;

				default:
					$this->method = PDO::FETCH_ASSOC;
					break;
			}
		}
		return $this->method;
	}

	function group(array $group=null) {
		if ($group) {
			$group = array_filter($group, function($v0) {return $v0 !== null;});
			self::$group = array_merge(self::$group, $group);
		}
		return $this;
	}	

	function join(array $join=null) {
		if ($join) {
			foreach ($join as $v1) {
				list($join_case, $join_table, $join_condition) = $v1;
				self::$join[] = strtolower(trim($join_case)).' '.$this->db.'.'.trim($join_table).' '.trim($join_condition);
			}
		}
		return $this;
	}
	
	function limit($limit=null) {
		if ($limit) {
			self::$limit = str_replace(' ', '', $limit);
		}
		return $this;
	}
	
	function order(array $order=null) {
		if ($order) {
			foreach ($order as $k1 => $v1) {
				self::$order[] = trim($k1).' '.strtolower(trim($v1));
			}
		}
		return $this;
	}

	function param(array $param = null) {
		if($param){
			foreach ($param as $k1 => $v1) {
				self::$param[trim($k1)] = strtolower(trim($v1));
			}
		}
		return $this;
	}

	function where(array $where=null) {
		if ($where) {
			foreach ($where as $v1) {
				list($filters, $logic) = $v1;
				$tmp2 = [];
				foreach ($filters as $v2) {
					list($field, $operator, $value) = $v2;
					$field = trim($field);
					switch (strtolower(trim($operator))) {
						case '=':
						case '!=':
						case '>=':
						case '>':
						case '<=':
						case '<':
						case 'like':
							$tmp2[] = $field." ".$operator." ".$value;
							break;
								
						case 'between':
							$tmp2[] = $field." ".$operator." ".$value[0]." and ".$value[1];
							break;
								
						// case 'in':
						// case 'not in':
						// 	foreach ($value as $k3 => $v3) {
						// 		if ($v3 === null) unset($value[$k3]);//^是否 null 要視為正常
						// 	}
						// 	if (!empty($value)) {
						// 		$tmp2[] = $field." ".$operator." (".implode(',', array_map(array(self::$database_instance[$this->database], 'quote'), array_unique($value))).")";
						// 	}
						// 	break;
								
						default:
							throw new Exception('Unknown case of where\'s operator');
							break;
					}
				}
				
				if (count($tmp2) > 1) {
					switch ($logic) {
						case 'and':
							self::$where[] = implode(' '.$logic.' ', $tmp2);
							break;
								
						case 'or':
							self::$where[] = '('.implode(' '.$logic.' ', $tmp2).')';
							break;
								
						default:
							throw new Exception('Unknown case of where\'s logic');
							break;
					}
				} else {
					self::$where[] = $tmp2[0];
				}
			}
		}
		return $this;
	}

	function quote($var, $param=null) {
		if ($var === null) {
			$return = "''";//目前欄位皆設置為 not null，故以空字串返回；但往後仍應考慮處理 null 的狀況
		} else {
			$return = is_string($var)? $this->pdo->quote($var) : $var;
		}
		
		return $return;
	}

	function quote_column($var, $param=null) {
		if ($var === null) {
			$return = "''";//目前欄位皆設置為 not null，故以空字串返回；但往後仍應考慮處理 null 的狀況
		} else {
			$return = is_string($var)? '`'.$var.'`' : $var;
		}
		
		return $return;
	}
}

