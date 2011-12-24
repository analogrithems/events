<?php
Configure::write('debug', 3);

/**
 * CakePHP Log Level:
 *
 * In case of Production Mode CakePHP gives you the possibility to continue logging errors.
 *
 * The following parameters can be used:
 *  Boolean: Set true/false to activate/deactivate logging
 *    Configure::write('log', true);
 *
 *  Integer: Use built-in PHP constants to set the error level (see error_reporting)
 *    Configure::write('log', E_ERROR | E_WARNING);
 *    Configure::write('log', E_ALL ^ E_NOTICE);
 */
	Configure::write('log', true);

/**
 * Application wide charset encoding
 */
	Configure::write('App.encoding', 'UTF-8');

/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below:
 */
	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));

/**
 * Uncomment the define below to use CakePHP prefix routes.
 *
 * The value of the define determines the names of the routes
 * and their associated controller actions:
 *
 * Set to an array of prefixes you want to use in your application. Use for
 * admin or other prefixed routes.
 *
 * 	Routing.prefixes = array('admin', 'manager');
 *
 * Enables:
 *	`admin_index()` and `/admin/controller/index`
 *	`manager_index()` and `/manager/controller/index`
 *
 * [Note Routing.admin is deprecated in 1.3.  Use Routing.prefixes instead]
 */
	Configure::write('Routing.prefixes', array('admin'));

/**
 * Turn off all caching application-wide.
 *
 */
	//Configure::write('Cache.disable', true);

/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * var $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting var $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
	//Configure::write('Cache.check', true);

/**
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
	define('LOG_ERROR', 2);

/**
 * The preferred session handling method. Valid values:
 *
 * 'php'	 		Uses settings defined in your php.ini.
 * 'cake'		Saves session files in CakePHP's /tmp directory.
 * 'database'	Uses CakePHP's database sessions.
 *
 * To define a custom session handler, save it at /app/config/<name>.php.
 * Set the value of 'Session.save' to <name> to utilize it in CakePHP.
 *
 * To use database sessions, run the app/config/schema/sessions.php schema using
 * the cake shell command: cake schema create Sessions
 *
 */
	Configure::write('Session.save', 'php');

/**
 * The model name to be used for the session model.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 *
 * The model name set here should *not* be used elsewhere in your application.
 */
	//Configure::write('Session.model', 'Session');

/**
 * The name of the table used to store CakePHP database sessions.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 *
 * The table name set here should *not* include any table prefix defined elsewhere.
 *
 * Please note that if you set a value for Session.model (above), any value set for
 * Session.table will be ignored.
 *
 * [Note: Session.table is deprecated as of CakePHP 1.3]
 */
	//Configure::write('Session.table', 'cake_sessions');

/**
 * The DATABASE_CONFIG::$var to use for database session handling.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 */
	//Configure::write('Session.database', 'default');

/**
 * The name of CakePHP's session cookie.
 *
 * Note the guidelines for Session names states: "The session name references
 * the session id in cookies and URLs. It should contain only alphanumeric
 * characters."
 * @link http://php.net/session_name
 */
	Configure::write('Session.cookie', 'CAKEPHP');

/**
 * Session time out time (in seconds).
 * Actual value depends on 'Security.level' setting.
 */
	Configure::write('Session.timeout', '120');

/**
 * If set to false, sessions are not automatically started.
 */
	Configure::write('Session.start', true);

/**
 * When set to false, HTTP_USER_AGENT will not be checked
 * in the session. You might want to set the value to false, when dealing with
 * older versions of IE, Chrome Frame or certain web-browsing devices and AJAX
 */
	Configure::write('Session.checkAgent', true);

/**
 * The level of CakePHP security. The session timeout time defined
 * in 'Session.timeout' is multiplied according to the settings here.
 * Valid values:
 *
 * 'high'   Session timeout in 'Session.timeout' x 10
 * 'medium' Session timeout in 'Session.timeout' x 100
 * 'low'    Session timeout in 'Session.timeout' x 300
 *
 * CakePHP session IDs are also regenerated between requests if
 * 'Security.level' is set to 'high'.
 */
	Configure::write('Security.level', 'medium');

/**
 * A random string used in security hashing methods.
 */
	Configure::write('Security.salt', 'cbd15191c24bf4915a2d101ebcf6dd1ad55a4d21');

/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
	Configure::write('Security.cipherSeed', '373832356261333131303938623865');

/**
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a querystring parameter containing the time the file was modified. This is
 * useful for invalidating browser caches.
 *
 * Set to `true` to apply timestamps, when debug = 0, or set to 'force' to always enable
 * timestamping.
 */
	//Configure::write('Asset.timestamp', true);
/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
	//Configure::write('Asset.filter.css', 'css.php');

/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');

/**
 * The classname and database used in CakePHP's
 * access control lists.
 */
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');

/**
 * If you are on PHP 5.3 uncomment this line and correct your server timezone
 * to fix the date & time related errors.
 */
	//date_default_timezone_set('UTC');

	Cache::config('default', array('engine' => 'File'));

//Ldap Config
Configure::load('ldap');
Configure::write('Usage', 'Private'); //Private or Public.  If Public anyone can singup and send events, if Private only your created users can send.
Configure::write('Email.Format', 'html'); //Should Email invites be sent in html or text?
Configure::write('Events.URL', 'http://vault.asynonymous.net/events'); //Should Email invites be sent in html or text?
