<?php
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'events',
		'password' => 'dsh828w7ywgfdo2q8xhyfef6yhawxerFDS12',
		'database' => 'events',
	);

	public $ldap = array (
			'datasource' => 'Idbroker.LdapSource',
			'host' => 'localhost',
			'port' => 389,
			'basedn' => 'DC=asynonymous,DC=net',
			'login' => 'CN=Manager,DC=asynonymous,DC=net',     //For Proxy Userdn
			'password' => 'Hsf638BH#df.5ekid',  //For Proxy UserDN password
			'database' => '',
			'tls'         => false,
			'type' => 'OpenLDAP', //Available types are 'OpenLDAP', 'ActiveDirectory', 'Netscape'
			'version' => 3
	);
}
?>
