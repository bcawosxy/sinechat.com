<?php 
class Model {
	public $db;
	public $pdo;
	public $sql;
	protected static $where = [];


	function __construct($dbhost, $dbuser, $dbpass, $dbname, $param) {
		$dsn = 'mysql:dbname='.$dbname.';host='.$dbhost;
		try {
			$this->pdo = new PDO($dsn, $dbuser, $dbpass, $param);
		} catch (PDOException $e) {
			echo 'Connection failed: '.$e->getMessage();
	    }
	}

	function db($db) {
		$this->db = $db;
		return $this;
	}

	function fetch($method = PDO::FETCH_ASSOC) {
		
		$this->sql = 'select * from '.$this->db.' where '.implode(' and ', self::$where);
		

		return $this->sql;
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
							$tmp2[] = $field." ".$operator." ".$this->db;
							break;
								
						// case 'between':
						// 	$tmp2[] = $field." ".$operator." ".self::$database_instance[$this->database]->quote($value[0])." and ".self::$database_instance[$this->database]->quote($value[1]);
						// 	break;
								
						// case 'in':
						// case 'not in':
						// 	foreach ($value as $k3 => $v3) {
						// 		if ($v3 === null) unset($value[$k3]);//^是否 null 要視為正常
						// 	}
						// 	if (!empty($value)) {
						// 		$tmp2[] = $field." ".$operator." (".implode(',', array_map(array(self::$database_instance[$this->database], 'quote'), array_unique($value))).")";
						// 	}
						// 	break;
								
						// default:
						// 	throw new Exception('Unknown case of where\'s operator');
						// 	break;
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

