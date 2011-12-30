<?php
App::uses('Controller', 'Controller');
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
	var $helpers = array('Session', 'Js' => array('Jquery'), 'Html', 'Form', 'Menu');
	var $components = array('DebugKit.Toolbar','Auth', 'Session', 'RequestHandler');

        var $user;

        function beforeFilter(){
		global $menus;
		$this->Auth->authenticate = array(
			'Idbroker.LDAP', // Manualy define the ldap auth until the trigger/hook is setup
		);

		$user = $this->Auth->user();
		$this->log("Auth user:".print_r($user,true),'debug');

                $this->user = $user;
                $this->set('user', $this->user);

		$menus['topRightNav'] = array(
			__('Asynonymous') => array(
				'url'=>array(
					'controller'=> 'pages',
					'action'=>'view',
					'home'
				),
				'permissions'=>'anonymous'
			),
			__('Sign Up') => array(
				'url'=>array(
					'controller'=> 'users',
					'action'=>'signup'
				),
				'options'=>array('onclick'=>"jQuery('#popup').load(this.href).dialog({title: '".__('Sign up')."', modal: true, height: 400, width: 450}); return false;"),
				'permissions'=>'anonymous'
			),
			__('Login') => array(
				'url'=>array(
					'controller'=> 'users',
					'action'=>'login'
				),
				'options'=>array('onclick'=>"jQuery('#popup').load(this.href).dialog({title: '".__('Login')."', modal: true, height: 250, width: 350}); return false;"),
				'permissions'=>'anonymous'
			),
			__('Logout') => array(
				'url'=>array(
					'controller'=> 'users',
					'action'=>'logout'
				),
				'permissions'=>'authed'
			),
			__('Help') => array(
				'url'=>array(
					'controller'=>'pages',
					'action'=>'view',
					'help'
				),
				'permissions'=>'any',
				'children'=>array(
					__('About') => array(
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

		$menus['Admin'][__('Events')] = array( 
			'url'=>array('controller'=>'events','action'=>'index'), 
			'children'=>array(
				__('Create Event')=>array(
					'url'=>array(
						'controller'=>'events',
						'action'=>'add',
					),
					'permissions'=>'authed'
				),
				__('List Events')=>array(
					'url'=>array(
						'controller'=>'events',
						'action'=>'index'
					),
					'permissions'=>'any'
				)
			)
		);
		$menus['Admin'][__('Pages')] = array(
			'url'=>array('controller'=>'pages','action'=>'index'), 
			'children'=>array(
				__('Add Page')=>array(
					'url'=>array(
						'controller'=>'pages',
						'action'=>'add',
					),
					'permissions'=>'authed'
				),
				__('My Pages')=>array(
					'url'=>array(
						'controller'=>'pages',
						'action'=>'my_pages'
					),
					'permissions'=>'any'
				)
			)
		);
		$menus['Admin'][__('Users & Groups')] = array(
			'url'=>array('controller'=>'users','action'=>'me'),
			'children'=>array(
				__('All Users')=>array(
					'url'=>array(
						'controller'=>'users',
						'action'=>'add',
					),
					'permissions'=>'admin'
				),
				__('Add Users')=>array(
					'url'=>array(
						'controller'=>'users',
						'action'=>'add',
					),
					'permissions'=>'admin'
				),
				__('All Groups')=>array(
					'url'=>array(
						'controller'=>'groups',
						'action'=>'index',
					),
					'permissions'=>'admin'
				),
				__('Add Group')=>array(
					'url'=>array(
						'controller'=>'groups',
						'action'=>'add',
					),
					'permissions'=>'admin'
				),
				__('My Profile')=>array(
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

	public function beforeRender() {
		$user = $this->Auth->user();
		$this->set(compact('user'));
	}

	public function isAuthorized(){
		$groups = $this->LDAPAcl->getGroups();
	}
}
