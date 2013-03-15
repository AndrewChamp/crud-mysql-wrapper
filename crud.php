<?php

/**
 * The MIT License (MIT)
 * Copyright (c) 2013 Andrew Champ | https://plus.google.com/106274972321613013294/about
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial 
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT 
 * LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
 * NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

class crud{
	
	private static $instance;
	
	private $server;
	private $user;
	private $password;
	private $database;
	private $dbh;
	
	
	public function __construct($_server=null, $_user=null, $_password=null, $_database=null){
		if($_server == null || $_user == null || $_password == null || $_database == null):
			print 'Please input database credentials';
		else:
			$this->server = $_server;
			$this->user = $_user;
			$this->password = $_password;
			$this->database = $_database;
			$this->connect();
		endif;
	}
		
		
	public static function obtain($_server=null, $_user=null, $_password=null, $_database=null){
		if(!self::$instance):
			self::$instance = new crud($_server, $_user, $_password, $_database); 
		endif;
		return self::$instance; 
	}
		
		
	public function connect(){
		$this->dbh = new PDO("mysql:host=".$this->server.";dbname=".$this->database, $this->user, $this->password);
		$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
		
		
	public function query($sql){
		$statement = $this->dbh->prepare($sql);
		$statement->execute();
		$result = $statement->fetchAll();
		return $result;
	}
	
	
	public function read($table, $where=null, $order=null, $limit=null){
		$statement = $this->dbh->prepare("SELECT * FROM `".$table."` ".($where != null ? "WHERE ".$where : '')." ".($order != null ? "ORDER BY ".$order : '')." ".($limit != null ? "LIMIT ".$limit : ''));
		$statement->execute();
		$result = $statement->fetchAll();
		return $result;
	}
	
	
	public function update($table, $data, $where='1'){
		$q = "UPDATE `$table` SET ";
		foreach($data as $key=>$val):
			if(strtolower($val) == 'null'):
				$q .= "`$key` = NULL, ";
			elseif(strtolower($val) == 'now()'):
				$q .= "`$key` = NOW(), ";
			elseif(preg_match("/^increment\((\-?\d+)\)$/i", $val, $m)):
				$q .= "`$key` = `$key` + $m[1], "; 
			else:
				$q .= "`$key`='".$val."', ";
			endif;
		endforeach;
		$q = rtrim($q, ', ') . ' WHERE '.$where.';';
		
		$statement = $this->dbh->prepare($q);
		$statement->execute();
	}
		
	
	public function insert($table, $data){
		$q = "INSERT INTO `$table` ";
		$v = ''; $n = '';
		foreach($data as $key=>$val):
			$n .= "`$key`, ";
			if(strtolower($val) == 'null'):
				$v .= "NULL, ";
			elseif(strtolower($val) == 'now()'):
				$v .= "NOW(), ";
			else: 
				$v .= "'".$val."', ";
			endif;
		endforeach;
		$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

		$statement = $this->dbh->prepare($q);
		$statement->execute();
	}
		
		
	public function delete($table, $data){
		$statement = $this->dbh->prepare("DELETE FROM `".$table."` WHERE ".$data);
		$statement->execute();
	}
	
}

?>
