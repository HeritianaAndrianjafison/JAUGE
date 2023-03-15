<?php 

class Tools{


	public static function gkey($key){
		
		$res = md5($key.time());
		return $res;

	}
	/*public static function cond(){
		if(!isset($_SESSION["customer_id"])){
			header("location:home.php");
		}
	}*/
	public static function check($table,$col,$val){
		//$res = DB::select($table,array($col),"$col = '$val'")[0];
		if(count(DB::select($table,array($col),"$col = '$val'"))!=0){
			return true;
		}
		return false;
	}
}

?>
