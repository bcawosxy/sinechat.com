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
			$this->db = $dbname;
		} catch (PDOException $e) {
			echo 'Connection failed: '.$e->getMessage();
	    }
	}

	function column(array $column=null) {
		if ($column) {
			$column = array_filter($column, function($v0) {return $v0 !== null;});
			self::$column = array_merge(self::$column, $column);
		}
		return $this;
	}
	
	function table($table = null) {
		if($table) {
			$this->table = $table;
		}
		
		return $this;
	}

	function fetch($method = 'assoc') {
		$this->sql = 'Select';
		$this->sql .= (self::$column)? ' '.implode(',', array_map('trim', self::$column)) : ' '.$this->table.'.*';
		$this->sql .= ' from '.$this->db.'.'.$this->table;
		if (!empty(self::$join)) $this->sql .= ' '.implode(' ', self::$join);
		if (!empty(self::$where)) $this->sql .= ' where '.implode(' and ', self::$where);
		if (!empty(self::$group)) $this->sql .= ' group by '.implode(',', array_map('trim', self::$group));
		if (!empty(self::$order)) $this->sql .= ' order by '.implode(',', self::$order);
		if (!empty(self::$limit)) $this->sql .= ' limit '.self::$limit;
		if (!empty(self::$lock)) $this->sql .= ' '.self::$lock;

	    $result = $this->pdo->prepare($this->sql);
	    $result->execute(self::$param);
	    $this->data = null;
	    
	    /**
	     *  0324 這邊可能會再加強,不過目前以此fetch方式為主
	     */
	    while($row = $result->fetch($this->fetch_method($method))){
	    	$this->data[] = $row;
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
		if ($limit) self::$limit = str_replace(' ', '', $limit);
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


}

