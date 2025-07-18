<?php 

function is_user($user_role , $roles) {
	$default = ['admin','root','worker'];

	if(empty($user_role)){
		return false;
	}
	
	if(!is_array($roles)){
		array_push($default, $roles);
		return in_array($user_role, $default);
	}

	$roles = array_merge($default, $roles);
	return in_array($user_role, $roles);
}

function is_admin($user_role) {
	if (empty($user_role)) {
		return false;
	}

	if($user_role == 'admin' || $user_role == 'root'){
		return true;
	}

	return false;
}

function is_root($user_role) {
	if (empty($user_role)) {
		return false;
	}

	if($user_role == 'root'){
		return true;
	}

	return false;
}

function is_worker($user_role) {
	if (empty($user_role)) {
		return false;
  }
  
	return in_array($user_role, ['admin','root','worker']);
}