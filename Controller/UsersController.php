<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses = array('IDBroker.User');


        function beforeFilter(){
                $this->Auth->allow('usernameExists', 'forgotPassword', 'signup','login','logout');
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
			$this->Session->setFlash(__('Invalid user'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->request->data)) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid user'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->User->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for user'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
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
		$this->redirect('/idbroker/ldap_auths/logout');
	}
	
	function signup(){
		$user = $this->Session->read('Auth');
		if(isset($user['User']['id'])){
			$this->redirect(array('controller'=>'users', 'action' => 'dashboard'));
		}

                if (!empty($this->request->data)) {
			if($this->request->data['User']['password'] != $this->request->data['User']['password_confirm']){
				$this->Session->setFlash(__("Passwords don't match."),'error_msg');
				return false;
			}elseif(isset($this->request->data['User']['username']) && $this->usernameExists($this->request->data['User']['username']) ){
				$this->Session->setFlash(__("Username already taken!"),'error_msg');
				return false;
			}else{
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					do_action('create_user',$this->request->data['User']);
					$this->Session->setFlash(__('Your account has been created, Please check your email for your account activation.'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
				}
			}
                }

	}

	function usernameExists($username = null){
		if($username ==null) return false;
		$users = $this->User->find('first',array('conditions'=>array('User.username'=>$username)));
		if(isset($users) && !empty($users)){
			set('users',$users);
			return $users;
		}else{
			$result = false;
			$result = apply_filters('lookup_usernameExists',$username,$result);
			set('users',$result);
			return $result;
		}
	}

	function dashboard(){
                $this->layout = 'dashboard';
                $this->User->recursive = 0;
                $this->set('users', $this->paginate());
	}
}
