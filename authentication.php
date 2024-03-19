<?php	
	if( ! defined( 'ACCESS' ) ) die( 'DIRECT ACCESS NOT ALLOWED' );

	/* 
	NOTE:
	ONLY SET THESE IF YOU WANT TO ALLOW AUTHENTICATION 
	IF NOT THEN JUST COMMENT THEM OUT 
	*/

	// table columns found in your 'users' table
	define( 'AUTH_ID', 'id' );
	define( 'AUTH_NAME', 'username' );
	define( 'AUTH_TYPE', 'usertype' );
	define( 'AUTH_TOKEN', 'token' );

	// default page to login, name of the file found in /pages
	define( 'LOGIN_REDIRECT', 'login' ); 

	/*
		TO USE:
			To add restricted pages, just uncomment the variable $restricted_pages,
			each array elements are page names found in your pages folder.
			When added, these pages will not be accessible unless the SESSION AUTH_ID
			is assigned with a value.
	*/

	$restricted_pages[ 'Admin' ]['access'] = [ "admin-page", "dashboard", "consumers", "billing", "updatestat", "add-consumer", "edit-consumer", "consumption", "data", "bill-print", "bill-generate"];
	$restricted_pages[ 'Admin' ][ 'default_page' ] = "dashboard";

	/*
	$restricted_pages[ 'user' ]['access'] = [ "user-page" ];
	$restricted_pages[ 'user' ][ 'default_page' ] = "default";
	*/
	$restricted_pages[ 'default' ]['access'] = [ "login",];
	$restricted_pages[ 'default' ][ 'default_page' ] = "login"; 

	has_access( true );
