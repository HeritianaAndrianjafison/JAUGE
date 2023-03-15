<?php

class DB{


	public function __construct (){
		global $dbname;
			

	}

	public static function q($sql){
		global $connection;
			$result = $connection->query($sql);
			return $result;
	}
	public static function qs($sql){
		global $connection;
		$res = array();
		$result = $connection->query($sql);

			if ($result->num_rows > 0) {
    				
   				 while($row = $result->fetch_assoc()) {
        			$res[] = $row;
    									}
			}
		return $res;
	}
	public static function select($table,$col,$condition = 1){
		global $connection;
		$res = array();
		$sql = "select ";
		$i = false;
		foreach($col as $c){
			if(!$i){
				$sql .=$c;
				$i = true;
			}else{

				$sql .=",".$c;
			}
			 
		}
		$sql .=" from $table where $condition"; 
//echo $sql;
		$result = $connection->query($sql);

			if ($result->num_rows > 0) {
    				// output data of each row
   				 while($row = $result->fetch_assoc()) {
        			$res[] = $row;
    									}
			}
			//echo $sql;
		return $res;
	}
	
	public static function update($table,$col,$val,$condition = 1){
		global $connection;
		$n = count($col);
		$sql = "update $table set ";
		$j = false;
		for($i = 0;$i<$n;$i++){
			
			if(!$j){
				$sql .=" ".$col[$i]."='".addslashes($val[$i])."'";
				$j = true;

			}else{

				$sql .=" ,".$col[$i]."='".addslashes($val[$i])."'";
			}
		}
		$sql.=" where ".$condition;
//echo $sql;
		$result = $connection->query($sql);
	}
	public static function delete($table,$condition = 1){
		global $connection;
		$sql = "delete from $table where $condition";

		$result = $connection->query($sql);
	}
	public static function insert($table,$col,$val){
		global $connection;
		$sql = "insert into $table (";

		$i = false; 

		foreach($col as $c){
			if(!$i){
				$sql .=$c;
				$i = true;
			}else{

				$sql .=",".$c;
			}
			 
		}

		$sql .=") values (";

		$j = false; 

		foreach($val as $v){
			if(!$j){
				$sql .="'".addslashes($v)."'";
				$j = true;
			}else{

				$sql .=","."'".addslashes($v)."'";
			}
			 
		}

		$sql.=")";
		//echo $sql.";";
		$result = $connection->query($sql);

	}
	public static function describe($table){
	$sql = "DESCRIBE $table";
	global $connection;
	$result = $connection->query($sql);

			if ($result->num_rows > 0) {
    				// output data of each row
   				 while($row = $result->fetch_assoc()) {
        			$res[] = $row;
    									}
			}
		return $res;
	}
}











































?>
