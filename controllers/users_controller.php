<?php
class UsersController extends AppController {

	var $name = 'Users';

        function beforeFilter(){
                $this->LDAPAuth->allow('index','view', 'existsOrCreate');
		if(isset($this->params['action']) && $this->params['action'] != 'existsOrCreate'){
			$user = $this->Session->read('Auth.LdapAuth');
			$userPK = Configure::read('LDAP.User.Identifier');
			if(isset($user[$userPK]) && !empty($user[$userPK]) ){
				$username = $user[$userPK];
				$this->user = $this->requestAction('/users/existsOrCreate/'.$username);
			}
		}
        }

	function existsOrCreate($username=false){
		$user = $this->Session->read('Auth.LdapAuth');
		if(isset($user) && !empty($user) ){
			$username  = ($username) ? $username : $user[$this->User->usernameAttr];
			$results = $this->User->find('first', array('recursive'=>1,'conditions'=>array('username'=>$username)));
			if(isset($results['User']['username'])){
				return $results;//User Exists, return the record and keep going.
			}else{
				$this->User->create(); //User doesn't exists, grab it from the auth session and add it to the user table
				if(isset($user['displayname']) && !empty($user['displayname'])) $u['displayname'] = $user['displayname'];
				if(isset($user['dn']) && !empty($user['dn']) ) $u['dn'] = $user['dn'];
				if(isset($username) && !empty($username) ) $u['username'] = $username;
				if(isset($user['mail']) && !empty($user['mail']) ) $u['email'] = $user['mail'];
			        //so that it will get a id number for the foreign keys
				if($this->User->save($u)){
					$results = $this->User->find('first', array('recursive'=>1,'conditions'=>array('username'=>$username)));
					if (!empty($this->params['requested'])) {
						return $results;
					}else{
						set(compact($results));
					}
				}else{
					return false;
				}
			}
		}
		return false;
	}

	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('The user has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function login(){
		$this->redirect('/idbroker/ldap_auths/login');
	}
	function logout(){
		$this->redirect('/idbroker/ldap_auths/logout');
	}
}
