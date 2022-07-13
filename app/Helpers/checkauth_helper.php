<?php 
use Config\Services;


function IsloggedIn()
{
	$session = Services::session();
	$user = $session->get('user') ?? null ;
	if($user AND $user['isLoggedIn']){
		return true;
	} else {
		return false;
	}
}

?>