<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	var $helpers = array('Session', 'Javascript', 'Ajax', 'Html', 'Form', 'Menu');
	var $components = array('DebugKit.Toolbar','Idbroker.LDAPAcl'=>array('groupType'=>'group'), 'Idbroker.LDAPAuth'=>array('homeLanding'=>'/'), 'Session', 'RequestHandler');

        var $user;

        function beforeFilter(){
		global $menus;
                $this->user['User'] = $this->Session->read('User');
                $this->set('user', $this->user);

		$menus['topRightNav'] = array(
			__('Asynonymous',true) => array(
				'url'=>array(
					'controller'=> 'pages',
					'action'=>'view',
					'home'
				),
				'permissions'=>'anonymous'
			),
			__('Sign Up',true) => array(
				'url'=>array(
					'controller'=> 'users',
					'action'=>'signup'
				),
				'options'=>array('onclick'=>"jQuery('#popup').load(this.href).dialog({title: '".__('Sign up',true)."', modal: true, height: 500, width: 500}); return false;"),
				'permissions'=>'anonymous'
			),
			__('Login',true) => array(
				'url'=>array(
					'controller'=> 'users',
					'action'=>'login'
				),
				'options'=>array('onclick'=>"jQuery('#popup').load(this.href).dialog({title: '".__('Login',true)."', modal: true, height: 250, width: 350}); return false;"),
				'permissions'=>'anonymous'
			),
			__('Logout',true) => array(
				'url'=>array(
					'controller'=> 'users',
					'action'=>'logout'
				),
				'permissions'=>'authed'
			),
			__('Help',true) => array(
				'url'=>array(
					'controller'=>'pages',
					'action'=>'view',
					'help'
				),
				'permissions'=>'any',
				'children'=>array(
					__('About',true) => array(
						'url'=>array(
							'controller'=>'pages',
							'action'=>'view',
							'about'
						),
						'permissions'=>'any'
					)
				)
			)
		);

		$menus['Admin'][__('Events',true)] = array( 
			'url'=>array('controller'=>'events','action'=>'index'), 
			'children'=>array(
				__('Create Event',true)=>array(
					'url'=>array(
						'controller'=>'events',
						'action'=>'add',
					),
					'permissions'=>'authed'
				),
				__('List Events',true)=>array(
					'url'=>array(
						'controller'=>'events',
						'action'=>'index'
					),
					'permissions'=>'any'
				)
			)
		);
		$menus['Admin'][__('Pages',true)] = array(
			'url'=>array('controller'=>'pages','action'=>'index'), 
			'children'=>array(
				__('Add Page',true)=>array(
					'url'=>array(
						'controller'=>'pages',
						'action'=>'add',
					),
					'permissions'=>'authed'
				),
				__('My Pages',true)=>array(
					'url'=>array(
						'controller'=>'pages',
						'action'=>'my_pages'
					),
					'permissions'=>'any'
				)
			)
		);
		$menus['Admin'][__('Users & Groups',true)] = array(
			'url'=>array('controller'=>'users','action'=>'me'),
			'children'=>array(
				__('All Users',true)=>array(
					'url'=>array(
						'controller'=>'users',
						'action'=>'add',
					),
					'permissions'=>'admin'
				),
				__('Add Users',true)=>array(
					'url'=>array(
						'controller'=>'users',
						'action'=>'add',
					),
					'permissions'=>'admin'
				),
				__('All Groups',true)=>array(
					'url'=>array(
						'controller'=>'groups',
						'action'=>'index',
					),
					'permissions'=>'admin'
				),
				__('Add Group',true)=>array(
					'url'=>array(
						'controller'=>'groups',
						'action'=>'add',
					),
					'permissions'=>'admin'
				),
				__('My Profile',true)=>array(
					'url'=>array(
						'controller'=>'profile',
						'action'=>'me'
					),
					'permissions'=>'any'
				)
			)
		);
					
					
		$this->set('menus', $menus);
        }
}
