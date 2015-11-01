<?php
require_once ("md5_encryption.php");
require_once 'Encryption.class.php'; 
//---------------------------- Encrypt/Decrypt Function -------------------------------------
function encrypt($data)
{
	$crypt = new Encryption; 
	$key = "bttbbttb";
	$pswdlen = floor(strlen($data)*1.35);
	$crypt->setAdjustment(1/75); 
	$crypt->setModulus(3); 
	$result =  $crypt->encrypt($key, $data, $pswdlen);
	//var_dump($crypt->errors);
	return $result;
}
function decrypt($data)
{
	$crypt = new Encryption; 
	$key = "bttbbttb";
	$crypt->setAdjustment(1/75); 
	$crypt->setModulus(3); 
	$result =  $crypt->decrypt($key, $data);
	//var_dump($crypt->errors);
	return $result;
}
function pEncrypt($data)
{
	return encrypt($data);
}
function pDecrypt($data)
{
	return decrypt($data);
}
?>