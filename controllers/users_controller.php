<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array('IDBroker.User');

        function beforeFilter(){
                $this->LDAPAuth->allow('signup','login','logout');
                if($this->RequestHandler->isAjax()){
                    Configure::write('debug', 0);// and forget debug messages
                    $this->layout = 'ajax'; //or try with $this->layout = '';
                }
                parent::beforeFilter();
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

	function admin_logout(){
		$this->logout();
	}
	function admin_login(){
		$this->login();
	}
	function login(){
		$this->redirect('/idbroker/ldap_auths/login');
	}
	function logout(){
                $this->log("Destroying session",'debug');
                $this->Session->destroy();
		$this->redirect('/');
	}
	
	function signup(){
		$user = $this->Session->read('Auth');
		if(isset($user['User']['id'])){
			$this->redirect(array('controller'=>'users', 'action' => 'dashboard'));
		}

                if(!empty($this->data)){
                        $this->data['User']['objectclass'] = array('top', 'organizationalperson', 'inetorgperson','person','posixaccount','shadowaccount');

			if(empty($this->data['User']['sn']) || empty($this->data['User']['givenname']) ){
				$this->Session->setFlash(__("Must give a first and last name",true),'error_msg');
                        }elseif($this->data['User']['password'] == $this->data['User']['password_confirm']){
                                $this->data['User']['userpassword'] = $this->data['User']['password'];
                                unset($this->data['User']['password']);
                                unset($this->data['User']['password_confirm']);

                                if(!isset($this->data['User']['homedirectory'])&& isset($this->data['User']['uid'])){
                                        $this->data['User']['homedirectory'] = '/home/'.$this->data['User']['uid'];
                                }

                                $cn = $this->data['User']['cn'];
                                if ($this->User->save($this->data)) {
                                        $this->Session->setFlash($cn.' was added Successfully.');
                                        $id = $this->User->id;
                                        $this->redirect(array('action' => 'view', 'id'=> $id));
                                }else{
                                        $this->Session->setFlash("$cn couldn't be created.");
                                }
                        }else{
                                $this->Session->setFlash("Passwords don't match.");
                        }
                }
	}

	function usernameExists($username = null){
		if($username ==null) return false;
		
	}

	function dashboard(){
                $this->layout = 'dashboard';
                $this->User->recursive = 0;
                $this->set('users', $this->paginate());
	}
}
