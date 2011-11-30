<?php
/**
 * LDAP Settings
 *
 */
	$config['LDAP']['Db']['Config'] = 'ldap';
	$config['LDAP']['User']['Identifier'] = 'uid';
	$config['LDAP']['Model'] = 'Idbroker.LdapAuth';
	$config['LDAP']['LdapAuth']['Model'] = 'Idbroker.LdapAuth';
	$config['LDAP']['LdapAuth']['MirrorSQL'] = 'User';
	$config['LDAP']['LdapACL']['Model'] = 'Idbroker.LdapAcl';
	$config['LDAP']['LdapACL']['groupType'] = 'group';
?>
