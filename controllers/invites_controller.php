<?php
class InvitesController extends AppController {

	var $name = 'Invites';
	var $components = array('Email');

        function beforeFilter(){
                $this->LDAPAuth->allow('index','view');
                $user = $this->Session->read('Auth.LdapAuth');
                $userPK = Configure::read('LDAP.User.Identifier');
                if(isset($user[$userPK]) && !empty($user[$userPK]) ){
                        $username = $user[$userPK];
                        $this->user = $this->requestAction('/users/existsOrCreate/'.$username);
                        $this->set('user', $this->user);
                }
        }

	function index() {
		$this->Invite->recursive = 0;
		$this->set('invites', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid invite', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('invite', $this->Invite->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Invite->create();
			if ($this->Invite->save($this->data)) {
				$this->Session->setFlash(__('The invite has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invite could not be saved. Please, try again.', true));
			}
		}
		$events = $this->Invite->Event->find('list');
		$this->set(compact('events'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid invite', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Invite->save($this->data)) {
				$this->Session->setFlash(__('The invite has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invite could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Invite->read(null, $id);
		}
		$events = $this->Invite->Event->find('list');
		$this->set(compact('events'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for invite', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Invite->delete($id)) {
			$this->Session->setFlash(__('Invite deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Invite was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->log("Current User is:".print_r($this->user,1),'debug');
		$this->Invite->recursive = 0;
			
		$this->set('invites', $this->paginate("Invite", array('Event.user_id'=>$this->user['User']['id'])));
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid invite', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('invite', $this->Invite->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Invite->create();
			if ($this->Invite->save($this->data)) {
				$this->Session->setFlash(__('The invite has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invite could not be saved. Please, try again.', true));
			}
		}
		$events = $this->Invite->Event->find('list');
		$this->set(compact('events'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid invite', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Invite->save($this->data)) {
				$this->Session->setFlash(__('The invite has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The invite could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Invite->read(null, $id);
		}
		$events = $this->Invite->Event->find('list');
		$this->set(compact('events'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for invite', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Invite->delete($id)) {
			$this->Session->setFlash(__('Invite deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Invite was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function sendInvite($id = null){
		$this->log("Calling sendInvite",'debug');
		if($id == null) return false;
		$invitee = $this->Invite->read(null,$id);
		$this->log("Sending Email:".print_r($invitee,1),'debug');
		$this->Email->delivery = 'smtp';
		$this->Email->to = $invitee['Invite']['email'];
		$this->Email->subject = $invitee['Event']['name'];
		$this->Email->from = $invitee['User']['email'];
		
		//Change the following to a configure var
		$this->Email->replyTo = 'no-reply@asynonymous.net';

		//Change this to use templates for var interpolation
		$this->set('content', $invitee['User']['details']);
		$this->set('uuid', $invitee['User']['uuid']);
		$this->Email->send();
			
		//Update Status
		$invitee['Invite']['sent'] = 'yes';
		$this->Invite->save($invitee);
		return true;
	}
}
