<?php
/*
Plugin Name: Domain-Change
Plugin URI: http://www.webtoolol.com/
Version: 1.1
Author: Soz
Author URI: http://www.webtoolol.com/
Description: This plugin is for who changed their wordpress blog from one domain to another domain. Including the 301 redirect and replace your old domain into the new domain, you will enjoy this plugin if you want to change your domain.
*/

if(!class_exists('DomainChange')){
	class DomainChange{

		/* The options in the database, like below

		domainChangeArray = array(
			'newDomain' => 'www.example.com',
			'isRedirect'=> true
		);

		*/
		var $currentOptionsArray = 'domainChangeArray';
		var $defaultDomainChangeArray = array(
			'newDomain' => '',
			'isRedirect'=> false
		);


		function directDomain(){
			$devDomainChangeArray = get_option($this->currentOptionsArray);
			if(empty($devDomainChangeArray)){
				add_option($this->currentOptionsArray, $this->defaultDomainChangeArray);
				$devDomainChangeArray = $this->defaultDomainChangeArray;
			}elseif($devDomainChangeArray['isRedirect'] === true and '' != $devDomainChangeArray['newDomain']){
							// invoke the redirect event
							if( strtolower($_SERVER['SERVER_NAME']) != strtolower($devDomainChangeArray['newDomain'])){
								$URIRedirect = $_SERVER['REQUEST_URI'];
									if( strtolower($URIRedirect == '/index.php')){
										$URIRedirect = '/';
									}
								header('HTTP/1.1 301 Moved Permanently');
								header('Location:http://'. $devDomainChangeArray['newDomain'] . $URIRedirect);
								exit();
							}
					}				
			
		}


		// register the option pag vars
		//function register_mysettings() { // whitelist options
		//	register_setting( 'changeDomain', 'newDomain' );
		//	register_setting( 'changeDomain', 'isRedirect' );
		//}

		
		// add the admin setting link, but the options page function is not include in this class.
		function adminMenu(){
			add_options_page('Domain Change Setting', 'Domain Change', 8, 'domain-change/options.php');
			//add_options_page('Domain Change Setting', 'Domain Change', 8, __FILE__, array($this,'options'));
		}

		function options(){
			
		}


				
	}//end of DomainChange class define

}

if(!isset($domainChange)){
	$domainChange = new DomainChange();
	add_action('send_headers',array(&$domainChange,'directDomain'));
	
	//Add the admin setting
	add_action('admin_menu',array(&$domainChange,'adminMenu'));

	//add_action( 'admin_init', array(&$domainChange,'register_mysettings') );

}


?>