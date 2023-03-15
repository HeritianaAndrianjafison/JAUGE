<?php

$key ="lnvvlkqhgoiruhtàhjksbdkmqbv;s<,vbkm";

function jovcrypt($string){
	global $key;
	return md5($key.$string);
}


echo jovcrypt("cool");
?>